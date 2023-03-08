<div class="card">
    <div class="card-header">
        <h1 class="text-center">Operation</h1>
    </div>
    <div class="card-body">
        <button class="btn btn-primary w-100 mb-1" type="button">
            <a href="{{ route('pr.sales.attachments', $customer->id) }}">
                Attachment
            </a>
        </button>

        @can('create', ProvincialRecontractFullyQualifiedNameSpace())
        @if ($customer->terminate->first()->sales_confirmation &&
        $customer->terminate->first()->noc_confirmation &&
        $customer->terminate->first()->finance_confirmation &&
        $recontract == null)
        <button class="btn btn-primary w-100" type="button">
            <a href="{{ route('pr.recontract', $customer->id) }}">
                Re-contract
            </a>
        </button>
        @endif
        @endcan


        @if (!$customer->terminate->first()->noc_confirmation && !$customer->terminate->first()->finance_confirmation)
        @can('update', ProvincialTerminateFullyQualifiedNameSpace())
        <button class="btn btn-primary w-100 mb-1" type="button" data-toggle="modal" data-target="#editTerminate">
            Edit Terminate
        </button>
        @endcan
        @can('delete', ProvincialTerminateFullyQualifiedNameSpace())
        <button class="btn btn-danger w-100 mb-1" type="button" data-toggle="modal" data-target="#deleteTerminate">
            Delete Terminate
        </button>
        @endcan
        @endif

    </div>
</div>

<div class="card">

    <div class="card-header">
        <h1 class="text-center">Confirmations</h1>
    </div> <!-- /card-header -->

    <div class="card-body">

        <p class="text-center">
            <strong>Sales:</strong>
            @if ($customer->terminate->first()->sales_confirmation)
            {{ $customer->terminate->first()->sales_confirmation }}
            @else
            Not Confirmed!
            @endif
        </p>

        <p class="text-center">
            <strong>NOC:</strong>
            @if ($customer->terminate->first()->noc_confirmation)
            {{ $customer->terminate->first()->noc_confirmation }}
            @else
            Not Confirmed!
            @endif
        </p>

        <p class="text-center">
            <strong>Finance:</strong>
            @if ($customer->terminate->first()->finance_confirmation)
            {{ $customer->terminate->first()->finance_confirmation }}
            @else
            Not Confirmed!
            @endif
        </p>

    </div> <!-- /card-body -->

</div> <!-- /card -->