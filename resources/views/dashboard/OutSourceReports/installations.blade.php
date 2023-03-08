@extends('dashboard.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Total Customers Reports</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('outsource.reports.installation') }}
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
                                        <form method="get" action="{{ route('outsource.reports.installation') }}">
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
                                                        <label for="finance">Finance Status:</label>
                                                        <select class="form-control" name="finance" id="finance">
                                                            <option value="">Select Option</option>
                                                            <option value="1" {{ request('finance')=='1' ? 'selected'
                                                                : '' }}>Updated</option>
                                                            <option value="0" {{ request('finance')=='0' ? 'selected'
                                                                : '' }}>Not Updated</option>
                                                        </select>
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="process">Process Status:</label>
                                                        <select class="form-control" name="process" id="process">
                                                            <option value="">Select Option</option>
                                                            <option value="pending" {{ request('process')=='pending'
                                                                ? 'selected' : '' }}>Pending</option>
                                                            <option value="cancel" {{ request('process')=='cancel'
                                                                ? 'selected' : '' }}>Cancel</option>
                                                            <option value="activate" {{ request('process')=='activate'
                                                                ? 'selected' : '' }}>Activate</option>
                                                            <option value="suspend" {{ request('process')=='suspend'
                                                                ? 'selected' : '' }}>Suspend</option>
                                                            <option value="terminate" {{ request('process')=='terminate'
                                                                ? 'selected' : '' }}>Terminate</option>
                                                            <option value="amendment" {{ request('process')=='amendment'
                                                                ? 'selected' : '' }}>Amendment</option>
                                                        </select>
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="insStart">
                                                            Installation Date:
                                                        </label>
                                                        <input type="date" name="insStart" id="insStart"
                                                            value="{{ request('insStart') ? request('insStart') : '' }}"
                                                            class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="insEnd">End Date:</label>
                                                        <input type="date" name="insEnd" id="insEnd"
                                                            value="{{ request('insEnd') ? request('insEnd') : '' }}"
                                                            class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="actStart">
                                                            Activation Date:
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
                                                        <label for="cancelStart">
                                                            Cancel Date:
                                                        </label>
                                                        <input type="date" name="cancelStart" id="cancelStart"
                                                            value="{{ request('cancelStart') ? request('cancelStart') : '' }}"
                                                            class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="cancelEnd">End Date:</label>
                                                        <input type="date" name="cancelEnd" id="cancelEnd"
                                                            value="{{ request('cancelEnd') ? request('cancelEnd') : '' }}"
                                                            class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="susStart">
                                                            Suspend Date:
                                                        </label>
                                                        <input type="date" name="susStart" id="susStart"
                                                            value="{{ request('susStart') ? request('susStart') : '' }}"
                                                            class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="susEnd">End Date:</label>
                                                        <input type="date" name="susEnd" id="susEnd"
                                                            value="{{ request('susEnd') ? request('susEnd') : '' }}"
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
                                                        <label for="amendStart">
                                                            Amendment Date:
                                                        </label>
                                                        <input type="date" name="amendStart" id="amendStart"
                                                            value="{{ request('amendStart') ? request('amendStart') : '' }}"
                                                            class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="amendEnd">End Date:</label>
                                                        <input type="date" name="amendEnd" id="amendEnd"
                                                            value="{{ request('amendEnd') ? request('amendEnd') : '' }}"
                                                            class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="cancelAmend">
                                                            Cancel Amendment Date:
                                                        </label>
                                                        <input type="date" name="cancelAmend" id="cancelAmend"
                                                            value="{{ request('cancelAmend') ? request('cancelAmend') : '' }}"
                                                            class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="cancelAmendEnd">End Cancel Date:</label>
                                                        <input type="date" name="cancelAmendEnd" id="cancelAmendEnd"
                                                            value="{{ request('cancelAmendEnd') ? request('cancelAmendEnd') : '' }}"
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
                    <a href="{{ route('provincial.export-total')}}" class="btn btn-primary" target="__blank">
                        Export All To CSV
                    </a>
                    <button class="btn btn-primary"
                        onclick="$('#my-table').table2csv({ filename: 'total-provincial-customers-report.csv' });">
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
                                <th>Province</th>
                                <th>Installation Date</th>
                                <th>Status</th>
                                <th>Status Date</th>
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
                                <th>{{ $customer->installation_date }}</th>
                                <th>{{ prStatus($customer->customer_id)['status'] }}</th>
                                <th>{{ prStatus($customer->customer_id)['date'] }}</th>
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