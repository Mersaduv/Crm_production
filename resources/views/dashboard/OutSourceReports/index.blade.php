@extends('dashboard.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Reports</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('outsource.reports.index') }}
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
                    <h2>Provincial Reports:</h2>
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-4">
                            <a href="{{ route('outsource.reports.installation') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Total Customers</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('outsource.reports.customers') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Activated Customers</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('outsource.reports.terminates') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Terminates</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('outsource.reports.recontract') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Re-contracted</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('outsource.reports.suspends') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Suspends</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('outsource.reports.reactivate') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Re-activated</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('outsource.reports.amendments') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Amendments</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('outsource.reports.cancelAmendments') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Canceled Amendments</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('outsource.reports.cancels') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Canceled Installations</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('outsource.reports.resellers') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Resellers</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('outsource.reports.base') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Branch Types</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('outsource.reports.package') }}" style="text-decoration: none;">
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
                    <h2>Provincial Charts:</h2>
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-4">
                            <a href="{{ route('outsource.charts.customers') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Total Customers</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('outsource.charts.activated') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Activated Customers</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('outsource.charts.terminates') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Terminates</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('outsource.charts.recontract') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Re-contracted</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('outsource.charts.suspends') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Suspends</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('outsource.charts.reactivate') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Re-activated</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('outsource.charts.amendments') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Amendments</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('outsource.charts.cancelAmendments') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Canceled Amendments</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('outsource.charts.cancels') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Canceled Installations</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('outsource.charts.resellers') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Resellers</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('outsource.charts.branch') }}" style="text-decoration: none;">
                                <div class="card text-center report-card">
                                    <div class="card-body">
                                        <h4>Branch Types</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('outsource.charts.package') }}" style="text-decoration: none;">
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