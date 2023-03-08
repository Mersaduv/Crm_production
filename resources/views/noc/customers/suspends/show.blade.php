@extends('noc.layouts.app')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Customer</h4>
                  
                <div class="history">

                    <div class="row">
                        <div class="col-sm-6">
                           {{ Breadcrumbs::render('noc.suspend',$customer) }}
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
							        <a href="#" class="col active">Sales Details</a>
							        <a href="#" class="col">Suspends Details</a>
							    </div>	

                        		<div class="owl-carousel owl-1">

							        <div class="media-29101 d-md-flex w-100">
							          	<table class="table table-striped">
                                            <tbody>
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
                                                    <td>{{ $customer->identity_num }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Branch:</th>
                                                    <td>{{ $customer->branch->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Address:</th>
                                                    <td>{{ $customer->address }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Package:</th>
                                                    <td>
                                                        @if($customer->sale->package)
                                                            {{ $customer->sale->package->name }}
                                                        @else
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr class="price">
                                                    <th>Package Price:</th>
                                                    <td>
                                                        @if($customer->sale->package_price)
                                                            <span>
                                                                {{ $customer->sale->package_price }}
                                                            </span>
                                                            <span>
                                                                {{ $customer->sale->package_price_currency }}
                                                            </span> 
                                                        @else
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Reseller Name</th>
                                                    <td>
                                                        @if($customer->sale->commission)
                                                            {{ $customer->sale->commission->name }}
                                                        @else
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Reseller Percentage</th>
                                                    <td>
                                                        <span>
                                                            {{ $customer->sale->commission_percent ."%" }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr class="discount">
                                                    <th>Discount:</th>
                                                    <td>
                                                        @if($customer->sale->discount)
                                                            <span>
                                                                {{ $customer->sale->discount }}
                                                            </span>
                                                            <span>
                                                                {{ $customer->sale->discount_currency }}
                                                            </span>
                                                        @else
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Discount Period:</th>
                                                    <td>
                                                        @if($customer->sale->discount_period)
                                                            <span>
                                                                {{ $customer->sale->discount_period }}
                                                            </span>
                                                            <span>
                                                                {{ $customer->sale->discount_period_currency }}
                                                            </span>
                                                        @else
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Discount Reason:</th>
                                                    <td>
                                                        @if($customer->sale->discount_reason)
                                                            {{ $customer->sale->discount_reason }}
                                                        @else
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Equipment Possession:</th>
                                                    <td>{{ $customer->sale->equi_type }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Leased Type:</th>
                                                    <td>
                                                        @if($customer->sale->leased_type)
                                                            {{ $customer->sale->leased_type }}
                                                        @else 
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Receiver Type:</th>
                                                    <td>{{ $customer->sale->receiver_type }}</td>
                                                </tr>
                                                <tr class="price">
                                                    <th>Receiver Price:</th>
                                                    <td>
                                                        @if($customer->sale->receiver_price)
                                                            <span>
                                                                {{ $customer->sale->receiver_price }}
                                                            </span>
                                                            <span>
                                                                {{ $customer->sale->receiver_price_currency }}
                                                            </span>
                                                        @else 
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Router Type:</th>
                                                    <td>
                                                        @if($customer->sale->router_type)
                                                            {{ $customer->sale->router_type }}
                                                        @else 
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr class="price"> 
                                                    <th>Router Price:</th>
                                                    <td>
                                                        @if($customer->sale->router_price)
                                                            <span>
                                                                {{ $customer->sale->router_price }}
                                                            </span>
                                                            <span>
                                                                {{ $customer->sale->router_price_currency }}
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
                                                            {{ $customer->sale->cable_price }}
                                                        </span>
                                                        <span>
                                                            {{ $customer->sale->cable_price_currency }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr class="price">
                                                    <th>Installation Cost:</th>
                                                    <td>
                                                        @if($customer->sale->Installation_cost)
                                                            <span>
                                                                {{ $customer->sale->Installation_cost }}
                                                            </span>
                                                            <span>
                                                                {{ $customer->sale->Installation_cost_currency }}
                                                            </span>

                                                        @else
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Installation Date:</th>
                                                    <td>{{ Carbon\Carbon::parse($customer->sale->
                                                        installation_date)->format('Y-m-d') }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Public IP:</th>
                                                    <td>
                                                        @if($customer->sale->public_ip)
                                                            {{ $customer->sale->public_ip }}
                                                        @else 
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr class="price">
                                                    <th>Public IP Price:</th>
                                                    <td>
                                                        @if($customer->sale->ip_price)
                                                            <span>
                                                                {{ $customer->sale->ip_price }}
                                                            </span>
                                                            <span>
                                                                {{ $customer->sale->ip_price_currency }}
                                                            </span>
                                                        @else 
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Additional Charge:</th>
                                                    <td>
                                                        @if($customer->sale->additional_charge)
                                                            {{ $customer->sale->additional_charge }}
                                                        @else 
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr class="price">
                                                    <th>Additional Charge Price:</th>
                                                    <td>
                                                        @if($customer->sale->additional_charge_price)
                                                            <span>
                                                                {{ $customer->sale->additional_charge_price }}
                                                            </span>
                                                            <span>
                                                                {{ $customer->sale->additional_currency }}
                                                            </span>
                                                        @else 
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Comment:</th>
                                                    <td>
                                                        @if($customer->sale->comment)
                                                            {{ $customer->sale->comment }}
                                                        @else 
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Created At:</th>
                                                    <td>{{ $customer->created_at }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Created By:</th>
                                                    <td>{{ $customer->sale->user->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Total Amount:</th>
                                                    <td class="afg"></td>
                                                </tr>
                                                <tr>
                                                    <th>Total Amount:</th>
                                                    <td class="dollar"></td>
                                                </tr>
                                            </tbody>
                                        </table>
							        </div> <!-- .item -->

							        <div class="media-29101  w-100">
							          	<table class="table table-striped table-dark">
                                            <tbody>
                                                <tr>
                                                    <th>Suspend Date:</th>
                                                    <td>{{ $customer->suspend->first()->suspend_date }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Re-Activation Date:</th>
                                                    <td>
                                                        @if($customer->suspend->first()->reactivation_date)
                                                            {{ $customer->suspend->first()->reactivation_date }}
                                                        @else
                                                            NA
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Suspend Reason:</th>
                                                    <td>{{ $customer->suspend->first()->suspend_reason }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Suspend By:</th>
                                                    <td>{{ $customer->suspend->first()->user->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Created At:</th>
                                                    <td>{{ $customer->suspend->first()->created_at }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
							        </div> <!-- .item -->

						      	</div>

                        	</div> <!-- /card-body -->
                        </div> <!-- /card -->
                    </div> <!-- /col-9 -->

                    <div class="col-md-3">
                       @include('noc.customers.suspends.sidebar')
                    </div> <!-- /col-3 -->

                </div> <!-- /row -->
            </div>
        </div>

        <!-- The Modal -->
        <div class="modal" id="editSuspend">
          <div class="modal-dialog">
            <div class="modal-content">

              <form method="post"
                    id="formID" 
                    action="{{ route('noc.suspend.edit',$customer->suspend->first()->id) }}">
                    @csrf
                    @method('put')

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Edit Suspend</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">
                    
                    <div class="form-group">
                        <label for="suspend_date">Suspend Date:</label>
                        <input type="date" 
                               name="suspend_date"
                               id="suspend_date"
                               class="form-control" 
                               required="required"
                               value="{{ $customer->suspend->first()->suspend_date }}" 
                            />
                    </div>

                    <div class="form-group">
                        <label for="suspend_reason">Suspend Reason:</label>
                        <textarea class="form-control" 
                              name="suspend_reason" 
                              id="suspend_reason"
                              placeholder="Suspend Reason"
                              rows="5" required="required">{{ $customer->suspend->first()->suspend_reason }}</textarea>
                    </div>

                  </div> <!-- /modal-body -->

                  <!-- Modal footer -->
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>

              </form>

            </div>
          </div>
        </div> <!-- // end of suspend modal -->

        <!-- The Modal -->
        <div class="modal" id="deleteSuspend">
          <div class="modal-dialog">
            <div class="modal-content">

              <form method="post"
                    id="formID" 
                    action="{{ route('noc.suspend.delete',$customer->suspend->first()->id) }}">
                    @csrf
                    @method('delete')

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Delete Suspend</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">
                    
                    <h3>Are you sure?</h3>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Delete</button>
                  </div>

              </form>

            </div>
          </div>
        </div> <!-- // end of delete modal -->

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
               url:"{{ route('suspend.confirm') }}",
               method:'post',
               data:{
                    "_token": "{{ csrf_token() }}",
                    id:"{{ $customer->suspend->first()->id }}", 
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
