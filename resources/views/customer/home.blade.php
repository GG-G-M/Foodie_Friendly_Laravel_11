@extends('layouts.app')

@section('title', 'Food Menu')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Food Menu</h1>
    <div class="row">
        @foreach ($foods as $food)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0">
                    <img src="{{ asset('storage/' . $food->image) }}" class="card-img-top" alt="{{ $food->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $food->name }}</h5>
                        <p class="card-text">{{ $food->description }}</p>
                        <p class="card-text"><strong>Price:</strong> ₱{{ number_format($food->price, 2) }}</p>
                        <form action="{{ route('cart.add', $food->id) }}" method="POST">
                            @csrf
                            <div class="form-group mb-2">
                                <label for="quantity">Quantity:</label>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" class="form-control border-brown" style="width: 100px;">
                            </div>
                            <button type="submit" class="btn btn-brown">Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <a href="{{ route('cart') }}" class="btn btn-brown">View Cart</a>
</div>
@endsection