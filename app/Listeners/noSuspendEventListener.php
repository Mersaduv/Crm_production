<?php

namespace App\Listeners;

use App\Events\nocSuspendEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Customer;
use Mail;
use DB;

class noSuspendEventListener implements ShouldQueue
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
     * @param  nocSuspendEvent  $event
     * @return void
     */
    public function handle(nocSuspendEvent $event)
    {
        try{
            DB::beginTransaction();

            \Mail::to(['finance@ariyabod.af','installation@ariyabod.af','sales@ariyabod.af'])
            ->cc(['baratian@ariyabod.af','ceo@ariyabod.af','soroosh@ariyabod.af'])
            ->send(new \App\Mail\nocSuspendEventMail($event->customer)); 
                       
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
    }
}
