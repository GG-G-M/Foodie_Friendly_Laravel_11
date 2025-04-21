@extends('layouts.welcome_admin')

@section('content')
<!-- Bootstrap Icons CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<!-- Custom Styles -->
<style>
    body {
        background-color: #f4f1ea;
    }

    .card {
        border: 1px solid #a1866f;
        background-color: #fffdf9;
        box-shadow: 0 4px 8px rgba(161, 134, 111, 0.2);
        border-radius: 12px;
    }

    .card-header {
        background-color: #d2b48c;
        color: #3e2f1c;
        font-weight: bold;
    }

    .btn-primary {
        background-color: #8b5e3c;
        border-color: #8b5e3c;
    }

    .btn-primary:hover {
        background-color: #71452d;
        border-color: #71452d;
    }

    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #fff;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #d39e00;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
        color: #fff;
    }

    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    .btn i {
        margin-right: 5px;
    }

    table thead {
        background-color: #f0e0cf;
    }

    .table td,
    .table th {
        vertical-align: middle;
    }

    .alert-success {
        background-color: #e5d6be;
        color: #3e2f1c;
        border-color: #c7b299;
    }
</style>

<div class="container py-4">
    <h2 class="mb-4 text-center text-brown">🍽️ Order Categories - Admin Panel</h2>

  <!-- Add Food Item -->
<div class="card mb-4">
    <div class="card-header">➕ Add Food Item</div>
    <div class="card-body">
        <form action="{{ route('foods.store') }}" method="POST" enctype="multipart/form-data">
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

            <!-- Image Upload Field -->
            <div class="col-md-4 mb-3">
                <label for="image" class="form-label">Food Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                @error('image') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Food
            </button>
        </form>
    </div>
</div>

    <!-- Food List -->
    <div class="card">
        <div class="card-header">📋 Food List</div>
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
                                <a href="{{ route('foods.edit', $food->id) }}" class="btn btn-sm btn-warning text-white">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('foods.destroy', $food->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Are you sure you want to delete this item?')">
                                        <i class="bi bi-trash"></i> Delete
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
