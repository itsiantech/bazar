<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OrderConfirmation extends Notification
{
    use Queueable;

    protected $order;

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
        return ['database'];
    }


    public function toDatabase($notifiable)
    {
        return [
            'id' => $this->order->id,
            'amount' => $this->order->amount,
            'customer_name' => $notifiable->name,
            'status' => $this->order->status,
        ];
    }

}
