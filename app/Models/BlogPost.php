<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
                 ->where(function($qq){
                    $qq->whereNull('published_at')
                       ->orWhere('published_at', '<=', now());
                 });
    }
}
