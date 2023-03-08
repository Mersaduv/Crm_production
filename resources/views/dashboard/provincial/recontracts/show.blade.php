@extends('dashboard.layouts.app')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Recontraction Details</h4>
                
                <div class="history">

                    <div class="row">
                        <div class="col-sm-6">
                           {{ Breadcrumbs::render('manager.pr.terminates') }}
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
                                    <a href="#" class="col active">Terminate Details</a>
							        <a href="#" class="col">Recontraction Details</a>
							    </div>	<!-- /owl-nav -->

                        		<div class="owl-carousel owl-1">

							        <div class="media-29101 d-md-flex w-100">
							          	<table class="table table-striped">
                                            <tbody>
                                                <tr>
                                                    <th>Customer ID</th>
                                                    <td>{{ $customer->terminate->customer_id }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Full Name</th>
                                                    <td>{{ $customer->terminate->full_name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>POC</th>
                                                    <td>{{ $customer->terminate->poc }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Phone</th>
                                                    <td>
                                                        {{ $customer->terminate->phone1 }}
                                                        -
                                                        {{ $customer->terminate->phone2 }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Branch</th>
                                                    <td>{{ $customer->terminate->branch->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Province</th>
                                                    <td>{{ province($customer->terminate->province) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Customer Province</th>
                                                    <td>{{ province($customer->terminate->customerProvince) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Address</th>
                                                    <td>{{ $customer->terminate->address }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Package</th>
                                                    <td>
                                                        @if($customer->terminate->package_id)
                                                            {{ $customer->terminate->package->name }}
                                                        @else
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr class="price">
                                                    <th>Package Price</th>
                                                    <td>
                                                        <span>{{ $customer->terminate->package_price }}</span>
                                                        <span>{{ $customer->terminate->package_price_currency }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Reseller Name</th>
                                                    <td>{{ $customer->terminate->commission ? $customer->terminate->commission->name : 'NA' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Reseller Percentage</th>
                                                    <td>
                                                        <span>
                                                            {{ $customer->terminate->commission_percent ."%" }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Service</th>
                                                    <td>{{ $customer->terminate->service }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Provider</th>
                                                    <td>{{ $customer->terminate->provider }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Public IP</th>
                                                    <td>
                                                        @if($customer->terminate->public_ip)
                                                            {{ $customer->terminate->public_ip }}
                                                        @else
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>IP Price</th>
                                                    <td>
                                                        @if($customer->terminate->ip_price)
                                                            <span>{{ $customer->terminate->ip_price }}</span>
                                                            <span>{{ $customer->terminate->ip_price_currency }}</span>
                                                        @else
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Additional Charge:</th>
                                                    <td>
                                                        @if($customer->terminate->additional_charge)
                                                            {{ $customer->terminate->additional_charge }}
                                                        @else 
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Additional Charge Price:</th>
                                                    <td>
                                                        @if($customer->terminate->additional_charge_price)
                                                            <span>
                                                                {{ $customer->terminate->additional_charge_price }}
                                                            </span>
                                                            <span>
                                                                {{ $customer->terminate->additional_currency }}
                                                            </span>
                                                        @else 
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Created At:</th>
                                                    <td>{{ $customer->terminate->created_at }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Created By:</th>
                                                    <td>{{ $customer->terminate->user->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Terminate Date</th>
                                                    <td>{{ $customer->terminate->terminate_date }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Terminate Reason</th>
                                                    <td>{{ $customer->terminate->terminate_reason }}</td>
                                                </tr>
                                            </tbody>
                                        </table> <!-- /table -->
							        </div> <!-- .item -->

							        <div class="media-29101  w-100">
							          	<table class="table table-striped table-dark">
                                            <tbody>
                                                <tr>
                                                    <th>Customer ID</th>
                                                    <td>{{ $customer->customer_id }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Full Name</th>
                                                    <td>{{ $customer->full_name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>POC</th>
                                                    <td>{{ $customer->poc }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Phone</th>
                                                    <td>
                                                        {{ $customer->phone1 }}
                                                        -
                                                        {{ $customer->phone2 }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Branch</th>
                                                    <td>{{ $customer->branch->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Province</th>
                                                    <td>{{ province($customer->province) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Customer Province</th>
                                                    <td>{{ province($customer->customerProvince) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Address</th>
                                                    <td>{{ $customer->address }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Package</th>
                                                    <td>
                                                        @if($customer->package_id)
                                                            {{ $customer->package->name }}
                                                        @else
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr class="price">
                                                    <th>Package Price</th>
                                                    <td>
                                                        <span>{{ $customer->package_price }}</span>
                                                        <span>{{ $customer->package_price_currency }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Reseller Name</th>
                                                    <td>{{ $customer->commission ? $customer->commission->name : 'NA' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Reseller Percentage</th>
                                                    <td>
                                                        <span>
                                                            {{ $customer->commission_percent ."%" }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Installation Cost</th>
                                                    <td>
                                                        <span>{{ $customer->installation_cost }}</span>
                                                        <span>{{ $customer->Installation_cost_currency }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Service</th>
                                                    <td>{{ $customer->service }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Provider</th>
                                                    <td>{{ $customer->provider }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Public IP</th>
                                                    <td>
                                                        @if($customer->public_ip)
                                                            {{ $customer->public_ip }}
                                                        @else
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>IP Price</th>
                                                    <td>
                                                        @if($customer->ip_price)
                                                            <span>{{ $customer->ip_price }}</span>
                                                            <span>{{ $customer->ip_price_currency }}</span>
                                                        @else
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Additional Charge:</th>
                                                    <td>
                                                        @if($customer->additional_charge)
                                                            {{ $customer->additional_charge }}
                                                        @else 
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Additional Charge Price:</th>
                                                    <td>
                                                        @if($customer->additional_charge_price)
                                                            <span>
                                                                {{ $customer->additional_charge_price }}
                                                            </span>
                                                            <span>
                                                                {{ $customer->additional_currency }}
                                                            </span>
                                                        @else 
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Recontracte Date</th>
                                                    <td>{{ $customer->recontract_date }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Recontracte Reason</th>
                                                    <td>{{ $customer->comment ? $customer->comment : 'NA' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Created By</th>
                                                    <td>{{ $customer->user->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Created At</th>
                                                    <td>{{ $customer->created_at }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
							        </div> <!-- .item -->

						      	</div> <!-- /owl -->

                        	</div> <!-- /card-body -->
                        </div> <!-- /card -->

                    </div> <!-- /col-9 -->

                    <div class="col-md-3">
                        @include('dashboard.provincial.recontracts.sidebar')
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
               url:"{{ route('confirm.prrecontract') }}",
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
