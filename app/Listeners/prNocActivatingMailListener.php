<?php

namespace App\Listeners;

use App\Events\prNocActivatingEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;
use DB;

class prNocActivatingMailListener implements ShouldQueue
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
     * @param  prNocActivatingEvent  $event
     * @return void
     */
    public function handle(prNocActivatingEvent $event)
    {
        try{
            DB::beginTransaction();

            \Mail::to(['sales@ariyabod.af','finance@ariyabod.af','support@ariyabod.af'])
            ->cc(['baratian@ariyabod.af','ceo@ariyabod.af','soroosh@ariyabod.af'])
            ->send(new \App\Mail\prCustomerNocReactivationMail($event->customer));

            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
    }
}
