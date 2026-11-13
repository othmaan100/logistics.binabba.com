<!DOCTYPE html>
<html>
<head>
  <title>Undelivered Goods </title>
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
    <h2 align="center">Undelivered Goods List</h2>
    </div>
   
 
   @if (count($goods)>0)  
    <font size="2" face="Courier New" >
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
            <th>PickUp Date</th>
          </tr>
      </thead>
      <tbody>
          @foreach($goods as $good)
          <tr>
             
              <td>{{$good->good_id_no}}</td>
              <td>{{$good->good_type}}</td>
              <td>{{$good->good_pickup_point}}</td>
              <td>{{$good->good_delivery_point}}</td>
              <td>{{$good->client_name}}</td>
              <td>{{$good->driver_name}}</td>
              <td>{{$good->plate_number}}</td>
              <th> {{date('d-m-Y',strtotime($good->good_date_of_pickup))}}</th>
           
          </tr>
          @endforeach
      </tbody>
    </table>
    @else
    <p class="text-info">No Undelivered Good(s) Has been Recorded</p>
  @endif
  </font>
    </div>

