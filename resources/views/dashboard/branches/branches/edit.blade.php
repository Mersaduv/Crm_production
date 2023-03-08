@extends('dashboard.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Edit Branch</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('branch.edit',$branch) }}
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

            <form method="post" action="{{ route('branch.update',$branch->id) }}">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="category" class="required">Branch:</label>
                                    <input type="text" name="name" class="form-control" placeholder="Province:"
                                        autocomplete="off" value="{{ $branch->name }}" required />
                                </div>
                            </div><!-- /col -->

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="address" class="required">Address:</label>
                                    <input type="text" name="address" class="form-control" placeholder="Address:"
                                        autocomplete="off" value="{{ $branch->address }}" required />
                                </div>
                            </div><!-- /col -->

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="province">Province:</label>
                                    <select name="province_id" id="province" class="form-control">
                                        <option value="">Select Province</option>
                                        @foreach($provinces as $province)
                                        <option value="{{ $province->id }}" {{ $branch->province->id == $province->id ?
                                            'selected' : '' }}>{{ $province->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> <!-- /col -->
                        </div> <!-- /row -->

                    </div> <!-- /card-body -->
                    <div class="card-footer">
                        <button class="btn btn-secondary" type="reset">Reset</button>
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div> <!-- /card-footer -->
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