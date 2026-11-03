@extends('layouts.staff')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
  <div class="card-header text-center">
    <h5>Register Good <i class="fa fa-fw fa-boxes"></i></h5>
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
      <form method="post" action="{{ route('goods.store') }}">
          
          <div class="form-group col-md-3">
              @csrf
                <label for="good_id_no" class="font-weight-bold">Goods ID Number:</label>
                <input type="text" class="form-control" name="good_id_no" id="good_id_no" value="G{{sprintf("%03d",$count)}}" readonly>
            </div>
            <div class="row">
            <div class="form-group col-md-2">
              <label for="truck_id" class="font-weight-bold"> Truck Assigned:</label>
                <select name="truck_id" id="truck_id" onchange="fetch_driver_id(this.value)" class="form-control" required>
                  <option value="">Select Truck</option>
                  @foreach($trucks as $truck) 
                  <option value="{{$truck->id}}"> {{$truck->truck_model}} With Plate Number: {{$truck->plate_number}} Assigned to {{$truck->driver_id_no }}</option>
                  @endforeach
                </select>
              </label>
          </div>
          <div class="form-group col-md-3 " id="drid">

            <label for="driver_id_no" class="font-weight-bold">Driver Name:</label>
            <input type="text" class="form-control" name="" id=""  readonly/>
           
          </div>

             <div class="form-group col-md-3">
                <label for="good_type" class=" font-weight-bold">Good Type:</label>
                 <!--<select class="form-control" name="good_type" id="good_type">
                  <option value="">Select Good</option>
                  <option value="Beans">Beans</option>
                  <option value="Bottle Water">Bottle Water</option>
                  <option value="Cements">Cements</option>
                  <option value="Cows">Cows</option>
                  <option value="Fertilizer">Fertilizer</option>
                  <option value="Flour">Flour</option>
                  <option value="Gravel">Gravel</option>
                  <option value="Gypsy">Gypsy</option>
                  <option value="Juice">Juice</option>
                  <option value="Leather">Leather</option>
                  <option value="Maize">Maize</option>
                  <option value="Millet">Millet</option>
                  <option value="Detergent">Detergent</option>
                  <option value="Plastic Rubber">Plastic Rubber </option>
                  <option value="PVC Rubber">PVC Rubber</option>
                  <option value="Semovita">Semovita</option>
                  <option value="Sesame">Sesame</option>
                  <option value="Soya-Beans">Soya-Beans</option>
                  <option value="Sugar">Sugar</option>
                  <option value="Timber">Timber</option>
                  <option value="Wheat">Wheat</option> 
                  <option value="Others">Others</option>
                </select> -->
            <select class="form-control" name="good_type" id="good_type" onchange="select_good_type(this.value)" required>
              <option value="">Select Goods Type:</option>
              @foreach($goodsTypes as $goodsType) 
                <option value="{{$goodsType->goods_type}}"> {{$goodsType->goods_type}} </option>
                @endforeach
                 <option value="Others">Others</option>
              
  </select>
            </div>

            <div class="form-group col-md-3" id="other_type">
              <label for="other_type" class=" font-weight-bold">Good Type(If others):</label>

              <input type="text" class="form-control" name="other_type" id="other_type" />
          </div>
          </div>
          <div class="row">
            <div class="form-group col-md-2">
              <label for="good_weight" class="font-weight-bold"> Weight(Tones): </label>
                <select name="good_weight" id="good_weight" class="form-control" onchange="select_good_weight(this.value)" required>
                  <option value="">Select Weight</option>
                  <option value="30">  30 </option>
                  <option value="35">  35 </option>
                  <option value="40">  40 </option>
                  <option value="45">  45 </option>
                  <option value="50">  50 </option>
                  <option value="55">  55 </option>
                  <option value="60">  60 </option>
                  <option value="Others">  Others </option>
                </select>
              </label>
          </div>
        
         <div class="form-group col-md-2" id="other_weight">
              <label for="other_weight" class=" font-weight-bold">Weight(If others):</label>

              <input type="text" class="form-control" name="other_weight" id="other_weight" />
          </div>

        
            <div class="form-group col-md-4">
              <label for="good_cost" class="font-weight-bold"> Cost of Good:</label>
              <input type="number" class="form-control" name="good_cost" id="good_cost"  required/>
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
            <input type="text" class="form-control" name="diesel_cost" id="diesel_cost" required>
        </div>
        <div class="form-group col-md-2">
            <label for="liters" class=" font-weight-bold">liters:</label>
            <input type="text" class="form-control" name="liters" id="liters" required>
        </div>
        <div class="form-group col-md-4">
          <label for="road_expenses" class=" font-weight-bold">Road Expenses:</label>
          <input type="number" class="form-control" name="road_expenses" id="road_expenses" required>
          </div>
     
    
            <div class="form-group col-md-3">
                <label for="client_id" class="font-weight-bold">Client:</label>
                <select class="form-control" id="client_id" name="client_id" required>
                    <option value="">Select Client</option>
                    @foreach ($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->client_name }} From {{ $client->client_address }} </option>
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
         <input type="hidden" class="form-control" name="payment_id_no" id="payment_id_no" value="P{{sprintf("%03d",$pcount)}}" readonly>

         </div>  

          <div class="form-group col-md-4" id="payd">
                <label for="payment_deposit" class="font-weight-bold">Amount Deposit:</label>
                <input type="number" class="form-control" name="payment_deposit" id="payment_deposit">
             </div>




            <div class="form-group col-md-3">
              <label for="good_date_of_pickup" class="4 font-weight-bold">PickUp Date:</label>
              <input type="date" class="form-control" name="good_date_of_pickup" id="good_date_of_pickup" required>
           </div>
          

           <!-- <div class="form-group col-md-3">
              <label for="good_date_of_delivery" class="font-weight-bold">Delivery Date:</label>
              <input type="date" class="form-control" name="good_date_of_delivery" id="good_date_of_delivery" >
           </div> -->
          
           
          
            <div class="form-group col-md-3">
                <label for="good_pickup_point" class="font-weight-bold">PickUp Point:</label>
                <input type="text" class="form-control" name="good_pickup_point" id="good_pickup_point" required>
             </div>
            
             <div class="form-group col-md-3">
                <label for="good_delivery_point" class="font-weight-bold">Delivery Point:</label>
                <input type="text" class="form-control" name="good_delivery_point" id="good_delivery_point" required>
             </div>
            </div>

          
          <button type="submit" class="btn btn-primary">Save Record</button>
      </form>
  </div>
