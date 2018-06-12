<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderProcessing extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $order;

    /**
     * Create a new message instance.
     *
     * @param $name
     * @param $order
     */
    public function __construct($name, $order)
    {
        $this->subject('Coffee Delivery đã nhận đơn hàng ' . $order['id']);
        $this->name = $name;
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.orderProcessing');
    }
}
