@extends('noc.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Customer</h4>

            <div class="history">

                <div class="row">
                    <div class="col-sm-6">
                        {{ Breadcrumbs::render('contractors.show',$customer) }}
                    </div>
                    <div class="col-sm-6 historyBTN">
                        <button class="btn btn-primary btn-sm">
                            <a href="{{ url()->previous() }}" class="btn btn-ctr">
                                <i class="far fa-arrow-alt-circle-left"></i>
                                Go Back
                            </a>
                        </button>
                    </div>
                </div> <!-- /row -->

            </div>

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
                    <h1 class="card-title">Customer Operations Timeline</h1>
                </div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-4">

                            <section class="timeline_area section_padding_130">
                                <div class="apland-timeline-area">

                                    @foreach ( $timelineData as $stdObj)
                                    @if($stdObj->event_date)

                                    <!-- Single Timeline Content-->
                                    <div class="single-timeline-area">

                                        <div class="timeline-date wow fadeInLeft" data-wow-delay="0.1s" style="visibility: visible;
					                        	 		animation-delay: 0.1s;
					                        	 		animation-name: fadeInLeft;">
                                            <p>{{ $stdObj->event_date }}</p>
                                        </div>

                                        <div class="single-timeline-content d-flex
                            							wow fadeInLeft" data-wow-delay="0.3s" style="visibility: visible;
	                                            		animation-delay: 0.3s;
	                                     				animation-name: fadeInLeft;">

                                            @php
                                            $events = explode(',', $stdObj->events);
                                            $ids = explode(',', $stdObj->ids);
                                            @endphp

                                            @foreach ( $events as $index => $eventName)
                                            @php
                                            switch ($eventName) {
                                            case 'Installation':
                                            $buttonClass = 'btn-info';
                                            break;
                                            case 'Activate':
                                            $buttonClass = 'btn-primary';
                                            break;
                                            case 'Amendment':
                                            $buttonClass = 'btn-info';
                                            break;
                                            case 'Suspend':
                                            $buttonClass = 'btn-secondary';
                                            break;

                                            case 'Reactivate':
                                            $buttonClass = 'btn-info';
                                            break;

                                            case 'Terminate':
                                            $buttonClass = 'btn-danger';
                                            break;

                                            case 'Recontract':
                                            $buttonClass = 'btn-info';
                                            break;

                                            case 'Cancel':
                                            $buttonClass = 'btn-danger';
                                            break;

                                            case 'Cancel RollBack':
                                            $buttonClass = 'btn-info';
                                            break;

                                            case 'CancelAmendment':
                                            $buttonClass = 'btn-warning';
                                            break;

                                            default:
                                            $buttonClass = 'btn-primary';
                                            }
                                            @endphp
                                            <button class="btn {{ $buttonClass }} timeline-btn"
                                                event-date="{{$stdObj->event_date}}" event-id="{{ $ids[$index] }}"
                                                event-name="{{$eventName}}">
                                                {{ $eventName }}
                                            </button>
                                            @endforeach

                                        </div>

                                    </div> <!-- /timeline-area -->

                                    @endif
                                    @endforeach

                                </div>
                            </section> <!-- /timeline-section -->

                        </div> <!-- /col-4 -->

                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Timeline Info</h5>
                                </div> <!-- /card-header -->
                                <div class="card-body">
                                    <div id="timeline-body">

                                    </div>
                                </div> <!-- /card-body -->
                            </div> <!-- /card -->
                        </div> <!-- /col-9 -->

                    </div> <!-- /row -->
                </div> <!-- /timeline-card-body -->

            </div> <!-- /timeline-card -->

        </div>
    </div> <!-- /col -->

    <div class="clearfix"></div>
</div> <!-- /end of page content -->
@endsection

@section('style')
<style>
    .btn {
        font-size: 12px;
        margin: 0px 2px;
    }
</style>
@endsection

@section('script')
<script type="text/javascript">
    jQuery(document).ready(function(){

   	jQuery('.timeline-btn').off().on('click',function(e){
        e.preventDefault();
        var date = jQuery(this).attr('event-date');
        var event = jQuery(this).attr('event-name');
        var event_id = jQuery(this).attr('event-id');

        jQuery.ajax({
           url:"{{ route('contractors.details') }}",
           method:'post',
           data:{
                "_token": "{{ csrf_token() }}",
                date:date,
                event:event,
                event_id:event_id,
                id:"{{ $id }}",
            },
           success:function(response){
             $('#timeline-body').html(response);
           }
        });

    });

   });
</script>
@endsection