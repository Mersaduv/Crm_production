<?php

namespace App\Listeners;
use App\Events\nocProcessEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;
use DB;

class nocProcessListener implements ShouldQueue
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
    public function handle(nocProcessEvent $event)
    {
        try{
            DB::beginTransaction();

            \Mail::to(['finance@ariyabod.af','support@ariyabod.af','sales@ariyabod.af'])
            ->cc(['baratian@ariyabod.af','ceo@ariyabod.af','soroosh@ariyabod.af'])
            ->send(new \App\Mail\nocProcessEventMail($event->customer));
                       
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
    }
}
