@extends('layouts.main')
@section('content')
<form method="post" id="form" class="form-horizontal" enctype="multipart/form-data">
	{{csrf_field()}}
	
	<div class="panel panel-white">
		<div class="panel-heading">
			<h5 class="panel-title">{{$title}}<a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>			
		</div>
		<input type="hidden" name="is_update" id="is_update" value="0" />
		<div class="panel-body">
			<div class="form-group">
				<label class="col-lg-3 control-label">Company Name</label>
				<div class="col-lg-9">
					 <select class="select" name="company_id" >
					 	@foreach ($companies as $item)
				    		<option value="{{ $item->id }}" {{(@$data->company_id==$item->id?'selected':'')}}>{{ $item->name }}</option>
				  		@endforeach
				  </select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">Province</label>
				<div class="col-lg-9">
					 <select class="select" name="province_id" >
					 	@foreach ($provincies as $item)
				    		<option value="{{ $item->id }}">{{ $item->name }}</option>
				  		@endforeach
				  </select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">City</label>
				<div class="col-lg-9">
					 <select class="select" name="city_id" >
					 	@foreach ($cities as $item)
				    		<option value="{{ $item->id }}">{{ $item->name }}</option>
				  		@endforeach
				  </select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">Addres</label>
				<div class="col-lg-9">
					<textarea name="address" class="form-control">
						{!! (@$data->address?$data->address:old('address'))!!}
					</textarea>
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">Website</label>
				<div class="col-lg-9">
					<input type="text" name="website"  class="form-control" placeholder="Website" value="{{(@$data->website?$data->website:old('website'))}}">
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">Contact 1</label>
				<div class="col-lg-9">
					<input type="text" name="contact_01"  class="form-control" placeholder="Contact 1" value="{{(@$data->contact_01?$data->contact_01:old('contact_01'))}}">
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">Contact 2</label>
				<div class="col-lg-9">
					<input type="text" name="contact_02"  class="form-control" placeholder="Contact 2" value="{{(@$data->contact_02?$data->contact_02:old('contact_02'))}} ">
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">Bank Name</label>
				<div class="col-lg-9">
					<input type="text" name="bank_name"  class="form-control" placeholder="bank name" value="{{(@$data->bank_name?$data->bank_name:old('bank_name'))}}">
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">Bank Account</label>
				<div class="col-lg-9">
					<input type="text" name="bank_account"  class="form-control" placeholder="bank account" value="{{(@$data->bank_account?$data->bank_account:old('bank_account'))}}">
				</div>
			</div>




		</div>
		<div class="panel-footer">
			<div class="col-md-12">
				<div class="text-right">
	               
	                <button type="submit" onclick="submitForm()" class="btn btn-success">Save Changes</button>
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


<script type="text/javascript">
function submitForm(){
    var url = '{{route("savesetupcompany")}}';
    var formData = new FormData($("#form")[0]);
    $.ajax({
           type: "POST",
           url: url,
           contentType: false,
           processData: false,
           data: formData, // serializes the form's elements.
           success: function(data)
           {
              var obj_msg = jQuery.parseJSON(data);
                var type = "alert bg-success alert-styled-left";
                if(obj_msg.status=="success"){
                 
                }else{
                  type = "alert bg-danger alert-styled-left";
                }
        showNotif("Information",obj_msg.message,type);
           }
         });    
   
}
</script>
@endsection