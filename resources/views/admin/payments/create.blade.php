@extends('layouts.app')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
  <div class="card-header">
    Make Payment
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
      <form method="post" action="{{ route('payments.store') }}">
          
          <div class="form-group col-md-4">
              @csrf
                <label for="payment_id_no "class="font-weight-bold" >Payment ID Number:</label>
          <input type="text" class="form-control" name="payment_id_no" id="payment_id_no" value="P{{sprintf("%03d",$count)}}" readonly>
            </div>


          <div class="form-group col-md-4">
            <label for="good_id"><strong> Good Paid For: </strong></label>
              <select name="good_id" id="good_id" onchange="fetch_good_cost(this.value)" class="form-control">
                <option value=" ">Select Good</option>
                @foreach($goods as $good) 
                <option value="{{$good->good_id}}"> {{$good->good_id_no}} (  {{$good->good_type}})  {{$good->good_date_of_pickup}}</option>
                @endforeach
              </select>
            </label>
        </div>
       
        <div id="cost_client"> 
      {{--   <div class="form-group col-md-4">

          <label for="good_cost" class="font-weight-bold">Good Cost:</label>
          <input type="text" class="form-control"   readonly/>
      </div>
      <div class="form-group col-md-4">

        <label for="client" class="font-weight-bold">Client Name:</label>
        <input type="text" class="form-control"  readonly/>
    </div> --}}

  </div>

      <div class="form-group col-md-4">
        <label for="payment_mode"><strong> Mode of Payment: </strong></label>
          <select name="payment_mode" id="payment_mode" class="form-control dynamic" data-dependent="client"  onchange="select_pay_mode(this.value)">
            <option value=" ">Select Payment Mode</option>
            
            <option value="AP">Advance Payment</option>
            <option value="FP">Full Payment </option>
            <option value="BP">Bulky Payment </option>
          </select>
        </label>
    </div>          
          
            <div class="form-group col-md-4" id="payd">
                <label for="payment_deposit" class="font-weight-bold">Amount Deposit:</label>
                <input type="number" class="form-control" name="payment_deposit" id="payment_deposit">
             </div>
             
          <button type="submit" class="btn btn-primary">Save Record</button>
      </form>
  </div>
</div>
<script>
  function fetch_good_cost(good_id) {
      var good_id=good_id;
      var _token= $('input[name="_token"]').val();
    console.log(_token);
    var datas="good_id="+good_id+"&_token="+_token;
    
    $.ajax({
        url: "{{route('payment.Goodfetch')}}",
        method:"POST",
        data: datas,
        success:function(res){
           // alert(res);exit;
            //console.log(res);
           
            //console.log(a);
           
              $("#cost_client").html(res); //inserting values into div
              
              //$("#good_cost").val('₦'+ '' + a);
             // $("#good_cost").val(a);// inserting into textnox
         },
         error: function(xhr,status,error){
           var errrmsg=xhr.status+ ': '+xhr.statusText;
            alert('Eror-'+ errrmsg);
  }
      });
    
  }
  function select_pay_mode(method){
    var pm=method;
    var _token= $('input[name="_token"]').val();
    console.log(_token);
    //alert(pm);
   // if ($(this).val()=='BP') {
   /*  if (pm=='BP') {
        alert('Bulk payment selected');
        
      } elseif (pm=='AP') {
        alert('Advance payment selected');
        
      } 
      elseif (pm=='FP') {
        alert('Full payment selected');
        
      }  */
     switch (pm) {
           case pm='AP':
            $('#payd').show();
           // alert('Advance payment selected');
            break; 
          /* case pm='BP':
          $('#client_div').show();
           // alert('Bulk payment selected');
           case pm='FP':
            $('#client_div').hide();
            //alert('Full payment selected');
          */
          default:
         $('#payd').hide();
            break;
        } 
        //alert(method);exit;
       console.log(method);
        /* $.ajax({

            url: 'ajax_level_id.php',
            data: 'stid='+stid,
            success:function(res){
                //alert(res);exit;
               $("#empId").html(res);
            }
        }); */

     
    }
  $(document).ready(function(){
    //$('#client_div').hide();
    $('#payd').hide();

 
  
  });
</script>
@endsection