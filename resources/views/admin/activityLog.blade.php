@extends("layouts.admin")
@section("title")
    Manage Users
@endsection
@section("headers")
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" rel="stylesheet">
@endsection
@section("content")
<div class="card shadow mb-4">
    

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Activity Log</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            
                
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Name</th>
                        <th>Activity</th>
                        <th>Role</th>
                        <th>Date </th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>S/N</th>
                        <th>Name</th>
                        <th>Activity</th>
                        <th>Role</th>
                        <th>Date </th>
                    </tr>
                </tfoot>
                <tbody>
                    @php
                        $sn =0
                    @endphp
                    @foreach ($logs as $log)
                        @php
                            $sn++
                        @endphp
                        <tr>
                            <td>{{$sn}}</td>
                            <td>{{$log->fullName}}</td>
                            <td>{{$log->email}}</td>
                            <td>{{$log->activity}}</td>
                            <td>{{date("d/m/Y H:i:s",strtotime($log->created_at))}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
} );
</script>

@endsection