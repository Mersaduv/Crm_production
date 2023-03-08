<div class="card customer_operation">

    <div class="card-header">
        <h1 class="text-center">Operation</h1>
    </div> <!-- /card-header -->

    <div class="card-body">

        <button class="btn-primary btn w-100 mb-1">
            <a href="{{ route('finance.files',$customer->customer->id) }}">
                Attachments
            </a>
        </button>

        @if($customer->finance_confirmation)
        <button class="btn btn-success w-100" type="button">
            Confirmed
        </button>
        @endif

        @if(!$customer->finance_confirmation)
        <button class="btn btn-primary w-100 confirm_btn" type="button">
            Confirm Amendment
        </button>
        @endif

        @if(!$customer->cancel_date && !$customer->finance_confirmation)
        <button class="btn btn-danger w-100 mt-1" data-toggle="modal" data-target="#cancelModal" type="button">
            Cancel Amendment
        </button>
        @endif

    </div> <!-- /card-body -->
</div> <!-- /card -->

<div class="card">

    <div class="card-header">
        <h1 class="text-center">Confirmations</h1>
    </div> <!-- /card-header -->

    <div class="card-body">

        <p class="text-center">
            <strong>Finance:</strong>
            @if($customer->finance_confirmation)
            {{ $customer->finance_confirmation }}
            @else
            Not Confirmed!
            @endif
        </p>

        <p class="text-center">
            <strong>Sales:</strong>
            @if($customer->sales_confirmation)
            {{ $customer->sales_confirmation }}
            @else
            Not Confirmed!
            @endif
        </p>

        <p class="text-center">
            <strong>NOC:</strong>
            @if($customer->noc_confirmation)
            {{ $customer->noc_confirmation }}
            @else
            Not Confirmed!
            @endif
        </p>

    </div> <!-- /card-body -->
</div> <!-- /card -->


<!-- The Modal -->
<div class="modal" id="cancelModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="post" action="{{ route('cancel.amendment',$customer->id) }}">
                @csrf
                @method('put')

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Cancel</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">

                    <div class="form-group">
                        <label for="cancel_date">Cancel Date:</label>
                        <input type="datetime-local" name="cancel_date" class="form-control" id="cancel_date"
                            required="required" />
                    </div>

                    <div class="form-group">
                        <label for="cancel_reason">Cancel Reason:</label>
                        <textarea class="form-control" name="cancel_reason" id="cancel_reason"
                            placeholder="Cancel Reason" rows="5" required="required"></textarea>
                    </div>

                </div> <!-- /modal-body -->

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

            </form>

        </div>
    </div>
</div> <!-- // end of suspend modal -->