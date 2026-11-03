@extends('layouts.admin')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
  <div class="card-header text-center">
    <h5>Register Driver</h5>
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
      <form method="post" action="{{ route('admin-drivers.store') }}" enctype="multipart/form-data">
          
          <div class="form-group col-md-4">
              @csrf
                <label for="driver_id_no"><strong> Driver ID Number:</strong></label>
                <input type="text" class="form-control" name="driver_id_no" id="driver_id_no" value="D{{sprintf("%03d",$count)}}" readonly>
            </div>
            <div class="form-group col-md-4">
                <label for="title"><strong> Title:</strong></label>
                <select class=" form-control"   id="title" name="title" >
                  <option value="">select</option>
                  <option value="Mr.">Mr.</option>
                  <option value="Mrs.">Mrs.</option>
                  <option value="Alh.">Alh.</option>
                  <option value="Haj.">Haj.</option>
                  <option value="Mal.">Mal.</option>
                  <option value="Dr.">Dr.</option>
                  <option value="Prof.">Prof.</option>
              
          </select> 
            </div>
            <div class="form-group col-md-6">
                <label for="driver_name"><strong>Full Name:</strong></label>
                <input type="text" class="form-control" name="driver_name" id="driver_name">
             </div>
             <div class="form-group col-md-4">
                <label for="driver_phone"><strong> Phone Number:</strong></label>
                <input type="tel" class="form-control" name="driver_phone" id="driver_phone" maxlength="11">
             </div>

          <div class="form-group col-md-4">
              <label for="driver_address"><strong> Address:</strong></label>
              <textarea name="driver_address" id="driver_address" class="form-control"></textarea>          
          </div>

          <div class="form-group">
              <label for="photo"></label>
                <input type="file" name="image" id="image">
              </label>
          </div>

          <!-- <div class="form-group col-md-4">
            <label for="truck_id"><strong> Truck Assigned</strong></label>
              <select name="truck_id" id="truck_id" class="form-control">
                <option value=" ">Select Truck</option>
                @foreach($trucks as $truck) 
                <option value="{{$truck->id}}"> {{$truck->truck_model}} With Plate Number: {{$truck->plate_number}} </option>
                @endforeach
              </select> 
        </div> -->
        
          <button type="submit" class="btn btn-primary ">Save Record</button>
          </div>
      </form>
  </div>

@endsection