<?php

namespace App\Listeners;

use App\Events\prTerminateEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Provincial;
use Mail;
use DB;

class prTerminateListener implements ShouldQueue
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
     * @param  prTerminateEvent  $event
     * @return void
     */
    public function handle(prTerminateEvent $event)
    {
        try{
            DB::beginTransaction();

            \Mail::to(['installation@ariyabod.af','finance@ariyabod.af','support@ariyabod.af'])
            ->cc(['baratian@ariyabod.af','ceo@ariyabod.af','soroosh@ariyabod.af'])
            ->send(new \App\Mail\prTerminateMail($event->customer));
                  
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
             
        }
    }
}
