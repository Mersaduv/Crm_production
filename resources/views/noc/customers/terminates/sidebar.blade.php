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

        @if($customer->terminate->first()->noc_confirmation)
        <button class="btn btn-success w-100" type="button">
            Confirmed
        </button>
        @else
        <button class="btn btn-primary w-100 confirm_btn" type="button">
            Confirm Terminate
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