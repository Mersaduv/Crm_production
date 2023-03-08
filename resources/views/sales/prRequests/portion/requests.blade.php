<?php
    $page = request('page') ? request('page') : 1;
    $index = 15 * $page - 14;
?>
@foreach($requests as $request)
	<tr>
		<td>{{ $index }}</td>
		<td>{{ $request->customer->full_name }}</td>
		<td>{{ $request->request_date }}</td>
		<td>{{ $request->user->name }}</td>
        <td>{{ $request->status }}</td>
		<td class="operation">
			<a href="{{ route('getRequest',$request->id) }}">
				View <i class="mdi mdi-eye"></i>
			</a>
		</td>
	</tr>
	<?php $index ++ ?>
@endforeach