<div class="card-header">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button
                class="nav-link filter-area-pr-terminate  mr-2  {{ request('attr') == 'terminate' ? 'active' : '' }}"
                type="button" role="tab" attr="terminate">Terminates</button>
            <button class="nav-link filter-area-pr-terminate  mr-2 {{ request('attr') == 'pending' ? 'active' : '' }}"
                type="button" role="tab" attr="pending">
                Terminate Requests
            </button>
            <button
                class="nav-link filter-area-pr-recontract-terminate mr-2  {{ request('attr') == 'recontract' ? 'active' : '' }}"
                type="button" role="tab" attr="recontract">Recontract Requests</button>
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
                <th>Termination Date</th>
                @canany(['view'], ProvincialTerminateFullyQualifiedNameSpace())
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
                    @if ($customer->PrNocInfo()->exists())
                    {{ $customer->PrNocInfo->activation_date }}
                    @else
                    NA
                    @endif
                </th>
                <th>
                    {{ $customer->terminate->first()->terminate_date }}
                </th>
                @canany(['view'], ProvincialTerminateFullyQualifiedNameSpace())
                <td>
                    <div class="action_dropdown_area">
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                Actions
                            </button>
                            <div class="dropdown-menu">
                                @can('view', ProvincialTerminateFullyQualifiedNameSpace())
                                <a class="dropdown-item" href="{{ route('admin.terminate', $customer->id) }}">
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