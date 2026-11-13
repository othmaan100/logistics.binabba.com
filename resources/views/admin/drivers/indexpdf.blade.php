<!DOCTYPE html>
<html>
<head>
  <title>Drivers List </title>
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
   
 <x-org-letterhead pdf />
<hr > 
</div>
    <div >
    <h2 align="center">Drivers List</h2>
    </div>
   
     
   
  
 
<div >
    <font size="2" face="Courier New" >
          @if(count($drivers)>0)
  
     <table   width="100%" >
     <thead>
        <tr>
          <th>SN</th>
          <th>ID</th>
          <th>Name</th>
          <th>Phone</th>
          <th>Address</th>
         
        </tr>
    </thead>
    <tbody>
        @foreach($drivers as $driver)
        <tr>
          <td></td>
            <td>{{$driver->driver_id_no}}</td>
            <td>{{$driver->driver_name}}</td>
            <td>{{$driver->driver_phone}}</td>
            <td>{{$driver->driver_address}}</td>
            
        @endforeach
    </tbody>
  </table>
  @else 
  <br>  
  <p class="text-info ">No Driver not assigned to a Truck</p>
  </font>
  @endif
  </div>
  </div>
</div>
  
