<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'slug',
        'description'
    ];

    /**
     * Lấy các phim thuộc quốc gia này
     */
    public function movies(): HasMany
    {
        return $this->hasMany(Movie::class);
    }
} 