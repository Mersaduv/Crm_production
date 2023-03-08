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
<h1>Provincial Suspend Details</h1>
<table class="table">
<tbody>
<tr>
<th>Suspend Date</th>
<td>
{{ $customer->suspend->first()->suspend_date }}
</td>
</tr>
<tr>
<th>Suspend Reason</th>
<td>
{{ $customer->suspend->first()->suspend_reason }}
</td>
</tr>
<tr>
<th>Suspend By</th>
<td>{{ $customer->suspend->first()->user->name }}</td>
</tr>
<tr>
<th>Customer ID</th>
<td>
{{ $customer->suspend->first()->customer_id }}
</td>
</tr>
<tr>
<th>Full Name</th>
<td>{{ $customer->suspend->first()->full_name }}</td>
</tr>
<tr>
<th>POC</th>
<td>{{ $customer->suspend->first()->poc }}</td>
</tr>
<tr>
<th>Phone</th>
<td>
{{ $customer->suspend->first()->phone1 }}
-
{{ $customer->suspend->first()->phone2 }}
</td>
</tr>
<tr>
<th>Province</th>
<td>{{ province($customer->suspend->first()->province) }}</td>
</tr>
<tr>
<th>Customer Province</th>
<th>{{ province($customer->suspend->first()->customerProvince) }}</th>
</tr>
<tr>
<th>Address</th>
<td>{{ $customer->suspend->first()->address }}</td>
</tr>
<tr>
<th>Package</th>
<td>
@if($customer->suspend->first()->package)
{{ $customer->suspend->first()->package->name }}	
@else
NA
@endif
</td>
</tr>
<tr class="price">
<th>Package Price</th>
<td>
{{ $customer->suspend->first()->package_price }}
{{ $customer->suspend->first()->package_price_currency }}
</td>
</tr>
<tr>
<th>Additional Charge:</th>
<td>
@if($customer->suspend->first()->additional_charge)
{{ $customer->suspend->first()->additional_charge }}
@else 
NA
@endif
</td>
</tr>
<tr class="price">
<th>Additional Charge Price:</th>
<td>
@if($customer->suspend->first()->additional_charge_price)
<span>
{{ $customer->suspend->first()->additional_charge_price }}
</span>
<span>
{{ $customer->suspend->first()->additional_currency }}
</span>
@else 
NA
@endif
</td>
</tr>
<tr>
<th>Reseller Name</th>
<td>
@if($customer->suspend->first()->commission)
{{ $customer->suspend->first()->commission->name }}
@else
NA
@endif
</td>
</tr>
<tr>
<th>Reseller Percentage</th>
<td>
{{ $customer->suspend->first()->commission_percent ."%" }}
</td>
</tr>
<tr>
<th>Service</th>
<td>{{ $customer->suspend->first()->service }}</td>
</tr>
<tr>
<th>Provider</th>
<td>{{ $customer->suspend->first()->provider }}</td>
</tr>
<tr>
<th>Public IP</th>
<td>
@if($customer->suspend->first()->public_ip)
{{ $customer->suspend->first()->public_ip }}
@else
NA
@endif
</td>
</tr>
<tr class="price">
<th>IP Price</th>
<td>
@if($customer->suspend->first()->ip_price)
{{ $customer->suspend->first()->ip_price }}
{{ $customer->suspend->first()->ip_price_currency }}
@else
NA
@endif
</td>
</tr>
</tbody>
</table>
</body>
</html>