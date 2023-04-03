@extends('finance.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Customer</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('finance.pr.name',$customer) }}
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
                                <a href="#" class="col">Noc Details</a>
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
                                                <th>Branch</th>
                                                <td>{{ $customer->branch->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Province</th>
                                                <td>{{ province($customer->province) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Customer Province</th>
                                                <th>{{ province($customer->customerProvince) }}</th>
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
                                                <td>
                                                    @if($customer->commission)
                                                    {{ $customer->commission->name }}
                                                    @else

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
                                                <th>Installation Date</th>
                                                <td>{{
                                                    Carbon\Carbon::parse($customer->installation_date)->format('Y-m-d')
                                                    }}</td>
                                            </tr>
                                            <tr class="price">
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
                                                @if ($customer->provider)
                                                <td>{{ $customer->provider->name }}</td>
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
                                                <th>Comment</th>
                                                <td>
                                                    @if($customer->comment)
                                                    {{ $customer->comment }}
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
                                                <td>{{ $customer->user->name }}</td>
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
                                    @if($customer->PrNocInfo()->exists())
                                    <table class="table table-striped table-dark">
                                        <tbody>
                                            <tr>
                                                <th>Activation Date</th>
                                                <td>
                                                    {{ Carbon\Carbon::parse($customer
                                                    ->PrNocInfo->activation_date)
                                                    ->format('Y-m-d')
                                                    }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Latitude</th>
                                                <td>{{ $customer->PrNocInfo->latitiude ? $customer->PrNocInfo->latitiude
                                                    : 'NA' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Longitude</th>
                                                <td>{{ $customer->PrNocInfo->longitude ? $customer->PrNocInfo->longitude
                                                    : 'NA' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Additional Fee Reason</th>
                                                <td>
                                                    {{ $customer->PrNocInfo->additional_fee }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Additional Fee Price</th>
                                                <td>
                                                    {{ $customer->PrNocInfo->additional_fee_price }}
                                                    {{ $customer->PrNocInfo->additional_fee_currency }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Created At</th>
                                                <td>{{ $customer->PrNocInfo->created_at }}</td>
                                            </tr>
                                            <tr>
                                                <th>Created By</th>
                                                <td>
                                                    {{ $customer->PrNocInfo->user->name }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    @else
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <h1>Customer is not active</h1>
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                    @endif
                                </div> <!-- .item -->

                            </div> <!-- /owl -->

                        </div> <!-- /card-body -->
                    </div> <!-- /card -->

                </div> <!-- /col-9 -->

                <div class="col-md-3">
                    @include('finance.provincial.portion.sidebar')
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

    .card-header a {
        color: #212529 !important;
    }

    #financeForm label {
        margin-bottom: 0;
        margin-top: 10px;
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

</script>
@endsection