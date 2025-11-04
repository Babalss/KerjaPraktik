<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('blog_posts', function (Blueprint $t) {
            $t->id();

            $t->string('title', 200);
            $t->string('slug', 200)->unique();
            $t->text('excerpt')->nullable();
            $t->string('hero_image', 255)->nullable();
            $t->longText('content');

            $t->enum('status', ['draft','published'])->default('draft');
            $t->timestamp('published_at')->nullable();

            // FK
            $t->foreignId('author_id')->constrained('users')->cascadeOnDelete();
            $t->foreignId('category_id')->constrained('blog_categories')->restrictOnDelete();

            $t->timestamps();

            // Listing publik cepat
            $t->index(['status', 'published_at'], 'idx_blog_posts_status_published_at');
        });
    }

    public function down(): void {
        Schema::dropIfExists('blog_posts');
    }
};
