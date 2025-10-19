<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Admin']);
    }

    public function index()
    {
        $productCount = Product::count();
        $categoryCount = ProductCategory::count();

        return view('admin.dashboard', [
            'user' => Auth::user(),
            'productCount' => $productCount,
            'categoryCount' => $categoryCount,
        ]);
    }
}
