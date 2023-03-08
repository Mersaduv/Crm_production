@extends('dashboard.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Packages</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('packages') }}
                    </div>
                    <div class="col-sm-6 historyBTN">
                        @can('create', PackageFullyQualifiedNameSpace())
                        <button class="btn btn-primary btn-sm">
                            <a href="{{ route('packages.create') }}" class="btn btn-ctr">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                Add New
                            </a>
                        </button>
                        @endcan
                        @can('restore', PackageFullyQualifiedNameSpace())
                        <button class="btn btn-danger btn-sm">
                            <a href="{{ route('packages.trashed') }}" class="btn btn-ctr">
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
                                        Filter {{ $packages->total() }}
                                    </div>
                                    <i class="more-less mdi mdi-plus"></i>
                                </a>
                            </div>

                            <div id="collapse-1" class="collapse" role="tabpanel" aria-labelledby="heading-1"
                                data-parent="#accordion-2">
                                <div class="card-body">
                                    <div class="panel-body">
                                        <form method="get" action="{{ route('packages.index') }}">
                                            @csrf
                                            <div class="row">

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="id">Category:</label>
                                                        <select name="id" class="form-control" id="id">
                                                            <option value="">Select Category</option>
                                                            @foreach($categories as $cat)
                                                            <option value="{{ $cat->id }}">
                                                                {{ $cat->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="name">Package Name:</label>
                                                        <input type="text" name="name" id="name"
                                                            placeholder="Package Name" class="form-control"
                                                            autocomplete="off" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="price">Package Price:</label>
                                                        <input type="number" name="price" id="price" autocomplete="off"
                                                            placeholder="Package Price" class="form-control" />
                                                    </div>
                                                </div> <!-- /col -->
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="duration">Package Duration:</label>
                                                        <input type="number" name="duration" id="duration"
                                                            autocomplete="off" placeholder="Package Duration"
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
                <div class="card-body">
                    <table class="table" id="my-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Duration</th>
                                @canany(['update', 'view', 'delete'], PackageFullyQualifiedNameSpace())
                                <th>Operation</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                    $page = request('page') ? request('page') : 1;
                                    $index = 15 * $page - 14;
                                ?>
                            @foreach($packages as $package)
                            <tr>
                                <td>{{ $index }}</td>
                                <td>{{ $package->category->name }}</td>
                                <td>{{ $package->name }}</td>
                                <td>
                                    @if($package->price)
                                    {{ $package->price }}
                                    {{ $package->price_currency }}
                                    @else
                                    NA
                                    @endif

                                </td>
                                <td>
                                    @if($package->duration)
                                    {{ $package->duration }}
                                    {{ $package->duration_unit }}
                                    @else
                                    NA
                                    @endif
                                </td>
                                @canany(['update', 'view', 'delete'], $package)
                                <td class="">
                                    <div class="action_dropdown_area">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-primary dropdown-toggle"
                                                data-toggle="dropdown">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu">
                                                @can('update', $package)
                                                <a class="dropdown-item"
                                                    href="{{ route('packages.edit',$package->id) }}">
                                                    <i class="fas fa-pencil-alt info"></i>
                                                    Edit
                                                </a>
                                                @endcan

                                                @can('delete', $package)
                                                <form method="post"
                                                    action="{{ route('packages.destroy',$package->id) }}">
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
                        {{ $packages->links() }}
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