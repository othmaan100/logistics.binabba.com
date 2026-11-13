<!DOCTYPE html>
<html>
<head>
  <title>Client Transaction History</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      /* background-color: #f4f4f4; */
    }
    .banner {
      /* background-color: #fff; */
      padding: 20px;
      text-align: center;
      border-bottom: 2px solid #ccc;
    }
    .banner h1 {
      margin: 0;
      font-size: 2em;
    }
    .banner p {
      margin: 5px 0;
    }
    .contact-info {
      margin-top: 20px;
    }
    .contact-info p {
      margin: 5px 0;
    }
    .table-responsive {
      margin: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: left;
    }
    th {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>
  <x-org-letterhead pdf />

  <!-- Client List Section -->
  <div>
    <h2 style="text-align:center">Stock Assignment List</h2>
    </div>
   
     
   

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
  
