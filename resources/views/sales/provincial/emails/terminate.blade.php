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
<h1>Provincial Terminate Details</h1>
<table class="table table-striped table-dark">
<tbody>
<tr>
<th>Terminate Date</th>
<td>
{{ $customer->terminate->first()->terminate_date }}
</td>
</tr>
<tr>
<th>Terminate Reason</th>
<td>
{{ $customer->terminate->first()->terminate_reason }}
</td>
</tr>
<tr>
<th>Terminated By</th>
<td>
{{ $customer->terminate->first()->user->name }}
</td>
</tr>
<tr>
<th>Customer ID</th>
<td>
{{ $customer->terminate->first()->customer_id }}
</td>
</tr>
<tr>
<th>Full Name</th>
<td>{{ $customer->terminate->first()->full_name }}</td>
</tr>
<tr>
<th>POC</th>
<td>{{ $customer->terminate->first()->poc }}</td>
</tr>
<tr>
<th>Phone</th>
<td>
{{ $customer->terminate->first()->phone1 }}
-
{{ $customer->terminate->first()->phone2 }}
</td>
</tr>
<tr>
<th>Province</th>
<td>{{ province($customer->terminate->first()->province) }}</td>
</tr>
<tr>
<th>Customre Province</th>
<td>{{ province($customer->terminate->first()->customerProvince); }}</td>
</tr>
<tr>
<th>Address</th>
<td>{{ $customer->terminate->first()->address }}</td>
</tr>
<tr>
<th>Package</th>
<td>
@if($customer->terminate->first()->package)
{{ $customer->terminate->first()->package->name }}
@else
NA
@endif
</td>
</tr>
<tr class="price">
<th>Package Price</th>
<td>
{{ $customer->terminate->first()->package_price }}
{{ $customer->terminate->first()->package_price_currency }}
</td>
</tr>
<tr>
<th>Additional Charge:</th>
<td>
@if($customer->terminate->first()->additional_charge)
{{ $customer->terminate->first()->additional_charge }}
@else 
NA
@endif
</td>
</tr>
<tr class="price">
<th>Additional Charge Price:</th>
<td>
@if($customer->terminate->first()->additional_charge_price)
<span>
{{ $customer->terminate->first()->additional_charge_price }}
</span>
<span>
{{ $customer->terminate->first()->additional_currency }}
</span>
@else 
NA
@endif
</td>
</tr>
<tr>
<th>Reseller Name</th>
<td>{{ $customer->terminate->first()->commission ? $customer->terminate->first()->commission->name : 'NA' }}</td>
</tr>
<tr>
<th>Reseller Percentage</th>
<td>
{{ $customer->terminate->first()->commission_percent ."%" }}
</td>
</tr>
<tr>
<th>Service</th>
<td>{{ $customer->terminate->first()->service }}</td>
</tr>
<tr>
<th>Provider</th>
<td>{{ $customer->terminate->first()->provider }}</td>
</tr>
<tr>
<th>Public IP</th>
<td>
@if($customer->terminate->first()->public_ip)
{{ $customer->terminate->first()->public_ip }}
@else
NA
@endif
</td>
</tr>
<tr class="price">
<th>IP Price</th>
<td>
@if($customer->terminate->first()->ip_price)
{{ $customer->terminate->first()->ip_price }}
{{ $customer->terminate->first()->ip_price_currency }}
@else
NA
@endif
</td>
</tr>
</tbody>	
</table>
</body>
</html>