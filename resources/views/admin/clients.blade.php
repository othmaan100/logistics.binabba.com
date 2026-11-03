@extends('layouts.admin')
@section("headers")
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" rel="stylesheet">
@endsection
@section('content')
<!-- <style>
  .uper {
    margin-top: 40px;
  }
  body{
    counter-reset: Serial;  /*set the serial counter to zero*/
  }
  table{
    border-collapse: collapse;
  }
  tr td:first-child::before{
    counter-increment: Serial;
    content: counter(Serial);
  }
   td{
    margin: 0px;
    padding: 0px;
  }
  .btn{
    font-size: 1em;
  }

  div.b {
  position: absolute;
  right: 0;
  width: auto;
  
 
} 
  div.a {
  position: absolute;
  left: 0;
  width: auto;
  
 
}  -->
</style>

  <div class="card uper">

        <div class="card-header ">
        
              <div class="d-flex justify-content-between"> 
                    <div class="p-2 bd-highlight">
                        <a class="btn btn-primary a" href="{{ route('admin-clients.create') }}">  Add New client  </a>
                  </div>
                  <div class="p-2 bd-highlight">
                      <a align ="right" class="btn btn-primary pull-right md-offet-6 b"  href="{{ route('admin-clients.indexpdf') }}">  Download PDF List  </a>

                  </div>
          </div>
  </div>
 
  <div class="card-body col-md-12">
    @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}  
    </div>
  @endif
  

  <div class="table-responsive">
    <table class="table table-bordered m-0 p-0" id="dataTable" >
        <thead>
            <tr>
                <th>SN</th>
                <th>Client Name</th>
                <th>Phone Number</th>
                <th>Address</th>
                <th>Date Registered</th>
                <th  class="text-center">Action</th>
                
            </tr>
        </thead>
        <tbody>
        @php
           $sn =0
        @endphp
            @foreach($clients as $client)
              @php
                  $sn++
              @endphp      
            <tr>
                <td>{{$sn}}</td>
                <td>{{ $client->client_name }}</td>
                <td>{{ $client->client_phone }}</td>
                <td>{{ $client->client_address }}</td>
                <td>{{ date('d-m-Y', strtotime($client->created_at)) }}</td>
                <td>
                    <a href="{{ route('admin-clients.edit', ['admin_client' => $client->id]) }}" class="btn btn-primary responsive">Edit <i class="fa fa-fw fa-edit"></i></a>
                
                    <a class="btn btn-success" href="{{ route('admin-clients.transactions', $client->id) }}">Transactions <i class="fa fa-fw fa-history"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>

        <tfoot>
              <tr>
                      <th>SN</th>
                      <th>Client Name</th>
                      <th>Phone Number</th>
                      <th>Address</th>
                      <th>Date Registered</th>
                      <th  class="text-center">Action</th>
                      
              </tr>
          </tfoot>
    </table>
    <div class="d-flex justify-content-center">
       
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