@extends('layouts.staff')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
  <div class="card-header text-center">
  <h5>  Register Truck</h5>
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
      <form method="post" action="{{ route('trucks.store') }}">
          
          <div class="form-group col-md-4">
              @csrf
              <strong></strong>
                <label for="truck_model" > <strong>Truck Model:</strong></label>
                <input type="text" class="form-control" name="truck_model" id="truck_model">
            </div>
            <div class="form-group col-md-4">
                <label for="plate_number" class="font-weight-bold"></strong>Plate Number:<strong></label>
                <input type="text" class="form-control" name="plate_number" id="plate_number" />
            </div>
             <div class="form-group col-md-4">
                <label for="plate_number" class="font-weight-bold"></strong>Purchased Price:<strong></label>
                <input type="number" class="form-control" name="truck_price" id="truck_price" />
            </div>
        <!--     <div class="form-group col-md-4">
              <label for="driver_id" class="font-weight-bold">Driver Assigned</label>
                <select name="driver_id" id="driver_id" class="form-control">
                  <option value=" ">Select Driver</option>
                  @foreach($drivers as $driver) 
                  <option value="{{$driver->driver_id_no}}"> {{$driver->driver_id_no}}  {{$driver->driver_name}} </option>
                  @endforeach
                </select>
              </label>
          </div> -->
           
          <button type="submit" class="btn btn-primary">Save Record</button>
      </form>
  </div>
</div>
@endsection



<script>
         jQuery(document).ready(function(){
            jQuery('#ajaxSubmit').click(function(e){
               e.preventDefault();
               $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                  }
              });
               jQuery.ajax({
                  url: "{{ route('admin-trucks.store') }}",
                  method: 'post',
                  data: {
                    truck_model: jQuery('#truck_model').val(),
                    plate_number: jQuery('#plate_number').val(),
                     
                  },
                  success: function(result){
                     console.log(result);
                  }});
               });
            });
</script>