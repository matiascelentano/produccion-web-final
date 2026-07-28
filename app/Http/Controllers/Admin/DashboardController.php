<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        if (!auth()->user()?->isAdmin()) {
            abort(403, 'No tienes permiso para acceder al panel de administración.');
        }

        $stats = [
            'products' => Product::count(),
            'orders' => Order::count(),
            'users' => User::count(),
            'pending_orders' => Order::where('status', 'pendiente')->count(),
        ];

        $recentOrders = Order::with('user')->latest()->take(5)->get();
        $lowStockProducts = Product::where('stock', '<=', 5)->orderBy('stock', 'asc')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'lowStockProducts'));
    }
}
