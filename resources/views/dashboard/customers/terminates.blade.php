@extends('dashboard.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Customers</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('terminates') }}
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
                                        Filter {{ $terminates->total() }}
                                    </div>
                                    <i class="more-less mdi mdi-plus"></i>
                                </a>
                            </div>

                            <div id="collapse-1" class="collapse" role="tabpanel" aria-labelledby="heading-1"
                                data-parent="#accordion-2">
                                <div class="card-body">
                                    <div class="panel-body">
                                        <form method="get" action="{{ route('admin.customers.terminates') }}">
                                            @csrf
                                            <div class="row">

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="id">Customer ID:</label>
                                                        <input type="number" name="id" id="id" class="form-control"
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
                                                        <label for="date">Terminate Date:</label>
                                                        <input type="date" name="date" id="date" class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="contract">Contract Date:</label>
                                                        <input type="date" name="contract" id="contract"
                                                            class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="startTerminate">
                                                            Terminate Date:
                                                        </label>
                                                        <input type="date" name="startTerminate" id="startTerminate"
                                                            class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="endTerminate">
                                                            End Date:
                                                        </label>
                                                        <input type="date" name="endTerminate" id="endTerminate"
                                                            class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="startContract">
                                                            Contract Date:
                                                        </label>
                                                        <input type="date" name="startContract" id="startContract"
                                                            class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="endContract">End Date:</label>
                                                        <input type="date" name="endContract" id="endContract"
                                                            class="form-control" />
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
                                <th>Terminate Date</th>
                                <th>Terminate Reason</th>
                                <th>Operation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                    $page = request('page') ? request('page') : 1;
                                    $index = 15 * $page - 14;
                                ?>
                            @foreach($terminates as $terminate)
                            <tr>
                                <th>{{ $index }}</th>
                                <th>{{ $terminate->customer->customer_id }}</th>
                                <th>{{ $terminate->customer->full_name }}</th>
                                <th>{{ $terminate->terminate_date }}</th>
                                <th>
                                    {{ Illuminate\Support\Str::
                                    limit($terminate->terminate_reason, 80)
                                    }}
                                </th>

                                @if( $terminate->recontraction_date )

                                <th>{{ $terminate->recontraction_date }}</th>
                                <th class="operation">
                                    <a href="{{ route('admin.customer',
                                                     $terminate->customer->id) }}">
                                        view <span class="mdi mdi-eye"></span>
                                    </a>
                                </th>

                                @else

                                <th> NA </th>
                                <th class="operation">
                                    <a href="{{ route('admin.customer',
                                                     $terminate->customer->id) }}">
                                        view <span class="mdi mdi-eye"></span>
                                    </a>
                                </th>

                                @endif
                            </tr>
                            <?php $index ++ ?>
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- /card-body -->
                <div class="card-footer">
                    <div class="pagination">
                        {{ $terminates->links() }}
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
</style>
@endsection

@section('script')
<script type="text/javascript">

</script>
@endsection