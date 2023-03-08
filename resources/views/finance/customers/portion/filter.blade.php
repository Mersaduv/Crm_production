<div class="card-header">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link customer-filter-area mr-2 {{ request('attr') == 'all' ? 'active' : '' }}"
                type="button" role="tab" attr="all">All</button>
            <button class="nav-link customer-filter-area mr-2 {{ request('attr') == 'active' ? 'active' : '' }}"
                type="button" role="tab" attr="active">Paid</button>
            <button class="nav-link customer-filter-area mr-2 {{ request('attr') == 'not-active' ? 'active' : '' }}"
                type="button" role="tab" attr="not-active">Not Paid</button>
        </div>
    </nav>
</div>
<div class="card-body">
    <table class="table" id="my-table">
        <thead>
            <tr>
                <th>#</th>
                <th>ID</th>
                <th>Full Name</th>
                <th>Package</th>
                <th>Installation Date</th>
                <th>Activation Date</th>
                @canany(['view'], CustomerFullyQualifiedNameSpace())
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
                    {{ $customer->sale->package ? $customer->sale->package->name : 'NA' }}
                </th>
                <th>{{ $customer->sale->installation_date }}</th>
                <th>
                    @if ($customer->noc)
                    @if ($customer->last_state == 'reactive')
                    <span class="badge badge-info">
                        reactive
                    </span>
                    {{ $customer->reactivates->first()->reactivation_date }}
                    @elseif ($customer->last_state == 'recontract')
                    <span class="badge badge-info">
                        recontract
                    </span>
                    {{ $customer->recontracts->first()->recontract_date }}
                    @else
                    {{ $customer->noc->activation_date }}
                    @endif
                    @else
                    NA
                    @endif
                </th>
                @canany(['view'], CustomerFullyQualifiedNameSpace())
                <td>
                    <div class="action_dropdown_area">
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                Actions
                            </button>
                            <div class="dropdown-menu">
                                @can('view', CustomerFullyQualifiedNameSpace())
                                <a class="dropdown-item" href="{{ route('finance.show', $customer->id) }}">
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