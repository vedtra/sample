

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
				<label class="col-lg-3 control-label">Description</label>
				<div class="col-lg-9">
					<textarea name="description"  class="form-control" placeholder="Deskripsi">{{(@$data->description?$data->description:old('description'))}}</textarea>
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
		Ladda.bind( 'button[type=submit]',{ timeout: 5000 }  );
	});
	
</script>