@extends('layouts.admin')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
  <a class="btn btn-primary" href="{{ route('admin-drivers.index') }}"> Back</a>

  <div class="card-header">
 <strong>
    Edit driver Information
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

   
 
      <form method="post" action="{{ route('admin-drivers.update', ['admin_driver'=>$driver->driver_id]) }}" enctype="multipart/form-data">
                @csrf

        @method('PUT')
 
        <div class="form-group">
           
              <label for="driver_id_no"><strong> ID Number:</strong></label>
              <input type="text" class="form-control" name="driver_id_no" id="driver_id_no" value="{{ $driver->driver_id_no }}" readonly>
          </div>

          <div class="form-group">
              <label for="driver_name"><strong> Name:</strong></label>
              <input type="text" class="form-control" name="driver_name" id="driver_name" value="{{ $driver->driver_name }}">
           </div>
           <div class="form-group">
              <label for="driver_phone"><strong> Phone Number:</strong></label>
              <input type="text" class="form-control" name="driver_phone" id="driver_phone" maxlength="11" value="{{ $driver->driver_phone }}">
           </div>

        <div class="form-group">
            <label for="driver_address "><strong> Address:</strong></label>
            <textarea name="driver_address" id="driver_address" class="form-control">{{ $driver->driver_address }}</textarea>
        </div>
        <div class="form-group col-md-4"> 
          <label for="truck_id"><strong>Truck Assigned</strong></label> 
          <select name="truck_id" id="truck_id" class="form-control" readonly> 
            <option value="">Select Truck</option> 
              @foreach($trucks as $truck) 
              <option value="{{ $truck->id }}" {{ $truck->id == $driver->id ? 'selected' : '' }}> {{ $truck->truck_model }} With Plate Number: {{ $truck->plate_number }} </option>
               @endforeach </select> 
        </div>
      
      <div class="form-group">
        <label for="photo"></label>
          <input type="file" name="image" id="image">
        </label>
    </div>

        <button type="submit" class="btn btn-primary">Update</button>
       
      </form>
  </div> 
</div>
@endsection