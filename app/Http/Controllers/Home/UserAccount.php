<?php

namespace App\Http\Controllers\Home;

use Illuminate\Support\Arr;
use App\Http\Controllers\Controller;
use App\Models\customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Country;
use App\Models\state;
use App\Models\city;
use App\User;
use Hash;
use Illuminate\Validation\Validator; 
use Illuminate\Notifications\Notification;
use App\Models\Brand;
use App\Models\Category;

class UserAccount extends Controller
{
    public function index()
    {
        $pagetitle="Account";
        $brands = Brand::all();
        $categories = Category::all();
        $notifications = auth()->user()->notifications()->paginate(5);
        $countrys = Country::all();
        $customer = customer::where('user_id', Auth::id())->first();
        if (is_null($customer)) {
            return view('frontend.account.index', ['customer' => null, 
            'orders' => null, 
            'countrys' => 
            $countrys, 
            'states' => null, 
            'cities' => null,
            'notifications'=>$notifications,
            'pagetitle'=>$pagetitle,
            'brands'=>$brands,
            'categories'=>$categories
            
            ]);
        } else {
            $states = state::where('country_id', $customer->country_id)->get();
            $cities = city::where('state_id', $customer->state_id)->get();
            $orders = Order::where('customer_id', $customer->id)->paginate(10);
            return view('frontend.account.index', compact('customer', 'orders', 'countrys', 'states', 'cities','notifications','pagetitle','brands','categories'));
        }
    }

    public function AddressUpdate(Request $request)
    {
        $request->validate([
            'customername' => 'required',
            'mobile_no' => 'required|numeric',
            'country_id' => 'required|numeric',
            'state_id' => 'required|numeric',
            'city_id' => 'required|numeric',
            'address' => 'required',

        ]);
        $customer = customer::where('user_id', auth::id())->first();
        if (!is_null($customer)) {
            $customer->address = $request->address;
            $customer->address_one = $request->address_one;
            $customer->country_id = $request->country_id;
            $customer->state_id = $request->state_id;
            $customer->city_id = $request->city_id;
            $customer->mobile_no = $request->mobile_no;
            $customer->update();
        } else {
            $customerCode = $this->CustomerCode();
            $newcustomer = new customer();
            $newcustomer->name = $request->customername;
            $newcustomer->customerid = $customerCode;
            $newcustomer->address = $request->address;
            $newcustomer->address_one = $request->address_one;
            $newcustomer->country_id = $request->country_id;
            $newcustomer->state_id = $request->state_id;
            $newcustomer->city_id = $request->city_id;
            $newcustomer->mobile_no = $request->mobile_no;
            $newcustomer->email = Auth::user()->email;
            $newcustomer->status = 1;
            $newcustomer->openingDate = date('Y-m-d');
            $newcustomer->user_id = Auth::id();
            $newcustomer->save();
        }
    }

    public function CustomerCode()
    {

        $customer = new customer();
        $lastcustomerID = $customer->orderBy('id', 'desc')->pluck('id')->first();
        $newcustomerID = $lastcustomerID + 1;
        $customerCode = '10' . $newcustomerID;
        return $customerCode;
    }


    public function Userupdate(Request $request)
    {
        $id = Auth::id();
        try {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'required|same:password_confirmation',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
           // return \response($e->errors(), 400);
        }
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }
        $user = User::find($id);
        $user->update($input);

        return redirect()->route('accounts');
    }
}
