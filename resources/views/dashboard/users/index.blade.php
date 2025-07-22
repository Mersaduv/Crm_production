@extends('dashboard.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">users</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('users') }}
                    </div>
                    <div class="col-sm-6 historyBTN">
                        @can('create', UserFullyQualifiedNameSpace())
                        <button class="btn btn-primary btn-sm">
                            <a href="{{ route('users.create') }}" class="btn btn-ctr">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                Add New
                            </a>
                        </button>
                        @endcan
                        @canany(['restore','forceDelete'], UserFullyQualifiedNameSpace())
                        <button class="btn btn-danger btn-sm">
                            <a href="{{ route('user.trashed') }}" class="btn btn-ctr">
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
                                        Filter
                                    </div>
                                    <i class="more-less mdi mdi-plus"></i>
                                </a>
                            </div>

                            <div id="collapse-1" class="collapse" role="tabpanel" aria-labelledby="heading-1"
                                data-parent="#accordion-2">
                                <div class="card-body">
                                    <div class="panel-body">
                                        <form method="get" action="{{ route('users') }}">
                                            @csrf
                                            <div class="row">

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="name">User Name</label>
                                                        <input type="text" name="name" class="form-control"
                                                            placeholder="User Name" autocomplete="off" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="email">User Email</label>
                                                        <input type="email" name="email" class="form-control"
                                                            placeholder="User Email" autocomplete="off" />
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="role">User Role</label>
                                                        <select name="role" class="form-control">
                                                            <option value="">select Role</option>
                                                            <option value="admin">Admin</option>
                                                            <option value="manager">Manager</option>
                                                            <option value="sales">Sales</option>
                                                            <option value="noc">NOC</option>
                                                            <option value="finance">Finance</option>
                                                            <option value="support">Support</option>
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

            <div class="card">
                <div class="card-body">
                    <table class="table" id="my-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                @canany(['update', 'view', 'delete'], UserFullyQualifiedNameSpace())
                                <th>Operation</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                    $page = request('page') ? request('page') : 1;
                                    $index = 15 * $page - 14;
                                ?>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $index }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                @canany(['update', 'view', 'delete'], UserFullyQualifiedNameSpace())
                                <td class="">
                                    <div class="action_dropdown_area">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-primary dropdown-toggle"
                                                data-toggle="dropdown">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu">
                                                @can('update', $user)
                                                <a class="dropdown-item" href="{{ route('users.edit',$user->id) }}">
                                                    <i class="fas fa-pencil-alt info"></i>
                                                    Edit
                                                </a>
                                                @endcan
                                                @can('view', $user)
                                                <a class="dropdown-item" href="{{ route('users.show',$user->id) }}">
                                                    <i class="fas fa-lock" aria-hidden="true"></i>
                                                    Permission
                                                </a>
                                                @endcan
                                                @can('delete', $user)
                                                <form method="post" action="{{ route('users.destroy',$user->id) }}">
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
                    <div class="card-footer">
                        <div class="pagination">
                            {!! $users->links() !!}
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

    .card-header button a {
        color: #fff;
    }
</style>
@endsection

@section('script')
<script type="text/javascript">
    jQuery(document).on('ready',function(){

   });
</script>
@endsection
