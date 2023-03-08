@extends('sales.layouts.app')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Customer</h4>
                
                <div class="history">

                    <div class="row">
                        <div class="col-sm-6">
                            {{ Breadcrumbs::render('singleTerminate',$customer->customer) }}
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
                    <div class="col-md-9 col-sm-12">
                        <div class="card">
                        	<div class="card-header">
                        		<h1 class="text-center">All Information</h1>
                        	</div> <!-- /card-header -->
                        	<div class="card-body">
                        		
                        		<div class="d-flex carousel-nav">
							        <a href="#" class="col active">Terminate Details</a>
                                    <a href="#" class="col">Recontract Details</a>
							    </div>	

                        		<div class="owl-carousel owl-1">

							        <div class="media-29101 d-md-flex w-100">
							          	<table class="table table-striped">
                                            <tbody>
                                                <tr>
                                                    <th>Terminate Date</th>
                                                    <td>{{ $customer->terminate->termination_date }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Terminate Reason</th>
                                                    <td>{{ $customer->terminate->terminate_reason }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Terminate By</th>
                                                    <td>{{ $customer->terminate->user->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Customer ID:</th>
                                                    <td>{{ $customer->terminate->customer_id }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Full Name:</th>
                                                    <td>{{ $customer->terminate->full_name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>POC:</th>
                                                    <td>{{ $customer->terminate->poc }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Phone:</th>
                                                    <td>
                                                        {{ $customer->terminate->phone1 }}
                                                        -
                                                        {{ $customer->terminate->phone2 }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Education:</th>
                                                    <td>{{ $customer->terminate->education }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Identity Number:</th>
                                                    <td>{{ $customer->terminate->identity }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Branch:</th>
                                                    <td>{{ $customer->terminate->branch->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Province:</th>
                                                    <td>{{ province($customer->terminate->province) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Address:</th>
                                                    <td>{{ $customer->terminate->address }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Package:</th>
                                                    <td>
                                                        @if($customer->terminate->package)
                                                            {{ $customer->terminate->package->name }}
                                                        @else
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Package Price:</th>
                                                    <td>
                                                        @if($customer->terminate->package_price)
                                                            <span>
                                                                {{ $customer->terminate->package_price }}
                                                            </span>
                                                            <span>
                                                                {{ $customer->terminate->package_price_currency }}
                                                            </span> 
                                                        @else
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Reseller Name</th>
                                                    <td>
                                                        @if($customer->terminate->commission)
                                                            {{ $customer->terminate->commission->name }}
                                                        @else
                                                            NA
                                                        @endif
                                                    </td>
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
                                                    <th>Discount:</th>
                                                    <td>
                                                        @if($customer->terminate->discount)
                                                            <span>
                                                                {{ $customer->terminate->discount }}
                                                            </span>
                                                            <span>
                                                                {{ $customer->terminate->discount_currency }}
                                                            </span>
                                                        @else
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Discount Period:</th>
                                                    <td>
                                                        @if($customer->terminate->discount_period)
                                                            <span>
                                                                {{ $customer->terminate->discount_period }}
                                                            </span>
                                                            <span>
                                                                {{ $customer->terminate->discount_period_currency }}
                                                            </span>
                                                        @else
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Discount Reason:</th>
                                                    <td>
                                                        @if($customer->terminate->discount_reason)
                                                            {{ $customer->terminate->discount_reason }}
                                                        @else
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Equipment Possession:</th>
                                                    <td>{{ $customer->terminate->equi_type }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Leased Type:</th>
                                                    <td>
                                                        @if($customer->terminate->leased_type)
                                                            {{ $customer->terminate->leased_type }}
                                                        @else 
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Receiver Type:</th>
                                                    <td>{{ $customer->terminate->receiver_type }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Receiver Price:</th>
                                                    <td>
                                                        @if($customer->terminate->receiver_price)
                                                            <span>
                                                                {{ $customer->terminate->receiver_price }}
                                                            </span>
                                                            <span>
                                                                {{ $customer->terminate->receiver_price_currency }}
                                                            </span>
                                                        @else 
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Router Type:</th>
                                                    <td>
                                                        @if($customer->terminate->router_type)
                                                            {{ $customer->terminate->router_type }}
                                                        @else 
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr> 
                                                    <th>Router Price:</th>
                                                    <td>
                                                        @if($customer->terminate->router_price)
                                                            <span>
                                                                {{ $customer->terminate->router_price }}
                                                            </span>
                                                            <span>
                                                                {{ $customer->terminate->router_price_currency }}
                                                            </span>
                                                        @else 
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Cable Price:</th>
                                                    <td>
                                                        <span>
                                                            {{ $customer->terminate->cable_price }}
                                                        </span>
                                                        <span>
                                                            {{ $customer->terminate->cable_price_currency }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Installation Cost:</th>
                                                    <td>
                                                        @if($customer->terminate->Installation_cost)
                                                            <span>
                                                                {{ $customer->terminate->Installation_cost }}
                                                            </span>
                                                            <span>
                                                                {{ $customer->terminate->Installation_cost_currency }}
                                                            </span>
                                                        @else
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Public IP:</th>
                                                    <td>
                                                        @if($customer->terminate->public_ip)
                                                            {{ $customer->terminate->public_ip }}
                                                        @else 
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Public IP Price:</th>
                                                    <td>
                                                        @if($customer->terminate->ip_price)
                                                            <span>
                                                                {{ $customer->terminate->ip_price }}
                                                            </span>
                                                            <span>
                                                                {{ $customer->terminate->ip_price_currency }}
                                                            </span>
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
                                            </tbody>
                                        </table>
							        </div> <!-- .item -->

							        <div class="media-29101  w-100">
							          	<table class="table table-striped table-dark">
                                            <tbody>
                                                <tr>
                                                    <th>Recontract Date</th>
                                                    <td>{{ $customer->recontract_date }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Recontract Reason</th>
                                                    <td>{{ $customer->comment }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Recontract By</th>
                                                    <td>{{ $customer->user->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Customer ID:</th>
                                                    <td>{{ $customer->customer_id }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Full Name:</th>
                                                    <td>{{ $customer->full_name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>POC:</th>
                                                    <td>{{ $customer->poc }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Phone:</th>
                                                    <td>
                                                        {{ $customer->phone1 }}
                                                        -
                                                        {{ $customer->phone2 }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Education:</th>
                                                    <td>{{ $customer->education }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Identity Number:</th>
                                                    <td>{{ $customer->identity }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Branch:</th>
                                                    <td>{{ $customer->branch->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Province:</th>
                                                    <td>{{ province($customer->province) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Address:</th>
                                                    <td>{{ $customer->address }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Package:</th>
                                                    <td>
                                                        @if($customer->package)
                                                            {{ $customer->package->name }}
                                                        @else
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Package Price:</th>
                                                    <td>
                                                        @if($customer->package_price)
                                                            <span>
                                                                {{ $customer->package_price }}
                                                            </span>
                                                            <span>
                                                                {{ $customer->package_price_currency }}
                                                            </span> 
                                                        @else
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Reseller Name</th>
                                                    <td>
                                                        @if($customer->commission)
                                                            {{ $customer->commission->name }}
                                                        @else
                                                            NA
                                                        @endif
                                                    </td>
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
                                                    <th>Discount:</th>
                                                    <td>
                                                        @if($customer->discount)
                                                            <span>
                                                                {{ $customer->discount }}
                                                            </span>
                                                            <span>
                                                                {{ $customer->discount_currency }}
                                                            </span>
                                                        @else
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Discount Period:</th>
                                                    <td>
                                                        @if($customer->discount_period)
                                                            <span>
                                                                {{ $customer->discount_period }}
                                                            </span>
                                                            <span>
                                                                {{ $customer->discount_period_currency }}
                                                            </span>
                                                        @else
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Discount Reason:</th>
                                                    <td>
                                                        @if($customer->discount_reason)
                                                            {{ $customer->discount_reason }}
                                                        @else
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Equipment Possession:</th>
                                                    <td>{{ $customer->equi_type }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Leased Type:</th>
                                                    <td>
                                                        @if($customer->leased_type)
                                                            {{ $customer->leased_type }}
                                                        @else 
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Receiver Type:</th>
                                                    <td>{{ $customer->receiver_type }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Receiver Price:</th>
                                                    <td>
                                                        @if($customer->receiver_price)
                                                            <span>
                                                                {{ $customer->receiver_price }}
                                                            </span>
                                                            <span>
                                                                {{ $customer->receiver_price_currency }}
                                                            </span>
                                                        @else 
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Router Type:</th>
                                                    <td>
                                                        @if($customer->router_type)
                                                            {{ $customer->router_type }}
                                                        @else 
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr> 
                                                    <th>Router Price:</th>
                                                    <td>
                                                        @if($customer->router_price)
                                                            <span>
                                                                {{ $customer->router_price }}
                                                            </span>
                                                            <span>
                                                                {{ $customer->router_price_currency }}
                                                            </span>
                                                        @else 
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Cable Price:</th>
                                                    <td>
                                                        <span>
                                                            {{ $customer->cable_price }}
                                                        </span>
                                                        <span>
                                                            {{ $customer->cable_price_currency }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Installation Cost:</th>
                                                    <td>
                                                        @if($customer->Installation_cost)
                                                            <span>
                                                                {{ $customer->Installation_cost }}
                                                            </span>
                                                            <span>
                                                                {{ $customer->Installation_cost_currency }}
                                                            </span>
                                                        @else
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Public IP:</th>
                                                    <td>
                                                        @if($customer->public_ip)
                                                            {{ $customer->public_ip }}
                                                        @else 
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Public IP Price:</th>
                                                    <td>
                                                        @if($customer->ip_price)
                                                            <span>
                                                                {{ $customer->ip_price }}
                                                            </span>
                                                            <span>
                                                                {{ $customer->ip_price_currency }}
                                                            </span>
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
                                                    <th>Created At:</th>
                                                    <td>{{ $customer->created_at }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
							        </div> <!-- .item -->
						      	</div>

                        	</div> <!-- /card-body -->
                        </div> <!-- /card -->
                    </div> <!-- /col-9 -->

                    <div class="col-md-3">
                       @include('sales.customers.recontracts.sidebar')
                    </div> <!-- /col-3 -->

                </div> <!-- /row -->
            </div>
        </div>

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
               url:"{{ route('confirm.recontract') }}",
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
