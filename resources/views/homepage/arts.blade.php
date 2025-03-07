<div id="vote" class="max-w-7xl mx-auto">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">
        Vote Karya Seni
        <div class="h-1 w-24 bg-amber-400 mx-auto mt-2 rounded-full"></div>
    </h2>

    {{-- @if (session('success'))
        <div class="mt-4 bg-green-100 text-green-700 p-3 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mt-4 bg-red-100 text-red-700 p-3 rounded-md">
            {{ session('error') }}
        </div>
    @endif --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
        @forelse ($artworks as $artwork)
            <div
                class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="relative overflow-hidden group h-64">
                    <img src="{{ asset('storage/' . $artwork->image) }}" alt="{{ $artwork->title }}"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" />
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end">
                        <div class="p-4 text-white">
                            <p class="font-medium">
                                {{ getCategoryLabel($artwork->category) }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="p-5 flex flex-col justify-between h-auto">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $artwork->title }}</h3>
                        <p class="text-gray-600 mb-4 line-clamp-2">{{ $artwork->featured_description }}</p>
                    </div>

                    <div class="flex gap-2">
                      
                        {{-- @if (!$isVotingEnded)
                            <button
                                class="flex-1 gap-2 bg-amber-500 hover:bg-amber-600 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-300 flex items-center justify-center"
                                onclick="openModal({{ $artwork->id }})">
                                <x-heroicon-o-star width='20' /> Vote
                            </button>
                        @endif --}}

                        <a href="{{ route('artworks.show', $artwork->slug) }}"
                            class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-lg transition-colors duration-300 flex items-center justify-center border-2 border-[#111111] shadow-[0px_4px_0px_0px_#111111]">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center text-gray-500">
                <p>Tidak ada karya seni yang tersedia saat ini.</p>
            </div>
        @endforelse
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
