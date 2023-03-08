@foreach($customer->NocAttachment as $images)
	<div class="col-md-3">
		<figure>
			<a href="{{asset('public/uploads/noc/'.$images->file)}}"    target="_blank">
				<img src="{{ asset('public/uploads/noc/'.$images->file) }}">
			</a>
			<span id="{{ $images->id }}" class="caption newElement">
				<caption>Remove Image</caption>
			</span>
		</figure>
	</div>
@endforeach