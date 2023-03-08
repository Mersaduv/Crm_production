@extends('dashboard.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Categories</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('salesCategories') }}
                    </div>
                    <div class="col-sm-6 historyBTN">
                        @can('create', CategoryFullyQualifiedNameSpace())
                        <button class="btn btn-primary btn-sm">
                            <a href="{{ route('categories.create') }}" class="btn btn-ctr">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                Add New
                            </a>
                        </button>
                        @endcan

                        @can('restore', CategoryFullyQualifiedNameSpace())
                        <button class="btn btn-danger btn-sm">
                            <a href="{{ route('categories.trashed') }}" class="btn btn-ctr">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                                Trashed
                            </a>
                        </button>
                        @endcan
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
                                        Filter {{ $categories->total() }}
                                    </div>
                                    <i class="more-less mdi mdi-plus"></i>
                                </a>
                            </div>

                            <div id="collapse-1" class="collapse" role="tabpanel" aria-labelledby="heading-1"
                                data-parent="#accordion-2">
                                <div class="card-body">
                                    <div class="panel-body">
                                        <form method="get" action="{{ route('categories.index') }}">
                                            @csrf
                                            <div class="row">

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="name">Category:</label>
                                                        <input type="text" name="name" class="form-control" id="name"
                                                            autocomplete="off" placeholder="Category Name" />
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
                <div class="card-body">
                    <table class="table" id="my-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category</th>
                                @canany(['update', 'view', 'delete'], CategoryFullyQualifiedNameSpace())
                                <th>Operation</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                    $page = request('page') ? request('page') : 1;
                                    $index = 15 * $page - 14;
                                ?>
                            @foreach($categories as $category)
                            <tr>
                                <td>{{ $index }}</td>
                                <td>{{ $category->name }}</td>
                                @canany(['update', 'view', 'delete'], $category)
                                <td class="">
                                    <div class="action_dropdown_area">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-primary dropdown-toggle"
                                                data-toggle="dropdown">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu">
                                                @can('update', $category)
                                                <a class="dropdown-item"
                                                    href="{{ route('categories.edit',$category->id) }}">
                                                    <i class="fas fa-pencil-alt info"></i>
                                                    Edit
                                                </a>
                                                @endcan
                                                @can('delete', $category)
                                                <form method="post"
                                                    action="{{ route('categories.destroy',$category->id) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn dropdown-item" type="submit">
                                                        <i class="fas fa-trash  danger"></i>
                                                        Delete
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
                        {{ $categories->links() }}
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
    .card-header {
        text-align: right;
    }
</style>
@endsection

@section('script')
<script type="text/javascript">

</script>
@endsection