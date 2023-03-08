@extends('dashboard.layouts.app')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Total Customers Reports</h4>
                
                <div class="history">

                    <div class="row">
                        <div class="col-sm-6">
                           {{ Breadcrumbs::render('outsource.charts.customers') }}
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
                                            <form method="get" action="{{ route('outsource.charts.customers') }}">
                                                @csrf
                                                <div class="row">

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="insStart">
                                                                Installation Date:
                                                            </label>
                                                            <input type="date" 
                                                                   name="insStart"
                                                                   id="insStart" 
                                                                   class="form-control" 
                                                                />
                                                        </div>
                                                    </div> <!-- /col -->

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="insEnd">End Date:</label>
                                                            <input type="date" 
                                                                   name="insEnd"
                                                                   id="insEnd" 
                                                                   class="form-control" 
                                                                />
                                                        </div>
                                                    </div> <!-- /col -->

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="actStart">
                                                                Activation Date:
                                                            </label>
                                                            <input type="date" 
                                                                   name="actStart"
                                                                   id="actStart" 
                                                                   class="form-control" 
                                                                />
                                                        </div>
                                                    </div> <!-- /col -->

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="actEnd">End Date:</label>
                                                            <input type="date" 
                                                                   name="actEnd"
                                                                   id="actEnd" 
                                                                   class="form-control" 
                                                                />
                                                        </div>
                                                    </div> <!-- /col -->

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="cancelStart">
                                                                Cancel Date:
                                                            </label>
                                                            <input type="date" 
                                                                   name="cancelStart"
                                                                   id="cancelStart" 
                                                                   class="form-control" 
                                                                />
                                                        </div>
                                                    </div> <!-- /col -->

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="cancelEnd">End Date:</label>
                                                            <input type="date" 
                                                                   name="cancelEnd"
                                                                   id="cancelEnd" 
                                                                   class="form-control" 
                                                                />
                                                        </div>
                                                    </div> <!-- /col -->

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="susStart">
                                                                Suspend Date:
                                                            </label>
                                                            <input type="date" 
                                                                   name="susStart"
                                                                   id="susStart" 
                                                                   class="form-control" 
                                                                />
                                                        </div>
                                                    </div> <!-- /col -->

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="susEnd">End Date:</label>
                                                            <input type="date" 
                                                                   name="susEnd"
                                                                   id="susEnd" 
                                                                   class="form-control" 
                                                                />
                                                        </div>
                                                    </div> <!-- /col -->

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="terStart">
                                                                Terminate Date:
                                                            </label>
                                                            <input type="date" 
                                                                   name="terStart"
                                                                   id="terStart" 
                                                                   class="form-control" 
                                                                />
                                                        </div>
                                                    </div> <!-- /col -->

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="terEnd">End Date:</label>
                                                            <input type="date" 
                                                                   name="terEnd"
                                                                   id="terEnd" 
                                                                   class="form-control" 
                                                                />
                                                        </div>
                                                    </div> <!-- /col -->

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="amendStart">
                                                                Amendment Date:
                                                            </label>
                                                            <input type="date" 
                                                                   name="amendStart"
                                                                   id="amendStart" 
                                                                   class="form-control" 
                                                                />
                                                        </div>
                                                    </div> <!-- /col -->

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="amendEnd">End Date:</label>
                                                            <input type="date" 
                                                                   name="amendEnd"
                                                                   id="amendEnd" 
                                                                   class="form-control" 
                                                                />
                                                        </div>
                                                    </div> <!-- /col -->

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="cancelAmend">
                                                                Cancel Amendment Date:
                                                            </label>
                                                            <input type="date" 
                                                                   name="cancelAmend"
                                                                   id="cancelAmend" 
                                                                   class="form-control" 
                                                                />
                                                        </div>
                                                    </div> <!-- /col -->

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="cancelAmendEnd">End Cancel Date:</label>
                                                            <input type="date" 
                                                                   name="cancelAmendEnd"
                                                                   id="cancelAmendEnd" 
                                                                   class="form-control" 
                                                                />
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

   		var datas = <?php echo json_encode($datas); ?>;
        var activations = <?php echo json_encode($activationDatas); ?>;
        var cancels = <?php echo json_encode($cancelDatas); ?>;
        var amendments = <?php echo json_encode($amendmentsDatas); ?>;
        var suspends = <?php echo json_encode($suspendDatas); ?>;
        var termination = <?php echo json_encode($terminatesDatas); ?>;
        var cancelAmendments = <?php echo json_encode($cancelAmendmentsDatas); ?>;

		var ctx = jQuery('#canvas');
	    var myChart = new Chart(ctx, {
	        type: 'line',
	        data:{
	            labels:['Jan','Feb','Mar','Apr','May','June','July','Aug','Sep','Oct','Nov','Dec'],
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
            label: "Total Customers",
            data: datas,
            fill: true,
            borderColor: "rgb(0,0,0)",
            tension: 0.1
        });
        myChart.update();
         
	    myChart.data.datasets.push({
			label: "Activations",
            data: activations,
            fill: true,
            borderColor: "rgb(0, 0, 153)",
            tension: 0.1
		});
		myChart.update();

        myChart.data.datasets.push({
            label: "Cancels",
            data: cancels,
            fill: true,
            borderColor: "rgb(255, 255, 0)",
            tension: 0.1
        });
        myChart.update();

        myChart.data.datasets.push({
            label: "Amendments",
            data: amendments,
            fill: true,
            borderColor: "rgb(0, 204, 0)",
            tension: 0.1
        });
        myChart.update();

        myChart.data.datasets.push({
            label: "Cancel Amendments",
            data: cancelAmendments,
            fill: true,
            borderColor: "rgb(0, 204, 0)",
            tension: 0.1
        });
        myChart.update();

        myChart.data.datasets.push({
            label: "Suspends",
            data: suspends,
            fill: true,
            borderColor: "rgb(255, 102, 0)",
            tension: 0.1
        });
        myChart.update();

        myChart.data.datasets.push({
            label: "Termintions",
            data: termination,
            fill: true,
            borderColor: "rgb(204, 0, 0)",
            tension: 0.1
        });
        myChart.update();

   });
</script>
@endsection