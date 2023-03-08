<?php

namespace App\Listeners;

use App\Events\prNocSuspend;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Provincial;
use Mail;
use DB;

class prNocSuspendListener implements ShouldQueue
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
     * @param  prNocSuspend  $event
     * @return void
     */
    public function handle(prNocSuspend $event)
    {
        try{
            DB::beginTransaction();

            \Mail::to(['finance@ariyabod.af','support@ariyabod.af','sales@ariyabod.af'])
            ->cc(['baratian@ariyabod.af','ceo@ariyabod.af','soroosh@ariyabod.af'])
            ->send(new \App\Mail\prNocSuspendMail($event->customer));  
                       
            DB::commit();
        }catch(Exception $e){
            DB::rollback(); 
        }
    }
}
