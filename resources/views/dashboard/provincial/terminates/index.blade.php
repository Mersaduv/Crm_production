@extends('dashboard.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Terminate Customers</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('manager.pr.terminates') }}
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
                                        Filter <span id="filter-count">{{ $customers->total() }}</span>
                                    </div>
                                    <i class="more-less mdi mdi-plus"></i>
                                </a>
                            </div>

                            <div id="collapse-1" class="collapse" role="tabpanel" aria-labelledby="heading-1"
                                data-parent="#accordion-2">
                                <div class="card-body">
                                    <div class="panel-body">
                                        <form method="get" action="{{ route('admin.terminates') }}">
                                            @csrf
                                            <div class="row">

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="id">Customer ID:</label>
                                                        <input type="text" name="id" id="id" class="form-control"
                                                            placeholder="Customer ID" autocomplete="off" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="name">Full Name:</label>
                                                        <input type="text" name="name" id="name" placeholder="Full Name"
                                                            class="form-control" autocomplete="off" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="StartActDate">
                                                            Activation Date:
                                                        </label>
                                                        <input type="date" name="StartActDate" id="StartActDate"
                                                            class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="StartTerDate">
                                                            Termination Date:
                                                        </label>
                                                        <input type="date" name="StartTerDate" id="StartTerDate"
                                                            class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="actDate">
                                                            Activation Date:
                                                        </label>
                                                        <input type="date" name="actDate" id="actDate"
                                                            class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="actEndDate">
                                                            End Date:
                                                        </label>
                                                        <input type="date" name="actEndDate" id="actEndDate"
                                                            class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="terDate">
                                                            Terminate Date:
                                                        </label>
                                                        <input type="date" name="terDate" id="terDate"
                                                            class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="terEndDate">End Date:</label>
                                                        <input type="date" name="terEndDate" id="terEndDate"
                                                            class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="province">Province:</label>
                                                        <select name="province" id="province" class="form-control">
                                                            <option value="">Select Province</option>
                                                            @foreach ($provinces as $province)
                                                            <option value="{{ $province->name }}">
                                                                {{ province($province->name) }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="noc">Noc Confirmation:</label>
                                                        <select name="noc" id="noc" class="form-control">
                                                            <option value="">Select Option</option>
                                                            <option value="true">Confirmed</option>
                                                            <option value="false">Not Confirmed</option>
                                                        </select>
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="finance">Finance Confirmation:</label>
                                                        <select name="finance" id="finance" class="form-control">
                                                            <option value="">Select Option</option>
                                                            <option value="true">Confirmed</option>
                                                            <option value="false">Not Confirmed</option>
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

            <div class="card" id="filter-area-pr-terminate">
                <div class="card-header">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link filter-area-pr-terminate  mr-2 active" type="button" role="tab"
                                attr="terminate">Terminates</button>
                            <button class="nav-link filter-area-pr-terminate mr-2" type="button" role="tab"
                                attr="pending">
                                Terminate Requests

                            </button>
                            <button class="nav-link filter-area-pr-recontract-terminate mr-2" type="button" role="tab"
                                attr="recontract">
                                Recontraction Requests
                            </button>
                        </div>
                    </nav>
                </div> <!-- /card-header -->
                <div class="card-body">
                    <table class="table" id="my-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Province</th>
                                <th>Customer Province</th>
                                <th>Activation Date</th>
                                <th>Termination Date</th>
                                @canany(['view'], ProvincialTerminateFullyQualifiedNameSpace())
                                <th>Operation</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $page = request('page') ? request('page') : 1;
                                $index = 15 * $page - 14;
                                ?>
                            @foreach ($customers as $customer)
                            <tr>
                                <th>{{ $index }}</th>
                                <th>{{ $customer->customer_id }}</th>
                                <th>{{ $customer->full_name }}</th>
                                <th>{{ province($customer->province) }}</th>
                                <th>{{ province($customer->customerProvince) }}</th>
                                <th>
                                    @if ($customer->PrNocInfo()->exists())
                                    {{ $customer->PrNocInfo->activation_date }}
                                    @else
                                    NA
                                    @endif
                                </th>
                                <th>
                                    {{ $customer->terminate->first()->terminate_date }}
                                </th>
                                @canany(['view'], ProvincialTerminateFullyQualifiedNameSpace())
                                <td>
                                    <div class="action_dropdown_area">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-primary dropdown-toggle"
                                                data-toggle="dropdown">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu">
                                                @can('view', ProvincialTerminateFullyQualifiedNameSpace())
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.terminate', $customer->id) }}">
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
                            <?php $index++; ?>
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

    .card-header {
        text-align: right;
    }

    .filter-area-amend {
        min-width: 100px;
    }

    .nav-tabs {
        border-bottom: unset;
    }
</style>
@endsection

@section('script')
<script type="text/javascript">
    jQuery(document).on('ready', function() {

        });
</script>
@endsection