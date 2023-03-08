<div class="card-header">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link filter-area-pr-suspend mr-2 {{ request('attr') == 'suspend' ? 'active' : '' }}"
                type="button" role="tab" attr="suspend">Suspends</button>
            <button class="nav-link filter-area-pr-suspend mr-2 {{ request('attr') == 'pending' ? 'active' : '' }}"
                type="button" role="tab" attr="pending">
                Suspend Requests
                <span class="badge badge-info">
                    {{ PrSuspend('sales_confirmation')['suspends'] }}
                </span>
            </button>
            <button
                class="nav-link filter-area-pr-reactivate mr-2 {{ request('attr') == 'reactivate' ? 'active' : '' }}"
                type="button" role="tab" attr="reactivate">
                Reactivation Requests
                <span class="badge badge-info">
                    {{ PrSuspend('sales_confirmation')['reactives'] }}
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
                <th>Province</th>
                <th>Customer Province</th>
                <th>Activation Date</th>
                <th>Suspend Date</th>
                @canany(['view'],ProvincialSuspendFullyQualifiedNameSpace())
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
                <th>{{ $customer->PrNocInfo->activation_date }}</th>
                <th>{{ $customer->suspend->first()->suspend_date }}</th>
                @canany(['view'],ProvincialSuspendFullyQualifiedNameSpace())
                <td>
                    <div class="action_dropdown_area">
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                Actions
                            </button>
                            <div class="dropdown-menu">
                                @can('view', ProvincialSuspendFullyQualifiedNameSpace())
                                <a class="dropdown-item" href="{{ route('pr.suspend', $customer->id) }}">
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
                <th colspan="7">No Data Found</th>
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