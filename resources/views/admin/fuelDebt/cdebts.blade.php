@extends('layouts.app')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
  body{
    counter-reset: Serial;  /*set the serial counter to zero*/
  }
  table{
    border-collapse: separate;
  }
  tr td:first-child::before{
    counter-increment: Serial;
    content: counter(Serial);
  }
</style>

  <div class="card uper">

  <div class="card-header">
  <div class="d-flex justify-content-between"> 
  <div class="p-2 bd-highlight">
   <a class="btn btn-primary" href="{{ route('fuelDebt.create') }}"> <strong> Add New Fuel company <i class="fa fa-fw fa-money"> </i></strong></a>
  </div>
 <div class="p-2 bd-highlight">
    <a align="right" class="btn btn-primary pull-right md-offet-6 b"  href="{{ route('fuelDebt.indexppdf') }}">  Download Paid PDF List  </a>
     <a align="right" class="btn btn-primary pull-right md-offet-6 b"  href="{{ route('fuelDebt.indexpdf') }}">  Download Unpaid PDF List  </a>

 </div>

   </div>
<div class="card-body">


  <h5>List of Fuel company Records</h5>
    @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}  
    </div><br />
  @endif
 
   @if (count($cdebts)>0)
     <table class="table table-striped table-responsive" width="100%">
    <thead>
        <tr>
          <th>SN</th>
          <th>Company</th>
           <th colspan="2" class="text-center">Action</th>
         
        </tr>
    </thead>
    <tbody>
        @foreach($cdebts as $cdebt)
        
        <tr>
          <td></td>
            <td>{{$cdebt->company_name}}</td>
             <td><a href="{{ route('fuelDebt.cdebt',$company->company_id)}}" class="btn btn-primary">View Company Debt <i class="fa fa-fw fa-edit"> </i></a></td>
            <td><a class="btn btn-danger" href="{{ route('fuelDebt.dedit',$company->company_id) }}" >Click on Payment <i class="fa fa-fw fa-eye"></i></a></td>
           
        </tr>
        @endforeach
    </tbody>
  </table>
  @else
  <p class="text-info">No company Has been Recorded</p>
@endif
  </div>

  
  <div class="col-offset-9">
    <span class="fa-pull-right">
      <!-- Help in giving out links for paginated data-->
    </span>
    
    </div>

</div>
  
@endsection