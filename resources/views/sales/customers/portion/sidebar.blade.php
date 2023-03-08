<div class="card">
    <div class="card-header">
        <h1 class="text-center">Operation</h>
    </div> <!-- /card-header -->
    <div class="card-body">


        <!-- ************************************** -->
        <!-- ************Customer Detail*********** -->
        <!-- ************************************** -->

        <button class="btn btn-primary w-100 mb-1" type="button">
            <a href="{{ route('fileview',$customer->sale->id) }}">
                Attachment
            </a>
        </button>

        @if($customer->cancel_status == 0)
        <button class="btn btn-primary w-100 mb-1" type="button">
            <a href="{{ route('printContract',['id' => $customer->id]) }}">
                Print
            </a>
        </button>
        @endif

        @can('update', CustomerFullyQualifiedNameSpace())
        @if($customer->active_status == 0 && $customer->cancel_status == 0)
        <button class="btn btn-primary w-100 mb-1" type="button">
            <a href="{{ route('customers.edit',$customer->id) }}">
                Edit
            </a>
        </button>
        @endif
        @endcan

        <!-- ************************************************ -->
        <!-- ******************Process Customer************** -->
        <!-- ************************************************ -->

        @can('update', CustomerFullyQualifiedNameSpace())
        @if($customer->cancel_status == 0)

        @if($customer->noc_status == 0)
        <form method="post" action="{{ route('sendProcess',$customer->id)}}">
            @csrf
            @method('put')
            <button class="btn btn-success w-100 mb-1" type="submit">
                Send to Process
            </button>
        </form>
        @else
        <button class="btn btn-success w-100 mb-1" type="button" disabled="disabled" style="cursor: not-allowed;">
            In Process
        </button>
        @endif

        @endif
        @endcan



        <!-- ************************************************ -->
        <!-- ******************Deletion Process************** -->
        <!-- ************************************************ -->
        @can('delete', CustomerFullyQualifiedNameSpace())
        <form method="post" action="{{ route('customers.destroy',$customer->id) }}">
            @csrf
            @method('delete')
            <button class="btn btn-danger w-100 mb-1" type="submit">
                Trash
            </button>
        </form>
        @endcan

        @can('create',TerminateFullyQualifiedNameSpace())
        @if($customer->active_status == 1)
        <button class="btn btn-danger w-100 mb-1" type="button" data-toggle="modal" data-target="#terminateModal">
            Terminate
        </button>
        @endif
        @endcan


        <!-- ************************************************ -->
        <!-- ****************** Suspend Process ************* -->
        <!-- ************************************************ -->

        @can('create',SuspendFullyQualifiedNameSpace())
        @if($customer->active_status == 1)
        <button class="btn btn-primary w-100 mb-1" type="button" data-toggle="modal" data-target="#suspendModal">
            Suspend
        </button>
        @endif
        @endcan

        <!-- ************************************************ -->
        <!-- ****************** Amedment Process ************* -->
        <!-- ************************************************ -->

        @can('create',SuspendFullyQualifiedNameSpace())
        @if($customer->active_status == 1)
        <button class="btn btn-primary w-100" type="button">
            <a href="{{ route('customer.amedment',$customer->id) }}">
                Amedment
            </a>
        </button>
        @endif
        @endcan

    </div> <!-- /card-body -->
</div> <!-- /card -->

<div class="card">
    <div class="card-header">
        <h1 class="text-center"> Created At </h1>
    </div> <!-- /card-header -->

    <div class="card-body">
        <p class="text-center">
            <strong>Date: </strong>
            {{ $customer->created_at }}
        </p>
        <p class="text-center">
            <strong>User:</strong>
            {{ $customer->sale->user->name }}
        </p>
    </div>

</div> <!-- /card -->