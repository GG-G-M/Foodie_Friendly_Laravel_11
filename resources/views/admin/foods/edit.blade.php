@extends('layouts.welcome_admin')

@section('content')
<div class="container py-4">
    <h2>Edit Food Item</h2>
    
    <form action="{{ route('foods.update', $food->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="name" class="form-label">Food Name</label>
            <input type="text" class="form-control" id="name" name="name" 
                   value="{{ old('name', $food->name) }}" required>
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <input type="text" class="form-control" id="category" name="category" 
                   value="{{ old('category', $food->category) }}" required>
            @error('category') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" 
                   value="{{ old('price', $food->price) }}" required>
            @error('price') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        
        <button type="submit" class="btn btn-primary">Update Food</button>
        <a href="{{ route('admin.order_categories') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection