<div class="card-header">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">

            <button class="nav-link filter-area-suspend mr-2 {{ request('attr') == 'suspends' ? 'active' : '' }}"
                type="button" role="tab" attr="suspends">Suspends</button>
            <button class="nav-link filter-area-suspend mr-2 {{ request('attr') == 'pendings' ? 'active' : '' }}"
                type="button" role="tab" attr="pendings">
                Suspend Requests
                <span class="badge badge-info">
                    {{ suspends('finance_confirmation')['suspends'] }}
                </span>
            </button>
            <button
                class="nav-link filter-area-reactivate mr-2 {{ request('attr') == 'reactivations' ? 'active' : '' }}"
                type="button" role="tab" attr="reactivations">
                Reactivation Requests
                <span class="badge badge-info">
                    {{ suspends('finance_confirmation')['reactives'] }}
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
                <th>Suspend Date</th>
                @canany(['view'], ReactivateFullyQualifiedNameSpace())
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
                <th>{{ $customer->package ? $customer->package->name : 'NA' }}</th>
                <th>{{ $customer->customer->noc->activation_date }}</th>
                <th>{{ $customer->suspend->suspend_date }}</th>
                @canany(['view'], ReactivateFullyQualifiedNameSpace())
                <td>
                    <div class="action_dropdown_area">
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                Actions
                            </button>
                            <div class="dropdown-menu">
                                @can('view', ReactivateFullyQualifiedNameSpace())
                                <a class="dropdown-item" href="{{ route('finance.reactivates.show', $customer->id) }}">
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