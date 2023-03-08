@extends('noc.layouts.app')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Customer Attachments</h4>    
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
                            @if($customer->sale->SalesAttachment()->exists())
                            <div class="row" id="attachments">
                                @foreach($customer->sale->SalesAttachment as $images)
                                    <div class="col-md-3">
                                        <figure>
                                            <a href="{{asset('public/uploads/sales/'.$images->file_name)}}"   target="_blank">
                                                <img src="{{ asset('public/uploads/sales/'.$images->file_name) }}">
                                            </a>
                                        </figure>
                                    </div>
                                @endforeach
                            </div>
                            @else
                            <div>
                                <table class="table">
                                    <thead>
                                        <th><h1>No Images Uploaded</h1></th>
                                    </thead>
                                </table>
                            </div>
                            @endif
                        </div>
                    </div>

          			
                    <div class="card">
                        <div class="card-header">
                            <h3>NOC Attachments</h3>
                        </div> <!-- /card-header -->
                        <div class="card-body">
                            @if($customer->noc()->exists() && $customer->noc->NocAttachment()->exists())
                            <div class="row" id="attachments">
                                @foreach($customer->noc->NocAttachment as $images)
                                    <div class="col-md-3">
                                        <figure>
                                            <a href="{{asset('public/uploads/noc/'.$images->file)}}"    target="_blank">
                                                <img src="{{ asset('public/uploads/noc/'.$images->file) }}">
                                            </a>
                                        </figure>
                                    </div>
                                @endforeach
                            </div>
                            @else
                            <div>
                                <table class="table">
                                    <thead>
                                        <th><h1>No Images Uploaded</h1></th>
                                    </thead>
                                </table>
                            </div>
                            @endif
                        </div> <!-- /card-body -->
                    </div> <!-- /card -->
                    

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