<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    // Define fillable fields for mass assignment
    protected $fillable = [
        'title', 
        'genre', 
        'release_date', 
        'ratings', 
        'duration', 
        'country', 
        'description', 
        'image',
    ];

    // If you have timestamps or other attributes, make sure they're handled properly
    public $timestamps = true;
}

