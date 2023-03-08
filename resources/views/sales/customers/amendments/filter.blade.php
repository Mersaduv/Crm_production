<div class="card-header">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link filter-area-amend mr-2 {{ request('attr') == 'accepted' ? 'active' : '' }}"
                type="button" role="tab" attr="accepted"> Amendments </button>
            <button class="nav-link filter-area-amend mr-2 {{ request('attr') == 'pending' ? 'active' : '' }}"
                type="button" role="tab" attr="pending">
                Amendment Requests
                <span class="badge badge-info">
                    {{ amends('sales_confirmation')['penddingAmend'] }}
                </span>
            </button>
            <button class="nav-link filter-area-cancel-amend mr-2 {{ request('attr') == 'cancels' ? 'active' : '' }}"
                type="button" role="tab" attr="cancels">
                Canceled Amendments
                <span class="badge badge-info">
                    {{ amends('sales_confirmation')['canceledAmend'] }}
                </span>
            </button>
        </div>
    </nav>
</div> <!-- /card-header -->

<div class="card-body">
    <table class="table" id="my-table">
        <thead>
            <tr>
                <th>#</th>
                <th>ID</th>
                <th>Full Name</th>
                <th>Package</th>
                <th>Activation Date</th>
                <th>Amendment Date</th>
                @canany(['view'], AmendmentFullyQualifiedNameSpace())
                <th>Operation</th>
                @endcanany
            </tr>
        </thead>
        <tbody>
            @if (count($customers) > 0)
            <?php
                $page = request('page') ? request('page') : 1;
                $index = 15 * $page - 14;
                ?>
            @foreach ($customers as $customer)
            <tr>
                <th>{{ $index }}</th>
                <th>{{ $customer->customer_id }}</th>
                <th>{{ $customer->full_name }}</th>
                <th>
                    {{ $customer->package ? $customer->package->name : 'NA' }}
                </th>
                <th>{{ $customer->customer->noc->activation_date }}</th>
                <th>{{ $customer->amend_date }}</th>
                @canany(['view'], AmendmentFullyQualifiedNameSpace())
                <td>
                    <div class="action_dropdown_area">
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                Actions
                            </button>
                            <div class="dropdown-menu">
                                @can('view', AmendmentFullyQualifiedNameSpace())
                                <a class="dropdown-item" href="{{ route('amedment.amend', $customer->id) }}">
                                    <i class="fas fa-info info"></i>
                                    Details
                                </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </td>
                @endcanany
            </tr>
            <?php $index++; ?>
            @endforeach
            @else
            <tr>
                <th colspan="7">No Data Found!</th>
            </tr>
            @endif
        </tbody>
    </table>
</div> <!-- /card-body -->

<div class="card-footer">
    <div class="pagination">
        {{ $customers->links() }}
    </div>
</div> <!-- /card-footer -->


<input type="hidden" name="total" id="total" value="{{ $total }}" />