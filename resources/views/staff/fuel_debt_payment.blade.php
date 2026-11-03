@extends('layouts.staff')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
  <div class="card-header text-center">
    <h5>Add Fuel Debt Payment Record</h5>
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
    <div class="flex">
      
      <h3 class="text-center">Payment for {{$filling_station->company_name}}</h3>
    </div>
      <form method="post" action="{{ route('fuelDebts.pstore') }}" enctype="multipart/form-data">
          
          <div class="form-group row">
              <label for="balance" class="font-weight-bold col-md-3">Current Balance:</label>
              <input type="text" class="form-control col-md-4" value="₦{{number_format($filling_station->balance,2)}}" name="dbalance" id="dbalance" readonly="">
              <input type="hidden" name="balance" value="{{$filling_station->balance}}">
               <input type="hidden" name="company_id" value="{{$filling_station->company_id}}">
            </div>

          <div class="form-group row">
              @csrf
              <label for="payment_method" class="font-weight-bold col-md-3"> Payment Method</label>
              <select name="payment_method" id="payment_method" class="form-control col-md-4">
                <option value="">Select Payment Method</option>
                <option>Cash Payment</option>
                <option>Transfer Payment</option>
              </select>
            </div>

            

          <div class="form-group row">
              <label for="payer" class="font-weight-bold col-md-3">Payer:</label>
              <input type="text" class="form-control col-md-4" name="payer" id="payer">
            </div>



             <div class="form-group row">
                <label for="diesel_cost" class="font-weight-bold col-md-3"> Amount Paid:</label>
                <input type="number" class="form-control col-md-4" name="amount_paid" id="amount_paid">
             </div>

             <div class="form-group row">
              <label for="payment_date" class="font-weight-bold col-md-3"> Payment Date:</label>
              <input type="date" name="payment_date" class="form-control  col-md-4" id="payment_date">
        </div>
            
       
          <button type="submit" class="btn btn-primary ">Save Record</button>
          </div>
      </form>
  </div>
</div>
@endsection

