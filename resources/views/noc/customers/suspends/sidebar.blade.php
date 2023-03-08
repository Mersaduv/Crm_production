<div class="card">

    <div class="card-header">
        <h1 class="text-center">Operation</h1>
    </div> <!-- /card-header -->

    <div class="card-body">

        <button class="btn btn-primary w-100 mb-1" type="button">
            <a href="{{ route('noc.attachment',$customer->id) }}">
                Attachment
            </a>
        </button>


        @if(
        $customer->suspend->first()->sales_confirmation &&
        $customer->suspend->first()->noc_confirmation &&
        $customer->suspend->first()->finance_confirmation
        )
        @can('create',ReactivateFullyQualifiedNameSpace())
        <button class="btn btn-primary w-100 mb-1" type="button">
            <a href="{{ route('noc.activateForm',$customer->id) }}">
                Re-Activate
            </a>
        </button>
        @endcan
        @endif

        @if(
        !$customer->suspend->first()->finance_confirmation &&
        !$customer->suspend->first()->sales_confirmation
        )
        @can('update',SuspendFullyQualifiedNameSpace())
        <button class="btn btn-primary w-100 mb-1" type="button" data-toggle="modal" data-target="#editSuspend">
            Edit Suspend
        </button>
        @endcan
        @can('delete',SuspendFullyQualifiedNameSpace())
        <button class="btn btn-danger w-100 mb-1" type="button" data-toggle="modal" data-target="#deleteSuspend">
            Delete Suspend
        </button>
        @endcan
        @endif



        @if($customer->suspend->first()->noc_confirmation)
        <button class="btn btn-success w-100" type="button">
            Confirmed
        </button>
        @else
        <button class="btn btn-primary w-100 confirm_btn" type="button">
            Confirm Suspend
        </button>
        @endif

    </div> <!-- /card-body -->

</div> <!-- /card -->

<div class="card">

    <div class="card-header">
        <h1 class="text-center">Confirmations</h1>
    </div> <!-- /card-header -->

    <div class="card-body">

        <p class="text-center">
            <strong>NOC:</strong>
            @if($customer->suspend->first()->noc_confirmation)
            {{ $customer->suspend->first()->noc_confirmation }}
            @else
            Not Confirmed!
            @endif
        </p>

        <p class="text-center">
            <strong>Finance:</strong>
            @if($customer->suspend->first()->finance_confirmation)
            {{ $customer->suspend->first()->finance_confirmation }}
            @else
            Not Confirmed!
            @endif
        </p>

        <p class="text-center">
            <strong>Sales:</strong>
            @if($customer->suspend->first()->sales_confirmation)
            {{ $customer->suspend->first()->sales_confirmation }}
            @else
            Not Confirmed!
            @endif
        </p>

    </div> <!-- /card-body -->
</div> <!-- /card -->