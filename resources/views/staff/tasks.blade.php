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

   table, th, td
{
  border-collapse:collapse;
  border: 1px solid black;
  width:100%;
  text-align:right;
} */
</style>

  <div class="card uper">
    <a class="btn btn-primary" href="{{ route('drivers.index') }}"> <i class="fa fa-arrow-left"></i> List of Drivers</a>

  <div class="card-header">
        
</div>
 
  <div class="card-body">
      <h4 class="text-center">Driver's Task History</h4>
      <hr>
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
            <div class="col-md-2 font-weight-bold">Truck Model:</div> 
           
               @if($truck)
                <div class="col-md-5">{{$truck->truck_model}}</div>
            @else
                <td>No Truck Model</td>
            @endif

    </div>
    

    <div class="row">
            <div class="col-md-2 font-weight-bold">Plate Number:</div>
            @if($truck)
            <div class="col-md-5">{{$truck->plate_number}}</div>
            @else
                <td>No Plate Number</td>
            @endif

             
    </div>
    
     <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
      <li class="nav-item">
          <a class="nav-link active" id="one-tab" data-toggle="tab" href="#one" role="tab" aria-controls="One" aria-selected="true">Uncompleted Task</a>
      </li>
      <li class="nav-item">
          <a class="nav-link" id="two-tab" data-toggle="tab" href="#two" role="tab" aria-controls="Two" aria-selected="false">Completed Task</a>
      </li>
    </ul>

 <div class="card-body">
    @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}  
    </div><br />
    
  @endif

   <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active " id="one" role="tabpanel" aria-labelledby="one-tab">

  @if(count($tasks)>0)
  
  <div class="container">
    
      <table class="table table-striped table-responsive" width="100%" id="dataTable" style="display: table;"> 
       
    <thead>
     
    
     
        <tr>
          <th>SN</th>
          <th>Good ID</th>
          <th>Good Type</th>
          <th>Pickup Point</th>
          <th>Delivery Point</th>
          <th>Cost of Good</th>
          <th>Date</th>
          <th>Action</th>
          <th></th>
        </tr>
      
    </thead>
    <tbody>
        
        @php
              $sn =0
          @endphp                      
        @foreach($tasks as $task)
        @php
            $sn++
        @endphp
        <tr>
            <td>{{$sn}}</td>
            <td>{{$task->good_id_no}}</td>
            <td>{{$task->good_type}}</td>
            <td>{{$task->good_pickup_point}}</td>
            <td>{{$task->good_delivery_point}}</td>
            <td>₦{{number_format($task->good_cost,2)}}</td>
            <td>{{date('d-m-Y', strtotime($task->good_date_of_pickup))}}</td>
             <td><a class="btn btn-success" href="{{ route('drivers.taskcomplete',$task->good_id) }}" onclick="return confirm('Are You Sure this Task is Settled?')">Click on Payment Completion</a></td>
            <td><a class="btn btn-danger" href="{{ route('drivers.taskdetails',$task->good_id) }}">View Expenses Details </a></td>

        </tr>
        @endforeach
        <tr>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
        </tr>
    </tbody>
  </table>
  
    </div>
  @else 
  <br>  
  <p class="text-info ">No Transaction Uncompleted Recorded</p>
@endif
  </div>

 <div class="tab-pane fade " id="two" role="tabpanel" aria-labelledby="two-tab">
   
  @if(count($ctasks)>0)
  
  <div class="container">
    
      <table class="table table-striped table-responsive" width="100%" id="dataTable1" style="display: table;"> 
       
    <thead>
        <tr>
          <th>SN</th>
          <th>Good ID</th>
          <th>Good Type</th>
          <th>Pickup Point</th>
          <th>Delivery Point</th>
          <th>Cost of Good</th>
          <th>Date</th>
          <th>Action</th>
          </tr>
      
    </thead>
    <tbody>
        @php
              $sn =0
          @endphp                      
        @foreach($ctasks as $ctask)
        @php
            $sn++
        @endphp
        <tr>
            <td>{{$sn}}</td>
            <td>{{$ctask->good_id_no}}</td>
            <td>{{$ctask->good_type}}</td>
            <td>{{$ctask->good_pickup_point}}</td>
            <td>{{$ctask->good_delivery_point}}</td>
            <td>₦{{number_format($ctask->good_cost,2)}}</td>
            <td>{{date('d-m-Y', strtotime($ctask->good_date_of_pickup))}}</td>
            <td><a class="btn btn-danger" href="{{ route('drivers.taskdetails',$ctask->good_id) }}">View Expenses Details </a></td>

        </tr>
        @endforeach
        <tr>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
        </tr>
    </tbody>
  </table>
  
    </div>
  @else 
  <br>  
  <p class="text-info ">No Completed Transaction Recorded</p>
@endif
  </div>
</div>




<script>
    $(document).ready(function(){
    
    /* // haddling the post for adding record
    $('.competed').click(function(){
     // alert('You don click am');
        var good_id = $('.competed').attr('d');
       
        var _token= $('input[name="_token"]').val();
    
         
       var datas="add="+1+"&good_id="+good_id+"&_token="+_token;
      console.log(datas);
        $.ajax({
        type: "POST",
        url: "",
        data: datas,
        success:function(data){
    
               
                location.reload();
    
        },
        error: function(xhr,status,error){
           var errrmsg=xhr.status+ ': '+xhr.statusText;
            alert('Eror-'+ errrmsg);
  }
        }); */
    
    });
    
    });
    
    
    
    </script>
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