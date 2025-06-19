<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;


class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'release_year',
        'duration',
        'poster_path',
        'video_path',
        'type',
        'country_id',
        'status',
        'views',
        'rating',
        'rating_count'
    ];

    protected $casts = [
        'release_year' => 'integer',
        'duration' => 'integer',
        'episodes' => 'integer',
        'views' => 'integer',
        'rating' => 'float',
        'rating_count' => 'integer',
        'type' => 'string'
    ];

    // Relationships
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'movie_category');
    }

    /**
     * Lấy các tập phim của bộ phim này
     */
    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

    public function episodeList(): HasMany
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($movie) {
            if (empty($movie->slug)) {
                $movie->slug = Str::slug($movie->title);
            }
        });

        static::updating(function ($movie) {
            if ($movie->isDirty('title')) {
                $movie->slug = Str::slug($movie->title);
            }
        });
    }
}
