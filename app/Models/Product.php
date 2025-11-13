<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'thumbnail',
        'short_description',
        'long_description',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function scopeSearch($q, ?string $term)
    {
        if (!$term) return $q;
        $term = "%{$term}%";
        return $q->where(function ($s) use ($term) {
            $s->where('name', 'LIKE', $term)
              ->orWhere('slug', 'LIKE', $term)
              ->orWhere('short_description', 'LIKE', $term);
        });
    }

    /** Buat slug unik: “nama-produk”, tambah -2, -3 kalau bentrok */
    public static function generateUniqueSlug(string $text, ?int $ignoreId = null): string
    {
        $base = Str::slug($text) ?: Str::random(6);
        $slug = $base;

        $exists = function (string $candidate) use ($ignoreId) {
            $q = static::query()->where('slug', $candidate);
            if ($ignoreId) $q->where('id', '!=', $ignoreId);
            return $q->exists();
        };

        if (!$exists($slug)) return $slug;
        $i = 2;
        while ($exists($base.'-'.$i)) $i++;
        return $base.'-'.$i;
    }
}
