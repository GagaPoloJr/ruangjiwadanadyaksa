@extends('layouts.detail')

@section('title', $artwork->title . ' - Detail Artwork')

@section('content')
    <!-- Tombol Kembali -->
    <a href="{{ route('vote.index') }}" class="text-blue-500 hover:text-blue-700 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Kembali ke Galeri
    </a>

    <!-- Detail Artwork -->
    <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
        <div class="relative group cursor-pointer" x-data="{ showModal: false }">
            <!-- Gambar Artwork -->
            <img @click="showModal = true" src="{{ asset('storage/' . $artwork->image) }}" alt="{{ $artwork->title }}"
                class="w-full h-96 object-cover rounded-lg transition-transform duration-300 ease-in-out" />

            <!-- Badge Kategori -->
            <span
                class="absolute top-4 left-4 bg-amber-500 text-white text-xs font-semibold px-3 py-1 rounded-full shadow-md">
                {{ $artwork->category ?? 'Uncategorized' }}
            </span>

            <!-- Modal Gambar -->
            <div x-show="showModal" x-transition
                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                @click="showModal = false">
                <div class="relative bg-white rounded-lg p-4 max-w-4xl w-full shadow-lg" @click.stop>
                    <button class="absolute top-2 right-2 text-gray-600 hover:text-gray-800" @click="showModal = false">
                        &times;
                    </button>
                    <img src="{{ asset('storage/' . $artwork->image) }}" alt="{{ $artwork->title }}"
                        class="w-full h-auto rounded-lg" />
                </div>
            </div>
        </div>

        <!-- Informasi Artwork -->
        <p class="text-sm text-gray-500 mt-4">Oleh: {{ $artwork->author }}</p>
        <p class="text-sm text-gray-500 mt-2">Diupload: {{ $artwork->created_at->format('d-m-Y') }}</p>
        <h1 class="text-3xl font-bold mt-4">{{ $artwork->title }}</h1>
        <div class="prose prose-lg max-w-none text-gray-600 mt-2">
            {!! strip_tags($artwork->description, '<strong><em><u><s><h2><h3><ul><ol><li><blockquote><br>') !!}
        </div>
    </div>

    <!-- Form Komentar -->
    <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Tinggalkan Komentar</h2>
        <form action="{{ route('comments.store', $artwork->slug) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block font-semibold text-gray-700">Nama:</label>
                <input type="text" name="name" id="name"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500"
                    required>
            </div>
            <div class="mb-4">
                <label for="comment" class="block font-semibold text-gray-700">Komentar:</label>
                <textarea name="comment" id="comment" rows="4"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500" required></textarea>
            </div>
            <button type="submit"
                class="w-full bg-amber-500 hover:bg-amber-600 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-300">
                Kirim Komentar
            </button>
        </form>
    </div>

    <!-- Daftar Komentar -->
    <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Komentar</h2>
        @if ($artwork->comments->isEmpty())
            <p class="text-gray-600">Belum ada komentar.</p>
        @else
            @foreach ($artwork->comments as $comment)
                <div class="mb-4 border-b pb-4">
                    <div class="flex justify-between items-center">
                        <p class="font-bold">{{ $comment->name }}</p>
                        <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                    </div>
                    <p class="text-gray-700 mt-2">{{ $comment->comment }}</p>
                </div>
            @endforeach
        @endif
    </div>
@endsection
