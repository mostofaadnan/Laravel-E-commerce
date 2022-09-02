<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use App\Models\Contactus;
class NotificationController extends Controller
{
   
    public function markAsRead($id)
    {

        $notification = auth()->user()->notifications()->where('id', $id)->first();
        $productid = $notification->data['product_id'];
        if ($notification) {
            $notification->markAsRead();
            return redirect()->route('product.productdetails', $productid);
        }
    }

    public function markAsReadmessage($id)
    {

        $notification = auth()->user()->notifications()->where('id', $id)->first();
        $messageid = $notification->data['message_id'];
        if ($notification) {
            $notification->markAsRead();
            $message=Contactus::find($messageid);
            if(!is_null($message)){
                return redirect()->route('page.contactusView', $messageid);
            }else{
                return redirect()->back();
            }
            
        }
    }

}
