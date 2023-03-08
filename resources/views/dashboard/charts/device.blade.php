@extends('dashboard.layouts.app')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Device Types Reports</h4>
                
                <div class="history">

                    <div class="row">
                        <div class="col-sm-6">
                           {{ Breadcrumbs::render('charts.device') }}
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
                    <div class="filter-area">

                        <div id="accordion-2" role="tablist">

                            <div class="card shadow-none mb-0">
                                <div class="card-header" role="tab" id="heading-1">
                                    <a data-toggle="collapse" 
                                       href="#collapse-1" 
                                       aria-expanded="true" 
                                       aria-controls="collapse-1" class="collapse-icons">
                                           <i class="fas fa-filter"></i>
                                           <div class="badge badge-success">
                                                Filter
                                            </div>
                                           <i class="more-less mdi mdi-plus"></i>
                                    </a>
                                </div>

                                <div id="collapse-1" class="collapse" 
                                     role="tabpanel"
                                     aria-labelledby="heading-1" 
                                     data-parent="#accordion-2">
                                    <div class="card-body">
                                        <div class="panel-body">
                                            <form method="get" action="{{ route('charts.device') }}">
                                                @csrf
                                                <div class="row">

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="device">Device Types</label>
                                                            <select id="device" name="device" class="form-control">
                                                                <option value="">Select Device Type</option>
                                                                <option value="router">Router Type</option>
                                                                <option value="receiver">Receiver Type</option>
                                                            </select>
                                                        </div>
                                                    </div> <!-- /col -->

                                                </div> <!-- /row -->

                                                <div class="card-footer">
                                                    <button class="btn btn-primary" type="submit">
                                                        Submit
                                                    </button>
                                                    <button class="btn btn-secondary" type="reset">
                                                        Reset
                                                    </button>
                                                </div>

                                            </form> <!-- /form -->
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- /card -->

                        </div> <!-- // accoridan -->

                    </div> <!-- /filter-area -->
                </div> <!-- /filter-card -->

                <div class="card">
                	<div class="card-body">
                		<canvas id="canvas" height="280" width="600"></canvas>
                	</div>
                </div>

            </div> <!-- /content-box -->
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
   jQuery(document).on('ready',function(){

   		var devices = <?php echo json_encode($devices); ?>;
        var counts  = <?php echo json_encode($counts); ?>;

		var ctx = jQuery('#canvas');
	    var myChart = new Chart(ctx, {
	        type: 'pie',
	        data:{
	            labels:devices,
	            datasets:[],
	            options:{
	                scales:{
	                    yAxes:[{
	                        ticks:{
	                            beginAtZero:false
	                        }
	                    }]
	                }
	            }
	        }
	    });

	    var dynamicColors = function() {
	        var r = Math.floor(Math.random() * 255);
	        var g = Math.floor(Math.random() * 255);
	        var b = Math.floor(Math.random() * 255);
	        return "rgb(" + r + "," + g + "," + b + ")";
	     };

        myChart.data.datasets.push({
            label: "Devices",
            data: counts,
            fill: true,
            borderColor: dynamicColors,
            tension: 0.1
        });
        myChart.update();
         
   });
</script>
@endsection