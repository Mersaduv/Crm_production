<div class="card-header">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link filter-area-terminate mr-2  {{ request('attr') == 'terminate' ? 'active' : '' }}"
                type="button" role="tab" attr="terminate">Terminates</button>
            <button class="nav-link filter-area-terminate mr-2  {{ request('attr') == 'pending' ? 'active' : '' }}"
                type="button" role="tab" attr="pending">
                Termination Requests
                <span class="badge badge-info">
                    {{ terminates('sales_confirmation')['terminates'] }}
                </span>
            </button>
            <button class="nav-link filter-area-recontract mr-2  {{ request('attr') == 'recontract' ? 'active' : '' }}"
                type="button" role="tab" attr="recontract">
                Recontraction Requests
                <span class="badge badge-info">
                    {{ terminates('sales_confirmation')['recontracts'] }}
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
                <th>Termination Date</th>
                @canany(['view'], TerminateFullyQualifiedNameSpace())
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
                <th>{{ $customer->noc->activation_date }}</th>
                <th>{{ $customer->terminate->first()->termination_date }}</th>
                @canany(['view'], TerminateFullyQualifiedNameSpace())
                <td>
                    <div class="action_dropdown_area">
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                Actions
                            </button>
                            <div class="dropdown-menu">
                                @can('view', TerminateFullyQualifiedNameSpace())
                                <a class="dropdown-item" href="{{ route('singleTerminate', $customer->id) }}">
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