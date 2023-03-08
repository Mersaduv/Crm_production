<?php

namespace App\Listeners;

use App\Events\CancelEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Customer;
use Mail;
use DB;

class noCancelEventListener implements ShouldQueue
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
     * @param  CancelEvent  $event
     * @return void
     */
    public function handle(CancelEvent $event)
    {
        try{
            DB::beginTransaction();

            \Mail::to(['contract@ariyabod.af','finance@ariyabod.af','support@ariyabod.af',
                    'sales@ariyabod.af'])
            ->cc(['baratian@ariyabod.af','ceo@ariyabod.af','soroosh@ariyabod.af'])
            ->send(new \App\Mail\nocCancelEventMail($event->customer));
                       
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
    }
}
