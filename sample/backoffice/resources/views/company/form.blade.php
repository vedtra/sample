
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
					<textarea name="description" class="form-control">{{(@$data->description?$data->description:old('description'))}}</textarea>
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">Logo </label>
				<div class="col-lg-9">
					<input type="file" name="logo" class="file-styled" accept="image/png, image/jpeg">
					<span class="help-block">Accepted formats: gif, png, jpg. Max file size 2Mb</span>
					@if(@$data->logo)
						<img src="{{url(''.$data->logo)}}" width="120" />
					@endif
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">Banner </label>
				<div class="col-lg-9">
					<input type="file" name="banner" class="file-styled" accept="image/png, image/jpeg">
					<span class="help-block">Accepted formats: gif, png, jpg. Max file size 2Mb</span>
					@if(@$data->banner)
						<img src="{{url(''.$data->banner)}}" width="120" />
					@endif
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">Category</label>
				<div class="col-lg-9">
					 <select class="select" name="category_id" >
					 	@foreach ($categories as $item)
				    		<option value="{{ $item->id }}" {{(@$data->category_id==$item->id?'selected':'')}}>{{ $item->name }} </option>
				  		@endforeach
				  </select>
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
		$('.select').select2();
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