@extends('layouts.admin')

@section('content')
<style>
    .uper {
        margin-top: 40px;
    }
</style>

<div class="card uper">
   
    <div class="card-header text-center">
        <strong>Assign Stock to Goods</strong>
    </div>

    <div class="card-body">
        <!-- Display stock details -->
        <div class="mb-4">
            <h5 class="text-info"><strong>Stock Details:</strong></h5>
            @foreach ($stocks as $stock)
                <ul class="list-group mb-3">
                    <li class="list-group-item">
                        <strong>Stock Name:</strong> {{ $stock->stock }}
                    </li>
                    <li class="list-group-item">
                        <strong>Stock Type:</strong> {{ $stock->type }}
                    </li>
                    <li class="list-group-item">
                        <strong>Available Quantity:</strong> {{ $stock->quantity }}
                    </li>
                    <li class="list-group-item">
                        <strong>Unit Price:</strong> ₦{{ number_format($stock->unit_price, 2) }}
                    </li>
                    <li class="list-group-item">
                        <strong>Description:</strong> {{ $stock->description }}
                    </li>
                   
                </ul>
                 @endforeach

                <!-- Assign Stock to Goods Form -->
                <form method="POST" action="{{ route('admin-stocks.assign.store', $stock->stock_id) }}">
                    @csrf
                    <div class="form-group row">
                        <label for="good_id" class="col-md-4 col-form-label text-md-right"><strong>Select Good to Assign:</strong></label>
                        <div class="col-md-6">
                            <select class="form-control" name="good_id" id="good_id" required>
                                <option value="" selected disabled>Select Good</option>
                                @foreach ($goods as $good)
                                    <option value="{{$good->good_id}}">
                                        {{$good->good_id_no}} Carried By: {{$good->plate_number}} Driver: {{$good->driver_name}}  on {{date('d-m-Y',strtotime($good->good_date_of_pickup))}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="quantity" class="col-md-4 col-form-label text-md-right"><strong>Quantity to Assign:</strong></label>
                        <div class="col-md-6">
                          <input type="hidden" name="stock_id" id="stock_id" value="{{ $stock->stock }}">
                            <input 
                                type="number" 
                                class="form-control" 
                                name="quantity" 
                                id="quantity" 
                                min="1" 
                                max="{{ $stock->quantity }}" 
                                required 
                                placeholder="Enter quantity to assign"
                            />
                        </div>
                    </div>

                    <div class="form-group row justify-content-center">
                        <div class="col-md-6 text-center">
                            <button type="submit" class="btn btn-success">Assign Stock</button>
                        </div>
                    </div>

           
        </div>
    </div>
</div>

@endsection
