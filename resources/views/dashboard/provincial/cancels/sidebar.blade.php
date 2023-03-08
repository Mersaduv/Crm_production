<div class="card">

    <div class="card-header">
        <h1 class="text-center">Operation</h1>
    </div> <!-- /card-header -->

    <div class="card-body">
        <button class="btn btn-primary w-100">
            <a href="{{ route('admin.pr.files',$customer->id) }}">
                Attachments
            </a>
        </button>
    </div> <!-- /card-body -->

</div> <!-- /card -->

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