<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch all movies from the database
        $movies = Movie::all();

        // Pass movies to the homepage view
        return view('home', compact('movies'));
    }
}
