<?php

namespace App\Listeners;

use App\Events\prFinanceActivatingEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;
use DB;

class prFinanceActivatingMailListener implements ShouldQueue
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
     * @param  prFinanceActivatingEvent  $event
     * @return void
     */
    public function handle(prFinanceActivatingEvent $event)
    {
        try{
            DB::beginTransaction();

            \Mail::to(['support@ariyabod.af','installation@ariyabod.af','sales@ariyabod.af'])
            ->cc(['baratian@ariyabod.af','ceo@ariyabod.af','soroosh@ariyabod.af'])
            ->send(new \App\Mail\prCustomerFinanceReactivationMail($event->customer));
                  
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
    }
}
