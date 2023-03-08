@extends('dashboard.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">province</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('branch.trashed') }}
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
                                        Filter {{ $branches->total() }}
                                    </div>
                                    <i class="more-less mdi mdi-plus"></i>
                                </a>
                            </div>

                            <div id="collapse-1" class="collapse" role="tabpanel" aria-labelledby="heading-1"
                                data-parent="#accordion-2">
                                <div class="card-body">
                                    <div class="panel-body">

                                    </div>
                                </div>
                            </div>
                        </div> <!-- /card -->

                    </div> <!-- // accoridan -->

                </div> <!-- /filter-area -->
            </div> <!-- /filter-card -->

            <div class="card">

                <div class="card-body">
                    <table class="table" id="my-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Branch</th>
                                <th>Address</th>
                                <th>Province</th>
                                @canany(['restore'], BranchFullyQualifiedNameSpace())
                                <th>Operation</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                    $page = request('page') ? request('page') : 1;
                                    $index = 15 * $page - 14;
                                ?>
                            @foreach($branches as $branch)
                            <tr>
                                <td>{{ $index }}</td>
                                <td>{{ $branch->name }}</td>
                                <td>{{ $branch->address }}</td>
                                <td>{{ province($branch->province->name) }}</td>
                                @canany(['restore'], $branch)
                                <td>
                                    <div class="action_dropdown_area">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-primary dropdown-toggle"
                                                data-toggle="dropdown">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu">
                                                @can('restore',$branch)
                                                <form method="post" action="{{ route('branch.restore',$branch->id) }}">
                                                    @csrf
                                                    @method('put')
                                                    <button class="btn dropdown-item" type="submit">
                                                        <i class="fas fa-undo "></i>
                                                        Restore
                                                    </button>
                                                </form>
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
                        {{ $branches->links() }}
                    </div>
                </div> <!-- / card-footer -->
            </div>
        </div> <!-- / content-box -->
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