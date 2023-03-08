<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>CRM</title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="Mannatthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link href="{{ asset('/public/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('/public/assets/css/icons.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('/public/assets/css/style.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('/public/assets/custom/custom.css') }}" rel="stylesheet" type="text/css">
		<style type="text/css">
			#wrapper{
				direction: rtl;
				text-align: right;
			}
			textarea{
				width: 100%;
			    height: 196px;
			    border-color: #dee2e6;
			    border-width: 2px;
			}
			.container{
				background: #fff;
			}
			.table{
				border-collapse: separate;
    			border-spacing: 2px;
			}
			.table th{
				background: #0a645b;
			    color: #fff;
			    border-top-right-radius: 20px;
			    border-top: 1px solid #fff;
			    font-size: 14px;
			    width: 40%;
			    padding-top: 10px;
			    padding-bottom: 10px;
				text-align:center;
			}
			.table td{
				border: 1px solid #0a645b;
				border-top-right-radius: 5px;
    			border-top-left-radius: 5px;
    			width: 60%;
			    padding-top: 10px;
			    padding-bottom: 10px;
				text-align:center;
			}
			img{
				width: 100%;
				height: auto;
				object-fit: cover;
			}
			.page-title-box{
				padding-top: 0px;
				margin-bottom: 25px;
			}
			*{
				font-family: system-ui;
			}
			.sign_table{
				width: 50%;
				margin: 0 auto;
			}
			.sign_table th{
				text-align: center;
				border-top-left-radius: 20px;
			}
			.sign_table td{
				height: 100px;
			}
			
			.page-header-box{
				text-align: center;
				margin-top: -70px;
				margin-bottom: 35px;
			}
			.page-header-box h3{
				font-size: 21px;
				margin: 0px;
			}
			.page-header-box h3:first-child span{
				display: inline-block;
				border-bottom: 2px solid #00665d;
				padding-bottom: 15px;
			}
			@media print{
				  @page {
					size: A4 portrait !important;
					margin: 0;
				  }
				.table th{
					background:  #0a645b !important;
					-webkit-print-color-adjust: exact;
				    color: #fff;
				    border-top-right-radius: 20px;
				    border-top: 1px solid #fff;
					text-align:center;
				}
				.table td{
					border: 1px solid #0a645b;
					-webkit-print-color-adjust: exact;
					border-top-right-radius: 5px !important;
	    			border-top-left-radius: 5px !important;
					text-align:center;
				}
				.page-header-box h3:first-child span{
					display: inline-block;
					border-bottom: 2px solid #00665d;
					padding-bottom: 15px;
				}
			}
			
			/* IE10+ CSS print styles */
			@media all and (-ms-high-contrast: none), (-ms-high-contrast: active) {
			  /* IE10+ CSS print styles go here */
			  @page {
				size: A4 portrait !important;
				margin: 0;  
			  }
			  .table th{
					background:  #0a645b !important;
					-webkit-print-color-adjust: exact;
				    color: #fff;
				    border-top-right-radius: 20px;
				    border-top: 1px solid #fff;
					text-align:center;
				}
				.table td{
					border: 1px solid #0a645b;
					-webkit-print-color-adjust: exact;
					border-top-right-radius: 5px !important;
	    			border-top-left-radius: 5px !important;
					text-align:center;
				}
				.page-header-box h3:first-child span{
					display: inline-block;
					border-bottom: 2px solid #00665d;
					padding-bottom: 15px;
				}
			}
		</style>
    </head>
<body>

    <!-- Begin page -->
    <div id="wrapper">
        <!-- Start right Content here -->
        <div class="page-content-wrapper ">

	        <div class="container">
	        	<div class="row">
			        <div class="col-sm-12">
			            <div class="page-title-box">
			                 <img src="{{ asset('/public/assets/images/header.jpg') }}">
			            </div>
						<div class="page-header-box">
			                <h3>
								<span> شرکت خدمات تکنالوژی  و انترنتی آریابُد </span>
							</h3>
							<h3> قرارداد ارائه خدمات انترنتی </h3>
			            </div>
			        </div>
			        <div class="clearfix"></div>
			    </div>
			    <!-- end page title -->

				<div class="page-content-box">
	  				<div class="row">
	  					<div class="col-sm-6">
	  						<table class="table" id="my-table">
								<?php
									$clone = json_decode($customer->clone);
								?>
	  							<tr>
	  								<th>آی دی</th>
	  								<td>{{ $customer->customer_id }}</td>
	  							</tr>
	  							<tr>
	  								<th>نام مشترک</th>
	  								<td>{{ $customer->full_name_persian ? $customer->full_name_persian : $customer->full_name }}</td>
	  							</tr>
								<tr>
	  								<th>شماره تذکره  / پاسپورت</th>
	  								<td>{{ $customer->identity }}</td>
	  							</tr>
								<tr>
	  								<th>شماره تماس</th>
	  								<td>{{ $customer->phone1 }}</td>
	  							</tr>
								<tr>
	  								<th>شخص ارتباطی</th>
	  								<td>{{ $customer->poc_persian ? $customer->poc_persian : $customer->poc }}</td>
	  							</tr>
	  							<tr>
	  								<th>شماره تماس شخص ارتباطی</th>
	  								<td>{{ $customer->phone2 }}</td>
	  							</tr>
								<tr>
	  								<th>میزان تحصیلات</th>
	  								<td>{{ $customer->education }}</td>
	  							</tr>
	  							<tr>
	  								<th>تاریخ قرار داد</th>
	  								<td>
	  									{{ Carbon\Carbon::parse($customer->customer->sale->installation_date)->format('Y-m-d') }}
	  								</td>
	  							</tr>
	  							<tr>
	  								<th>تاریخ فعال سازی</th>
	  								<td>
	  									@if($customer->customer->noc()->exists())
	  										{{ Carbon\Carbon::parse($customer->customer->noc->activation_date)->format('Y-m-d') }}
	  									@else
	  										--
	  									@endif
	  								</td>
	  							</tr>
	  							<tr>
	  								<th>بسته اینترنتی</th>
	  								<td style="direction: ltr;">
	  									@if($customer->package_id)
	  										{{ $customer->package->name }}
	  									@else
	  										--
	  									@endif
	  								</td>
	  							</tr>
	  							<tr class="<?php echo ($customer->package_price != $clone->package_price) || ($customer->package_id != $clone->package_id) ? 'price' : '' ?>">
	  								<th>قیمت بسته</th>
	  								<td>
	  									<span>{{ $customer->package_price }}</span>
	  									<span>{{ $customer->package_price_currency }}</span>
	  								</td>
	  							</tr>
	  							<tr>
	  								<th>نوعیت دستگاه گیرنده</th>
	  								<td>{{ $customer->receiver_type }}</td>
	  							</tr>
	  							<tr class="<?php echo ($customer->receiver_price != $clone->receiver_price) || ($customer->receiver_type != $clone->receiver_type) ? 'price' : '' ?>">
	  								<th>قیمت دستگاه گیرنده</th>
	  								<td>
	  									@if($customer->receiver_price)
	  										<span>{{ $customer->receiver_price }}</span>
	  										<span>{{ $customer->receiver_price_currency }}</span>
	  									@else
	  										--
	  									@endif
	  								</td>
	  							</tr>
	  							<tr>
	  								<th>نوعیت دستگاه فرستنده</th>
	  								<td>
	  									@if($customer->router_type)
	  										{{ $customer->router_type }}
	  									@else
	  										--
	  									@endif
	  								</td>
	  							</tr>
	  							<tr class="<?php echo ($customer->router_price != $clone->router_price) || ($customer->router_type != $clone->router_type) ? 'price' : '' ?>">
	  								<th>قیمت دستگاه فرستنده</th>
	  								<td>
	  									@if($customer->router_price)
	  										<span>{{ $customer->router_price }}</span>
	  										<span>{{ $customer->router_price_currency }}</span>
	  									@else
	  										--
	  									@endif
	  								</td>
	  							</tr>
	  							<tr class="price">
	  								<th>هزینه نصب و راه اندازی</th>
	  								<td>
	  									@if($customer->Installation_cost)
	  										<span>{{ $customer->Installation_cost }}</span>
	  										<span>{{ $customer->Installation_cost_currency }}</span>
	  									@else
	  										--
	  									@endif
	  								</td>
	  							</tr>
	  						</table> <!-- /table -->
	  					</div> <!-- /col-6 -->
	  					<div class="col-sm-6">
	  						<table class="table" id="my-table">
	  							<tr>
	  								<th>آی پی پابلیک</th>
	  								<td>
	  									@if($customer->public_ip)
	  										{{ $customer->public_ip }}
	  									@else
	  										--
	  									@endif
	  								</td>
	  							</tr>
	  							<tr class="price">
	  								<th>هزینه ماهوار آی پی</th>
	  								<td>
	  									@if($customer->ip_price)
	  										<span>{{ $customer->ip_price }}</span>
	  										<span>{{ $customer->ip_price_currency }}</span>
	  									@else
	  										--
	  									@endif
	  								</td>
	  							</tr>
	  							<tr>
	  								<th colspan="2" style="text-align:center">وضعیت دستگاه امانتی</th>
	  							</tr>
	  							<tr>
	  								<th>نوعیت دستگاه گیرنده</th>
	  								<td>
	  									@if($customer->receiver_type)
	  										{{ $customer->receiver_type }}
	  									@else
	  										--
	  									@endif
	  								</td>
	  							</tr>
	  							<tr>
	  								<th>مک آدرس دستگاه گیرنده</th>
	  								<td>
	  									@if($customer->customer->noc()->exists())
	  										{{ $customer->customer->noc->reciever_mac }}
	  									@else
	  										--
	  									@endif
	  								</td>
	  							</tr>
								
								<tr>
	  								<th>هزینه متفرقه</th>
	  								<td>
	  									@if($customer->additional_charge)
	  										<span>{{ $customer->additional_charge }}</span>
	  									@else
	  										--
	  									@endif
	  								</td>
	  							</tr>
	  							
	  							<tr class="price">
	  								<th>مقدار هزینه متفرقه</th>
	  								<td>
	  									@if($customer->additional_charge_price)
	  										<span>{{ $customer->additional_charge_price }}</span>
	  										<span>{{ $customer->additional_currency }}</span>
	  									@else
	  										--
	  									@endif
	  								</td>
	  							</tr>
	  							<tr class="discount">
	  								<th>تخفیف</th>
	  								<td>
	  									@if($customer->discount)
	  										<span>{{ $customer->discount }}</span>
	  										<span>{{ $customer->discount_currency }}</span>
	  									@else
	  										--
	  									@endif
	  								</td>
	  							</tr>
	  							<tr>
	  								<th>قیمت کلی</th>
	  								<td class="total"></td>
	  							</tr>
	  							<tr>
	  								<th>مسوول فروش</th>
	  								<td>{{ $customer->user->name }}</td>
	  							</tr>
	  							<tr>
	  								<th colspan="2">مهر و امضا مدیریت فروش</th>
	  							</tr>
	  							<tr>
	  								<td colspan="2" style="border: unset;">
	  									<textarea></textarea>
	  								</td>
	  							</tr>
	  						</table> <!-- /table -->
	  					</div> <!-- /col-6 -->
	  					<div class="col-sm-12">
	  						<table class="table">  
	  							<tr>
		  							<th style="width: 22.4%;">آدرس</th>
		  							<td>{{ $customer->address }}</td>
		  						</tr>
	  						</table>
	  					</div> <!-- /col-12 -->

	  					<div class="col-sm-12">
	  						<table class="table sign_table">
	  							<thead>
	  								<tr>
	  									<th>
	  										امضاء و نشان شصت مشتری
	  									</th>
	  								</tr>
	  							</thead>
	  							<tbody>
	  								<tr>
	  									<td></td>
	  								</tr>
	  							</tbody>
	  						</table>
	  					</div> <!-- /col-12 -->

	  					<div class="col-sm-12 custom_footer">
	  						<img src="{{ asset('/public/assets/images/footer.jpg') }}">
	  					</div> <!-- /col-sm-12 -->
	  				</div> <!-- /row -->
			        <div class="clearfix"></div>
			    </div> <!-- /end of page content -->

	        </div><!-- container -->

        </div> <!-- Page content Wrapper -->
    </div>
    <!-- END wrapper -->

	<script src="{{ asset('/public/assets/js/jquery.min.js') }}"></script>
	<script src="{{ asset('/public/assets/js/popper.min.js') }}"></script>
	<script src="{{ asset('/public/assets/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('/public/assets/js/modernizr.min.js') }}"></script>
	<script src="{{ asset('/public/assets/js/detect.js') }}"></script>
	<script src="{{ asset('/public/assets/js/fastclick.js') }}"></script>
	<script src="{{ asset('/public/assets/js/jquery.blockUI.js') }}"></script>
	<script src="{{ asset('/public/assets/js/waves.js') }}"></script>
	<script src="{{ asset('/public/assets/js/jquery.nicescroll.js') }}"></script>
	<script src="{{ asset('/public/assets/js/app.js') }}"></script>
	<script type="text/javascript">
		jQuery(document).ready(function(){


			// get total numbers
			var dollar = 0;
			var afg = 0;
			jQuery('.price').each(function() {
			    
				if($.trim($("span:not(:first)",this).text()) == 'Dollar'){
					dollar += eval($.trim($("span:not(:last)",this).text()));
				}else if($.trim($("span:not(:first)",this).text()) == 'AFG'){
					afg += eval($.trim($("span:not(:last)",this).text()));
				}

			});
			
		    var discount = 0;
		    jQuery('.discount').each(function() {
		        
		        if($.trim($("span:not(:first)",this).text()) == 'Dollar'){
		            discount = eval($.trim($("span:not(:last)",this).text()));
		            dollar -= discount;
		        }else if($.trim($("span:not(:first)",this).text()) == 'AFG'){
		            discount = eval($.trim($("span:not(:last)",this).text()));
		            afg -= discount;
		        }

		    });
		    
		    if(afg && dollar){
		    	$('.total').text( "(" + afg +" افغانی " + ")" + " - " + "(" + afg + " دلار " + ")" );
		    }else if(afg){
		    	$('.total').text( "(" + afg +" افغانی " + ")" );
		    }else if(dollar){
		    	$('.total').text( "(" + afg + " دلار " + ")" );
		    }

			try {
         	    window.print();
		        window.onafterprint = back;
		        function back() {
		            window.history.back();
		        }
			}
			catch(err) {
			  window.location.href = "{{ route('amedment.amend',$customer->id)}}";
			}

		});
	</script>
</body>
</html>