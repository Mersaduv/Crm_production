<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class prNocCancelMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $customer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($customer)
    {
        $this->customer = $customer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Provincial Cancel Process : '.$this->customer->full_name." - ".$this->customer->customer_id)
                    ->view('noc.provincial.emails.cancel');
    }
}
