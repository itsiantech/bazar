<?php

namespace App\Mail;

use App\Http\Controllers\Api\V1\OrderController;
use App\Models\User;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        // return $order;
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
	
        // return $this->order->id;
        return $this->markdown('emails.order-confirmation', ['order_details' => (new Order)->getDetail($this->order->id)]);
    }
}
