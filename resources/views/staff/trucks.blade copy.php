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

  <div class="card-header mt-3 tab-card">

<div class="d-flex justify-content-between"> 
  <div class="p-2 bd-highlight">
 <a class="btn btn-primary" href="{{ route('admin-trucks.create') }}"><strong> Add New truck  <i class="fa fa-fw fa-truck"> </i></strong></a>
    </div>

   </div>





    <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
      <li class="nav-item">
          <a class="nav-link active" id="one-tab" data-toggle="tab" href="#one" role="tab" aria-controls="One" aria-selected="true">Assigned Trucks</a>
      </li>
      <li class="nav-item">
          <a class="nav-link" id="two-tab" data-toggle="tab" href="#two" role="tab" aria-controls="Two" aria-selected="false">Unassigned Trucks</a>
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
 @if (count($trucks)>0)
     
   <div class="table-responsive">
      <table class="table table-striped table-bordered" id="dataTable">
    <thead>
      
        <tr>
          <th>  SN </th>
          <th> Truck Model </th>
          <th> Plate Number </th>
          <th> Driver ID </th>
          <th> Assigned To </th>
          <th>Date Registered</th>
          <th  class="text-center"> Action </th>
          <th></th>
         
        </tr>
    </thead>
    <tbody>
      @php
           $sn =0
        @endphp
        @foreach($trucks as $truck)
        @php
                  $sn++
        @endphp

        {{$truck}}
        
        <tr>
            <td>{{$sn}}</td>
            <td>{{ $truck->truck_model ? $truck->truck_model : 'No Truck' }}</td>
            <td>{{$truck->plate_number}}</td>
            <td>{{$truck->driver_id_no}}</td>
            <td>{{$truck->driver_name}}</td>
             <td>{{date('d-m-Y', strtotime($truck->created_at))}}</td>
            <td><a href="{{ route('admin-trucks.edit',$truck->id)}}" class="btn btn-primary">Edit <i class="fa fa-fw fa-edit"> </i></a></td>
             <td><a class="btn btn-success" href="{{ route('trucks.operations',$truck->id) }}">Operations <i class="fa fa-fw fa-history"> </i></a></td>
        
        </tr>
        @endforeach
    </tbody>
  </table>
  </div>
  @else
     <p class="text-info">No Truck Assigned to Any driver</p>
  @endif 
    </div>

    <div class="tab-pane fade " id="two" role="tabpanel" aria-labelledby="two-tab">
      @if (count($ntrucks)>0)
     
    <div class="table-responsive">
      <table class="table table-striped table-bordered" id="dataTable1">
        <thead>
          
            <tr>
              <th>  SN </th>
              <th> Truck Model </th>
              <th> Plate Number </th>
              
              <th  class="text-center"> Action </th>
              <th></th>
              
            </tr>
        </thead>
        <tbody>
        @php
            $sn =0
        @endphp
        @foreach($ntrucks as $ntruck)
              @php
                  $sn++
              @endphp
          
            <tr>
                <td>{{$sn}}</td>
                <td>{{$ntruck->truck_model}}</td>
                <td>{{$ntruck->plate_number}}</td>
                
                <td><a href="{{ route('admin-trucks.edit',$ntruck->id)}}" class="btn btn-primary">Edit / Assign Driver <i class="fa fa-fw fa-edit"> </i></a></td>
                 <td><a class="btn btn-success" href="{{ route('trucks.operations',$ntruck->id) }}">Operations <i class="fa fa-fw fa-history"> </i></a></td>
                
            </tr>
            @endforeach
        </tbody>
      </table>
      </div>
      @else
      <p class="text-info">No Truck Registered</p>
   @endif 


    </div>

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