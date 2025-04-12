<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
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
            // $totalOrders = Order::count();
            // $totalRevenue = Order::sum('total_price');
            // $recentOrders = Order::latest()->take(5)->get();

            $totalOrders = 2.355;
            $totalRevenue = 5.2222;
            $recentOrders = 5.22222;


            // return view(
            //     'about'
            // );
            return view('admin.dashboard', compact(
                'totalUsers',
                'totalOrders',
                'totalRevenue',
                'recentOrders'
            ));
        } catch (\Exception $e) {
            error_log('Error fetching dashboard data: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while fetching dashboard data.');
        }
    }


//-------------------------------------USER MANAGEMENTSECTION---------------------------------------
    /**x
     * Display the user management page.
     *
     * @return \Illuminate\View\View
     */
    public function userManagement(Request $request)
    {
        try {
            $query = User::query();
    
            // Search functionality
            if ($request->has('search')) {
                $searchTerm = $request->input('search');
                $query->where('name', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('role', 'LIKE', "%{$searchTerm}%");
            }
    
            $users = $query->paginate(10);
            $totalUsers = User::count();
            $totalOrders = 5; // Dummy value (replace later)
    
            return view('admin.user_management', compact('users', 'totalUsers', 'totalOrders'));
        } catch (\Exception $e) {
            error_log('Error fetching users: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while fetching users.');
        }
    }
//CREATE BUTTON [3]
// Show the create form
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
        'password' => 'required|confirmed', // 'confirmed' checks password_confirmation
        'role' => 'required|in:admin,customer',
    ], [
        'password.confirmed' => 'The passwords do not match.',
    ]);

    try {
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('admin.user_management')
               ->with('success', 'User created successfully!');
    } catch (\Exception $e) {
        return back()->with('error', 'Error creating user: ' . $e->getMessage())
                    ->withInput(); // This preserves old input
    }
}


// EDIT BUTTON [3]
// Display the edit form
public function edit(User $user)
{
    return view('admin.users.edit', compact('user'));
}

// EDIT BUTTON [5]

// Process the update request
public function update(Request $request, User $user)
{
    try {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,customer', // Updated role validation
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.user_management')
               ->with('success', 'User updated successfully!');
    } catch (\Exception $e) {
        return redirect()->back()
               ->with('error', 'Error updating user: ' . $e->getMessage());
    }
}

//DELETE BUTTON [3]
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
//-------------------------------------USER MANAGEMENTSECTION---------------------------------------


//-------------------------------------ORDER MENU SECTION---------------------------------------
    /**
     * Display the order menu.
     *
     * @return \Illuminate\View\View
     */
    public function OrderCategories()
    {
        // Dummy data for the food items
        $foods = [
            (object) ['id' => 1, 'name' => 'Burger', 'category' => 'Fast Food', 'price' => 5.99],
            (object) ['id' => 2, 'name' => 'Pizza', 'category' => 'Italian', 'price' => 9.99],
            (object) ['id' => 3, 'name' => 'Pasta', 'category' => 'Italian', 'price' => 7.49],
            (object) ['id' => 4, 'name' => 'Salad', 'category' => 'Vegetarian', 'price' => 4.99],
            (object) ['id' => 5, 'name' => 'chicken', 'category' => 'Fast food', 'price' => 5.99],
            
        ];
    
        return view('admin.order_categories', compact('foods'));
    }
    
    
    public function orderMenu() {
        
        return view('admin.order_menu');
    }
    

    /**
     * Store a new food item.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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