<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class processEventMail extends Mailable implements ShouldQueue
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
        $email = $this->subject("New Installation Request : ".$this->customer->full_name." - ".$this->customer->customer_id)
                      ->view('sales.customers.emails.email');

        foreach($this->customer->sale->SalesAttachment as $images){
            $email->attach(public_path('/uploads/sales/'.$images->file_name));
        }
        return $email;
    }
}
