<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\state;
use App\Models\city;
use App\Models\Company;
use Image;
use File;
use Artisan;

class CompanyController extends Controller
{

    public function index()
    {
        $countrys = Country::orderBy('name', 'asc')->get();
        return view('company.index', compact('countrys'));
    }
    public function Information()
    {
        $company = Company::find(1);
        return response()->json($company);
    }
    public function Update(Request $request)
    {

        $validator = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'city_id' => 'required|numeric',
            'state_id' => 'required|numeric',
            'country_id' => 'required|numeric',
            'postalcode' => 'nullable|numeric',
            'email' => 'email:rfc,dns'

        ]);

        $company = Company::find(1);
        $company->name = $request->name;
        $company->address = $request->address;
        $company->country_id = $request->country_id;
        $company->state_id = $request->state_id;
        $company->city_id = $request->city_id;
        $company->postalcode = $request->postalcode;
        $company->tin = $request->tin;
        $company->mobile_no = $request->mobile_no;
        $company->tell_no = $request->tell_no;
        $company->fax_no = $request->fax_no;
        $company->companyemail = $request->email;
        $company->website = $request->website;
        $company->Estd = $request->Estd;
        $company->description = $request->description;
        if ($request->hasFile('company_image')) {
            if (File::exists('storage/app/public/company/' . $company->logo)) {
                File::delete('storage/app/public/company/' . $company->logo);
            }
            $image = $request->File('company_image');
            $img = time() . $image->getClientOriginalExtension();
            $location = storage_path('app/public/company/' . $img);
            Image::make($image)->save($location);
            $company->logo = $img;
        }
        $company->update();
        Session()->flash('success', 'Company Data Update successfully');
        return redirect()->Route('company');
    }
    public function TimezoneUpdate(Request $request)
    {
        $validator = $request->validate([
            'timezone' => 'required',
            'language' => 'required',
        ]);
        $company = Company::find(1);
        $company->time_zone = $request->timezone;
       $company->language = $request->language;
        $company->update();
         Artisan::call('config:cache');
    }
}
