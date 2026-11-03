@extends('layouts.admin')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
    <a class="btn btn-primary" href="{{ route('admin-drivers.index') }}"> Back</a>

  <div class="card-header">
    View Driver's Information


                
            
  </div>
  <div class="card-body">
  <img src="{{asset('imgs/invoiceheader.png')}}" alt="">
     <div class="row">
      
<br>

  <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>Driver ID Number:</strong>

                {{$driver->driver_id_no}}

            </div>
            <div class="">
                {{-- <img src="{{asset('Uploads/images/'.$driver->driver_image)}}" alt=""> --}}
                <img src="{{asset($driver->driver_image)}}" alt="Image" height="200" width="200">
            </div>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>Full Name:</strong>

                {{$driver->driver_name}}

            </div>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>Phone Number:</strong>

                {{$driver->driver_phone}}

            </div>

        </div>
       

        <div class="col-xs-12 col-sm-12 col-md-12">
            {{-- {{$driver}} --}}
            <div class="form-group">

                <strong>Address:</strong>
                {{$driver->driver_address}}
            </div>
        </div> 

        <div class="col-xs-12 col-sm-12 col-md-12">
           
            <div class="form-group">

                <strong>Date Registered:</strong>
                {{date('d-m-Y', strtotime($driver->created_at))}}
            </div>
        </div> 


        {{-- {{sizeof($truck)}} --}}
        @if (sizeof($truck)>0)
        {{-- {{$truck[0]}} --}}
            <div class="col-xs-12 col-sm-12 col-md-12">

                <div class="form-group">
      
                    <strong>Truck Assigned:</strong>
      
                   {{$truck[0]->truck_model}}  with Plate Number: {{$truck[0]->plate_number}} 
       
                </div>
      
            </div> 
             @else

             <div class="col-xs-12 col-sm-12 col-md-12">

                <div class="form-group">
      
                   <p class="text-info">No Truck Assigned to this driver</p>
                </div>
      
            </div> 
        @endif

{{--         <div class="col-xs-12 col-sm-12 col-md-12">

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

      </div> --}}
    </div>
    
  </div>
</div>
@endsection