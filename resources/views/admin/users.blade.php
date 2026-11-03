@extends('layouts.admin')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
  body{
    counter-reset: Serial;  /*set the serial counter to zero*/
  }
  table{
    border-collapse: collapse;
  }
  tr td:first-child::before{
    counter-increment: Serial;
    content: counter(Serial);
  }
</style>

  <div class="card uper">

  <div class="card-header">
  


  <div class="d-flex justify-content-between"> 
  <div class="p-2 bd-highlight">
       <a class="btn btn-primary" href="{{ route('createuser') }}"> <strong> Add New User <i class="fa fa-fw fa-user"> </i></strong></a>
  
  </div>
 <div class="p-2 bd-highlight">
    <!-- <a align="right" class="btn btn-primary pull-right md-offet-6 b"  href="{{ route('users.active') }}">  Active Users  </a>
    <a align="right" class="btn btn-primary pull-right md-offet-6 b"  href="{{ route('users.inactive') }}">  Inactive Users  </a> -->

 </div>

   </div>

    <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
      <li class="nav-item">
          <a class="nav-link active" id="one-tab" data-toggle="tab" href="#one" role="tab" aria-controls="One" aria-selected="true">Active Users</a>
      </li>
      <li class="nav-item">
          <a class="nav-link" id="two-tab" data-toggle="tab" href="#two" role="tab" aria-controls="Two" aria-selected="false">Inactive Users</a>
      </li>
    </ul>

  </div>
 
  <div class="card-body">
    @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}  
    </div><br />
  @endif

  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active " id="one" role="tabpanel" aria-labelledby="one-tab">
 @if (count($users)>0)
  

     <div class="table-responsive">
     <table class="table table-bordered " >
   <thead>
        <tr>
          <th>SN</th>
          <th>Full Name</th>
          <th>Phone Number</th>
          <th>Email </th>
          <th>Role</th>
          
          <th colspan="4" class="text-center">Action</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
          <th>SN</th>
          <th>Full Name</th>
          <th>Phone Number</th>
          <th>Email </th>
          <th>Role</th>
          <th colspan="4" class="text-center">Action</th>
        </tr>
    </tfoot>
    <tbody>
        @foreach($users as $user)
        <tr>
          <td></td>
            <td>{{$user->fullName}}</td>
             <th>{{$user->phone}}</th>
            <th>{{$user->email }}</th>
            <td>{{$user->user_role}}</td>
             <td><a href="{{ route('users.redit',$user->id)}}" class="btn btn-primary">Update Record <i class="fa fa-fw fa-edit"> </i></a></td>
            <td><a href="{{ route('users.pedit',$user->id)}}" class="btn btn-success">Update Password <i class="fa fa-fw fa-edit"> </i></a></td>
            <td><a class="btn btn-danger" id="d" d="{{$user->id}}" href="{{ route('users.deactivate',$user->id) }}" onclick="return confirm('Are You Sure To Deactivate this user?')">Deactivate  <i class="fa fa-fw fa-power-off"> </i></a></td>
             </tr>
        @endforeach
    </tbody>
  </table>
  </div>
  @else
     <p class="text-info">No Additional Active User  </p>
  @endif 
    </div>

    <div class="tab-pane fade " id="two" role="tabpanel" aria-labelledby="two-tab">
      @if (count($inactive)>0)
     
    <div class="table-responsive">
     <table class="table table-bordered " >
   <thead>
        <tr>
          <th>SN</th>
          <th>Full Name</th>
          <th>Phone Number</th>
          <th>Email </th>
          <th>Role</th>
          
          <th colspan="4" class="text-center">Action</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
          <th>SN</th>
          <th>Full Name</th>
          <th>Phone Number</th>
          <th>Email </th>
          <th>Role</th>
          <th colspan="4" class="text-center">Action</th>
        </tr>
    </tfoot>
    <tbody>
        @foreach($inactive as $iuser)
        <tr>
          <td></td>
            <td>{{$iuser->fullName}}</td>
             <th>{{$iuser->phone}}</th>
            <th>{{$iuser->email }}</th>
            <td>{{$iuser->user_role}}</td>
            <td><a href="{{ route('users.activate',$iuser->id)}}" class="btn btn-success" onclick="return confirm('Are You Sure To Activate this user?')">Activate <i class="fa fa-fw fa-power-off"> </i></a></td>
            </tr>
        @endforeach
    </tbody>
  </table>
  </div>
  @else
     <p class="text-info">No Inactive User</p>
  @endif 
    </div>


  </div>
  <div class="col-offset-9">
    <span class="fa-pull-right">
      <!-- Help in giving out links for paginated data-->
    </span>
    
    </div>

</div>
</div>
  <script>
    $(document).ready(function(){
    
    // haddling the post for adding record
    $('#d').click(function(){
     // alert('You don click am');
        var id = $('#d').attr('d');
       console.log(id);
        var _token= $('input[name="_token"]').val();
    
         
      // var datas="good_id="+good_id+"&_token="+_token;
    // alert(datas);  
        //action
        $.ajax({
        type: "POST",
        url: "{{ route('users.deactivate', $user->id) }}",
        data: datas,
        success:function(data){
    
                $('#myModal').modal('hide');
                location.reload();
    
        },
        error: function(xhr,status,error){
           var errrmsg=xhr.status+ ': '+xhr.statusText;
            alert('Eror-'+ errrmsg);
  }
        }); 
    
    });

  
    });

</script>
@endsection