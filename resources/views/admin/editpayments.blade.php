@extends('layouts.admin')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
  
</style>
<div class="card uper">
  <div class="card-header">
    Update payment
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
 {{-- {{$payment}} --}}
        
   
      <form method="post" action="{{ route('admin-payments.update', ['admin_payment' => $payment->payment_id]) }}">
               @csrf

        @method('PUT')
 
        <div class="form-group">
           
              <label for="payment_id_no">Payment ID Number:</label>
              <input type="text" class="form-control" name="payment_id_no" id="payment_id_no" value="{{ $payment->payment_id_no }}" readonly>
          </div>

          <div class="form-group">
              {{-- <label for="good_id">Good ID:</label> --}}
              <input type="hidden" class="form-control" name="payment_id" id="payment_id" value="{{ $payment->payment_id}}" readonly>
              <input type="hidden" class="form-control" name="good_id" id="good_id" value="{{ $payment->good_id}}" readonly>
           </div>
           <div class="form-group">
            {{-- <label for="client_id">Client ID:</label> --}}
            <input type="hidden" class="form-control" name="client_id" id="client_id" value="{{ $payment->client_id }}" readonly>
         </div>
           <div class="form-group">
              <label for="payment_deposit">Payment Deposit:</label>
              <input type="number" class="form-control" name="payment_deposit" id="payment_deposit"  >
           </div>
        <button type="submit" class="btn btn-primary">Update</button>
       
      </form>
  </div> 
</div>
@endsection