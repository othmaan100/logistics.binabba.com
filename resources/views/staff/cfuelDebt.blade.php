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
                    <a class="btn btn-primary" href="{{ route('fuelDebts.create') }}"> <strong> Add New Fuel Debt <i class="fa fa-fw fa-money"> </i></strong></a>
                </div>


          </div>
  </div>
<div class="card-body">


  <h4 class="text-center">List of Fuel company Records</h4>
    @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}  
    </div>
  @endif
 
   @if (count($companies)>0)
     <table class="table table-striped table-responsive col-md-12" width="100%" id="dataTable">
    <thead>
        <tr>
          <th>SN</th>
          <th>Company</th>
           <th  class="text-center">Action</th>
           <th></th>
         
        </tr>
    </thead>
      <tbody>
      @php
        $sn =0
    @endphp
        @foreach($companies as $company)
        @php
          $sn++
        @endphp


        
        <tr>
          <td>{{$sn}}</td>
            <td>{{$company->company_name}}</td>
             <td><a href="{{ route('fuelDebts.cdebt',$company->company_id)}}" class="btn btn-primary">View Company Debt <i class="fa fa-fw fa-eye"> </i></a></td>
            <td>  @if (($company->balance)>0)
                 <a    class="btn btn-danger" href="{{ route('fuelDebts.payment',$company->company_id) }}" >Make Payment <i class="fa fa-fw fa-money-bill"></i></a>
             @else
                    
                     <a class="btn btn-success" > Paid <i class="fa fa-fw fa-money-bill"></i></a>

            @endif
            </td>
           
        </tr>
        @endforeach
    </tbody>
  </table>
  @else
  <p class="text-info">No company Has been Recorded</p>
@endif
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