<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie; 

class AdminController extends Controller
{
    public function index() {
        $movies = Movie::all();
        return view('admin', compact('movies'));
    }
}
