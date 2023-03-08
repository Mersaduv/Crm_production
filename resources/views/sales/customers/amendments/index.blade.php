@extends('sales.layouts.app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Amendments</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('sales.customers.amends') }}
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
                                        Filter <span id="filter-count">{{ $customers->total() }}</span>
                                    </div>
                                    <i class="more-less mdi mdi-plus"></i>
                                </a>
                            </div>

                            <div id="collapse-1" class="collapse" role="tabpanel" aria-labelledby="heading-1"
                                data-parent="#accordion-2">
                                <div class="card-body">
                                    <div class="panel-body">
                                        <form method="get" action="{{ route('customer.ameds') }}">
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
                                                        <label for="act">
                                                            Activation Date:
                                                        </label>
                                                        <input type="date" name="act" id="act" class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="amend">
                                                            Amendment Date:
                                                        </label>
                                                        <input type="date" name="amend" id="amend"
                                                            class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="actStart">
                                                            Activation Date:
                                                        </label>
                                                        <input type="date" name="actStart" id="actStart"
                                                            class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="actEnd">
                                                            End Date:
                                                        </label>
                                                        <input type="date" name="actEnd" id="actEnd"
                                                            class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="amendStart">
                                                            Amendment Date:
                                                        </label>
                                                        <input type="date" name="amendStart" id="amendStart"
                                                            class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="amendEnd">End Date:</label>
                                                        <input type="date" name="amendEnd" id="amendEnd"
                                                            class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="finance">Finance Status:</label>
                                                        <select class="form-control" name="finance" id="finance">
                                                            <option value="">Select Option</option>
                                                            <option value="1">Updated</option>
                                                            <option value="0">Not Updated</option>
                                                        </select>
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="noc">NOC Status:</label>
                                                        <select class="form-control" name="noc" id="noc">
                                                            <option value="">Select Option</option>
                                                            <option value="1">Updated</option>
                                                            <option value="0">Not Updated</option>
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

            <div class="card" id="filter-area-amend">
                <div class="card-header">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link filter-area-amend mr-2 active" type="button" role="tab"
                                attr="accepted">Amendments</button>
                            <button class="nav-link filter-area-amend mr-2" type="button" role="tab" attr="pending">
                                Amendment Requests
                                <span class="badge badge-info">
                                    {{ amends('sales_confirmation')['penddingAmend'] }}
                                </span>
                            </button>

                            <button class="nav-link filter-area-cancel-amend mr-2" type="button" role="tab"
                                attr="cancels">
                                Canceled Amendments
                                <span class="badge badge-info">
                                    {{ amends('sales_confirmation')['canceledAmend'] }}
                                </span>
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
                                <th>Package</th>
                                <th>Activation Date</th>
                                <th>Amendment Date</th>
                                @canany(['view'], AmendmentFullyQualifiedNameSpace())
                                <th>Operation</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($customers) > 0)
                            <?php
                                    $page = request('page') ? request('page') : 1;
                                    $index = 15 * $page - 14;
                                    ?>

                            @foreach ($customers as $customer)
                            <tr>
                                <th>{{ $index }}</th>
                                <th>{{ $customer->customer_id }}</th>
                                <th>{{ $customer->full_name }}</th>
                                <th>
                                    {{ $customer->package ? $customer->package->name : 'NA' }}
                                </th>
                                <th>{{ $customer->customer->noc->activation_date }}</th>
                                <th>{{ $customer->amend_date }}</th>
                                @canany(['view'], AmendmentFullyQualifiedNameSpace())
                                <td>
                                    <div class="action_dropdown_area">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-primary dropdown-toggle"
                                                data-toggle="dropdown">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu">
                                                @can('view', AmendmentFullyQualifiedNameSpace())
                                                <a class="dropdown-item"
                                                    href="{{ route('amedment.amend', $customer->id) }}">
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
                            @else
                            <tr>
                                <th colspan="7">No Data Found!</th>
                            </tr>
                            @endif
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