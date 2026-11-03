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
  tr td:first-child::before{
    counter-increment: Serial;
    content: counter(Serial); 
  }*/
</style>

  <div class="card uper">
    
  <div class="card-header">
     </div>
 
  <div class="card-body">
    <h4 class="text-center">Transport History</h4>
    <hr>
  <div class="row">
   
      <div class="col-md-2 font-weight-bold">Truck Model:</div> <div class="col-md-5">{{$truck->truck_model}}</div> 
  </div>
  <div class="row">
      <div class="col-md-2 font-weight-bold">Plate Number:</div> <div class="col-md-5">{{$truck->plate_number}}</div>
  </div>
 <div class="row">
      <div class="col-md-2 font-weight-bold">Date Registered::</div> <div class="col-md-5">{{date('d-m-Y', strtotime($truck->created_at))}}</div>
  </div>

    @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}  
    </div><br />
    
  @endif
  @if(count($goods)>0)
     <table class="table table-striped table-bordered table-responsive" id="dataTable">
    <thead>
        <tr>
          <th></th>
          <th>Goods ID</th>
          <th>Goods Type</th>
          <th>Pickup Location</th>
          <th>Good Delivery Location</th>
          <th>Good Cost</th>
          <th>Date</th>
          </tr>
    </thead>
    <tbody>

    @php
           $sn =0
        @endphp
        @foreach($goods as $good)
        @php
                  $sn++
        @endphp
        
        <tr>
            <td>{{$sn}}</td>
            <td>{{$good->good_id_no}}</td>
            <td>{{$good->good_type}}</td>
            <td>{{$good->good_pickup_point}}</td>
            <td>{{$good->good_delivery_point}}</td> 
            <td>₦{{number_format($good->good_cost,2)}}</td>
            <td>{{date('d-m-Y', strtotime($good->good_date_of_pickup))}}</td>
        </tr>
        @endforeach
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>Total:</th>
            <th>₦{{number_format($total_cost,2)}}</th>
        
        </tr>
    </tbody>
     </table>
     @else
    <p class="text-info">No Record of Operation Obtained!!!</p>
 @endif
  </div>
   Summary of Operations
  <table class="table table-sm table-inverse table-hover table-bordered col-md-6" width="50%">
 
      <tr>
        <th>Total Goods Cost</th>
        <td>₦{{number_format($total_cost,2)}}</td>
      </tr>
    <tr>
        <th>Total Expenses</th>
        <td>₦{{number_format($total_expenses,2)}}</td>
      </tr>
      <tr>
        <th> Income Operating</th>
        <td>₦{{number_format($total_amount_generated,2)}}</td>
      </tr>
      <tr>
        <th>Truck Value</th>
        <td>₦{{number_format($truckValue,2)}}</td>
      </tr>

      <tr>
        <th class="text-danger"> Balance</th>
        @if($balance>0)
        <td class="text-danger">₦{{number_format($balance,2)}}</td>
        @else
         <td class="text-danger">>NIL</td>
         @endif
      </tr>
      
       <tr>
        <th class="text-success">Net profit</th>
        @if($profit<0)
        <td class="text-success">NIL</td>
        @else
        <td class="text-Success font-weight-bold">₦ {{number_format($profit,2)}}</td>
         @endif
      </tr>
    

  


  </table>
   <a class="btn btn-primary" href="{{ route('admin-trucks.operationspdf',$truck->id) }}">Download PDF</a>
  
    

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
} );
</script>

@endsection