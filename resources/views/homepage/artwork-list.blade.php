@foreach ($artworks as $artwork)
    <div
        class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="relative overflow-hidden group h-64">
            <img src="{{ asset('storage/' . $artwork->image) }}" alt="{{ $artwork->title }}"
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" />
            <div
                class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end">
                <div class="p-4 text-white">
                    <p class="font-medium">{{ $artwork->category_label }}</p>
                </div>
            </div>
        </div>
        <div class="p-5 flex flex-col justify-between h-auto">
            <div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $artwork->title }}</h3>
                <p class="text-gray-600 mb-4 line-clamp-2">{{ $artwork->featured_description }}</p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('artworks.show', $artwork->slug) }}"
                    class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-lg transition-colors duration-300 flex items-center justify-center border-2 border-[#111111] shadow-[0px_4px_0px_0px_#111111]">
                    Lihat Detail
                </a>
            </div>
        </div>
    </div>
@endforeach
