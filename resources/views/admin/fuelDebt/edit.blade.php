@extends('layouts.app')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
  <div class="card-header">
    Edit Expenses Information
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
  
    <form method="post" action="{{ route('fuelDebt.update', $fuelDebt->fdid)}}">

             @csrf

        @method('PUT')


       <div class="form-group row">
              @csrf
              <label for="truck_id" class="font-weight-bold col-md-3"> Truck </label>
              <select name="truck_id" id="truck_id" class="form-control col-md-4">
                <option value=" ">Select Truck</option>
                @foreach($trucks as $truck) 
                 
                              @if($truck->id == $fuelDebt->truck_id )
                                  @$selected = "selected";
                <option value="{{$truck->id}}" selected="{{$selected}}">
                           {{$truck->truck_model}} With Plate Number: {{$truck->plate_number}} 
                    </option>
                     @endif
                       <option value="{{$truck->id}}" >
                          {{$truck->truck_model}} With Plate Number: {{$truck->plate_number}} 
                    </option>

                
                @endforeach
              </select>
            </div>
            <div class="form-group row">
                <label for="company" class="font-weight-bold col-md-3">Company:</label>
                <input type="text" class="form-control col-md-4" name="company" value="{{$fuelDebt->company}}" id="company">
             </div>
             <div class="form-group row">
                <label for="diesel_cost" class="font-weight-bold col-md-3"> Diesel price (per liter):</label>
                <input type="number" class="form-control col-md-4" value="{{$fuelDebt->diesel_cost}}" name="diesel_cost" id="diesel_cost">
             </div>
            <div class="form-group row">
                <label for="liters" class="font-weight-bold col-md-3">Liter(s):</label>
                <input type="number" class="form-control col-md-4" value="{{$fuelDebt->liters}}" name="liters" id="liters">
             </div>
             
          <div class="form-group row">
              <label for="debt_date" class="font-weight-bold col-md-3"> Debt Date:</label>
              <input type="date" name="debt_date" class="form-control  col-md-4"  value="{{$fuelDebt->debt_date}}" id="debt_date">
        </div>

        <button type="submit" class="btn btn-primary ">Update</button>
        </div>
    </form>
  </div> 
</div>
@endsection