<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    /**
     * Tampilkan daftar kategori blog.
     */
    public function index(Request $r)
    {
        $q = $r->get('q');

        $items = BlogCategory::when($q, fn($s) => $s->where('name', 'like', "%$q%"))
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.blog.categories.index', compact('items', 'q'));
    }

    /**
     * Form tambah kategori.
     */
    public function create()
    {
        $item = new BlogCategory();
        return view('admin.blog.categories.create', compact('item'));
    }

    /**
     * Simpan kategori baru.
     */
    public function store(Request $r)
    {
        $data = $r->validate([
            'name' => ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'string', 'max:190', 'unique:blog_categories,slug'],
        ]);

        // Jika slug kosong, buat otomatis dari name
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        BlogCategory::create($data);

        return redirect()
            ->route('admin.blog.categories.index')
            ->with('ok', 'Kategori berhasil dibuat.');
    }

    /**
     * Form edit kategori.
     */
    public function edit(BlogCategory $category)
    {
        $item = $category;
        return view('admin.blog.categories.edit', compact('item'));
    }

    /**
     * Update kategori.
     */
    public function update(Request $r, BlogCategory $category)
    {
        $data = $r->validate([
            'name' => ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'string', 'max:190', Rule::unique('blog_categories', 'slug')->ignore($category->id)],
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $category->update($data);

        return redirect()
            ->route('admin.blog.categories.index')
            ->with('ok', 'Kategori berhasil diperbarui.');
    }

    /**
     * Hapus kategori.
     */
    public function destroy(BlogCategory $category)
    {
        $category->delete();

        return back()->with('ok', 'Kategori berhasil dihapus.');
    }
}
