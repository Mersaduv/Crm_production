<?php

namespace App\Listeners;

use App\Events\CancelEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserOperationsNotifications;
use App\Models\User;
use DB;

class nocCancelEventNotificationListener implements ShouldQueue
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
     * @param  CancelEvent  $event
     * @return void
     */
    public function handle(CancelEvent $event)
    {
        try{
            DB::beginTransaction();

            $users = User::where('role','!=','noc')->get();

            Notification::send($users,
             new UserOperationsNotifications($event->customer,"Customer Installation process Cancelled"));

            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
    }
}
