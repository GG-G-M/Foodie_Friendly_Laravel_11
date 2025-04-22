@extends('layouts.welcome_admin')

@section('title', 'Rider Users')

@section('content')
<div class="container mt-2">

<h2 class="mb-3 text-center text-brown"> 🏍️ Rider User-Management - Admin Panel 🏍️</h2>
<!-- Add Rider Form -->
    <div class="mb-5">
        <div class="card shadow" style="border-radius: 12px; background-color: #fefaf3;">
        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #c8a879;">
        <h5 class="fw-bold text-dark mb-0">Add Rider</h5>
            </div>
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" placeholder="Enter full name" style="background-color: #fffaf2;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Gmail</label>
                            <input type="email" class="form-control" placeholder="Enter email" style="background-color: #fffaf2;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Number</label>
                            <input type="text" class="form-control" placeholder="Enter phone number" style="background-color: #fffaf2;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">License Code</label>
                            <input type="text" class="form-control" placeholder="Enter license code" style="background-color: #fffaf2;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" style="background-color: #fffaf2;">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn text-white" style="background-color: #8b5e3c;">
                            <i class="bi bi-plus-circle me-1"></i> Save Rider
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Riders List Table -->
    <div class="card shadow" style="border-radius: 12px;">
        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #c8a879;">
            <h5 class="fw-bold text-dark mb-0">Rider Users</h5>
         
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="text-white" style="background-color: #3e3e3e;">
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Gmail</th>
                        <th>Number</th>
                        <th>License Code</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($riders as $rider)
                    <tr>
                        <td>{{ $rider->id }}</td>
                        <td>{{ $rider->name }}</td>
                        <td>{{ $rider->email }}</td>
                        <td>{{ $rider->phone }}</td>
                        <td>{{ $rider->license_code }}</td>
                        <td>
                            <span class="badge rounded-pill {{ $rider->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($rider->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('riders.edit', $rider->id) }}" class="btn btn-warning btn-sm me-1">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('riders.destroy', $rider->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


@endsection
