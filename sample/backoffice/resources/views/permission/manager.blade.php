@extends('layouts.main')

@section('content')	
<script type="text/javascript" src="{{url('assets/js/plugins/forms/styling/uniform.min.js')}}"></script>        
<ul class="breadcrumb">
    <li><a href="{{route('home')}}">Dashboard</a></li>    
    <li class="active">{{@$bread_crumb}}</li>
</ul>
<h3 class="page_title">{{@$title}}</h3>    
<div class="panel panel-white">
    <div class="panel-heading">
      <h5 class="panel-title">Settings</h5>     
    </div>
    <div class="panel-body">
      <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th class="bg-slate-800">Permission</th>
                @foreach(@$roles as $role)
                  <th>
                    {{$role->name}}
                  </th>
                @endforeach
              </tr>
            </thead>
            <tbody>
              @foreach(@$permission as $item)
                <tr>
                  <td class="bg-grey-300">{{$item->name}}</td>
                  @foreach($roles as $role)
                  <td>
                    <label class="checkbox-inline" style="margin-top: -20px;">
                        <input type="checkbox" class="styled-check" data-permission="{{$item->id}}" data-role="{{$role->id}}" {{($role->hasPermissionTo($item->name)?'checked':'')}}/>                                      
                    </label>
                  </td>
                  @endforeach
                </tr>
              @endforeach
            </tbody>
        </table>
      </div>
    </div>
</div>
<script type="text/javascript">
  function savePermission(permission_id,role_id){
    var url = "{{url('permission/manager')}}"+"?role="+role_id+"&permission="+permission_id;
    $.post(url,function(data){
        var obj_msg = jQuery.parseJSON(data);
        var type = "alert bg-success alert-styled-left";
        if(obj_msg.status=="error"){                        
            type = "alert bg-danger alert-styled-left";
        }
        showNotif("Information",obj_msg.message,type);
    });
  }  
</script>

<script type="text/javascript">
  $(document).ready(function(){
      $(".styled-check").uniform();
      $(".styled-check").click(function(){
        var permission = $(this).attr('data-permission');
        var role = $(this).attr('data-role');
        savePermission(permission,role);
      });
  });

</script>
@endsection
