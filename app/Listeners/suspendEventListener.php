<?php

namespace App\Listeners;

use App\Events\suspendEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Customer;
use Mail;
use DB;

class suspendEventListener implements ShouldQueue
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
     * @param  suspendEvent  $event
     * @return void
     */
    public function handle(suspendEvent $event)
    {
        try{
            DB::beginTransaction();

            \Mail::to(['support@ariyabod.af','installation@ariyabod.af','finance@ariyabod.af'])
            ->cc(['baratian@ariyabod.af','ceo@ariyabod.af','soroosh@ariyabod.af'])
            ->send(new \App\Mail\suspendEventMail($event->customer));  
                       
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
    }
}
