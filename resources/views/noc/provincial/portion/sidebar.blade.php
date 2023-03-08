<div class="card customer_operation">

    <div class="card-header">
        <h1 class="text-center">Operation</h1>
    </div> <!-- /card-header -->

    <div class="card-body">

        <!-- ************************************************ -->
        <!-- ******************Customer Process************* -->
        <!-- ************************************************ -->



        @if($customer->active_status == 1)
        <button class="btn btn-primary" type="button">
            <a href="{{ route('pr.noc.files',$customer->id) }}">
                Attachment
            </a>
        </button>
        @endif

        @if($customer->active_status == 1)
        <button class="btn btn-primary" type="button">
            <a href="{{ route('prCustomers.edit',$customer->id)}}">
                Edit
            </a>
        </button>
        @else

        @if($customer->terminate_status == 0 && $customer->cancel_status == 0)
        <button class="btn btn-primary" type="button">
            <a href="{{ route('prCustomers.create',['id'=>$customer->id])}}">
                Process
            </a>
        </button>
        @endif

        @can('create', ProvincialCancelFullyQualifiedNameSpace())
        @if($customer->cancel_status == 0 && $customer->terminate_status == 0)
        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#cancelModal">
            Cancel Installation
        </button>
        @endif
        @endcan

        @can('update', ProvincialCancelFullyQualifiedNameSpace())
        @if($customer->cancel_status == 1)
        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#cancelModal">
            Rollback Cancel
        </button>
        @endif
        @endcan
        @endif



        <!-- ************************************************ -->
        <!-- ******************Suspend Details************* -->
        <!-- ************************************************ -->

        @can('create', ProvincialSuspendFullyQualifiedNameSpace())
        @if($customer->active_status == 1)
        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#suspendModal">
            Suspend
        </button>
        @endif
        @endcan

        <!-- ************************************************ -->
        <!-- ******************Terminate Details************* -->
        <!-- ************************************************ -->


        @if($customer->terminate_status == 1)
        <p>
            <strong>ID:</strong>
            {{ $customer->customer_id }}
        </p>
        <p>
            <strong>Name:</strong>
            {{ $customer->full_name }}
        </p>
        <p>
            <strong>Termination Date:</strong>
            {{ $customer->terminate->terminate_date }}
        </p>
        <p>
            <strong>Terminate Reason:</strong>
            {{ $customer->terminate->terminate_reason }}
        </p>

        <button class="btn btn-primary" type="button">
            <a href="{{ route('pr.noc.files',$customer->id) }}">
                Attachment
            </a>
        </button>

        @endif


    </div> <!-- /card-body -->
</div> <!-- /card -->