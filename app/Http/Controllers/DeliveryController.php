<?php
namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    // Display Deliveries for Rider
   
    public function index()
    {
        // Get deliveries for the authenticated rider
        $deliveries = Delivery::where('rider_id', auth()->id())->get();
    
        // Return the 'rider' view and pass the deliveries to it
        return view('rider.dashboard', compact('deliveries'));
    }
    
    
}
