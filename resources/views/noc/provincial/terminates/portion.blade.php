<?php
    $page = request('page') ? request('page') : 1;
    $index = 15 * $page - 14;
?>
@foreach($customers as $customer)
    <tr>
        <th>{{ $index }}</th>
        <th>{{ $customer->customer_id }}</th>
        <th>{{ $customer->full_name }}</th>
        <th>{{ $customer->province }}</th>
        <th>{{ $customer->installation_date }}</th>
        <th>
            {{ $customer->PrNocInfo()->exists() ? $customer->PrNocInfo->activation_date : 'NA' }}
        </th>
        <th class="operation">
            <a href="{{ route('pr.noc.terminate',$customer->id) }}">
               view <span class="mdi mdi-eye"></span>
            </a>
        </th>
    </tr>
    <?php $index ++; ?>
@endforeach