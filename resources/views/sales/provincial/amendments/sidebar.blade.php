<div class="card">

    <div class="card-header">
        <h1 class="text-center">Operation</h1>
    </div> <!-- /card-header -->

    <div class="card-body">

        <button class="btn btn-primary w-100 mb-1" type="button">
            <a href="{{ route('pr.sales.attachments',$customer->provincial->id) }}">
                Attachment
            </a>
        </button>

        <button class="btn btn-secondary w-100 mb-1" type="button">
            <a href="{{ route('printPrAmendment',['id' => $customer->id]) }}">
                Print
            </a>
        </button>

        @can('update',ProvincialAmendmentFullyQualifiedNameSpace())
        @if(!$customer->finance_confirmation && !$customer->noc_confirmation) )
        <button class="btn btn-primary w-100 mb-1" type="button">
            <a href="{{ route('pr.amedment.edit',$customer->id) }}">
                Edit
            </a>
        </button>
        @endif
        @endcan

        @can('delete',ProvincialAmendmentFullyQualifiedNameSpace())
        <button class="btn btn-danger w-100 mb-1" type="button" data-toggle="modal" data-target="#delete">
            Delete
        </button>
        @endcan

    </div> <!-- /card-body -->

</div> <!-- /card -->

<div class="card">

    <div class="card-header">
        <h1 class="text-center">Confirmations</h1>
    </div> <!-- /card-header -->

    <div class="card-body">

        <p class="text-center">
            <strong>Sales:</strong>
            @if($customer->sales_confirmation)
            {{ $customer->sales_confirmation }}
            @else
            Not Confirmed!
            @endif
        </p>

        <p class="text-center">
            <strong>NOC:</strong>
            @if($customer->noc_confirmation)
            {{ $customer->noc_confirmation }}
            @else
            Not Confirmed!
            @endif
        </p>

        <p class="text-center">
            <strong>Finance:</strong>
            @if($customer->finance_confirmation)
            {{ $customer->finance_confirmation }}
            @else
            Not Confirmed!
            @endif
        </p>

    </div> <!-- /card-body -->

</div> <!-- /card -->