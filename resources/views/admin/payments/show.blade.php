@extends('layouts.app')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
  <div class="card-header">
    View Payment Information


                <a class="btn btn-primary" href="{{ route('payments.index') }}"> Back</a>

            
  </div>
  <div class="card-body">
     <div class="row">

  <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>payment ID Number:</strong>

                {{$payment->payment_id_no}}

            </div>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>Payment Amount:</strong>

                {{$payment->payment_amount}}

            </div>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>Amount Deposited:</strong>

                {{$payment->payment_deposit}}

            </div>

        </div>
       
    </div>
    
  </div>
</div>
@endsection