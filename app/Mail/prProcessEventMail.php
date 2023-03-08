<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class prProcessEventMail extends Mailable implements ShouldQueue
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
                      ->view('sales.provincial.emails.email');

        foreach($this->customer->PrAttachments as $images){
            $email->attach(public_path('/uploads/pr/'.$images->file_name));
        }
        return $email;
    }
}
