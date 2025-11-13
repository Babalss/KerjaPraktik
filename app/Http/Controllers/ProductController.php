<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        $products = Product::with('category')
            ->search($q)
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
        $data = $request->validate([
            'category_id'        => ['required','exists:product_categories,id'],
            'name'               => ['required','string','max:255'],
            'slug'               => ['nullable','string','max:255','unique:products,slug'],
            'thumbnail'          => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
            'short_description'  => ['nullable','string','max:500'],
            'long_description'   => ['nullable','string'],
            'status'             => ['in:active,inactive'],
        ]);

        // Slug unik (dari input slug kalau ada, jika tidak dari name)
        $slugSource = $data['slug'] ?? $data['name'];
        $data['slug'] = Product::generateUniqueSlug($slugSource);

        // Upload thumbnail
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')
                ->store('products', 'public'); // simpan di storage/app/public/products
        }

        $data['status'] = $data['status'] ?? 'active';

        Product::create($data);

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

        $data = $request->validate([
            'category_id'        => ['required','exists:product_categories,id'],
            'name'               => ['required','string','max:255'],
            'slug'               => ['nullable','string','max:255', Rule::unique('products','slug')->ignore($product->id)],
            'thumbnail'          => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
            'short_description'  => ['nullable','string','max:500'],
            'long_description'   => ['nullable','string'],
            'status'             => ['in:active,inactive'],
        ]);

        // Slug unik (sinkron nama jika slug kosong)
        $slugSource = $data['slug'] ?? $data['name'];
        $data['slug'] = Product::generateUniqueSlug($slugSource, $product->id);

        // Upload thumbnail baru? hapus lama
        if ($request->hasFile('thumbnail')) {
            if ($product->thumbnail && Storage::disk('public')->exists($product->thumbnail)) {
                Storage::disk('public')->delete($product->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')
                ->store('products', 'public');
        }

        $data['status'] = $data['status'] ?? 'active';

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->thumbnail && Storage::disk('public')->exists($product->thumbnail)) {
            Storage::disk('public')->delete($product->thumbnail);
        }
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus');
    }

    /** OPSIONAL: halaman publik detail produk (untuk tombol “Kunjungi”) */
    public function show($slug)
    {
        $product = Product::with('category')->where('slug', $slug)->firstOrFail();
        return view('products.show', compact('product'));
    }
}
