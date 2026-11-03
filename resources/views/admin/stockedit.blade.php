@extends('layouts.admin')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
  <a class="btn btn-primary" href="{{ route('admin-stocks.index') }}"> Back</a>

  <div class="card-header text-center">
   <strong> Edit Stock </strong>
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
  
        <br/>
        <br/>
        <form method="POST" action="{{ route('admin-stocks.update', $stock->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="stock" class="font-weight-bold col-md-2"><strong> Stock:</strong></label>
        <input type="text" class="form-control col-md-4" maxlength="10" name="stock" id="stock" value="{{ old('stock', $stock->stock) }}">
    </div>

    <div class="form-group">
        <label for="price" class="font-weight-bold col-md-2"><strong> Unit Price:</strong></label>
        <input type="text" class="form-control col-md-4" maxlength="10" name="price" id="price" value="{{ old('price', $stock->unit_price) }}">
    </div>

    <div class="form-group">
        <label for="quantity" class="font-weight-bold col-md-2"><strong> Quantity:</strong></label>
        <input type="text" class="form-control col-md-4" maxlength="10" name="quantity" id="quantity" value="{{ old('quantity', $stock->quantity) }}">
    </div>

    <div class="form-group">
        <label for="description" class="font-weight-bold col-md-2"><strong> Description:</strong></label>
        <textarea name="description" id="description" class="form-control col-md-4">{{ old('description', $stock->description) }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
</form>

  </div> 
</div>
<script>
  $('#unassd').onClick(function(){
      var id= $('#unassd').attr('d');
      console.log(id);
  });
</script>
@endsection