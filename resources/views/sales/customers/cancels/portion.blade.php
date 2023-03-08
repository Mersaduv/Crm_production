<?php
    $page = request('page') ? request('page') : 1;
    $index = 15 * $page - 14;
?>
@foreach($cancels as $cancel)
<tr>
    <th>{{ $index }}</th>
    <th>{{ $cancel->customer_id }}</th>
    <th>{{ $cancel->full_name }}</th>
    <th>{{ $cancel->cancel->first()->cancel_date }}</th>
    <th>
        {{ Illuminate\Support\Str::limit($cancel->cancel->first()->cancel_reason, 80) }}
    </th>
    <th>
        {{ $cancel->cancel->first()->rollback_date ? $cancel->cancel->first()->rollback_date : 'NA' }}
    </th>
    <th class="operation">
        <a href="{{ route('cancels.show',$cancel->id) }}">
            view <span class="mdi mdi-eye"></span>
        </a>
    </th>
</tr>
<?php $index ++ ?>
@endforeach