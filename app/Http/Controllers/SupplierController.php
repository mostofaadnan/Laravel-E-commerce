<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\city;
use App\Models\state;
use App\Models\Country;
use App\Models\Category;
use App\Models\supplier;
use App\Models\RequrimentFile;
use App\Models\MultiselectCategory;
use App\Models\SupplierDebt;
use App\Models\SupplierDocument;
use App\Models\purchase;
use App\Models\purchasedetails;
use App\Models\PurchaseReturn;
use App\Models\SupplierPayment;
use App\Models\PurchaseRecieved;
use Image;
use File;
use DataTables;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:supplier-list|supplier-create|supplier-edit|supplier-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:supplier-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:supplier-edit', ['only' => ['edit', 'update', 'Active', 'Inactive']]);
        $this->middleware('permission:supplier-delete', ['only' => ['destroy']]);
        $this->middleware('permission:mail-list', ['only' => ['SendMail',]]);
    }
    public function index()
    {
        return view('supplier.index');
    }
    public function LoadAll()
    {
        $Supplier = supplier::orderBy('id', 'desc')
            ->whereIn('status', [0, 1])
            ->latest()
            ->get();
        return Datatables::of($Supplier)
            ->addIndexColumn()
            ->addColumn('openingBalance', function ($Supplier) {
                $openingBalance = $Supplier->SupplierDebt()->sum('openingBalance');
                return  number_format((float)$openingBalance, 2, '.', '');
            })
            ->addColumn('consignment', function ($Supplier) {
                $consignment = $Supplier->SupplierDebt()->sum('consignment');
                return  number_format((float)$consignment, 2, '.', '');
            })
            ->addColumn('totaldiscount', function ($Supplier) {
                $totaldiscount = $Supplier->SupplierDebt()->sum('totaldiscount');
                return number_format((float)$totaldiscount, 2, '.', '');
            })
            ->addColumn('payment', function ($Supplier) {
                $payment = $Supplier->SupplierDebt()->sum('payment');
                return number_format((float)$payment, 2, '.', '');
            })
            ->addColumn('balancedue', function ($Supplier) {

                $consignment = $Supplier->SupplierDebt()->sum('consignment');
                $discount = $Supplier->SupplierDebt()->sum('totaldiscount');
                $netConsignment = ($consignment - $discount);
                $payment = $Supplier->SupplierDebt()->sum('payment');
                $balancedue = $netConsignment - $payment;
                return number_format((float)$balancedue, 2, '.', '');
            })
            ->addColumn('status', function ($Supplier) {
                return $Supplier->status == 1 ?  'Active' : 'Inactive';
            })
            ->addColumn('user', function (Supplier $Supplier) {
            
                return $Supplier->username ? $Supplier->username->name : 'Deleted User';
              
            })


            ->addColumn('action', function ($Supplier) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $Supplier->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="dataedit" data-id="' . $Supplier->id . '">Edit</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $Supplier->id . '">Delete</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="documentup" data-id="' . $Supplier->id . '">Document Upload</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="openingbalance" data-id="' . $Supplier->id . '">Balance Summery</a>';
                $button .= '<div class="dropdown-divider"></div>';
                if ($Supplier->status == 1) {
                    $button .= '<a class="dropdown-item" id="inactive" data-id="' . $Supplier->id . '"><span class="badge badge-danger">In-Active</span></a>';
                } else {
                    $button .= '<a class="dropdown-item" id="active" data-id="' . $Supplier->id . '"><span class="badge badge-success">Active</span></a>';
                }

                $button .= '</div></div>';
                return $button;
            })
            ->make(true);
    }
    public function GetList()
    {
        $supliers = supplier::orderBy("id", 'asc')->get();
        return response()->json($supliers);
    }
    public function SupplierDatalist(Request $request)
    {
        if ($request->ajax()) {
            $supliers = supplier::select('id', 'name')
                ->orderBy("id", 'asc')
                ->where('status',1)
                ->get();
            return view('datalist.supplierdatalist', compact('supliers'))->render();
        }
    }
    public function getData()
    {
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $countrys = Country::orderBy('name', 'asc')->get();
        $categoryis = Category::orderBy('title', 'asc')->get();
        return view('supplier.create', compact('countrys', 'categoryis'));
    }
    public function getStateList(Request $request)
    {
        $states = state::orderBy('name', 'asc')
            ->where("country_id", $request->country_id)
            ->pluck("name", "id");
        return response()->json($states);
    }

    public function getCityList(Request $request)
    {
        $cities = city::orderBy('name', 'asc')
            ->where("state_id", $request->state_id)
            ->pluck("name", "id");
        return response()->json($cities);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = $request->validate([
            'sup_name' => 'required',
            'address' => 'required|max:255',
            'state_id' => 'required|numeric',
            'country_id' => 'required|numeric',
            'postalcode' => 'nullable|numeric',
            'email' => 'email:rfc,dns'

        ]);
        $inputdate = date('Y-m-d', strtotime($request->openingdate));
        $supplier = new supplier;
        $supplier->name = $request->sup_name;
        $supplier->address = $request->address;
        $supplier->country_id = $request->country_id;
        $supplier->state_id = $request->state_id;
        $supplier->city_id = $request->city_id;
        $supplier->postalcode = $request->postalcode;
        $supplier->TIN = $request->TIN;
        $supplier->status = $request->status;
        $supplier->mobile_no = $request->mobile_no;
        $supplier->tell_no = $request->tell_no;
        $supplier->fax_no = $request->fax_no;
        $supplier->email = $request->supemail;
        $supplier->website = $request->website;
        $supplier->openingDate = $inputdate;
        $supplier->description = $request->description;
        $supplier->user_id = Auth::id();
        /*  single image insert   */
        if ($request->hasFile('supplier_image')) {
            $image = $request->File('supplier_image');
            $img = time() . $image->getClientOriginalExtension();
            $location = storage_path('app/public/supplier/' . $img);
            Image::make($image)->save($location);
            $supplier->image = $img;
        }
        if ($supplier->save()) {
            $multicategory = $request->category;
            if (!is_null($multicategory)) {
                foreach ($multicategory as $mcat) {
                    $multycate = new MultiselectCategory();
                    $multycate->category_id = $mcat;
                    $multycate->type = "Supplier";
                    $multycate->parent_id = $supplier->id;
                    $multycate->save();
                }
            }
            Session()->flash('success', 'supplier has insert successfully');
            return redirect()->Route('supplier.create');
        }
    }
    public function Active($id)
    {
        $supplier = supplier::find($id);
        $supplier->status = 1;
        $ststusActive = $supplier->update();
        return response()->json($ststusActive);
    }
    public function Inactive($id)
    {
        $supplier = supplier::find($id);
        $supplier->status = 0;
        $ststusinactive = $supplier->update();
        return response()->json($ststusinactive);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function OpeningBalance($id)
    {
        $supplier = supplier::select('id', 'name')->where('id', $id)->first();
        return view('supplier.openingBalance', compact('supplier'));
    }
    public function GetOpening(Request $request)
    {
        if ($request->ajax()) {
            $opening = SupplierDebt::where('supplier_id', $request->supplierid)
                ->where('remark', 'Opening Balance')
                ->first();
            if (!is_null($opening)) {
                $data['openingbalance'] = $opening->openingBalance;
                $data['consignment'] = $opening->consignment;
                $data['totaldiscount'] = $opening->totaldiscount;
                $data['payment'] = $opening->payment;
                $data['id'] = $opening->id;
            } else {
                $data['openingbalance'] = 0.00;
                $data['consignment'] = 0.00;
                $data['totaldiscount'] = 0.00;
                $data['payment'] = 0.00;
                $data['id'] = 0;
            }
            return  response()->json($data);
        }
    }

    public function StoreOpening(Request $request)
    {
        if ($request->balanceid > 0) {
            $CustomerDebts = SupplierDebt::find($request->supplier_id);
        } else {
            $CustomerDebts = new SupplierDebt();
        }
        $CustomerDebts->supplier_id = $request->supplier_id;
        $CustomerDebts->openingBalance = $request->balancedue;
        $CustomerDebts->consignment = $request->consignment;
        $CustomerDebts->totaldiscount = $request->totaldiscount;
        $CustomerDebts->returnamount = 0;
        $CustomerDebts->payment = $request->payment;
        $CustomerDebts->remark = 'Opening Balance';
        $CustomerDebts->trn_id = 1;
        $CustomerDebts->save();
        Session()->flash('success', 'Supplier Balance has insert successfully');
        return redirect()->Route('suppliers');
    }
    public function BalanceLoadAll(Request $request)
    {
        $SupplierDebt = SupplierDebt::orderBy('id', 'desc')
            ->where('supplier_id', $request->supplierid)
            ->get();
        return Datatables::of($SupplierDebt)
            ->addIndexColumn()

            ->addColumn('inputdate', function ($SupplierDebt) {
                $fromdate = date('d/m/Y', strtotime($SupplierDebt->created_at));
                return  $fromdate;
            })
            ->make(true);
    }
    public function profile()
    {
        return view('supplier.view');
    }
    public function show($id)
    {

        return view('supplier.view');
    }

    public function SupplierInfo(Request $request)
    {
        if ($request->ajax()) {
            $supplier = supplier::with('CategoryName', 'CategoryName.CateName', 'CountryName', 'StateName', 'CityName', 'SupplierDocument')->find($request->supplierid);
            $supplierDebd = SupplierDebt::where('supplier_id', $request->supplierid)->get();
            $openingbalance = number_format((float) $supplierDebd->sum('openingBalance'), 2, '.', '');
            $consignment = number_format((float)  $supplierDebd->sum('consignment'), 2, '.', '');
            $discount = number_format((float)   $supplierDebd->sum('totaldiscount'), 2, '.', '');
            $netConsignment = ($consignment - $discount);
            $payment = $supplierDebd->sum('payment');
            $balancedue = $netConsignment - $payment;
            $balnaceduecon = number_format((float)$balancedue, 2, '.', '');
            $response = [
                'supplier' => $supplier,
                'openingbalance' => $openingbalance,
                'consignment' => $consignment,
                'discount' => $discount,
                'payment' => $payment,
                'balancedue' => $balnaceduecon,

            ];
            return  response()->json($response);
        }
    }
    public function search(Request $request)
    {
        $data = $request->search;
        $supplier = supplier::query()
            ->where('id', 'LIKE', "%{$data}%")
            ->orWhere('name', 'LIKE', "%{$data}%")
            ->orWhere('address', 'LIKE', "%{$data}%")
            ->orWhere('postalcode', 'LIKE', "%{$data}%")
            ->orWhere('email', 'LIKE', "%{$data}%")
            ->orWhere('mobile_no', 'LIKE', "%{$data}%")
            ->orWhere('tell_no', 'LIKE', "%{$data}%")
            ->orWhere('TIN', 'LIKE', "%{$data}%")
            ->orWhere('website', 'LIKE', "%{$data}%")
            ->orderBy("id", 'asc')
            ->get();

        return response()->json($supplier);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $supplierDebd = SupplierDebt::where('supplier_id', $id)
            ->get();
        $openingbalance = $supplierDebd->sum('openingBalance');
        $consignment = $supplierDebd->sum('consignment');
        $discount = $supplierDebd->sum('totaldiscount');
        $netConsignment = ($consignment - $discount);
        $payment = $supplierDebd->sum('payment');
        $balancedue = $openingbalance + ($netConsignment - $payment);
        $countrys = Country::orderBy('name', 'asc')->get();
        $categoryis = Category::orderBy('title', 'asc')->get();
        $supplier = supplier::orderBy('id', 'asc')->find($id);
        return view('supplier.edit', compact('supplier', 'countrys', 'categoryis', 'openingbalance', 'consignment', 'discount', 'payment', 'balancedue'));
    }
    public function Document($id)
    {

        $supplier = supplier::select('id', 'name')->where('id', $id)->first();
        return view('supplier.partials.documentUpload', compact('supplier'));
    }
    public function DocumentUpload(Request $request)
    {

        $request->validate([
            'supplier_image' => 'required | mimes:jpeg,jpg,png | max:1000',
            'type' => 'required',
        ]);
        if ($request->hasFile('supplier_image')) {
            $SupplierDocument = new SupplierDocument();
            $SupplierDocument->supplier_id = $request->id;
            $SupplierDocument->type = $request->type;
            $SupplierDocument->remark = $request->remark;
            $image = $request->File('supplier_image');
            $img = time() . $image->getClientOriginalExtension();
            $location = storage_path('app/public/supplier/SupplierDoucument/' . $img);
            Image::make($image)->save($location);
            $SupplierDocument->image = $img;
            $SupplierDocument->save();
        }
        Session()->flash('success', 'supplier Document has insert successfully');
        return redirect()->Route('suppliers');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = $request->validate([
            'sup_name' => 'required',
            'address' => 'required|max:255',
            'state_id' => 'required|numeric',
            'country_id' => 'required|numeric',
            'postalcode' => 'nullable|numeric',
        ]);
        $dataid = $request->supid;
        $supplier = supplier::find($dataid);
        $supplier->name = $request->sup_name;
        $supplier->address = $request->address;
        $supplier->country_id = $request->country_id;
        $supplier->state_id = $request->state_id;
        $supplier->city_id = $request->city_id;
        $supplier->postalcode = $request->postalcode;
        $supplier->TIN = $request->TIN;
        $supplier->status = $request->status;
        $supplier->mobile_no = $request->mobile_no;
        $supplier->tell_no = $request->tell_no;
        $supplier->fax_no = $request->fax_no;
        $supplier->email = $request->supemail;
        $supplier->website = $request->website;
        $supplier->openingDate = $request->openingdate;
        /*  single image update   */
        if ($request->hasFile('supplier_image')) {
            if (File::exists('storage/app/public/supplier/' . $supplier->image)) {
                File::delete('storage/app/public/supplier/' . $supplier->image);
            }
            $image = $request->File('supplier_image');
            $img = time() . $image->getClientOriginalExtension();
            $location = storage_path('app/public/supplier/' . $img);
            Image::make($image)->save($location);
            $supplier->image = $img;
        }
        $supplier->update();
        $multicategory = $request->category;
        if (!is_null($multicategory)) {
            $matchThese = [
                'parent_id' => $dataid,
                'type' => 'Supplier',
            ];
            $multicategoryDelete = MultiselectCategory::where($matchThese)->get();
            foreach ($multicategoryDelete as $mdelete) {
                $mdelete->delete();
            }

            foreach ($multicategory as $mcat) {
                $multycate = new MultiselectCategory();
                $multycate->category_id = $mcat;
                $multycate->type = "Supplier";
                $multycate->parent_id = $supplier->id;
                $multycate->save();
            }
        }
        //openig balance Update
        $supplierdept = SupplierDebt::where('supplier_id', $request->supid)
            ->where('remark', 'openingbalance')
            ->first();
        if (!is_null($supplierdept)) {
            SupplierDebt::where('supplier_id', $request->supid)
                ->where('remark', 'openingbalance')
                ->update(array(
                    'openingBalance' => $request->openingbalance,
                ));
        }
        Session()->flash('success', 'supplier has update successfully');
        return redirect()->Route('suppliers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $supplier = supplier::find($id);
        if (!is_null($supplier)) {
            if (purchasedetails::where('supplier_id', '=', $id)->exists() || purchase::where('supplier_id', '=', $id)->exists() || PurchaseReturn::where('supplier_id', '=', $id)->exists() || SupplierPayment::where('supplier_id', '=', $id)->exists()) {
                $supplier->status = 2;
                $supplier->update();
            } else {
                $SupplierDebt = SupplierDebt::where('supplier_id', $id)->get();
                if (!is_null($SupplierDebt)) {
                    foreach ($SupplierDebt as $pd) {
                        $pd->delete();
                    }
                }
                if (File::exists('storage/app/public/supplier/' . $supplier->image)) {
                    File::delete('storage/app/public/supplier/' . $supplier->image);
                }
                $matchThese = [
                    'parent_id' => $id,
                    'type' => 'Supplier',
                ];
                $multicategoryDelete = MultiselectCategory::where($matchThese)->get();
                if (!is_null($multicategoryDelete)) {
                    foreach ($multicategoryDelete as $mdelete) {
                        $mdelete->delete();
                    }
                }
                $dumentsDelete = SupplierDocument::where('supplier_id', $id)->get();
                if (!is_null($dumentsDelete)) {
                    foreach ($dumentsDelete as $rdelete) {
                        if (File::exists('storage/app/public/supplier/SupplierDoucument/' . $rdelete->image)) {
                            File::delete('storage/app/public/supplier/SupplierDoucument/' . $rdelete->image);
                        }
                        $rdelete->delete();
                    }
                }
                $supplier->delete();
            }
        }
    }
    public function GetAmounthistory($id)
    {
        $supplierDebd = SupplierDebt::where('supplier_id', $id)
            ->get();

        if (!is_null($supplierDebd)) {
            $consignment = $supplierDebd->sum('consignment');
            $discount = $supplierDebd->sum('totaldiscount');
            $netConsignment = ($consignment - $discount);
            $payment = $supplierDebd->sum('payment');
        } else {
            $consignment = 0.00;
            $discount = 0.00;
            $netConsignment = 0.00;
            $payment = 0.00;
        }
        $balancedue = $netConsignment - $payment;
        $balnaceduecon = number_format((float)$balancedue, 2, '.', '');
        $response = [
            'consignment' => $consignment,
            'discount' => $discount,
            'payment' => $payment,
            'balancedue' => $balnaceduecon,

        ];
        return  response()->json($response);
    }
    public function Statement()
    {
        return view('supplier.statement');
    }
    public function SendMail()
    {
        $data = Session::get('suppliaerstatementdata');
        $id = $data['supplierid'];
        $supplier = supplier::find($id);
        $from = date('Y-m-d', strtotime($data['fromdate']));
        $to = date('Y-m-d', strtotime($data['todate']));
        return view('supplier.sendmail', compact('supplier', 'from', 'to'));
    }
    public function ImageChange(Request $request)
    {
        $id = $request->id;
        $user = supplier::find($id);
        if ($request->hasFile('file')) {
            if (File::exists('storage/app/public/supplier/' . $user->image)) {
                File::delete('storage/app/public/supplier/' . $user->image);
            }
            $image = $request->File('file');
            $img = time() . $image->getClientOriginalExtension();
            $location = storage_path('app/public/supplier/' . $img);
            Image::make($image)->save($location);
            $user->image = $img;
        }
        $user->update();
    }

    //arcived
    public function Archived()
    {
        return view('supplier.archived');
    }
    public function LoadAllArchived()
    {
        $Supplier = supplier::orderBy('id', 'desc')
            ->where('status', 2)
            ->latest()
            ->get();
        return Datatables::of($Supplier)
            ->addIndexColumn()
            ->addColumn('openingBalance', function ($Supplier) {
                $openingBalance = $Supplier->SupplierDebt()->sum('openingBalance');
                return  number_format((float)$openingBalance, 2, '.', '');
            })
            ->addColumn('consignment', function ($Supplier) {
                $consignment = $Supplier->SupplierDebt()->sum('consignment');
                return  number_format((float)$consignment, 2, '.', '');
            })
            ->addColumn('totaldiscount', function ($Supplier) {
                $totaldiscount = $Supplier->SupplierDebt()->sum('totaldiscount');
                return number_format((float)$totaldiscount, 2, '.', '');
            })
            ->addColumn('payment', function ($Supplier) {
                $payment = $Supplier->SupplierDebt()->sum('payment');
                return number_format((float)$payment, 2, '.', '');
            })
            ->addColumn('balancedue', function ($Supplier) {

                $consignment = $Supplier->SupplierDebt()->sum('consignment');
                $discount = $Supplier->SupplierDebt()->sum('totaldiscount');
                $netConsignment = ($consignment - $discount);
                $payment = $Supplier->SupplierDebt()->sum('payment');
                $balancedue = $netConsignment - $payment;
                return number_format((float)$balancedue, 2, '.', '');
            })
            ->addColumn('status', function ($Supplier) {
                return 'Archived';
            })
            ->addColumn('user', function (Supplier $Supplier) {
             
                return $Supplier->username ? $Supplier->username->name : 'Deleted User';
            })
            ->addColumn('action', function ($Supplier) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $Supplier->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $Supplier->id . '">Permanant Delete</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="openingbalance" data-id="' . $Supplier->id . '">Balance Summery</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="retrive" data-id="' . $Supplier->id . '"><span class="badge badge-success">Retrive</span></a>';

                $button .= '</div></div>';
                return $button;
            })
            ->make(true);
    }
    public function PermanentDelete($id)
    {
        $supplier = supplier::find($id);
        if (!is_null($supplier)) {
            $purchase = purchase::where('supplier_id', $id)->get();
            if (!is_null($purchase)) {
                foreach ($purchase as $pd) {
                    $pd->delete();
                }
            }
            $PurchaseRecieved = PurchaseRecieved::where('supplier_id', $id)->get();
            if (!is_null($PurchaseRecieved)) {
                foreach ($PurchaseRecieved as $pd) {
                    $pd->delete();
                }
            }
            $purchasedetails = purchasedetails::where('supplier_id', $id)->get();
            if (!is_null($purchasedetails)) {
                foreach ($purchasedetails as $pd) {
                    $pd->delete();
                }
            }
            $PurchaseReturn = PurchaseReturn::where('supplier_id', $id)->get();
            if (!is_null($PurchaseReturn)) {
                foreach ($PurchaseReturn as $pd) {
                    $pd->delete();
                }
            }
            $SupplierPayment = SupplierPayment::where('supplier_id', $id)->get();
            if (!is_null($SupplierPayment)) {
                foreach ($SupplierPayment as $pd) {
                    $pd->delete();
                }
            }
            $SupplierDebt = SupplierDebt::where('supplier_id', $id)->get();
            if (!is_null($SupplierDebt)) {
                foreach ($SupplierDebt as $pd) {
                    $pd->delete();
                }
            }
            if (File::exists('storage/app/public/supplier/' . $supplier->image)) {
                File::delete('storage/app/public/supplier/' . $supplier->image);
            }
            $matchThese = [
                'parent_id' => $id,
                'type' => 'Supplier',
            ];
            $multicategoryDelete = MultiselectCategory::where($matchThese)->get();
            if (!is_null($multicategoryDelete)) {
                foreach ($multicategoryDelete as $mdelete) {
                    $mdelete->delete();
                }
            }
            $dumentsDelete = SupplierDocument::where('supplier_id', $id)->get();
            if (!is_null($dumentsDelete)) {
                foreach ($dumentsDelete as $rdelete) {
                    if (File::exists('storage/app/public/supplier/SupplierDoucument/' . $rdelete->image)) {
                        File::delete('storage/app/public/supplier/SupplierDoucument/' . $rdelete->image);
                    }
                    $rdelete->delete();
                }
            }
            $supplier->delete();
        }
    }
    public function Retrive($id)
    {
        $supplier = supplier::find($id);
        $supplier = supplier::find($id);
        if (!is_null($supplier)) {
            $supplier->status = 1;
            $supplier->update();
        }
    }
}
