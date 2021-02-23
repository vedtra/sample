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
				<label class="col-lg-3 control-label">Senin</label>
				<div class="col-lg-9">
					<select name="senin" class="form-control">
						<option value="1">Ya</option>
						<option value="0" >Tidak</option>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">Selasa</label>
				<div class="col-lg-9">
					<select name="selasa" class="form-control">
						<option value="1">Ya</option>
						<option value="0" >Tidak</option>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">Rabu</label>
				<div class="col-lg-9">
					<select name="rabu" class="form-control">
						<option value="1">Ya</option>
						<option value="0" >Tidak</option>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">Kamis</label>
				<div class="col-lg-9">
					<select name="kamis" class="form-control">
						<option value="1">Ya</option>
						<option value="0" >Tidak</option>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">jumat</label>
				<div class="col-lg-9">
					<select name="jumat" class="form-control">
						<option value="1">Ya</option>
						<option value="0" >Tidak</option>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">Sabtu</label>
				<div class="col-lg-9">
					<select name="sabtu" class="form-control">
						<option value="1">Ya</option>
						<option value="0" >Tidak</option>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">Minggu</label>
				<div class="col-lg-9">
					<select name="minggu" class="form-control">
						<option value="1">Ya</option>
						<option value="0" >Tidak</option>
					</select>
				</div>
			</div>

			<div class="form-group">
					<label class="col-lg-3 control-label">Start</label>
				<div class="col-lg-9">
					<input type="time" name="start_at"  class="form-control" placeholder="Jam" value="">
				</div>
			</div>

			<div class="form-group">
					<label class="col-lg-3 control-label">End</label>
				<div class="col-lg-9">
					<input type="time" name="endt_at"  class="form-control" placeholder="jam" value="">
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
		event.preventDefault();
		var url = '{{route("savesetupoperational")}}';
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

@endsection