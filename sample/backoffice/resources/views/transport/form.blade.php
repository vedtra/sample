
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
					<input type="text" name="name"  class="form-control" placeholder="Nama" value="{{(@$data->name?$data->name:old('name'))}}" required="required">
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-lg-3 control-label">Category</label>
				<div class="col-lg-9">
					 <select class="select" name="category" required="required">
					 	@foreach($categories as $item)
				    		<option value="{{ $item->id }}" {{(@$data->category_id==$item->id?'selected':'')}}>{{ $item->name }} </option>
				  		@endforeach
				  </select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-lg-3 control-label">Type</label>
				<div class="col-lg-9">
					 <select class="select" name="type" required="required">
					 	@foreach($types as $item)
				    		<option value="{{ $item->id }}" {{(@$data->type_id==$item->id?'selected':'')}}>{{ $item->name }} </option>
				  		@endforeach
				  </select>
				</div>
			</div>	

			<div class="form-group">
				<label class="col-lg-3 control-label">Photo </label>
				<div class="col-lg-9">
					<input type="file" name="image" class="file-styled" accept="image/png, image/jpeg">
					<span class="help-block">Accepted formats: gif, png, jpg. Max file size 2Mb</span>
					@if(@$data->image)
						<img src="{{url(''.$data->image)}}" width="120" />
					@endif
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">Qty</label>
				<div class="col-lg-9">
					<input type="number" name="qty"  class="form-control" placeholder="Qty" value="{{(@$data->qty?$data->qty:old('qty'))}}">
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">Total Stock</label>
				<div class="col-lg-9">
					<input type="number" name="total_stock"  class="form-control" placeholder="Total" value="{{(@$data->total_stock?$data->total_stock:old('total_stock'))}}">
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">Status</label>
				<div class="col-lg-9">
					<select name="status" class="form-control">
						<option value="1">Active</option>
						<option value="0" {{(@$data->is_active==0?'selected':'')}}>Non-Active</option>
					</select>
				</div>
			</div>

	</div>
		<div class="panel-footer">
			<div class="col-md-12">
				<div class="text-right">
	                <button type="button" onclick="close_form()" class="btn btn-primary">Back</button>
	                <button type="submit" onclick="submitForm()" class="btn btn-success">Save</button>
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
		Ladda.bind( 'button[type=submit]',{ timeout: 4000 }  );
	});
</script>
