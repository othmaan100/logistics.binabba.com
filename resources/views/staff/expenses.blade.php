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
  } */
</style>

  <div class="card uper">

  <div class="card-header">
  <div class="d-flex justify-content-between"> 
  <div class="p-2 bd-highlight">
   <a class="btn btn-primary" href="{{ route('expenses.create') }}"> <strong> Add New Expenses <i class="fa fa-fw fa-money"> </i></strong></a>
  </div>
 <div class="p-2 bd-highlight">
    <a align="right" class="btn btn-primary pull-right md-offet-6 b"  href="{{ route('expense.indexpdf') }}">  Download PDF List  </a>

 </div>

   </div>


  </div>
 
  <div class="card-body">
    @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}  
    </div><br />
  @endif
     <table class="table table-striped table-responsive" id="dataTable">
    <thead>
        <tr>
          <th>SN</th>
          <th>Date</th>
          <th>Good ID</th>
          <th>Plate Number</th>
          <th>Driver Name</th>
          <th>Expense Cost</th>
          <th>Reason</th>
          <th  class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
    @php
      $sn =0
  @endphp
  @foreach ($dexpenses as $expense)
      @php
          $sn++
      @endphp

        <tr>
          <td>{{$sn}}</td>
          <td>{{$expense->expenses_date}}</td>
          <td>{{$expense->good_id_no}}</td>
          <td>{{$expense->plate_number}}</td>
          <td>{{$expense->driver_name}}</td>
          <td>₦{{number_format($expense->expenses_cost,2)}}</td>
          <td>{{$expense->expenses_reason}}</td>
          <td><a href="{{ route('expenses.edit',$expense->expenses_id)}}" class="btn btn-primary" onclick="return confirm('Are You Sure to Edit this expenses?')">Edit <i class="fa fa-fw fa-edit"> </i></a></td>
              
        </tr>
        @endforeach
    </tbody>
  </table>
  </div>
  
  <div class="col-offset-9">
    <span class="fa-pull-right">
      <!-- Help in giving out links for paginated data-->
    </span>
    
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
} );
</script>

@endsection