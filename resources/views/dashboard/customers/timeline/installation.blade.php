@if($customer)
<table class="table table-striped">
    <tbody>
        <tr>
            <th>Customer ID:</th>
            <td>{{ $customer->customer_id }}</td>
        </tr>
        <tr>
            <th>Full Name:</th>
            <td>{{ $customer->full_name }}</td>
        </tr>
        <tr>
            <th>POC:</th>
            <td>{{ $customer->poc }}</td>
        </tr>
        <tr>
            <th>Phone:</th>
            <td>
                {{ $customer->phone1 }}
                -
                {{ $customer->phone2 }}
            </td>
        </tr>
        <tr>
            <th>Education:</th>
            <td>{{ $customer->education }}</td>
        </tr>
        <tr>
            <th>Identity Number:</th>
            <td>{{ $customer->identity_num }}</td>
        </tr>
        <tr>
            <th>Branch:</th>
            <td>{{ $customer->branch->name }}</td>
        </tr>
        <tr>
            <th>Address:</th>
            <td>{{ $customer->address }}</td>
        </tr>
        <tr>
            <th>Package:</th>
            <td>
                @if($customer->sale->package)
                    {{ $customer->sale->package->name }}
                @else
                    NA
                @endif
            </td>
        </tr>
        <tr class="price">
            <th>Package Price:</th>
            <td>
                @if($customer->sale->package_price)
                    <span>
                        {{ $customer->sale->package_price }}
                    </span>
                    <span>
                        {{ $customer->sale->package_price_currency }}
                    </span> 
                @else
                    NA
                @endif
            </td>
        </tr>
        <tr>
            <th>Reseller Name</th>
            <td>
                @if($customer->sale->commission)
                    {{ $customer->sale->commission->name }}
                @else
                    NA
                @endif
            </td>
        </tr>
        <tr>
            <th>Reseller Percentage</th>
            <td>
                <span>
                    {{ $customer->sale->commission_percent ."%" }}
                </span>
            </td>
        </tr>
        <tr class="discount">
            <th>Discount:</th>
            <td>
                @if($customer->sale->discount)
                    <span>
                        {{ $customer->sale->discount }}
                    </span>
                    <span>
                        {{ $customer->sale->discount_currency }}
                    </span>
                @else
                    NA
                @endif
            </td>
        </tr>
        <tr>
            <th>Discount Period:</th>
            <td>
            @if($customer->sale->discount_period)
                {{ $customer->sale->discount_period }}
                {{ $customer->sale->discount_period_currency }}
            @else
                NA
            @endif
            </td>
        </tr>
        <tr>
            <th>Discount Reason:</th>
            <td>
            @if($customer->sale->discount_reason)
                {{ $customer->sale->discount_reason }}
            @else
                NA
            @endif
            </td>
        </tr>
        <tr>
            <th>Equipment Possession:</th>
            <td>{{ $customer->sale->equi_type }}</td>
        </tr>
        <tr>
            <th>Leased Type:</th>
            <td>
                @if($customer->sale->leased_type)
                    {{ $customer->sale->leased_type }}
                @else 
                    NA
                @endif
            </td>
        </tr>
        <tr>
            <th>Receiver Type:</th>
            <td>{{ $customer->sale->receiver_type }}</td>
        </tr>
        <tr class="price">
            <th>Receiver Price:</th>
            <td>
                @if($customer->sale->receiver_price)
                    <span>
                        {{ $customer->sale->receiver_price }}
                    </span>
                    <span>
                        {{ $customer->sale->receiver_price_currency }}
                    </span>
                @else 
                    NA
                @endif
            </td>
        </tr>
        <tr>
            <th>Router Type:</th>
            <td>
                @if($customer->sale->router_type)
                    {{ $customer->sale->router_type }}
                @else 
                    NA
                @endif
            </td>
        </tr>
        <tr class="price"> 
            <th>Router Price:</th>
            <td>
                @if($customer->sale->router_price)
                    <span>
                        {{ $customer->sale->router_price }}
                    </span>
                    <span>
                        {{ $customer->sale->router_price_currency }}
                    </span>
                @else 
                    NA
                @endif
            </td>
        </tr>
        <tr>
            <th>Cable Price:</th>
            <td>
                <span>
                    {{ $customer->sale->cable_price }}
                </span>
                <span>
                    {{ $customer->sale->cable_price_currency }}
                </span>
            </td>
        </tr>
        <tr class="price">
            <th>Installation Cost:</th>
            <td>
                @if($customer->sale->Installation_cost)
                    <span>
                        {{ $customer->sale->Installation_cost }}
                    </span>
                    <span>
                        {{ $customer->sale->Installation_cost_currency }}
                    </span>

                @else
                    NA
                @endif
            </td>
        </tr>
        <tr>
            <th>Installation Date:</th>
            <td>{{ Carbon\Carbon::parse($customer->sale->
                installation_date)->format('Y-m-d') }}</td>
        </tr>
        <tr>
            <th>Public IP:</th>
            <td>
                @if($customer->sale->public_ip)
                    {{ $customer->sale->public_ip }}
                @else 
                    NA
                @endif
            </td>
        </tr>
        <tr class="price">
            <th>Public IP Price:</th>
            <td>
                @if($customer->sale->ip_price)
                    <span>
                        {{ $customer->sale->ip_price }}
                    </span>
                    <span>
                        {{ $customer->sale->ip_price_currency }}
                    </span>
                @else 
                    NA
                @endif
            </td>
        </tr>
        <tr>
            <th>Additional Charge:</th>
            <td>
                @if($customer->sale->additional_charge)
                    {{ $customer->sale->additional_charge }}
                @else 
                    NA
                @endif
            </td>
        </tr>
        <tr class="price">
            <th>Additional Charge Price:</th>
            <td>
                @if($customer->sale->additional_charge_price)
                    <span>
                        {{ $customer->sale->additional_charge_price }}
                    </span>
                    <span>
                        {{ $customer->sale->additional_currency }}
                    </span>
                @else 
                    NA
                @endif
            </td>
        </tr>
        <tr>
            <th>Comment:</th>
            <td>
                @if($customer->sale->comment)
                    {{ $customer->sale->comment }}
                @else 
                    NA
                @endif
            </td>
        </tr>
        <tr>
            <th>Created At:</th>
            <td>{{ $customer->created_at }}</td>
        </tr>
        <tr>
            <th>Created By:</th>
            <td>{{ $customer->sale->user->name }}</td>
        </tr>
    </tbody>
</table>
@else
<table class="table">
    <thead>
        <tr>
            <th>No Customer Details here.</th>
        </tr>
    </thead>
</table>
@endif