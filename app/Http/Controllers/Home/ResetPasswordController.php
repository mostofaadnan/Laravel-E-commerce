<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use DB;
use Hash;

class ResetPasswordController extends Controller
{
    public function index()
    {
        return view('user.resetpassword');
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);
        Admin::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);
               return redirect()->back();
    }
}
