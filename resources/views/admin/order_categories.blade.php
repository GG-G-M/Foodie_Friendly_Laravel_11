@extends('layouts.welcome_admin')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@section('content')
<div class="container py-4">
    <h2 class="mb-4">🍽️ Order Categories - Admin Panel</h2>

    <!-- Add Food Item -->
    <div class="card mb-4">
        <div class="card-header fw-bold">➕ Add Food Item</div>
        <div class="card-body">
            <form action="{{ route('foods.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="name" class="form-label">Food Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="category" class="form-label">Category</label>
                        <input type="text" class="form-control" id="category" name="category" required>
                        @error('category') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                        @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Add Food</button>
            </form>
        </div>
    </div>

    <!-- Food List -->
    <div class="card">
        <div class="card-header fw-bold">📋 Food List</div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($foods as $food)
                        <tr>
                            <td>{{ $food->id }}</td>
                            <td>{{ $food->name }}</td>
                            <td>{{ $food->category }}</td>
                            <td>${{ number_format($food->price, 2) }}</td>
                            <td>
                                <a href="{{ route('foods.edit', $food->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('foods.destroy', $food->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Are you sure you want to delete this item?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $foods->links() }}
            </div>
        </div>
    </div>
</div>

@endsection