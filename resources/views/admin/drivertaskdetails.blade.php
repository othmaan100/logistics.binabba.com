@extends('layouts.admin')
@section("headers")
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" rel="stylesheet">
@endsection
@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
  body{
    counter-reset: Serial;  /*set the serial counter to zero*/
  }
  /* table{
    border-collapse: separate;
  }
  #expenses tr td:first-child::before {
    counter-increment: Serial;
    content: counter(Serial);
  }
  .table th{
    font-size: .9em;
    font-weight: bold;

  }
  .table td{
    font-size: .9em;
    text-align: center;
  } */
</style>

  <div class="card uper">
    <a class="btn btn-primary" href="{{ route('admin-drivers.tasks',$driver->driver_id) }}"> Back</a>

  <div class="card-header">
  
</div>
 
  <div class="card-body">
      <div class="row justify-content-md-center">
    <x-org-letterhead />
</div> 
<hr class="my-4"/> 
<div class="offset-md-4 ">
    
    <h4 class=" display-6 font-weight-bold text-uppercase">Driver's Operation Details</h4>
      
    </div>
   
    
      
    <div class="row">
     
        
        <div class="col-md-2 font-weight-bold">Full Name:</div> <div class="col-md-5">{{$driver->driver_name}}</div> 
    </div>
    <div class="row">
        <div class="col-md-2 font-weight-bold">Address:</div> <div class="col-md-5">{{$driver->driver_address}}</div>
    </div>
    <div class="row">
            <div class="col-md-2 font-weight-bold">Phone Number:</div> <div class="col-md-5">{{$driver->driver_phone}}</div>
    </div>
     <div class="row">
            <div class="col-md-2 font-weight-bold">Truck Model:</div> <div class="col-md-5">{{$truck->truck_model}}</div>
    </div>
    <div class="row">
            <div class="col-md-2 font-weight-bold">Plate Number:</div> <div class="col-md-5">{{$truck->plate_number}}</div>
    </div>
    <div class="row">
            <div class="col-md-2 font-weight-bold">Client Name:</div> <div class="col-md-5">{{$client->client_name}}</div>
    </div>

    @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}  
    </div><br />
  @endif

  <table class="table  table-responsive" id="dataTablex">
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
        <td>₦{{number_format($good->good_cost,2)}}</td>
         <td>{{$good->liters}} liters</td>
        <td>₦{{number_format($good->diesel_cost,2)}}</td>
        <td>₦{{number_format($good->road_expenses,2)}}</td>
        <td>₦ @if ($good->commission=='1') 
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
      <td>₦{{number_format(($good->diesel_cost*$good->liters),2)}}</td>
      <td></td>
      <td class="font-weight-bold">Expenses </td>
      <td > ₦{{number_format((($good->diesel_cost*$good->liters) + $good->road_expenses + $good->commission),2)}}    </td>
      <td></td>
    </tr>
</table>


  @if(count($expenses)>0)
  
  <div class="container">

     <table id="expenses" class="table table-striped table-responsive" width="100%" id="dataTable1x">
    <thead>
     
    
     
        <tr>
          <th>SN</th>
          <th>Date</th>
          <th>Additional Expenses Cost</th>
          <th>Reason</th>
         
          </tr>
      
    </thead>
    <tbody>
    <?php $i = 0; ?> 
    @foreach($expenses as $expense) 
    <?php $i++; ?>
        <tr>
            <td>{{$i}}</td>
            <td>{{date('d-m-Y',strtotime($expense->expenses_date))}}</td>
            <td>₦{{number_format($expense->expenses_cost,2)}}</td>
            <td>{{$expense->expenses_reason}}</td>
           

        </tr>
        @endforeach
        <tr>
            <th></th>
            <th>Total</th>
            <th>₦{{number_format($total_add_expenses,2)}}</th>
            <th> </th>
            
        </tr>
       
    </tbody>
  </table>
  </div>

  
  <div class="container">
      <p class="text-danger font-weight-bold">
          Total Expenses : ₦{{number_format(($total_add_expenses + ($good->diesel_cost*$good->liters) + $good->road_expenses + $good->commission),2)}}
      </p>
         <p class="font-weight-bold text-info">
        Gross Profit : ₦{{number_format(($good->good_cost - ( $total_add_expenses + ($good->diesel_cost*$good->liters) + $good->road_expenses + $good->commission)),2)}}
    </p>
    <p class="font-weight-bold text-info">
        Driver's Percentage :   ₦ {{number_format($driverspercent,2)}}   
</p>
     <p class="font-weight-bold">
        Net Balance  : ₦{{number_format(($good->good_cost - ($total_add_expenses + ($good->diesel_cost*$good->liters) + $good->road_expenses + $good->commission + $driverspercent)),2)}}
    </p>
  </div>
  @else 
  <br>  
  <p class="text-info ">No Addtional Expenses Recorded</p>
  <div class="container">
    <p>
        Total Expenses :₦ {{ number_format((($good->diesel_cost*$good->liters) + $good->road_expenses + $good->commission),2)}}
   
    <p >
        Driver's Percentage : ₦ {{number_format($driverspercent,2)}}
    </p>
     </p>
    
    <p class="font-weight-bold">
        Net Balance   : ₦{{number_format(($good->good_cost - (($good->diesel_cost*$good->liters) + $good->road_expenses + $good->commission + $driverspercent )),2)}}
    </p>
</div>
@endif
<a class="btn btn-primary" href="{{ route('admin-drivers.taskdetailspdf',$good->good_id) }}">Download PDF</a>
 

  </div>
</div>

@endsection

@section("footers")
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script>
    $(document).ready(function() {
    $('#dataTable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    } );


    $('#dataTable1').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    } );

} );
</script>
@endsection