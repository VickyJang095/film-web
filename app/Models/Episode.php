<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Episode extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id',
        'title',
        'episode_number',
        'description',
        'video_path',
        'thumbnail_path',
        'duration',
        'status',
    ];

    /**
     * Lấy phim mà tập này thuộc về
     */
    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }
} 