<?php

namespace App\Listeners;

use App\Events\prFinanceSuspend;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Models\Provincial;
use Mail;
use DB;

class prFinanceSuspendListener implements ShouldQueue
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
     * @param  prFinanceSuspend  $event
     * @return void
     */
    public function handle(prFinanceSuspend $event)
    {
        try{
            DB::beginTransaction();

            \Mail::to(['support@ariyabod.af','installation@ariyabod.af','sales@ariyabod.af'])
            ->cc(['baratian@ariyabod.af','ceo@ariyabod.af','soroosh@ariyabod.af'])
            ->send(new \App\Mail\prFinanceSuspendMail($event->customer));
                  
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
    }
}
