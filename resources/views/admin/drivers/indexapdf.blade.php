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
  
    <div >
    <h2 align="center">Drivers List with Assigned Trucks</h2>
    </div>
   
     
   
  
 
<div >
    <font size="2" face="Courier New" >
     <table  width="100%" >
    <thead>
        <tr>
          <th>SN</th>
          <th>ID</th>
          <th>Truck Model</th>
          <th>Plate Number</th>
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
             <th>{{$driver->truck_model}}</th>
            <th>{{$driver->plate_number}}</th>
            <td>{{$driver->driver_name}}</td>
            <td>{{$driver->driver_phone}}</td>
            <td>{{$driver->driver_address}}</td>
            
        @endforeach
    </tbody>
  </table>
  </font>
  </div>
  </div>
</div>
  
