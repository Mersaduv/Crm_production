<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="color-scheme" content="light">
        <meta name="supported-color-schemes" content="light">
        <style>
            .table {
                width: 100%;
                text-align: center;
                border-collapse: collapse;
            }

            tbody {
                border-bottom: 2px solid #000;
            }

            tbody tr:nth-child(odd) {
                background: #eee;
            }

            td,
            th {
                border: 1px solid #999;
                padding: 0.5rem;
            }

            h1 {
                text-align: center;
                padding: 20px auto;
                background: #eee;
            }
        </style>
    </head>

    <body>
        <h1>Customer Amendment Cancel Details</h1>
        <table class="table">
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
                        {{ $customer->phone1 }} - {{ $customer->phone2 }}
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
                        {{ $customer->package_id ? package($customer->package_id) : 'NA' }}
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
                        @if($customer->commission_id)
                        {{ reseller($customer->commission_id) }}
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
                {{-- <tr>
                    <th>Field Officer</th>
                    <td>
                        @if($customer->marketer_id)
                        {{ marketer($customer->marketer_id) }}
                        @else
                        NA
                        @endif
                    </td>
                </tr> --}}
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
                    <th>Amendment Date</th>
                    <td>
                        {{ $customer->amend->amend_date }}
                    </td>
                </tr>
                <tr>
                    <th>Cancel Date</th>
                    <td>
                        {{ $customer->cancel_date }}
                    </td>
                </tr>
                <tr>
                    <th>Amendment Comment</th>
                    <td>{{ $customer->amend->amedment_comment }}</td>
                </tr>
                <tr>
                    <th>Cancel Reason</th>
                    <td>
                        {{ $customer->cancel_reason }}
                    </td>
                </tr>
                <tr>
                    <th>Amendment By</th>
                    <td>{{ $customer->amend->user->name }}</td>
                </tr>
                <tr>
                    <th>Cancel By</th>
                    <td>{{ $customer->user->name }}</td>
                </tr>
                <tr>
                    <th>Sales Confirmation</th>
                    <td>{{ $customer->sales_confirmation ? $customer->sales_confirmation : 'Not Confirmed' }}</td>
                </tr>
                <tr>
                    <th>Finance Confirmation</th>
                    <td>{{ $customer->finance_confirmation ? $customer->finance_confirmation : 'Not Confirmed' }}</td>
                </tr>
                <tr>
                    <th>NOC Confirmation</th>
                    <td>{{ $customer->noc_confirmation ? $customer->noc_confirmation : 'Not Confirmed' }}</td>
                </tr>
            </tbody>
        </table>
    </body>

</html>