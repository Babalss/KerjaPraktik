<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class BlogTagController extends Controller
{
    /**
     * Tampilkan daftar tag
     */
    public function index(Request $r)
    {
        $q = $r->get('q');
        $items = BlogTag::when($q, fn($s) => $s->where('name', 'like', "%$q%"))
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.blog.tags.index', compact('items', 'q'));
    }

    /**
     * Form tambah tag
     */
    public function create()
    {
        $item = new BlogTag();
        return view('admin.blog.tags.create', compact('item'));
    }

    /**
     * Simpan tag baru
     */
    public function store(Request $r)
    {
        $data = $r->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['nullable', 'string', 'max:150', 'unique:blog_tags,slug'],
        ]);

        // Jika slug kosong → otomatis generate dari name
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        BlogTag::create($data);
        return redirect()->route('admin.blog.tags.index')->with('ok', 'Tag berhasil dibuat.');
    }

    /**
     * Form edit tag
     */
    public function edit(BlogTag $tag)
    {
        $item = $tag;
        return view('admin.blog.tags.edit', compact('item'));
    }

    /**
     * Update tag
     */
    public function update(Request $r, BlogTag $tag)
    {
        $data = $r->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['nullable', 'string', 'max:150', Rule::unique('blog_tags', 'slug')->ignore($tag->id)],
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $tag->update($data);

        return redirect()->route('admin.blog.tags.index')->with('ok', 'Tag berhasil diperbarui.');
    }

    /**
     * Hapus tag
     */
    public function destroy(BlogTag $tag)
    {
        $tag->delete();
        return back()->with('ok', 'Tag berhasil dihapus.');
    }
}
