<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->integer('episode_number');
            $table->text('description')->nullable();
            $table->string('video_path');
            $table->string('thumbnail_path')->nullable();
            $table->integer('duration')->default(0)->comment('Thời lượng tập phim (phút)');
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamps();

            // Đảm bảo mỗi tập phim trong một bộ phim có số tập khác nhau
            $table->unique(['movie_id', 'episode_number']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('episodes');
    }
}; 