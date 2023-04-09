@extends('sales.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Edit Customer</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('sales.provincial.edit',$customer) }}
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
    <div class="col-md-12">
        <div class="page-content-box">

            <div class="card">
                <div class="filter-area">

                    <div id="accordion-2" role="tablist">

                        <div class="card shadow-none mb-0">
                            <div class="card-header" role="tab" id="heading-1">
                                <a data-toggle="collapse" href="#collapse-1" aria-expanded="true"
                                    aria-controls="collapse-1" class="collapse-icons">
                                    <i class="fas fa-filter"></i>
                                    <div class="badge badge-success">
                                        Additional Fields
                                    </div>
                                    <i class="more-less mdi mdi-plus"></i>
                                </a>
                            </div>

                            <div id="collapse-1" class="collapse resellersCard" role="tabpanel"
                                aria-labelledby="heading-1" data-parent="#accordion-2">
                                <div class="card-body">
                                    <div class="panel-body">

                                        <div class="row">

                                            <div class="col-md-4">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="additionalCheckbox" value="">
                                                    <label class="form-check-label" for="additionalCheckbox">
                                                        Additional Charge input
                                                    </label>
                                                </div> <!-- / additional Charge -->
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="ipCheckbox"
                                                        value="">
                                                    <label class="form-check-label" for="ipCheckbox">
                                                        Public IP input
                                                    </label>
                                                </div> <!-- / ip -->
                                            </div>

                                        </div> <!-- /inner-row -->

                                    </div>
                                </div>
                            </div>
                        </div> <!-- /card -->

                    </div> <!-- // accoridan -->

                </div> <!-- /filter-area -->
            </div> <!-- /filter-card -->

        </div> <!-- /content-box -->
    </div> <!-- /col -->
</div> <!-- /row -->

<div class="row">
    <div class="col-sm-12">
        <div class="page-content-box">
            <div class="card">
                <div class="card-body">

                    <form method="post" action="{{ route('provincial.update',$customer->id) }}">
                        @csrf
                        @method('put')
                        <h4 class="mt-0 header-title">Personal Info:</h4>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="id" class="required">ID:</label>
                                    <input type="text" name="customer_id" class="form-control"
                                        value="{{ $customer->customer_id }}" id="id" autocomplete="off"
                                        required="required" />
                                </div>
                            </div> <!-- /col -->

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="full_name" class="required">Full Name:</label>
                                    <input type="text" name="full_name" class="form-control"
                                        value="{{ $customer->full_name }}" id="full_name" autocomplete="off"
                                        required="required" />
                                </div>
                            </div> <!-- /col -->

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="full_name_persian" class="required">Full Name Persian:</label>
                                    <input type="text" name="full_name_persian" class="form-control"
                                        placeholder="Full Name Persian" id="full_name_persian"
                                        value="{{ $customer->full_name_persian }}" autocomplete="off"
                                        required="required" />
                                </div>
                            </div> <!-- /col -->

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="poc" class="required">POC:</label>
                                    <input type="text" name="poc" class="form-control" value="{{ $customer->poc }}"
                                        id="poc" autocomplete="off" required="required" />
                                </div>
                            </div> <!-- /col -->

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="poc_persian" class="required">POC Persian:</label>
                                    <input type="text" name="poc_persian" class="form-control" placeholder="POC Persian"
                                        value="{{ $customer->poc_persian }}" id="poc_persian" autocomplete="off"
                                        required="required" />
                                </div>
                            </div> <!-- /col -->

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="phone1" class="required">Phone 1:</label>
                                    <input type="text" name="phone1" class="form-control"
                                        value="{{ $customer->phone1 }}" id="phone1" autocomplete="off"
                                        required="required" />
                                </div>
                            </div> <!-- /col -->

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="phone2" class="required">Phone 2:</label>
                                    <input type="text" name="phone2" class="form-control"
                                        value="{{ $customer->phone2 }}" id="phone2" autocomplete="off"
                                        required="required" />
                                </div>
                            </div> <!-- /col -->

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="province" class="required">Province:</label>
                                    <select name="province" id="province" class="form-control">
                                        <option value="">Select Province</option>
                                        @foreach($provinces as $province)
                                        <option value="{{ $province->name }}" {{ $customer->province == $province->name
                                            ? 'selected' : ''}}>{{ province($province->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> <!-- /col-->

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="branch_id" class="required">Branch:</label>
                                    <select name="branch_id" class="form-control" id="branch_id" required="required">
                                        <option value="">Select Branch</option>
                                        @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ $customer->branch_id == $branch->id ?
                                            'selected' : '' }}>
                                            {{ $branch->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> <!-- /col-->

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="customerProvince" class="required">Customer Province:</label>
                                    <select name="customerProvince" id="customerProvince" class="form-control">
                                        <option value="">Select Province</option>
                                        @foreach($provinces as $province)
                                        <option value="{{ $province->name }}" {{ $customer->customerProvince ==
                                            $province->name ? 'selected' : ''}}>{{ province($province->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> <!-- /col-->

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="address" class="required">
                                        Address:
                                    </label>
                                    <textarea class="form-control" name="address" id="address"
                                        required="required">{{ $customer->address }}</textarea>
                                </div>
                            </div> <!-- /col -->
                        </div> <!-- /row -->

                        <h4 class="mt-3 header-title">Package and Device:</h4>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="package" class="required">Package:</label>
                                    <input type="text" name="package" id="package" class="form-control"
                                        autocomplete="off"
                                        value="{{ $customer->package ? $customer->package->name : '' }}"
                                        placeholder="Package Name:" required="required" />
                                    <ul id="packages_list"></ul>
                                    <input type="hidden" name="package_id" id="package_id"
                                        value="{{ $customer->package_id }}" />
                                </div>
                            </div> <!-- /col -->

                            <div class="col-md-3">
                                <div class="input-group">
                                    <label for="package_price" class="required">Package Price:</label>
                                    <input type="number" name="package_price" id="package_price" class="form-control"
                                        autocomplete="off" value="{{ $customer->package_price }}" required="required" />

                                    <div class="input-group-append">
                                        <select class="form-control" name="package_price_currency"
                                            id="package_price_currency">
                                            <option value="AFG" {{ $customer->package_price_currency == 'AFG' ?
                                                'selected' : '' }}>
                                                AFG
                                            </option>
                                            <option value="Dollar" {{ $customer->package_price_currency == 'Dollar' ?
                                                'selected' : '' }}>
                                                Dollar
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div> <!-- /col -->

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="additional_charge">
                                        Additional Charge:
                                    </label>
                                    <input type="text" name="additional_charge" id="additional_charge"
                                        class="form-control" placeholder="Additional Charge Reason:"
                                        value="{{ $customer->additional_charge }}" />
                                </div>
                            </div> <!-- /col -->

                            <div class="col-md-3">
                                <div class="input-group">
                                    <label for="additional_charge_price">
                                        Additional Charge Price:
                                    </label>
                                    <input type="number" name="additional_charge_price" id="additional_charge_price"
                                        class="form-control" placeholder="Additional Charge Price:"
                                        value="{{ $customer->additional_charge_price }}" />
                                    <div class="input-group-append">
                                        <select class="form-control" name="additional_currency">
                                            <option value="AFG" {{ $customer->additional_currency == 'AFG' ? 'selected'
                                                : '' }}>
                                                AFG
                                            </option>
                                            <option value="Dollar" {{ $customer->additional_currency == 'Dollar' ?
                                                'selected' : '' }}>
                                                Dollar
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div> <!-- /col -->

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="commission">
                                        Reseller:
                                    </label>
                                    <input type="text" name="commission" id="commission" autocomplete="off"
                                        class="form-control"
                                        value="{{ $customer->commission ? $customer->commission->name : '' }}" />
                                    <ul id="commission_list"></ul>
                                    <input type="hidden" name="commission_id" id="commission_id"
                                        value="{{ $customer->commission ? $customer->commission->id : '' }}" />
                                </div>
                            </div> <!-- /col -->

                            <div class="col-md-3">
                                <div class="input-group">
                                    <label for="commission_percent" class="required">
                                        Reseller Percent:
                                    </label>
                                    <input type="number" name="commission_percent" id="commission_percent"
                                        class="form-control" autocomplete="off"
                                        value="{{ $customer->commission_percent }}" required="required" />
                                </div>
                            </div> <!-- /col -->

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="marketer">
                                        Field Officer:
                                    </label>
                                    <input type="text" name="marketer" id="marketer" autocomplete="off"
                                        class="form-control"
                                        value="{{ $customer->marketer ? $customer->marketer->name : '' }}" />
                                    <ul id="marketers_list"></ul>
                                    <input type="hidden" name="marketer_id" id="marketer_id"
                                        value="{{ $customer->marketer ? $customer->marketer->id : '' }}" />
                                </div>
                            </div> <!-- /col -->


                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="service" class="required">Service Type:</label>
                                    <select class="form-control" name="service" id="service" required>
                                        <option value="">Service Type:</option>
                                        <option value="VSAT" {{ $customer->service=="VSAT" ? "selected" : "" }}>
                                            VSAT
                                        </option>
                                        <option value="Wireless" {{ $customer->service=="Wireless" ?"selected" : "" }}>
                                            Wireless
                                        </option>
                                        <option value="Microwave" {{ $customer->service=="Microwave" ? "selected" : ""
                                            }}>
                                            Microwave
                                        </option>
                                    </select>
                                </div>
                            </div> <!-- /col -->

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="provider" class="required">Provider</label>
                                    <input type="text" name="provider" id="provider" autocomplete="off"
                                        class="form-control" placeholder="Provider Name:"
                                        value="{{ $customer->provider ? $customer->provider->name : '' }}" />
                                    <ul id="providers_list"></ul>
                                    <input type="hidden" name="provider_id" id="provider_id"
                                        value="{{ $customer->provider ? $customer->provider->id : '' }}" />
                                </div>
                            </div> <!-- /col -->

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="installation_date" class="required">
                                        Installation Date:
                                    </label>
                                    <input type="date" name="installation_date" id="installation_date"
                                        class="form-control"
                                        value="{{ Carbon\Carbon::parse($customer->installation_date)->format('Y-m-d') }}"
                                        required="required" />
                                </div>
                            </div> <!-- /col -->

                            <div class="col-md-3">
                                <div class="input-group">
                                    <label for="installation_cost">
                                        Installation Cost:
                                    </label>
                                    <input type="number" name="installation_cost" id="installation_cost"
                                        class="form-control" value="{{ $customer->installation_cost }}" />
                                    <div class="input-group-append">
                                        <select class="form-control" name="Installation_cost_currency">
                                            <option value="AFG" {{ $customer->Installation_cost_currency == 'AFG'
                                                ? 'selected' : '' }}>
                                                AFG
                                            </option>
                                            <option value="Dollar" {{ $customer->Installation_cost_currency =='Dollar'
                                                ? 'selected' : '' }}>
                                                Dollar
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div> <!-- /col -->

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="public_ip">
                                        Public IP:
                                    </label>
                                    <input type="text" name="public_ip" id="public_ip" autocomplete="off"
                                        class="form-control" value="{{ $customer->public_ip }}" />
                                </div>
                            </div> <!-- /col -->

                            <div class="col-md-3">
                                <div class="input-group">
                                    <label for="ip_price">
                                        Public IP Price:
                                    </label>
                                    <input type="number" name="ip_price" id="ip_price" class="form-control"
                                        value="{{ $customer->ip_price }}" />
                                    <div class="input-group-append">
                                        <select class="form-control" name="ip_price_currency">
                                            <option value="AFG" {{ $customer->ip_price_currency == 'AFG'
                                                ? 'selected' : '' }}>
                                                AFG
                                            </option>
                                            <option value="Dollar" {{ $customer->ip_price_currency =='Dollar'
                                                ? 'selected' : '' }}>
                                                Dollar
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div> <!-- /col -->

                            <div class="col-md-3">
                                <div class="input-group">
                                    <label for="ip_price">
                                        Demo Days:
                                    </label>
                                    <input type="number" name="demo_days" id="demo_days" class="form-control"
                                        placeholder="Demo Days" value="{{$customer->demo_days}}" />
                                </div>
                            </div> <!-- /col -->

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="comment">
                                        Comment:
                                    </label>
                                    <textarea name="comment" class="form-control"
                                        id="comment">{{ $customer->comment }}</textarea>
                                </div>
                            </div> <!-- /col -->
                        </div> <!-- /row -->

                        <div class="card-footer">
                            <button type="reset" class="btn btn-secondary">
                                Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Submit
                            </button>
                        </div>

                    </form>

                </div>
                <!--/card-body -->
            </div> <!-- /card -->
        </div>
    </div>
    <div class="clearfix"></div>
</div> <!-- /end of page content -->
@endsection

@section('style')
<style>
    .card-footer {
        text-align: right;
    }

    .card-footer a {
        color: #fff;
    }

    #marketers_list,
    #commission_list,
    #packages_list,
    #providers_list {
        padding: 0;
        position: absolute;
        z-index: 100;
    }

    #commission_list,
    #packages_list,
    #providers_list,
    #marketers_list {
        width: 95%
    }

    #marketers_list li,
    #commission_list li,
    #packages_list li,
    #providers_list li {
        background-color: #e6eff7
    }

    #marketers_list li:hover,
    #commission_list li:hover,
    #packages_list li:hover,
    #providers_list li:hover {
        cursor: pointer;
    }
</style>
@endsection

@section('script')
<script type="text/javascript">
    jQuery(document).ready(function(){


   });
</script>
@endsection