<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function show($slug)
    {
        $country = Country::where('slug', $slug)->firstOrFail();
        $movies = $country->movies()->paginate(12);
        return view('countries.show', compact('country', 'movies'));
    }
} 