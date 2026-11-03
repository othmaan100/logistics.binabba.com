@extends('layouts.staff')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
  <div class="card-header text-center">
    <h5>Add Expenses Record</h5>
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
      <form method="post" action="{{ route('expenses.store') }}" enctype="multipart/form-data">
          
          <div class="form-group row">
          
              @csrf
                <label for="good_id" class="font-weight-bold col-md-2"> Good :</label>
               
                <select name="good_id" id="good_id" class="form-control col-md-6">
                    <option value=" ">Select Good</option>
                    @foreach($goods as $good) 
                    <option value="{{$good->good_id}}"> {{$good->good_id_no}} Carried By: {{$good->plate_number}} Driver: {{$good->driver_name}}   on {{date('d-m-Y',strtotime($good->good_date_of_pickup))}}</option>
                    @endforeach
                  </select>
            </div>
            <div class="form-group row">
                <label for="expenses_cost" class="font-weight-bold col-md-2">Cost:</label>
                <input type="text" class="form-control col-md-4" name="expenses_cost" id="expenses_cost">
             </div>
             <div class="form-group row">
                <label for="expenses_reason" class="font-weight-bold col-md-2"> Reason:</label>
                <textarea name="expenses_reason" class="form-control  col-md-4" id="expenses_reason" cols="30" rows="10"></textarea>
             </div>

          <div class="form-group row">
              <label for="expenses_date" class="font-weight-bold col-md-2"> Date:</label>
              <input type="date" name="expenses_date" class="form-control  col-md-4" id="expenses_date">
        </div>
          <button type="submit" class="btn btn-primary ">Save Record</button>
          </div>
      </form>
  </div>
</div>
@endsection