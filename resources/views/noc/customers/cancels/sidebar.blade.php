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

        @can('create', CancelFullyQualifiedNameSpace())
        @if($customer->cancel_status == 0 && $customer->noc_status == 1 && $customer->active_status == 0)
        <button class="btn btn-primary w-100" type="button" data-toggle="modal" data-target="#cancelModal">
            Cancel Installation
        </button>
        @endif
        @endcan

        @can('update', CancelFullyQualifiedNameSpace())
        @if($customer->cancel_status == 1)
        @if(
        $customer->cancel->first()->noc_confirmation &&
        $customer->cancel->first()->sales_confirmation &&
        $customer->cancel->first()->finance_confirmation
        )
        <button class="btn btn-primary w-100" type="button" data-toggle="modal" data-target="#cancelModal">
            Rollback Cancel
        </button>
        @endif
        @endif
        @endcan

    </div> <!-- /card-body -->

</div> <!-- /card -->

<div class="card">

    <div class="card-header">
        <h1 class="text-center">Confirmations</h1>
    </div> <!-- /card-header -->

    <div class="card-body">

        <p class="text-center">
            <strong>NOC:</strong>
            @if($customer->cancel->first()->noc_confirmation)
            {{ $customer->cancel->first()->noc_confirmation }}
            @else
            Not Confirmed!
            @endif
        </p>

        <p class="text-center">
            <strong>Sales:</strong>
            @if($customer->cancel->first()->sales_confirmation)
            {{ $customer->cancel->first()->sales_confirmation }}
            @else
            Not Confirmed!
            @endif
        </p>

        <p class="text-center">
            <strong>Finance:</strong>
            @if($customer->cancel->first()->finance_confirmation)
            {{ $customer->cancel->first()->finance_confirmation }}
            @else
            Not Confirmed!
            @endif
        </p>

    </div> <!-- /card-body -->

</div> <!-- /card -->