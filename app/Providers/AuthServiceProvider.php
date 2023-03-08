<?php

namespace App\Providers;

use App\Models\NOC;
use App\Models\PrAmend;
use App\Models\PrCancel;
use App\Models\PrCancelAmend;
use App\Models\PrNocInfo;
use App\Models\PrPayment;
use App\Models\PrReactivate;
use App\Models\PrRecontract;
use App\Models\PrSuspend;
use App\Models\PrTerminate;
use App\Policies\NocPolicy;
use App\Policies\ProvincialAmendmentPolicy;
use App\Policies\ProvincialCancelAmendmentPolicy;
use App\Policies\ProvincialCancelPolicy;
use App\Policies\ProvincialNocPolicy;
use App\Policies\ProvincialPaymentPolicy;
use App\Policies\ProvincialReactivatePolicy;
use App\Policies\ProvincialRecontractPolicy;
use App\Policies\ProvincialSuspendPolicy;
use App\Policies\ProvincialTerminatePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        PrTerminate::class => ProvincialTerminatePolicy::class,
        PrRecontract::class => ProvincialRecontractPolicy::class,
        PrSuspend::class => ProvincialSuspendPolicy::class,
        PrReactivate::class => ProvincialReactivatePolicy::class,
        PrAmend::class => ProvincialAmendmentPolicy::class,
        PrCancelAmend::class => ProvincialCancelAmendmentPolicy::class,
        PrCancel::class => ProvincialCancelPolicy::class,
        NOC::class => NocPolicy::class,
        PrNocInfo::class => ProvincialNocPolicy::class,
        PrPayment::class => ProvincialPaymentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
