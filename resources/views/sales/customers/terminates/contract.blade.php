@extends('sales.layouts.app')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Re-Contraction</h4>
                
                <div class="history">

                    <div class="row">
                        <div class="col-sm-6">
                            {{ Breadcrumbs::render('salesCustomerContract',$customer) }}
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
                                    <a data-toggle="collapse" 
                                       href="#collapse-1" 
                                       aria-expanded="true" 
                                       aria-controls="collapse-1" class="collapse-icons">
                                           <i class="fas fa-filter"></i>
                                           <div class="badge badge-success">
                                                Additional Fields
                                            </div>
                                           <i class="more-less mdi mdi-plus"></i>
                                    </a>
                                </div>

                                <div id="collapse-1" class="collapse" 
                                     role="tabpanel" aria-labelledby="heading-1" 
                                     data-parent="#accordion-2">
                                    <div class="card-body">
                                        <div class="panel-body">
                                            
                                            <div class="row">
                                                
                                                <div class="col-md-3">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" 
                                                               type="checkbox" 
                                                               id="resellerCheckbox" 
                                                               value="">
                                                        <label class="form-check-label" 
                                                               for="resellerCheckbox">
                                                            Reseller input
                                                        </label>
                                                    </div> <!-- / reseller -->
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" 
                                                               type="checkbox" 
                                                               id="discountCheckbox" 
                                                               value="">
                                                        <label class="form-check-label" 
                                                               for="discountCheckbox">
                                                            Discount input
                                                        </label>
                                                    </div> <!-- / Discount -->
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" 
                                                               type="checkbox" 
                                                               id="ipCheckbox" 
                                                               value="">
                                                        <label class="form-check-label" 
                                                               for="ipCheckbox">
                                                            Public IP input
                                                        </label>
                                                    </div> <!-- / ip -->
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" 
                                                               type="checkbox" 
                                                               id="additionalCheckbox" 
                                                               value="">
                                                        <label class="form-check-label" 
                                                               for="additionalCheckbox">
                                                            Additional Charge input
                                                        </label>
                                                    </div> <!-- / additional Charge -->
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
                        
                        <form method="post" action="{{ route('customer.recontraction',$customer->id) }}">
                            @csrf
                            @method('put')
                            <h4 class="mt-0 header-title">Personal Info:</h4>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="id" class="required">ID:</label>
                                        <input type="text" 
                                               name="customer_id"
                                               class="form-control"
                                               placeholder="Customer ID"
                                               value="{{ $customer->customer_id }}" 
                                               id="id" 
                                               autocomplete="off" 
                                               required="required" 
                                            />
                                    </div>
                                </div> <!-- /col -->

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="full_name" class="required">Full Name:</label>
                                        <input type="text" 
                                               name="full_name"
                                               class="form-control"
                                               placeholder="Full Name"
                                               value="{{ $customer->full_name }}" 
                                               id="full_name" 
                                               autocomplete="off" 
                                               required="required"
                                            />
                                    </div>
                                </div> <!-- /col -->

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="full_name_persian" class="required">Full Name Persian:</label>
                                        <input type="text" 
                                               name="full_name_persian"
                                               class="form-control"
                                               placeholder="Full Name Persian"
                                               value="{{ $customer->full_name_persian }}" 
                                               id="full_name_persian" 
                                               autocomplete="off" 
                                               required="required"
                                            />
                                    </div>
                                </div> <!-- /col -->

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="poc" class="required">POC:</label>
                                        <input type="text" 
                                               name="poc"
                                               class="form-control"
                                               placeholder="POC"
                                               value="{{ $customer->poc }}" 
                                               id="poc" 
                                               autocomplete="off" 
                                               required="required"
                                            />
                                    </div>
                                </div> <!-- /col -->

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="poc_persian" class="required">POC Persian:</label>
                                        <input type="text" 
                                               name="poc_persian"
                                               class="form-control"
                                               placeholder="POC Persian"
                                               value="{{ $customer->poc_persian }}" 
                                               id="poc_persian" 
                                               autocomplete="off" 
                                               required="required"
                                            />
                                    </div>
                                </div> <!-- /col -->

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="phone1" class="required">Phone 1:</label>
                                        <input type="text" 
                                               name="phone1"
                                               class="form-control"
                                               placeholder="Phone 1"
                                               value="{{ $customer->phone1 }}" 
                                               id="phone1" 
                                               autocomplete="off" 
                                               required="required"
                                            />
                                    </div>
                                </div> <!-- /col -->

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="phone2" class="required">Phone 2:</label>
                                        <input type="text" 
                                               name="phone2"
                                               class="form-control"
                                               placeholder="Phone 2"
                                               value="{{ $customer->phone2 }}" 
                                               id="phone2" 
                                               autocomplete="off" 
                                               required="required"
                                            />
                                    </div>
                                </div> <!-- /col -->

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="education" class="required">Education:</label>
                                        <input type="text" 
                                               name="education"
                                               class="form-control"
                                               placeholder="Education"
                                               value="{{ $customer->education }}" 
                                               id="education" 
                                               autocomplete="off" 
                                               required="required"
                                            />
                                    </div>
                                </div> <!-- /col -->

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="identity_num" class="required">
                                            Identity Number:
                                        </label>
                                        <input type="text" 
                                               name="identity_num"
                                               class="form-control"
                                               placeholder="Identity Number:"
                                               value="{{ $customer->identity_num }}" 
                                               id="identity_num" 
                                               autocomplete="off" 
                                               required="required"
                                            />
                                    </div>
                                </div> <!-- /col -->

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="province" class="required">Province:</label>
                                        <select name="province" id="province" class="form-control">
                                            <option value="">Select Province</option>
                                            @foreach($provinces as $province)
                                                <option value="{{ $province->name }}" {{ $customer->province == $province->name ? 'selected' : ''}}>{{ province($province->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> <!-- /col-->

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="branch_id" class="required">Branch:</label>
                                        <select name="branch_id" 
                                                class="form-control"
                                                id="branch_id" required="required">
                                            <option value="">Select Branch</option>
                                            @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}"
                                                    {{ $customer->branch_id == $branch->id ? 'selected' : '' }}>
                                                    {{ $branch->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> <!-- /col-->

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="address" class="required">
                                            Address:
                                        </label>
                                        <textarea class="form-control"
                                                  name="address" 
                                                  id="address" 
                                                  placeholder="Address"
                                                  required="required">{{ $customer->address }}</textarea>
                                    </div>
                                </div> <!-- /col -->
                            </div> <!-- /row -->

                            <h4 class="mt-3 header-title">Package and Device:</h4>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="package" class="required">Package:</label>
                                        <input type="text" 
                                               name="package" 
                                               id="package"  
                                               class="form-control" 
                                               autocomplete="off" 
                                               value="{{ $customer->sale->package ? $customer->sale->package->name : '' }}" 
                                               placeholder="Package Name:" 
                                               required="required"
                                            />
                                        <ul id="packages_list"></ul>
                                        <input type="hidden" 
                                              name="package_id" 
                                              id="package_id"
                                              value="{{ $customer->sale->package_id }}" 
                                            />
                                    </div>
                                </div> <!-- /col -->

                                <div class="col-md-3">
                                    <div class="input-group">
                                        <label for="package_price" class="required">
                                               Package Price:
                                        </label>
                                        <input type="number" 
                                               name="package_price"
                                               id="package_price"
                                               class="form-control"
                                               value="{{ $customer->sale->package_price }}" 
                                               required="required" 
                                               autocomplete="off" 
                                            />

                                        <input type="hidden"
                                               name="package_price_hidden" 
                                               id="package_price_hidden" 
                                               value="{{ $customer->sale->package_price }}"
                                               />   

                                        <div class="input-group-append">
                                            <select class="form-control" name="package_price_currency">
                                                <option value="AFG" {{ $customer->sale-> 
                                                package_price_currency == 'AFG' ? 'selected' : '' }}>
                                                    AFG
                                                </option>
                                                <option value="Dollar" {{ $customer->sale-> 
                                                package_price_currency == 'Dollar' ? 'selected' : '' }}>
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
                                        <input type="text" 
                                               name="commission" 
                                               id="commission"
                                               autocomplete="off" 
                                               class="form-control" 
                                               value="{{ $customer->sale->commission ? $customer->sale->commission->name : '' }}"
                                            />
                                        <ul id="commission_list"></ul>
                                        <input type="hidden" 
                                              name="commission_id" 
                                              id="commission_id"
                                              value="{{ $customer->sale->commission ? $customer->sale->commission->id : '' }}"  
                                            />
                                    </div>
                                </div> <!-- /col -->

                                <div class="col-md-3">
                                    <div class="input-group">
                                        <label for="commission_percent">
                                            Reseller Percent:
                                        </label>
                                        <input type="number"
                                                name="commission_percent"
                                                id="commission_percent"
                                                class="form-control"
                                                autocomplete="off"
                                                value="{{ $customer->sale->commission_percent }}" />
                                    </div>
                                </div> <!-- /col -->

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="equi_type" class="required">
                                            Equipment Possession:
                                        </label>
                                        <select class="form-control" 
                                                name="equi_type" 
                                                id="equi_type" required="required">
                                            <option value="">Select Type:</option>
                                            <option value="sell" {{ $customer->sale->equi_type == 'sell' ? 'selected' : '' }}>
                                                Sell
                                            </option>
                                            <option value="leased" {{ $customer->sale->equi_type == 'leased' ? 'selected' : '' }}>
                                                Leased
                                            </option>
                                            <option value="own" {{ $customer->sale->equi_type == 'own' ? 'selected' : '' }}>
                                                Own
                                            </option>
                                        </select>
                                    </div>
                                </div> <!-- /col -->

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="leased_type">
                                            Leased Type:
                                        </label>
                                        <select class="form-control" name="leased_type" 
                                                id="leased_type">
                                            <option value="">Select Leased:</option>
                                            <option value="full" {{ $customer->sale->leased_type == 'full' ? 'selected' : '' }}>
                                                Full
                                            </option>
                                            <option value="guarantee" {{ $customer->sale->leased_type == 'guarantee' ? 'selected' : '' }}>
                                                Guarantee
                                            </option>
                                        </select>
                                    </div>
                                </div> <!-- /col -->

                                <div class="col-md-3">
                                    <div class="input-group">
                                        <label for="discount">Discount:</label>
                                        <input type="number"
                                               name="discount"
                                               id="discount" 
                                               placeholder="Discount:" 
                                               value="{{ $customer->sale->discount }}" 
                                               class="form-control" 
                                            />
                                        <div class="input-group-append">
                                            <select class="form-control" name="discount_currency">
                                                <option value="AFG" {{ $customer->sale->discount_currency == 'AFG' ? 'selected' : '' }}>
                                                    AFG
                                                </option>
                                                <option value="Dollar" {{ $customer->sale->discount_currency == 'Dollar' ? 'selected' : '' }}>
                                                    Dollar
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div> <!-- /col -->

                                <div class="col-md-3">
                                    <div class="input-group">
                                        <label for="discount_period">Discount Period:</label>
                                        <input type="number"
                                           name="discount_period"
                                           id="discount_period" 
                                           placeholder="Discount Period:" 
                                           class="form-control"
                                           value="{{ $customer->sale->discount_period }}" 
                                        />
                                        <div class="input-group-append">
                                            <select class="form-control" name="discount_period_currency" id="discount_period_currency">
                                                <option value="Days" {{ $customer->sale->discount_period_currency == 'Days' ? 'selected' : '' }}>
                                                    Days
                                                </option>
                                                <option value="Months" {{ $customer->sale->discount_period_currency == 'Months' ? 'selected' : '' }}>
                                                    Months
                                                </option>
                                                <option value="Package" {{ $customer->sale->discount_period_currency == 'Package' ? 'selected' : '' }}>
                                                    Package
                                                </option>
                                                <option value="Permanent" {{ $customer->sale->discount_period_currency == 'Permanent' ? 'selected' : '' }}>
                                                    Permanent
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div> <!-- /col -->

                                <div class="col-md-3">
                                    <div class="input-group">
                                        <label for="discount_reason">Discount Reason:</label>
                                        <input type="text"
                                           name="discount_reason"
                                           id="discount_reason" 
                                           placeholder="Discount Reason:" 
                                           class="form-control"
                                           value="{{ $customer->sale->discount_reason }}" 
                                        />
                                    </div>
                                </div> <!-- /col -->

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="receiver_type" class="required">
                                            Receiver Type:
                                        </label>
                                        <input type="text" 
                                               name="receiver_type"
                                               id="receiver_type"
                                               class="form-control"
                                               placeholder="Receiver Type:"
                                               value="{{ $customer->sale->receiver_type }}"  
                                               autocomplete="off" 
                                               required="required"
                                               />
                                        <ul id="receiver_type_list"></ul>
                                        <input type="hidden" 
                                               name="receiver_type_id"
                                               id="receiver_type_id" 
                                               value="{{ $customer->sale->receiver_type }}">
                                    </div>
                                </div> <!-- /col -->

                                <div class="col-md-3">
                                    <div class="input-group">
                                        <label for="receiver_price">
                                            Receiver Price:
                                        </label>
                                        <input type="number" 
                                               name="receiver_price"
                                               id="receiver_price"
                                               class="form-control"
                                               placeholder="Receiver Price:"
                                               value="{{ $customer->sale->receiver_price }}"
                                               autocomplete="off" 
                                               />
                                        <div class="input-group-append">
                                            <select class="form-control" name="receiver_price_currency">
                                                <option value="AFG" {{ $customer->sale->receiver_price_currency == 'AFG' ? 'selected' : '' }}>
                                                    AFG
                                                </option>
                                                <option value="Dollar" {{ $customer->sale->receiver_price_currency == 'Dollar' ? 'selected' : '' }}>
                                                    Dollar
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div> <!-- /col -->

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="router_type">
                                            Router Type:
                                        </label>
                                        <input type="text" 
                                               name="router_type"
                                               id="router_type"
                                               class="form-control"
                                               autocomplete="off" 
                                               placeholder="Router Type:"
                                               value="{{ $customer->sale->router_type }}"
                                               />
                                        <ul id="router_type_list"></ul>
                                        <input type="hidden"
                                               name="router_type_id"
                                               id="router_type_id" 
                                               value="{{ $customer->sale->router_type }}">
                                    </div>
                                </div> <!-- /col -->

                                <div class="col-md-3">
                                    <div class="input-group">
                                        <label for="router_price">
                                            Router Price:
                                        </label>
                                        <input type="number" 
                                               name="router_price"
                                               id="router_price"
                                               class="form-control"
                                               placeholder="Router Price:" 
                                               value="{{ $customer->sale->router_price }}"
                                               autocomplete="off" 
                                               />
                                        <div class="input-group-append">
                                            <select class="form-control" name="router_price_currency">
                                                <option value="AFG" {{ $customer->sale->router_price_currency == 'AFG' ? 'selected' : '' }}>
                                                    AFG
                                                </option>
                                                <option value="Dollar" {{ $customer->sale->router_price_currency == 'Dollar' ? 'selected' : '' }}>
                                                    Dollar
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div> <!-- /col -->

                                <div class="col-md-3">
                                    <div class="input-group">
                                        <label for="cable_price" class="required">
                                            Cable Price:
                                        </label>
                                        <input type="number" 
                                               name="cable_price"
                                               class="form-control"
                                               id="cable_price"
                                               placeholder="Cable Price:"
                                               value="{{ $customer->sale->cable_price }}" 
                                               autocomplete="off" 
                                               required="required" 
                                            />
                                        <div class="input-group-append">
                                            <select class="form-control" name="cable_price_currency">
                                                <option value="AFG" {{ $customer->sale->cable_price_currency == 'AFG' ? 'selected' : '' }}>
                                                    AFG
                                                </option>
                                                <option value="Dollar" {{ $customer->sale->cable_price_currency == 'Dollar' ? 'selected' : '' }}>
                                                    Dollar
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div> <!-- /col -->

                                <div class="col-md-3">
                                    <div class="input-group">
                                        <label for="Installation_cost">
                                            Installation Cost:
                                        </label>
                                        <input type="number" 
                                               name="Installation_cost"
                                               id="Installation_cost"
                                               class="form-control"
                                               placeholder="Installation Cost:" 
                                               autocomplete="off"
                                               value="{{ $customer->sale->Installation_cost }}" 
                                               />
                                        <div class="input-group-append">
                                            <select class="form-control" name="Installation_cost_currency">
                                                <option value="AFG" {{ $customer->sale->Installation_cost_currency == 'AFG' ? 'selected' : '' }}>
                                                    AFG
                                                </option>
                                                <option value="Dollar" {{ $customer->sale->Installation_cost_currency == 'Dollar' ? 'selected' : '' }}>
                                                    Dollar
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div> <!-- /col -->

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="recontract_date" class="required">
                                            Recontraction Date: 
                                        </label>
                                        <input type="date" 
                                               name="recontract_date"
                                               id="recontract_date"
                                               class="form-control"
                                               placeholder="Recontraction Date:" 
                                               value="" 
                                               required="required" 
                                               />
                                    </div>
                                </div> <!-- /col -->

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="public_ip">
                                            Public IP:
                                        </label>
                                        <input type="text" 
                                               name="public_ip"
                                               id="public_ip"
                                               class="form-control"
                                               placeholder="Public IP:" 
                                               autocomplete="off"
                                               value="{{ $customer->sale->public_ip }}"  
                                               />
                                    </div>
                                </div> <!-- /col -->

                                <div class="col-md-3">
                                    <div class="input-group">
                                        <label for="ip_price">
                                            Public IP Price:
                                        </label>
                                        <input type="number" 
                                               name="ip_price"
                                               id="ip_price"
                                               class="form-control"
                                               placeholder="Public IP Price:" 
                                               autocomplete="off"
                                               value="{{ $customer->sale->ip_price }}" 
                                               />
                                        <div class="input-group-append">
                                            <select class="form-control" name="ip_price_currency">
                                                <option value="AFG" {{ $customer->sale->ip_price_currency == 'AFG' ? 'selected' : '' }}>
                                                    AFG
                                                </option>
                                                <option value="Dollar" {{ $customer->sale->ip_price_currency == 'Dollar' ? 'selected' : '' }}>
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
                                        <input type="text" 
                                               name="additional_charge"
                                               id="additional_charge"
                                               class="form-control"
                                               placeholder="Additional Charge Reason:" 
                                               value="{{ $customer->sale->additional_charge }}"
                                               />
                                    </div>
                                </div> <!-- /col -->

                                <div class="col-md-3">
                                    <div class="input-group">
                                        <label for="additional_charge_price">
                                            Additional Charge Price:
                                        </label>
                                        <input type="number" 
                                               name="additional_charge_price"
                                               id="additional_charge_price"
                                               class="form-control"
                                               placeholder="Additional Charge Price:"
                                               value="{{ $customer->sale->additional_charge_price }}" 
                                               />
                                        <div class="input-group-append">
                                           <select class="form-control" name="additional_currency">
                                                <option value="AFG" {{ $customer->sale->additional_currency == 'AFG' ? 'selected' : '' }}>
                                                    AFG
                                                </option>
                                                <option value="Dollar" {{ $customer->sale->additional_currency == 'Dollar' ? 'selected' : '' }}>
                                                    Dollar
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div> <!-- /col -->

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="comment">
                                            Comment:
                                        </label>
                                        <textarea name="comment" class="form-control" id="comment"
                                        placeholder="Comment:">{{ $customer->sale->comment }}</textarea>
                                    </div>
                                </div> <!-- /col -->
                            </div> <!-- /row -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>

                        </form>

                     </div> <!--/card-body -->
                </div> <!-- /card -->
            </div>
        </div>
        <div class="clearfix"></div>
    </div> <!-- /end of page content -->
@endsection

@section('style')
  <style>
    .card-footer{
        text-align: right;
    }
    .card-footer a{
        color: #fff;
    }
  </style>
@endsection

@section('script')
<script type="text/javascript">
   jQuery(document).ready(function(){

   });
</script>
@endsection