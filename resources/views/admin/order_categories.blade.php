@extends('layouts.welcome_admin')

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
                                <button class="btn btn-sm btn-warning edit-food-btn"
                                        data-id="{{ $food->id }}"
                                        data-name="{{ $food->name }}"
                                        data-category="{{ $food->category }}"
                                        data-price="{{ $food->price }}">
                                    Edit
                                </button>
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

<!-- Edit Food Modal -->
<div class="modal fade" id="editFoodModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editFoodForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Food Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_food_name" class="form-label">Food Name</label>
                        <input type="text" class="form-control" id="edit_food_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_food_category" class="form-label">Category</label>
                        <input type="text" class="form-control" id="edit_food_category" name="category" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_food_price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="edit_food_price" name="price" step="0.01" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Edit Food Modal
        $('.edit-food-btn').click(function() {
            const foodId = $(this).data('id');
            const foodName = $(this).data('name');
            const foodCategory = $(this).data('category');
            const foodPrice = $(this).data('price');
            
            $('#edit_food_name').val(foodName);
            $('#edit_food_category').val(foodCategory);
            $('#edit_food_price').val(foodPrice);
            
            // Set form action
            $('#editFoodForm').attr('action', '/foods/' + foodId);
            
            // Show modal
            $('#editFoodModal').modal('show');
        });
    });
</script>
@endsection
@endsection