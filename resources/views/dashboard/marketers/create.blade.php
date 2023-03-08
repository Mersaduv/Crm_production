@extends('dashboard.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Insert Field Officers</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('marketers.add') }}
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

            <form method="POST" action="{{ route('marketers.store') }}">
                @csrf

                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="required">Name:</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name:"
                                        autocomplete="off" required />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone" class="required">Phone:</label>
                                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone:"
                                        autocomplete="off" required />
                                </div>
                            </div>
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
    jQuery(document).ready(function(){

		$('#phone').on('keyup',function(){
	        var number = $(this).val();

	        var reg = /^\+93((77|78|79|70|73|74|72|76)\d{7})$/;
	        var reg2 = /^\b07(7|8|3|2|0|6|4|9)\d{7}$/;
	        var reg3 = /^\b0093((77|78|79|70|73|74|72|76)\d{7})$/;

	        if(reg.test(number))
	        {
	            $(this).css('border-color','green');
	            $(":submit").removeAttr("disabled");
	        }else if(reg2.test(number))
	        {
	            $(this).css('border-color','green');
	            $(":submit").removeAttr("disabled");
	        }else if(reg3.test(number))
	        {
	           $(this).css('border-color','green');
	           $(":submit").removeAttr("disabled");
	        }else if(number == "")
	        {
	            $(this).css('border-color','#ced4da');
	            $(":submit").removeAttr("disabled");
	        }else
	        {
	            $(this).css('border-color','red');
	            $(":submit").attr("disabled", true);
	        }

	    });

	});
</script>
@endsection