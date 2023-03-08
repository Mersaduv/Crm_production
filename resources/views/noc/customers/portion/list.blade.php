<?php
    $page = request('page') ? request('page') : 1;
    $index = 15 * $page - 14;
?>
@foreach($customers as $index => $customer)
    <tr>
        <th>{{ $index + 1 }}</th>
        <th>{{ $customer->customer_id }}</th>
        <th>{{ $customer->full_name }}</th>
        <th>
            {{ $customer->sale->package ? $customer->sale->package->name : 'NA' }}
        </th>
        <th>
            {{ $customer->sale->installation_date }}
        </th>
        <th>
            {{ $customer->noc ? $customer->noc->activation_date : 'NA' }}
        </th>
        <th>{{ $customer->address }}</th>
        <th class="operation">
            <a href="{{ route('installation.show',$customer->id) }}">
               view <span class="mdi mdi-eye"></span>
            </a>
        </th>
    </tr>
    <?php $index ++; ?>
@endforeach