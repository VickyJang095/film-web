<?php

namespace App\View\Components;

use Closure;
use App\Models\Movie;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PhimLe extends Component
{
    public $movie;
    public function __construct()
    {
        $this->movie = Movie::where('type', 'movie')->take(4)->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.phim-le');
    }
}