</div>
<script>
  $(document).ready(function(){
    
    $('#payd').hide();
    $('#other_weight').hide();
    $('#other_type').hide();
  
  });

    function fetch_driver_id(truck_id) {
      var truck_id=truck_id;
      var _token= $('input[name="_token"]').val();
    console.log(truck_id);
    var datas="truck_id="+truck_id+"&_token="+_token;
    
    $.ajax({
        url: "{{route('good.TruckfetchDriver')}}",
        method:"POST",
        data: datas,
        success:function(res){
          // alert(res);exit;
            //console.log(res);
            var a =res;
            //console.log(a);
            $("#drid").html(res);
              //$("#good_cost").value=a;
              //$('#gcst').innerHTML=a;
             // $("#driver_id_no").val(a);
         },
         error: function(xhr,status,error){
           var errrmsg=xhr.status+ ': '+xhr.statusText;
            alert('Eror-'+ errrmsg);
  }
      });
    
  }

 
function select_good_weight (weight) {
  // body...
   var good_weight=weight;
    var _token= $('input[name="_token"]').val();
    console.log(_token);
   
     switch (good_weight) {
           case good_weight='Others':
            $('#other_weight').show();
           break; 
       
          default:
         $('#other_weight').hide();
            break;
        }    
}
function select_good_type (type) {
  // body...
  var good_type=type;
    var _token= $('input[name="_token"]').val();
    console.log(_token);
   
     switch (good_type) {
           case good_type='Others':
            $('#other_type').show();
           break; 
       
          default:
         $('#other_type').hide();
            break;
        }   
}

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