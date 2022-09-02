<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emplyer;
use DataTables;
use App\Models\designation;
use App\Models\salaryDetails;

use DB;
use Hash;
use Image;
use File;

class EmployerController extends Controller
{
    public function index()
    {
        return view('employer.index');
    }
    public function LoadAll()
    {
        $Emplyer = Emplyer::orderBy('id', 'desc')->latest()->get();
        return Datatables::of($Emplyer)
            ->addIndexColumn()
            ->addColumn('status', function ($Emplyer) {
                return $Emplyer->status == 1 ?  'Active' : 'Inactive';
            })
            ->addColumn('action', function ($Emplyer) {
                $button = '<div class="btn-group" role="group">';
                $button .= '<button id="btnGroupDrop1" type="button" class="btn btn-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>';
                $button .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $Emplyer->id . '">View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="dataedit" data-id="' . $Emplyer->id . '">Edit</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $Emplyer->id . '">Delete</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="documentup" data-id="' . $Emplyer->id . '">Document Upload</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="openingbalance" data-id="' . $Emplyer->id . '">Balance Summery</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '</div></div>';
                return $button;
            })
            ->make(true);
    }
    public function EmployeeId()
    {
        $numb = '100';
        $Emplyer = new Emplyer();
        $lastEmplyer = $Emplyer->pluck('id')->last();
        $EmplyerCode = $lastEmplyer + 1;
        return response()->json($numb . $EmplyerCode);
    }
    public function EmployeDataList(Request $request)
    {
        if ($request->ajax()) {
            $Emplyers = Emplyer::orderBy("id", 'asc')->get();
            return view('datalist.employeedatalist', compact('Emplyers'))->render();
        }
    }
    public function Create()
    {
        $designations = designation::where('status', 1)->get();
        return view('employer.create', compact('designations'));
    }
    public function Store(Request $request)
    {
        //Validate name, email and password fields
        $this->validate($request, [
            'name' => 'required',
            'email' => 'email',
            'mobile_no' => 'required',
            'salary' => 'required',
        ]);

        $input = $request->all();
        if ($request->hasFile('supplier_image')) {
            $image = $request->File('supplier_image');
            $img = time() . $image->getClientOriginalExtension();
            $location =  storage_path('app/public/Employee/' . $img);
            Image::make($image)->save($location);
            $input['image'] = $img;
        }
        //print_r($input);
        Emplyer::create($input);
        Session()->flash('success', 'employee has insert successfully');
        return redirect()->route('employees');
    }
    public function Edit($id)
    {
        $Emplyer = Emplyer::find($id);
        $designations = designation::where('status', 1)->get();
        return view('employer.edit', compact('Emplyer', 'designations'));
    }
    public function Profile($id)
    {
        $Emplyer = Emplyer::find($id);
        return view('employer.profile', compact('Emplyer'));
    }
    public function empSalary(Request $request)
    {
        $salary = salaryDetails::orderBy('id', 'desc')->latest()
            ->where('employee_id', $request->employeeid)
            ->where('status', 1)
            ->get();
        return Datatables::of($salary)
            ->addIndexColumn()
            ->addColumn('payment', function ($salary) {
                if ($salary->payment_type == 1) {
                    $source = 'Cash';
                } else if ($salary->payment_type == 2) {
                    $source = 'Bank';
                } else {
                    $source = '';
                }
                return $source;
            })
            ->make(true);
    }
    public function Update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'email',
            'mobile_no' => 'required',
            'salary' => 'required',
        ]);
        $input = $request->all();
        $Emplyer = Emplyer::find($request->id);
        if ($request->hasFile('supplier_image')) {
            if (File::exists('images/app/public/Employee/' . $Emplyer->image)) {
                File::delete('images/app/public/Employee/' . $Emplyer->image);
            }
            $image = $request->File('supplier_image');
            $img = time() . $image->getClientOriginalExtension();
            $location =   storage_path('app/public/Employee/' . $img);
            Image::make($image)->save($location);
            $input['image'] = $img;
        }
        $Emplyer->update($input);
        Session()->flash('success', 'employee has update successfully');
        return redirect()->route('employees');
    }
    public function Delete($id)
    {
        $Emplyer = Emplyer::find($id);
        if (!is_null($Emplyer)) {
            $Emplyer->delete();
        }
    }
    public function ImageChange(Request $request)
    {
        $id = $request->id;
        $user = Emplyer::find($id);
        if ($request->hasFile('file')) {
            if (File::exists('storage/app/public/Employee/' . $user->image)) {
                File::delete('storage/app/public/Employee/' . $user->image);
            }
            $image = $request->File('file');
            $img = time() . $image->getClientOriginalExtension();
            $location =  storage_path('app/public/Employee/' . $img);
            Image::make($image)->save($location);
            $user->image = $img;
        }
        $user->update();
      
    }
}
