@extends('dashboard.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Categories</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('salesTrashedCategories') }}
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
                <div class="card-header"></div>
                <div class="card-body">
                    <table class="table" id="my-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category</th>
                                @canany(['restore'], CategoryFullyQualifiedNameSpace())
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
                                @canany(['restore'], $category)
                                <td>
                                    <div class="action_dropdown_area">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-primary dropdown-toggle"
                                                data-toggle="dropdown">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu">
                                                @can('restore',$category)
                                                <form method="post"
                                                    action="{{ route('categories.restore',$category->id) }}">
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
    .card-header a {
        color: #fff;
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