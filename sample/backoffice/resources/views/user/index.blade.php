@extends('layouts.main')

@section('content')	<ul class="breadcrumb">
    <li><a href="{{route('home')}}">Dashboard</a></li>    
    <li class="active">{{@$bread_crumb}}</li>
</ul>
<h3 class="page_title">{{@$title}}</h3>    

<div id="area_form" style="display: none;">
	
</div>
<div id="area_datatable">
	<div class="row" style="margin-bottom:10px;">
        <div class="col-md-12">	
            <div class="pull-left">
                <a href="javascript:void(0)" onclick="showForm('{{route('createaccount')}}')" class="btn btn-success"><i class="icon-plus22"></i>Add New</a> 	
            </div>
        </div>
    </div>

	<div class="panel panel-flat" id="area_datatable">		
		<table class="table" id="grid">
			<thead>
				<tr>
					<th></th>
					<th>Nama</th>							
					<th>Email</th>
          <th>Role</th>
          <th>is Verified?</th>   
          <th>Action</th>       
				</tr>
			</thead>		
		</table>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {	
	function renderActionButton(id){		
		var edit_url = '{{url("account/edit")}}/'+id;
		var delete_url = '{{url("account/delete")}}/'+id;
		var action_button = '<ul class="icons-list">'+
							'<li class="dropdown">'+
								'<a href="#" class="dropdown-toggle" data-toggle="dropdown">'+
									'<i class="icon-menu9"></i>'+
								'</a>'+
								'<ul class="dropdown-menu dropdown-menu-right">'+
									'<li><a href="javascript:void(0)" onclick="showForm(\''+edit_url+'\')"><i class="icon-pencil3"></i> Edit</a></li>'+
									
                                    '<li><a href="javascript:void(0)" onclick="destroy(\''+delete_url+'\',\'Delete\')"><i class="icon-trash"></i> Delete</a></li>'+
								'</ul>'+
							'</li>'+	
						'</ul>'		
		return action_button;
	}


	$('#grid').DataTable({		
		fixedHeader: true,
		processing: true,
        serverSide: true,
		responsive: {
            details: {
                type: 'column'
            }
        },
        columnDefs: [
            {
                className: 'control',
                orderable: false,
                targets:   0
            },           
        ],
             
	  	"ajax"		: {
					    "type"   : "GET",
					    "url"    : '{{route("accountloadjson")}}',
					    "dataSrc": function (res) {
					      var json = res.data;
					      var return_data = new Array();						      				    
					      for(var i=0;i< json.length; i++){
					        return_data.push({
					          'expand': '',
					          'name'  : json[i].name,
                    'email'  : json[i].email,	
                    'role'  : json[i].role,   
                    'verified' : json[i].status,         
					          'action' : renderActionButton(json[i].id)
					        })
					      }
					      return return_data;
					    }
				  	},
	     "columns"	:[
					    {'data': 'expand'},
					    {'data': 'name'},					    
					    {'data': 'email'},
              {'data': 'role'},
              {'data': 'verified'},
                        {'data': 'action'},
					  ]
    });
});
</script>
<script type="text/javascript">
function refresh(){
	var table = $('#grid').DataTable();
	table.ajax.reload();
}
</script>
<script type="text/javascript">
function showForm(url){
	$.get(url,function(data){
		$("#area_datatable").hide();
		$("#area_form").html(data);
		$("#area_form").show();
	});
}
function close_form(){
	$("#area_form").hide();
	$("#area_form").html("");	
	$("#area_datatable").show();	
}
function submitForm(){
    var url = '{{route("saveaccount")}}';
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
               		close_form();
               		refresh();
               	}else{
               		type = "alert bg-danger alert-styled-left";
               	}
				showNotif("Information",obj_msg.message,type);
           }
         });    
   
}
function destroy(url){
	swal({
            title: "Delete Confirmation",
            text: "Are you Sure?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#EF5350",
            confirmButtonText: "Yes",
            cancelButtonText: "Back",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm){
            if (isConfirm) {
                /**Delete Data */
                $.get(url,function(data){
                    var obj_msg = jQuery.parseJSON(data);
                    var type = "alert bg-success alert-styled-left";
                    if(obj_msg.status=="success"){                        
                        swal({
                            title: "Deleted!",
                            text: "Successfull",
                            confirmButtonColor: "#66BB6A",
                            type: "success"
                        });
                        close_form();               		
                        refresh();
                    }else{
                        type = "alert bg-danger alert-styled-left";
                        swal.close();
                    }
                    showNotif("Information",obj_msg.message,type);
                });
               
            }
            else {
                swal({
                    title: "Canceled",
                    text: "Operation is canceled",
                    confirmButtonColor: "#2196F3",
                    type: "error"
                });
            }
        });	
}
</script>
@endsection
