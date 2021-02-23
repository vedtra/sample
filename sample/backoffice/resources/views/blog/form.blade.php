
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
				<label class="col-lg-3 control-label">SEO Title</label>
				<div class="col-lg-9">
					<input type="text" name="seo_title"  class="form-control" placeholder="Seo Title" value="{{(@$data->seo_title?$data->seo_title:old('seo_title'))}}">
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
						<img src="{{url(''.$data->thumbnail)}}" width="120" />
					@endif
				</div>
			</div>

			
			<div class="form-group">
				<label class="col-lg-3 control-label">Status</label>
				<div class="col-lg-9">
					<select name="status" class="form-control">
						<option value="0">Draft</option>
						<option value="1" {{(@$data->is_active==1?'selected':'')}}>Published</option>
						<option value="2" {{(@$data->is_active==2?'selected':'')}}>UnPublished</option>
					</select>
				</div>
			</div>

			<div class="col-md-6">
                <div class="form-group">
                    <label>Date Published</label>                    
                    <div class="input-group">
                        <span class="input-group-addon"><i class="icon-calendar22"></i></span>
                        <input type="text" name="demo_date" class="form-control daterange-single" value="{{(@$data->demo_date?date('m/d/Y H:i:a',strtotime($data->demo_date)):old('demo_date'))}}">
                    </div>
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
	$("#form").submit(function( event ) {
		submitForm();	  
	  event.preventDefault();
	});
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
    var today = new Date(); 
    var dd = today.getDate(); 
    var mm = today.getMonth()+1; //January is 0! 
    var yyyy = today.getFullYear(); 
    if(dd<10){ dd='0'+dd } 
    if(mm<10){ mm='0'+mm } 
    var today = mm+'/'+dd+'/'+yyyy;
    $(document).ready(function(){
        $('.daterange-single').daterangepicker({            
            singleDatePicker: true,
            timePicker: true,
            minDate: today,
            applyClass: 'bg-slate-600',
            cancelClass: 'btn-default',
            locale: {
                format: 'MM/DD/YYYY h:mm a'
            }
        });

    });
</script>