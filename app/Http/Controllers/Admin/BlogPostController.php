<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    /**
     * Tampilkan daftar post blog.
     */
    public function index(Request $r)
    {
        $q = $r->get('q');

        $items = BlogPost::with(['category', 'author'])
            ->when($q, function ($s) use ($q) {
                $s->where(function ($qq) use ($q) {
                    $qq->where('title', 'like', "%{$q}%")
                       ->orWhere('slug', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.blog.posts.index', compact('items', 'q'));
    }

    /**
     * Form tambah post baru.
     */
    public function create()
    {
        $item = new BlogPost();
        $categories = BlogCategory::orderBy('name')->get();
        $tags = BlogTag::orderBy('name')->get();

        return view('admin.blog.posts.create', compact('item', 'categories', 'tags'));
    }

    /**
     * Simpan post baru ke database.
     */
    public function store(Request $r)
    {
        $data = $r->validate([
            'title'        => ['required', 'string', 'max:200'],
            // slug tidak divalidasi, di-generate otomatis dari title
            'excerpt'      => ['nullable', 'string'],
            'hero_image'   => ['nullable', 'file', 'image', 'max:2048'],
            'content'      => ['required', 'string'],
            'status'       => ['required', 'in:draft,published'],
            'published_at' => ['nullable', 'date'],
            'category_id'  => ['required', 'exists:blog_categories,id'],
            'tag_ids'      => ['nullable', 'array'],
            'tag_ids.*'    => ['integer', 'exists:blog_tags,id'],
        ]);

        $data['author_id'] = auth()->id();

        // Upload gambar hero (opsional)
        if ($r->hasFile('hero_image')) {
            $file = $r->file('hero_image');
            $filename = time() . '-' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('blog', $filename, 'public');
            $data['hero_image'] = $path;
        }

        $post = BlogPost::create($data); // slug akan diisi di hook saving()
        $post->tags()->sync($r->input('tag_ids', []));

        return redirect()
            ->route('admin.blog.posts.index')
            ->with('ok', 'Post berhasil dibuat.');
    }

    /**
     * Form edit.
     */
    public function edit(BlogPost $post)
    {
        $item = $post;
        $categories = BlogCategory::orderBy('name')->get();
        $tags = BlogTag::orderBy('name')->get();
        $selectedTags = $item->tags()->pluck('blog_tags.id')->toArray();

        return view('admin.blog.posts.edit', compact('item', 'categories', 'tags', 'selectedTags'));
    }

    /**
     * Update data post.
     */
    public function update(Request $r, BlogPost $post)
    {
        $data = $r->validate([
            'title'        => ['required', 'string', 'max:200'],
            // slug tetap otomatis, tidak dari input user
            'excerpt'      => ['nullable', 'string'],
            'hero_image'   => ['nullable', 'file', 'image', 'max:2048'],
            'content'      => ['required', 'string'],
            'status'       => ['required', 'in:draft,published'],
            'published_at' => ['nullable', 'date'],
            'category_id'  => ['required', 'exists:blog_categories,id'],
            'tag_ids'      => ['nullable', 'array'],
            'tag_ids.*'    => ['integer', 'exists:blog_tags,id'],
        ]);

        // Ganti gambar hero jika upload baru
        if ($r->hasFile('hero_image')) {
            if ($post->hero_image && Storage::disk('public')->exists($post->hero_image)) {
                Storage::disk('public')->delete($post->hero_image);
            }

            $file = $r->file('hero_image');
            $filename = time() . '-' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('blog', $filename, 'public');
            $data['hero_image'] = $path;
        }

        $post->update($data); // kalau title berubah, slug ikut diubah di hook saving()
        $post->tags()->sync($r->input('tag_ids', []));

        return redirect()
            ->route('admin.blog.posts.index')
            ->with('ok', 'Post berhasil diperbarui.');
    }

    /**
     * Hapus post.
     */
    public function destroy(BlogPost $post)
    {
        if ($post->hero_image && Storage::disk('public')->exists($post->hero_image)) {
            Storage::disk('public')->delete($post->hero_image);
        }

        $post->delete();

        return back()->with('ok', 'Post berhasil dihapus.');
    }
}
