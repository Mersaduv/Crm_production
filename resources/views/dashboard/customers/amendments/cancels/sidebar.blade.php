<div class="card">

    <div class="card-header">
        <h1 class="text-center">Operation</h1>
    </div> <!-- /card-header -->

    <div class="card-body">
        <button class="btn btn-primary w-100">
            <a href="{{ route('admin.files',$amend->customer->id) }}">
                Attachments
            </a>
        </button>
    </div> <!-- /card-body -->

</div>

<div class="card">

    <div class="card-header">
        <h1 class="text-center">Cancel Details</h1>
    </div> <!-- /card-header -->

    <div class="card-body">

        <p class="text-center">
            <strong>Cancel Date:</strong>
            {{ $amend->cancel_date }}
        </p>

        <p class="text-center">
            <strong>Cancel Reason:</strong>
            {{ $amend->cancel_reason }}
        </p>

        <p class="text-center">
            <strong>Cancel By:</strong>
            {{ $amend->user->name }}
        </p>

    </div> <!-- /card-body -->

</div> <!-- /card -->

<div class="card">

    <div class="card-header">
        <h1 class="text-center">Confirmation Dates</h1>
    </div> <!-- /card-header -->

    <div class="card-body">

        <p class="text-center">
            <strong>Sales:</strong>
            {{ $amend->sales_confirmation ? $amend->sales_confirmation : 'Not Confirmed' }}
        </p>

        <p class="text-center">
            <strong>Finance:</strong>
            {{ $amend->finance_confirmation ? $amend->finance_confirmation : 'Not Confirmed' }}
        </p>

        <p class="text-center">
            <strong>NOC:</strong>
            {{ $amend->noc_confirmation ? $amend->noc_confirmation : 'Not Confirmed' }}
        </p>

    </div> <!-- /card-body -->
</div> <!-- /card -->