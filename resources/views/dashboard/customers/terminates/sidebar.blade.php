<div class="card">

    <div class="card-header">
        <h1 class="text-center">Operation</h1>
    </div> <!-- /card-header -->

    <div class="card-body">
        <button class="btn btn-primary w-100">
            <a href="{{ route('admin.files',$customer->id) }}">
                Attachments
            </a>
        </button>
    </div> <!-- /card-body -->

</div>

<div class="card">

    <div class="card-header">
        <h1 class="text-center">Confirmations</h1>
    </div> <!-- /card-header -->

    <div class="card-body">

        <p class="text-center">
            <strong>NOC:</strong>
            @if($customer->terminate->first()->noc_confirmation)
            {{ $customer->terminate->first()->noc_confirmation }}
            @else
            Not Confirmed!
            @endif
        </p>

        <p class="text-center">
            <strong>Finance:</strong>
            @if($customer->terminate->first()->finance_confirmation)
            {{ $customer->terminate->first()->finance_confirmation }}
            @else
            Not Confirmed!
            @endif
        </p>

        <p class="text-center">
            <strong>Sales:</strong>
            @if($customer->terminate->first()->sales_confirmation)
            {{ $customer->terminate->first()->sales_confirmation }}
            @else
            Not Confirmed!
            @endif
        </p>

    </div> <!-- /card-body -->
</div> <!-- /card -->