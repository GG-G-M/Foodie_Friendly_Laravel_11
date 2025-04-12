@extends('layouts.app')

@section('content')
<div class="main-content">
    <!-- Search Bar Section -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{ route('search') }}" method="GET">
                    <div class="input-group mb-4 shadow-sm">
                        <input type="text" 
                               class="form-control form-control-lg border-brown" 
                               placeholder="Search for dishes..."
                               name="query"
                               style="border-top-left-radius: 25px; border-bottom-left-radius: 25px;">
                        <button class="btn btn-brown" 
                                type="submit"
                                style="border-top-right-radius: 25px; border-bottom-right-radius: 25px;">
                            <i class="bi bi-search"></i> Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Product Grid -->
    <div class="container mt-3 pt-2">
        <div class="row">
            @php
                $products = [
                    ['name' => 'Beef Wellington', 'price' => '₱399', 'image' => 'beef_wellington.avif'],
                    ['name' => 'Sticky Toffee Pudding', 'price' => '₱249', 'image' => 'sticky-toffee-pudding.jpg'],
                    ['name' => 'BSK Burger', 'price' => '₱199', 'image' => 'BSK_burger.jpg'],
                    ['name' => 'Whole Pizza', 'price' => '₱499', 'image' => 'pizza.jpg'],
                    ['name' => 'Carbonara', 'price' => '₱139', 'image' => 'carbonara.jpg'],
                    ['name' => 'Fried Chicken', 'price' => '₱299', 'image' => 'fried_chicken.jpg'],
                ];
            @endphp

            @foreach ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card shadow text-center">
                    <img src="{{ url('/image/' . $product['image']) }}" 
                         class="img-fluid mb-3" 
                         alt="{{ $product['name'] }}" 
                         style="height: 180px; object-fit: cover;">
                    <h5 class="text-dark">{{ $product['name'] }}</h5>
                    <p class="text-dark">{{ $product['price'] }}</p>
                    <button class="btn btn-dark w-100">ORDER</button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    /* Custom styles for search bar */
    .border-brown {
        border-color: #A67B5B !important;
    }
    .btn-brown {
        background-color: #8B4513;
        color: white;
    }
    .btn-brown:hover {
        background-color: #A67B5B;
    }
    .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(139, 69, 19, 0.25);
        border-color: #8B4513;
    }
</style>
@endsection