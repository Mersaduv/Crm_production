@extends('dashboard.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">CREATE</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('create-user') }}
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
            <form method="post" action="{{ route('users.store') }}">
                <div class="card">
                    <div class="card-body">
                        @csrf
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="required">Full Name:</label>
                                    <input class="form-control" type="text" name="name" id="name" required="required"
                                        placeholder="Full Name" autocomplete="off" />
                                </div>
                            </div> <!-- /col -->

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="required">Email:</label>
                                    <input class="form-control" type="email" name="email" id="email" required="required"
                                        placeholder="Email" autocomplete="off" />
                                </div>
                            </div> <!-- /col -->

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role" class="required">Role:</label>
                                    <select class="form-control" name="role" id="role">
                                        <option value="">Select Role:</option>
                                        <option value="admin">Admin</option>
                                        <option value="manager">Manager</option>
                                        <option value="finance">Finance</option>
                                        <option value="noc">NOC</option>
                                        <option value="sales">Sales</option>
                                        <option value="support">Support</option>
                                    </select>
                                </div>
                            </div> <!-- /col -->

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="required">Password:</label>
                                    <input class="form-control" type="password" name="password" id="password"
                                        placeholder="Password" autocomplete="off" />
                                </div>
                            </div> <!-- /col -->
                        </div>
                    </div> <!-- /card-body -->
                    <div class="card-footer">
                        <button class="btn btn-secondary" type="reset">
                            Reset
                        </button>
                        <button class="btn btn-primary" type="submit">
                            Register
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
