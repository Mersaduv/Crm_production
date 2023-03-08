<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\prNocProcessEvent;
use Mail;
use DB;

class prNocProcessEventListener implements ShouldQueue
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
     * @param  object  $event
     * @return void
     */
    public function handle(prNocProcessEvent $event)
    {
        try{
            DB::beginTransaction();

            \Mail::to(['finance@ariyabod.af','support@ariyabod.af','sales@ariyabod.af'])
            ->cc(['baratian@ariyabod.af','ceo@ariyabod.af','soroosh@ariyabod.af'])
            ->send(new \App\Mail\prNocProcessEventMail($event->customer));
                       
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
    }
}
