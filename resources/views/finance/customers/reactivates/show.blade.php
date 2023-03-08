@extends('finance.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Reactivate Details</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('finance.suspend',$customer->customer) }}
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
                                <a href="#" class="col active">Suspend Details</a>
                                <a href="#" class="col">Reactivation Details</a>
                            </div>

                            <div class="owl-carousel owl-1">

                                <div class="media-29101 d-md-flex w-100">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <th>Suspend Date:</th>
                                                <td>{{ $customer->suspend->suspend_date }}</td>
                                            </tr>
                                            <tr>
                                                <th>Suspend Comment</th>
                                                <td>{{ $customer->suspend->suspend_reason ?
                                                    $customer->suspend->suspend_reason : 'NA' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Suspend By</th>
                                                <td>{{ $customer->suspend->user->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Customer ID</th>
                                                <td>
                                                    {{ $customer->suspend->customer_id }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Full Name</th>
                                                <td>
                                                    {{ $customer->suspend->full_name }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>POC</th>
                                                <td>
                                                    {{ $customer->suspend->poc }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Phone</th>
                                                <td>
                                                    {{ $customer->suspend->phone1 }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Phone</th>
                                                <td>
                                                    {{ $customer->suspend->phone2 }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Education</th>
                                                <td>
                                                    {{ $customer->suspend->education }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Identity</th>
                                                <td>
                                                    {{ $customer->suspend->identity }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <td>
                                                    {{ $customer->suspend->address }}
                                                </td>
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
                                                <th>Package</th>
                                                <td>
                                                    {{ $customer->suspend->package->name }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Package Price</th>
                                                <td>
                                                    {{ $customer->suspend->package->price }} {{
                                                    $customer->suspend->package->price_currency }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Discount</th>
                                                <td>
                                                    {{ $customer->suspend->discount }} {{
                                                    $customer->suspend->discount_currency }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Discount Period</th>
                                                <td>
                                                    {{ $customer->suspend->discount_period }} {{
                                                    $customer->suspend->discount_period_currency }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Discount Reason</th>
                                                <td>
                                                    {{ $customer->suspend->discount_reason ?
                                                    $customer->suspend->discount_reason : 'NA' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Reseller</th>
                                                <td>
                                                    {{ $customer->suspend->commission ?
                                                    $customer->suspend->commission->name : 'NA' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Reseller Percentage</th>
                                                <td>
                                                    {{ $customer->suspend->commission_percent ?
                                                    $customer->suspend->commission_percent : 'NA' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Equipment Possession</th>
                                                <td>
                                                    {{ $customer->suspend->equi_type }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Lease Type</th>
                                                <td>
                                                    {{ $customer->suspend->leased_type }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Receiver Type</th>
                                                <td>
                                                    {{ $customer->suspend->receiver_type }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Receiver Price</th>
                                                <td>
                                                    {{ $customer->suspend->receiver_price }} {{
                                                    $customer->suspend->receiver_price_currency }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Router Price</th>
                                                <td>
                                                    {{ $customer->suspend->router_type }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Router Price</th>
                                                <td>
                                                    {{ $customer->suspend->router_price }} {{
                                                    $customer->suspend->router_price_currency }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Cable Price</th>
                                                <td>
                                                    {{ $customer->suspend->cable_price }} {{
                                                    $customer->suspend->cable_price_currency }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Public IP</th>
                                                <td>
                                                    {{ $customer->suspend->public_ip ? $customer->suspend->public_ip :
                                                    'NA' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Public IP Price</th>
                                                <td>
                                                    {{ $customer->suspend->ip_price }} {{
                                                    $customer->suspend->ip_price_currency }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Additional Charge</th>
                                                <td>
                                                    {{ $customer->suspend->additional_charge ?
                                                    $customer->suspend->additional_charge : 'NA' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Additional Charge Price</th>
                                                <td>
                                                    {{ $customer->suspend->additional_charge_price }} {{
                                                    $customer->suspend->additional_currency }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div> <!-- .item -->

                                <div class="media-29101 w-100">
                                    <table class="table table-striped table-dark">
                                        <tbody>
                                            <tr>
                                                <th>Reactivation Date</th>
                                                <td>{{ $customer->reactivation_date }}</td>
                                            </tr>
                                            <tr>
                                                <th>Reactivation Comment</th>
                                                <td>{{ $customer->comment ? $customer->comment : 'NA' }}</td>
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
                                                <th>Phone</th>
                                                <td>
                                                    {{ $customer->suspend->phone1 }}
                                                    =>
                                                    {{ $customer->phone1 }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->phone2 != $customer->suspend->phone2)
                                            <tr>
                                                <th>Phone</th>
                                                <td>
                                                    {{ $customer->suspend->phone2 }}
                                                    =>
                                                    {{ $customer->phone2 }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->education != $customer->suspend->education)
                                            <tr>
                                                <th>Education</th>
                                                <td>
                                                    {{ $customer->suspend->education }}
                                                    =>
                                                    {{ $customer->education }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->identity != $customer->suspend->identity)
                                            <tr>
                                                <th>Identity</th>
                                                <td>
                                                    {{ $customer->suspend->identity }}
                                                    =>
                                                    {{ $customer->identity }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->address != $customer->suspend->address)
                                            <tr>
                                                <th>Address</th>
                                                <td>
                                                    {{ $customer->suspend->address }}
                                                    =>
                                                    {{ $customer->address }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->branch_id != $customer->suspend->branch_id)
                                            <tr>
                                                <th>Address</th>
                                                <td>
                                                    {{ $customer->suspend->branch->name }}
                                                    =>
                                                    {{ $customer->branch->name }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->province != $customer->suspend->province)
                                            <tr>
                                                <th>Address</th>
                                                <td>
                                                    {{ province($customer->suspend->province) }}
                                                    =>
                                                    {{ province($customer->province) }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->package_id != $customer->suspend->package_id)
                                            <tr>
                                                <th>Package</th>
                                                <td>
                                                    {{ $customer->suspend->package_id }}
                                                    =>
                                                    {{ $customer->package->name }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->package_price != $customer->suspend->package_price)
                                            <tr>
                                                <th>Package Price</th>
                                                <td>
                                                    {{ $customer->suspend->package_price }} {{
                                                    $customer->suspend->package_price_currency }}
                                                    =>
                                                    {{ $customer->package_price }}
                                                    {{ $customer->package_price_currency }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->discount != $customer->suspend->discount)
                                            <tr>
                                                <th>Discount</th>
                                                <td>
                                                    {{ $customer->suspend->discount }} {{
                                                    $customer->suspend->discount_currency }}
                                                    =>
                                                    {{ $customer->discount }}
                                                    {{ $customer->discount_currency }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->discount_period && ( $customer->discount_period !=
                                            $customer->suspend->discount_period))
                                            <tr>
                                                <th>Discount Period</th>
                                                <td>
                                                    {{ $customer->suspend->discount_period }} {{
                                                    $customer->suspend->discount_period_currency }}
                                                    =>
                                                    {{ $customer->discount_period }}
                                                    {{ $customer->discount_period_currency }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if( $customer->discount_reason && ($customer->discount_reason !=
                                            $customer->suspend->discount_reason))
                                            <tr>
                                                <th>Discount Reason</th>
                                                <td>
                                                    {{ $customer->suspend->discount_reason }}
                                                    =>
                                                    {{ $customer->discount_reason }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->commission_id != $customer->suspend->commission_id)
                                            <tr>
                                                <th>Reseller</th>
                                                <td>
                                                    {{ $customer->suspend->commission_id }}
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
                                            {{-- @if($customer->marketer_id != $customer->suspend->marketer_id)
                                            <tr>
                                                <th>Field Officer</th>
                                                <td>
                                                    {{ marketer($customer->suspend->marketer_id) }}
                                                    =>
                                                    {{ $customer->marketer->name }}
                                                </td>
                                            </tr>
                                            @endif --}}
                                            @if($customer->equi_type != $customer->suspend->equi_type)
                                            <tr>
                                                <th>Equipment Possession</th>
                                                <td>
                                                    {{ $customer->suspend->equi_type }}
                                                    =>
                                                    {{ $customer->equi_type }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->leased_type != $customer->suspend->leased_type)
                                            <tr>
                                                <th>Lease Type</th>
                                                <td>
                                                    {{ $customer->suspend->leased_type }}
                                                    =>
                                                    {{ $customer->leased_type }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->receiver_type != $customer->suspend->receiver_type)
                                            <tr>
                                                <th>Receiver Type</th>
                                                <td>
                                                    {{ $customer->suspend->receiver_type }}
                                                    =>
                                                    {{ $customer->receiver_type }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->receiver_price != $customer->suspend->receiver_price)
                                            <tr>
                                                <th>Receiver Price</th>
                                                <td>
                                                    {{ $customer->suspend->receiver_price }} {{
                                                    $customer->suspend->receiver_price_currency }}
                                                    =>
                                                    {{ $customer->receiver_price }}
                                                    {{ $customer->receiver_price_currency }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->router_type != $customer->suspend->router_type)
                                            <tr>
                                                <th>Router Price</th>
                                                <td>
                                                    {{ $customer->suspend->router_type }}
                                                    =>
                                                    {{ $customer->router_type }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->router_price != $customer->suspend->router_price)
                                            <tr>
                                                <th>Router Price</th>
                                                <td>
                                                    {{ $customer->suspend->router_price }} {{
                                                    $customer->suspend->router_price_currency }}
                                                    =>
                                                    {{ $customer->router_price }}
                                                    {{ $customer->router_price_currency }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->cable_price != $customer->suspend->cable_price)
                                            <tr>
                                                <th>Cable Price</th>
                                                <td>
                                                    {{ $customer->suspend->cable_price }} {{
                                                    $customer->suspend->cable_price_currency }}
                                                    =>
                                                    {{ $customer->cable_price }}
                                                    {{ $customer->cable_price_currency }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->Installation_cost != $customer->suspend->Installation_cost)
                                            <tr>
                                                <th>Installation Cost</th>
                                                <td>
                                                    {{ $customer->suspend->Installation_cost }} {{
                                                    $customer->suspend->Installation_cost_currency }}
                                                    =>
                                                    {{ $customer->Installation_cost }}
                                                    {{ $customer->Installation_cost_currency }}
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
                                                    {{ $customer->suspend->ip_price }} {{
                                                    $customer->suspend->ip_price_currency }}
                                                    =>
                                                    {{ $customer->ip_price }}
                                                    {{ $customer->ip_price_currency }}
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
                                            @if($customer->additional_charge_price !=
                                            $customer->suspend->additional_charge_price)
                                            <tr>
                                                <th>Additional Charge Price</th>
                                                <td>
                                                    {{ $customer->suspend->additional_charge_price }} {{
                                                    $customer->suspend->additional_currency }}
                                                    =>
                                                    {{ $customer->additional_charge_price }}
                                                    {{ $customer->additional_currency }}
                                                </td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div> <!-- .item -->

                            </div>

                        </div> <!-- /card-body -->
                    </div> <!-- /card -->
                </div> <!-- /col-9 -->

                <div class="col-md-3">
                    @include('finance.customers.reactivates.sidebar')
                </div> <!-- /col-3 -->

            </div> <!-- /row -->
        </div>
    </div>

    <div class="clearfix"></div>
</div> <!-- /end of page content -->
@endsection

@section('style')
<style>
    .customer_operation button {
        display: block;
        width: 100%;
        margin: 5px 0px;
    }

    .customer_operation button a {
        color: #fff;
    }

    .modal-dialog {
        max-width: 800px;
    }

    .modal-dialog img {
        width: 100%;
        height: auto;
        object-fit: cover;
    }

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
               url:"{{ route('confirm.reactivate') }}",
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