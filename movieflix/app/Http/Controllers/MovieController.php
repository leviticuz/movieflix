<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index(Request $request)
     {
         // Get the search and genre filters
         $search = $request->input('search');
         $genre = $request->input('genre');
     
         // Fetch movies with optional filtering by title and genre
         $movies = Movie::when($search, function ($query, $search) {
             return $query->where('title', 'like', '%' . $search . '%');
         })
         ->when($genre, function ($query, $genre) {
             return $query->where('genre', $genre);
         })
         ->get();
     
         // Return view with movies
         return view('home', compact('movies'));
     }
     

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'genre' => 'required',
            'release_date' => 'required',
            'ratings' => 'required',
            'duration' => 'required',
            'country' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);
    
        $movie = new Movie($request->all());
        if ($request->hasFile('image')) {
            $movie->image = $request->file('image')->store('movies', 'public');
        }
        $movie->save();
    
        return redirect()->back()->with('message', 'Movie added successfully!');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie)
    {
        return response()->json($movie);  // Return movie data as JSON
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movie $movie)
{
    $request->validate([
        'title' => 'required',
        'genre' => 'required',
        'release_date' => 'required',
        'ratings' => 'required',
        'duration' => 'required',
        'country' => 'required',
        'description' => 'required',
        'image' => 'nullable|image|max:2048',
    ]);

    // Update movie details
    $movie->fill($request->except('image'));

    // Handle image upload if present
    if ($request->hasFile('image')) {
        $movie->image = $request->file('image')->store('movies', 'public');
    }

    $movie->save();

    return redirect()->back()->with('message', 'Movie updated successfully!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        $movie->delete();
        return redirect()->back()->with('message', 'Movie deleted successfully!');
    }

}
