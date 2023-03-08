<?php

namespace App\Listeners;

use App\Events\financeActivateEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;
use DB;

class financeActivateEventListener implements ShouldQueue
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
     * @param  financeActivateEvent  $event
     * @return void
     */
    public function handle(financeActivateEvent $event)
    {
        try{
            DB::beginTransaction();

            \Mail::to(['support@ariyabod.af','installation@ariyabod.af','sales@ariyabod.af'])
            ->cc(['baratian@ariyabod.af','ceo@ariyabod.af','soroosh@ariyabod.af'])
            ->send(new \App\Mail\customerFinanceReActivationMail($event->customer));
                       
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
    }
}
