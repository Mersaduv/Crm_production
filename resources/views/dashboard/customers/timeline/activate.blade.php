@if($customer) 
  <table class="table table-striped">
        <tbody>
            <tr>
                <th>Installer:</th>
                <td>{{ $customer->noc->installer }}</td>
            </tr>
            <tr>
                <th>Activation Date:</th>
                <td>{{ $customer->noc->activation_date }}</td>
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
                <td>{{ $customer->noc->created_at }}</td>
            </tr>
            <tr>
                <th>Created By:</th>
                <td>{{ $customer->noc->user->name }}</td>
            </tr>    
        </tbody>
    </table>
@else
    <table class="table">
        <tbody>
            <tr>
                <th><h1>Customer is not active.</h1></th>
            </tr>
        </tbody>
    </table>
@endif