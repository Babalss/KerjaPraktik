<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;

// tambahkan model blog
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\BlogPost;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Admin']);
    }

    public function index()
    {
        $productCount      = Product::count();
        $categoryCount     = ProductCategory::count();
        $blogCategoryCount = BlogCategory::count();
        $blogTagCount      = BlogTag::count();
        $blogPostCount     = BlogPost::count();

        return view('admin.dashboard', [
            'user'              => Auth::user(),
            'productCount'      => $productCount,
            'categoryCount'     => $categoryCount,
            'blogCategoryCount' => $blogCategoryCount,
            'blogTagCount'      => $blogTagCount,
            'blogPostCount'     => $blogPostCount,
        ]);
    }
}
