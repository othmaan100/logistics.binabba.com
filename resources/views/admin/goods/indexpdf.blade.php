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
    <h2 style="text-align:center">Undelivered Goods List</h2>
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

