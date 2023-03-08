<div class="card">

    <div class="card-header">
        <h1 class="text-center">Operation</h1>
    </div> <!-- /card-header -->

    <div class="card-body">

        <button class="btn-primary btn w-100 mb-1">
            <a href="{{ route('finance.files',$customer->id) }}">
                Attachments
            </a>
        </button>

        <!-- Confirm the customer payment -->

        @can('create', PaymentFullyQualifiedNameSpace())
        @if($customer->finance_status ==0)
        <button class="btn btn-info w-100 mb-1" type="button" data-toggle="modal" data-target="#paymentModal">
            Add Payment
        </button>
        @endif
        @endcan


        <!-- Rollback the customer payment -->
        @can('update', PaymentFullyQualifiedNameSpace())
        @if($customer->finance_status == 1 )
        <button class="btn btn-info w-100 mb-1" type="button" data-toggle="modal" data-target="#updatePaymentModal">
            Update Payment
        </button>
        @endif
        @endcan

        <!-- Suspend the customer when it is active -->
        @can('create', SuspendFullyQualifiedNameSpace())
        @if($customer->active_status ==1)
        <button class="btn btn-primary w-100" type="button" data-toggle="modal" data-target="#suspendModal">
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

            <form method="post" action="{{ route('finance.suspend',$customer->id) }}">
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

            <form method="post" action="{{ route('finance.update',$customer->id) }}">
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
                            <label for="package_price">
                                Package Price:
                            </label>
                            <input type="number" name="package_price" id="package_price" class="form-control"
                                value="{{ $customer->sale->package_price ? $customer->sale->package_price :'0'}}"
                                required="required" autocomplete="off" />
                            <div class="input-group-append">
                                <select class="form-control" name="package_price_currency">
                                    <option value="AFG" {{ $customer->sale->package_price_currency == 'AFG' ? 'selected'
                                        : '' }}>
                                        AFG
                                    </option>
                                    <option value="Dollar" {{ $customer->sale->package_price_currency == 'Dollar' ?
                                        'selected' : '' }}>
                                        Dollar
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <label for="receiver_price">
                                Receiver Price:
                            </label>
                            <input type="number" name="receiver_price" id="receiver_price" class="form-control"
                                placeholder="Receiver Price:"
                                value="{{ $customer->sale->receiver_price ? $customer->sale->receiver_price:'0'}}"
                                autocomplete="off" />
                            <div class="input-group-append">
                                <select class="form-control" name="receiver_price_currency">
                                    <option value="AFG" {{ $customer->sale->receiver_price_currency == 'AFG' ?
                                        'selected' : '' }}>
                                        AFG
                                    </option>
                                    <option value="Dollar" {{ $customer->sale->receiver_price_currency == 'Dollar' ?
                                        'selected' : '' }}>
                                        Dollar
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <label for="router_price">
                                Router Price:
                            </label>
                            <input type="number" name="router_price" id="router_price" class="form-control"
                                placeholder="Router Price:"
                                value="{{ $customer->sale->router_price ? $customer->sale->router_price : '0' }}"
                                autocomplete="off" />
                            <div class="input-group-append">
                                <select class="form-control" name="router_price_currency">
                                    <option value="AFG" {{ $customer->sale-> router_price_currency == 'AFG' ?'selected'
                                        : '' }}>
                                        AFG
                                    </option>
                                    <option value="Dollar" {{ $customer->sale->router_price_currency == 'Dollar' ?
                                        'selected' : '' }}>
                                        Dollar
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <label for="cable_price">
                                Cable Price:
                            </label>
                            <input type="number" name="cable_price" class="form-control" id="cable_price"
                                placeholder="Cable Price:"
                                value="{{ $customer->sale->cable_price ? $customer->sale->cable_price : '0' }}"
                                autocomplete="off" />
                            <div class="input-group-append">
                                <select class="form-control" name="cable_price_currency">
                                    <option value="AFG" {{ $customer->sale->cable_price_currency == 'AFG' ? 'selected' :
                                        '' }}>
                                        AFG
                                    </option>
                                    <option value="Dollar" {{ $customer->sale->cable_price_currency == 'Dollar' ?
                                        'selected' : '' }}>
                                        Dollar
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <label for="Installation_cost">
                                Installation Cost:
                            </label>
                            <input type="number" name="Installation_cost" id="Installation_cost" class="form-control"
                                placeholder="Installation Cost:" autocomplete="off" required="required"
                                value="{{ $customer->sale->Installation_cost ? $customer->sale->Installation_cost : '0' }}" />
                            <div class="input-group-append">
                                <select class="form-control" name="Installation_cost_currency">
                                    <option value="AFG" {{ $customer->sale->Installation_cost_currency == 'AFG' ?
                                        'selected' : '' }}>
                                        AFG
                                    </option>
                                    <option value="Dollar" {{ $customer->sale->Installation_cost_currency == 'Dollar' ?
                                        'selected' : '' }}>
                                        Dollar
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <label for="public_ip_price">
                                Public IP Price:
                            </label>
                            <input type="number" name="ip_price" id="public_ip_price" class="form-control"
                                placeholder="Public IP Price:" autocomplete="off"
                                value="{{ $customer->sale->ip_price ? $customer->sale->ip_price : '0' }}" />
                            <div class="input-group-append">
                                <select class="form-control" name="ip_price_currency">
                                    <option value="AFG" {{ $customer->sale->ip_price_currency == 'AFG' ? 'selected' : ''
                                        }}>
                                        AFG
                                    </option>
                                    <option value="Dollar" {{ $customer->sale->ip_price_currency == 'Dollar' ?
                                        'selected' : '' }}>
                                        Dollar
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <label for="additional_price">
                                Additional Charge Price:
                            </label>
                            <input type="number" name="additional_price" id="additional_price" class="form-control"
                                placeholder="Public IP Price:" autocomplete="off"
                                value="{{ $customer->sale->additional_charge_price ? $customer->sale->additional_charge_price : '0' }}" />
                            <div class="input-group-append">
                                <select class="form-control" name="additional_currency">
                                    <option value="AFG" {{ $customer->sale->additional_currency == 'AFG' ? 'selected' :
                                        '' }}>
                                        AFG
                                    </option>
                                    <option value="Dollar" {{ $customer->sale->additional_currency == 'Dollar' ?
                                        'selected' : '' }}>
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

            <form method="post" action="{{ route('finance.update',$customer->id) }}">
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
                                Package Price: ({{ $customer->sale->package_price }}
                                {{ $customer->sale->package_price_currency }})
                            </label>
                            <input type="number" name="package_price" id="package_price" class="form-control"
                                value="{{ $payment->package_price }}" required="required" autocomplete="off" />
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
                            <label for="receiver_price">
                                Receiver Price: ({{ $customer->sale->receiver_price }} {{
                                $customer->sale->receiver_price_currency }})
                            </label>
                            <input type="number" name="receiver_price" id="receiver_price" class="form-control"
                                placeholder="Receiver Price:" value="{{ $payment->receiver_price}}"
                                autocomplete="off" />
                            <div class="input-group-append">
                                <select class="form-control" name="receiver_price_currency">
                                    <option value="AFG" {{ $payment->receiver_price_currency == 'AFG' ? 'selected' : ''
                                        }}>
                                        AFG
                                    </option>
                                    <option value="Dollar" {{ $payment->receiver_price_currency == 'Dollar' ? 'selected'
                                        : '' }}>
                                        Dollar
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <label for="router_price">
                                Router Price: ({{ $customer->sale->router_price }} {{
                                $customer->sale->router_price_currency }})
                            </label>
                            <input type="number" name="router_price" id="router_price" class="form-control"
                                placeholder="Router Price:" value="{{ $payment->router_price }}" autocomplete="off" />
                            <div class="input-group-append">
                                <select class="form-control" name="router_price_currency">
                                    <option value="AFG" {{ $payment->router_price_currency == 'AFG' ? 'selected' : ''
                                        }}>
                                        AFG
                                    </option>
                                    <option value="Dollar" {{ $payment->router_price_currency == 'Dollar' ? 'selected' :
                                        '' }}>
                                        Dollar
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <label for="cable_price">
                                Cable Price: ({{ $customer->sale->cable_price }} {{
                                $customer->sale->cable_price_currency }})
                            </label>
                            <input type="number" name="cable_price" class="form-control" id="cable_price"
                                placeholder="Cable Price:" value="{{ $payment->cable_price }}" autocomplete="off" />
                            <div class="input-group-append">
                                <select class="form-control" name="cable_price_currency">
                                    <option value="AFG" {{ $payment->cable_price_currency == 'AFG' ? 'selected' : '' }}>
                                        AFG
                                    </option>
                                    <option value="Dollar" {{ $payment->cable_price_currency == 'Dollar' ? 'selected' :
                                        '' }}>
                                        Dollar
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <label for="Installation_cost">
                                Installation Cost: ({{ $customer->sale->Installation_cost }} {{
                                $customer->sale->Installation_cost_currency }})
                            </label>
                            <input type="number" name="Installation_cost" id="Installation_cost" class="form-control"
                                placeholder="Installation Cost:" autocomplete="off" required="required"
                                value="{{ $payment->Installation_cost }}" />
                            <div class="input-group-append">
                                <select class="form-control" name="Installation_cost_currency">
                                    <option value="AFG" {{ $payment->Installation_cost_currency == 'AFG' ? 'selected' :
                                        '' }}>
                                        AFG
                                    </option>
                                    <option value="Dollar" {{ $payment->Installation_cost_currency == 'Dollar' ?
                                        'selected' : '' }}>
                                        Dollar
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <label for="public_ip_price">
                                Public IP Price: ( {{ $customer->sale->ip_price }}
                                {{ $customer->sale->ip_price_currency }})
                            </label>
                            <input type="number" name="ip_price" id="public_ip_price" class="form-control"
                                placeholder="Public IP Price:" autocomplete="off" value="{{ $payment->ip_price }}" />
                            <div class="input-group-append">
                                <select class="form-control" name="ip_price_currency">
                                    <option value="AFG" {{ $payment->ip_price_currency == 'AFG' ? 'selected' : '' }}>
                                        AFG
                                    </option>
                                    <option value="Dollar" {{ $customer->ip_price_currency == 'Dollar' ? 'selected' : ''
                                        }}>
                                        Dollar
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <label for="additional_price">
                                Additional Charge Price: ( {{ $customer->sale->additional_charge_price }}
                                {{ $customer->sale->additional_currency }})
                            </label>
                            <input type="number" name="additional_price" id="additional_price" class="form-control"
                                placeholder="Public IP Price:" autocomplete="off"
                                value="{{ $payment->additional_charge_price }}" />
                            <div class="input-group-append">
                                <select class="form-control" name="additional_currency">
                                    <option value="AFG" {{ $payment->additional_currency == 'AFG' ? 'selected' : '' }}>
                                        AFG
                                    </option>
                                    <option value="Dollar" {{ $customer->additional_currency == 'Dollar' ? 'selected' :
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

@endif