<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Movieflix</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
<nav class="flex justify-between items-center bg-gray-900 text-white p-4">
    <h1 class="text-2xl font-bold">Movieflix</h1>
    <ul class="flex space-x-4">
        <li><a href="{{ route('home') }}" class="hover:underline">Home</a></li>
        <li><a href="{{ route('admin') }}" class="hover:underline">Admin</a></li>
    </ul>
    <!-- Logout Button -->
    <form action="{{ route('logout') }}" method="POST" class="flex items-center">
        @csrf
        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
            Logout
        </button>
    </form>
</nav>

    <div class="container mx-auto mt-8">
        <div class="flex justify-between">
            <h2 class="text-xl font-bold text-black">Movie List</h2> <!-- Added text-black here -->
            <button class="bg-blue-500 text-white px-4 py-2 rounded" onclick="toggleAddMovieModal()">Add Movie</button> <!-- Added text-black here -->
        </div>
        <table class="w-full mt-4 bg-white shadow">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2 text-black">Title</th> <!-- Added text-black here -->
                    <th class="p-2 text-black">Genre</th> <!-- Added text-black here -->
                    <th class="p-2 text-black">Release Date</th> <!-- Added text-black here -->
                    <th class="p-2 text-black">Actions</th> <!-- Added text-black here -->
                </tr>
            </thead>
            <tbody>
                @foreach($movies as $movie)
                <tr>
    <td class="p-2 text-black">{{ $movie->title }}</td> <!-- Added text-black here -->
    <td class="p-2 text-black">{{ $movie->genre }}</td> <!-- Added text-black here -->
    <td class="p-2 text-black">{{ $movie->release_date }}</td> <!-- Added text-black here -->
    <td class="p-2">
        <!-- Use flex to align buttons in a row -->
        <div class="flex space-x-2">
            <!-- View Button -->
            <button class="bg-green-500 text-white px-2 py-1 rounded" onclick="viewMovie({{ $movie->id }})">View</button>
            
            <!-- Edit Button -->
            <button class="bg-yellow-500 text-white px-2 py-1 rounded" onclick="editMovie({{ $movie->id }})">Edit</button>
            
            <!-- Delete Button inside a form -->
            <form method="POST" action="{{ route('movies.destroy', $movie->id) }}" onsubmit="return confirm('Are you sure you want to delete this movie?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
            </form>
        </div>
    </td>
</tr>

                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Add Movie Modal -->
    <div id="addMovieModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded shadow-lg">
            <h2 class="text-lg font-bold mb-4 text-black">Add Movie</h2> <!-- Added text-black here -->
            <form method="POST" action="{{ route('movies.store') }}" enctype="multipart/form-data">
                @csrf
                <label class="text-black">Title</label> <!-- Added text-black here -->
                <input type="text" name="title" class="border w-full p-2 mb-4" required>
                <label class="text-black">Genre</label> <!-- Added text-black here -->
                <select name="genre" class="border w-full p-2 mb-4" required>
                    <option value="Action">Action</option>
                    <option value="Drama">Drama</option>
                    <option value="Comedy">Comedy</option>
                </select>
                <label class="text-black">Release Date</label> <!-- Added text-black here -->
                <input type="date" name="release_date" class="border w-full p-2 mb-4" required>
                <label class="text-black">Ratings</label> <!-- Added text-black here -->
                <select name="ratings" class="border w-full p-2 mb-4" required>
                    <option value="1">1 Star</option>
                    <option value="2">2 Stars</option>
                    <option value="3">3 Stars</option>
                    <option value="4">4 Stars</option>
                    <option value="5">5 Stars</option>
                </select>
                <label class="text-black">Duration</label> <!-- Added text-black here -->
                <input type="number" name="duration" class="border w-full p-2 mb-4" required>
                <label class="text-black">Country</label> <!-- Added text-black here -->
                <input type="text" name="country" class="border w-full p-2 mb-4" required>
                <label class="text-black">Description</label> <!-- Added text-black here -->
                <textarea name="description" class="border w-full p-2 mb-4" required></textarea>
                <label class="text-black">Image</label> <!-- Added text-black here -->
                <input type="file" name="image" class="border w-full p-2 mb-4">
                <div class="flex justify-end">
                    <button type="button" class="bg-gray-500 text-black px-4 py-2 rounded mr-2" onclick="toggleAddMovieModal()">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-black px-4 py-2 rounded">Add</button>
                </div>
            </form>
        </div>
    </div>
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

