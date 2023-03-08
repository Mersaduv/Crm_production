<?php

namespace App\Listeners;

use App\Events\prFinanceActivatingEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserOperationsNotifications;
use App\Models\User;
use DB;

class prFinanceActivatingNotificationListener implements ShouldQueue
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
     * @param  prFinanceActivatingEvent  $event
     * @return void
     */
    public function handle(prFinanceActivatingEvent $event)
    {
        try{
            DB::beginTransaction();

            $users = User::where('role','!=','finance')->get();

            Notification::send($users,
                    new UserOperationsNotifications($event->customer,"Suspend Customer Activated"));

            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
    }
}
