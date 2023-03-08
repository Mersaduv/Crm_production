@if($message = Session::get('success'))
<div class="alert alert-success alert-block alert-messages">
	<button type="button" class="close" data-dismiss="alert">×</button>	
        <strong>{{ $message }}</strong>
</div>
@endif

@if($message = Session::get('error'))
<div class="alert alert-danger alert-block alert-messages">
	<button type="button" class="close" data-dismiss="alert">×</button>	
        <strong>{{ $message }}</strong>
</div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-messages">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif