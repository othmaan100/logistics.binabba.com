@extends('layouts.admin')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
  <div class="card-header text-center">
   <strong> Register client </strong>
  </div>
  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
      <form method="post" action="{{ route('admin-clients.store') }}">
          
          
            <div class="form-group col-md-4">
                 @csrf
                <label for="title"><strong> Title:</strong></label>
                <select class=" form-control"   id="title" name="title" >
                  <option value="">select</option>
                  <option value="Mr.">Mr.</option>
                  <option value="Mrs.">Mrs.</option>
                  <option value="Alh.">Alh.</option>
                  <option value="Haj.">Haj.</option>
                  <option value="Mal.">Mal.</option>
                  <option value="Dr.">Dr.</option>
                  <option value="Prof.">Prof.</option>
              
          </select> 


            </div>
            <div class="form-group col-md-6">
                 @csrf
                <label for="client_name"><strong>  Client's Name:</strong></label>
                <input type="text" class="form-control" name="client_name" id="client_name">
             </div>
             <div class="form-group col-md-5">
                <label for="client_phone"><strong> Phone Number:</strong></label>
                <input type="text" class="form-control" name="client_phone" id="client_phone" maxlength="11">
             </div>

          <div class="form-group col-md-6">
              <label for="client_address "><strong> Address:</strong></label>
              <textarea name="client_address" id="client_address" class="form-control"></textarea>
              
          </div>
         {{--  <div class="form-group col-md-5">
            <label for="client_phone"><strong> Picture Upload:</strong></label>
            <input type="file" name="image" id="image"class="form-control">
         </div> --}}
          <button type="submit" class="btn btn-primary center">Save Record</button>
      </form>
  </div>
</div>
@endsection