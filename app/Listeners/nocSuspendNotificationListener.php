<?php

namespace App\Listeners;

use App\Events\nocSuspendEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserOperationsNotifications;
use App\Models\User;
use DB;

class nocSuspendNotificationListener implements ShouldQueue
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
     * @param  nocSuspendEvent  $event
     * @return void
     */
    public function handle(nocSuspendEvent $event)
    {
        try{
            DB::beginTransaction();

            $users = User::where('role','!=','noc')->get();

            Notification::send($users,
                    new UserOperationsNotifications($event->customer,"New Customer Suspend"));

            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
    }
}
