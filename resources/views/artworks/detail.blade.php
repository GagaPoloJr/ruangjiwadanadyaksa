@extends('layouts.detail')

@section('title', $artwork->title . ' - Detail Artwork')

@section('content')

    <!-- Success/Error Modal -->
    @if (session('success') || session('error'))
        <div id="messageModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6">
                <div class="flex justify-between items-center border-b pb-2">
                    <h5 class="text-xl font-bold">
                        {{ session('success') ? '✅ Berhasil!' : '❌ Gagal!' }}
                    </h5>
                    <button onclick="closeMessageModal()" class="text-gray-500 hover:text-gray-700">&times;</button>
                </div>
                <p class="mt-4 text-gray-700">
                    {{ session('success') ?? session('error') }}
                </p>
                <button onclick="closeMessageModal()"
                    class="mt-4 w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                    OK
                </button>
            </div>
        </div>
    @endif


    <a href="{{ route('vote.index') }}" class="text-blue-500 hover:text-blue-700 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Kembali ke Galeri
    </a>

    <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
        <div x-data="{ showModal: false }">
            <div class="relative group cursor-pointer">
                <img @click="showModal = true" src="{{ asset('storage/' . $artwork->image) }}" alt="{{ $artwork->title }}"
                    class="w-full h-96 object-cover rounded-lg transition-transform duration-300 ease-in-out" />

                <span
                    class="absolute top-4 left-4 bg-amber-500 text-white text-xs font-semibold px-3 py-1 rounded-full shadow-md">
                    {{ $artwork->category ?? 'Uncategorized' }}
                </span>
            </div>

            <div x-cloak x-show="showModal" x-transition
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

        <div class="flex mb-3 w-full">
            @php
                $isVotingEnded = now()->greaterThanOrEqualTo($votingDeadline);
            @endphp

            @if (!$isVotingEnded)
                <button
                    class="flex-1 bg-[#7B0206] rounded-lg text-white font-bold py-3 px-8 transition-colors duration-300 hover:bg-[#9B0206] border-2 border-[#111111] shadow-[0px_4px_0px_0px_#111111] items-center justify-center"
                    onclick="openModal({{ $artwork->id }})">
                    <div class="flex justify-center items-center gap-2">
                        <x-heroicon-o-star width='20' /> <span>
                            Vote
                        </span>
                    </div>
                </button>
            @endif
        </div>

        <p class="text-sm text-gray-500 mt-4">Oleh: {{ $artwork->author }}</p>
        <p class="text-sm text-gray-500 mt-2">Diupload: {{ $artwork->created_at->format('d-m-Y') }}</p>
        <h1 class="text-3xl font-bold mt-4">{{ $artwork->title }}</h1>
        <div class="prose prose-lg max-w-none text-gray-600 mt-2">
            {!! strip_tags($artwork->description, '<strong><em><u><s><h2><h3><ul><ol><li><blockquote><br>') !!}
        </div>
    </div>

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
                class="w-full bg-amber-500 hover:bg-amber-600 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-300 border-2 border-[#111111] shadow-[0px_4px_0px_0px_#111111]">
                Kirim Komentar
            </button>
        </form>
    </div>

    <!-- Daftar Komentar -->
    <div class="mt-8 bg-white rounded-lg shadow-lg p-6 border border-gray-200">
        <h2 class="text-2xl font-bold mb-4">💬 Komentar</h2>
        @if ($artwork->comments->isEmpty())
            <p class="text-gray-600">Belum ada komentar.</p>
        @else
            @foreach ($artwork->comments as $comment)
                <div class="flex items-start space-x-4 p-4 border-b last:border-b-0">
                    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr($comment->name, 0, 1)) }}
                    </div>

                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <p class="font-semibold text-gray-800">{{ $comment->name }}</p>
                            <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                        </div>
                        <p class="text-gray-700 mt-1">{{ $comment->comment }}</p>
                    </div>
                </div>
            @endforeach
        @endif
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

@endsection


@section('scripts')
    <script>
        function openModal(artworkId) {
            document.getElementById("artwork_id").value = artworkId;
            document.getElementById("voteModal").classList.remove("hidden");
        }

        function closeModal() {
            document.getElementById("voteModal").classList.add("hidden");
        }

        function closeMessageModal() {
            document.getElementById("messageModal").remove();
        }
    </script>
@endsection
