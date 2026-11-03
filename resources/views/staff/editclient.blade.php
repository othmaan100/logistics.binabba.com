@extends('layouts.staff')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
  <a class="btn btn-primary " href="{{ route('clients.index') }}"> Back</a>
  
  <div class="card-header">
   <div class="text-center "> <h4> Edit client Information </h4></div>
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
  
   
      
      <form method="post" action="{{ route('clients.update', ['client' =>$client->id]) }}">
                @csrf

        @method('PUT')
 
       

          <div class="form-group">
              <label for="client_name">Client's Name:</label>
              <input type="text" class="form-control" name="client_name" id="client_name" value="{{ $client->client_name }}">
           </div>
           <div class="form-group">
              <label for="client_phone">Phone Number:</label>
              <input type="text" class="form-control" name="client_phone" id="client_phone" maxlength="11" value={{ $client->client_phone }}>
           </div>

        <div class="form-group">
            <label for="client_address ">Address:</label>
            <textarea name="client_address" id="client_address" class="form-control">{{ $client->client_address }}</textarea>
            
        </div>
        
        <button type="submit" class="btn btn-primary">Update</button>
       
      </form>
  </div> 
</div>
@endsection