@extends('layouts.app')

@section('content')
<div class="container py-4" style="background-color: #f4ece3; border-radius: 15px;">
    <h2 class="mb-4 text-center" style="color: #5D3A00;">🛍️ Your Cart</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($cartItems->isEmpty())
        <p class="text-center">Your cart is empty.</p>
    @else
        <table class="table table-bordered table-hover table-light">
            <thead class="table-dark" style="background-color: #a97c50; color: white;">
                <tr>
                    <th>Food</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                    <tr>
                        <td>{{ $item->food->name }}</td>
                        <td>₱{{ number_format($item->food->price, 2) }}</td>
                        <td>
                            <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" style="width: 60px;">
                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            </form>
                        </td>
                        <td>₱{{ number_format($item->food->price * $item->quantity, 2) }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-end">
            <h5>Total: ₱{{ number_format($cartItems->sum(fn($item) => $item->food->price * $item->quantity), 2) }}</h5>
            <form action="{{ route('checkout') }}" method="GET">
                <div class="mb-3">
                    <label for="delivery_address" class="form-label">Delivery Address</label>
                    <input type="text" class="form-control" id="delivery_address" name="delivery_address" required>
                </div>
                <button type="submit" class="btn btn-success">Checkout</button>
            </form>
        </div>
    @endif
</div>

<style>
    body {
        background-color: #eaddcf;
    }
</style>
@endsection