@extends('finance.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Customer</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('finance.amedments.amend',$customer->customer) }}
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
                                <a href="#" class="col">Amendments Details</a>
                            </div>

                            <div class="owl-carousel owl-1">

                                <div class="media-29101 d-md-flex w-100">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <th>Customer ID:</th>
                                                <td>
                                                    {{ $customer->customer_id }}
                                                </td>
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
                                            <tr class="price">
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
                                            <tr class="discount">
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
                                            <tr class="price">
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
                                            <tr class="price">
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
                                            <tr class="price">
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
                                            <tr class="price">
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
                                            <tr class="price">
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
                                                <th>Comment:</th>
                                                <td>
                                                    @if($customer->comment)
                                                    {{ $customer->comment }}
                                                    @else
                                                    NA
                                                    @endif
                                                </td>
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
                                            <?php
                                                    $clone = json_decode($customer->clone);
                                                ?>
                                            <tr>
                                                <th>Amendment Date</th>
                                                <td>
                                                    {{ $customer->amend_date }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Created At:</th>
                                                <td>{{ $customer->created_at }}</td>
                                            </tr>
                                            <tr>
                                                <th>Amendment Comment</th>
                                                <td>{{ $customer->amedment_comment }}</td>
                                            </tr>
                                            <tr>
                                                <th>Amendment By</th>
                                                <td>{{ $customer->user->name }}</td>
                                            </tr>

                                            @if($clone)

                                            @if($customer->customer_id != $clone->customer_id)
                                            <tr>
                                                <th>Customer ID</th>
                                                <td>
                                                    {{ $clone->customer_id }}
                                                    =>
                                                    {{ $customer->customer_id }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->full_name != $clone->full_name)
                                            <tr>
                                                <th>Full Name</th>
                                                <td>
                                                    {{ $clone->full_name }}
                                                    =>
                                                    {{ $customer->full_name }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->poc != $clone->poc)
                                            <tr>
                                                <th>POC</th>
                                                <td>
                                                    {{ $clone->poc }}
                                                    =>
                                                    {{ $customer->poc }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->phone1 != $clone->phone1)
                                            <tr>
                                                <th>Phone</th>
                                                <td>
                                                    {{ $clone->phone1 }}
                                                    =>
                                                    {{ $customer->phone1 }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->phone2 != $clone->phone2)
                                            <tr>
                                                <th>Phone</th>
                                                <td>
                                                    {{ $clone->phone2 }}
                                                    =>
                                                    {{ $customer->phone2 }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->education != $clone->education)
                                            <tr>
                                                <th>Education</th>
                                                <td>
                                                    {{ $clone->education }}
                                                    =>
                                                    {{ $customer->education }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->identity != $clone->identity_num)
                                            <tr>
                                                <th>Identity</th>
                                                <td>
                                                    {{ $clone->identity_num }}
                                                    =>
                                                    {{ $customer->identity }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->address != $clone->address)
                                            <tr>
                                                <th>Address</th>
                                                <td>
                                                    {{ $clone->address }}
                                                    =>
                                                    {{ $customer->address }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->package_id != $clone->package_id)
                                            <tr>
                                                <th>Package</th>
                                                <td>
                                                    {{ package($clone->package_id) }}
                                                    =>
                                                    {{ $customer->package->name }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->package_price != $clone->package_price)
                                            <tr>
                                                <th>Package Price</th>
                                                <td>
                                                    {{ $clone->package_price }} {{ $clone->package_price_currency }}
                                                    =>
                                                    {{ $customer->package_price }}
                                                    {{ $customer->package_price_currency }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->discount != $clone->discount)
                                            <tr>
                                                <th>Discount</th>
                                                <td>
                                                    {{ $clone->discount }} {{ $clone->discount_currency }}
                                                    =>
                                                    {{ $customer->discount }}
                                                    {{ $customer->discount_currency }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->discount_period && ( $customer->discount_period !=
                                            $clone->discount_period))
                                            <tr>
                                                <th>Discount Period</th>
                                                <td>
                                                    {{ $clone->discount_period }} {{ $clone->discount_period_currency }}
                                                    =>
                                                    {{ $customer->discount_period }}
                                                    {{ $customer->discount_period_currency }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if( $customer->discount_reason && ($customer->discount_reason !=
                                            $clone->discount_reason))
                                            <tr>
                                                <th>Discount Reason</th>
                                                <td>
                                                    {{ $clone->discount_reason }}
                                                    =>
                                                    {{ $customer->discount_reason }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->commission_id != $clone->commission_id)
                                            <tr>
                                                <th>Reseller</th>
                                                <td>
                                                    {{ reseller($clone->commission_id) }}
                                                    =>
                                                    {{ $customer->commission->name }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->commission_percent != $clone->commission_percent)
                                            <tr>
                                                <th>Reseller Percentage</th>
                                                <td>
                                                    {{ $clone->commission_percent }}
                                                    =>
                                                    {{ $customer->commission_percent }}
                                                </td>
                                            </tr>
                                            @endif
                                            {{-- @if($customer->marketer_id != $clone->marketer_id)
                                            <tr>
                                                <th>Field Officer</th>
                                                <td>
                                                    {{ marketer($clone->marketer_id) }}
                                                    =>
                                                    {{ $customer->marketer->name }}
                                                </td>
                                            </tr>
                                            @endif --}}
                                            @if($customer->equi_type != $clone->equi_type)
                                            <tr>
                                                <th>Equipment Possession</th>
                                                <td>
                                                    {{ $clone->equi_type }}
                                                    =>
                                                    {{ $customer->equi_type }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->leased_type != $clone->leased_type)
                                            <tr>
                                                <th>Lease Type</th>
                                                <td>
                                                    {{ $clone->leased_type }}
                                                    =>
                                                    {{ $customer->leased_type }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->receiver_type != $clone->receiver_type)
                                            <tr>
                                                <th>Receiver Type</th>
                                                <td>
                                                    {{ $clone->receiver_type }}
                                                    =>
                                                    {{ $customer->receiver_type }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->receiver_price != $clone->receiver_price)
                                            <tr>
                                                <th>Receiver Price</th>
                                                <td>
                                                    {{ $clone->receiver_price }} {{ $clone->receiver_price_currency }}
                                                    =>
                                                    {{ $customer->receiver_price }}
                                                    {{ $customer->receiver_price_currency }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->router_type != $clone->router_type)
                                            <tr>
                                                <th>Router Price</th>
                                                <td>
                                                    {{ $clone->router_type }}
                                                    =>
                                                    {{ $customer->router_type }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->router_price != $clone->router_price)
                                            <tr>
                                                <th>Router Price</th>
                                                <td>
                                                    {{ $clone->router_price }} {{ $clone->router_price_currency }}
                                                    =>
                                                    {{ $customer->router_price }}
                                                    {{ $customer->router_price_currency }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->cable_price != $clone->cable_price)
                                            <tr>
                                                <th>Cable Price</th>
                                                <td>
                                                    {{ $clone->cable_price }} {{ $clone->cable_price_currency }}
                                                    =>
                                                    {{ $customer->cable_price }}
                                                    {{ $customer->cable_price_currency }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->Installation_cost != $clone->Installation_cost)
                                            <tr>
                                                <th>Installation Cost</th>
                                                <td>
                                                    {{ $clone->Installation_cost }} {{
                                                    $clone->Installation_cost_currency }}
                                                    =>
                                                    {{ $customer->Installation_cost }}
                                                    {{ $customer->Installation_cost_currency }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->public_ip != $clone->public_ip)
                                            <tr>
                                                <th>Public IP</th>
                                                <td>
                                                    {{ $clone->public_ip }}
                                                    =>
                                                    {{ $customer->public_ip }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->ip_price != $clone->ip_price)
                                            <tr>
                                                <th>Public IP Price</th>
                                                <td>
                                                    {{ $clone->ip_price }} {{ $clone->ip_price_currency }}
                                                    =>
                                                    {{ $customer->ip_price }}
                                                    {{ $customer->ip_price_currency }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->additional_charge != $clone->additional_charge)
                                            <tr>
                                                <th>Additional Charge</th>
                                                <td>
                                                    {{ $clone->additional_charge }}
                                                    =>
                                                    {{ $customer->additional_charge }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->additional_charge_price != $clone->additional_charge_price)
                                            <tr>
                                                <th>Additional Charge Price</th>
                                                <td>
                                                    {{ $clone->additional_charge_price }} {{ $clone->additional_currency
                                                    }}
                                                    =>
                                                    {{ $customer->additional_charge_price }}
                                                    {{ $customer->additional_currency }}
                                                </td>
                                            </tr>
                                            @endif

                                            @endif

                                        </tbody>
                                    </table>
                                </div> <!-- .item -->

                            </div>

                        </div> <!-- /card-body -->
                    </div> <!-- /card -->
                </div> <!-- /col-9 -->

                <div class="col-md-3">
                    @include('finance.customers.amendments.sidebar')
                </div> <!-- /col-3 -->

            </div> <!-- /row -->
        </div>
    </div>

    <div class="clearfix"></div>
</div> <!-- /end of page content -->
@endsection

@section('style')
<style>
    .carousel-nav a {
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
               url:"{{ route('amend.confirm') }}",
               method:'post',
               data:{
                    "_token": "{{ csrf_token() }}",
                    id:"{{ $customer->id }}",
                },
                success:function(response){
                    if(response == 'success'){
                        location.reload();
                    }
                    console.log(response)
               }
            });

        });

   });
</script>
@endsection