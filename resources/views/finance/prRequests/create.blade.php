@extends('finance.layouts.app')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Terminate Requests</h4>
                
                <div class="history">

                    <div class="row">
                        <div class="col-sm-6">
                            {{ Breadcrumbs::render('tr.finance.add') }}
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
                    <form method="post" action="{{ route('trRequests.store') }}">
                        @csrf
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="customer" class="required">Customer:</label>
                                        <input type="text" 
                                               name="customer" 
                                               id="customer"
                                               autocomplete="off" 
                                               class="form-control" 
                                               placeholder="Customer Name:" 
                                               required="required"
                                            />
                                        <ul id="customer_list"></ul>
                                        <input type="hidden" 
                                              name="customer_id" 
                                              id="customer_id"
                                              value="" 
                                            />
                                    </div>
                                </div> <!-- /col -->

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="request_date" class="required">Request Date:</label>
                                        <input type="date" 
                                               name="request_date" 
                                               class="form-control"
                                               id="request_date" 
                                               required="required" 
                                            />
                                    </div>
                                </div> <!-- /col -->

                                <div class="col-md-4">
                                     <div class="form-group">
                                         <label for="reason" class="required">Terminate Reason:</label>
                                         <textarea class="form-control" 
                                                   name="reason" 
                                                   id="reason"
                                                   placeholder="Terminate Reason:" 
                                                   rows="3" 
                                                   required="required" 
                                                   ></textarea>
                                     </div>
                                </div> <!-- /col -->
                            </div> <!-- /row -->

                        </div> <!-- /card-body -->
                        <div class="card-footer text-right">
                            <button class="btn btn-secondary" type="reset">
                                Reset
                            </button>
                            <button class="btn btn-success" type="submit">
                                Submit
                            </button>
                        </div> <!-- /card-footer -->
                    </form>
                </div> <!-- /card -->

            </div> <!-- /content-box -->
        </div>
        <div class="clearfix"></div>
    </div> <!-- /end of page content -->
@endsection

@section('style')
  <style>
    
  </style>
@endsection

@section('script')
<script type="text/javascript">
   jQuery(document).ready(function(){

        jQuery('#customer').off().on('keyup',function(e){
            e.preventDefault();
            var data = jQuery(this).val();
                
            jQuery.ajax({
               url:"{{ route('getCustomer') }}",
               method:'post',
               data:{
                    "_token": "{{ csrf_token() }}",
                    search:data, 
                },
               success:function(response){

                 if(response == 'false'){
                    $('#customer').css('border-color','red');
                 }else{
                    $('#customer').css('border-color','#ced4da');
                    jQuery('#customer_list').empty().append(response);
                 }

               },
               complete:function(){
                 if(data.length == 0){
                    $('#customer').css('border-color','#ced4da');
                    jQuery('#customer_list').empty();
                 }   
               }
            });
            
        });

        $('#customer').on('change', function(){
        var val = $(this).val();
        var opts = document.getElementById('customer_list').childNodes;
        for (var i = 0; i < opts.length; i++) {
          if (opts[i].value === val) {
            document.getElementById("customer_id").value = opts[i].getAttribute('id');
            break;
          }else{
            document.getElementById("customer_id").value = " ";
          }
        }
    });

   });
</script>
@endsection