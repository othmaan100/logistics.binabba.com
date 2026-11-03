@extends('layouts.app')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
  <a class="btn btn-primary" href="{{ route('goods.index') }}"> Back</a>

  <div class="card-header">
    Edit Good Information
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
  
   
      <form method="post" action="{{ route('goods.update', $good->good_id) }}">
                @csrf

        @method('PUT')
 
        <div class="form-group">
           
              <label for="good_id_no">Good ID Number:</label>
              <input type="text" class="form-control" name="good_id_no" id="good_id_no" value="{{ $good->good_id_no }}" readonly="">
          </div>

         

          <div class="row">
          <div class="form-group col-md-5 " id="drid">
            <label for="truck" class="font-weight-bold">Truck:</label>
            <input type="text" class="form-control" name="truck" id="truck"  value="{{$trucks->truck_model}} with Plate Nummber: {{$trucks->plate_number}} " readonly/>
        </div>
            <div class="form-group col-md-3 " id="drid">
            <label for="driver_id_no" class="font-weight-bold">Driver Name:</label>
            <input type="text" class="form-control" name="" id=""  value="{{$driver_name}}" readonly/>
          </div>
          </div>

            <div class="row">
 
             <div class="form-group col-md-3 ">
              <label for="good_type">Good Type:</label>
              <input type="text" class="form-control" name="good_type" id="good_type" value="{{ $good->good_type }}">
           </div>
           <div class="form-group col-md-2">
              <label for="good_weight" class="font-weight-bold"> Weight(Tones): </label>
                <input type="text" class="form-control" name="good_weight" id="good_weight" value="{{ $good->good_weight }}">
          </div>
          <div class="form-group col-md-4">
              <label for="good_cost" class="font-weight-bold"> Cost of Good:</label>
              <input type="text" class="form-control" name="good_cost" value="{{ $good->good_cost }}" id="good_cost" />
          </div>

          <div class="form-group col-md-3">
            <label for="commission" class="font-weight-bold"> Commission: </label>
              <select name="commission" id="commission" class="form-control" required>
                <option value="">Select Type</option>
                <option value="0">  No </option>
                <option value="1">  Yes </option>
               
              </select>
            </label>
        </div>


          </div>
       
         
      <div class="row">
       <div class="form-group col-md-3">
            <label for="diesel_cost" class="font-weight-bold">Diesel Cost per liter:</label>
            <input type="text" class="form-control" name="diesel_cost" value="{{ $good->diesel_cost }}" id="diesel_cost">
        </div>
        <div class="form-group col-md-2">
            <label for="liters" class=" font-weight-bold">liters:</label>
            <input type="text" class="form-control" name="liters" value="{{ $good->liters }}" id="liters">
        </div>
        <div class="form-group col-md-4">
          <label for="road_expenses" class=" font-weight-bold">Road Expenses:</label>
          <input type="text" class="form-control" value="{{ $good->road_expenses }}" name="road_expenses" id="road_expenses">
          </div>
     
    
            <div class="form-group col-md-3">
                <label for="client_id" class="font-weight-bold">Client:</label>
                <select name="client_id" id="client_id" class="form-control">
                @foreach($aclients as $aclient) 
                 
                              @if($aclient->id == $good->client_id)
                                  @$selected = "selected";
                <option value="{{$aclient->id}}" selected="{{$selected}}">
                           {{$aclient->client_name}}  
                    </option>
                     @endif

                      <option value="{{$aclient->id}}" >
                          {{$aclient->client_name}}
                    </option>
                      

                
                @endforeach
              </select>


            </div>
             </div>
          <div class="row">
            <div class="form-group col-md-3">
           
        <label for="payment_mode" class="font-weight-bold"> Mode of Payment: </label>
          <select name="payment_mode" id="payment_mode" class="form-control dynamic" data-dependent="client"  onchange="select_pay_mode(this.value)" required>
            <option value="">Select Payment Mode</option>
            
            <option value="AP">Advance Payment</option>
            <option value="FP">Full Payment </option>
            <option value="BP">Bulky Payment </option>
          </select>
       <input type="text" class="form-control" name="payment_id_no" id="payment_id_no" value="{{$payment[0]->payment_id_no}}" readonly> 
        <input type="hidden" class="form-control" name="payment_id" id="payment_id" value="{{$payment[0]->payment_id}}" readonly> 

         </div>  

          <div class="form-group col-md-4" id="payd">
                <label for="payment_deposit" class="font-weight-bold">Amount Deposit:</label>
                <input type="number" class="form-control" value="{{$payment[0]->payment_deposit}}"  name="payment_deposit" id="payment_deposit">
             </div>


              <div class="form-group col-md-3">
              <label for="good_date_of_pickup" class="4 font-weight-bold">PickUp Date:</label>
              <input type="date" class="form-control" value="{{ $good->good_date_of_pickup }}" name="good_date_of_pickup" id="good_date_of_pickup">
           </div>
          

         
            <div class="form-group col-md-3">
                <label for="good_pickup_point" class="font-weight-bold">PickUp Point:</label>
                <input type="text" class="form-control" value="{{ $good->good_pickup_point }}" name="good_pickup_point" id="good_pickup_point">
             </div>
            
             <div class="form-group col-md-3">
                <label for="good_delivery_point" class="font-weight-bold">Delivery Point:</label>
                <input type="text" class="form-control" value="{{ $good->good_delivery_point }}" name="good_delivery_point" id="good_delivery_point" >
             </div>
            </div>





        
        <button type="submit" class="btn btn-primary">Update</button>
       
      </form>
  </div> 
</div>
<script type="text/javascript">
   $(document).ready(function(){
    
    $('#payd').hide();
  
  });

   function select_pay_mode(method){
    var pm=method;
    var _token= $('input[name="_token"]').val();
    console.log(_token);
   
     switch (pm) {
           case pm='AP':
            $('#payd').show();
           // alert('Advance payment selected');
            break; 
         
          
          default:
         $('#payd').hide();
            break;
        } 
        //alert(method);exit;
       console.log(method);
      

     
    }

</script>
@endsection