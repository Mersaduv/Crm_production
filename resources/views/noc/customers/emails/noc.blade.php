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
<h1>Customer NOC installation</h1>	

<table class="table">
<tbody>
<tr>
<th>Customer ID</th>
<td>{{ $customer->customer_id }}</td>
</tr>
<tr>
<th>Customer Full Name</th>
<td>{{ $customer->full_name }}</td>
</tr>
<tr>
<th>Customer Phone </th>
<td>{{ $customer->phone1 }}</td>
</tr>
<tr>
<th>Customer Address </th>
<td>{{ $customer->address }}</td>
</tr>
<tr>
<th>Installer:</th>
<td>{{ $customer->noc->installer }}</td>
</tr>
<tr>
<th>Activation Date:</th>
<td>{{ Carbon\Carbon::parse($customer->noc->activation_date)->format('Y-m-d') }}</td>
</tr>
<tr>
<th>Cable Length:</th>
<td>{{ $customer->noc->cable_length." Meter" }}</td>
</tr>
<tr>
<th>Receiver Mac:</th>
<td>{{ $customer->noc->reciever_mac ? $customer->noc->reciever_mac : 'NA' }}</td>
</tr>
<tr>
<th>Latitude:</th>
<td>{{ $customer->noc->latitiude ? $customer->noc->latitiude : 'NA' }}</td>
</tr>
<tr>
<th>Longitude:</th>
<td>{{ $customer->noc->longitude ? $customer->noc->longitude : 'NA' }}</td>
</tr>
<tr>
<th>Additional Fee Reason:</th>
<td>{{ $customer->noc->additional_fee }}</td>
</tr>
<tr>
<th>Additional Fee Price:</th>
<td>
{{ $customer->noc->additional_fee_price }}
{{ $customer->noc->additional_fee_currency }}
</td>
</tr>
<tr>
<th>Created At:</th>
<td>
{{ $customer->noc->created_at }}
</td>
</tr> 
<tr>
<th>Created By:</th>
<td>
{{ $customer->noc->user->name }}
</td>
</tr> 
</tbody>
</table>
</body>
</html>