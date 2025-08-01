@extends('dashboard.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Resellers Reports</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('outsource.reports.resellers') }}
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
                                        <form method="get" action="{{ route('outsource.reports.resellers') }}">
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

                                                <div class="col-md-3" id="resellers_col">
                                                    <div class="form-group">
                                                        <label for="commission">
                                                            Reseller:
                                                        </label>
                                                        <input type="text" name="commission" id="commission"
                                                            autocomplete="off" class="form-control"
                                                            placeholder="Reseller Name:"
                                                            value="{{ request('commission') ? request('commission') : '' }}" />
                                                        <ul id="commission_list"></ul>
                                                        <input type="hidden" name="commission_id" id="commission_id"
                                                            value="{{ request('commission_id') ? request('commission_id') : '' }}" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="ins">Exact Date (Installation):</label>
                                                        <input type="date" name="ins" id="ins"
                                                            value="{{ request('ins') ? request('ins') : '' }}"
                                                            class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="insStart">
                                                            Start Date (Installation):
                                                        </label>
                                                        <input type="date" name="insStart" id="insStart"
                                                            value="{{ request('insStart') ? request('insStart') : '' }}"
                                                            class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="insEnd">End Date (Installation):</label>
                                                        <input type="date" name="insEnd" id="insEnd"
                                                            value="{{ request('insEnd') ? request('insEnd') : '' }}"
                                                            class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

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
                    <a href="{{ route('provincial.export-resellers')}}" class="btn btn-primary" target="__blank">
                        Export All To CSV
                    </a>
                    <button class="btn btn-primary"
                        onclick="$('table').table2csv({ filename: 'provincial-resellers-report.csv' });">
                        Export To CSV
                    </button>
                </div>
                <div class="card-body">
                    <table class="table text-center" id="my-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Package</th>
                                <th>Installation Date</th>
                                <th>Province</th>
                                <th>Provider</th>
                                <th>Reseller</th>
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
                                <th>
                                    {{ $customer->package ? $customer->package->name : 'NA' }}
                                </th>
                                <th>{{ $customer->installation_date }}</th>
                                <th>{{province($customer->province)}}</th>
                                <th>{{
                                    $customer->provider ?
                                    $customer->provider->name : 'NA'
                                    }}
                                </th>
                                <th>{{ $customer->commission ? $customer->commission->name : 'NA' }}</th>
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
    #resellers_col {
        display: block !important;
    }
</style>
@endsection

@section('script')
<script src="{{ asset('/public/assets/js/table2csv.js') }}"></script>
<script type="text/javascript">
    jQuery(document).on('ready',function(){

   });
</script>
@endsection