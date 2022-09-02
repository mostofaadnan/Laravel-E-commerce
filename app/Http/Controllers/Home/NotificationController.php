<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use App\Models\Brand;
use App\Models\Category;

class NotificationController extends Controller
{

    public function index(){
        $pagetitle='Notification';
        $brands = Brand::all();
        $categories = Category::all();
        $notifications = auth()->user()->notifications()->paginate(5);
        return view('frontend.notification.index',compact('notifications','pagetitle','brands','categories'));
    }
    public function markAsRead($id)
    {

        $notification = auth()->user()->notifications()->where('id', $id)->first();
        $orderid = $notification->data['id'];

        if ($notification) {
            $notification->markAsRead();
            return redirect()->route('checkout.orderslip', $orderid);
        }
    }

    public function markAllAsRead()
    {

        $notifications = auth()->user()->notifications()->get();
        foreach ($notifications as $notification) {
            if ($notification) {
                $notification->markAsRead();
            }
        }
        return redirect()->back();
    }
}
