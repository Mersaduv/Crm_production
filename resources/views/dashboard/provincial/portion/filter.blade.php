<div class="card-header">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link provincial-filter-area mr-2 {{ request('attr') == 'all' ? 'active' : '' }}"
                type="button" role="tab" attr="all">All</button>
            <button class="nav-link provincial-filter-area mr-2 {{ request('attr') == 'active' ? 'active' : '' }}"
                type="button" role="tab" attr="active">Active</button>
            <button class="nav-link provincial-filter-area {{ request('attr') == 'not-active' ? 'active' : '' }}"
                type="button" role="tab" attr="not-active">Not Active</button>
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
                <th>Province</th>
                <th>Customer Province</th>
                <th>Package</th>
                <th>Installation Date</th>
                <th>Activation Date</th>
                @canany(['view'], ProvincialFullyQualifiedNameSpace())
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
                <th>{{ province($customer->province) }}</th>
                <th>{{ province($customer->customerProvince) }}</th>
                <th>
                    {{ $customer->package ? $customer->package->name : 'NA' }}
                </th>
                <th>{{ $customer->installation_date }}</th>
                <th>
                    @if ($customer->PrNocInfo()->exists())
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
                    {{ $customer->PrNocInfo->activation_date }}
                    @endif
                    @else
                    NA
                    @endif
                </th>
                @canany(['view'], ProvincialFullyQualifiedNameSpace())
                <td>
                    <div class="action_dropdown_area">
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                Actions
                            </button>
                            <div class="dropdown-menu">
                                @can('view', ProvincialFullyQualifiedNameSpace())
                                <a class="dropdown-item" href="{{ route('admin.pr.show', $customer->id) }}">
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
                <th colspan="8">No Data Found!</th>
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