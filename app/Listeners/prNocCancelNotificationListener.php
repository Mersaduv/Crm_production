<?php

namespace App\Listeners;

use App\Events\prNocCancel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserOperationsNotifications;
use App\Models\User;
use DB;

class prNocCancelNotificationListener implements ShouldQueue
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
     * @param  prNocCancel  $event
     * @return void
     */
    public function handle(prNocCancel $event)
    {
        try{
            DB::beginTransaction();

            $users = User::where('role','!=','noc')->get();

            Notification::send($users,
                new UserOperationsNotifications($event->customer,"Customer Installation Cancelled"));

            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
    }
}
