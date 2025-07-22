@extends('dashboard.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">edit</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('edit-user',$user) }}
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
            <form method="post" action="{{ route('users.update',$user->id) }}">
                <div class="card">
                    <div class="card-body">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="required">Full Name:</label>
                                    <input class="form-control" type="text" name="name" id="name" required="required"
                                        placeholder="Full Name" autocomplete="off" value="{{ $user->name }}" />
                                </div>
                            </div> <!-- /col -->

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="required">Email:</label>
                                    <input class="form-control" type="email" name="email" id="email" required="required"
                                        placeholder="Email" autocomplete="off" value="{{ $user->email }}" />
                                </div>
                            </div> <!-- /col -->

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role" class="required">Role:</label>
                                    <select class="form-control" name="role" id="role">
                                        <option value="">Select Role:</option>
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>
                                            Admin
                                        </option>
                                        <option value="manager" {{ $user->role == 'manager' ? 'selected' : '' }}>
                                            Manager
                                        </option>
                                        <option value="finance" {{ $user->role == 'finance' ? 'selected' : '' }}>
                                            Finance
                                        </option>
                                        <option value="noc" {{ $user->role == 'noc' ? 'selected' : '' }}>
                                            NOC
                                        </option>
                                        <option value="sales" {{ $user->role == 'sales' ? 'selected' : '' }}>
                                            Sales
                                        </option>
                                        <option value="support" {{ $user->role == 'support' ? 'selected' : '' }}>
                                            Support
                                        </option>
                                    </select>
                                </div>
                            </div> <!-- /col -->

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">New Password</label>
                                    <input type="password" name="password" id="password" class="form-control"
                                        placeholder="Password:" />
                                </div>
                            </div>
                        </div>
                    </div> <!-- /card-body -->
                    <div class="card-footer">
                        <button class="btn btn-success" type="submit">
                            Update
                        </button>
                    </div>
                </div> <!-- /card -->
            </form>
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
