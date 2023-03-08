@extends('dashboard.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">edit</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('edit-permission',$permission) }}
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
            <form method="post" action="{{ route('permissions.update',$permission->id) }}">
                <div class="card">
                    <div class="card-body">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="section" class="required">Section</label>
                                    <input class="form-control" type="text" name="section" id="section"
                                        required="required" placeholder="Section Name" autocomplete="off"
                                        value="{{ $permission->section }}" />
                                </div>
                            </div> <!-- /col -->

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="permission" class="required">Permission</label>
                                    <input class="form-control" type="text" name="permission" id="permission"
                                        required="required" placeholder="Permission Name" autocomplete="off"
                                        value="{{ $permission->permission }}" />
                                </div>
                            </div> <!-- /col -->

                        </div>
                    </div> <!-- /card-body -->
                    <div class="card-footer">
                        <button class="btn btn-primary" type="submit">
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