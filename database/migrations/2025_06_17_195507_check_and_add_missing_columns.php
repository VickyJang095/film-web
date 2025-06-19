<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Kiểm tra và thêm cột cho bảng movie_user
        if (!Schema::hasColumn('movie_user', 'user_id')) {
            Schema::table('movie_user', function (Blueprint $table) {
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
            });
        }
        if (!Schema::hasColumn('movie_user', 'movie_id')) {
            Schema::table('movie_user', function (Blueprint $table) {
                $table->foreignId('movie_id')->constrained()->onDelete('cascade');
            });
        }
        if (!Schema::hasColumn('movie_user', 'created_at')) {
            Schema::table('movie_user', function (Blueprint $table) {
                $table->timestamps();
            });
        }

        // Kiểm tra và thêm cột cho bảng favorites
        if (!Schema::hasColumn('favorites', 'user_id')) {
            Schema::table('favorites', function (Blueprint $table) {
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
            });
        }
        if (!Schema::hasColumn('favorites', 'movie_id')) {
            Schema::table('favorites', function (Blueprint $table) {
                $table->foreignId('movie_id')->constrained()->onDelete('cascade');
            });
        }
        if (!Schema::hasColumn('favorites', 'created_at')) {
            Schema::table('favorites', function (Blueprint $table) {
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Không cần rollback vì đây là migration kiểm tra
    }
};
