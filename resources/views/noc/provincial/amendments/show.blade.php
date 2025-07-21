@extends('noc.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Customer</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('noc.pr.amend',$customer->provincial) }}
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
                                <a href="#" class="col active">Sales Details</a>
                                <a href="#" class="col">Amend Details</a>
                            </div> <!-- /owl-nav -->

                            <div class="owl-carousel owl-1">

                                <div class="media-29101 d-md-flex w-100">
                                    <table class="table table-striped">
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
                                                    @if($customer->package)
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
                                                <td>{{ $customer->commission->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Reseller Percentage</th>
                                                <td>
                                                    {{ $customer->commission_percent ."%" }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Service</th>
                                                <td>{{ $customer->service }}</td>
                                            </tr>
                                            <tr>
                                                <th>Provider</th>
                                                @if ($customer->provincial->provider)
                                                <td>{{ $customer->provincial->provider->name }}</td>
                                                @else
                                                <td>NA</td>
                                                @endif
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
                                            <tr class="price">
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
                                                <th>Total Amount:</th>
                                                <td class="afg"></td>
                                            </tr>
                                            <tr>
                                                <th>Total Amount:</th>
                                                <td class="dollar"></td>
                                            </tr>
                                        </tbody>
                                    </table> <!-- /table -->
                                </div> <!-- .item -->

                                <div class="media-29101  w-100">
                                    @if($customer->exists())
                                    <table class="table table-striped table-dark">
                                        <tbody>
                                            <?php
                                                        $clone = json_decode($customer->clone);
                                                    ?>
                                            <tr>
                                                <th>Amend Date</th>
                                                <td>{{ $customer->amend_date }}</td>
                                            </tr>
                                            <tr>
                                                <th>Amend Comment</th>
                                                <td>
                                                    {{ $customer->amend_comment }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Updater</th>
                                                <td>{{ $customer->user->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Created At</th>
                                                <td>{{ $customer->created_at }}</td>
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
                                            @if($customer->province != $clone->province)
                                            <tr>
                                                <th>Province</th>
                                                <td>
                                                    {{ province($clone->province) }}
                                                    =>
                                                    {{ province($customer->province) }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->customerProvince != $clone->customerProvince)
                                            <tr>
                                                <th>Customer Province</th>
                                                <td>
                                                    {{ province($clone->customerProvince) }}
                                                    =>
                                                    {{ province($customer->customerProvince) }}
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
                                            @isset($clone->marketer_id)
                                            @if($customer->marketer_id != $clone->marketer_id)
                                            <tr>
                                                <th>Field Officer</th>
                                                <td>
                                                    {{ marketer($clone->marketer_id) }}
                                                    =>
                                                    {{ $customer->provincial->marketer->name }}
                                                </td>
                                            </tr>
                                            @endif
                                            @endisset
                                            @if($customer->service != $clone->service)
                                            <tr>
                                                <th>Reseller Percentage</th>
                                                <td>
                                                    {{ $clone->service }}
                                                    =>
                                                    {{ $customer->service }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($customer->provincial->provider->name != $clone->provider->name)
                                            <tr>
                                                <th>Reseller Percentage</th>
                                                <td>
                                                    {{ $clone->provider->name }}
                                                    =>
                                                    {{ $customer->provincial->provider->name }}
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
                                    @endif
                                </div> <!-- .item -->

                            </div> <!-- /owl -->

                        </div> <!-- /card-body -->
                    </div> <!-- /card -->

                </div> <!-- /col-9 -->

                <div class="col-md-3">
                    @include('noc.provincial.amendments.sidebar')
                </div> <!-- /col-3 -->

            </div> <!-- /row -->
        </div>
    </div> <!-- /col-12 -->

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
               url:"{{ route('prAmend.confirm') }}",
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
