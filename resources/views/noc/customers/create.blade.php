@extends('noc.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Insert Customer</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('noc.process',$customer) }}
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
                <div class="card-body">

                    <form method="post" action="{{ route('installation.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="installer" class="required">
                                        Installer Name:
                                    </label>
                                    <input type="text" name="installer" class="form-control"
                                        placeholder="Installer Name:" id="installer" autocomplete="off"
                                        required="required" />
                                </div>
                            </div> <!-- /col -->

                            <input type="hidden" name="mac" id="mac" value="{{ $customer->sale->equi_type }}" />

                            <input type="hidden" name="customer_id" id="customer_id" value="{{ $customer->id }}" />

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="activation_date" class="required">
                                        Activation Date:
                                    </label>
                                    <input type="date" name="activation_date" class="form-control"
                                        placeholder="Activation Date:" id="activation_date" autocomplete="off"
                                        required="required" />
                                </div>
                            </div> <!-- /col -->

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cable_length">
                                        Cable Length:
                                    </label>
                                    <input type="number" name="cable_length" class="form-control"
                                        placeholder="Cable Length:" id="cable_length" autocomplete="off" />
                                </div>
                            </div> <!-- /col -->

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="reciever_mac" id="mac_label" class="required">
                                        Receiver Mac:
                                    </label>
                                    <input type="text" name="reciever_mac" class="form-control"
                                        placeholder="aa:aa:aa:aa:aa:aa" id="reciever_mac" maxlength="17"
                                        autocomplete="off" style="text-transform: uppercase" required="required" />
                                </div>
                            </div> <!-- /col -->

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="latitiude">Latitude:</label>
                                    <input type="text" name="latitiude" class="form-control" placeholder="Latitiude:"
                                        id="latitiude" autocomplete="off" required />
                                </div>
                            </div> <!-- /col -->

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="longitude">Longitude:</label>
                                    <input type="text" name="longitude" class="form-control" placeholder="Longitude:"
                                        id="longitude" autocomplete="off" required />
                                </div>
                            </div> <!-- /col -->

                            <div class="col-md-3">
                                <div class="input-group">
                                    <label for="additional_fee" class="required">
                                        Additional Fee Reason:
                                    </label>
                                    <input type="text" name="additional_fee" class="form-control"
                                        placeholder="Additional Fee Reason:" id="additional_fee" autocomplete="off"
                                        required="required" />
                                </div>
                            </div> <!-- /col -->

                            <div class="col-md-3">
                                <div class="input-group">
                                    <label for="additional_fee_price" class="required">
                                        Additional Fee Price:
                                    </label>
                                    <input type="number" name="additional_fee_price" class="form-control"
                                        placeholder="Additional Fee Price:" id="additional_fee_price" autocomplete="off"
                                        required="required" />
                                    <div class="input-group-append">
                                        <select class="form-control" name="additional_fee_currency">
                                            <option value="AFG">AFG</option>
                                            <option value="Dollar">Dollar</option>
                                        </select>
                                    </div>
                                </div>
                            </div> <!-- /col -->

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="receiver_type" class="required">
                                        Receiver Type:
                                    </label>
                                    <input type="text" name="receiver_type" id="receiver_type" class="form-control"
                                        placeholder="Receiver Type:" autocomplete="off" required="required" />
                                    <ul id="receiver_type_list"></ul>
                                    <input type="hidden" name="receiver_type_id" id="receiver_type_id" value="" />
                                </div>
                            </div> <!-- /col -->

                            <input type="hidden" name="customer_id" value="{{ $customer->id }}">

                        </div> <!-- /row -->

                        <div class="card-footer">
                            <button type="reset" class="btn btn-secondary">
                                Reset
                            </button>
                            <button type="submit" class="btn btn-primary" id="submit">
                                Submit
                            </button>
                        </div>

                    </form>

                </div>
                <!--/card-body -->
            </div> <!-- /card -->

            <div class="card">
                <div class="card-header">
                    <h3>NOC Attachments uploader</h3>
                </div> <!-- /card-header -->
                <div class="card-body">
                    <form method="post" action="{{ route('installation_contract',$customer->id) }}"
                        enctype="multipart/form-data" class="dropzone dz-clickable" id="image upload">
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
                        @foreach($customer->NocAttachment as $images)
                        <div class="col-md-3">
                            <figure>
                                <a href="{{asset('public/uploads/noc/'.$images->file)}}" target="_blank">
                                    <img src="{{ asset('public/uploads/noc/'.$images->file) }}">
                                </a>
                                <span id="{{ $images->id }}" class="caption">
                                    <caption>Remove Image</caption>
                                </span>
                            </figure>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div> <!-- /card -->

        </div>
    </div>
    <div class="clearfix"></div>
</div> <!-- /end of page content -->
@endsection

@section('style')
<style>
    .card-footer {
        text-align: right;
    }

    #attachments img,
    #SalesAttachment img {
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

    // Image uploader js scripts
    Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone(".dropzone", {
           maxFilesize: 10,
           acceptedFiles: ".jpeg,.jpg,.png,.gif",
           addRemoveLinks: true,
           removedfile: function(file) {
            var fileName = file.name;

            jQuery.ajax({
            type: 'POST',
            url: '{{ route('noc.remove') }}',
            data: { "_token": "{{ csrf_token() }}", fileName: fileName},
            success:function(){
                jQuery.ajax({
                   url:"{{ route('nocFiles') }}",
                   method:'post',
                   data:{
                        "_token": "{{ csrf_token() }}",
                        id:"{{ $customer->id }}",
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
                   url:"{{ route('nocFiles') }}",
                   method:'post',
                   data:{
                        "_token": "{{ csrf_token() }}",
                        id:"{{ $customer->id }}",
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
            url: '{{ route('noc.remove') }}',
            data: { "_token": "{{ csrf_token() }}", id: id},
            success:function(){
                jQuery.ajax({
                   url:"{{ route('nocFiles') }}",
                   method:'post',
                   data:{
                        "_token": "{{ csrf_token() }}",
                        id:"{{ $customer->id }}",
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
