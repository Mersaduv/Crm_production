@extends('sales.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Sales Dashboard</h4>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-sm-12">
        <div class="page-content-box">

            <div class="card">

                <div class="card-header">
                    <h1>Notifications</h1>
                </div>

                <div class="card-body">
                    @forelse($notifications as $notification)
                    <div class="alert alert-info" role="alert">
                        [{{ $notification->created_at }}]
                        -
                        {{ $notification->data['message'] }}:
                        ({{ $notification->data['id'] }}
                        -
                        {{ $notification->data['name'] }})
                        <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
                            Mark as read
                        </a>
                    </div>

                    @if ($loop->last)
                    <a href="#" id="mark-all">
                        <strong>Mark all as read</strong>
                    </a>
                    @endif

                    @empty
                    <div class="alert alert-info" role="alert">
                        There are no new notifications
                    </div>
                    @endforelse
                </div> <!-- /card-body -->

            </div> <!-- /card -->

        </div> <!-- /end of content box -->
    </div>
    <div class="clearfix"></div>
</div> <!-- /end of page content -->
@endsection

@section('style')
<style>

</style>
@endsection

@section('script')
<script type="text/javascript">
    function sendMarkRequest(id = null) {
            return $.ajax("{{ route('markNotification') }}", {
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id
                }
            });
        }

        $(function() {

            $('.mark-as-read').click(function() {
                let request = sendMarkRequest($(this).data('id'));
                request.done(() => {
                    $(this).parents('div.alert').remove();
                });
            });

            $('#mark-all').click(function() {
                let request = sendMarkRequest();
                request.done(() => {
                    $('div.alert').remove();
                })
            });

        });
</script>
@endsection