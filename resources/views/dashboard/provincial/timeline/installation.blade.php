@if($customer)
<table class="table table-striped">
    <tbody>
        <tr>
            <th>Customer ID</th>
            <td>{{ $customer->customer_id }}</td>
        </tr>
        <tr>
            <th>Full Name</th>
            <td>{{ $customer->full_name }}</td>
        </tr>
        <tr>
            <th>POC</th>
            <td>{{ $customer->poc }}</td>
        </tr>
        <tr>
            <th>Phone</th>
            <td>
                {{ $customer->phone1 }}
                -
                {{ $customer->phone2 }}
            </td>
        </tr>
        <tr>
            <th>Branch</th>
            <td>{{ $customer->branch->name }}</td>
        </tr>
        <tr>
            <th>Province</th>
            <td>{{ province($customer->province) }}</td>
        </tr>
        <tr>
            <th>Customer Province</th>
            <th>{{ province($customer->customerProvince) }}</th>
        </tr>
        <tr>
            <th>Address</th>
            <td>{{ $customer->address }}</td>
        </tr>
        <tr>
            <th>Package</th>
            <td>
                @if($customer->package)
                    {{ $customer->package->name }}
                @else
                    NA
                @endif
            </td>
        </tr>
        <tr class="price">
            <th>Package Price</th>
            <td>
                <span>{{ $customer->package_price }}</span>
                <span>{{ $customer->package_price_currency }}</span>
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
            <th>Reseller Name</th>
            <td>
                @if($customer->commission)
                    {{ $customer->commission->name }}
                @else
                    NA
                @endif
            </td>
        </tr>
        <tr>
            <th>Reseller Percentage</th>
            <td>
                <span>{{ $customer->commission_percent ."%" }}</span>
            </td>
        </tr>
        <tr>
            <th>Installation Date</th>
            <td>{{ Carbon\Carbon::parse($customer->installation_date)->format('Y-m-d') }}</td>
        </tr>
        <tr class="price">
            <th>Installation Cost</th>
            <td>
                <span>{{ $customer->installation_cost }}</span>
                <span>{{ $customer->Installation_cost_currency }}</span>
            </td>
        </tr>
        <tr>
            <th>Service</th>
            <td>{{ $customer->service }}</td>
        </tr>
        <tr>
            <th>Provider</th>
            <td>{{ $customer->provider }}</td>
        </tr>
        <tr>
            <th>Public IP</th>
            <td>
                @if($customer->public_ip)
                    {{ $customer->public_ip }}
                @else
                    NA
                @endif
            </td>
        </tr>
        <tr class="price">
            <th>IP Price</th>
            <td>
                @if($customer->ip_price)
                    <span>{{ $customer->ip_price }}</span>
                    <span>{{ $customer->ip_price_currency }}</span>
                @else
                    NA
                @endif
            </td>
        </tr>
        <tr>
            <th>Comment</th>
            <td>
                @if($customer->comment)
                    {{ $customer->comment }}
                @else
                    NA
                @endif
            </td>
        </tr>
        <tr>
            <th>Created At:</th>
            <td>
                {{ $customer->created_at }}
            </td>
        </tr>
        <tr>
            <th>Created By:</th>
            <td>
                {{ $customer->user->name }}
            </td>
        </tr>
    </tbody>
</table> <!-- /table -->
@else
<table class="table">
	<thead>
		<tr>
			<th>No Details Exists here.</th>
		</tr>
	</thead>
</table>
@endif