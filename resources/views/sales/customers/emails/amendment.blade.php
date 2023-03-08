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
<h1>Customer Amendment Details</h1>	
<table class="table">
<tbody>
<tr>
<th>Amendment Date</th>
<td>{{ $customer->amend->first()->amend_date }}</td>
</tr>
<tr>
<th>Amendment Comment</th>
<td>{{ $customer->amend->first()->amedment_comment }}</td>
</tr>
<tr>
<th>Amendment By</th>
<td>{{ $customer->amend->first()->user->name }}</td>
</tr>
<tr>
<th>Customer ID:</th>
<td>{{ $customer->amend->first()->customer_id }}</td>
</tr>
<tr>
<th>Full Name:</th>
<td>{{ $customer->amend->first()->full_name }}</td>
</tr>
<tr>
<th>POC:</th>
<td>{{ $customer->amend->first()->poc }}</td>
</tr>
<tr>
<th>Phone:</th>
<td>
{{ $customer->amend->first()->phone1 }}
-
{{ $customer->amend->first()->phone2 }}
</td>
</tr>
<tr>
<th>Education:</th>
<td>{{ $customer->amend->first()->education }}</td>
</tr>
<tr>
<th>Identity Number:</th>
<td>{{ $customer->amend->first()->identity }}</td>
</tr>
<tr>
<th>Address:</th>
<td>{{ $customer->amend->first()->address }}</td>
</tr>
<tr>
<th>Package:</th>
<td>
@if($customer->amend->first()->package)
{{ $customer->amend->first()->package->name }}
@else
NA
@endif
</td>
</tr>
<tr>
<th>Package Price:</th>
<td>
@if($customer->amend->first()->package_price)
{{ $customer->amend->first()->package_price }}
{{ $customer->amend->first()->package_price_currency }} 
@else
NA
@endif
</td>
</tr>
<tr>
<th>Reseller Name</th>
<td>
@if($customer->amend->first()->commission)
{{ $customer->amend->first()->commission->name }}
@else
NA
@endif
</td>
</tr>
<tr>
<th>Reseller Percentage</th>
<td>
<span>
{{ $customer->amend->first()->commission_percent ."%" }}
</span>
</td>
</tr>
<tr>
<th>Discount:</th>
<td>
@if($customer->amend->first()->discount)
{{ $customer->amend->first()->discount }}
{{ $customer->amend->first()->discount_currency }}
@else
NA
@endif
</td>
</tr>
<tr>
<th>Discount Period:</th>
<td>
@if($customer->amend->first()->discount_period)
<span>
{{ $customer->amend->first()->discount_period }}
</span>
<span>
{{ $customer->amend->first()->discount_period_currency }}
</span>
@else
NA
@endif
</td>
</tr>
<tr>
<th>Discount Reason:</th>
<td>
@if($customer->amend->first()->discount_reason)
{{ $customer->amend->first()->discount_reason }}
@else
NA
@endif
</td>
</tr>
<tr>
<th>Equipment Possession:</th>
<td>{{ $customer->amend->first()->equi_type }}</td>
</tr>
<tr>
<th>Leased Type:</th>
<td>
@if($customer->amend->first()->leased_type)
{{ $customer->amend->first()->leased_type }}
@else 
NA
@endif
</td>
</tr>
<tr>
<th>Receiver Type:</th>
<td>{{ $customer->amend->first()->receiver_type }}</td>
</tr>
<tr>
<th>Receiver Price:</th>
<td>
@if($customer->amend->first()->receiver_price)
{{ $customer->amend->first()->receiver_price }}
{{ $customer->amend->first()->receiver_price_currency }}
@else 
NA
@endif
</td>
</tr>
<tr>
<th>Router Type:</th>
<td>
@if($customer->amend->first()->router_type)
{{ $customer->amend->first()->router_type }}
@else 
NA
@endif
</td>
</tr>
<tr> 
<th>Router Price:</th>
<td>
@if($customer->amend->first()->router_price)
{{ $customer->amend->first()->router_price }}
{{ $customer->amend->first()->router_price_currency }}
@else 
NA
@endif
</td>
</tr>
<tr>
<th>Cable Price:</th>
<td>
@if($customer->amend->first()->cable_price)
{{ $customer->amend->first()->cable_price }}
{{ $customer->amend->first()->cable_price_currency }}
@else
NA
@endif
</td>
</tr>
<tr>
<th>Public IP:</th>
<td>
@if($customer->amend->first()->public_ip)
{{ $customer->amend->first()->public_ip }}
@else 
NA
@endif
</td>
</tr>
<tr>
<th>Public IP Price:</th>
<td>
@if($customer->amend->first()->ip_price)
{{ $customer->amend->first()->ip_price }}
{{ $customer->amend->first()->ip_price_currency }}
@else 
NA
@endif
</td>
</tr>
<tr>
<th>Additional Charge:</th>
<td>
@if($customer->amend->first()->additional_charge)
{{ $customer->amend->first()->additional_charge }}
@else 
NA
@endif
</td>
</tr>
<tr class="price">
<th>Additional Charge Price:</th>
<td>
@if($customer->amend->first()->additional_charge_price)
<span>
{{ $customer->amend->first()->additional_charge_price }}
</span>
<span>
{{ $customer->amend->first()->additional_currency }}
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