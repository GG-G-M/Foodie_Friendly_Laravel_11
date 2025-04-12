@extends('layouts.welcome_admin')

@section('content')
<style>
    body {
        background-color: #fdf6f0;
    }

    h2, .card-header {
        color: #5c3d2e;
    }

    .btn-primary {
        background-color: #8b5e3c;
        border-color: #8b5e3c;
    }

    .btn-primary:hover {
        background-color: #6b4226;
        border-color: #6b4226;
    }

    .btn-warning {
        background-color: #d89b5c;
        border-color: #d89b5c;
        color: #fff;
    }

    .btn-warning:hover {
        background-color: #b1783f;
        border-color: #b1783f;
    }

    .btn-danger {
        background-color: #a64b2a;
        border-color: #a64b2a;
    }

    .btn-danger:hover {
        background-color: #82371f;
        border-color: #82371f;
    }

    .card {
        box-shadow: 0 4px 12px rgba(139, 94, 60, 0.2);
        border: none;
        border-left: 5px solid #8b5e3c;
    }

    .form-control:focus {
        border-color: #8b5e3c;
        box-shadow: 0 0 0 0.2rem rgba(139, 94, 60, 0.25);
    }

    table th {
        background-color: #8b5e3c;
        color: white;
    }
</style>

<div class="container py-4">
    <h2 class="mb-4">🍽️ Order Menu - Admin Panel</h2>

    <!-- Add Food Item -->
    <div class="card mb-4">
        <div class="card-header fw-bold">➕ Add Food Item</div>
        <div class="card-body">
            <form action="{{ route('admin.food.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Food Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <input type="text" class="form-control" id="category" name="category" required>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Food</button>
            </form>
        </div>
    </div>

    <!-- Food List -->
    <div class="card">
        <div class="card-header fw-bold">📋 Food List</div>
        <div class="card-body">
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
                                <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                <a href="#" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
