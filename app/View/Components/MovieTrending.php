<?php

namespace App\View\Components;

use Closure;
use App\Models\Movie;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MovieTrending extends Component
{
    public $trendingMovies;
    public function __construct()
    {
        $this->trendingMovies = Movie::where('release_year', '>=', 2024)
                                        ->orderBy("rating", "desc") ->limit(4)->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.movie-trending');
    }
}
