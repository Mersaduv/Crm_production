@extends('dashboard.layouts.app')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Insert Package</h4>
                
                <div class="history">

                    <div class="row">
                        <div class="col-sm-6">
                           {{ Breadcrumbs::render('packages.add') }}
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
                		
                		<form method="post" action="{{ route('packages.store') }}">
                			@csrf
                			<div class="row">
                				<div class="col-md-3">
                					<div class="form-group">
                						<label for="category" class="required">
                							Package Category:
                						</label>
                						<select class="form-control" id="category" name="category">
                							<option value="">Select Category</option>
                							@foreach($categories as $category)
                								<option value="{{ $category->id }}">
                									{{ $category->name }}
                								</option>
                							@endforeach
                						</select>
                					</div>
                				</div> <!-- /col -->

                				<div class="col-md-3">
                					<div class="form-group">
                						<label for="name" class="required">Name:</label>
                						<input type="text"
                							   name="name" 
                							   id="name"
                							   class="form-control"
                							   placeholder="Name:"
                							   autocomplete="off" 
                							/>
                					</div>
                				</div> <!-- /col -->

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="speed" class="required">Speed:</label>
                                        <input type="text"
                                               name="speed" 
                                               id="speed"
                                               class="form-control"
                                               placeholder="Speed:"
                                               autocomplete="off" 
                                            />
                                    </div>
                                </div> <!-- /col -->

                				<div class="col-md-3">
                					<div class="input-group">
                						<label for="price">Price:</label>
                						<input type="number"
                							   name="price" 
                							   id="price"
                							   class="form-control"
                							   placeholder="Price:"
                							   autocomplete="off" 
                							/>
                                        <div class="input-group-append">
                                            <select class="form-control" name="price_currency">
                                                <option value="AFG">AFG</option>
                                                <option value="Dollar">Dollar</option>
                                            </select>
                                        </div>
                					</div>
                				</div> <!-- /col -->

                                <div class="col-md-3">
                                    <div class="input-group">
                                        <label for="duration">Duration:</label>
                                        <input type="text"
                                               name="duration" 
                                               id="duration"
                                               class="form-control"
                                               placeholder="Duration:"
                                               autocomplete="off" 
                                            />
                                        <div class="input-group-append">
                                            <select class="form-control" name="duration_unit">
                                                <option value="Days">Days</option>
                                                <option value="Months">Months</option>
                                            </select>
                                        </div>
                                    </div>
                                </div> <!-- /col -->

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="category">
                                            Data Type:
                                        </label>
                                        <select class="form-control" id="data_type" name="data_type">
                                            <option value="">Select Type</option>
                                            <option value="hybrid">Hybrid</option>
                                            <option value="limit">limit</option>
                                            <option value="unlimit">Unlimit</option>
                                        </select>
                                    </div>
                                </div> <!-- /col -->

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="data">Data:</label>
                                        <input type="text"
                                               name="data" 
                                               id="data"
                                               class="form-control"
                                               placeholder="Data:"
                                               autocomplete="off" 
                                            />
                                    </div>
                                </div> <!-- /col -->

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="daily_limit">Daily Limit:</label>
                                        <input type="text"
                                               name="daily_limit" 
                                               id="daily_limit"
                                               class="form-control"
                                               placeholder="Daily Limit:"
                                               autocomplete="off" 
                                            />
                                    </div>
                                </div> <!-- /col -->

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="active_hrs">Active Hours:</label>
                                        <input type="text"
                                               name="active_hrs" 
                                               id="active_hrs"
                                               class="form-control"
                                               placeholder="Active Hours:"
                                               autocomplete="off" 
                                            />
                                    </div>
                                </div> <!-- /col -->

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="free_usage">Free Usage:</label>
                                        <input type="text"
                                               name="free_usage" 
                                               id="free_usage"
                                               class="form-control"
                                               placeholder="Free Usage:"
                                               autocomplete="off" 
                                            />
                                    </div>
                                </div> <!-- /col -->

                			</div> <!-- /row -->

                			<div class="card-footer">
                				<button type="reset" class="btn btn-secondary">Reset</button>
                				<button type="submit" class="btn btn-primary">Submit</button>
                			</div>

                		</form>

                	</div> <!-- /card-body -->
                </div> <!-- /card -->
            </div>
        </div>
        <div class="clearfix"></div>
    </div> <!-- /end of page content -->
@endsection

@section('style')
  <style>
    .card-footer{
    	text-align: right;
    }
  </style>
@endsection

@section('script')
<script type="text/javascript">
   $(document).on('ready',function(){

      // filter package based on category type  
      $('#category').on('change',function(){
            var val = $.trim($(this).children("option").filter(":selected").text());
            
            if(val == 'Home-Package'){

                $('#price').removeAttr('disabled');
                $('#duration').removeAttr('disabled');
                $('#data_type').removeAttr('disabled');
                $('#data').removeAttr('disabled');
                $('#daily_limit').removeAttr('disabled');
                $('#active_hrs').removeAttr('disabled');
                $('#free_usage').removeAttr('disabled');

            }else if(val == 'Business'){

                $('#data_type').attr('disabled','disabled');
                $('#data').attr('disabled','disabled');
                $('#daily_limit').attr('disabled','disabled');
                $('#active_hrs').attr('disabled','disabled');
                $('#free_usage').attr('disabled','disabled');

            }else{

                $('#price').removeAttr('disabled');
                $('#duration').removeAttr('disabled');
                $('#data_type').removeAttr('disabled');
                $('#data').removeAttr('disabled');
                $('#daily_limit').removeAttr('disabled');
                $('#active_hrs').removeAttr('disabled');
                $('#free_usage').removeAttr('disabled');

            }

      });

      // filter based on package type
      $('#data_type').on('change',function(){
            var val = $.trim($(this).children("option").filter(":selected").text());
            
            if(val == 'Unlimit'){

                $('#data').attr('disabled','disabled');
                $('#daily_limit').attr('disabled','disabled');
                $('#active_hrs').attr('disabled','disabled');
                $('#free_usage').attr('disabled','disabled');

            }else if(val == 'limit'){

                $('#data').removeAttr('disabled');
                $('#active_hrs').removeAttr('disabled');
                $('#free_usage').removeAttr('disabled');
                $('#daily_limit').attr('disabled','disabled');

            }else if(val == 'Hybrid'){

                $('#data').removeAttr('disabled');
                $('#free_usage').removeAttr('disabled');
                $('#daily_limit').removeAttr('disabled');
                $('#active_hrs').removeAttr('disabled');

            }else{

                $('#data').removeAttr('disabled');
                $('#free_usage').removeAttr('disabled');
                $('#daily_limit').removeAttr('disabled');
                $('#active_hrs').removeAttr('disabled');
                
            }

      });

   });
</script>
@endsection