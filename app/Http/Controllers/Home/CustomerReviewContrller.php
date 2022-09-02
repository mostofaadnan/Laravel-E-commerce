<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerReview;
use App\Admin;
use App\Notifications\ProductReviewNotification;

class CustomerReviewContrller extends Controller
{
    public function Store(Request $request)
    {
        $review = new CustomerReview();
        $review->product_id = $request->product_id;
        $review->name = $request->name;
        $review->email = $request->email;
        $review->comment = $request->comment;

        if ($review->save()) {
            $admins = Admin::all();
            foreach ($admins as $admin) {
                Admin::find($admin->id)->notify(new ProductReviewNotification($review));
            }

            return response()->json($request->name);
        }
    }
}
