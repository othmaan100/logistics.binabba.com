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
  } */
</style>

  <div class="card uper">

          <div class="card-header">
                <div class="d-flex justify-content-between"> 
                      <div class="p-2 bd-highlight">
                          <a class="btn btn-primary" href="{{ route('admin-fuelDebt.create') }}"> <strong> Add New Fuel Debt <i class="fa fa-fw fa-money"> </i></strong></a>
                      </div>
                      <div class="p-2 bd-highlight">
                        <a align="right" class="btn btn-primary pull-right md-offet-6 b"  href="{{ route('admin-fuelDebt.indexppdf',['id'=>$company[0]->company_id]) }}">  Download Debt Record List  </a>
                        <a align="right" class="btn btn-primary pull-right md-offet-6 b"  href="{{ route('admin-fuelDebt.indexpdf',['id'=>$company[0]->company_id]) }}">  Download Debt Payment Record List  </a>
                      </div>

                </div>
          </div>
   <div class="card-body">
  <h3 class="text-center">List of {{$company[0]->company_name}} Fuel Debt Records</h3>
    @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}  
  @endif
  <div class="d-flex">
      <div class="pull-right md-offet-6 b">
        <label>Balance</label>
        <input type="text" value="₦{{number_format($company[0]->balance,2)}}" name="" readonly="" disabled="">
        <a class="btn btn-danger" href="{{ route('fuelDebt.payment',$company[0]->company_id) }}" >Make Payment <i class="fa fa-fw fa-money-bill"></i></a>
      </div> 
  </div>
   
 <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
      <li class="nav-item">
          <a class="nav-link active" id="one-tab" data-toggle="tab" href="#one" role="tab" aria-controls="One" aria-selected="true">Fuel Debt Record</a>
      </li>
      <li class="nav-item">
          <a class="nav-link" id="two-tab" data-toggle="tab" href="#two" role="tab" aria-controls="Two" aria-selected="false">Debt Payment Record</a>
      </li>
    </ul>
  </div>

  <div class="tab-content" id="myTabContent"> 

<div class="tab-pane fade show active p-3" id="one" role="tabpanel" aria-labelledby="one-tab">


  <div class="container">
    @if (count($debts)>0)
     <table class="table table-striped table-responsive" id="dataTable">
    <thead>
        <tr>
          <th>SN</th>
          <th>Truck</th>
          <th>Plate Number</th>
          <th>Driver Name</th>
          <th>Diesel Cost/liter</th>
           <th>liters</th>
           <th>Total</th>
          <th>Debt date</th>
         
        </tr>
    </thead>
    <tbody>
       
        @php
              $sn =0
          @endphp
              @foreach($debts as $pdebt)
              @php
                $sn++
              @endphp
        
        <tr>
          <td>{{$sn}}</td>
            <td>{{$pdebt->truck_model}}</td>
            <td>{{$pdebt->plate_number}}</td>
            <td>{{$pdebt->driver_name}}</td>
            
            <td>₦{{number_format($pdebt->diesel_cost,2)}}</td>
            <td>{{$pdebt->liters}}</td>
             <td>₦{{number_format(($pdebt->diesel_cost * $pdebt->liters),2)}}</td>
            <td>{{date('d-m-Y', strtotime($pdebt->debt_date))}}</td>
           
        </tr>
        @endforeach
        <tr>
          <th></th>
           <th></th>
            <th></th>
             <th></th>
              <th></th>
               <th></th>
                <th>Total</th>
                <th colspan="2">₦{{number_format($total_debt[0]->total_debt,2)}}</th>

        </tr>
    </tbody>
  </table>
  @else
  <p class="text-info">No  Debt Has been Recorded</p>
@endif
  </div>
</div>


 <div class="tab-pane fade p-3" id="two" role="tabpanel" aria-labelledby="two-tab">

  <div class="container">
    @if (count($payments)>0)
     <table class="table table-striped table-responsive" id="dataTable1">
    <thead>
        <tr>
          <th>SN</th>
          <th>Payment Method</th>
          <th>Payer</th>
          <th>Amout Paid</th>
           <th>Balance Before Payment</th>
           <th>Balance After Payment</th>
          <th>Payment date</th>
         <th>Status</th>
        </tr>
    </thead>
    <tbody>
       
        @php
              $sn =0
          @endphp
              @foreach($payments as $payment)
              @php
                $sn++
              @endphp
        <tr>
          <td>{{$sn}}</td>
            <td>{{$payment->payment_method}}</td>
            <td>{{$payment->payer}}</td>
            <td>₦{{number_format($payment->amount_paid,2)}}</td>
             <td>₦{{number_format($payment->balance_before_payment ,2)}}</td>
              <td>₦{{number_format($payment->balance_after_payment ,2)}}</td>
            <td>{{date('d-m-Y', strtotime($payment->payment_date))}}</td>
            <td>Paid</td>
           
        </tr>
        @endforeach
        <tr>
          <th></th>
          <th></th>
           <th></th>
           <th></th>
             <th></th>          
            <th></th>
           <th>Total</th>
          <th >₦{{number_format($total_pay[0]->total_pay,2)}}</th>
           
            

        </tr>
    
    </tbody>
  </table>
  @else
  <p class="text-info">No Paid Debt Has been Recorded</p>
@endif
  </div>

  </div>

   
  
  <div class="col-offset-9">
    <span class="fa-pull-right">
      <!-- Help in giving out links for paginated data-->
    </span>
    
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