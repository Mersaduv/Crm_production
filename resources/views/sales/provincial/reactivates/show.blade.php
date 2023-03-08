@extends('sales.layouts.app')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Reactivate Details</h4>
                
                <div class="history">

                    <div class="row">
                        <div class="col-sm-6">
                           {{ Breadcrumbs::render('sales.pr.suspend',$customer->provincial) }}
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
                <div class="row">
                    <div class="col-md-9">

                    	<div class="card">
                        	<div class="card-header">
                        		<h1 class="text-center">All Information</h1>
                        	</div> <!-- /card-header -->
                        	<div class="card-body">
                        		
                        		<div class="d-flex carousel-nav">
                                    <a href="#" class="col active">Suspends Details</a>
							        <a href="#" class="col">Reactivate Details</a>
							    </div>	<!-- /owl-nav -->

                        		<div class="owl-carousel owl-1">

							        <div class="media-29101 d-md-flex w-100">
							          	<table class="table table-striped">
                                            <tbody>
                                                <tr>
                                                    <th>Customer ID</th>
                                                    <td>{{ $customer->suspend->customer_id }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Full Name</th>
                                                    <td>{{ $customer->suspend->full_name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>POC</th>
                                                    <td>{{ $customer->suspend->poc }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Phone</th>
                                                    <td>
                                                        {{ $customer->suspend->phone1 }}
                                                        -
                                                        {{ $customer->suspend->phone2 }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Branch</th>
                                                    <td>{{ $customer->suspend->branch->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Province</th>
                                                    <td>{{ province($customer->suspend->province) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Customer Province</th>
                                                    <td>{{ province($customer->suspend->customerProvince) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Address</th>
                                                    <td>{{ $customer->suspend->address }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Package</th>
                                                    <td>
                                                        @if($customer->suspend->package_id)
                                                            {{ $customer->suspend->package->name }}
                                                        @else
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr class="price">
                                                    <th>Package Price</th>
                                                    <td>
                                                        <span>{{ $customer->suspend->package_price }}</span>
                                                        <span>{{ $customer->suspend->package_price_currency }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Reseller Name</th>
                                                    <td>{{ $customer->suspend->commission ? $customer->suspend->commission->name : 'NA' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Reseller Percentage</th>
                                                    <td>
                                                        <span>
                                                            {{ $customer->suspend->commission_percent ."%" }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Service</th>
                                                    <td>{{ $customer->suspend->service }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Provider</th>
                                                    <td>{{ $customer->suspend->provider }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Public IP</th>
                                                    <td>
                                                        @if($customer->suspend->public_ip)
                                                            {{ $customer->suspend->public_ip }}
                                                        @else
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>IP Price</th>
                                                    <td>
                                                        @if($customer->suspend->ip_price)
                                                            <span>{{ $customer->suspend->ip_price }}</span>
                                                            <span>{{ $customer->suspend->ip_price_currency }}</span>
                                                        @else
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Additional Charge:</th>
                                                    <td>
                                                        @if($customer->suspend->additional_charge)
                                                            {{ $customer->suspend->additional_charge }}
                                                        @else 
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Additional Charge Price:</th>
                                                    <td>
                                                        @if($customer->suspend->additional_charge_price)
                                                            <span>
                                                                {{ $customer->suspend->additional_charge_price }}
                                                            </span>
                                                            <span>
                                                                {{ $customer->suspend->additional_currency }}
                                                            </span>
                                                        @else 
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Created At:</th>
                                                    <td>{{ $customer->suspend->created_at }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Created By:</th>
                                                    <td>{{ $customer->suspend->user->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Suspend Date</th>
                                                    <td>{{ $customer->suspend->suspend_date }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Suspend Reason</th>
                                                    <td>{{ $customer->suspend->suspend_reason }}</td>
                                                </tr>
                                            </tbody>
                                        </table> <!-- /table -->
							        </div> <!-- .item -->

							        <div class="media-29101  w-100">
							          	<table class="table table-striped table-dark">
                                            <tbody>
                                                <tr>
                                                    <th>Reactivate Date</th>
                                                    <td>{{ $customer->reactive_date }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Reactivate Reason</th>
                                                    <td>{{ $customer->comment ? $customer->comment : 'NA' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Reactivated By</th>
                                                    <td>{{ $customer->user->name }}</td>
                                                </tr>

                                                @if($customer->customer_id != $customer->suspend->customer_id)
                                                    <tr>
                                                        <th>Customer ID</th>
                                                        <td>
                                                            {{ $customer->suspend->customer_id }}
                                                            =>
                                                            {{ $customer->customer_id }}
                                                        </td>
                                                    </tr>
                                                @endif

                                                @if($customer->full_name != $customer->suspend->full_name)
                                                    <tr>
                                                        <th>Full Name</th>
                                                        <td>
                                                            {{ $customer->suspend->full_name }}
                                                            =>
                                                            {{ $customer->full_name }}
                                                        </td>
                                                    </tr>
                                                @endif

                                                @if($customer->poc != $customer->suspend->poc)
                                                    <tr>
                                                        <th>POC</th>
                                                        <td>
                                                            {{ $customer->suspend->poc }}
                                                            =>
                                                            {{ $customer->poc }}
                                                        </td>
                                                    </tr>
                                                @endif

                                                @if($customer->phone1 != $customer->suspend->phone1)
                                                    <tr>
                                                        <th>Phone 1</th>
                                                        <td>
                                                            {{ $customer->suspend->phone1 }}
                                                            =>
                                                            {{ $customer->phone1 }}
                                                        </td>
                                                    </tr>
                                                @endif

                                                @if($customer->phone2 != $customer->suspend->phone2)
                                                    <tr>
                                                        <th>Phone 2</th>
                                                        <td>
                                                            {{ $customer->suspend->phone2 }}
                                                            =>
                                                            {{ $customer->phone2 }}
                                                        </td>
                                                    </tr>
                                                @endif

                                                @if($customer->branch->name != $customer->suspend->branch->name)
                                                    <tr>
                                                        <th>Branch</th>
                                                        <td>
                                                            {{ $customer->suspend->branch->name }}
                                                            =>
                                                            {{ $customer->branch->name }}
                                                        </td>
                                                    </tr>
                                                @endif

                                                @if($customer->province != $customer->suspend->province)
                                                    <tr>
                                                        <th>Province</th>
                                                        <td>
                                                            {{ province($customer->suspend->province) }}
                                                            =>
                                                            {{ province($customer->province) }}
                                                        </td>
                                                    </tr>
                                                @endif

                                                @if($customer->customerProvince != $customer->suspend->customerProvince)
                                                    <tr>
                                                        <th>Customer Province</th>
                                                        <td>
                                                            {{ province($customer->suspend->customerProvince) }}
                                                            =>
                                                            {{ province($customer->customerProvince) }}
                                                        </td>
                                                    </tr>
                                                @endif

                                                @if($customer->address != $customer->suspend->address)
                                                    <tr>
                                                        <th>Address</th>
                                                        <td>
                                                            {{ province($customer->suspend->address) }}
                                                            =>
                                                            {{ province($customer->address) }}
                                                        </td>
                                                    </tr>
                                                @endif

                                                @if($customer->package_id != $customer->suspend->package_id)
                                                    <tr>
                                                        <th>Package</th>
                                                        <td>
                                                            {{ $customer->suspend->package->name }}
                                                            =>
                                                            {{ $customer->package->name }}
                                                        </td>
                                                    </tr>
                                                @endif

                                                @if($customer->package_price != $customer->suspend->package_price)
                                                    <tr>
                                                        <th>Package Price</th>
                                                        <td>
                                                            {{ $customer->suspend->package_price }} {{ $customer->suspend->package_price_currency }}
                                                            =>
                                                            {{ $customer->package_price }} {{ $customer->package_price_currency }}
                                                        </td>
                                                    </tr>
                                                @endif

                                                @if($customer->commission != $customer->suspend->commission)
                                                    <tr>
                                                        <th>Reseller Name</th>
                                                        <td>
                                                            {{ $customer->suspend->commission->name }}
                                                            =>
                                                            {{ $customer->commission->name }}
                                                        </td>
                                                    </tr>
                                                @endif

                                                @if($customer->commission_percent != $customer->suspend->commission_percent)
                                                    <tr>
                                                        <th>Reseller Percentage</th>
                                                        <td>
                                                            {{ $customer->suspend->commission_percent }}
                                                            =>
                                                            {{ $customer->commission_percent }}
                                                        </td>
                                                    </tr>
                                                @endif

                                                @if($customer->service != $customer->suspend->service)
                                                    <tr>
                                                        <th>Service</th>
                                                        <td>
                                                            {{ $customer->suspend->service }}
                                                            =>
                                                            {{ $customer->service }}
                                                        </td>
                                                    </tr>
                                                @endif

                                                @if($customer->provider != $customer->suspend->provider)
                                                    <tr>
                                                        <th>Provider</th>
                                                        <td>
                                                            {{ $customer->suspend->service }}
                                                            =>
                                                            {{ $customer->service }}
                                                        </td>
                                                    </tr>
                                                @endif

                                                @if($customer->public_ip != $customer->suspend->public_ip)
                                                    <tr>
                                                        <th>Public IP</th>
                                                        <td>
                                                            {{ $customer->suspend->public_ip }}
                                                            =>
                                                            {{ $customer->public_ip }}
                                                        </td>
                                                    </tr>
                                                @endif

                                                @if($customer->ip_price != $customer->suspend->ip_price)
                                                    <tr>
                                                        <th>Public IP Price</th>
                                                        <td>
                                                            {{ $customer->suspend->ip_price }}
                                                            =>
                                                            {{ $customer->ip_price }}
                                                        </td>
                                                    </tr>
                                                @endif

                                                @if($customer->additional_charge != $customer->suspend->additional_charge)
                                                    <tr>
                                                        <th>Additional Charge</th>
                                                        <td>
                                                            {{ $customer->suspend->additional_charge }}
                                                            =>
                                                            {{ $customer->additional_charge }}
                                                        </td>
                                                    </tr>
                                                @endif

                                                @if($customer->additional_charge_price != $customer->suspend->additional_charge_price)
                                                    <tr>
                                                        <th>Additional Charge Price</th>
                                                        <td>
                                                            {{ $customer->suspend->additional_charge_price }} {{ $customer->suspend->additional_currency }}
                                                            =>
                                                            {{ $customer->additional_charge_price }} {{ $customer->additional_currency }}
                                                        </td>
                                                    </tr>
                                                @endif

                                            </tbody>
                                        </table>
							        </div> <!-- .item -->

						      	</div> <!-- /owl -->

                        	</div> <!-- /card-body -->
                        </div> <!-- /card -->

                    </div> <!-- /col-9 -->

                    <div class="col-md-3">
                        @include('sales.provincial.reactivates.sidebar')
                    </div> <!-- /col-3 -->

                </div> <!-- /row -->
            </div>
        </div> <!-- /col-12 -->

        <div class="clearfix"></div>
    </div> <!-- /end of page content -->
@endsection

@section('style')
  <style>
    .carousel-nav a{
  		color: #000;
	    font-size: 20px;
	    display: inline-block;
	    text-align: center;
	    padding: 20px;
  	}
  	.carousel-nav a.active {
	    border-bottom: 1px solid;
	}
  </style>
@endsection

@section('script')
<script type="text/javascript">
   jQuery(document).ready(function(){

        jQuery('.confirm_btn').off().on('click',function(e){
        e.preventDefault();
            
            jQuery.ajax({
               url:"{{ route('confirm.PrReactivate') }}",
               method:'post',
               data:{
                    "_token": "{{ csrf_token() }}",
                    id:"{{ $customer->id }}", 
                },
                success:function(response){
                    if(response == 'success'){
                        location.reload();
                    }
               }
            });

        });

   });
</script>
@endsection
