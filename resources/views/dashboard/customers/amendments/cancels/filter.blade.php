<div class="card-header">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link filter-area-amend mr-2 {{ request('attr') == 'accepted' ? 'active' : '' }}"
                type="button" role="tab" attr="accepted"> Amendments </button>
            <button class="nav-link filter-area-amend mr-2 {{ request('attr') == 'pending' ? 'active' : '' }}"
                type="button" role="tab" attr="pending"> Amendment Requests </button>
            <button class="nav-link filter-area-cancel-amend mr-2 {{ request('attr') == 'cancels' ? 'active' : '' }}"
                type="button" role="tab" attr="cancels">Canceled Amendments</button>
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
                <th>Amendment Date</th>
                <th>Cancel Date</th>
                <th>Operation</th>
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
                        <th>{{ $customer->amend->amend_date }}</th>
                        <th>{{ $customer->cancel_date }}</th>
                        <th class="operation">
                            <a href="{{ route('cancel.amendment.mr', $customer->id) }}">
                                view <span class="mdi mdi-eye"></span>
                            </a>
                        </th>
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
