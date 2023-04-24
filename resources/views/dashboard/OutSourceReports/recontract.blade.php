@extends('dashboard.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Recontract Reports</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('outsource.reports.recontract') }}
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
                <div class="filter-area">

                    <div id="accordion-2" role="tablist">

                        <div class="card shadow-none mb-0">
                            <div class="card-header" role="tab" id="heading-1">
                                <a data-toggle="collapse" href="#collapse-1" aria-expanded="true"
                                    aria-controls="collapse-1" class="collapse-icons">
                                    <i class="fas fa-filter"></i>
                                    <div class="badge badge-success">
                                        Filter {{ $customers->total() }}
                                    </div>
                                    <i class="more-less mdi mdi-plus"></i>
                                </a>
                            </div>

                            <div id="collapse-1" class="collapse {{ $isFilter == 'true' ? 'show' : '' }}"
                                role="tabpanel" aria-labelledby="heading-1" data-parent="#accordion-2">
                                <div class="card-body">
                                    <div class="panel-body">
                                        <form method="get" action="{{ route('outsource.reports.recontract') }}">
                                            @csrf
                                            <div class="row">

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="id">Customer ID:</label>
                                                        <input type="text" name="id" id="id"
                                                            value="{{ request('id') ? request('id') : '' }}"
                                                            class="form-control" placeholder="Customer ID"
                                                            autocomplete="off" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="name">Full Name:</label>
                                                        <input type="text" name="name" id="name"
                                                            value="{{ request('name') ? request('name') : '' }}"
                                                            placeholder="Full Name" class="form-control"
                                                            autocomplete="off" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="terminate">
                                                            Terminate Date:
                                                        </label>
                                                        <input type="date" name="terminate" id="terminate"
                                                            value="{{ request('terminate') ? request('terminate') : '' }}"
                                                            class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="activation">
                                                            Recontract Date:
                                                        </label>
                                                        <input type="date" name="activation" id="activation"
                                                            value="{{ request('activation') ? request('activation') : '' }}"
                                                            class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="terStart">
                                                            Terminate Date:
                                                        </label>
                                                        <input type="date" name="terStart" id="terStart"
                                                            value="{{ request('terStart') ? request('terStart') : '' }}"
                                                            class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="terEnd">End Date:</label>
                                                        <input type="date" name="terEnd" id="terEnd"
                                                            value="{{ request('terEnd') ? request('terEnd') : '' }}"
                                                            class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="actStart">
                                                            Recontract Date:
                                                        </label>
                                                        <input type="date" name="actStart" id="actStart"
                                                            value="{{ request('actStart') ? request('actStart') : '' }}"
                                                            class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="actEnd">End Date:</label>
                                                        <input type="date" name="actEnd" id="actEnd"
                                                            value="{{ request('actEnd') ? request('actEnd') : '' }}"
                                                            class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="province">Province:</label>
                                                        <select name="province" id="province" class="form-control">
                                                            <option value="">Select Province</option>
                                                            @foreach($provinces as $province)
                                                            <option value="{{ $province->name }}" {{
                                                                request('province')==$province->name ? 'selected' : ''
                                                                }}>
                                                                {{ province($province->name) }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div> <!-- /col-->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="per_page">Select Items:</label>
                                                        <select name="per_page" id="per_page" class="form-control">
                                                            <option value="">Choose Items Per Page</option>
                                                            <option value="20" {{ request('per_page')=='20' ? 'selected'
                                                                : '' }}>20</option>
                                                            <option value="30" {{ request('per_page')=='30' ? 'selected'
                                                                : '' }}>30</option>
                                                            <option value="40" {{ request('per_page')=='40' ? 'selected'
                                                                : '' }}>40</option>
                                                            <option value="50" {{ request('per_page')=='50' ? 'selected'
                                                                : '' }}>50</option>
                                                            <option value="80" {{ request('per_page')=='80' ? 'selected'
                                                                : '' }}>80</option>
                                                            <option value="100" {{ request('per_page')=='100'
                                                                ? 'selected' : '' }}>100</option>
                                                            <option value="{{ $customers->total() }}" {{
                                                                request('per_page')==$customers->total() ? 'selected' :
                                                                '' }}>{{ $customers->total() }}</option>
                                                        </select>
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
                <div class="card-header">
                    <a href="{{ route('provincial.export.recontract')}}" class="btn btn-primary" target="__blank">
                        Export All To CSV
                    </a>
                    <button class="btn btn-primary"
                        onclick="$('#my-table').table2csv({ filename: 'provincial-recontracts-report.csv' });">
                        Export To CSV </button>
                </div>
                <div class="card-body">
                    <table class="table text-center" id="my-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Package</th>
                                <th>Province</th>
                                <th>Provider</th>
                                <th>Termination Date</th>
                                <th>Recontraction Date</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                    $page = request('page') ? request('page') : 1;
                                    $index = 15 * $page - 14;
                                ?>
                            @foreach($customers as $customer)
                            <tr>
                                <th>{{ $index }}</th>
                                <th>{{ $customer->customer_id }}</th>
                                <th>{{ $customer->full_name }}</th>
                                <th>{{ $customer->package ? $customer->package->name : 'NA' }}</th>
                                <th>{{ province($customer->province) }}</th>
                                <th>{{
                                    $customer->provincial->provider ?
                                    $customer->provincial->provider->name : 'NA'
                                    }}
                                </th>
                                <th>{{ $customer->terminate->terminate_date }}</th>
                                <th>{{ $customer->recontract_date }}</th>
                                @canany(['view'], ProvincialFullyQualifiedNameSpace())
                                <td>
                                    <div class="action_dropdown_area">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-primary dropdown-toggle"
                                                data-toggle="dropdown">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu">
                                                @can('view', ProvincialFullyQualifiedNameSpace())
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.pr.show', $customer->provincial->id) }}">
                                                    <i class="fas fa-info info"></i>
                                                    Details
                                                </a>
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                @endcanany
                            </tr>
                            <?php $index ++ ?>
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- /card-body -->
                <div class="card-footer">
                    <div class="pagination">
                        {{ $customers->links() }}
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

</style>
@endsection

@section('script')
<script src="{{ asset('/public/assets/js/table2csv.js') }}"></script>
<script type="text/javascript">
    jQuery(document).on('ready',function(){

   });
</script>
@endsection