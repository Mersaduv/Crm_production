<?php

namespace App\Listeners;

use App\Events\processEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Customer;
use Mail;
use DB;

class processEventListener implements ShouldQueue
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
     * @param  processEvent  $event
     * @return void
     */
    public function handle(processEvent $event)
    {
        try{
            DB::beginTransaction();

            \Mail::to(['installation@ariyabod.af','finance@ariyabod.af','support@ariyabod.af'])
            ->cc(['baratian@ariyabod.af','ceo@ariyabod.af','soroosh@ariyabod.af'])
            ->send(new \App\Mail\processEventMail($event->customer)); 
                       
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
    }
}
