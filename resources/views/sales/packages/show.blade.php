@extends('sales.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Package</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('sales.package',$package) }}
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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>Package Information</h3>
                        </div> <!-- /card-header -->
                        <div class="card-body">
                            <table class="table" id="my-table">
                                <tbody>
                                    <tr>
                                        <th>Category</th>
                                        <td>{{ $package->category->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $package->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Price</th>
                                        <td>{{ $package->price }}</td>
                                    </tr>
                                    <tr>
                                        <th>Speed</th>
                                        <td>{{ $package->speed }}</td>
                                    </tr>
                                    <tr>
                                        <th>Duration</th>
                                        <td>{{ $package->duration }}</td>
                                    </tr>
                                    <tr>
                                        <th>Data</th>
                                        <td>{{ $package->data }}</td>
                                    </tr>
                                    <tr>
                                        <th>Daily Limit</th>
                                        <td>{{ $package->daily_limit }}</td>
                                    </tr>
                                    <tr>
                                        <th>Active Hours</th>
                                        <td>{{ $package->active_hrs }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> <!-- /card-body -->
                    </div> <!-- /card -->
                </div> <!-- /col-9 -->

            </div> <!-- /row -->
        </div>
    </div>
    <div class="clearfix"></div>
</div> <!-- /end of page content -->
@endsection

@section('style')
<style>
    .customer_operation button {
        display: block;
        width: 100%;
        margin: 5px 0px;
    }

    .customer_operation button a {
        color: #fff;
    }

    .modal-dialog {
        max-width: 800px;
    }

    .modal-dialog img {
        width: 100%;
        height: auto;
        object-fit: cover;
    }
</style>
@endsection

@section('script')
<script type="text/javascript">

</script>
@endsection