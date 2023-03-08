<?php

namespace App\Listeners;

use App\Events\financeSuspendEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Customer;
use Mail;
use DB;

class financeSuspendEventListener implements ShouldQueue
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
     * @param  suspending  $event
     * @return void
     */
    public function handle(financeSuspendEvent $event)
    {
        try{
            DB::beginTransaction();

            \Mail::to(['support@ariyabod.af','installation@ariyabod.af','sales@ariyabod.af'])
            ->cc(['baratian@ariyabod.af','ceo@ariyabod.af','soroosh@ariyabod.af'])
            ->send(new \App\Mail\financeSuspendEventMail($event->customer));  
                       
            DB::commit();
        }catch(Exception $e){
            DB::rollback(); 
        }
    }
}
