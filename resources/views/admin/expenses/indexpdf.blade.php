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
    <h2 style="text-align:center">Expenses List</h2>
    </div>
   
     
   

     <table class="table table-striped table-responsive" width="100%">
    <thead>
        <tr>
          <th>SN</th>
          <th>Date</th>
          <th>Good ID</th>
          <th>Plate Number</th>
          <th>Driver Name</th>
          <th>Expense Cost</th>
          <th>Reason</th>
        </tr>
    </thead>
    <tbody>
        @foreach($dexpenses as $expense)
        
        <tr>
          <td></td>
            <td>{{date('d-m-Y',strtotime($expense->expenses_date))}}</td>
            <td>{{$expense->good_id_no}}</td>
            <td>{{$expense->plate_number}}</td>
            <td>{{$expense->driver_name}}</td>
            <td>#{{number_format($expense->expenses_cost,2)}}</td>
            <td>{{$expense->expenses_reason}}</td>
            
        </tr>
        @endforeach
    </tbody>
  </table>
  </div>

    
    </div>

</div>
  
