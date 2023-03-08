<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\prProcessEvent;
use App\Listeners\PrProcessEventListener;
use App\Listeners\PrProcessNotificationListener;
use App\Events\prAmendmentEvent;
use App\Listeners\prAmendmentListener;
use App\Listeners\prAmendmentNotificationListener;
use App\Events\prSalesSuspend;
use App\Listeners\prSalesSuspendListener;
use App\Listeners\PrSalesSuspendNotificationListener;
use App\Events\prTerminateEvent;
use App\Listeners\prTerminateListener;
use App\Listeners\PrTerminateNotificationListener;
use App\Events\prNocSuspend;
use App\Listeners\prNocSuspendListener;
use App\Listeners\prNocSuspendNotificationListener;
use App\Events\prFinanceSuspend;
use App\Listeners\prFinanceSuspendListener;
use App\Listeners\prFinanceSuspendNotificationListener;
use App\Events\prNocCancel;
use App\Listeners\prNocCancelListener;
use App\Listeners\prNocCancelNotificationListener;
use App\Events\processEvent;
use App\Listeners\processEventListener;
use App\Listeners\processEventNotificationListener;
use App\Events\amendmentEvent;
use App\Listeners\amendmentEventListener;
use App\Listeners\amendmentEventNotificationListener;
use App\Events\suspendEvent;
use App\Listeners\suspendEventListener;
use App\Listeners\suspendEventNotificationListener;
use App\Events\terminateEvent;
use App\Listeners\terminateEventListener;
use App\Listeners\terminateEventNotificationListener;
use App\Events\financeSuspendEvent;
use App\Listeners\financeSuspendEventListener;
use App\Listeners\financeSuspendNotificationListener;
use App\Events\nocSuspendEvent;
use App\Listeners\noSuspendEventListener;
use App\Listeners\nocSuspendNotificationListener;
use App\Events\CancelEvent;
use App\Listeners\noCancelEventListener;
use App\Listeners\nocCancelEventNotificationListener;
use App\Events\prActivatingEvent;
use App\Listeners\prActivatingEventNotificationListener;
use App\Listeners\prActivationEventMailListener;
use App\Events\prContractionEvent;
use App\Listeners\prContractionEventNotificationListener;
use App\Listeners\prContractionEventMailListener;
use App\Events\prFinanceActivatingEvent;
use App\Listeners\prFinanceActivatingNotificationListener;
use App\Listeners\prFinanceActivatingMailListener;
use App\Events\prNocActivatingEvent;
use App\Listeners\prNocActivatingNotificationListener;
use App\Listeners\prNocActivatingMailListener;
use App\Events\customerReactivateEvent;
use App\Listeners\customerReactivateEventListener;
use App\Listeners\customerReactivateNotificationListener;
use App\Events\customerContractionEvent;
use App\Listeners\customerContractionListener;
use App\Listeners\customerContractionNotificationListener;
use App\Events\financeActivateEvent;
use App\Listeners\financeActivateEventListener;
use App\Listeners\financeActivateEventNotificationListener;
use App\Events\nocActivateEvent;
use App\Listeners\nocActivateListener;
use App\Listeners\nocActivateNotificationListener;
use App\Events\requestEvent;
use App\Listeners\requestEventNotificationListener;
use App\Events\prTrRequestEvent;
use App\Listeners\prRequestEventNotificationListener;
use App\Events\nocProcessEvent;
use App\Listeners\nocProcessListener;
use App\Listeners\nocProcessNotificationListener;
use App\Events\cancelAmendmentEvent;
use App\Listeners\cancelAmendmentEventListener;
use App\Listeners\cancelAmendmentNotificationListener;
use App\Events\cancelPrAmendment;
use App\Listeners\cancelPrAmendmentListener;
use App\Listeners\cancelPrAmendmentNotificationListener;
use App\Events\prNocProcessEvent;
use App\Listeners\prNocProcessEventListener;
use App\Listeners\prNocProceessEventNotificationListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        prProcessEvent::class => [
            PrProcessEventListener::class,
            PrProcessNotificationListener::class
        ],
        prAmendmentEvent::class => [
            prAmendmentListener::class,
            prAmendmentNotificationListener::class,
        ],
        prSalesSuspend::class => [
            prSalesSuspendListener::class,
            PrSalesSuspendNotificationListener::class
        ],
        prTerminateEvent::class => [
            prTerminateListener::class,
            PrTerminateNotificationListener::class
        ],
        prNocSuspend::class => [
            prNocSuspendListener::class,
            prNocSuspendNotificationListener::class,
        ],
        prFinanceSuspend::class => [
            prFinanceSuspendListener::class,
            prFinanceSuspendNotificationListener::class,
        ],
        prNocCancel::class => [
            prNocCancelListener::class,
            prNocCancelNotificationListener::class,
        ],
         processEvent::class => [
            processEventListener::class,
            processEventNotificationListener::class
        ],
        amendmentEvent::class => [
            amendmentEventListener::class,
            amendmentEventNotificationListener::class,
        ],
        suspendEvent::class => [
            suspendEventListener::class,
            suspendEventNotificationListener::class,
        ],
        terminateEvent::class => [
            terminateEventListener::class,
            terminateEventNotificationListener::class,
        ],
        financeSuspendEvent::class => [
            financeSuspendEventListener::class,
            financeSuspendNotificationListener::class,
        ],
        nocSuspendEvent::class => [
            noSuspendEventListener::class,
            nocSuspendNotificationListener::class,
        ],
        CancelEvent::class => [
            noCancelEventListener::class,
            nocCancelEventNotificationListener::class,
        ],
        prActivatingEvent::class => [
            prActivatingEventNotificationListener::class,
            prActivationEventMailListener::class
        ],
        prContractionEvent::class => [
            prContractionEventNotificationListener::class,
            prContractionEventMailListener::class
        ],
        prFinanceActivatingEvent::class => [
            prFinanceActivatingNotificationListener::class,
            prFinanceActivatingMailListener::class
        ],
        prNocActivatingEvent::class => [
            prNocActivatingNotificationListener::class,
            prNocActivatingMailListener::class
        ],
        customerReactivateEvent::class => [
            customerReactivateEventListener::class,
            customerReactivateNotificationListener::class
        ],
        customerContractionEvent::class => [
            customerContractionListener::class,
            customerContractionNotificationListener::class
        ],
        financeActivateEvent::class => [
            financeActivateEventListener::class,
            financeActivateEventNotificationListener::class
        ],
        nocActivateEvent::class => [
            nocActivateListener::class,
            nocActivateNotificationListener::class
        ],
        requestEvent::class => [
            requestEventNotificationListener::class
        ],
        prTrRequestEvent::class => [
            prRequestEventNotificationListener::class
        ],
        nocProcessEvent::class => [
            nocProcessListener::class,
            nocProcessNotificationListener::class
        ],
        cancelAmendmentEvent::class => [
            cancelAmendmentEventListener::class,
            cancelAmendmentNotificationListener::class
        ],
        cancelPrAmendment::class => [
            cancelPrAmendmentListener::class,
            cancelPrAmendmentNotificationListener::class
        ],
        prNocProcessEvent::class => [
            prNocProcessEventListener::class,
            prNocProceessEventNotificationListener::class
        ]
    ];
    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
