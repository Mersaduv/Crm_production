<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
		  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="color-scheme" content="light">
<meta name="supported-color-schemes" content="light">
<style>
.table{
width: 100%;
text-align: center;
border-collapse: collapse;
}
tbody{
border-bottom:2px solid #000;
}
tbody tr:nth-child(odd){
background: #eee;
}
td, th{
border: 1px solid #999;
padding: 0.5rem;	
}
h1{
text-align: center;
padding: 20px auto;
background: #eee;
}
</style>
</head>
<body>
<h1>Provincial Cancel Details</h1>
<table class="table">
<tbody>
<tr>
<th>Cancel Date</th>
<td>
{{ $customer->prCancel->first()->cancel_date }}
</td>
</tr>
<tr>
<th>Cancel Reason</th>
<td>
{{ $customer->prCancel->first()->cancel_reason }}
</td>
</tr>
<tr>
<th>Cancel By</th>
<td>
{{ $customer->prCancel->first()->user->name }}
</td>
</tr>
<tr>
<th>Customer ID</th>
<td>
{{ $customer->prCancel->first()->customer_id }}
</td>
</tr>
<tr>
<th>Full Name</th>
<td>{{ $customer->prCancel->first()->full_name }}</td>
</tr>
<tr>
<th>POC</th>
<td>{{ $customer->prCancel->first()->poc }}</td>
</tr>
<tr>
<th>Phone</th>
<td>
{{ $customer->prCancel->first()->phone1 }}
-
{{ $customer->prCancel->first()->phone2 }}
</td>
</tr>
<tr>
<th>Province</th>
<td>{{ province($customer->prCancel->first()->province) }}</td>
</tr>
<tr>
<th>Customer Province</th>
<th>{{ province($customer->prCancel->first()->customerProvince) }}</th>
</tr>
<tr>
<th>Address</th>
<td>{{ $customer->prCancel->first()->address }}</td>
</tr>
<tr>
<th>Package</th>
<td>
@if($customer->prCancel->first()->package)
{{ $customer->prCancel->first()->package->name }}	
@else
NA
@endif
</td>
</tr>
<tr class="price">
<th>Package Price</th>
<td>
{{ $customer->prCancel->first()->package_price }}
{{ $customer->prCancel->first()->package_price_currency }}
</td>
</tr>
<tr>
<th>Additional Charge:</th>
<td>
@if($customer->prCancel->first()->additional_charge)
{{ $customer->prCancel->first()->additional_charge }}
@else 
NA
@endif
</td>
</tr>
<tr class="price">
<th>Additional Charge Price:</th>
<td>
@if($customer->prCancel->first()->additional_charge_price)
<span>
{{ $customer->prCancel->first()->additional_charge_price }}
</span>
<span>
{{ $customer->prCancel->first()->additional_currency }}
</span>
@else 
NA
@endif
</td>
</tr>
<tr>
<th>Reseller Name</th>
<td>{{ $customer->prCancel->first()->commission ? $customer->prCancel->first()->commission->name : 'NA' }}</td>
</tr>
<tr>
<th>Reseller Percentage</th>
<td>
{{ $customer->prCancel->first()->commission_percent ."%" }}
</td>
</tr>
<tr>
<th>Installation Date</th>
<td>{{ $customer->prCancel
->first()->installation_date }}</td>
</tr>
<tr class="price">
<th>Installation Cost</th>
<td>
<span>{{ $customer->prCancel->first()->installation_cost }}</span>
<span>{{ $customer->prCancel->first()->Installation_cost_currency }}</span>
</td>
</tr>
<tr>
<th>Service</th>
<td>{{ $customer->prCancel->first()->service }}</td>
</tr>
<tr>
<th>Provider</th>
<td>{{ $customer->prCancel->first()->provider }}</td>
</tr>
<tr>
<th>Public IP</th>
<td>
@if($customer->prCancel->first()->public_ip)
{{ $customer->prCancel->first()->public_ip }}
@else
NA
@endif
</td>
</tr>
<tr class="price">
<th>IP Price</th>
<td>
@if($customer->prCancel->first()->ip_price)
{{ $customer->prCancel->first()->ip_price }}
{{ $customer->prCancel->first()->ip_price_currency }}
@else
NA
@endif
</td>
</tr>
</tbody>
</table>
</body>
</html>