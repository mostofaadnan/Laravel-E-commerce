<?php

namespace App\Http\Controllers;

use App\Models\MailConfigation;
use Illuminate\Http\Request;
use Validator;
use Artisan;

class MailConfigController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:mail-list', ['only' => ['index',]]);
    }
    public function index()
    {
        return view('setup.mailconfig');
    }
    public function GetData()
    {
        $emailServices = MailConfigation::where(['id' => 1])->latest()->first();
        return response()->json($emailServices);
    }
    public function Store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'driver' => 'required',
            'host' => 'required',
            'port' => 'required',
            'username' => 'required',
            'password' => 'required',
            'encryption' => 'required',
            'email' => 'required|email',

        ]);
        $emailServices = MailConfigation::where(['id' => 1])->latest()->first();
        $emailServices->name = $request->name;
        $emailServices->driver = $request->driver;
        $emailServices->host = $request->host;
        $emailServices->port = $request->port;
        $emailServices->username = $request->username;
        $emailServices->password = $request->password;
        $emailServices->encryption = $request->encryption;
        $emailServices->email = $request->email;
        $emailServices->encryption = $request->encryption;
        $emailServices->email = $request->email;
        $emailServices->update();
        $this->clearAll();
    }
    public function clearAll()
    {
        $clearconfig = Artisan::call('config:cache');
    }
}
