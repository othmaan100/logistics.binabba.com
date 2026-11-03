@extends('layouts.staff')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
  <!-- <a class="btn btn-primary" href="{{ route('users') }}"> Back</a> -->

  <div class="card-header">
 
    Update/Change user Password
 
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
 
      <form method="post" action="{{ route('users.pupdate', $user->id) }}" enctype="multipart/form-data">
                @csrf

        @method('PUT')
 
      
          <div class="form-group row">
          <div class="col-md-4">
              <label for="user_name"><strong> Full Name:</strong></label>
              <input type="text" class="form-control" name="fullName" id="fullName" value="{{ $user->fullName }}" readonly="">
           </div>
           <div class="col-md-4">
              <label for="user_phone"><strong> Phone Number:</strong></label>
              <input type="text" class="form-control" name="phone" id="user_phone" maxlength="11" value="{{ $user->phone }}" readonly="">
           </div>
            <div class="col-md-4">
              <label for="email"><strong> Email:</strong></label>
              <input type="text" class="form-control" name="email" id="email"  value="{{ $user->email }}" readonly="">
           </div>
           </div>
           <div class="form-group row">
        <div class="col-md-8">
            <label for="user_address "><strong> Address:</strong></label>
            <textarea name="address" id="address" class="form-control" readonly="">{{ $user->address }}</textarea>
        </div>
        <div class="col-md-4">
          <label for="role"><strong> Role </strong></label>
          <select name="role" id="role" class="form-control col-md-6" readonly>
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
          
      </div>
      </div>

       <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
      
    
        <button type="submit" class="btn btn-primary">Update</button>
       
      </form>
  </div> 
</div>
@endsection