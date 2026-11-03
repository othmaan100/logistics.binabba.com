@extends('layouts.app')

@section('content')
<style>
   
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
   

  <div class="card-header">
    View Good's Information


               
            
  </div>
  <div class="card-body">
  <img src="{{asset('imgs/invoiceheader.png')}}" alt="">
     <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class=" col-md-4">
            

                <strong>Good ID Number:</strong>

                {{$good[0]->good_id_no}}

            </div>
             <div class=" col-md-4">
            

                <strong>Client Name:</strong>

                {{$good[0]->client_name}}

            </div>
             <div class=" col-md-4">
            

                <strong>Driver Name:</strong>

                {{$good[0]->driver_name}}

            </div>
            <div class=" col-md-4">
            

                <strong>Truck:</strong>

                {{$good[0]->truck_model}}

            </div>
            <div class=" col-md-4">
            

                <strong>Plate Number:</strong>

                {{$good[0]->plate_number}}

            </div>

            <div class=" col-md-4">

                <strong>Good Type:</strong>

                {{$good[0]->good_type}}

            </div>
            <div class=" col-md-4">

                <strong>Good Weight:</strong>

                {{$good[0]->good_weight}} Tones

            </div>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class=" col-md-4">

                <strong>Good Cost:</strong>

               ₦ {{number_format($good[0]->good_cost,2)}}

            </div>

            <div class=" col-md-4">

                <strong>Diseal Cost:</strong>

                ₦{{number_format($good[0]->diesel_cost,2)}}

            </div>
            <div class=" col-md-4">

                <strong>Commision:</strong>

               ₦ {{number_format($good[0]->good_cost*.1,2)}}

            </div>

        </div>

        

        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class=" col-md-4">

                <strong>Road Expenses:</strong>

               ₦{{number_format($good[0]->road_expenses,2)}}

            </div>
            <div class=" col-md-4">

                <strong>PickUp Point:</strong>

                {{$good[0]->good_pickup_point}}

            </div>
            <div class=" col-md-4">

                <strong>Delivery Point:</strong>

                {{$good[0]->good_delivery_point}}

            </div>

        </div>
       

     

            <div class=" col-md-4">

                <strong>Delivery Date:</strong>

                {{$good[0]->good_date_of_delivery}}

            </div>

       
    </div>
    
  </div>
 <!-- <a class="btn btn-primary" href="">Download PDF</a>-->
 

</div>
@endsection