@extends('layouts.staff')
@section("headers")
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" rel="stylesheet">
@endsection
@section('content')
<style>
   body{
        font-size: .8rem;
    }
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
              <a class="btn btn-primary" href="{{ route('goods.create') }}"> Add New Good <i class="fa fa-fw fa-boxes"></i></a>
        </div>
      <div class="p-2 bd-highlight">
          <a align="right" class="btn btn-primary pull-right md-offet-6 b"  href="{{ route('goods.indexdpdf') }}">  Download Delivered Goods List  </a>
          <a align="right" class="btn btn-primary pull-right md-offet-6 b"  href="{{ route('goods.indexpdf') }}">  Download UnDelivered Goods List  </a>
      </div>
    </div>



   <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
      <li class="nav-item">
          <a class="nav-link active" id="one-tab" data-toggle="tab" href="#one" role="tab" aria-controls="One" aria-selected="true">Delivered</a>
      </li>
      <li class="nav-item">
          <a class="nav-link" id="two-tab" data-toggle="tab" href="#two" role="tab" aria-controls="Two" aria-selected="false">Not Delivered</a>
      </li>
    </ul>
  </div>
 
  <div class="tab-content" id="myTabContent"> 
    <h5>List of Goods Records</h5>
    @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}  
    </div><br />
  @endif
  
  <div class="tab-pane fade show active p-3" id="one" role="tabpanel" aria-labelledby="one-tab">
    @if (count($dgoods)>0)
     <table class="table table-striped table-responsive" id="dataTable">
    <thead>
        <tr>
          <th>S/N</th>
          <th>Goods ID</th>
          <th>Goods Type</th>
          <th>Pickup Point</th>
          <th>Delivery Point</th>
          <th>Client</th>
          <th>Driver</th>
          <th>Truck</th>
          <th>Delivery Date</th>
          <th  class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        
        @php
        $sn =0
    @endphp
        @foreach($dgoods as $dgood)
        @php
          $sn++
        @endphp


        <tr>
            <td>{{$sn}}</td>
            <td>{{$dgood->good_id_no}}</td>
            <td>{{$dgood->good_type}}</td>
            <td>{{$dgood->good_pickup_point}}</td>
            <td>{{$dgood->good_delivery_point}}</td>
            <td>{{$dgood->client_name}}</td>
            <td>{{$dgood->driver_name}}</td>
            <td>{{$dgood->plate_number}}</td>
             <td>{{$dgood->good_date_of_delivery}}</td>
            <td><a class="btn btn-primary" href="{{ route('goods.show',$dgood->good_id) }}" >Show <i class="fa fa-fw fa-eye"></i></a></td>

        </tr>
        @endforeach
    </tbody>
  </table>
  <div class="d-flex justify-content-center">
        
    </div>
  @else
  <p class="text-info">No Delivered Good(s) Has been Recorded</p>
@endif
  </div>
  <div class="tab-pane fade p-3" id="two" role="tabpanel" aria-labelledby="two-tab">
    @if (count($goods)>0)  
    <table class="table table-striped table-responsive" id="dataTable1">
      <thead>
          <tr>
            <th>S/N</th>
            <th>Goods ID</th>
            <th>Goods Type</th>
            <th>Pickup Point</th>
            <th>Delivery Point</th>
            <th>Client</th>
            <th>Driver</th>
            <th>Truck</th>
            <th>PickUp Date</th>
            <th class="text-center">Action</th>
            <th></th>
            <th></th>
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
              <td>{{$good->client_name}}</td>
              <td>{{$good->driver_name}}</td>
              <td>{{$good->plate_number}}</td>
              <td> {{date('d-m-Y',strtotime($good->good_date_of_pickup))}}</td>
              <td><a href="{{ route('goods.edit',$good->good_id)}}" class="btn btn-primary" >Edit <i class="fa fa-fw fa-edit"> </i> </a></td>
              <td><a class="btn btn-primary" href="{{ route('goods.show',$good->good_id) }}" >Show <i class="fa fa-fw fa-eye"></i></a></td>
              <td><a class="btn btn-danger" href="{{ route('goods.dedit',$good->good_id) }}" onclick="return confirm('Are You Sure the Goods are delivered?')">Click on Delivery <i class="fa fa-fw fa-eye"></i></a></td>
             

          </tr>
          @endforeach
      </tbody>
    </table>
    <div class="d-flex justify-content-center">
       
    </div>
    @else
    <p class="text-info">No Undelivered Good(s) Has been Recorded</p>
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