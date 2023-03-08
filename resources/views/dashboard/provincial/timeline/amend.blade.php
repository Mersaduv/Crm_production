@if($customer)
<table class="table table-striped">
    <tbody>
        <?php
                $clone = json_decode($customer->clone);
            ?>
        <tr>
            <th>Amend Date</th>
            <td>{{ $customer->amend_date }}</td>
        </tr>
        <tr>
            <th>Amend Comment</th>
            <td>
                {{ $customer->amend_comment }}
            </td>
        </tr>
        <tr>
            <th>Amendment By</th>
            <td>{{ $customer->user->name }}</td>
        </tr>
        <tr>
            <th>Created At</th>
            <td>{{ $customer->created_at }}</td>
        </tr>
        @if($clone)
        @if($customer->customer_id != $clone->customer_id)
        <tr>
            <th>Customer ID</th>
            <td>
                {{ $clone->customer_id }}
                =>
                {{ $customer->customer_id }}
            </td>
        </tr>
        @endif

        @if($customer->full_name != $clone->full_name)
        <tr>
            <th>Full Name</th>
            <td>
                {{ $clone->full_name }}
                =>
                {{ $customer->full_name }}
            </td>
        </tr>
        @endif
        @if($customer->poc != $clone->poc)
        <tr>
            <th>POC</th>
            <td>
                {{ $clone->poc }}
                =>
                {{ $customer->poc }}
            </td>
        </tr>
        @endif
        @if($customer->phone1 != $clone->phone1)
        <tr>
            <th>Phone</th>
            <td>
                {{ $clone->phone1 }}
                =>
                {{ $customer->phone1 }}
            </td>
        </tr>
        @endif
        @if($customer->phone2 != $clone->phone2)
        <tr>
            <th>Phone</th>
            <td>
                {{ $clone->phone2 }}
                =>
                {{ $customer->phone2 }}
            </td>
        </tr>
        @endif
        @if($customer->province != $clone->province)
        <tr>
            <th>Address</th>
            <td>
                {{ $clone->province }}
                =>
                {{ $customer->province }}
            </td>
        </tr>
        @endif
        @if($customer->address != $clone->address)
        <tr>
            <th>Address</th>
            <td>
                {{ $clone->address }}
                =>
                {{ $customer->address }}
            </td>
        </tr>
        @endif
        @if($customer->package_id != $clone->package_id)
        <tr>
            <th>Package</th>
            <td>
                {{ package($clone->package_id) }}
                =>
                {{ $customer->package->name }}
            </td>
        </tr>
        @endif
        @if($customer->package_price != $clone->package_price)
        <tr>
            <th>Package Price</th>
            <td>
                {{ $clone->package_price }} {{ $clone->package_price_currency }}
                =>
                {{ $customer->package_price }}
                {{ $customer->package_price_currency }}
            </td>
        </tr>
        @endif
        @if($customer->commission_id != $clone->commission_id)
        <tr>
            <th>Reseller</th>
            <td>
                {{ reseller($clone->commission_id) }}
                =>
                {{ $customer->commission->name }}
            </td>
        </tr>
        @endif
        @if($customer->commission_percent != $clone->commission_percent)
        <tr>
            <th>Reseller Percentage</th>
            <td>
                {{ $clone->commission_percent }}
                =>
                {{ $customer->commission_percent }}
            </td>
        </tr>
        @endif
        @if($customer->marketer_id != $clone->marketer_id)
        <tr>
            <th>Field Officer</th>
            <td>
                {{ marketer($clone->marketer_id) }}
                =>
                {{ $customer->marketer->name }}
            </td>
        </tr>
        @endif
        @if($customer->service != $clone->service)
        <tr>
            <th>Reseller Percentage</th>
            <td>
                {{ $clone->service }}
                =>
                {{ $customer->service }}
            </td>
        </tr>
        @endif
        @if($customer->provider != $clone->provider)
        <tr>
            <th>Reseller Percentage</th>
            <td>
                {{ $clone->provider }}
                =>
                {{ $customer->provider }}
            </td>
        </tr>
        @endif
        @if($customer->public_ip != $clone->public_ip)
        <tr>
            <th>Public IP</th>
            <td>
                {{ $clone->public_ip }}
                =>
                {{ $customer->public_ip }}
            </td>
        </tr>
        @endif
        @if($customer->ip_price != $clone->ip_price)
        <tr>
            <th>Public IP Price</th>
            <td>
                {{ $clone->ip_price }} {{ $clone->ip_price_currency }}
                =>
                {{ $customer->ip_price }}
                {{ $customer->ip_price_currency }}
            </td>
        </tr>
        @endif
        @if($customer->additional_charge != $clone->additional_charge)
        <tr>
            <th>Additional Charge</th>
            <td>
                {{ $clone->additional_charge }}
                =>
                {{ $customer->additional_charge }}
            </td>
        </tr>
        @endif
        @if($customer->additional_charge_price != $clone->additional_charge_price)
        <tr>
            <th>Additional Charge Price</th>
            <td>
                {{ $clone->additional_charge_price }} {{ $clone->additional_currency }}
                =>
                {{ $customer->additional_charge_price }}
                {{ $customer->additional_currency }}
            </td>
        </tr>
        @endif
        @endif
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
    </tbody>
</table>
@else
<table class="table">
    <thead>
        <tr>
            <th>No Details Exists here.</th>
        </tr>
    </thead>
</table>
@endif