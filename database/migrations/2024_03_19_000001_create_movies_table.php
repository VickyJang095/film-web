<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->integer('release_year');
            $table->integer('duration')->default(0);
            $table->string('poster_path')->nullable();
            $table->string('video_path')->nullable();
            $table->integer('episodes')->default(0);
            $table->enum('type', ['single', 'series'])->default('single');
            $table->foreignId('country_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->integer('views')->default(0);
            $table->float('rating')->default(0);
            $table->integer('rating_count')->default(0);
            $table->timestamps();
        });

        Schema::create('movie_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movie_category');
        Schema::dropIfExists('movies');
    }
}; 