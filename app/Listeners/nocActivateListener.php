<?php

namespace App\Listeners;

use App\Events\nocActivateEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;
use DB;

class nocActivateListener implements ShouldQueue
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
     * @param  nocActivateEvent  $event
     * @return void
     */
    public function handle(nocActivateEvent $event)
    {
        try{
            DB::beginTransaction();

            \Mail::to(['sales@ariyabod.af','finance@ariyabod.af','support@ariyabod.af'])
            ->cc(['baratian@ariyabod.af','ceo@ariyabod.af','soroosh@ariyabod.af'])
            ->send(new \App\Mail\customerNocReActivationMail($event->customer)); 
                       
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
    }
}
