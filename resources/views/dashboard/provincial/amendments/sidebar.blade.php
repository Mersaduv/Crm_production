<div class="card">

    <div class="card-header">
        <h1 class="text-center">Operation</h1>
    </div>

    <div class="card-body">
        <button class="btn btn-primary w-100">
            <a href="{{ route('admin.pr.files',$customer->provincial->id) }}">
                Attachments
            </a>
        </button>
    </div>

</div>

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