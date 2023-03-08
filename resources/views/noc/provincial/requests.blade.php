@extends('noc.layouts.app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">New Requests</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('noc.pr.requests') }}
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
                                        Filter {{ $customers->total() }}
                                    </div>
                                    <i class="more-less mdi mdi-plus"></i>
                                </a>
                            </div>

                            <div id="collapse-1" class="collapse" role="tabpanel" aria-labelledby="heading-1"
                                data-parent="#accordion-2">
                                <div class="card-body">
                                    <div class="panel-body">
                                        <form method="get" action="{{ route('pr.noc.requests') }}">
                                            @csrf
                                            <div class="row">

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="id">Customer ID:</label>
                                                        <input type="number" name="id" id="id" class="form-control"
                                                            placeholder="Customer ID" autocomplete="off" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="name">Full Name:</label>
                                                        <input type="text" name="name" id="name" placeholder="Full Name"
                                                            class="form-control" autocomplete="off" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="province">Province:</label>
                                                        <select name="province" id="province" class="form-control">
                                                            <option value="">Select Province</option>
                                                            @foreach($provinces as $province)
                                                            <option value="{{ $province->name }}">{{
                                                                province($province->name) }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="date">Installation Date:</label>
                                                        <input type="date" name="date" id="date" class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="start">Start Date:</label>
                                                        <input type="date" name="start" id="start"
                                                            class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="end">End Date:</label>
                                                        <input type="date" name="end" id="end" class="form-control" />
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
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Package</th>
                                <th>Province</th>
                                <th>Customer Province</th>
                                <th>Installation Date</th>
                                <th>Activation Date</th>
                                @canany(['view'], ProvincialFullyQualifiedNameSpace())
                                <th>Operation</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody id="pr_noc_requests">
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
                                <th>{{ province($customer->province) }}</th>
                                <th>{{ province($customer->customerProvince) }}</th>
                                <th>{{ $customer->installation_date }}</th>
                                <th>
                                    {{ $customer->PrNocInfo()->exists() ? $customer->PrNocInfo->activation_date : 'NA'
                                    }}
                                </th>
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
                                                    href="{{ route('prCustomers.show',$customer->id) }}">
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
        </div>
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

    table {
        text-align: center;
    }
</style>
@endsection

@section('script')
<script type="text/javascript">

</script>
@endsection