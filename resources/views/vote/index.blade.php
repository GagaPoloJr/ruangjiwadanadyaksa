@extends('layouts.app')

@section('title', 'Vote Artwork')

@section('content')
    <div class="max-w-7xl mx-auto mt-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">
            Featured Artworks
            <div class="h-1 w-24 bg-amber-400 mx-auto mt-2 rounded-full"></div>
        </h2>

        @if (session('success'))
            <div class="mt-4 bg-green-100 text-green-700 p-3 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mt-4 bg-red-100 text-red-700 p-3 rounded-md">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
            @foreach ($artworks as $artwork)
                <div
                    class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="relative overflow-hidden group h-64">
                        <img src="{{ asset('storage/' . $artwork->image) }}" alt="{{ $artwork->title }}"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" />
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end">
                            <div class="p-4 text-white">
                                <p class="font-medium">
                                    {{ $artwork->category }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="p-5">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $artwork->title }}</h3>
                        <p class="text-gray-600 mb-4 line-clamp-2">{{ $artwork->featured_description }}</p>
                        <div class="flex gap-2">
                            <button
                                class="flex-1 gap-2 bg-amber-500 hover:bg-amber-600 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-300 flex items-center justify-center"
                                onclick="openModal({{ $artwork->id }})">
                                <x-heroicon-o-star width='20' /> Vote
                            </button>
                            <a href="{{ route('artworks.show', $artwork->slug) }}"
                                class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-lg transition-colors duration-300 flex items-center justify-center">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal -->
    <div id="voteModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6">
            <div class="flex justify-between items-center border-b pb-2">
                <h5 class="text-xl font-bold">Pilih Kategori untuk Vote</h5>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">&times;</button>
            </div>
            <form id="voteForm" action="{{ route('vote.store') }}" method="POST" class="mt-4">
                @csrf
                <input type="hidden" name="artwork_id" id="artwork_id">
                <div class="mb-4">
                    <label for="category_id" class="block font-semibold text-gray-700">Pilih Kategori</label>
                    <select name="category_id" id="category_id"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                        <option value="" disabled selected>-- Pilih Kategori --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg w-full hover:bg-blue-600 transition">
                    Kirim Vote
                </button>
            </form>
        </div>
    </div>

    <script>
        function openModal(artworkId) {
            document.getElementById("artwork_id").value = artworkId;
            document.getElementById("voteModal").classList.remove("hidden");
        }

        function closeModal() {
            document.getElementById("voteModal").classList.add("hidden");
        }
    </script>
@endsection
