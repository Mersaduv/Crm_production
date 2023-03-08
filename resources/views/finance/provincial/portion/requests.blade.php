<?php
    $page = request('page') ? request('page') : 1;
    $index = 15 * $page - 14;
?>
@foreach($customers as $customer)
    <tr>
        <th>{{ $index }}</th>
        <th>{{ $customer->customer_id }}</th>
        <th>{{ $customer->full_name }}</th>
        <th>{{ province($customer->province); }}</th>
        <th>
            @if($customer->package)
                {{ $customer->package->name }}
            @else
                NA
            @endif
        </th>
        <th>{{ $customer->installation_date }}</th>
        <th>
            @if($customer->PrNocInfo()->exists())
                {{ $customer->PrNocInfo->activation_date }}
            @else
                NA
            @endif
        </th>
        <th class="operation">
            <a href="{{ route('prc.show',$customer->id) }}">
               view <span class="mdi mdi-eye"></span>
            </a>
        </th>
    </tr>
    <?php $index ++ ?>
@endforeach