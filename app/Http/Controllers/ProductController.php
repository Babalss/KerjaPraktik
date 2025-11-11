<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar semua produk (dengan pencarian & pagination).
     */
    public function index(Request $request)
    {
        $q = $request->get('q');

        $products = Product::with('category')
            ->search($q)          // <- scope dari model
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.products.index', compact('products', 'q'));
    }

    public function create()
    {
        $categories = ProductCategory::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id'        => 'required|exists:product_categories,id',
            'name'               => 'required|string|max:255',
            'slug'               => 'nullable|string|max:255|unique:products,slug',
            'short_description'  => 'nullable|string|max:500',
            'long_description'   => 'nullable|string',
            'status'             => 'in:active,inactive',
        ]);

        $slug = $request->filled('slug')
            ? Str::slug($request->slug)
            : Str::slug($request->name);

        Product::create([
            'category_id'        => $request->category_id,
            'name'               => $request->name,
            'slug'               => $slug,
            'short_description'  => $request->short_description,
            'long_description'   => $request->long_description,
            'status'             => $request->status ?? 'active',
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $product    = Product::findOrFail($id);
        $categories = ProductCategory::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'category_id'        => 'required|exists:product_categories,id',
            'name'               => 'required|string|max:255',
            'slug'               => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'short_description'  => 'nullable|string|max:500',
            'long_description'   => 'nullable|string',
            'status'             => 'in:active,inactive',
        ]);

        $slug = $request->filled('slug')
            ? Str::slug($request->slug)
            : Str::slug($request->name);

        $product->update([
            'category_id'        => $request->category_id,
            'name'               => $request->name,
            'slug'               => $slug,
            'short_description'  => $request->short_description,
            'long_description'   => $request->long_description,
            'status'             => $request->status ?? 'active',
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus');
    }
}
