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
    <h2 style="text-align:center">Driver's Operation Details</h2>
    </div>

<font size="2" face="Courier New" >
<table  width="100%">
  
    <tr>
      <th width="17%" align="left">Full Name:</th>
      <td width="28%" align="left">{{$driver->driver_name}}</td>
      
      <td width="55%" align="right" rowspan="8" > <img src="{{$driver_pic}}" alt="Driver_Image" height="95px" width="95px"></td>
    </tr>
    <tr>
      <th align="left">Address:</th>
      <td align="left">{{$driver->driver_address}}</td>
      <td></td>
    </tr>
    <tr>
      <th align="left">Phone Number:</th>
      <td align="left">{{$driver->driver_phone}}</td>
      <td></td>
    </tr>
    <tr>
      <th align="left">Truck Model::</th>
      <td align="left">{{$truck->truck_model}}</td>
      <td></td>
    </tr>
    <tr>
      <th align="left">Plate Number:</th>
      <td align="left">{{$truck->plate_number}}</td>
      <td></td>
    </tr>
    <tr>
      <th align="left">Client Name:</th>
      <td align="left">{{$client->client_name}}</td>
      <td></td>
    </tr>
    
  
</table>
 </font> 
  


<font size="2" face="Courier New" >

  <table id="table" style="border:1px solid black;border-collapse:collapse; padding-top:15px;">
    <tr>
        
        <th>Good</th>
        <th>From</th>
        <th>To</th>
        <th>Weight</th>
        <th>Cost</th>
         <th>Diesel liters</th>
        <th>Diesel Cost / liter</th>
        <th>Road Expenses</th>
        <th>Commision</th>
        <th>Date of Pickup</th>
        <th>Date of Delivery</th>
    </tr>
    <tr>
        
        <td>{{$good->good_type}}</td>
        <td>{{$good->good_pickup_point}}</td>
        <td>{{$good->good_delivery_point}}</td>
        <td>{{$good->good_weight}} Tone(s)</td>
        <td>#{{number_format($good->good_cost,2)}}</td>
         <td>{{$good->liters}} liters</td>
        <td>#{{number_format($good->diesel_cost,2)}}</td>

        <td>#{{number_format($good->road_expenses,2)}}</td>
        <td># @if ($good->commission=='1') 
            {{number_format(($good->good_cost*0.1),2)}}
            @else
            {{number_format($good->commission,2)}}
        @endif
            </td>
        <td>{{date('d-m-Y',strtotime($good->good_date_of_pickup))}}</td>
        <td>{{$good->good_date_of_delivery}}</td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td  class="font-weight-bold">Diesel Cost</td>
      <td>#{{number_format(($good->diesel_cost*$good->liters),2)}}</td>
      <td></td>
      <td class="font-weight-bold">Expenses </td>
      <td colspan="2"> #{{number_format((($good->diesel_cost*$good->liters) + $good->road_expenses + $good->commission),2)}}
    </td>
    </tr>
</table>
</font>
<br/>
  <br/>
 
  @if(count($expenses)>0)
  
  <div class="container">

<font size="2" face="Courier New" >
     <table id="expenses" class="table table-striped table-responsive" width="100%">
    
    
     
        <tr>
          <th>SN</th>
          <th>Date</th>
          <th>Additional Expenses Cost</th>
          <th>Reason</th>
         
          </tr>
      
    
        @foreach($expenses as $expense)
        <tr>
            <td></td>
            <td>{{date('d-m-Y',strtotime($expense->expenses_date))}}</td>
            <td>#{{number_format($expense->expenses_cost,2)}}</td>
            <td>{{$expense->expenses_reason}}</td>
           

        </tr>
        @endforeach
        <tr>
            <th></th>
            <th>Total</th>
            <th>#{{number_format($total_add_expenses,2)}}</th>
            <th> </th>
            
        </tr>
       
  
  </table>
  </font>
  </div>

  
  <div class="container">
      <p class="text-danger font-weight-bold">
          Total Expenses : #{{number_format(($total_add_expenses + ($good->diesel_cost*$good->liters) + $good->road_expenses + $good->commission),2)}}
      </p>
         <p class="font-weight-bold text-info">
        Gross Profit : #{{number_format(($good->good_cost - ( $total_add_expenses + ($good->diesel_cost*$good->liters) + $good->road_expenses + $good->commission)),2)}}
    </p>
    <p class="font-weight-bold text-info">
         Driver's Percentage :   # {{number_format($driverspercent,2)}}
    </p>
     <p class="font-weight-bold">
       Net Balance  : #{{number_format(($good->good_cost - ($total_add_expenses + ($good->diesel_cost*$good->liters) + $good->road_expenses + $good->commission + $driverspercent)),2)}}
 </p>
  </div>
  @else 
  <br>  
  <p class="text-info ">No Addtional Expenses Recorded</p>
  <div class="container">
    <p>
        Total Expenses :# {{ number_format((($good->diesel_cost*$good->liters) + $good->road_expenses + $good->commission),2)}}
   
    <p >
       Driver's Percentage :   # {{number_format($driverspercent,2)}}
        </p>
     </p>
    
    <p class="font-weight-bold">
        Net Balance   : #{{number_format(($good->good_cost - (($good->diesel_cost*$good->liters) + $good->road_expenses + $good->commission + $driverspercent )),2)}}
      </p>
</div>
@endif
 

  </div>
</div>



  </div>
</div>




