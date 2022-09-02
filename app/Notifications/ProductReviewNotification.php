<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\CustomerReview;

class ProductReviewNotification extends Notification
{
    use Queueable;
    public $CustomerReview;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(CustomerReview $CustomerReview)
    {
        $this->CustomerReview = $CustomerReview;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toDatabase($notifiable)
    {
        return [
            'message'=>$this->CustomerReview->review_name.' Make Review On '.$this->CustomerReview->productName->name,
            'product_id'=>$this->CustomerReview->product_id
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
