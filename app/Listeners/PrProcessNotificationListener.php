<?php

namespace App\Listeners;

use App\Events\prProcessEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserOperationsNotifications;
use App\Models\User;
use DB;

class PrProcessNotificationListener implements ShouldQueue
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
     * @param  prProcessEvent  $event
     * @return void
     */
    public function handle(prProcessEvent $event)
    {
        try{
            DB::beginTransaction();

            $users = User::where('role','!=','sales')->get();

            Notification::send($users,
                          new UserOperationsNotifications($event->customer,"New Customer Process"));

            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
    }
}
