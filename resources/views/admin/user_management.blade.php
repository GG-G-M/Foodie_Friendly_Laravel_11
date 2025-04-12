@extends('layouts.welcome_admin')

@section('content')
<div class="container-fluid">
<!-- Page Heading -->
<div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">User Management</h1>
    
    <div class="d-flex align-items-center">
        <!-- Role Filter Dropdown -->
        <form action="{{ route('admin.user_management') }}" method="GET" class="mr-3">
            <div class="input-group">
                <select name="role_filter" class="form-control" style="min-width: 150px;" onchange="this.form.submit()">
                    <option value="">All Roles</option>
                    <option value="admin" {{ request('role_filter') == 'admin' ? 'selected' : '' }}>Admins</option>
                    <option value="customer" {{ request('role_filter') == 'customer' ? 'selected' : '' }}>Customers</option>
                </select>
            </div>
        </form>
        
        <!-- Search Form -->
        <form action="{{ route('admin.user_management') }}" method="GET" class="d-flex">
            <div class="input-group">
                <input 
                    type="text" 
                    name="search" 
                    class="form-control search-bar" 
                    placeholder="Search users..." 
                    value="{{ request('search') }}"
                    style="min-width: 200px;"
                >
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- Role Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Admins</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalAdmins }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Customers</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalCustomers }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    

    <!-- User Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 flexed">
            <h3 class="m-0 font-weight-bold text-primary">Users List</h3>
            <a href="{{ route('users.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Add User
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="userTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge {{ $user->role === 'admin' ? 'badge-success' : 'badge-primary' }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td>
                                {{-- EDIT BUTTON [1] --}}
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                {{-- DELETE BUTTON [1] --}}
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links with Filter Preservation -->
            <div class="d-flex justify-content-center mt-4">
                {{ $users->appends([
                    'search' => request('search'),
                    'role_filter' => request('role_filter')
                ])->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('.search-bar').on('keyup', function() {
            const searchTerm = $(this).val();
            $.ajax({
                url: "{{ route('admin.user_management') }}",
                data: { search: searchTerm },
                success: function(data) {
                    $('#userTable tbody').html($(data).find('#userTable tbody').html());
                }
            });
        });
    });
</script>
@endsection

@section('styles')
<style>
    
    /* Custom styles for the table */
    #userTable {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    #userTable thead th {
        background-color: #4e73df;
        color: white;
        font-weight: bold;
        border: none;
    }

    #userTable tbody tr:hover {
        background-color: #f8f9fa;
    }

    .badge {
        padding: 0.5em 0.75em;
        font-size: 0.875em;
        border-radius: 10px;
    }

    .badge-success {
        background-color: #28a745;
    }

    .badge-primary {
        background-color: #007bff;
    }

    .search-bar {
        border-radius: 20px;
        border: 1px solid #ddd;
        padding: 10px 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .search-bar:focus {
        border-color: #4e73df;
        box-shadow: 0 2px 4px rgba(78, 115, 223, 0.3);
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        border-radius: 0.2rem;
    }

    .btn-primary {
        background-color: #4e73df;
        border-color: #4e73df;
    }

    .btn-primary:hover {
        background-color: #375ab4;
        border-color: #375ab4;
    }

    .btn-danger {
        background-color: #e74a3b;
        border-color: #e74a3b;
    }

    .btn-danger:hover {
        background-color: #c53022;
        border-color: #c53022;
    }
</style>