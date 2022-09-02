<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class DeliveryNotification extends Notification
{
    use Queueable;
    public $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Order Delivery')
            ->greeting('Hello,' . $this->order->CustomerName->name)
            ->line('Your order delivery on the way.')
            ->line('Order No #' . $this->order->invoice_no)
            ->line('Amount:' . $this->order->nettotal)
            ->action('Check Invoice', url('/CheckOut/orderslip/' . $this->order->id))
            ->line('Your items are out for delivery.')
           /*  ->line('Thank you for your Order'); */
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
            'type' => 'Delivery',
            'message' => $this->order->CustomerName->name . ' your order ready for deliver.we will contact soon for recieve yor order',
            'id' => $this->order->id,
            'invoice_no' => 'Order No #' . $this->order->invoice_no,
            'inputdate' => $this->order->inputdate,
            'total' => 'Amount: ' . $this->order->nettotal,
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
