<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function index(Request $r)
    {
        $q = $r->get('q');

        $categories = ProductCategory::query()
            ->search($q)
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.categories.index', compact('categories', 'q'));
    }

    public function create()
    {
        // tanpa parent
        return view('admin.categories.create');
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'thumbnail'   => ['nullable', 'file', 'image', 'max:2048'], // 2MB
        ]);

        // slug auto-unik dari name
        $data['slug'] = $this->uniqueSlug(Str::slug($data['name']));

        // upload thumbnail jika ada
        if ($r->hasFile('thumbnail')) {
            $file = $r->file('thumbnail');
            $filename = time() . '-' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('categories', $filename, 'public');
            $data['thumbnail'] = $path; // simpan path relatif
        }

        ProductCategory::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit($id)
    {
        $category = ProductCategory::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $r, $id)
    {
        $category = ProductCategory::findOrFail($id);

        $data = $r->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'thumbnail'   => ['nullable', 'file', 'image', 'max:2048'],
        ]);

        // slug auto-unik dari name (selalu ikut nama saat edit)
        $base = Str::slug($data['name']);
        $data['slug'] = $this->uniqueSlug($base, $category->id);

        // ganti thumbnail jika upload baru
        if ($r->hasFile('thumbnail')) {
            if ($category->thumbnail && Storage::disk('public')->exists($category->thumbnail)) {
                Storage::disk('public')->delete($category->thumbnail);
            }
            $file = $r->file('thumbnail');
            $filename = time() . '-' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('categories', $filename, 'public');
            $data['thumbnail'] = $path;
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy($id)
    {
        $cat = ProductCategory::findOrFail($id);

        if ($cat->thumbnail && Storage::disk('public')->exists($cat->thumbnail)) {
            Storage::disk('public')->delete($cat->thumbnail);
        }

        $cat->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus');
    }

    /**
     * Buat slug unik. Jika sudah ada, tambahkan -2, -3, dst.
     */
    private function uniqueSlug(string $base, ?int $ignoreId = null): string
    {
        $slug = $base ?: 'kategori';
        $i = 2;

        $exists = ProductCategory::where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists();

        while ($exists) {
            $candidate = $base . '-' . $i++;
            $exists = ProductCategory::where('slug', $candidate)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists();
            if (!$exists) {
                $slug = $candidate;
                break;
            }
        }

        return $slug;
    }
}
