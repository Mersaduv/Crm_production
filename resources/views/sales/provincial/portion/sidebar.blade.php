<div class="card customer_operation">

    <div class="card-header">
        <h1 class="text-center">Operation</h1>
    </div>

    <div class="card-body">

        <!-- ************************************** -->
        <!-- ************Customer Detail*********** -->
        <!-- ************************************** -->

        <button class="btn btn-primary" type="button">
            <a href="{{ route('pr.files',$customer->id) }}">
                Attachment
            </a>
        </button>


        <button class="btn btn-primary" type="button">
            <a href="{{ route('pr.sales.print',$customer->id) }}">
                Print
            </a>
        </button>

        @can('update', ProvincialFullyQualifiedNameSpace())
        @if($customer->active_status == 0 && $customer->cancel_status == 0)
        <button class="btn btn-primary" type="button">
            <a href="{{ route('provincial.edit',$customer->id) }}">
                Edit
            </a>
        </button>
        @endif
        @endcan


        <!-- ************************************************ -->
        <!-- ******************Process Customer************** -->
        <!-- ************************************************ -->

        @can('update', ProvincialFullyQualifiedNameSpace())
        @if($customer->cancel_status == 0)
        @if($customer->process_status == 0)
        <form method="post" action="{{ route('pr_process',$customer->id)}}">
            @csrf
            @method('put')
            <button class="btn btn-success" type="submit">
                Send to Process
            </button>
        </form>
        @else
        <button class="btn btn-success" type="button" disabled="disabled" style="cursor: not-allowed;">
            Sent to Process
        </button>
        @endif
        @endif
        @endcan

        <!-- ************************************** -->
        <!-- ************Customer Suspend*********** -->
        <!-- ************************************** -->
        @can('create', ProvincialSuspendFullyQualifiedNameSpace())
        @if($customer->active_status == 1)
        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#suspendModal">
            Suspend
        </button>
        @endif
        @endcan

        <!-- ************************************** -->
        <!-- ************Customer Amenment********** -->
        <!-- ************************************** -->
        @can('create', ProvincialAmendmentFullyQualifiedNameSpace())
        @if($customer->active_status == 1)
        <button class="btn btn-primary" type="button">
            <a href="{{ route('pr.amendment',$customer->id) }}">
                Amedment
            </a>
        </button>
        @endif
        @endcan

        <!-- ************************************************ -->
        <!-- ******************Deletion Process************** -->
        <!-- ************************************************ -->

        @can('create', ProvincialTerminateFullyQualifiedNameSpace())
        @if($customer->active_status == 1)
        <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#terminateModal">
            Terminate
        </button>
        @endif
        @endcan

        @can('delete', ProvincialFullyQualifiedNameSpace())
        <form method="post" action="{{ route('provincial.destroy',$customer->id) }}">
            @csrf
            @method('delete')
            <button class="btn btn-danger" type="submit">
                Trash
            </button>
        </form>
        @endcan
    </div> <!-- /card-body -->

</div> <!-- /sidebar-card -->

<div class="card">
    <div class="card-header">
        <h1 class="text-center">Created At</h1>
    </div>

    <div class="card-body">
        <p class="text-center">
            <strong>Date:</strong>
            {{ $customer->created_at }}
        </p>

        <p class="text-center">
            <strong>User:</strong>
            {{ $customer->user->name }}
        </p>
    </div>

</div>