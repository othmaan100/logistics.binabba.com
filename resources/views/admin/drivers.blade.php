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
    border-collapse: collapse;
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
       <a class="btn btn-primary" href="{{ route('admin-drivers.create') }}"> <strong> Add New Driver <i class="fa fa-fw fa-user"> </i></strong></a>
  
  </div>
 <div class="p-2 bd-highlight">
   
 </div>

   </div>

    <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
      <li class="nav-item">
          <a class="nav-link active" id="one-tab" data-toggle="tab" href="#one" role="tab" aria-controls="One" aria-selected="true">Assigned to Trucks</a>
      </li>
      <li class="nav-item">
          <a class="nav-link" id="two-tab" data-toggle="tab" href="#two" role="tab" aria-controls="Two" aria-selected="false">Unassigned to Trucks</a>
      </li>
    </ul>

  </div>
 
  <div class="card-body">
    @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}  
    </div><br />
  @endif

  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active " id="one" role="tabpanel" aria-labelledby="one-tab">
 @if (count($adrivers)>0)
  

     <div class="table-responsive">
     <table class="table table-bordered " id="dataTable">
   <thead>
        <tr>
          <th>SN</th>
          <th>ID</th>
          <th>Truck Model</th>
          <th>Plate Number</th>
          <th>Name</th>
          <th>Phone</th>
          <th>Address</th>
          <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
    @php
        $sn =0
    @endphp
        @foreach($adrivers as $adriver)
        @php
          $sn++
        @endphp
        <tr>
          <td>{{$sn}}</td>
            <td>{{$adriver->driver_id_no}}</td>
             <th>{{$adriver->truck_model}}</th>
            <th>{{$adriver->plate_number}}</th>
            <td>{{$adriver->driver_name}}</td>
            <td>{{$adriver->driver_phone}}</td>
            <td>{{$adriver->driver_address}}</td>
            <td>
            <a href="{{ route('admin-drivers.edit',['admin_driver'=>$adriver->driver_id])}}" class="btn btn-primary">Edit <i class="fa fa-fw fa-edit"> </i></a>
            <a class="btn btn-secondary" href="{{ route('admin-drivers.show',['admin_driver'=>$adriver->driver_id]) }}">Show <i class="fa fa-fw fa-eye"> </i></a>
            <a class="btn btn-success" href="{{ route('admin-drivers.tasks',$adriver->driver_id) }}">Tasks <i class="fa fa-fw fa-tasks"> </i></a>
          </td>
                   </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>SN</th>
            <th>ID</th>
            <th>Truck Model</th>
            <th>Plate Number</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Address</th>
            <th class="text-center">Action</th>
          </tr>
    </tfoot>
  </table>
  <div class="d-flex justify-content-center">
       
    </div>
  </div>
  @else
     <p class="text-info">No Driver Assigned to Any Truck  </p>
  @endif 
    </div>

    <div class="tab-pane fade " id="two" role="tabpanel" aria-labelledby="two-tab">
      @if (count($drivers)>0)
     
    <div class="table-responsive">
     
      <table class="table table-bordered " id="dataTable1">
   <thead>
        <tr>
          <th>SN</th>
          <th>ID</th>
          <th>Name</th>
          <th>Phone</th>
          <th>Address</th>
          <th  class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>

      @php
          $sn =0
      @endphp
      @foreach($drivers as $driver)
        @php
          $sn++
        @endphp

        
        <tr>
            <td>{{ $sn }}</td>
            <td>{{$driver->driver_id_no}}</td>
            <td>{{$driver->driver_name}}</td>
            <td>{{$driver->driver_phone}}</td>
            <td>{{$driver->driver_address}}</td>
            <td><a href="{{ route('admin-drivers.edit',['admin_driver'=>$driver->driver_id])}}" class="btn btn-primary">Edit <i class="fa fa-fw fa-edit"> </i></a>
                <a class="btn btn-secondary" href="{{ route('admin-drivers.show',['admin_driver'=>$driver->driver_id]) }}">Show <i class="fa fa-fw fa-eye"> </i></a>
                <a class="btn btn-success" href="{{ route('drivers.tasks',$driver->driver_id) }}">Tasks <i class="fa fa-fw fa-tasks"> </i></a>
            </td>
      
        </tr>
        @endforeach
    </tbody>
  </table>
  <div class="d-flex justify-content-center">
       
    </div>
  </div>
  @else
     <p class="text-info">No Driver Unassigned to a Truck</p>
  @endif 
    </div>


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