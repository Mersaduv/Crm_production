<?php
    $page = request('page') ? request('page') : 1;
    $index = 15 * $page - 14;
?>
@foreach($customers as $customer)
    <tr>
        <th>{{ $index }}</th>
        <th>{{ $customer->customer_id }}</th>
        <th>{{ $customer->full_name }}</th>
        <th>
            {{ $customer->sale->package ? $customer->sale->package->name : 'NA' }}
        </th>
        <th>{{ $customer->noc->activation_date }}</th>
        <th>{{ $customer->suspend->first()->suspend_date }}</th>
        <th class="operation">
            <a href="{{ route('singleSuspend',$customer->id) }}">
               view <span class="mdi mdi-eye"></span>
            </a>
        </th>
    </tr>
    <?php $index ++ ?>
@endforeach