<!-- Edit Movie Modal -->
<div id="editMovieModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center">
    <div class="bg-white p-6 rounded shadow-lg">
        <h2 class="text-lg font-bold mb-4 text-black">Edit Movie</h2>
        <form method="POST" id="editMovieForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <label class="text-black">Title</label>
            <input type="text" name="title" id="editTitle" class="border w-full p-2 mb-4" required>
            
            <label class="text-black">Genre</label>
            <select name="genre" id="editGenre" class="border w-full p-2 mb-4" required>
                <option value="Action">Action</option>
                <option value="Drama">Drama</option>
                <option value="Comedy">Comedy</option>
            </select>
            
            <label class="text-black">Release Date</label>
            <input type="date" name="release_date" id="editReleaseDate" class="border w-full p-2 mb-4" required>
            
            <label class="text-black">Ratings</label>
            <select name="ratings" id="editRatings" class="border w-full p-2 mb-4" required>
                <option value="1">1 Star</option>
                <option value="2">2 Stars</option>
                <option value="3">3 Stars</option>
                <option value="4">4 Stars</option>
                <option value="5">5 Stars</option>
            </select>
            
            <label class="text-black">Duration</label>
            <input type="number" name="duration" id="editDuration" class="border w-full p-2 mb-4" required>
            
            <label class="text-black">Country</label>
            <input type="text" name="country" id="editCountry" class="border w-full p-2 mb-4" required>
            
            <label class="text-black">Description</label>
            <textarea name="description" id="editDescription" class="border w-full p-2 mb-4" required></textarea>
            
            <label class="text-black">Image</label>
            <input type="file" name="image" id="editImage" class="border w-full p-2 mb-4">
            
            <div class="flex justify-end">
                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded mr-2" onclick="toggleEditMovieModal()">Cancel</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Changes</button>
            </div>
        </form>
    </div>
</div>


    @if(session('message'))
        <div id="successMessage" class="fixed bottom-0 right-0 m-4 p-4 bg-green-500 text-black rounded shadow-lg">
            {{ session('message') }}
        </div>

        <script>
            setTimeout(function() {
                document.getElementById('successMessage').style.display = 'none';
            }, 5000); // The message will disappear after 5 seconds
        </script>
    @endif
    @if(session('message'))
        <div id="successMessage" class="fixed bottom-0 right-0 m-4 p-4 bg-green-500 text-black rounded shadow-lg">
            {{ session('message') }}
        </div>
        <script>
            setTimeout(function() {
                document.getElementById('successMessage').style.display = 'none';
            }, 5000); // The message will disappear after 5 seconds
        </script>
    @endif

    <script>
        function toggleAddMovieModal() {
            const modal = document.getElementById('addMovieModal');
            modal.classList.toggle('hidden');
        }
    </script>
    <script>
    function confirmDelete(movieId) {
        if (confirm('Are you sure you want to delete this movie?')) {
            // Perform the deletion using AJAX
            axios.delete(`/admin/movies/${movieId}`)
                .then(response => {
                    alert(response.data.message); // Show success message
                    window.location.reload(); // Reload the page after deletion
                })
                .catch(error => {
                    console.error('Error deleting the movie:', error);
                    alert('Failed to delete the movie.');
                });
        }
    }
</script>

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
            document.getElementById('movieDuration').textContent = data.duration + " minutes";
            document.getElementById('movieCountry').textContent = data.country;
            document.getElementById('movieDescription').textContent = data.description;

            // Generate star ratings
            const starContainer = document.getElementById('movieRatings');
            const rating = parseInt(data.ratings); // Convert ratings to an integer
            let stars = '';
            for (let i = 1; i <= 5; i++) {
                stars += i <= rating ? '★' : '☆'; // Filled stars for the rating, empty for the rest
            }
            starContainer.innerHTML = `<span class="text-yellow-500">${stars}</span>`;
        })
        .catch(error => console.error('Error fetching movie details:', error));

        toggleViewMovieModal();
        }
        function toggleEditMovieModal() {
    const modal = document.getElementById('editMovieModal');
    modal.classList.toggle('hidden');
}

function editMovie(movieId) {
    // Fetch movie details using AJAX
    fetch(`/movies/${movieId}`)
        .then(response => response.json())
        .then(movie => {
            // Populate the modal fields
            document.getElementById('editTitle').value = movie.title;
            document.getElementById('editGenre').value = movie.genre;
            document.getElementById('editReleaseDate').value = movie.release_date;
            document.getElementById('editRatings').value = movie.ratings;
            document.getElementById('editDuration').value = movie.duration;
            document.getElementById('editCountry').value = movie.country;
            document.getElementById('editDescription').value = movie.description;

            // Update the form's action to point to the correct update route
            const editForm = document.getElementById('editMovieForm');
            editForm.action = `/movies/${movieId}`;

            // Show the modal
            toggleEditMovieModal();
        })
        .catch(error => console.error('Error fetching movie details:', error));
}

    </script>

</body>
</html>
