<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'short_description',
        'long_description',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    /**
     * Scope pencarian sederhana (nama/slug/deskripsi singkat)
     */
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
}
