<div class="card customer_operation">

    <div class="card-header">
        <h1 class="text-center">Operation</h1>
    </div> <!-- /card-header -->

    <div class="card-body">

        <button class="btn-primary btn">
            <a href="{{ route('pr.finance.files',$customer->id) }}">
                Attachments
            </a>
        </button>

        <!-- Confirm the customer payment -->
        @can('update', ProvincialPaymentFullyQualifiedNameSpace())
        @if($customer->finance_status == 0)
        <button class="btn btn-info" type="button" data-toggle="modal" data-target="#paymentModal">
            Add Payment
        </button>
        @endif
        @endcan

        <!-- Update the customer payment -->
        @can('update', ProvincialPaymentFullyQualifiedNameSpace())
        @if($customer->finance_status == 1)
        <button class="btn btn-info" type="button" data-toggle="modal" data-target="#updatePaymentModal">
            Update Payment
        </button>
        @endif
        @endcan


        <!-- Suspend the customer when it is active -->
        @can('update', ProvincialPaymentFullyQualifiedNameSpace())
        @if($customer->active_status ==1)
        <button class="btn btn-success" type="button" data-toggle="modal" data-target="#suspendModal">
            Suspend
        </button>
        @endif
        @endcan


    </div> <!-- /card-body -->
</div> <!-- /card -->

<!-- The Modal -->
<div class="modal" id="suspendModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="post" action="{{ route('pr.fin.suspend.process',$customer->id) }}">
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

<div class="modal fade" id="paymentModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="post" action="{{ route('prc.update',$customer->id) }}">
                @csrf
                @method('put')

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Payment</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">

                    <div class="form-group">
                        <div class="input-group">
                            <label for="package_price">Package Price:</label>
                            <input type="number" name="package_price" id="package_price" class="form-control"
                                autocomplete="off" value="{{ $customer->package_price }}" required="required" />
                            <div class="input-group-append">
                                <select class="form-control" name="package_price_currency">
                                    <option value="AFG" {{ $customer->package_price_currency == 'AFG' ? 'selected' : ''
                                        }}>
                                        AFG
                                    </option>
                                    <option value="Dollar" {{ $customer->package_price_currency == 'Dollar' ? 'selected'
                                        : '' }}>
                                        Dollar
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <label for="installation_cost">
                                Installation Cost:
                            </label>
                            <input type="number" name="installation_cost" id="installation_cost" class="form-control"
                                value="{{ $customer->installation_cost }}" />
                            <div class="input-group-append">
                                <select class="form-control" name="Installation_cost_currency">
                                    <option value="AFG" {{ $customer->Installation_cost_currency == 'AFG' ? 'selected' :
                                        '' }}>
                                        AFG
                                    </option>
                                    <option value="Dollar" {{ $customer->Installation_cost_currency =='Dollar' ?
                                        'selected' : '' }}>
                                        Dollar
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <label for="ip_price">
                                Public IP Price:
                            </label>
                            <input type="number" name="ip_price" id="ip_price" class="form-control"
                                value="{{ $customer->ip_price ? $customer->ip_price : '0'  }}" />
                            <div class="input-group-append">
                                <select class="form-control" name="ip_price_currency">
                                    <option value="AFG" {{ $customer->ip_price_currency == 'AFG' ? 'selected' : '' }}>
                                        AFG
                                    </option>
                                    <option value="Dollar" {{ $customer->ip_price_currency =='Dollar' ? 'selected' : ''
                                        }}>
                                        Dollar
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <label for="additional_charge">
                                Additional Charge Price:
                            </label>
                            <input type="number" name="additional_charge" id="additional_charge" class="form-control"
                                value="{{ $customer->additional_charge_price ? $customer->additional_charge_price : '0'  }}" />
                            <div class="input-group-append">
                                <select class="form-control" name="additional_currency">
                                    <option value="AFG" {{ $customer->additional_currency == 'AFG' ? 'selected' : '' }}>
                                        AFG
                                    </option>
                                    <option value="Dollar" {{ $customer->additional_currency =='Dollar' ? 'selected' :
                                        '' }}>
                                        Dollar
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div> <!-- /modal-body -->

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

            </form>

        </div>
    </div>
</div> <!-- // end of Payment modal -->

@if($payment)
<div class="modal fade" id="updatePaymentModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="post" action="{{ route('prc.update',$customer->id) }}">
                @csrf
                @method('put')

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Update Payment</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">

                    <div class="form-group">
                        <div class="input-group">
                            <label for="package_price">
                                Package Price: ({{$customer->package_price}} {{$customer->package_price_currency}})
                            </label>
                            <input type="number" name="package_price" id="package_price" class="form-control"
                                autocomplete="off" value="{{ $payment->package_price }}" required="required" />
                            <div class="input-group-append">
                                <select class="form-control" name="package_price_currency">
                                    <option value="AFG" {{ $payment->package_price_currency == 'AFG' ? 'selected' : ''
                                        }}>
                                        AFG
                                    </option>
                                    <option value="Dollar" {{ $payment->package_price_currency == 'Dollar' ? 'selected'
                                        : '' }}>
                                        Dollar
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <label for="installation_cost">
                                Installation Cost: ({{$customer->installation_cost}}
                                {{$customer->Installation_cost_currency}})
                            </label>
                            <input type="number" name="installation_cost" id="installation_cost" class="form-control"
                                value="{{ $payment->installation_cost ? $payment->installation_cost : '0'  }}" />
                            <div class="input-group-append">
                                <select class="form-control" name="Installation_cost_currency">
                                    <option value="AFG" {{ $payment->Installation_cost_currency == 'AFG' ? 'selected' :
                                        '' }}>
                                        AFG
                                    </option>
                                    <option value="Dollar" {{ $payment->Installation_cost_currency =='Dollar' ?
                                        'selected' : '' }}>
                                        Dollar
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <label for="ip_price">
                                Public IP Price: ({{ $customer->ip_price ? $customer->ip_price : '0' }}
                                {{$customer->ip_price_currency}})
                            </label>
                            <input type="number" name="ip_price" id="ip_price" class="form-control"
                                value="{{ $payment->ip_price ? $payment->ip_price : '0'  }}" />
                            <div class="input-group-append">
                                <select class="form-control" name="ip_price_currency">
                                    <option value="AFG" {{ $payment->ip_price_currency == 'AFG' ? 'selected' : '' }}>
                                        AFG
                                    </option>
                                    <option value="Dollar" {{ $payment->ip_price_currency =='Dollar' ? 'selected' : ''
                                        }}>
                                        Dollar
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <label for="additional_charge">
                                Additional Charge Price: ({{ $customer->additional_charge_price ?
                                $customer->additional_charge_price : '0' }}
                                {{$customer->additional_currency}})
                            </label>
                            <input type="number" name="additional_charge" id="additional_charge" class="form-control"
                                value="{{ $payment->additional_charge_price ? $payment->additional_charge_price : '0'  }}" />
                            <div class="input-group-append">
                                <select class="form-control" name="additional_currency">
                                    <option value="AFG" {{ $payment->additional_currency == 'AFG' ? 'selected' : '' }}>
                                        AFG
                                    </option>
                                    <option value="Dollar" {{ $payment->additional_currency =='Dollar' ? 'selected' : ''
                                        }}>
                                        Dollar
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div> <!-- /modal-body -->

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

            </form>

        </div>
    </div>
</div> <!-- // end of Payment modal -->
@endif