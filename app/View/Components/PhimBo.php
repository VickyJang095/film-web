<?php

namespace App\View\Components;

use Closure;
use App\Models\Movie;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PhimBo extends Component
{
    public $series;
    public function __construct()
    {
        $this->series = Movie::where('type', 'series')->latest()->take(4)->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.phim-bo');
    }
}
