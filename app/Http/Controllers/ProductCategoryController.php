<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    /**
     * Menampilkan daftar semua kategori produk.
     */
    public function index(Request $request)
    {
        $q = $request->get('q');

        $categories = ProductCategory::query()
            ->when(
                $q,
                fn($query) =>
                $query->where(
                    fn($x) =>
                    $x->where('name', 'like', "%{$q}%")
                        ->orWhere('slug', 'like', "%{$q}%")
                )
            )
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.categories.index', compact('categories', 'q'));
    }

    /**
     * Menampilkan form untuk membuat kategori baru.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Menyimpan kategori baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:product_categories,slug',
            'description' => 'nullable|string',
        ]);

        // Jika slug kosong, buat otomatis dari name
        $slug = $request->filled('slug')
            ? Str::slug($request->slug)
            : Str::slug($request->name);

        ProductCategory::create([
            'name'        => $request->name,
            'slug'        => $slug,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    /**
     * Menampilkan form untuk mengedit kategori.
     */
    public function edit($id)
    {
        $category = ProductCategory::findOrFail($id);

        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Memperbarui data kategori di database.
     */
    public function update(Request $request, $id)
    {
        $category = ProductCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:product_categories,slug,' . $category->id,
            'description' => 'nullable|string',
        ]);

        // Jika slug kosong, buat otomatis dari name
        $slug = $request->filled('slug')
            ? Str::slug($request->slug)
            : Str::slug($request->name);

        $category->update([
            'name'        => $request->name,
            'slug'        => $slug,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui');
    }

    /**
     * Menghapus kategori dari database.
     */
    public function destroy($id)
    {
        ProductCategory::findOrFail($id)->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}
