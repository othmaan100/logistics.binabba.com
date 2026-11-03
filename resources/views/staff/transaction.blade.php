@extends('layouts.staff')
@section("headers")
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" rel="stylesheet">
    <!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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

/*   table, th, td
{
  border-collapse:collapse;
  border: 1px solid black;
  width:100%;
  text-align:right;
} */
</style>

  <div class="card uper">
    <a class="btn btn-primary " href="{{ route('admin-clients.index') }}"> Back</a>
  
  <div class="card-header">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" data-whatever="">Add Bulky Advance</button>
    <div class="fa-pull-right">
      <label for="Balance" class="font-weight-bold">Bulky Advance: ₦ </label><input type="text" name="bulky_advance" value="{{number_format($client->bulky_advance,2)}}" id="Balance" disabled>

    <label for="Balance" class="font-weight-bold">Balance: ₦ </label><input type="text" name="Balance" value="{{number_format($client->bulky_advance-$total_cost,2)}}" id="Balance" disabled>

    </div>    
</div>
 
  <div class="card-body">
   <img src="{{asset('imgs/invoiceheader.png')}}" alt="">
      <h4 class="text-center font-weight-bold">Client's Transaction History</h4>
      <hr>
    <div class="row">
     
        <div class="col-md-3 font-weight-bold">Client's Name:</div> <div class="col-md-5">{{$client->client_name}}</div> 
    </div>
    <div class="row">
        <div class="col-md-3 font-weight-bold">Address:</div> <div class="col-md-5">{{$client->client_address}}</div>
    </div>
    <div class="row">
            <div class="col-md-3 font-weight-bold">Phone Number:</div> <div class="col-md-5">{{$client->client_phone}}</div>
    </div>
    <div class="row">
            <div class="col-md-3 font-weight-bold">Date Registered:</div> <div class="col-md-5">{{date('d-m-Y', strtotime($client->created_at))}}</div>
    </div>
    <div class="row">
            <div class="col-md-3 font-weight-bold">Total Transactions Amount:</div> <div class="col-md-5 text-danger font-weight-bold">₦{{number_format($total_cost,2)}}</div>
    </div>




    @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}  
    </div><br />
  @endif
  @if(count($trans)>0)
  
  <div class="container">
    
      <table class="table table-bordered table-responsive" width="80%" id="dataTable"> 
       
    <thead class="thead-dark">
     
    
     
        <tr>
          <th>SN</th>
          <th>Good ID</th>
          <th>Good Type</th>
          <th>Pickup Point</th>
          <th>Delivery Point</th>
          <th>Cost of Good</th>
          <th>Date</th>
          </tr>
      
    </thead>
    <tbody>
        @php
              $sn =0
          @endphp                      
        @foreach($trans as $tran)
        @php
            $sn++
        @endphp
        <tr>
            <td>{{$sn}}</td>
            <td>{{$tran->good_id_no}}</td>
            <td>{{$tran->good_type}}</td>
            <td>{{$tran->good_pickup_point}}</td>
            <td>{{$tran->good_delivery_point}}</td>
            <td>₦{{number_format($tran->good_cost,2)}}</td>
            <td>{{date('d-m-Y', strtotime($tran->created_at))}}</td>

        </tr>
        @endforeach
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>Total</th>
          <th colspan="2">₦{{number_format($total_cost,2)}}</th>
          <th></th>
          
        </tr>
    </tbody>
  </table>
  <!-- <a class="btn btn-primary" href="{{ route('clients.transactionspdf',$client->id) }}">Download PDF</a> -->
   
</div>
  @else 
  <br>  
  <p class="text-info ">No Transaction Recorded</p>
@endif
  </div>
</div>



<!--Modal Begining-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Bulky Advance</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
          <input type="hidden"  id="client_id" name="client_id" value="{{$client->id}}">
            <div class="form-group">
                @csrf
              <label for="amount" class="col-form-label">Bulky Advance(₦):</label>
              <input type="text"  class="form-control" id="bulky_advance"  name="bulky_advance" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" >
            </div>
            <button type="button" class="btn btn-primary" id="add">Update Paymet</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         </div>
      </div>
    </div>
  </div>
<!--Modal End-->
<script>
    $(document).ready(function(){
    
    // haddling the post for adding record
    $('#add').click(function(){
     // alert('You don click am');
        var bulky_advance = $('#bulky_advance').val();
        var client_id = $('#client_id').val();
        var _token= $('input[name="_token"]').val();
    
         
       var datas="add="+1+"&bulky_advance="+bulky_advance+"&client_id="+client_id+"&_token="+_token;
      // var datas="good_id="+good_id+"&_token="+_token;
    // alert(datas);  
        //action
        $.ajax({
        type: "POST",
        url: "{{ route('clients.bupdate', $client->id) }}",
        data: datas,
        success:function(data){
    
          event.preventDefault();
            jQuery.noConflict();      
          $('#myModal').modal('hide');
               location.reload();





          // // Redirect to the route
          //   window.location.href = '/admin-clients'; // The corresponding route URL

          //   // Simulate flash message using localStorage
          //   localStorage.setItem('success', 'Client Bulky-Advance updated successfully');

          //   // On the redirected page, you can retrieve and display the message like this
          //   document.addEventListener('DOMContentLoaded', function() {
          //       const message = localStorage.getItem('success');
          //       if (message) {
          //           alert(message);  // You can display it in an alert or any other way you want
          //           localStorage.removeItem('success'); // Clear the message after showing it
          //       }
          //   });







    
        },
        error: function(xhr,status,error){
           var errrmsg=xhr.status+ ': '+xhr.statusText;
            alert('Eror-'+ errrmsg);
  }
        }); 
    
    });

/*    
    $("input[data-type='currency']").on({
    keyup: function() {
      formatCurrency($(this));
    },
    blur: function() { 
      formatCurrency($(this), "blur");
    }
});


function formatNumber(n) {
  // format number 1000000 to 1,234,567
  return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
}*/


/*function formatCurrency(input, blur) {
  // appends $ to value, validates decimal side
  // and puts cursor back in right position.
  
  // get input value
  var input_val = input.val();
  
  // don't validate empty input
  if (input_val === "") { return; }
  
  // original length
  var original_len = input_val.length;

  // initial caret position 
  var caret_pos = input.prop("selectionStart");
    
  // check for decimal
  if (input_val.indexOf(".") >= 0) {

    // get position of first decimal
    // this prevents multiple decimals from
    // being entered
    var decimal_pos = input_val.indexOf(".");

    // split number by decimal point
    var left_side = input_val.substring(0, decimal_pos);
    var right_side = input_val.substring(decimal_pos);

    // add commas to left side of number
    left_side = formatNumber(left_side);

    // validate right side
    right_side = formatNumber(right_side);
    
    // On blur make sure 2 numbers after decimal
    if (blur === "blur") {
      right_side += "00";
    }
    
    // Limit decimal to only 2 digits
    right_side = right_side.substring(0, 2);

    // join number by .
    //input_val = "₦" + left_side + "." + right_side;
    input_val =  left_side + "." + right_side;

  } else {
    // no decimal entered
    // add commas to number
    // remove all non-digits
    input_val = formatNumber(input_val);
    //input_val = "₦" + input_val;
    input_val = "₦" + input_val;
    
    // final formatting
    if (blur === "blur") {
      input_val += ".00";
    }
  }
  
  // send updated string to input
  input.val(input_val);

  // put caret back in the right position
  var updated_len = input_val.length;
  caret_pos = updated_len - original_len + caret_pos;
  input[0].setSelectionRange(caret_pos, caret_pos);
}*/



    
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
} );
</script>

@endsection