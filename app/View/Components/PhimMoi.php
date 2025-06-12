<?php

namespace App\View\Components;

use App\Models\Movie;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PhimMoi extends Component
{
    public $latestMovies;
    public function __construct($limit = 4)
    {
        $this->latestMovies = Movie::orderBy('created_at', 'desc') -> take($limit)->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.phim-moi');
    }
}
