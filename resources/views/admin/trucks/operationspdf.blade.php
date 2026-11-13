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
    <h2 style="text-align:center">Transport History</h2>
    </div>

 

  <div class="row">
   
      <div class="col-md-6 font-weight-bold">Truck Model: {{$truck->truck_model}}</div> 
  </div>
  <div class="row">
      <div class="col-md-6 font-weight-bold">Plate Number: {{$truck->plate_number}}</div>
  </div>
 <div class="row">
      <div class="col-md-6 font-weight-bold">Date Registered: {{date('d-m-Y', strtotime($truck->created_at))}}</div>
  </div>



  @if(count($goods)>0)
     <table width="100%" style="border:1px solid black;border-collapse:collapse; padding-top:15px;">
     <thead>
        <tr>
         
          <th>Goods ID</th>
          <th>Goods Type</th>
          <th>Pickup Location</th>
          <th>Good Delivery Location</th>
          <th>Good Cost</th>
          <th>Date</th>
          </tr>
    </thead>
    <tbody>
        @foreach($goods as $good)
        <tr>
           
            <td>{{$good->good_id_no}}</td>
            <td>{{$good->good_type}}</td>
            <td>{{$good->good_pickup_point}}</td>
            <td>{{$good->good_delivery_point}}</td> 
            <td>#{{number_format($good->good_cost,2)}}</td>
            <td>{{date('d-m-Y', strtotime($good->good_date_of_pickup))}}</td>
        </tr>
        @endforeach
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>Total:</th>
            <th>#{{number_format($total_cost,2)}}</th>
        
        </tr>
    </tbody>
     </table>
     @else
    <p class="text-info">No Record of Operation Obtained!!!</p>
 @endif
  </div>
  <strong> Summary of Operations </strong>
  <table class="table table-sm table-inverse table-hover table-bordered col-md-6" width="50%">
 
         <tr>
        <th>Total Goods Cost</th>
        <td>#{{number_format($total_cost,2)}}</td>
      </tr>
    <tr>
        <th>Total Expenses</th>
        <td>#{{number_format($total_expenses,2)}}</td>
      </tr>
      <tr>
        <th> Income Operating</th>
        <td>#{{number_format($total_amount_generated,2)}}</td>
      </tr>
      <tr>
        <th>Truck Value</th>
        <td>#{{number_format($truckValue,2)}}</td>
      </tr>

      <tr>
        <th class="text-danger"> Balance</th>
        @if($balance>0)
        <td class="text-danger">#{{number_format($balance,2)}}</td>
        @else
         <td class="text-danger">>NIL</td>
         @endif
      </tr>
      
       <tr>
        <th class="text-success">Net profit</th>
        @if($profit<0)
        <td class="text-success">NIL</td>
        @else
        <td class="text-Success font-weight-bold"># {{number_format($profit,2)}}</td>
         @endif
      </tr>
    

  
    

  


  </table>
    </div>
 
  </div>
</div>




</body>
</html>