<?php

namespace App\Listeners;

use App\Events\cancelAmendmentEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\CancelAmend;
use Mail;
use DB;

class cancelAmendmentEventListener implements ShouldQueue
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
    public function handle(cancelAmendmentEvent $event)
    {
        try{
            DB::beginTransaction();

            \Mail::to(['installation@ariyabod.af','finance@ariyabod.af','support@ariyabod.af','sales@ariyabod.af'])
            ->cc(['baratian@ariyabod.af','ceo@ariyabod.af','soroosh@ariyabod.af'])
            ->send(new \App\Mail\cancelAmendmentMailListener($event->customer)); 
                       
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
    }
}
