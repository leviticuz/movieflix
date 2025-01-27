@extends('layouts.app')
@section('content')
<div class="container mx-auto mt-8">
    <!-- Search Bar and Genre Filter -->
    <form action="{{ route('home') }}" method="GET" class="mb-6 flex items-center gap-4">
        <!-- Search Bar -->
        <input 
            type="text" 
            name="search" 
            placeholder="Search movies..." 
            value="{{ request('search') }}" 
            class="border rounded p-2 w-full"
        />
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Search</button>
        <select name="genre" class="border rounded p-2" onchange="this.form.submit()">
            <option value="">All Genres</option>
            <option value="Action" {{ request('genre') == 'Action' ? 'selected' : '' }}>Action</option>
            <option value="Drama" {{ request('genre') == 'Drama' ? 'selected' : '' }}>Drama</option>
            <option value="Comedy" {{ request('genre') == 'Comedy' ? 'selected' : '' }}>Comedy</option>
            <option value="Horror" {{ request('genre') == 'Horror' ? 'selected' : '' }}>Horror</option>
            <option value="Sci-Fi" {{ request('genre') == 'Sci-Fi' ? 'selected' : '' }}>Sci-Fi</option>
            <option value="Romance" {{ request('genre') == 'Romance' ? 'selected' : '' }}>Romance</option>
            <!-- Add more genres as needed -->
        </select>
    </form>

    <!-- View Movie Modal -->
    <div id="viewMovieModal" class="hidden fixed inset-0 bg-black-900 bg-opacity-50 flex justify-center items-center">
    <div class="bg-white p-6 rounded shadow-lg w-2/3 relative"> <!-- relative positioning -->
        <!-- Close button -->
        <button class="absolute top-2 right-2 p-2 bg-gray-300 text-black rounded-full" onclick="toggleViewMovieModal()">Close</button>
        
        <div class="flex">
            <div class="w-2/3">
                <!-- Movie Image -->
                <img id="movieImage" class="w-full h-auto max-w-full max-h-96 object-contain" />
            </div>
            <div class="w-2/3 pl-4">
                <!-- Movie Details -->
                <h2 id="movieTitle" class="text-xl font-bold text-black"></h2>
                <p><strong>Genre:</strong> <span id="movieGenre"></span></p>
                <p><strong>Release Date:</strong> <span id="movieReleaseDate"></span></p>
                <p><strong>Ratings:</strong> <span id="movieRatings"></span></p>
                <p><strong>Duration:</strong> <span id="movieDuration"></span></p>
                <p><strong>Country:</strong> <span id="movieCountry"></span></p>
                <p><strong>Description:</strong> <span id="movieDescription"></span></p>
            </div>
        </div>
    </div>
</div>


    <!-- Movie List -->
    <div class="mt-4">
    @if($movies->isEmpty())
        <p class="text-gray-500">No movies found matching your search query.</p>
    @else
        <div class="grid grid-cols-6 gap-4">
            @foreach($movies as $movie)
                <div 
                    class="border rounded shadow p-2 flex flex-col items-center cursor-pointer" 
                    onclick="viewMovie({{ $movie->id }})"
                > <!-- Added cursor-pointer and onclick for the modal -->
                    <img 
                        src="{{ asset('storage/' . $movie->image) }}" 
                        alt="{{ $movie->title }}" 
                        class="w-20 h-36 object-cover mb-2" />
                    <h3 class="text-sm font-bold text-center">{{ $movie->title }}</h3> <!-- Centered text -->
                    <p class="text-xs text-gray-600 text-center">{{ $movie->genre }}</p> <!-- Centered text -->
                </div>
            @endforeach
        </div>
    @endif
</div>

</div>
@endsection


<script>
    function toggleViewMovieModal() {
            const modal = document.getElementById('viewMovieModal');
            modal.classList.toggle('hidden');
        }
    function viewMovie(movieId) {
        
    // Fetch the movie details from your backend (using Ajax)
    fetch(`/movies/${movieId}`)
        .then(response => response.json())
        .then(data => {
            // Populate modal with the movie details
            document.getElementById('movieImage').src = '/storage/' + data.image;
            document.getElementById('movieTitle').textContent = data.title;
            document.getElementById('movieGenre').textContent = data.genre;
            document.getElementById('movieReleaseDate').textContent = data.release_date;
            document.getElementById('movieRatings').textContent = data.ratings + " Stars";
            document.getElementById('movieDuration').textContent = data.duration + " minutes";
            document.getElementById('movieCountry').textContent = data.country;
            document.getElementById('movieDescription').textContent = data.description;
        })
        .catch(error => console.error('Error fetching movie details:', error));

    // Show the modal
    toggleViewMovieModal();
}

</script>