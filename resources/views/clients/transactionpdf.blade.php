<!DOCTYPE html>
<html>
<head>
  <title>Client Transaction History </title>
  <style>
  .uper {
    margin-top: 40px;
  }
  body{
    counter-reset: Serial;  /*set the serial counter to zero*/
    font-size: 1em;
  }
  th{
    border:1px solid black;
  }
   td{
    border:1px solid black;
  }
  table{
    border-collapse: separate;
    text-align: center;
    font-size: .9em;

  }
  tr td:first-child::before{
    counter-increment: Serial;
    content: counter(Serial);

  }
  .col-md-6{width:50%}
  .col-md-9{width:75%}
  .row{margin-right:-15px;margin-left:-15px}
</style>
</head>
<body>


 
  <div >
   
 <img src="{{asset('imgs/invoiceheader.png')}}" width="100%" height="170px" alt="">
<hr > 
</div>
    <div >
    <h2 align="center">Client's Transaction History</h2>
    </div>
   
      <div class="row">       
        <label for="Balance" style="float:right" >Bulky Advance: # {{number_format($client->bulky_advance,2)}} </label>
       </div>
       <br/>
       <div class="row">
      <label for="Balance" style="float:right" >Balance: # {{number_format($client->bulky_advance-$total_cost,2)}}</label>
    
    </div>
      
    <div class="row">
     
        <div > <strong>Client's Name: </strong>{{$client->client_name}}</div> 
    </div>
    <div class="row">
        <div > <strong>Address: </strong>{{$client->client_address}}</div>
    </div>
    <div class="row">
            <div > <strong> Phone Number: </strong>{{$client->client_phone}}</div>
    </div>

   
  
  
  <div >

     <table width="100%" style="border:1px solid black;border-collapse:collapse; padding-top:15px;">
    <thead>
        <tr>
          <th>SN</th>
          <th>Good ID</th>
          <th>Good Type</th>
          <th>Pickup Point</th>
          <th>Delivery Point</th>
          <th>Cost of Good</th>
          <th>Date</th>
          </tr>
      
    </thead>
    <tbody>
        @foreach($trans as $tran)
        <tr>
            <td></td>
            <td>{{$tran->good_id_no}}</td>
            <td>{{$tran->good_type}}</td>
            <td>{{$tran->good_pickup_point}}</td>
            <td>{{$tran->good_delivery_point}}</td>
            <td>#  {{number_format($tran->good_cost,2)}}</td>
            <td>{{date('d-m-Y', strtotime($tran->created_at))}}</td>

        </tr>
        @endforeach
        <tr>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th>Total:</th>
        <th colspan="2" align="left"># {{number_format($total_cost,2)}}</th>
         
        </tr>
          <tr>
          <th colspan="2"> <strong> Total in Words:</strong></th>
        <th colspan="5" align="left" style="text-transform: capitalize;">{{$tcwords}} Naira  only</th>
        </tr>
    </tbody>
  </table>
 </div>
 
  </div>
</div>




</body>
</html>