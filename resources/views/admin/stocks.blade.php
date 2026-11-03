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
  body {
    counter-reset: Serial;  /*set the serial counter to zero*/
  }
</style>

<div class="card uper">
  <div class="card-header">
    <div class="d-flex justify-content-between"> 
      <div class="p-2 bd-highlight">
          <a class="btn btn-primary" href="{{ route('admin-stocks.create') }}">  <strong>Add New Stock <i class="fa fa-fw fa-money"></i></strong> </a>

          <a align="right" class="btn btn-primary pull-right md-offet-6 strong"  href="{{ route('admin-stocks.assignPDF') }}">    Download Stock Assignment List  </a>

         

                  
      </div>
    </div>

    <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="one-tab" data-toggle="tab" href="#one" role="tab" aria-controls="one" aria-selected="true">Stocks</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="two-tab" data-toggle="tab" href="#two" role="tab" aria-controls="two" aria-selected="false">Assigned Stocks</a>
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
      <!-- Stocks Tab -->
      <div class="tab-pane fade show active" id="one" role="tabpanel" aria-labelledby="one-tab">
        <div class="table-responsive">
          @if (count($stocks) > 0)
            <table class="table table-striped table-responsive" id="dataTable">
              <thead>
                <tr>
                  <th>SN</th>
                  <th>Stock Type</th>
                  <th>Stock</th>
                  <th>Stock Quantity</th>
                  <th>Stock Description</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @php $sn = 0; @endphp
                @foreach($stocks as $stock)
                  @php $sn++; @endphp
                  <tr>
                    <td>{{ $sn }}</td>
                    <td>{{ $stock->type }}</td>
                    <td>{{ $stock->stock }}</td>
                    <td>{{ $stock->quantity }}</td>
                    <td>{{ $stock->description }}</td>
                    <td>
                      <a href="{{ route('admin-stocks.edit', $stock->stock_id) }}" class="btn btn-primary">
                        Edit Stock <i class="fa fa-fw fa-edit"></i>
                      </a>
                      <a href="{{ route('admin-stocks.assignGood', $stock->stock_id) }}" class="btn btn-primary">
                        Assign To Goods <i class="fa fa-fw fa-edit"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th>SN</th>
                  <th>Stock Type</th>
                  <th>Stock</th>
                  <th>Stock Quantity</th>
                  <th>Stock Description</th>
                  <th>Action</th>
                </tr>
              </tfoot>
            </table>
          @else
            <p class="text-info">No stocks available.</p>
          @endif
        </div>
      </div>

      <!-- Assigned Stocks Tab -->
      <div class="tab-pane fade" id="two" role="tabpanel" aria-labelledby="two-tab">
        <div class="table-responsive col-md-12">

          @if (count($assgnedstocks) > 0)
            <table class="table table-striped table-responsive" width="100%" id="dataTable1" style="display: table;">
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
                  <!-- <th>Action</th> -->
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
                  <!-- <th>Action</th> -->
                </tr>
         
              </tfoot>
            </table>
          @else
          <p class="text-info">No assigned stocks data to display.</p>
          @endif

        </div>
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
    $('#dataTable').DataTable({
      dom: 'Bfrtip',
      buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5']
    });
    $('#dataTable1').DataTable({
      dom: 'Bfrtip',
      buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5']
    });
  });
</script>
@endsection
