<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Rider;
use App\Models\Order;
use App\Models\Food;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            $totalUsers = User::count();
            $totalAdmins = User::where('role', 'admin')->count();
            $totalCustomers = User::where('role', 'customer')->count();
            $totalRiders = User::where('role', 'rider')->count();
            
            $totalOrders = 2.355;
            $totalRevenue = 5.2222;
            $recentOrders = 5.22222;
    
            return view('admin.dashboard', compact(
                'totalUsers',
                'totalAdmins',
                'totalCustomers',
                'totalRiders',
                'totalOrders',
                'totalRevenue',
                'recentOrders'
            ));
        } catch (\Exception $e) {
            error_log('Error fetching dashboard data: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while fetching dashboard data.');
        }
    }

    //-------------------------------------USER MANAGEMENT SECTION---------------------------------------
    /**
     * Display the user management page.
     *
     * @return \Illuminate\View\View
     */
    public function userManagement(Request $request)
    {
        try {
            $query = User::with('rider');
            
            if ($request->has('search')) {
                $searchTerm = $request->input('search');
                $query->where(function($q) use ($searchTerm) {
                    $q->where('name', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('role', 'LIKE', "%{$searchTerm}%");
                });
            }

            if ($request->has('role_filter') && in_array($request->role_filter, ['admin', 'customer', 'rider'])) {
                $query->where('role', $request->role_filter);
            }
            
            $sortOrder = $request->input('sort_order', 'desc');
            $query->orderBy('id', $sortOrder);

            $users = $query->paginate(10);
            $totalUsers = User::count();
            $totalCustomers = User::where('role', 'customer')->count();
            $totalAdmins = User::where('role', 'admin')->count();
            $totalRiders = User::where('role', 'rider')->count();

            return view('admin.user_management', compact(
                'users',
                'totalUsers',
                'totalCustomers',
                'totalAdmins',
                'totalRiders'
            ));
        } catch (\Exception $e) {
            error_log('Error fetching users: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while fetching users.');
        }
    }

    // CREATE BUTTON [3]
    public function create()
    {
        return view('admin.users.create');
    }

    // Store the new user
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'role' => 'required|in:admin,customer,rider',
            'phone_number' => 'nullable|string|max:20',
            'license_number' => 'nullable|string|max:50',
        ], [
            'password.confirmed' => 'The passwords do not match.',
        ]);

        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'role' => $validated['role'],
            ]);

            if ($validated['role'] === 'rider') {
                Rider::create([
                    'user_id' => $user->id,
                    'phone_number' => $validated['phone_number'],
                    'license_number' => $validated['license_number'],
                ]);
            }

            return redirect()->route('admin.user_management')
                   ->with('success', 'User created successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error creating user: ' . $e->getMessage())
                        ->withInput();
        }
    }

    // EDIT BUTTON [3]
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // Process the update request
    public function update(Request $request, User $user)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'role' => 'required|in:admin,customer,rider',
                'phone_number' => 'nullable|string|max:20',
                'license_number' => 'nullable|string|max:50',
            ]);

            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role' => $validated['role'],
            ]);

            if ($validated['role'] === 'rider') {
                $rider = $user->rider ?? new Rider(['user_id' => $user->id]);
                $rider->phone_number = $validated['phone_number'];
                $rider->license_number = $validated['license_number'];
                $rider->save();
            } else {
                if ($user->rider) {
                    $user->rider->delete();
                }
            }

            return redirect()->route('admin.user_management')
                   ->with('success', 'User updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                   ->with('error', 'Error updating user: ' . $e->getMessage());
        }
    }

    // DELETE BUTTON [3]
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('admin.user_management')->with('success', 'User deleted successfully!');
        } catch (\Exception $e) {
            error_log('Error deleting user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete user.');
        }
    }

    // New method to view rider details
    public function view(User $user)
    {
        if ($user->role !== 'rider' || !$user->rider) {
            return redirect()->route('admin.user_management')->with('error', 'This user is not a rider or has no rider details.');
        }

        return view('admin.users.view', compact('user'));
    }

    // Rider user controller (optional, replaced by userManagement)
    public function riderUsers()
    {
        return redirect()->route('admin.user_management', ['role_filter' => 'rider']);
    }

    //-------------------------------------ORDER MENU SECTION---------------------------------------
    public function OrderCategories()
    {
        $foods = Food::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.order_categories', compact('foods'));
    }
    
    public function orderMenu()
    {
        $orders = Order::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.order_menu', compact('orders'));
    }

    public function storeFood(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'category' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
            ]);

            Food::create([
                'name' => $request->name,
                'category' => $request->category,
                'price' => $request->price,
            ]);

            return redirect()->route('admin.order_menu')->with('success', 'Food item added successfully!');
        } catch (\Exception $e) {
            error_log('Error storing food item: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while adding the food item.');
        }
    }
}