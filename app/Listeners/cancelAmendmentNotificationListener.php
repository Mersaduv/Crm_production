<?php

namespace App\Listeners;

use App\Events\cancelAmendmentEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserOperationsNotifications;
use App\Models\CancelAmend;
use App\Models\User;
use DB;

class cancelAmendmentNotificationListener implements ShouldQueue
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
    public function handle(cancelAmendmentEvent $event)
    {
        try{
            DB::beginTransaction();

            $users = User::whereNull('deleted_at')->get();

            Notification::send($users, new UserOperationsNotifications($event->customer,"The Amendment Process Canceled"));

            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
    }
}
