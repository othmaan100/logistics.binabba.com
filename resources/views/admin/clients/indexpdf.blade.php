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
    <h2 style="text-align:center">Clients List</h2>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered" width="100%">
      <thead>
        <tr>
          <th>SN</th>
          <th>Client Name</th>
          <th>Phone Number</th>
          <th>Address</th>
          <th>Date Registered</th>
        </tr>
      </thead>
      <tbody>
      @php $i = 0; @endphp
        @foreach($clients as $client)
            @php $i++; @endphp
       

        <tr>
          <td>{{ $i }}</td>
          <td>{{ $client->client_name }}</td>
          <td>{{ $client->client_phone }}</td>
          <td>{{ $client->client_address }}</td>
          <td>{{ date('d-m-Y', strtotime($client->created_at)) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</body>
</html>
