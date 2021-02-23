@extends('layouts.main')

@section('content')	<ul class="breadcrumb">
    <li><a href="{{route('home')}}">Dashboard</a></li>    
    <li class="active">{{@$bread_crumb}}</li>
</ul>
<h3 class="page_title">{{@$title}}</h3>    
<form method="post" id="form" class="form-horizontal" enctype="multipart/form-data">
    {{csrf_field()}}

    <div class="panel panel-white">
      <div class="panel-heading">
        <h5 class="panel-title">{{$title}}</h5>     
      </div>
      <div class="panel-body">
        <div class="form-group">
          <label class="col-lg-3 control-label">Old Password</label>
          <div class="col-lg-6">
            <input type="password" name="old_password"  class="form-control" >
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-3 control-label">New Password</label>
          <div class="col-lg-6">
            <input type="password" name="password"  class="form-control" >
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-3 control-label">Confirm Password</label>
          <div class="col-lg-6">
            <input type="password" name="password_confirmation"  class="form-control" >
          </div>
        </div>  
      </div>
      <div class="panel-footer">
        <div class="col-md-12">
          <div class="text-right">
                    <a href="{{url()->previous()}}" class="btn btn-primary">Back</a>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
      </div>
    </div>
</form>
<script type="text/javascript">
  function submitForm(){
    var url = '{{route("updatepasswd")}}';
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
<script type="text/javascript">
  $("#form").submit(function( event ) {
    submitForm();   
    event.preventDefault();
  });
</script>

@endsection
