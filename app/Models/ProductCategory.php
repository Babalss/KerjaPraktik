<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'slug',
        'description',
        'thumbnail',  
    ];

 
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function scopeSearch($q, ?string $term)
    {
        if (!$term) return $q;
        $term = "%{$term}%";
        return $q->where(function ($s) use ($term) {
            $s->where('name', 'LIKE', $term)
              ->orWhere('slug', 'LIKE', $term);
        });
    }
}
