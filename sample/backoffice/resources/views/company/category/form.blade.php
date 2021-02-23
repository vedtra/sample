
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
				<label class="col-lg-3 control-label">Name</label>
				<div class="col-lg-9">
					<input type="text" name="name"  class="form-control" placeholder="Nama" value="{{(@$data->name?$data->name:old('name'))}}">
				</div>
				</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">Code</label>
				<div class="col-lg-9">
					<input type="text" name="code"  class="form-control" placeholder="Code" value="{{(@$data->code?$data->code:old('code'))}}">
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">Notes</label>
				<div class="col-lg-9">
					<textarea name="notes"  class="form-control" placeholder="About this Category">{{(@$data->notes?$data->notes:old('notes'))}}</textarea>
				</div>
				
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">Icon Image </label>
				<div class="col-lg-9">
					<input type="file" name="icon" class="file-styled" accept="image/png, image/jpeg">
					<span class="help-block">Accepted formats: gif, png, jpg. Max file size 1Mb</span>
					@if(@$data->icon)
						<img src="{{url(''.$data->icon)}}" width="120" />
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
	$("#form").submit(function( event ) {
		submitForm();	  
	  event.preventDefault();
	});
	$(document).ready(function(){
		$(".file-styled").uniform({
	        fileButtonClass: 'action btn bg-green-700'
	    });
	});
	$(document).ready(function(){
		Ladda.bind( 'button[type=submit]',{ timeout: 5000 }  );
	});
</script>