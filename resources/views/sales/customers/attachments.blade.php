@extends('sales.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Sales Attachments</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('salesAttachments',$sale->customer) }}
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
                    <h3>Sales Attachments uploader</h3>
                </div> <!-- /card-header -->
                <div class="card-body">
                    <form method="post" action="{{ route('sales_contract',$sale->id) }}" enctype="multipart/form-data"
                        class="dropzone dz-clickable" id="image upload" />
                    @csrf
                    @method('put')
                    <div>
                        <h3 class="text-center">Upload Image By Click On Box</h3>
                    </div>
                    <div class="dz-default dz-message">
                        <span>Drop file here to upload</span>
                    </div>
                    </form>
                </div> <!-- /card-body -->
            </div> <!-- /card -->

            <div class="card">
                <div class="card-header">
                    <h3>Uploaded Images</h3>
                </div> <!-- /card-header -->
                <div class="card-body">
                    <div class="row" id="attachments">
                        @foreach($sale->SalesAttachment as $images)
                        <div class="col-md-3">
                            <figure>
                                <span>{{ $images->file_name }}</span>
                                @php
                                $isPDF = str_contains($images->file_name, '.pdf');
                                if ($isPDF) {
                                $file_path = 'public/uploads/sales/'.$images->file_name;
                                $image_path= 'public/uploads/sales/PDF_file.png';
                                }else {
                                $file_path= 'public/uploads/sales/'.$images->file_name;
                                $image_path= 'public/uploads/sales/'.$images->file_name;
                                }
                                @endphp
                                <a href="{{asset( $file_path)}}" target="_blank" class="file_perview">
                                    <img src="{{ asset( $image_path) }}">
                                </a>
                                <span id="{{ $images->id }}" class="caption">
                                    <caption>Remove Image</caption>
                                </span>
                            </figure>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div> <!-- /end of content box -->
        <div class="clearfix"></div>
    </div>
</div> <!-- /end of page content -->
@endsection

@section('style')
<style>
    #attachments img,
    #NocAttachment img {
        width: 100%;
        height: auto;
        max-height: 400px;
        object-fit: contain;
    }

    #attachments figure {
        border-bottom: 2px solid #eee;
        padding-bottom: 10px;
    }

    .caption {
        display: block;
        text-align: center;
        cursor: pointer;
        font-weight: bold;
        padding-bottom: 10px;
        margin-top: 15px;
    }
</style>
@endsection

@section('script')
<script type="text/javascript">
    jQuery(document).ready(function(){

        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone(".dropzone", {
           maxFilesize: 10,
           acceptedFiles: ".jpeg,.jpg,.png,.gif,.pdf",
           addRemoveLinks: true,

           removedfile: function(file) {
            var fileName = file.name;

            jQuery.ajax({
            type: 'POST',
            url: '{{ route('file.remove') }}',
            data: { "_token": "{{ csrf_token() }}", fileName: fileName},
            success:function(){
            	jQuery.ajax({
		           url:"{{ route('saleFiles') }}",
		           method:'post',
		           data:{
		                "_token": "{{ csrf_token() }}",
		                id:"{{ $sale->id }}",
		            },
		           success:function(response){
		             jQuery('#attachments').empty().html(response);
		           }
		        });
            }
            });

            var fileRef;

            return (fileRef = file.previewElement) != null ?
            fileRef.parentNode.removeChild(file.previewElement) : void 0;

           },
           success:function(response){
           		jQuery.ajax({
		           url:"{{ route('saleFiles') }}",
		           method:'post',
		           data:{
		                "_token": "{{ csrf_token() }}",
		                id:"{{ $sale->id }}",
		            },
		           success:function(response){
		             jQuery('#attachments').empty().html(response);
		           }
		        });
           }
        });

        jQuery(document).on('click','.caption',function(){
        	var id = jQuery(this).attr('id');

        	jQuery.ajax({
            type: 'POST',
            url: '{{ route('file.remove') }}',
            data: { "_token": "{{ csrf_token() }}", id: id},
            success:function(){
            	jQuery.ajax({
		           url:"{{ route('saleFiles') }}",
		           method:'post',
		           data:{
		                "_token": "{{ csrf_token() }}",
		                id:"{{ $sale->id }}",
		            },
		           success:function(response){
		             jQuery('#attachments').empty().html(response);
		           }
		        });
            }
            });

        });
   });
</script>
@endsection