@if($customer)
<table class="table table-striped">
    <tbody>
        <tr>
            <th>Recontract Date:</th>
            <td>
                {{ $customer->recontract_date }}
            </td>
        </tr>
        <tr>
            <th>Recontract Reason:</th>
            <td>
                {{ $customer->comment }}
            </td>
        </tr>
        <tr>
            <th>Recontracted By:</th>
            <td>{{ $customer->user->name }}</td>
        </tr>
        <tr>
            <th>Created At</th>
            <td>{{ $customer->created_at }}</td>
        </tr>
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
            <td>{{ $customer->identity }}</td>
        </tr>
        <tr>
            <th>Address:</th>
            <td>{{ $customer->address }}</td>
        </tr>
        <tr>
            <th>Package:</th>
            <td>
                @if($customer->package)
                    {{ $customer->package->name }}
                @else
                    NA
                @endif
            </td>
        </tr>
        <tr>
            <th>Package Price:</th>
            <td>
            @if($customer->package_price)
                {{ $customer->package_price }}
                {{ $customer->package_price_currency }} 
            @else
                NA
            @endif
            </td>
        </tr>
        <tr>
            <th>Discount:</th>
            <td>
            @if($customer->discount)
                {{ $customer->discount }}
                {{ $customer->discount_currency }}
            @else
                NA
            @endif
            </td>
        </tr>
        <tr>
            <th>Discount Period:</th>
            <td>
            @if($customer->discount_period)
                {{ $customer->discount_period }}
                {{ $customer->discount_period_currency }}
            @else
                NA
            @endif
            </td>
        </tr>
        <tr>
            <th>Discount Reason:</th>
            <td>
            @if($customer->discount_reason)
                {{ $customer->discount_reason }}
            @else
                NA
            @endif
            </td>
        </tr>
        <tr>
            <th>Equipment Possession:</th>
            <td>{{ $customer->equi_type }}</td>
        </tr>
        <tr>
            <th>Leased Type:</th>
            <td>
                @if($customer->leased_type)
                {{ $customer->leased_type }}
            @else 
                NA
            @endif
            </td>
        </tr>
        <tr>
            <th>Receiver Type:</th>
            <td>{{ $customer->receiver_type }}</td>
        </tr>
        <tr>
            <th>Receiver Price:</th>
            <td>
            @if($customer->receiver_price)
                {{ $customer->receiver_price }}
                {{ $customer->receiver_price_currency }}
            @else 
                NA
            @endif
            </td>
        </tr>
        <tr>
            <th>Router Type:</th>
            <td>
            @if($customer->router_type)
                {{ $customer->router_type }}
            @else 
                NA
            @endif
            </td>
        </tr>
        <tr> 
            <th>Router Price:</th>
            <td>
                @if($customer->router_price)
                    {{ $customer->router_price }}
                    {{ $customer->router_price_currency }}
                @else 
                    NA
                @endif
            </td>
        </tr>
        <tr>
            <th>Cable Price:</th>
            <td>
            @if($customer->cable_price)
                {{ $customer->cable_price }}
                {{ $customer->cable_price_currency }}
            @else
                NA
            @endif
            </td>
        </tr>
        <tr>
            <th>Installation Cost:</th>
            <td>
            @if($customer->Installation_cost)
                {{ $customer->Installation_cost }}
                {{ $customer->Installation_cost_currency }}
            @else
                NA
            @endif
            </td>
        </tr>
        <tr>
            <th>Public IP:</th>
            <td>
            @if($customer->public_ip)
                {{ $customer->public_ip }}
            @else 
                NA
            @endif
            </td>
            </tr>
        <tr>
            <th>Public IP Price:</th>
            <td>
            @if($customer->ip_price)
                {{ $customer->ip_price }}
                {{ $customer->ip_price_currency }}
            @else 
                NA
            @endif
            </td>
        </tr>
        <tr>
            <th>Additional Charge:</th>
            <td>
                @if($customer->additional_charge)
                    {{ $customer->additional_charge }}
                @else 
                    NA
                @endif
            </td>
        </tr>
        <tr class="price">
            <th>Additional Charge Price:</th>
            <td>
                @if($customer->additional_charge_price)
                    <span>
                        {{ $customer->additional_charge_price }}
                    </span>
                    <span>
                        {{ $customer->additional_currency }}
                    </span>
                @else 
                    NA
                @endif
            </td>
        </tr>
        <tr>
            <th>Sales Confirmation:</th>
            <td>
            @if($customer->sales_confirmation)
                {{ $customer->sales_confirmation }}
            @else 
                Not Confirmed!
            @endif
            </td>
        </tr>
        <tr>
            <th>Finance Confirmation:</th>
            <td>
            @if($customer->finance_confirmation)
                {{ $customer->finance_confirmation }}
            @else 
                Not Confirmed!
            @endif
            </td>
        </tr>
        <tr>
            <th>NOC Confirmation:</th>
            <td>
            @if($customer->noc_confirmation)
                {{ $customer->noc_confirmation }}
            @else 
                Not Confirmed!
            @endif
            </td>
        </tr>
    </tbody>
</table>
@else
<table class="table">
    <thead>
        <tr>
            <th>Customer Recontract Details Not Exists</th>
        </tr>
    </thead>
</table>
@endif