@extends('layouts.app')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
 <a class="btn btn-primary " href="{{ route('clients.index') }}"> Back</a>
  <div class="card-header text-center">
    
<strong> View client's Information
</strong>

                
            
  </div>
  <div class="card-body">
     <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>Client's Name:</strong>

                {{$client->client_name}}

            </div>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>Phone Number:</strong>

                {{$client->client_phone}}

            </div>

        </div>
       

        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>Address:</strong>

                {{$client->client_address}}

            </div>

        </div> 
       

    </div>
    
  </div>
</div>
@endsection