<!DOCTYPE html>
<html>
<head>
  <title>Expenses List </title>
  <style>
  .uper {
    margin-top: 40px;
  }
  body{
    counter-reset: Serial;  /*set the serial counter to zero*/
    font-size: 1em;
  }
  th{
    border:1px solid black;
  }
   td{
    border:1px solid black;
    text-align: left;
  }
  table{
    border-collapse: collapse;
    text-align: center;
    font-size: .9em;

  }
  tr td:first-child::before{
    counter-increment: Serial;
    content: counter(Serial);

  }
  
   table td, table th {
        font-size: 10px;
    }
   
  .col-md-6{width:50%}
  .col-md-9{width:75%}
  .row{margin-right:-15px;margin-left:-15px}
</style>
</head>
<body>


 
  <div >
   
 <x-org-letterhead />
<hr > 
</div>
    <div >
    <h2 align="center">Stock Assignment List</h2>
    </div>
   
     
   {{$assgnedstocks}}

     <table class="table table-striped table-responsive" width="100%">
     <thead>
                <tr>
                  <th>SN</th>
                  <th>Driver</th>
                  <th>Truck</th>
                  <th>Stock Type</th>
                  <th>Stock</th>
                  <th>Stock Quantity</th>
                  <th>Good</th>
                  <th>Date Assigned</th>
                  
                </tr>
              </thead>
              <tbody>
                @php $sn = 0; @endphp
                @foreach($assgnedstocks as $stock)
                  @php $sn++; @endphp
                  <tr>
                    <td>{{ $sn }}</td>
                    <td>{{ $stock->driver_name }}</td>
                    <td>{{ $stock->truck_model }} {{ $stock->plate_number }}</td>
                    <td>{{ $stock->type }}</td>
                    <td>{{ $stock->stock }}</td>
                    <td>{{ $stock->quantity }}</td>
                    <td>{{ $stock->good_type }}</td>
                    <td>{{ $stock->date }}</td>
                  
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
            
                <tr>
                  <th>SN</th>
                  <th>Stock Type</th>
                  <th>Stock</th>
                  <th>Stock Quantity</th>
                  <th>Good</th>
                  <th>Truck</th>
                  <th>Driver</th>
                  <th>Date Assigned</th>
                </tr>
         
              </tfoot>
            </table>
  </div>

    
    </div>

</div>
  
