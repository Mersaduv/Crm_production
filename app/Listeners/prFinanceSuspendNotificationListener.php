<?php

namespace App\Listeners;

use App\Events\prFinanceSuspend;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserOperationsNotifications;
use App\Models\User;
use DB;

class prFinanceSuspendNotificationListener implements ShouldQueue
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

            $users = User::where('role','!=','finance')->get();

            Notification::send($users,
                          new UserOperationsNotifications($event->customer,"New Customer Suspend"));

            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
    }
}
