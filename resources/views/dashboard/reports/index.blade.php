@extends('dashboard.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Reports</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('reports.index') }}
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
                <div class="card-header">
                    <h2>Customers Reports:</h2>
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-4">
                            <a href="{{ route('reports.installation') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Total Customers</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('reports.customers') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Activated Customers</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('reports.terminates') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Terminates</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('reports.recontract') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Re-contracted</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('reports.suspends') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Suspends</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('reports.reactivate') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Re-activted</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('reports.amendments') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Amendments</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('reports.cancel.amendments') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Canceled Amendments</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('reports.cancels') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Canceled Installations</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('reports.device') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Device Types</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('reports.base') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Branch Types</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('reports.package') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Package Types</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>
                </div>
            </div>

        </div> <!-- /content-box -->
    </div>
    <div class="clearfix"></div>
</div> <!-- /end of page content -->

<div class="row">
    <div class="col-sm-12">
        <div class="page-content-box">

            <div class="card">
                <div class="card-header">
                    <h2>Customers Charts:</h2>
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-4">
                            <a href="{{ route('charts.customers') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h3>Total Customers</h3>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('charts.activated') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Activated Customers</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('charts.terminates') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Terminates</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('charts.recontract') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Re-contracted</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('charts.suspends') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Suspends</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('charts.reactivate') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Re-activated</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('charts.amendments') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Amendments</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('charts.cancels.amendments') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Canceled Amendments</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('charts.cancels') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Canceled Installations</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('charts.device') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Device Types</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('charts.branch') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Branch Types</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('charts.package') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Package Types</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>
                </div>
            </div>

        </div> <!-- /content-box -->
    </div>
    <div class="clearfix"></div>
</div> <!-- /end of page content -->
@endsection

@section('style')
<style>
    .report-card {
        background-color: #eff3f6;
    }
</style>
@endsection

@section('script')
<script type="text/javascript">
    jQuery(document).on('ready',function(){

   });
</script>
@endsection