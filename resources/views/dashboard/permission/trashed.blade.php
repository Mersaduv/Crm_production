@extends('dashboard.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Trashed</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('trashed-permissions') }}
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
                <div class="card-body">
                    <table class="table" id="my-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Section</th>
                                <th>Permissions</th>
                                <th>Operation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $page = request('page') ? request('page') : 1;
                                $index = 15 * $page - 14;
                            ?>
                            @foreach($permissions as $permission)
                            <tr>
                                <td>{{ $index }}</td>
                                <td>{{ $permission->section }}</td>
                                <td>{{ $permission->permission }}</td>
                                <td class="">
                                    <div class="action_dropdown_area">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-primary dropdown-toggle"
                                                data-toggle="dropdown">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu">
                                                <form method="post"
                                                    action="{{ route('permissions.restore',$permission->id) }}">
                                                    @csrf
                                                    @method('put')
                                                    <button class="btn dropdown-item" type="submit">
                                                        <i class="fas fa-undo "></i>
                                                        Restore
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php $index ++ ?>
                            @endforeach
                        </tbody>

                    </table>
                    <div class="card-footer">
                        <div class="pagination">
                            {!! $permissions->links() !!}
                        </div>
                    </div> <!-- /card-footer -->
                </div> <!-- /card-body -->
            </div> <!-- /card -->
        </div>
    </div>
    <div class="clearfix"></div>
</div> <!-- /end of page content -->
@endsection

@section('style')
<style>
    table {
        text-align: center;
    }

    .card-header {
        text-align: right;
    }

    .card-header button a {
        color: #fff;
    }
</style>
@endsection

@section('script')
<script type="text/javascript">

</script>
@endsection