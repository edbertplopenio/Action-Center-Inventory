<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    // Display the form to create a new item
    public function create()
    {
        return view('item-form');
    }

    // Store the newly created item in the database
    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'item_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'unit' => 'required|string|max:100',
            'description' => 'required|string',
            'storage_location' => 'required|string|max:255',
            'arrival_date' => 'required|date',
            'purchase_date' => 'required|date',
            'status' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        } else {
            $imagePath = null;
        }

        // Save the item to the database
        Item::create([
            'item_name' => $request->item_name,
            'category' => $request->category,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'description' => $request->description,
            'storage_location' => $request->storage_location,
            'arrival_date' => $request->arrival_date,
            'purchase_date' => $request->purchase_date,
            'status' => $request->status,
            'image' => $imagePath,
        ]);

        // Redirect back with a success message
        return redirect()->route('items.create')->with('success', 'Item added successfully!');
    }

    // Display a paginated list of items
    public function index()
    {
        // Retrieve items with pagination (10 items per page)
        $items = Item::paginate(10);

        // Return the inventory page with the paginated items
        return view('inven', compact('items'));
    }
}
