
<form method="post" id="form" class="form-horizontal" enctype="multipart/form-data">
	{{csrf_field()}}
	<input type="hidden" name="id" value="{{(@$data?$data->id:0)}}">
	<div class="panel panel-white">
		<div class="panel-heading">
			<h5 class="panel-title">{{$title}}<a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>			
		</div>
		<input type="hidden" name="is_update" id="is_update" value="0" />
		<div class="panel-body">
			<div class="form-group">
					<label class="col-lg-3 control-label">Title</label>
				<div class="col-lg-9">
					<input type="text" name="title"  class="form-control" placeholder="Title" value="{{(@$data->title?$data->title:old('title'))}}">
				</div>
			</div>

			<div class="form-group">
					<label class="col-lg-3 control-label">Type</label>
				<div class="col-lg-9">
					<input type="text" name="type"  class="form-control" placeholder="Type" value="{{(@$data->type?$data->type:old('type'))}}">
				</div>
			</div>

			<div class="form-group">
					<label class="col-lg-3 control-label">Code</label>
				<div class="col-lg-9">
					<input type="text" name="code"  class="form-control" placeholder="Code" value="{{(@$data->code?$data->code:old('code'))}}">
				</div>
			</div>


			<div class="form-group">
					<label class="col-lg-3 control-label">Min Payment</label>
				<div class="col-lg-9">
					<input type="number" name="min_payment"  class="form-control" placeholder="Minimal Payment" value="{{(@$data->min_payment?$data->min_payment:old('min_payment'))}}">
				</div>
			</div>

			
                <div class="form-group">
                    <label class="col-lg-3 control-label">Active From - Until</label>
                    <div class="col-lg-9">                    
                    <div class="input-group">
                        <span id="startdate"class="input-group-addon"><i class="icon-calendar22"></i></span>
                        <input type="text" name="date_range" class="form-control daterange-single" value="{{(@$data->start_date?date('m/d/Y',strtotime($data->start_date)).' - '.date('m/d/Y',strtotime($data->end_date)):old('start_date'))}}">
                    </div>
                    </div>
                </div>

            
			<div class="form-group">
				<label class="col-lg-3 control-label">Company</label>
				<div class="col-lg-9">
					 <select class="select" name="company" required="required">
					 	@foreach($companies as $item)
				    		<option value="{{ $item->id }}" {{(@$data->company_id==$item->id?'selected':'')}}>{{ $item->name }} </option>
				  		@endforeach
				  </select>
				</div>
			</div>
		

			<div class="form-group">
				<label class="col-lg-3 control-label">Content</label>
				<div class="col-lg-9">	
					<textarea name="content" class="summernote">{!! (@$data->content?$data->content:old('content'))!!}</textarea>
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">Thumbnail Image </label>
				<div class="col-lg-9">
					<input type="file" name="thumbnail" class="file-styled" accept="image/png, image/jpeg">
					<span class="help-block">Accepted formats: gif, png, jpg. Max file size 2Mb</span>
					@if(@$data->thumbnail)
						<img src="{{url(''.$data->thumbnail	)}}" width="120" />
					@endif
				</div>
			</div>

		</div>
		<div class="panel-footer">
			<div class="col-md-12">
				<div class="text-right">
	                <button type="button" onclick="close_form()" class="btn btn-primary">Back</button>
	                <button type="submit" class="btn btn-success btn-ladda btn-ladda-spinner" data-style="expand-left" data-spinner-color="#333" data-spinner-size="20"><span class="ladda-label">Save</span></button>
	            </div>
	        </div>
		</div>
	</div>
</form>
<script type="text/javascript">
	$(document).ready(function() {

	$('.summernote').summernote({
		height: 200,
	});
	$(document).ready(function(){
		$(".file-styled").uniform({
	        fileButtonClass: 'action btn bg-green-700'
	    });
	});
	$(document).ready(function(){
		Ladda.bind( 'button[type=submit]',{ timeout: 5000 }  );
	});
});

</script>

<script type="text/javascript">
	$("#form").submit(function( event ) {
		submitForm();	  
	  event.preventDefault();
	});
	$(document).ready(function(){
		$('.select').select2();
	});
	$(document).ready(function(){
		$(".file-styled").uniform({
	        fileButtonClass: 'action btn bg-green-700'
	    });
	});

	$(document).ready(function(){
		Ladda.bind( 'button[type=submit]',{ timeout: 4000 }  );
	});

	var today = new Date(); 
    var dd = today.getDate(); 
    var mm = today.getMonth()+1; //January is 0! 
    var yyyy = today.getFullYear(); 
    if(dd<10){ dd='0'+dd } 
    if(mm<10){ mm='0'+mm } 
    var today = mm+'/'+dd+'/'+yyyy;
    $(document).ready(function(){
        $('.daterange-single').daterangepicker({            
            singleDatePicker: false,
            timePicker: false,
            minDate: today,
            applyClass: 'bg-slate-600',
            cancelClass: 'btn-default',
            locale: {
                format: 'MM/DD/YYYY'
            }
        });
        
    });
</script>

