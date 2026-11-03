@extends('layouts.staff')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
  <a class="btn btn-primary" href="{{ route('trucks.index') }}"> Back</a>

  <div class="card-header text-center">
   <strong> Edit Truck Information </strong>
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
  
        <br/>
        <br/>
      <form method="post" action="{{ route('trucks.update',['truck'=>$truck->id]) }}">
                @csrf

        @method('PUT')

        
        <div class="form-group">
            <label for="truck_name"><strong> Truck Model:</strong></label>
            <input type="text" class="form-control" name="truck_model" id="truck_model" value="{{ $truck->truck_model }}">
         </div>

        <div class="form-group">
           
              <label for="truck_id_no"><strong> Plate Number:</strong></label>
              <input type="text" class="form-control" maxlength="10" name="plate_number" id="plate_number" value="{{ $truck->plate_number }}">
          </div>
          <div class="form-group col-md-4">
            <label for="driver_id_no" class="font-weight-bold">Driver Assigned</label>
              <select name="driver_id_no" id="driver_id_no" class="form-control">
                <option value=" ">Select Driver</option>
                @foreach($drivers as $driver) 
                <option value="{{$driver->driver_id_no}}"> {{$driver->driver_id_no}}  {{$driver->driver_name}} </option>
                @endforeach
              </select>
            </label>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
       
      </form>
  </div> 
</div>
<script>
  $('#unassd').onClick(function(){
      var id= $('#unassd').attr('d');
      console.log(id);
  });
</script>
@endsection