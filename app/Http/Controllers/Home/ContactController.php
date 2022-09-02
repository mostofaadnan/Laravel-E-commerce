<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\newsLatter;
use App\Models\Company;
use App\Models\Contactus;
use App\Admin;
use App\Notifications\MessageNotification;
use App\Models\Brand;
use App\Models\Category;

class ContactController extends Controller
{
  public function index()
  {
    $pagetitle = "Contact";
    $brands = Brand::all();
    $categories = Category::all();
    $company = Company::find(1);
    return view('frontend.contact.index', compact('company', 'pagetitle', 'brands', 'categories'));
  }

  public function NewsLatterStore(Request $request)
  {
    $newsLatter = new newsLatter();
    $newsLatter->email = $request->email;
    $newsLatter->save();
  }

  public function contactusStore(Request $request)
  {
    $Contactus = new Contactus();
    $Contactus->name = $request->name;
    $Contactus->email = $request->email;
    $Contactus->subject = $request->subject;
    $Contactus->message = $request->message;

    if ($Contactus->save()) {
      $admins = Admin::all();
      foreach ($admins as $admin) {
        Admin::find($admin->id)->notify(new MessageNotification($Contactus));
      }
    }
  }
}
