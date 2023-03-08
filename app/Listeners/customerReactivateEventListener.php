<?php

namespace App\Listeners;

use App\Events\customerReactivateEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;
use DB;

class customerReactivateEventListener implements ShouldQueue
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
     * @param  customerReactivateEvent  $event
     * @return void
     */
    public function handle(customerReactivateEvent $event)
    {
        try{
            DB::beginTransaction();

            \Mail::to(['support@ariyabod.af','installation@ariyabod.af','finance@ariyabod.af'])
            ->cc(['baratian@ariyabod.af','ceo@ariyabod.af','soroosh@ariyabod.af'])
            ->send(new \App\Mail\customerReActivationMail($event->customer));
                       
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
    }
}
