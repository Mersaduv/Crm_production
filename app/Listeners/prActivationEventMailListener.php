<?php

namespace App\Listeners;

use App\Events\prActivatingEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;
use DB;

class prActivationEventMailListener implements ShouldQueue
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
     * @param  prActivatingEvent  $event
     * @return void
     */
    public function handle(prActivatingEvent $event)
    {
        try{
            DB::beginTransaction();

            \Mail::to(['support@ariyabod.af','installation@ariyabod.af','finance@ariyabod.af'])
            ->cc(['baratian@ariyabod.af','ceo@ariyabod.af','soroosh@ariyabod.af'])
            ->send(new \App\Mail\prCustomerReactivationMail($event->customer));
                  
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
    }
}
