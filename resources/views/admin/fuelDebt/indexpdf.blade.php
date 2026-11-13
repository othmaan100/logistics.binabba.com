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
    <h2 style="text-align:center">{{$company[0]->company_name}} Fuel Debt Payment Record(s) </h2>
    </div>
   
     
   

    @if (count($payments)>0)
     <table width="100%">
    <thead>
        <tr>
          <th width="3%">SN</th>
          <th width="17%">Payment Method</th>
          
          <th>Payer</th>
          <th>Amout Paid</th>
           <th>Balance Before Payment</th>
           <th>Balance After Payment</th>
          <th>Payment date</th>
          <th>Status</th>
         
        </tr>
    </thead>
    <tbody>
        @foreach($payments as $payment)
        
        <tr>
          <td></td>
            <td>{{$payment->payment_method}}</td>
            <td>{{$payment->payer}}</td>
            <td>#{{number_format($payment->amount_paid,2)}}</td>
             <td>#{{number_format($payment->balance_before_payment ,2)}}</td>
              <td>#{{number_format($payment->balance_after_payment ,2)}}</td>
            <td>{{date('d-m-Y', strtotime($payment->payment_date))}}</td>
            <td>Paid</td>
           
        </tr>
        @endforeach
         <tr>
          <th></th>
              
           <th></th>
           <th>Total</th>
          <th >#{{number_format($total_pay[0]->total_pay,2)}}</th>
           <th></th>
            <th></th>
             <th></th>
              <th></th>
              
</tr>
    </tbody>
  </table>
  @else
  <p class="text-info">No Paid Debt Has been Recorded</p>
@endif
  </div>  

    
    </div>

</div>
  
