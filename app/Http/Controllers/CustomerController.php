<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Category;
use App\Models\customer;
use App\Models\MultiselectCategory;
use App\Models\CustomerDebts;
use App\Models\CustomerDocument;
use App\Models\InvoiceDetails;
use App\Models\Invoice;
use App\Models\SaleReturn;
use App\Models\CustomerPaymentRecieve;
use Image;
use File;
use DataTables;

class CustomerController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:customer-list|customer-create|customer-edit|customer-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:customer-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:customer-edit', ['only' => ['edit', 'update', 'Active', 'Inactive']]);
        $this->middleware('permission:customer-delete', ['only' => ['destroy']]);
        $this->middleware('permission:mail-list', ['only' => ['SendMail',]]);
    }
    public function index()
    {
        return view('customer.index');
    }
    public function LoadAll()
    {
        $customer = customer::orderBy('id', 'desc')
            ->whereIn('status', [0, 1])
            ->latest()
            ->get();
        return Datatables::of($customer)
            ->addIndexColumn()
            ->addColumn('cashinvoice', function (customer $customer) {

                $cashinvoice = $customer->CustomerDebts()->sum('cashinvoice');
                return number_format((float)$cashinvoice, 2, '.', '');
            })
            ->addColumn('creditinvoice', function (customer $customer) {
                $creditinvoice = $customer->CustomerDebts()->sum('creditinvoice');
                return number_format((float)$creditinvoice, 2, '.', '');
            })
            ->addColumn('totaldiscount', function (customer $customer) {
                $totaldiscount = $customer->CustomerDebts()->sum('totaldiscount');
                return number_format((float)$totaldiscount, 2, '.', '');
            })
            ->addColumn('payment', function (customer $customer) {
                $payment = $customer->CustomerDebts()->sum('payment');
                return number_format((float)$payment, 2, '.', '');
            })
            ->addColumn('netpayment', function (customer $customer) {
                $cashinvoice = $customer->CustomerDebts()->sum('cashinvoice');
                $payment = $customer->CustomerDebts()->sum('payment');
                $netpayment = $payment + $cashinvoice;
                return number_format((float)$netpayment, 2, '.', '');
            })
            ->addColumn('consignment', function (customer $customer) {
                $cashinvoice = $customer->CustomerDebts()->sum('cashinvoice');
                $creditinvoice = $customer->CustomerDebts()->sum('creditinvoice');
                $consignment =  $cashinvoice + $creditinvoice;
                return number_format((float)$consignment, 2, '.', '');
            })
            ->addColumn('balancedue', function (customer $customer) {
                $cashinvoice = $customer->CustomerDebts()->sum('cashinvoice');
                $creditinvoice = $customer->CustomerDebts()->sum('creditinvoice');
                $discount = $customer->CustomerDebts()->sum('totaldiscount');
                $consignment =  ($cashinvoice + $creditinvoice) - $discount;
                $payment = $customer->CustomerDebts()->sum('payment');
                $netpayment = $payment + $cashinvoice;
                $balancedue = $consignment - $netpayment;
                return number_format((float)$balancedue, 2, '.', '');
            })
            ->addColumn('status', function ($customer) {
                return $customer->status == 1 ?  'Active' : 'Inactive';
            })
            ->addColumn('user', function (customer $customer) {
              
                return $customer->username ? $customer->username->name : 'Deleted User';
            })
            ->addColumn('action', function ($customer) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $customer->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="dataedit" data-id="' . $customer->id . '">Edit</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $customer->id . '">Delete</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="documentup" data-id="' . $customer->id . '">Document Upload</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="openingbalance" data-id="' . $customer->id . '">Balance Summery</a>';
                $button .= '<div class="dropdown-divider"></div>';
                if ($customer->status == 1) {
                    $button .= '<a class="dropdown-item" id="inactive" data-id="' . $customer->id . '"><span class="badge badge-danger">In-Active</span></a>';
                } else {
                    $button .= '<a class="dropdown-item" id="active" data-id="' . $customer->id . '"><span class="badge badge-success">Active</span></a>';
                }

                $button .= '</div></div>';
                return $button;
            })
            ->make(true);
    }
    public function Profile()
    {
        return view('customer.view');
    }
    public function GetList()
    {
        $customers = customer::orderBy('id', 'asc')->get();
        return response()->json($customers);
    }
    public function CustomerDatalist(Request $request)
    {
        if ($request->ajax()) {
            $customers = customer::select('id', 'name')
                ->where('status', 1)
                ->orderBy("id", 'asc')
                ->get();
            return view('datalist.customerdatalist', compact('customers'))->render();
        }
    }
    public function CustomerSearchDatalist(Request $request)
    {
        $data = $request->search;
        $customers = customer::query()
            ->where('id', 'LIKE', "%{$data}%")
            ->orWhere('name', 'LIKE', "%{$data}%")
            ->orWhere('mobile_no', 'LIKE', "%{$data}%")
            ->orWhere('email', 'LIKE', "%{$data}%")
            ->orderBy("id", 'asc')
            ->get();
        return view('datalist.customerdatalist', compact('customers'))->render();
    }
    public function create()
    {
        $countrys = Country::orderBy('name', 'asc')->get();
        $categoryis = Category::orderBy('title', 'asc')->get();
        return view('customer.create', compact('countrys', 'categoryis'));
    }

    public function CustomerCode()
    {

        $customer = new customer();
        $lastcustomerID = $customer->orderBy('id', 'desc')->pluck('id')->first();
        $newcustomerID = $lastcustomerID + 1;;
        return response()->json('1000' . $newcustomerID);
    }



    public function store(Request $request)
    {
        $validator = $request->validate([
            'customername' => 'required',
            'mobile_no' => 'required|numeric',

        ]);
        $customer = new customer;
        $customer->name = $request->customername;
        $customer->customerid = $request->customerid;
        $customer->address = $request->address;
        $customer->country_id = $request->country_id;
        $customer->state_id = $request->state_id;
        $customer->city_id = $request->city_id;
        $customer->status = $request->status;
        $customer->mobile_no = $request->mobile_no;
        $customer->email = $request->supemail;
        $customer->user_id = 0;
      
        /*  single image insert   */
        if ($request->hasFile('supplier_image')) {
            $image = $request->File('supplier_image');
            $img = time() . $image->getClientOriginalExtension();
            $location = storage_path('app/public/Customer/' . $img);
            Image::make($image)->save($location);
            $customer->image = $img;
        }
        if ($customer->save() == true) {
         
            /*     return response()->json($customer); */
            Session()->flash('success', 'Customer has insert successfully');
        } else {

            Session()->flash('success', 'Customer has insert Fail');
        }
        return redirect()->Route('customer.create');
    }
    public function OpeningBalance($id)
    {
        $customer = customer::select('id', 'name')->where('id', $id)->first();
        return view('customer.openingBalance', compact('customer'));
    }

    public function Document($id)
    {
        $customer = customer::select('id', 'name')->where('id', $id)->first();
        return view('customer.partials.documentUpload', compact('customer'));
    }
    public function DocumentUpload(Request $request)
    {
        $request->validate([
            'supplier_image' => 'required | mimes:jpeg,jpg,png | max:1000',
            'type' => 'required',
        ]);
        if ($request->hasFile('supplier_image')) {
            $CustomerDocument = new CustomerDocument();
            $CustomerDocument->customer_id = $request->id;
            $CustomerDocument->type = $request->type;
            $CustomerDocument->remark = $request->remark;
            $image = $request->File('supplier_image');
            $img = time() . $image->getClientOriginalExtension();
            $location = storage_path('app/public/Customer/customerDocument/' . $img);
            Image::make($image)->save($location);
            $CustomerDocument->image = $img;
            $CustomerDocument->save();
        }
        Session()->flash('success', 'Customer Document has insert successfully');
        return redirect()->Route('customers');
    }
    public function show($id)
    {

        return view('customer.view');
    }
    public function GetOpening(Request $request)
    {
        if ($request->ajax()) {
            $opening = CustomerDebts::where('customer_id', $request->customerid)
                ->where('remark', 'Opening Balance')
                ->first();
            if (!is_null($opening)) {
                $data['cashinvoice'] = $opening->cashinvoice;
                $data['creditinvoice'] = $opening->creditinvoice;
                $data['totaldiscount'] = $opening->totaldiscount;
                $data['payment'] = $opening->payment;
                $data['id'] = $opening->id;
            } else {
                $data['cashinvoice'] = 0.00;
                $data['creditinvoice'] = 0.00;
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
            $CustomerDebts = CustomerDebts::find($request->balanceid);
        } else {
            $CustomerDebts = new CustomerDebts();
        }
        $CustomerDebts->customer_id = $request->customer_id;
        $CustomerDebts->openingBalance = $request->balancedue;
        $CustomerDebts->cashinvoice = $request->cashinvoice;
        $CustomerDebts->creditinvoice = $request->creditinvoice;
        $CustomerDebts->totaldiscount = $request->totaldiscount;
        $CustomerDebts->payment = $request->payment;
        $CustomerDebts->remark = 'Opening Balance';
        $CustomerDebts->save();
        Session()->flash('success', 'Customer Balance has insert successfully');
        return redirect()->Route('customers');
    }
    public function BalanceLoadAll(Request $request)
    {
        $CustomerDebts = CustomerDebts::orderBy('id', 'desc')
            ->where('customer_id', $request->customerid)

            ->where('cancel', 0)
            ->get();
        return Datatables::of($CustomerDebts)
            ->addIndexColumn()
            ->addColumn('totalpayment', function ($CustomerDebts) {
                $cashinvoice = $CustomerDebts->cashinvoice;
                $payment = $CustomerDebts->payment;
                $netpayment = $payment + $cashinvoice;
                return  $netpayment;
            })
            ->addColumn('inputdate', function ($customer) {
                $fromdate = date('d/m/Y', strtotime($customer->created_at));
                return  $fromdate;
            })
            ->make(true);
    }
    public function CustomerInfo(Request $request)
    {
        if ($request->ajax()) {
            $customer = customer::with('CategoryName', 'CategoryName.CateName', 'CountryName', 'StateName', 'CityName', 'CustomerDocument')->find($request->customerid);
            $CustomerDebts = CustomerDebts::where('customer_id', $request->customerid)

                ->where('cancel', 0)
                ->get();

            $openingbalance = number_format((float)$CustomerDebts->sum('openingBalance'), 2, '.', '');
            $cashinvoice = number_format((float)$CustomerDebts->sum('cashinvoice'), 2, '.', '');
            $creditinvoice = number_format((float) $CustomerDebts->sum('creditinvoice'), 2, '.', '');
            $discount = number_format((float) $CustomerDebts->sum('totaldiscount'), 2, '.', '');
            $consignment =  round(($cashinvoice + $creditinvoice), 2);
            $netconsignment =  round(($consignment - $discount), 2);
            $payment = $CustomerDebts->sum('payment');
            $netpayment =  round(($payment + $cashinvoice), 2);
            $balancedue = round(($netconsignment - $netpayment), 2);
            $response = [
                'customer' => $customer,
                'openingbalance' => $openingbalance,
                'cashinvoice' => $cashinvoice,
                'creditinvoice' => $creditinvoice,
                'consignment' => $consignment,
                'discount' => $discount,
                'payment' => $netpayment,
                'balancedue' => $balancedue,
            ];
            return  response()->json($response);
        }
    }

    public function Edit($id)
    {
        $customer = Customer::find($id);
        $countrys = Country::orderBy('name', 'asc')->get();
        $categoryis = Category::orderBy('title', 'asc')->get();
        $CustomerDebts = CustomerDebts::where('customer_id', $id)

            ->where('cancel', 0)
            ->get();
        $openingbalance = $CustomerDebts->sum('openingBalance');
        $cashinvoice = $CustomerDebts->sum('cashinvoice');
        $creditinvoice = $CustomerDebts->sum('creditinvoice');
        $discount = $CustomerDebts->sum('totaldiscount');
        $consignment =  round(($cashinvoice + $creditinvoice), 2);
        $netconsignment =  round(($consignment - $discount), 2);
        $payment = $CustomerDebts->sum('payment');
        $netpayment =  round(($payment + $cashinvoice), 2);
        $balancedue = round(($netconsignment - $netpayment), 2);
        return view('customer.edit', compact('customer', 'countrys', 'categoryis', 'openingbalance', 'cashinvoice', 'creditinvoice', 'discount', 'consignment', 'netpayment', 'balancedue'));
    }
    public function Update(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required',
            'mobile_no' => 'required|numeric',
        ]);
        $dataid = $request->cusid;
        $Customer = Customer::find($dataid);
        $Customer->name = $request->name;
        $Customer->address = $request->address;
        $Customer->country_id = $request->country_id;
        $Customer->state_id = $request->state_id;
        $Customer->city_id = $request->city_id;
        $Customer->status = $request->status;
        $Customer->mobile_no = $request->mobile_no;
        $Customer->email = $request->supemail;
        
        /*  single image update   */
        if ($request->hasFile('customer_image')) {
            if (File::exists('storage/app/public/Customer/' . $Customer->image)) {
                File::delete('storage/app/public/Customer/' . $Customer->image);
            }
            $image = $request->File('customer_image');
            $img = time() . $image->getClientOriginalExtension();
            $location = storage_path('app/public/Customer/' . $img);
            Image::make($image)->save($location);
            $Customer->image = $img;
        }
        $Customer->update();
        Session()->flash('success', 'customer has update successfully');
        return redirect()->Route('customers');
    }

    public function GetAmounthistory($id)
    {
        $CustomerDebts = CustomerDebts::where('customer_id', $id)

            ->where('cancel', 0)
            ->get();


        if (!is_null($CustomerDebts)) {
            $cashinvoice = $CustomerDebts->sum('cashinvoice');
            $creditinvoice = $CustomerDebts->sum('creditinvoice');
            $consignment = $cashinvoice + $creditinvoice;
            $discount = $CustomerDebts->sum('totaldiscount');
            $netConsignment = $consignment - $discount;
            $payment = $CustomerDebts->sum('payment');
            $netpayment = $payment + $cashinvoice;
            $balancedue = $netConsignment - $netpayment;
        } else {
            $cashinvoice = 0.00;
            $creditinvoice = 0.00;
            $consignment = 0.00;
            $discount = 0.00;
            $payment = 0.00;
            $balancedue = 0.00;
        }
        $response = [
            'cashinvoice' => $cashinvoice,
            'creditinvoice' => $creditinvoice,
            'consignment' => $consignment,
            'discount' => $discount,
            'payment' => $netpayment,
            'balancedue' => $balancedue,
        ];
        return  response()->json($response);
    }
    public function Active($id)
    {
        $customer = customer::find($id);
        $customer->status = 1;
        $customerupdate = $customer->update();
        return response()->json($customerupdate);
    }
    public function Inactive($id)
    {
        $customer = customer::find($id);
        $customer->status = 0;
        $customerupdate = $customer->update();
        return response()->json($customerupdate);
    }
    public function Statement()
    {
        return view('customer.statement');
    }
    public function SendMail()
    {
        $data = Session::get('customerstatementdata');
        $id = $data['customerid'];
        $customer = customer::find($id);
        $from = date('Y-m-d', strtotime($data['fromdate']));
        $to = date('Y-m-d', strtotime($data['todate']));
        return view('customer.sendmail', compact('customer', 'from', 'to'));
    }
    public function ImageChange(Request $request)
    {
        $id = $request->id;
        $user = customer::find($id);
        if ($request->hasFile('file')) {
            if (File::exists('storage/app/public/customer/' . $user->image)) {
                File::delete('storage/app/public/customer/' . $user->image);
            }
            $image = $request->File('file');
            $img = time() . $image->getClientOriginalExtension();
            $location = storage_path('app/public/Customer/' . $img);
            Image::make($image)->save($location);
            $user->image = $img;
        }
        $user->update();
    }

    public function destroy($id)
    {
        $customer = customer::find($id);
        if (!is_null($customer)) {
            if (InvoiceDetails::where('customer_id', '=', $id)->exists() || Invoice::where('customer_id', '=', $id)->exists() || SaleReturn::where('customer_id', '=', $id)->exists() || CustomerPaymentRecieve::where('customer_id', '=', $id)->exists()) {
                $customer->status = 2;
                $customer->update();
            } else {
                $CustomerDebts = CustomerDebts::where('customer_id', $id)->get();
                if (!is_null($CustomerDebts)) {
                    foreach ($CustomerDebts as $pd) {
                        $pd->delete();
                    }
                }
                if (File::exists('storage/app/public/Customer/' . $customer->image)) {
                    File::delete('storage/app/public/Customer//' . $customer->image);
                }
                $matchThese = [
                    'parent_id' => $id,
                    'type' => 'Customer',
                ];
                $multicategoryDelete = MultiselectCategory::where($matchThese)->get();
                if (!is_null($multicategoryDelete)) {
                    foreach ($multicategoryDelete as $mdelete) {
                        $mdelete->delete();
                    }
                }
                $dumentsDelete = CustomerDocument::where('customer_id', $id)->get();
                if (!is_null($dumentsDelete)) {
                    foreach ($dumentsDelete as $rdelete) {
                        if (File::exists('storage/app/public/customer/customerDocument/' . $rdelete->image)) {
                            File::delete('storage/app/public/customer/customerDocument/' . $rdelete->image);
                        }
                        $rdelete->delete();
                    }
                }
                $customer->delete();
            }
        }
    }
    //arcived
    public function Archived()
    {
        return view('customer.archived');
    }
    public function LoadAllArchived()
    {
        $customer = customer::orderBy('id', 'desc')
            ->where('status', 2)
            ->latest()
            ->get();
        return Datatables::of($customer)
            ->addIndexColumn()
            ->addColumn('cashinvoice', function (customer $customer) {

                $cashinvoice = $customer->CustomerDebts()->sum('cashinvoice');
                return number_format((float)$cashinvoice, 2, '.', '');
            })
            ->addColumn('creditinvoice', function (customer $customer) {
                $creditinvoice = $customer->CustomerDebts()->sum('creditinvoice');
                return number_format((float)$creditinvoice, 2, '.', '');
            })
            ->addColumn('totaldiscount', function (customer $customer) {
                $totaldiscount = $customer->CustomerDebts()->sum('totaldiscount');
                return number_format((float)$totaldiscount, 2, '.', '');
            })
            ->addColumn('payment', function (customer $customer) {
                $payment = $customer->CustomerDebts()->sum('payment');
                return number_format((float)$payment, 2, '.', '');
            })
            ->addColumn('netpayment', function (customer $customer) {
                $cashinvoice = $customer->CustomerDebts()->sum('cashinvoice');
                $payment = $customer->CustomerDebts()->sum('payment');
                $netpayment = $payment + $cashinvoice;
                return number_format((float)$netpayment, 2, '.', '');
            })
            ->addColumn('consignment', function (customer $customer) {
                $cashinvoice = $customer->CustomerDebts()->sum('cashinvoice');
                $creditinvoice = $customer->CustomerDebts()->sum('creditinvoice');
                $consignment =  $cashinvoice + $creditinvoice;
                return number_format((float)$consignment, 2, '.', '');
            })
            ->addColumn('balancedue', function (customer $customer) {
                $cashinvoice = $customer->CustomerDebts()->sum('cashinvoice');
                $creditinvoice = $customer->CustomerDebts()->sum('creditinvoice');
                $discount = $customer->CustomerDebts()->sum('totaldiscount');
                $consignment =  ($cashinvoice + $creditinvoice) - $discount;
                $payment = $customer->CustomerDebts()->sum('payment');
                $netpayment = $payment + $cashinvoice;
                $balancedue = $consignment - $netpayment;
                return number_format((float)$balancedue, 2, '.', '');
            })
            ->addColumn('status', function ($customer) {
                return 'Archived';
            })
            ->addColumn('user', function (customer $customer) {

                return $customer->username ? $customer->username->name : 'Deleted User';
            })
            ->addColumn('action', function ($customer) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $customer->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="dataedit" data-id="' . $customer->id . '">Edit</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $customer->id . '">Permanent Delete</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="retirve" data-id="' . $customer->id . '"><span class="badge badge-success">Retrive</span></a>';
                $button .= '</div></div>';
                return $button;
            })
            ->make(true);
    }
    public function PermanentDelete($id)
    {
        $customer = customer::find($id);
        if (!is_null($customer)) {

            $InvoiceDetails = InvoiceDetails::where('customer_id', $id)->get();
            if (!is_null($InvoiceDetails)) {
                foreach ($InvoiceDetails as $pd) {
                    $pd->delete();
                }
            }
            $Invoice = Invoice::where('customer_id', $id)->get();
            if (!is_null($Invoice)) {
                foreach ($Invoice as $pd) {
                    $pd->delete();
                }
            }
            $SaleReturn = SaleReturn::where('customer_id', $id)->get();
            if (!is_null($SaleReturn)) {
                foreach ($SaleReturn as $pd) {
                    $pd->delete();
                }
            }
            $CustomerPaymentRecieve = CustomerPaymentRecieve::where('customer_id', $id)->get();
            if (!is_null($CustomerPaymentRecieve)) {
                foreach ($CustomerPaymentRecieve as $pd) {
                    $pd->delete();
                }
            }
            $CustomerDebts = CustomerDebts::where('customer_id', $id)->get();
            if (!is_null($CustomerDebts)) {
                foreach ($CustomerDebts as $pd) {
                    $pd->delete();
                }
            }
            if (File::exists('storage/app/public/Customer/' . $customer->image)) {
                File::delete('storage/app/public/Customer/' . $customer->image);
            }
            $matchThese = [
                'parent_id' => $id,
                'type' => 'Customer',
            ];
            $multicategoryDelete = MultiselectCategory::where($matchThese)->get();
            if (!is_null($multicategoryDelete)) {
                foreach ($multicategoryDelete as $mdelete) {
                    $mdelete->delete();
                }
            }
            $dumentsDelete = CustomerDocument::where('customer_id', $id)->get();
            if (!is_null($dumentsDelete)) {
                foreach ($dumentsDelete as $rdelete) {
                    if (File::exists('storage/app/public/customer/customerDocument/' . $rdelete->image)) {
                        File::delete('storage/app/public/customer/customerDocument/' . $rdelete->image);
                    }
                    $rdelete->delete();
                }
            }
            $customer->delete();
        }
    }
    public function Retrive($id)
    {
        $customer = customer::find($id);
        $customer = customer::find($id);
        if (!is_null($customer)) {
            $customer->status = 1;
            $customer->update();
        }
    }
}
