@extends('finance.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Requests</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('request',$request) }}
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

            <div class="row">
                <div class="col-sm-12">

                    <div class="card">
                        <div class="card-header">
                            <h4>Terminate Request</h4>
                        </div>

                        <div class="card-body">
                            <table class="table" id="my-table">
                                <tr>
                                    <th>Customer Name:</th>
                                    <td>{{ $request->customer->full_name }}</td>
                                </tr>
                                <tr>
                                    <th>Sent By:</th>
                                    <td>{{ $request->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Request Date:</th>
                                    <td>{{ $request->request_date }}</td>
                                </tr>
                                <tr>
                                    <th>Request Reason:</th>
                                    <td>{{ $request->reason }}</td>
                                </tr>
                            </table> <!-- /table -->
                        </div>
                    </div> <!-- /card -->

                </div> <!-- /col-9 -->

            </div> <!-- /row -->

        </div> <!-- /content-box -->
    </div>
    <div class="clearfix"></div>
</div> <!-- /end of page content -->
@endsection

@section('style')
<style>
    button {
        width: 100%;
        margin: 3px 0;
    }
</style>
@endsection

@section('script')
<script type="text/javascript">

</script>
@endsection