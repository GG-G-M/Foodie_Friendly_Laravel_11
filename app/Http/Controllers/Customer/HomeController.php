<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $foods = Food::all();
        return view('customer.home', compact('foods'));
    }
}