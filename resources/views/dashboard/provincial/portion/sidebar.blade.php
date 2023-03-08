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
        <h1 class="text-center">Finance Info</h1>
    </div> <!-- /card-header -->

    <div class="card-body">
        @if($customer->finance_status == 1)

        <div>
            <strong>
                Package Price ({{ $customer->package_price ? $customer->package_price : '0' }} {{
                $customer->package_price_currency }}):
                {{ $payment->package_price ? $payment->package_price : '0' }}
            </strong>
        </div>

        <div>
            <strong>
                Installation ({{ $customer->installation_cost ? $customer->Installation_cost : '0' }} {{
                $customer->Installation_cost_currency }}):
                {{ $payment->Installation_cost ? $payment->Installation_cost : '0' }}
            </strong>
        </div>

        <div>
            <strong>
                Public IP Price ({{ $customer->ip_price ? $customer->ip_price : '0' }} {{ $customer->ip_price_currency
                }}):
                {{ $payment->ip_price ? $payment->ip_price : '0' }}
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