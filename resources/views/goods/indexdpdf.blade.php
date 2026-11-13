<!DOCTYPE html>
<html>
<head>
  <title>Delivered Goods List</title>
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
    text-align: left;
  }
  table{
    border-collapse: collapse;
    text-align: center;
    font-size: .9em;
    margin:0px;
    padding:0px;

  }
 
  .col-md-6{width:50%}
  .col-md-9{width:75%}
  .row{margin-right:-15px;margin-left:-15px}
</style>
</head>
<body>


 
  <div >
   
 <x-org-letterhead pdf />
<hr > 
</div>
    <div >
    <h2 align="center">Delivered Goods List</h2>
    </div>
   
 
   @if (count($dgoods)>0)
    <!--<font size="2" face="Courier New" >-->
     <table class="table table-striped table-responsive" width="100%">
    <thead>
        <tr>
          
          <th>Goods ID</th>
          <th>Goods Type</th>
          <th>Pickup Point</th>
          <th>Delivery Point</th>
          <th>Client</th>
          <th>Driver</th>
          <th>Truck</th>
          <th>Delivery Date</th>
       </tr>
    </thead>
    <tbody>
        @foreach($dgoods as $dgood)
        <tr>
            
            <td>{{$dgood->good_id_no}}</td>
            <td>{{$dgood->good_type}}</td>
            <td>{{$dgood->good_pickup_point}}</td>
            <td>{{$dgood->good_delivery_point}}</td>
            <td>{{$dgood->client_name}}</td>
            <td>{{$dgood->driver_name}}</td>
            <td>{{$dgood->plate_number}}</td>
             <td>{{date('d-m-Y',strtotime($dgood->good_date_of_delivery))}}</td>
       
        </tr>
        @endforeach
    </tbody>
  </table>
  <!--</font>-->
  @else
  <p class="text-info">No Delivered Good(s) Has been Recorded</p>
@endif
  </div>
  
 