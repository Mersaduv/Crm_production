@extends('finance.layouts.app')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Customer Attachments</h4>
                
                <div class="history">

                    <div class="row">
                        <div class="col-sm-6">
                            {{ Breadcrumbs::render('finance.pr.attachments',$customer) }}
                        </div>
                        <div class="col-sm-6 historyBTN">
                            <button class="btn btn-primary btn-sm">
                                <a href="{{ url()->previous() }}" class="btn btn-ctr">
                                   <i class="far fa-arrow-alt-circle-left"></i> 
                                   Go Back
                                </a>
                            </button>
                        </div>
                    </div> <!-- /row -->
                
                </div>

            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-sm-12">
            	<div class="page-content-box">
                 
          			<div class="card">
          				<div class="card-header">
          					<h3>Sales Attachments</h3>
          				</div> <!-- /card-header -->
          				<div class="card-body">
          					@if($customer->PrAttachments()->exists())
          					<div class="row" id="attachments">
      							@foreach($customer->PrAttachments as $images)
          							<div class="col-md-3">
          								<figure>
          									<a href="{{asset('public/uploads/pr/'.$images->file_name)}}"   target="_blank">
          										<img src="{{ asset('public/uploads/pr/'.$images->file_name) }}">
          									</a>
          								</figure>
          							</div>
          						@endforeach
          					</div>
      						@else
      							<table class="table">
      								<thead>
      									<th>
      										<h1>No Images Uploaded</h1>
      									</th>
      								</thead>
      							</table>
      						@endif
          				</div>
          			</div>

                    
                    <div class="card">
          				<div class="card-header">
          					<h3>NOC Attachments</h3>
          				</div> <!-- /card-header -->
          				<div class="card-body">
          					@if($customer->PrNocInfo()->exists() && $customer->PrNocAttachments()->exists())
          					<div class="row" id="attachments">
      							@foreach($customer->PrNocAttachments as $images)
          							<div class="col-md-3">
          								<figure>
          									<a href="{{asset('public/uploads/pr/'.$images->file_name)}}"   target="_blank">
          										<img src="{{ asset('public/uploads/pr/'.$images->file_name) }}">
          									</a>
          								</figure>
          							</div>
          						@endforeach
          					</div>
      						@else
      							<table class="table">
      								<thead>
      									<th>
      										<h1>No Images Uploaded</h1>
      									</th>
      								</thead>
      							</table>
      						@endif
          				</div>
          			</div>
            	</div> <!-- /end of content box -->
        	<div class="clearfix"></div>
    	</div>
    </div> <!-- /end of page content -->
@endsection

@section('style')
  <style>
    #attachments img{
    	width: 100%;
    	height: auto;
    	max-height: 400px;
    	object-fit: contain;
    }
  </style>
@endsection

@section('script')
<script type="text/javascript">

</script>
@endsection