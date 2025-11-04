<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('blog_categories', function (Blueprint $t) {
            $t->id();
            $t->string('name', 150);
            $t->string('slug', 190)->unique();
            $t->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('blog_categories');
    }
};
