<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    protected $table = 'blog_posts';

    protected $fillable = [
        'title','slug','excerpt','hero_image','content',
        'status','published_at','author_id','category_id',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Hook untuk slug otomatis & set published_at
     */
    protected static function booted()
    {
        static::saving(function (BlogPost $post) {
            // Slug otomatis jika kosong; pastikan unik
            if (blank($post->slug) && filled($post->title)) {
                $post->slug = static::generateUniqueSlug($post->title, $post->id);
            }

            // Isi published_at otomatis saat status published dan belum ada tanggal
            if ($post->status === 'published' && is_null($post->published_at)) {
                $post->published_at = now();
            }
        });
    }

    /**
     * Membuat slug unik: judul => slug, tambahkan -2, -3 jika bentrok
     */
    public static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: Str::random(6);
        $slug = $base;

        $exists = function (string $candidate) use ($ignoreId) {
            $q = static::query()->where('slug', $candidate);
            if ($ignoreId) {
                $q->where('id', '!=', $ignoreId);
            }
            return $q->exists();
        };

        if (!$exists($slug)) {
            return $slug;
        }

        $i = 2;
        while ($exists($base . '-' . $i)) {
            $i++;
        }
        return $base . '-' . $i;
    }

    // Relasi
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(BlogTag::class, 'blog_post_tag', 'post_id', 'tag_id');
    }

    // Scope publikasi
    public function scopePublished($q)
    {
        return $q->where('status', 'published')
            ->where(function ($qq) {
                $qq->whereNull('published_at')
                   ->orWhere('published_at', '<=', now());
            });
    }
}
