<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;
use PDF;
use Illuminate\Notifications\Messages\NexmoMessage;
class OrderNotification extends Notification
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
        return ['database', 'mail','nexmo'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $invoice = $this->order;
        $title = "Invoice";
        $pdf = PDF::loadView('frontend.pdf.order', compact('invoice', 'title'));
        return (new MailMessage)
            ->subject('Product Order')
            ->greeting('Hello,' . $this->order->CustomerName->name)
            ->line('You make an order which waiting for recieved.')
            ->line('Order No #' . $this->order->invoice_no)
            ->line('Total Amount:' . $this->order->nettotal)
            ->action('Check Order', url('/CheckOut/complete/' . $this->order->id))
            ->line("Thanks for your purchase. We have received your order. We will notify once it's confirmed")
            /* ->line('Thank you for your Order') */
            ->attachData($pdf->output(), "invoice.pdf");
    }


    public function toDatabase($notifiable)
    {
        return [
            'type' => 'New Order',
            'message' => $this->order->CustomerName->name . ' You make an order which waiting for recieved.',
            'id' => $this->order->id,
            'invoice_no' => 'Order No #' . $this->order->invoice_no,
            'inputdate' => $this->order->inputdate,
            'total' => 'Amount: ' . $this->order->nettotal,
        ];
    }
    public function toNexmo($notifiable)
    {
        return (new NexmoMessage())
                    ->content('Hello adil ki kobor');
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
