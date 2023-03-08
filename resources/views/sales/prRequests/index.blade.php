@extends('sales.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Requests</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('sales.pr.requests') }}
                    </div>
                    <div class="col-sm-6 historyBTN">
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
                <div class="filter-area">

                    <div id="accordion-2" role="tablist">

                        <div class="card shadow-none mb-0">
                            <div class="card-header" role="tab" id="heading-1">
                                <a data-toggle="collapse" href="#collapse-1" aria-expanded="true"
                                    aria-controls="collapse-1" class="collapse-icons">
                                    <i class="fas fa-filter"></i>
                                    <div class="badge badge-success">
                                        Filter {{ $requests->total() }}
                                    </div>
                                    <i class="more-less mdi mdi-plus"></i>
                                </a>
                            </div>

                            <div id="collapse-1" class="collapse" role="tabpanel" aria-labelledby="heading-1"
                                data-parent="#accordion-2">
                                <div class="card-body">
                                    <div class="panel-body">
                                        <form method="get" action="{{ route('PrRequests.index') }}">
                                            @csrf
                                            <div class="row">

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="customer">
                                                            Customer:
                                                        </label>
                                                        <input type="text" name="customer" id="customer"
                                                            list="customer_list" autocomplete="off" class="form-control"
                                                            placeholder="Customer Name:" />
                                                        <datalist id="customer_list"></datalist>
                                                        <input type="hidden" name="customer_id" id="customer_id"
                                                            value="" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="state">Request Status:</label>
                                                        <select name="status" class="form-control">
                                                            <option value="">Select Status</option>
                                                            <option value="Accepted">Accepted</option>
                                                            <option value="Rejected">Rejected</option>
                                                            <option value="Pending">Pending</option>
                                                        </select>
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="sender">Sent By:</label>
                                                        <select class="form-control" id="sender" name="sender">
                                                            <option value="">Choose Sender</option>
                                                            <option value="finance">Finance</option>
                                                            <option value="noc">NOC</option>
                                                        </select>
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="date">Request Date:</label>
                                                        <input type="date" name="date" class="form-control" id="date" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="start">Start Date:</label>
                                                        <input type="date" name="start" class="form-control"
                                                            id="start" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="end">End Date:</label>
                                                        <input type="date" name="end" class="form-control" id="end" />
                                                    </div>
                                                </div> <!-- /col -->

                                            </div> <!-- /row -->

                                            <div class="card-footer">
                                                <button class="btn btn-primary" type="submit">
                                                    Submit
                                                </button>
                                                <button class="btn btn-secondary" type="reset">
                                                    Reset
                                                </button>
                                            </div>

                                        </form> <!-- /form -->
                                    </div>
                                </div>
                            </div>
                        </div> <!-- /card -->

                    </div> <!-- // accoridan -->

                </div> <!-- /filter-area -->
            </div> <!-- /filter-card -->

            <div class="card">
                <div class="card-header"></div> <!-- /card-header -->
                <div class="card-body">
                    <table class="table" id="my-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer Name</th>
                                <th>Request Date</th>
                                <th>Sent By</th>
                                <th>Status</th>
                                <th>Operation</th>
                            </tr>
                        </thead>
                        <tbody id="pr_table_requests">
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
                                <td class="">
                                    <div class="action_dropdown_area">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-primary dropdown-toggle"
                                                data-toggle="dropdown">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu">

                                                <a class="dropdown-item"
                                                    href="{{route('PrRequests.show',$request->id) }}">
                                                    <i class="fas fa-info info"></i>
                                                    Details
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php $index ++ ?>
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- /card-body -->
                <div class="card-footer">
                    <div class="pagination">
                        {{ $requests->links() }}
                    </div>
                </div> <!-- /card-footer -->
            </div> <!-- /card -->

        </div> <!-- /content-box -->
    </div>
    <div class="clearfix"></div>
</div> <!-- /end of page content -->
@endsection

@section('style')
<style>
    .operation a {
        background: #44a2d2;
        color: #fff;
        border-radius: 5px;
        padding: 4px 0px;
        padding-left: 6px;
        font-size: 13px;
        padding-right: 6px;
    }
</style>
@endsection

@section('script')
<script type="text/javascript">
    jQuery(document).on('ready',function(){


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