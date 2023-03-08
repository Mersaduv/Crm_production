<?php

namespace App\Listeners;

use App\Events\requestEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserOperationsNotifications;
use App\Models\User;
use DB;

class requestEventNotificationListener implements ShouldQueue
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
     * @param  requestEvent  $event
     * @return void
     */
    public function handle(requestEvent $event)
    {
        try{
            DB::beginTransaction();

            $users = User::where('role','=','sales')->get();

            Notification::send($users,
                    new UserOperationsNotifications($event->customer,"Customer Termination Request"));

            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
    }
}
