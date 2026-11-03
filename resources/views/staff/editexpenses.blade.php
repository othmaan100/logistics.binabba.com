@extends('layouts.staff')

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
  
    <form method="post" action="{{ route('expenses.update', $expense->expenses_id)}}">
        @csrf

        @method('PUT')
        
   

        <div class="form-group row">
          
              <!--<label for="good_id" class="font-weight-bold col-md-1"> Good ID:</label>-->
              <input type="hidden" name="good_id" id="good_id" class="form-control col-md-4" value="{{$expense->good_id}}" readonly>
          </div>
          <div class="form-group row">
              <label for="expenses_cost" class="font-weight-bold col-md-1">Cost:</label>
          <input type="text" class="form-control col-md-4" name="expenses_cost" id="expenses_cost" value="{{$expense->expenses_cost}}">
           </div>
           <div class="form-group row">
              <label for="expenses_reason" class="font-weight-bold col-md-1"> Reason:</label>
              <textarea name="expenses_reason" class="form-control  col-md-4" id="expenses_reason" cols="30" rows="10">{{$expense->expenses_reason}}</textarea>
           </div>

        <div class="form-group row">
            <label for="expenses_date" class="font-weight-bold col-md-1"> Date:</label>
            <input type="date" name="expenses_date" class="form-control  col-md-4" id="expenses_date" value="{{\Carbon\Carbon::parse($expense->expenses_date)->format('Y-m-d')}}">
      </div>
        <button type="submit" class="btn btn-primary ">Update</button>
        </div>
    </form>
  </div> 
</div>
@endsection