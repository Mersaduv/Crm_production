<?php

namespace App\Listeners;

use App\Events\nocProcessEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserOperationsNotifications;
use App\Models\User;
use DB;

class nocProcessNotificationListener implements ShouldQueue
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
     * @param  object  $event
     * @return void
     */
    public function handle(nocProcessEvent $event)
    {
        try{
            DB::beginTransaction();

            $users = User::where('role','!=','noc')->get();

            Notification::send($users,
            new UserOperationsNotifications($event->customer,"New Customer has been proceed"));

            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
    }
}
