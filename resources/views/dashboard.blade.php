@extends('layouts.app')

@section('title', 'Disaster Risk Reduction Inventory Dashboard')

@section('content')
    <!-- Logout Form (Hidden) -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Logout Button -->
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
        class="text-red-500 hover:text-red-700 font-semibold">
        Logout
    </a>

    <div class="container mx-auto p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-semibold text-gray-800">Disaster Risk Reduction Inventory</h1>
        </div>

        <!-- Dashboard Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 shadow-lg rounded-lg">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Top Stocked Item</h2>
                <p class="text-3xl font-semibold text-gray-800">Emergency Tent</p>
                <span class="text-sm text-gray-600 mt-2 block"><i class="fas fa-arrow-up"></i> 200 units available</span>
            </div>

            <div class="bg-white p-6 shadow-lg rounded-lg">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Low Stock</h2>
                <p class="text-3xl font-semibold text-gray-800">Water Purifiers</p>
                <span class="text-sm text-gray-600 mt-2 block"><i class="fas fa-exclamation-triangle"></i> 10 units left</span>
            </div>

            <div class="bg-white p-6 shadow-lg rounded-lg">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Slow Moving</h2>
                <p class="text-3xl font-semibold text-gray-800">First Aid Kits</p>
                <span class="text-sm text-gray-600 mt-2 block"><i class="fas fa-arrow-down"></i> 3 units distributed this month</span>
            </div>

            <div class="bg-white p-6 shadow-lg rounded-lg">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Total Stock Value</h2>
                <p class="text-3xl font-semibold text-gray-800">$50,000</p>
                <span class="text-sm text-gray-600 mt-2 block"><i class="fas fa-arrow-up"></i> 15% increase in value since last review</span>
            </div>

            <div class="bg-white p-6 shadow-lg rounded-lg col-span-4">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Inventory Dynamics</h2>
                <div class="bg-gray-100 h-52 rounded-lg"></div> <!-- Placeholder for Inventory Trend Chart -->
            </div>

            <div class="bg-white p-6 shadow-lg rounded-lg col-span-4">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Risk Assessment Overview</h2>
                <div class="bg-gray-100 h-52 rounded-lg"></div> <!-- Placeholder for Risk Heatmap -->
            </div>
        </div>
    </div>
@endsection
