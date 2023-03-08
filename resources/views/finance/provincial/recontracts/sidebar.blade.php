<div class="card">

    <div class="card-header">
        <h1 class="text-center">Operation</h1>
    </div> <!-- /card-header -->

    <div class="card-body">

        @if($customer->finance_confirmation)
            <button class="btn btn-success w-100" type="button">
                Confirmed
            </button>
        @else
            <button class="btn btn-primary w-100 confirm_btn" type="button">
                Confirm Recontraction
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
            <strong>Finance:</strong>
            @if($customer->finance_confirmation)
                {{ $customer->finance_confirmation }}
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
            <strong>Sales:</strong>
            @if($customer->sales_confirmation)
                {{ $customer->sales_confirmation }}
            @else
                Not Confirmed!
            @endif
        </p>

    </div> <!-- /card-body -->
</div> <!-- /card -->