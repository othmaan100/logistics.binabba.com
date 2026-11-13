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
    <h2 align="center">Clients List</h2>
    </div>
   
     
   
  
 
<div class="table-responsive">
     <table class="table table-bordered " width="100%" >
    <thead>
     
    
     
        <tr>
          <th>SN</th>
          <th>Client Name</th>
          <th>  Phone Number</th>
          <th>  Address </th>
          <th>Date Registered</th>
          </tr>
      
    </thead>
    <tbody>
        @foreach($clients as $client)
        <tr>
            <td></td>
            <td>{{$client->client_name}}</td>
            <td>{{$client->client_phone}}</td>
            <td>{{$client->client_address}}</td>
            <td>{{date('d-m-Y', strtotime($client->created_at))}}</td>
            
        @endforeach
    </tbody>
  </table>
  </div>
  </div>
</div>
  
