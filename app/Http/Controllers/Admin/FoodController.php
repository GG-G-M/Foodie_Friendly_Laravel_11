<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    /**
     * Display all food items
     */
    public function index()
    {
        $foods = Food::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.order_categories', compact('foods'));
    }

    /**
     * Store a new food item
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0'
        ]);

        Food::create($validated);

        return redirect()->route('admin.order_categories')
            ->with('success', 'Food item added successfully!');
    }

    /**
     * Update an existing food item
     */
    public function update(Request $request, Food $food)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0'
        ]);

        $food->update($validated);

        return redirect()->route('admin.order_categories')
            ->with('success', 'Food item updated successfully!');
    }

    /**
     * Delete a food item
     */
    public function destroy(Food $food)
    {
        $food->delete();

        return redirect()->route('admin.order_categories')
            ->with('success', 'Food item deleted successfully!');
    }
}