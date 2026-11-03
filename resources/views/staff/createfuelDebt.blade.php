@extends('layouts.staff')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
  <div class="card-header text-center">
    <h5>Add Fuel Debt Record</h5>
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
      <form method="post" action="{{ route('fuelDebts.store') }}" enctype="multipart/form-data">
          
          <div class="form-group row">
              @csrf
              <label for="truck_id" class="font-weight-bold col-md-3"> Truck </label>
              <select name="truck_id" id="truck_id" class="form-control col-md-4">
                <option value=" ">Select Truck</option>
                @foreach($trucks as $truck) 
                <option value="{{$truck->id}}"> {{$truck->truck_model}} With Plate Number: {{$truck->plate_number}} </option>
                @endforeach
              </select>
            </div>

             <div class="form-group row">
             
              <label for="company" class=" font-weight-bold col-md-3">Company:</label>
              <select class="form-control col-md-3" name="company" id="company" >
              <option >Select Company:</option>
              @foreach($companies as $company) 
                <option value="{{$company->company_id}}"> {{$company->company_name}} </option>
                @endforeach
                 <option value="Others">Not Listed</option>   
              </select>
                <label for="ocompany" class="font-weight-bold col-md-2">Company (If Not Listed):</label>
                <input type="text" class="form-control col-md-3" name="ocompany" id="ocompany">
            </div>





             <div class="form-group row">
                <label for="diesel_cost" class="font-weight-bold col-md-3"> Diesel price (per liter):</label>
                <input type="number" class="form-control col-md-4" name="diesel_cost" id="diesel_cost">
             </div>
            <div class="form-group row">
                <label for="liters" class="font-weight-bold col-md-3">Liter(s):</label>
                <input type="number" class="form-control col-md-4" name="liters" id="liters">
             </div>
             
          <div class="form-group row">
              <label for="debt_date" class="font-weight-bold col-md-3"> Debt Date:</label>
              <input type="date" name="debt_date" class="form-control  col-md-4" id="debt_date">
        </div>
        
          <button type="submit" class="btn btn-primary ">Save Record</button>
          </div>
      </form>
  </div>
</div>
@endsection

