@extends('sales.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Customer</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('salesCustomer', $customer) }}
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
                                <a href="#" class="col">Noc Details</a>
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
                                                    @if ($customer->sale->package)
                                                    {{ $customer->sale->package->name }}
                                                    @else
                                                    NA
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="price">
                                                <th>Package Price:</th>
                                                <td>
                                                    @if ($customer->sale->package_price)
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
                                                    @if ($customer->sale->commission)
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
                                                        {{ $customer->sale->commission_percent . '%' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr class="discount">
                                                <th>Discount:</th>
                                                <td>
                                                    @if ($customer->sale->discount)
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
                                                    @if ($customer->sale->discount_period)
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
                                                    @if ($customer->sale->discount_reason)
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
                                                    @if ($customer->sale->leased_type)
                                                    {{ $customer->sale->leased_type }}
                                                    @else
                                                    NA
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Receiver Type:</th>
                                                <td>
                                                    @if ($customer->sale->receiver_type)
                                                    {{ $customer->sale->receiver_type }}
                                                    @else
                                                    NA
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="price">
                                                <th>Receiver Price:</th>
                                                <td>
                                                    @if ($customer->sale->receiver_price)
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
                                                    @if ($customer->sale->router_type)
                                                    {{ $customer->sale->router_type }}
                                                    @else
                                                    NA
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="price">
                                                <th>Router Price:</th>
                                                <td>
                                                    @if ($customer->sale->router_price)
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
                                                    @if ($customer->sale->Installation_cost)
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
                                                <td>{{
                                                    Carbon\Carbon::parse($customer->sale->installation_date)->format('Y-m-d')
                                                    }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Public IP:</th>
                                                <td>
                                                    @if ($customer->sale->public_ip)
                                                    {{ $customer->sale->public_ip }}
                                                    @else
                                                    NA
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="price">
                                                <th>Public IP Price:</th>
                                                <td>
                                                    @if ($customer->sale->ip_price)
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
                                                    @if ($customer->sale->additional_charge)
                                                    {{ $customer->sale->additional_charge }}
                                                    @else
                                                    NA
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="price">
                                                <th>Additional Charge Price:</th>
                                                <td>
                                                    @if ($customer->sale->additional_charge_price)
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
                                                    @if ($customer->sale->comment)
                                                    {{ $customer->sale->comment }}
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

                                <div class="media-29101 d-md-flex w-100">
                                    @if ($customer->active_status == 1)
                                    <table class="table table-striped table-dark">
                                        <tbody>
                                            <tr>
                                                <th>Installer:</th>
                                                <td>{{ $customer->noc->installer }}</td>
                                            </tr>
                                            <tr>
                                                <th>Activation Date:</th>
                                                <td>{{
                                                    Carbon\Carbon::parse($customer->noc->activation_date)->format('Y-m-d')
                                                    }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Cable Length:</th>
                                                <td>{{ $customer->noc->cable_length . ' Meter' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Receiver Mac:</th>
                                                <td>{{ $customer->noc->reciever_mac ? $customer->noc->reciever_mac :
                                                    'NA' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Latitude:</th>
                                                <td>{{ $customer->noc->latitiude ? $customer->noc->latitiude : 'NA' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Longitude:</th>
                                                <td>{{ $customer->noc->longitude ? $customer->noc->longitude : 'NA' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Additional Fee Reason:</th>
                                                <td>{{ $customer->noc->additional_fee }}</td>
                                            </tr>
                                            <tr>
                                                <th>Additional Fee Price:</th>
                                                <td>
                                                    {{ $customer->noc->additional_fee_price }}
                                                    {{ $customer->noc->additional_fee_currency }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Created At:</th>
                                                <td>{{ $customer->noc->created_at }}</td>
                                            </tr>
                                            <tr>
                                                <th>Created By:</th>
                                                <td>{{ $customer->noc->user->name }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    @else
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <h1>Customer is not active.</h1>
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                    @endif
                                </div> <!-- .item -->
                            </div>

                        </div> <!-- /card-body -->
                    </div> <!-- /card -->
                </div> <!-- /col-9 -->

                <div class="col-md-3">
                    @include('sales.customers.portion.sidebar')
                </div> <!-- /col-3 -->

            </div> <!-- /row -->
        </div>
    </div>

    <!-- The Modal -->
    <div class="modal" id="terminateModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <form method="post" id="formID" action="{{ route('customer.terminate', $customer->id) }}">
                    @csrf
                    @method('put')

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Terminate</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="terminate_date">Terminate Date:</label>
                            <input type="date" name="terminate_date" id="terminate_date" class="form-control"
                                required="required" />
                        </div>

                        <div class="form-group">
                            <label for="terminate_reason">Terminate Reason:</label>
                            <textarea class="form-control" name="terminate_reason" id="terminate_reason"
                                placeholder="Terminate Reason" rows="5" required="required"></textarea>
                        </div>

                    </div> <!-- /modal-body -->

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                </form>

            </div>
        </div>
    </div> <!-- // end of terminate modal -->

    <!-- The Modal -->
    <div class="modal" id="suspendModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <form method="post" action="{{ route('customer.suspend', $customer->id) }}">
                    @csrf
                    @method('put')

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Suspend</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="suspend_date">Suspend Date:</label>
                            <input type="date" name="suspend_date" class="form-control" id="suspend_date"
                                required="required" />
                        </div>

                        <div class="form-group">
                            <label for="suspend_reason">Suspend Reason:</label>
                            <textarea class="form-control" name="suspend_reason" id="suspend_reason"
                                placeholder="Suspend Reason" rows="5" required="required"></textarea>
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
    jQuery(document).ready(function() {

        });
</script>
@endsection