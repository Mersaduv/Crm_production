@foreach($customer->PrAttachments as $images)
	<div class="col-md-3">
		<figure>
			<a href="{{asset('public/uploads/pr/'.$images->file_name)}}"   target="_blank">
				<img src="{{ asset('public/uploads/pr/'.$images->file_name) }}">
			</a>
			<span id="{{ $images->id }}" class="caption">
				<caption>Remove Image</caption>
			</span>
		</figure>
	</div>
@endforeach