<?php
    $page = request('page') ? request('page') : 1;
    $index = 15 * $page - 14;
?>
@foreach($cancels as $cancel)
    <tr>
    	<th>{{ $index }}</th>
    	<th>{{ $cancel->customer_id }}</th>
    	<th>{{ $cancel->full_name }}</th>
    	<th>{{ $cancel->province }}</th>
    	<th>{{ $cancel->prCancel->cancel_date }}</th>
    	<th>
    		{{ Illuminate\Support\Str::limit($cancel->prCancel->cancel_reason, 80) }}
    	</th>
    	<th>
            {{ $cancel->prCancel->rollback_date ? $cancel->prCancel->rollback_date : 'NA' }}
    	</th>
    	<th class="operation">
    		 <a href="{{route('prCancels.show',$cancel->id) }}">
               view <span class="mdi mdi-eye"></span>
            </a>
    	</th>
    </tr>
    <?php $index ++; ?>
@endforeach