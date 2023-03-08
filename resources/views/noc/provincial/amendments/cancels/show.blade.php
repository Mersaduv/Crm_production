@extends('noc.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Canceled Amendment</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('noc.pr.amend',$amend->provincial) }}
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
                                <a href="#" class="col active">Amendment Details</a>
                                <a href="#" class="col">Cancel Details</a>
                            </div>

                            <div class="owl-carousel owl-1">

                                <div class="media-29101 d-md-flex w-100">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <th>Customer ID:</th>
                                                <td>
                                                    {{ $amend->customer_id }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Full Name:</th>
                                                <td>{{ $amend->full_name }}</td>
                                            </tr>
                                            <tr>
                                                <th>POC:</th>
                                                <td>{{ $amend->poc }}</td>
                                            </tr>
                                            <tr>
                                                <th>Address:</th>
                                                <td>{{ $amend->address }}</td>
                                            </tr>
                                            <tr>
                                                <th>Province:</th>
                                                <td>{{ province($amend->province) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Customer Province:</th>
                                                <td>{{ province($amend->customerProvince) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Package:</th>
                                                <td>
                                                    @if($amend->package_id)
                                                    {{ package($amend->package_id) }}
                                                    @else
                                                    NA
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="price">
                                                <th>Package Price:</th>
                                                <td>
                                                    @if($amend->package_price)
                                                    <span>
                                                        {{ $amend->package_price }}
                                                    </span>
                                                    <span>
                                                        {{ $amend->package_price_currency }}
                                                    </span>
                                                    @else
                                                    NA
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Reseller Name</th>
                                                <td>
                                                    @if($amend->commission_id)
                                                    {{ reseller($amend->commission_id) }}
                                                    @else
                                                    NA
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Reseller Percentage</th>
                                                <td>
                                                    <span>
                                                        {{ $amend->commission_percent ."%" }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Field Officer</th>
                                                <td>
                                                    @if($amend->marketer_id)
                                                    {{ marketer($amend->marketer_id) }}
                                                    @else
                                                    NA
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Service</th>
                                                <td>{{ $amend->service }}</td>
                                            </tr>
                                            <tr>
                                                <th>Provider</th>
                                                <td>{{ $amend->provider }}</td>
                                            </tr>
                                            <tr>
                                                <th>Public IP:</th>
                                                <td>
                                                    @if($amend->public_ip)
                                                    {{ $amend->public_ip }}
                                                    @else
                                                    NA
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="price">
                                                <th>Public IP Price:</th>
                                                <td>
                                                    @if($amend->ip_price)
                                                    <span>
                                                        {{ $amend->ip_price }}
                                                    </span>
                                                    <span>
                                                        {{ $amend->ip_price_currency }}
                                                    </span>
                                                    @else
                                                    NA
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Additional Charge:</th>
                                                <td>
                                                    @if($amend->additional_charge)
                                                    {{ $amend->additional_charge }}
                                                    @else
                                                    NA
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="price">
                                                <th>Additional Charge Price:</th>
                                                <td>
                                                    @if($amend->additional_charge_price)
                                                    <span>
                                                        {{ $amend->additional_charge_price }}
                                                    </span>
                                                    <span>
                                                        {{ $amend->additional_currency }}
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
                                    </table>
                                </div> <!-- .item -->

                                <div class="media-29101  w-100">
                                    <table class="table table-striped table-dark">
                                        <tbody>
                                            <tr>
                                                <th>Amendment Date</th>
                                                <td>
                                                    {{ $amend->amend->amend_date }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Cancel Date</th>
                                                <td>
                                                    {{ $amend->cancel_date }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Amendment Comment</th>
                                                <td>{{ $amend->amend->amend_comment }}</td>
                                            </tr>
                                            <tr>
                                                <th>Cancel Reason</th>
                                                <td>
                                                    {{ $amend->cancel_reason }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Amendment By</th>
                                                <td>{{ $amend->amend->user->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Cancel By</th>
                                                <td>{{ $amend->user->name }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div> <!-- .item -->

                            </div>

                        </div> <!-- /card-body -->
                    </div> <!-- /card -->
                </div> <!-- /col-9 -->

                <div class="col-md-3">
                    @include('noc.provincial.amendments.cancels.sidebar')
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
               url:"{{ route('prAmend.cancel.confirm') }}",
               method:'post',
               data:{
                    "_token": "{{ csrf_token() }}",
                    id:"{{ $amend->id }}",
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