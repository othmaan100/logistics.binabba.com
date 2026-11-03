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
    <h2 style="text-align:center">List of Completed Payments</h2>
    </div>
   
 
      

     <!-- <font size="2" face="Courier New" >-->
              @if (count($payments)>0)
              {{-- One table per chunk: a single 1,000+ row table exhausts dompdf's memory --}}
              @foreach($payments->chunk(40) as $rows)
              <table style="" class="table table-striped table-responsive" width="100%">
              <thead>
                  <tr>
                    
                    <th>ID</th>
                    <th>Goods ID </th>
                 <th>Good</th>
                    <th>Plate Number</th>
                    <th>Driver Name</th>
                    <th>Client</th>
                    <th>Goods Cost</th>
                    <th>Amount Paid</th>
                    <th>Balance</th>
                    <th>Date</th>
                   </tr>
              </thead>
              <tbody>
                @foreach($rows as $payment)
                <tr>
                   
                    <td>{{$payment->payment_id_no}}</td>
                    <td>{{$payment->good_id_no}}</td>
                    <td>{{$payment->good_type}}</td>
                    <td>{{$payment->plate_number}}</td>
                    <td>{{$payment->driver_name}}</td>
                    <td>{{$payment->client_name}}</td>
                    <td>#{{number_format($payment->good_cost,2)}}</td> 
                    <td>#{{number_format($payment->payment_deposit,2)}}</td>
                    <td>#{{number_format($payment->good_cost - $payment->payment_deposit,2)}}</td>
                     <td>{{date('d-m-Y', strtotime($payment->updated_at))}}</td>
                  
                      
                </tr>
                @endforeach



              </tbody>
              </table>
              @endforeach
             <!-- </font>-->
              @else
                  <p class="text-info">No Good Has been full Paid</p>
              @endif
             
          </div>

         
      </div>
    
