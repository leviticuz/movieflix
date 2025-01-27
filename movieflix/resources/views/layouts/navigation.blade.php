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
