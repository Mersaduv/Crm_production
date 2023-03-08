<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class nocProcessEventMail extends Mailable implements ShouldQueue
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
       $email = $this->subject('Customer NOC installation : '.$this->customer->full_name." - ".$this->customer->customer_id)
                     ->view('noc.customers.emails.noc');

        foreach($this->customer->NocAttachment as $images){
            $email->attach(public_path('/uploads/noc/'.$images->file));
        }
        return $email;
    }
}
