<?php

namespace App\Listeners;

use App\Events\prContractionEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;
use DB;

class prContractionEventMailListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  prContractionEvent  $event
     * @return void
     */
    public function handle(prContractionEvent $event)
    {
        try{
            DB::beginTransaction();

            \Mail::to(['installation@ariyabod.af','finance@ariyabod.af','support@ariyabod.af'])
            ->cc(['baratian@ariyabod.af','ceo@ariyabod.af','soroosh@ariyabod.af'])
            ->send(new \App\Mail\prCustomerRecontractMail($event->customer));
                  
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
    }
}
