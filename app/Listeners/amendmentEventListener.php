<?php

namespace App\Listeners;

use App\Events\amendmentEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Mail;
use DB;

class amendmentEventListener implements ShouldQueue
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
     * @param  amedmentEvent  $event
     * @return void
     */
    public function handle(amendmentEvent $event)
    {
        try{
            DB::beginTransaction();

            \Mail::to(['installation@ariyabod.af','finance@ariyabod.af','support@ariyabod.af'])
            ->cc(['baratian@ariyabod.af','ceo@ariyabod.af','soroosh@ariyabod.af'])
            ->send(new \App\Mail\amendmentEventMail($event->customer)); 
                       
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
    }
}
