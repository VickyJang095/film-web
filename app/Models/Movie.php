<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'duration',
        'release_year',
        'rating',
        'subtitle',
        'trailer_url',
        'poster_url',
        'video_url',
        'category_id',
        'country_id',
        'poster_path',
        'video_path',
        'episodes',
        'type',
        'status',
        'views'
    ];

    protected $casts = [
        'release_year' => 'integer',
        'duration' => 'integer',
        'views' => 'integer',
        'rating' => 'float'
    ];

    // Relationships
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'movie_category');
    }

    /**
     * Lấy các tập phim của bộ phim này
     */
    public function episodes(): HasMany
    {
        return $this->hasMany(Episode::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
