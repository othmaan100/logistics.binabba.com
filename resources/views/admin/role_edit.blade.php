@extends('layouts.admin')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
  <!-- <a class="btn btn-primary" href="{{ route('users') }}"> Back</a> -->

  <div class="card-header">
 <strong>
    Edit user Information
  </strong>
  </div>
  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif

      <form method="post" action="{{ route('updateuser', $user->id) }}" enctype="multipart/form-data">
                @csrf

        @method('PUT')
 
      
          <div class="form-group">
              <label for="user_name"><strong> Full Name:</strong></label>
              <input type="text" class="form-control" name="fullName" id="fullName" value="{{ $user->fullName }}" >
           </div>
           <div class="form-group">
              <label for="user_phone"><strong> Phone Number:</strong></label>
              <input type="text" class="form-control" name="phone" id="user_phone" maxlength="11" value="{{ $user->phone }}" >
           </div>
            <div class="form-group">
              <label for="email"><strong> Email:</strong></label>
              <input type="text" class="form-control" name="email" id="email"  value="{{ $user->email }}" >
           </div>

        <div class="form-group">
            <label for="user_address "><strong> Address:</strong></label>
            <textarea name="address" id="address" class="form-control">{{ $user->address }}</textarea>
        </div>
        <div class="form-group col-md-6">
          <label for="role"><strong> Role </strong></label>
             <select name="role" id="role" class="form-control col-md-6">
                <option value=" ">Select Role</option>
                @foreach($roles as $role) 
                 
                              @if($role->id == $user->role )
                                  @$selected = "selected";
                <option value="{{$role->id}}" selected="{{$selected}}">
                           {{$role->role}}  
                    </option>
                     @endif
                       <option value="{{$role->id}}" >
                          {{$role->role}}
                    </option>

                
                @endforeach
              </select>
          </label>
      </div>
      
    
        <button type="submit" class="btn btn-primary">Update</button>
       
      </form>
  </div> 
</div>
@endsection