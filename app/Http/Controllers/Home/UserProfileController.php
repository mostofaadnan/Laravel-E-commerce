<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\purchase;
use App\Models\SupplierPayment;
use App\Models\CustomerPaymentRecieve;
use App\User;
use Image;
use File;
use SebastianBergmann\Environment\Console;

class UserProfileController extends Controller
{
    public function Profile()
    {
        return view('user.profile');
    }

    public function UserOperationByUser($id)
    {
        $data['invoice'] = Invoice::Where('user_id', $id)->where('cancel', 0)->sum('nettotal');
        $data['purchase'] = purchase::Where('user_id', $id)->where('status', 1)->sum('nettotal');
        $data['SupplierPayment'] = SupplierPayment::Where('user_id', $id)->sum('payment');
        $data['CustomerPaymentRecieve'] = CustomerPaymentRecieve::where('user_id', $id)->sum('recieve');
        return response()->json($data);
    }
    public function UserOperationByUserCurrentdate($id)
    {
        $currentdate = date('Y-m-d');
        $data['invoice'] = Invoice::Where('user_id', $id)->where('cancel', 0)->where('created_at', $currentdate)->sum('nettotal');
        $data['purchase'] = purchase::Where('user_id', $id)->where('status', 1)->where('created_at', $currentdate)->sum('nettotal');
        $data['SupplierPayment'] = SupplierPayment::Where('user_id', $id)->where('created_at', $currentdate)->sum('payment');
        $data['CustomerPaymentRecieve'] = CustomerPaymentRecieve::where('user_id', $id)->where('created_at', $currentdate)->sum('recieve');
        return response()->json($data);
    }
    public function ImageChange(Request $request)
    {
        $id = $request->id;
        $user = User::find(Auth::user()->id);
        if ($request->hasFile('file')) {
            if (File::exists('storage/user/' . $user->image)) {
                File::delete('storage/store/' . $user->image);
            }
            $image = $request->File('file');
            $img = time() . $image->getClientOriginalExtension();
            $location =   storage_path('app/public/user/' . $img);
            Image::make($image)->save($location);
            $user->image = $img;
        }
        $user->update();
        return response()->json($request->File('file'));
    }
}
