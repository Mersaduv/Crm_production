@extends('dashboard.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Cancel Amendments Reports</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('outsource.reports.cancelAmendments') }}
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
                                        <form method="get" action="{{ route('outsource.reports.cancelAmendments') }}">
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
                                                        <label for="amend">
                                                            Amendment Date:
                                                        </label>
                                                        <input type="date" name="amend" id="amend"
                                                            value="{{ request('amend') ? request('amend') : '' }}"
                                                            class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="cancel">
                                                            Cancel Date:
                                                        </label>
                                                        <input type="date" name="cancel" id="cancel"
                                                            value="{{ request('cancel') ? request('cancel') : '' }}"
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
                                                        <label for="cancel_date">
                                                            Cancel Date:
                                                        </label>
                                                        <input type="date" name="cancel_date" id="cancel_date"
                                                            value="{{ request('cancel_date') ? request('cancel_date') : '' }}"
                                                            class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="cancel_end">End Date:</label>
                                                        <input type="date" name="cancel_end" id="cancel_end"
                                                            value="{{ request('cancel_end') ? request('cancel_end') : '' }}"
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
                    <a href="{{ route('provincial.export-cance-amendments')}}" class="btn btn-primary" target="__blank">
                        Export All To CSV
                    </a>
                    <button class="btn btn-primary"
                        onclick="$('#my-table').table2csv({ filename: 'provincial-cancel-amendments-report.csv' });">
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
                                <th>Amendment Date</th>
                                <th>Cancel Date</th>
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
                                <th>{{ $customer->amend->amend_date }}</th>
                                <th>{{ $customer->cancel_date }}</th>
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