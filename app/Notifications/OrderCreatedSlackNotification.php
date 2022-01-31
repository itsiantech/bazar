<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedSlackNotification extends Notification
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
        return ['slack'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return SlackMessage
     */
    public function toSlack($notifiable)
    {
        // $link = route('order.detail', ['id' => $this->order->id]);
        // $amount = $this->order->amount;
        // $time = $this->order->created_at->format('Y-m-d H:m:s');
        // $message = "New order of BDT. $amount is created at $time.\nThe link: $link";
        // return (new SlackMessage)
        //     ->content($message);
    }

}
