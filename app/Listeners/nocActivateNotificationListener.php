<?php

namespace App\Listeners;

use App\Events\nocActivateEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserOperationsNotifications;
use App\Models\User;
use DB;

class nocActivateNotificationListener implements ShouldQueue
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

            $users = User::where('role','!=','noc')->get();

            Notification::send($users,
                    new UserOperationsNotifications($event->customer,"Suspend Customer Activated"));

            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
    }
}
