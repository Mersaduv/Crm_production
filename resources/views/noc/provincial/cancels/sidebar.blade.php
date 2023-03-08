<div class="card">
    <div class="card-header">
        <h1 class="text-center">Operation</h1>
    </div>
    <div class="card-body">

        <button class="btn btn-primary w-100 mb-1" type="button">
            <a href="{{ route('pr.noc.attachments',$customer->id) }}">
                Attachment
            </a>
        </button>

        @canany(['create'], ProvincialCancelFullyQualifiedNameSpace())
        @if($customer->cancel_status == 0 && $customer->process_status == 1 && $customer->active_status == 0)
        <button class="btn btn-primary w-100" type="button" data-toggle="modal" data-target="#cancelModal">
            Cancel Installation
        </button>
        @endif
        @endcan

        @canany(['update'], ProvincialCancelFullyQualifiedNameSpace())
        @if($customer->cancel_status == 1)
        @if(
        $customer->prCancel->first()->noc_confirmation &&
        $customer->prCancel->first()->sales_confirmation &&
        $customer->prCancel->first()->finance_confirmation
        )
        <button class="btn btn-primary w-100" type="button" data-toggle="modal" data-target="#cancelModal">
            Rollback Cancel
        </button>
        @endif
        @endif
        @endcan

    </div>
</div>

<div class="card">

    <div class="card-header">
        <h1 class="text-center">Confirmations</h1>
    </div> <!-- /card-header -->

    <div class="card-body">

        <p class="text-center">
            <strong>NOC:</strong>
            @if($customer->prCancel->first()->noc_confirmation)
            {{ $customer->prCancel->first()->noc_confirmation }}
            @else
            Not Confirmed!
            @endif
        </p>

        <p class="text-center">
            <strong>Sales:</strong>
            @if($customer->prCancel->first()->sales_confirmation)
            {{ $customer->prCancel->first()->sales_confirmation }}
            @else
            Not Confirmed!
            @endif
        </p>

        <p class="text-center">
            <strong>Finance:</strong>
            @if($customer->prCancel->first()->finance_confirmation)
            {{ $customer->prCancel->first()->finance_confirmation }}
            @else
            Not Confirmed!
            @endif
        </p>

    </div> <!-- /card-body -->

</div> <!-- /card -->