@extends('layouts.app')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
  <a class="btn btn-primary" href="{{ route('trucks.index') }}"> Back</a>

  <div class="card-header">
    <h5>Truck Information


               </h5>
            
  </div>
  <div class="card-body">
     <div class="row">
      {{$truck->driver}}
  <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>Truck Plate Number:</strong>

                {{$truck->plate_number}}

            </div>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>Truck Model:</strong>

                {{$truck->truck_model}}

            </div>

        </div>

        

        </div> 
    </div>
    
  </div>
</div>
@endsection