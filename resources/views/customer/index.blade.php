@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Food Menu</h1>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="row">
            @foreach ($foods as $food)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">{{ $food->name }}</h5>
                            <p class="card-text">Price: ${{ $food->price }}</p>
                            <form action="{{ route('customer.addToCart', $food->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <a href="{{ route('customer.cart') }}" class="btn btn-success">View Cart</a>
        <a href="{{ route('customer.orders') }}" class="btn btn-info">View Orders</a>
    </div>
@endsection