<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description'
    ];

    /**
     * Lấy các phim thuộc thể loại này
     */
    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'movie_category');
    }
} 