@extends('layouts.app')

@section('title', 'Food Menu')

@section('content')
<div class="container mt-4">

    <!-- Header + View Cart button aligned -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Food Menu</h1>
        <a href="{{ route('cart') }}" class="btn btn-brown">
            <i class="bi bi-cart4 me-1"></i> View Cart
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Search and Filter Bar -->
    <div class="row mb-4">
        <div class="col-md-6">
            <form action="{{ route('home') }}" method="GET" class="d-flex">
                <input type="text" name="q" class="form-control me-2 border-brown" placeholder="Search food by name or description..." value="{{ request()->input('q') }}" style="background-color: #fffaf2;">
                <button type="submit" class="btn btn-brown">Search</button>
            </form>
        </div>
        <div class="col-md-6">
            <form action="{{ route('home') }}" method="GET" class="d-flex justify-content-end">
                <select name="category" class="form-control border-brown me-2" style="background-color: #fffaf2;" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category }}" {{ request()->input('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
                <input type="hidden" name="q" value="{{ request()->input('q') }}">
            </form>
        </div>
    </div>

    <!-- Food Items -->
    <div class="row">
        @foreach ($foods as $food)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0" style="background-color: #fefaf3;">
                    <img src="{{ asset('storage/' . $food->image) }}" class="card-img-top" alt="{{ $food->name }}" style="max-height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $food->name }}</h5>
                        <p class="card-text">{{ $food->description }}</p>
                        <p class="card-text"><strong>Price:</strong> ₱{{ number_format($food->price, 2) }}</p>
                        <form action="{{ route('cart.add', $food->id) }}" method="POST">
                            @csrf
                            <div class="form-group mb-2">
                                <label for="quantity-{{ $food->id }}">Quantity:</label>
                                <input type="number" name="quantity" id="quantity-{{ $food->id }}" value="1" min="1" class="form-control border-brown" style="width: 100px; background-color: #fffaf2;">
                            </div>
                            <button type="submit" class="btn btn-brown">Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            setTimeout(() => {
                successAlert.classList.remove('show');
            }, 3000);
        }
    });
</script>
@endsection