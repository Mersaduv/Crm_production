@if($customer->PrNocInfo()->exists())
<table class="table table-striped">
    <tbody>
        <tr>
            <th>Activation Date</th>
            <td>
                {{ Carbon\Carbon::parse($customer->PrNocInfo->activation_date)->format('Y-m-d') }}
            </td>
        </tr>
        <tr>
            <th>Latitude</th>
            <td>{{ $customer->PrNocInfo->latitiude ? $customer->PrNocInfo->latitiude : 'NA' }}</td>
        </tr>
        <tr>
            <th>Longitude</th>
            <td>{{ $customer->PrNocInfo->longitude ? $customer->PrNocInfo->longitude : 'NA' }}</td>
        </tr>
        <tr>
            <th>Additional Fee Reason</th>
            <td>
                {{ $customer->PrNocInfo->additional_fee }}
            </td>
        </tr>
        <tr>
            <th>Additional Fee Price</th>
            <td>
                {{ $customer->PrNocInfo->additional_fee_price }}
                {{ $customer->PrNocInfo->additional_fee_currency }}
            </td>
        </tr>
        <tr>
            <th>Created At:</th>
            <td>
                {{ $customer->PrNocInfo->created_at }}
            </td>
        </tr>
        <tr>
            <th>Created By:</th>
            <td>
                {{ $customer->PrNocInfo->user->name }}
            </td>
        </tr>    
    </tbody>
</table>
@else
<table class="table">
    <thead>
        <tr>
            <th><h1>Customer is not active</h1></th>
        </tr>
    </thead>
</table>
@endif