<div class="card-header">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link filter-area-pr-cancel  mr-2 {{ request('attr') == 'all' ? 'active' : '' }}"
                type="button" role="tab" attr="all">All</button>
            <button class="nav-link filter-area-pr-cancel mr-2 {{ request('attr') == 'confirmed' ? 'active' : '' }}"
                type="button" role="tab" attr="confirmed">Confirmed</button>
            <button class="nav-link filter-area-pr-cancel mr-2 {{ request('attr') == 'not-confirm' ? 'active' : '' }}"
                type="button" role="tab" attr="not-confirm">
                Not Confirmed
                <span class="badge badge-info">
                    {{ PrCancel('noc_confirmation') }}
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
                <th>Cancel Date</th>
                <th>Cancel Reason</th>
                @canany(['view'], ProvincialCancelFullyQualifiedNameSpace())
                <th>Operation</th>
                @endcanany
            </tr>
        </thead>
        <tbody>
            @if (count($cancels) > 0)
            <?php
                $page = request('page') ? request('page') : 1;
                $index = 15 * $page - 14;
                ?>
            @foreach ($cancels as $cancel)
            <tr>
                <th>{{ $index }}</th>
                <th>{{ $cancel->customer_id }}</th>
                <th>{{ $cancel->full_name }}</th>
                <th>{{ province($cancel->province) }}</th>
                <th>{{ province($cancel->customerProvince) }}</th>
                <th>{{ $cancel->prCancel->first()->cancel_date }}</th>
                <th>
                    {{ Illuminate\Support\Str::limit($cancel->prCancel->first()->cancel_reason, 80) }}
                </th>
                @canany(['view'], ProvincialCancelFullyQualifiedNameSpace())
                <td>
                    <div class="action_dropdown_area">
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                Actions
                            </button>
                            <div class="dropdown-menu">
                                @can('view', ProvincialCancelFullyQualifiedNameSpace())
                                <a class="dropdown-item" href="{{ route('prCancels.show', $cancel->id) }}">
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
                <th colspan="6">No Data Found</th>
            </tr>
            @endif
        </tbody>
    </table>
</div> <!-- /card-body -->
<div class="card-footer">
    <div class="pagination">
        {{ $cancels->links() }}
    </div>
</div> <!-- /card-footer -->

<input type="hidden" name="total" id="total" value="{{ $total }}" />