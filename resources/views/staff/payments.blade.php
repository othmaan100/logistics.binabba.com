@extends('layouts.staff')
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
  }
  tr td{
    font-size: .8rem;
  } */
    </style>

    
        <div class="card uper mt-12  ">
         <div class="d-flex justify-content-between"> 
  <div class="p-2 bd-highlight">
<!--<a class="btn btn-primary" href="{{ route('admin-payments.create') }}"> Add New payment <i class="fa fa-fw fa-money-bill"> </i></a>-->
          
        </div>
 <div class="p-2 bd-highlight">
     <a align="right" class="btn btn-primary pull-right md-offet-6 b"  href="{{ route('payments.indexcpdf') }}"> Download Completed Payment List   </a>
    <a align="right" class="btn btn-primary pull-right md-offet-6 b"  href="{{ route('payments.indexpdf') }}"> Download Uncompleted Payment  List   </a>
 </div>
   </div>



        <div class="card-header tab-card-header">
          <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="one-tab" data-toggle="tab" href="#one" role="tab" aria-controls="One" aria-selected="true">Completed Payment Records</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="two-tab" data-toggle="tab" href="#two" role="tab" aria-controls="Two" aria-selected="false">Uncompleted Payment Records</a>
            </li>
          </ul>
        </div>

        <div class="tab-content" id="myTabContent"> 
        <h5> Payment Records</h5>
              @if(session()->get('success'))
              <div class="alert alert-success">
                {{ session()->get('success') }}  
              </div>
              <br />
            @endif
          <div class="tab-pane fade show active " id="one" role="tabpanel" aria-labelledby="one-tab">
              @if (count($payments)>0)
              <table  style="" class="table table-striped table-responsive" width="100%" id="dataTable">
              <thead>
                  <tr>
                    <th>SN</th>
                    <th>Payment ID</th>
                     <th>Good ID No</th>
                    <th>Goods </th>
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
               
                @php
              $sn =0
          @endphp
              @foreach($payments as $payment)
              @php
                $sn++
              @endphp


                <tr>
                    <td>{{$sn}}</td>
                    <td>{{$payment->payment_id_no}}</td>
                    <td>{{$payment->good_id_no}}</td>
                    <td>{{$payment->good_type}}</td>
                    <td>{{$payment->plate_number}}</td>
                    <td>{{$payment->driver_name}}</td>
                    <td>{{$payment->client_name}}</td>
                    <td>₦{{number_format($payment->good_cost,2)}}</td> 
                    <td>₦{{number_format($payment->payment_deposit,2)}}</td>
                    <td>₦{{number_format($payment->good_cost - $payment->payment_deposit,2)}}</td>
                     <td>{{date('d-m-Y', strtotime($payment->updated_at))}}</td>
                 
                </tr>
                @endforeach



              </tbody>
              </table>
              @else
                  <p class="text-info">No Good Has been full Paid</p>
              @endif
          </div>

          <div class="tab-pane fade " id="two" role="tabpanel" aria-labelledby="two-tab">
            {{-- <table class="table table-striped table-responsive  table-bordered" width="100%"> --}}
            

             @if (count($dpayments)>0)
                 
            
              <table class="table table-striped table-responsive  table-bordered" width="100%" id="dataTable1">
            
              <thead>
                  <tr>
                    <th>SN</th>
                    <th>Payment ID</th>
                    <th>Good ID No</th>
                    <th>Goods </th>
                    <th>Plate Number</th>
                    <th>Driver Name</th>
                    <th>Client</th>
                    <th>Goods Cost</th>
                    <th>Amount Deposited</th>
                    <th>Balance</th>
                    <th  class="text-center">Action</th>
                  </tr>
              </thead>
              <tbody>
                
                @php
              $sn =0
          @endphp
              @foreach($dpayments as $dpayment)
              @php
                $sn++
              @endphp
                <tr>
                    <td>{{$sn}}</td>
                    <td>{{$dpayment->payment_id_no}}</td>
                    <td>{{$dpayment->good_id_no}}</td>
                    <td>{{$dpayment->good_type}}</td>
                    <td>{{$dpayment->plate_number}}</td>
                    <td>{{$dpayment->driver_name}}</td>
                    <td>{{$dpayment->client_name}}</td>
                    <td>₦{{number_format($dpayment->good_cost,2)}}</td> 
                    <td>₦{{number_format($dpayment->payment_deposit,2)}}</td>
                    <td>₦{{number_format($dpayment->good_cost - $dpayment->payment_deposit,2)}}</td>
                    <td>
                      <a href="{{ route('payments.edit', ['payment' => $dpayment->payment_id]) }}" class="btn btn-primary" onclick="return confirm('Are You Sure to Update this payment?')">
                          Update Payment <i class="fa fa-fw fa-edit"></i>
                      </a>
                  </td>
  
                </tr>
                @endforeach



              </tbody>
              </table>
              @else
                 <p class="text-info">No Default Payment Remaining</p>
              @endif
          </div>
         



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