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

</div> <!-- /card -->

<div class="card">

    <div class="card-header">
        <h1 class="text-center">Finance Info</h1>
    </div> <!-- /card-header -->

    <div class="card-body">
        @if($customer->finance_status == 1)

        <div>
            <strong>
                Installation ({{ $customer->sale->Installation_cost }} {{ $customer->sale->Installation_cost_currency
                }}):
                {{ $customer->payment->Installation_cost }}
            </strong>
        </div>

        <div>
            <strong>
                Package Price ({{ $customer->sale->package_price }} {{ $customer->sale->package_price_currency }}):
                {{ $customer->payment->package_price }}
            </strong>
        </div>

        <div>
            <strong>
                Receiver Price ({{ $customer->sale->receiver_price }} {{ $customer->sale->receiver_price_currency }}):
                {{ $customer->payment->receiver_price}}
            </strong>
        </div>

        <div>
            <strong>
                Router Price ({{ $customer->sale->router_price }} {{ $customer->sale->router_price_currency }}): {{
                $customer->payment->router_price }}
            </strong>
        </div>

        <div>
            <strong>
                Cable Price ({{ $customer->sale->cable_price }} {{ $customer->sale->cable_price_currency }}): {{
                $customer->payment->cable_price }}
            </strong>
        </div>

        <div>
            <strong>
                Public IP Price ({{ $customer->sale->ip_price }} {{ $customer->sale->ip_price_currency }}): {{
                $customer->payment->ip_price }}
            </strong>
        </div>

        @else
        <p class="text-center">
            <strong>
                Finance payment is not updated...
            </strong>
        </p>
        @endif
    </div> <!-- /card-body -->

</div> <!-- /card -->