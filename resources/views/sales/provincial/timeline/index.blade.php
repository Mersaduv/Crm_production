@extends('sales.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Customers</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('contractors') }}
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
                                        <form method="get" action="{{ route('contractorsTimeline.index') }}">
                                            @csrf

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="id">Customer ID:</label>
                                                        <input type="text" name="id" class="form-control"
                                                            placeholder="Customer ID" id="id" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="name">Customer Name:</label>
                                                        <input type="text" name="name" class="form-control"
                                                            placeholder="Customer Name" id="name" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="activate">Activation Date:</label>
                                                        <input type="date" name="activate" class="form-control"
                                                            placeholder="Activation Date" id="activate" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="activateEnd">End Date:</label>
                                                        <input type="date" name="activateEnd" class="form-control"
                                                            placeholder="End Date" id="activateEnd" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="suspend">Suspend Date:</label>
                                                        <input type="date" name="suspend" class="form-control"
                                                            placeholder="Suspend Date" id="suspend" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="suspendEnd">End Date:</label>
                                                        <input type="date" name="suspendEnd" class="form-control"
                                                            placeholder="End Date" id="suspendEnd" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="terminate">Terminate Date:</label>
                                                        <input type="date" name="terminate" class="form-control"
                                                            placeholder="Terminate Date" id="terminate" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="terminateEnd">End Date:</label>
                                                        <input type="date" name="terminateEnd" class="form-control"
                                                            placeholder="End Date" id="terminateEnd" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="amend">Amendment Date:</label>
                                                        <input type="date" name="amend" class="form-control"
                                                            placeholder="Amendment Date" id="amend" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="amendEnd">End Date:</label>
                                                        <input type="date" name="amendEnd" class="form-control"
                                                            placeholder="End Date" id="amendEnd" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="cancel">Cancel Date:</label>
                                                        <input type="date" name="cancel" class="form-control"
                                                            placeholder="Cancel Date" id="cancel" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="cancelEnd">End Date:</label>
                                                        <input type="date" name="cancelEnd" class="form-control"
                                                            placeholder="End Date" id="cancelEnd" />
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

                                        </form>
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
                                <th>Activation Date</th>
                                <th>Operation</th>
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
                                <th>
                                    {{ $customer->PrNocInfo()->exists() ? $customer->PrNocInfo->activation_date : 'NA'
                                    }}
                                </th>
                                <td class="">
                                    <div class="action_dropdown_area">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-primary dropdown-toggle"
                                                data-toggle="dropdown">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu">

                                                <a class="dropdown-item"
                                                    href="{{ route('contractorsTimeline.show',$customer->id) }}">
                                                    <i class="fas fa-info info"></i>
                                                    Details
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
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

</style>
@endsection

@section('script')
<script type="text/javascript">

</script>
@endsection