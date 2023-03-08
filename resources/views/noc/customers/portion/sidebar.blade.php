<div class="card">

    <div class="card-header">
        <h1 class="text-center">Operation</h1>
    </div> <!-- /card-header -->

    <div class="card-body">

        <!-- ************************************************ -->
        <!-- ******************Suspend Details************* -->
        <!-- ************************************************ -->

        @can('create', SuspendFullyQualifiedNameSpace())
        @if($customer->active_status == 1)
        <button class="btn btn-primary w-100 mb-1" type="button" data-toggle="modal" data-target="#suspendModal">
            Suspend
        </button>
        @endif
        @endcan


        <!-- ************************************************ -->
        <!-- ******************Customer Details************* -->
        <!-- ************************************************ -->


        @if($customer->active_status == 1)
        @can('update', NocFullyQualifiedNameSpace())
        <button class="btn btn-primary w-100 mb-1" type="button">
            <a href="{{ route('installation.edit',$customer->id)}}">
                Edit
            </a>
        </button>
        @endcan
        <button class="btn btn-primary w-100 mb-1" type="button">
            <a href="{{ route('noc.attachment',$customer->id) }}">
                Attachment
            </a>
        </button>
        @else
        @can('create', NocFullyQualifiedNameSpace())
        <button class="btn btn-primary w-100 mb-1" type="button">
            <a href="{{ route('installation.create',['id'=>$customer->id])}}">
                Process
            </a>
        </button>
        @endcan
        @endif


        @can('create', CancelFullyQualifiedNameSpace())
        @if($customer->cancel_status == 0 && $customer->active_status == 0 && $customer->noc_status == 1)
        <button class="btn btn-primary w-100" type="button" data-toggle="modal" data-target="#cancelModal">
            Cancel Installation
        </button>
        @endif
        @endcan

        @can('update', CancelFullyQualifiedNameSpace())
        @if($customer->cancel_status == 1)
        <button class="btn btn-primary w-100" type="button" data-toggle="modal" data-target="#cancelModal">
            Rollback Cancel
        </button>
        @endif
        @endcan


    </div> <!-- /card-body -->
</div> <!-- /card -->

@if($customer->noc()->exists())
<div class="card">

    <div class="card-header">
        <h1 class="text-center">Created At</h1>
    </div> <!-- /card-header -->

    <div class="card-body">
        <p class="text-center">
            <strong>Created At:</strong>
            {{ $customer->noc->created_at }}
        </p>
        <p class="text-center">
            <strong>Created By:</strong>
            {{ $customer->noc->user->name }}
        </p>
    </div> <!-- /card-body -->

</div> <!-- /card -->
@endif