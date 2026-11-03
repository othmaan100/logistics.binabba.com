<!DOCTYPE html>
<html>
<head>
  <title>Client Transaction History</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      /* background-color: #f4f4f4; */
    }
    .banner {
      /* background-color: #fff; */
      padding: 20px;
      text-align: center;
      border-bottom: 2px solid #ccc;
    }
    .banner h1 {
      margin: 0;
      font-size: 2em;
    }
    .banner p {
      margin: 5px 0;
    }
    .contact-info {
      margin-top: 20px;
    }
    .contact-info p {
      margin: 5px 0;
    }
    .table-responsive {
      margin: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: left;
    }
    th {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>
  <div class="banner">
    <h1>Bin-Abba Nigeria Limited</h1>
    <p>RC No. 1308745</p>
    <p>No. 47, Maganda Road Kano</p>
    <div class="contact-info">
      <p>Phone: 08034942000, 08026982000, 08092271000</p>
      <p>Email: binabba@gmail.com, info@binabba.com</p>
     
    </div>
  </div>

  <!-- Client List Section -->
  <div>
    <h2 style="text-align:center">Delivered Goods List</h2>
    </div>
   
 
   @if (count($dgoods)>0)
    <!--<font size="2" face="Courier New" >-->
    {{-- One table per chunk: a single 1,000+ row table exhausts dompdf's memory --}}
    @foreach($dgoods->chunk(40) as $rows)
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
        @foreach($rows as $dgood)
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
    @endforeach
  <!--</font>-->
  @else
  <p class="text-info">No Delivered Good(s) Has been Recorded</p>
@endif
  </div>
  
 