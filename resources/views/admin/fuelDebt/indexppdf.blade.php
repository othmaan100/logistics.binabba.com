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
  <x-org-letterhead pdf />

  <!-- Client List Section -->
  <div>
    <h2 style="text-align:center">List of {{$company[0]->company_name}} Fuel Debt</h2>
    </div>
   
     
   

     <table class="table table-striped table-responsive" width="100%">
    <thead>
        <tr>
          <th>SN</th>
          <th>Truck</th>
          <th>Plate Number</th>
          <th>Driver Name</th>
          
          <th>Diesel Cost</th>
           <th>liters</th>
           <th>Total</th>
          <th>Debt date</th>
          
         
        </tr>
    </thead>
    <tbody>
        @foreach($pdebts as $pdebt)
        
        <tr>
          <td></td>
            <td>{{$pdebt->truck_model}}</td>
            <td>{{$pdebt->plate_number}}</td>
            <td>{{$pdebt->driver_name}}</td>
         
            <td>#{{number_format($pdebt->diesel_cost,2)}}</td>
            <td>{{$pdebt->liters}}</td>
            <td>#{{number_format(($pdebt->diesel_cost * $pdebt->liters),2)}}</td>
            <td>{{$pdebt->debt_date}}</td>
           
        </tr>
        @endforeach
          <tr>
          <th></th>
           <th></th>
            <th></th>
             <th></th>
              
                <th>Total</th>
                <th colspan="2">#{{number_format($total_debt[0]->total_debt,2)}}</th>
                <th></th>

        </tr>
    </tbody>
  </table>
  </div>

    
    </div>

</div>
  
