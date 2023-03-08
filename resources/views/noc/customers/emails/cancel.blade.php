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
<h1>Customer Cancel Details</h1>	
<table class="table">
<tbody>
<tr>
<th>Cancel Date</th>
<td>{{ $customer->cancel->first()->cancel_date }}</td>
</tr>
<tr>
<th>Cancel Reason</th>
<td>{{ $customer->cancel->first()->cancel_reason }}</td>
</tr>
<tr>
<th>Cancel By</th>
<td>{{ $customer->cancel->first()->user->name }}</td>
</tr>
<tr>
<th>Created At</th>
<td>{{ $customer->cancel->first()->user->name }}</td>
</tr>
<tr>
<th>Customer ID:</th>
<td>{{ $customer->cancel->first()->customer_id }}</td>
</tr>
<tr>
<th>Full Name:</th>
<td>{{ $customer->cancel->first()->full_name }}</td>
</tr>
<tr>
<th>POC:</th>
<td>{{ $customer->cancel->first()->poc }}</td>
</tr>
<tr>
<th>Phone:</th>
<td>
{{ $customer->cancel->first()->phone1 }}
-
{{ $customer->cancel->first()->phone2 }}
</td>
</tr>
<tr>
<th>Education:</th>
<td>{{ $customer->cancel->first()->education }}</td>
</tr>
<tr>
<th>Identity Number:</th>
<td>{{ $customer->cancel->first()->identity }}</td>
</tr>
<tr>
<th>Address:</th>
<td>{{ $customer->cancel->first()->address }}</td>
</tr>
<tr>
<th>Package:</th>
<td>
@if($customer->cancel->first()->package)
{{ $customer->cancel->first()->package->name }}
@else
NA
@endif
</td>
</tr>
<tr>
<th>Package Price:</th>
<td>
@if($customer->cancel->first()->package_price)
{{ $customer->cancel->first()->package_price }}
{{ $customer->cancel->first()->package_price_currency }} 
@else
NA
@endif
</td>
</tr>
<tr>
<th>Reseller Name</th>
<td>
@if($customer->cancel->first()->commission)
{{ $customer->cancel->first()->commission->name }}
@else
NA
@endif
</td>
</tr>
<tr>
<th>Reseller Percentage</th>
<td>
<span>
{{ $customer->cancel->first()->commission_percent ."%" }}
</span>
</td>
</tr>
<tr>
<th>Discount:</th>
<td>
@if($customer->cancel->first()->discount)
{{ $customer->cancel->first()->discount }}
{{ $customer->cancel->first()->discount_currency }}
@else
NA
@endif
</td>
</tr>
<tr>
<th>Discount Period:</th>
<td>
@if($customer->cancel->first()->discount_period)
{{ $customer->cancel->first()->discount_period }}
{{ $customer->cancel->first()->discount_period_currency }}
@else
NA
@endif
</td>
</tr>
<tr>
<th>Discount Reason:</th>
<td>
@if($customer->cancel->first()->discount_reason)
{{ $customer->cancel->first()->discount_reason }}
@else
NA
@endif
</td>
</tr>
<tr>
<th>Equipment Possession:</th>
<td>{{ $customer->cancel->first()->equi_type }}</td>
</tr>
<tr>
<th>Leased Type:</th>
<td>
@if($customer->cancel->first()->leased_type)
{{ $customer->cancel->first()->leased_type }}
@else 
NA
@endif
</td>
</tr>
<tr>
<th>Receiver Type:</th>
<td>{{ $customer->cancel->first()->receiver_type }}</td>
</tr>
<tr>
<th>Receiver Price:</th>
<td>
@if($customer->cancel->first()->receiver_price)
{{ $customer->cancel->first()->receiver_price }}
{{ $customer->cancel->first()->receiver_price_currency }}
@else 
NA
@endif
</td>
</tr>
<tr>
<th>Router Type:</th>
<td>
@if($customer->cancel->first()->router_type)
{{ $customer->cancel->first()->router_type }}
@else 
NA
@endif
</td>
</tr>
<tr> 
<th>Router Price:</th>
<td>
@if($customer->cancel->first()->router_price)
{{ $customer->cancel->first()->router_price }}
{{ $customer->cancel->first()->router_price_currency }}
@else 
NA
@endif
</td>
</tr>
<tr>
<th>Cable Price:</th>
<td>
@if($customer->cancel->first()->cable_price)
{{ $customer->cancel->first()->cable_price }}
{{ $customer->cancel->first()->cable_price_currency }}
@else
NA
@endif
</td>
</tr>
<tr>
<th>Installation Cost:</th>
<td>
@if($customer->cancel->first()->Installation_cost)
{{ $customer->cancel->first()->Installation_cost }}
{{ $customer->cancel->first()->Installation_cost_currency }}
@else
NA
@endif
</td>
</tr>
<tr>
<th>Public IP:</th>
<td>
@if($customer->cancel->first()->public_ip)
{{ $customer->cancel->first()->public_ip }}
@else 
NA
@endif
</td>
</tr>
<tr>
<th>Public IP Price:</th>
<td>
@if($customer->cancel->first()->ip_price)
{{ $customer->cancel->first()->ip_price }}
{{ $customer->cancel->first()->ip_price_currency }}
@else 
NA
@endif
</td>
</tr>
<tr>
<th>Additional Charge:</th>
<td>
@if($customer->cancel->first()->additional_charge)
{{ $customer->cancel->first()->additional_charge }}
@else 
NA
@endif
</td>
</tr>
<tr class="price">
<th>Additional Charge Price:</th>
<td>
@if($customer->cancel->first()->additional_charge_price)
<span>
{{ $customer->cancel->first()->additional_charge_price }}
</span>
<span>
{{ $customer->cancel->first()->additional_currency }}
</span>
@else 
NA
@endif
</td>
</tr>
</tbody>
</table>
</body>
</html>