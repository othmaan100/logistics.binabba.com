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
    <h2 style="text-align:center">List of UnCompleted Payments</h2>
    </div>
   

             @if (count($dpayments)>0)
                 
            
              <table class="table table-striped table-responsive  table-bordered" width="100%">
            
              <thead>
                  <tr>
                    
                    <th>Payment ID</th>
                    <th>Good ID No</th>
                    <th>Goods </th>
                    
                    <th>Client</th>
                    <th>Goods Cost</th>
                    <th>Amount Deposited</th>
                    <th>Balance</th>
                 </tr>
              </thead>
              <tbody>
                @foreach($dpayments as $dpayment)
                <tr>
                  
                    <td>{{$dpayment->payment_id_no}}</td>
                    <td>{{$dpayment->good_id_no}}</td>
                    <td>{{$dpayment->good_type}}</td>
                   
                    <td>{{$dpayment->client_name}}</td>
                    <td>#{{number_format($dpayment->good_cost,2)}}</td> 
                    <td>#{{number_format($dpayment->payment_deposit,2)}}</td>
                    <td>#{{number_format($dpayment->good_cost - $dpayment->payment_deposit,2)}}</td>
                   
                </tr>
                @endforeach



              </tbody>
              </table>
              @else
                 <p class="text-info" align="center">No Default Payment Remaining</p>
              @endif
          </div>
        
        </div>
      </div>
    


