@extends('dashboard.layouts.app')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Resellers Reports</h4>
                
                <div class="history">

                    <div class="row">
                        <div class="col-sm-6">
                           {{ Breadcrumbs::render('outsource.charts.resellers') }}
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

   		var commissions = <?php echo json_encode($commissions); ?>;
        var counts  = <?php echo json_encode($counts); ?>;

		var ctx = jQuery('#canvas');
	    var myChart = new Chart(ctx, {
	        type: 'pie',
	        data:{
	            labels:commissions,
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
            label: "Resellers",
            data: counts,
            fill: true,
            borderColor: dynamicColors,
            tension: 0.1
        });
        myChart.update();
         
   });
</script>
@endsection