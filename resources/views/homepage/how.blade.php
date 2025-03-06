<div class="how-it-works  py-12">
    <div class="container max-w-6xl mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-10 items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Bagaimana Cara Voting Berjalan?</h2>
                <p class="text-gray-600 mb-6">Kamu bisa vote karya seni yang kamu suka dengan cara berikut:</p>

                <div class="grid gap-6">
                    @foreach ($steps as $step)
                        <div class="flex items-start gap-4">
                            <div
                                class="w-12 h-12 bg-amber-500 text-white flex items-center justify-center rounded-full text-lg font-bold shrink-0">
                                {{ $step['number'] }}
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800 mb-1">{{ $step['title'] }}</h3>
                                <p class="text-gray-600">{{ $step['description'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div>
                <img src="{{ asset('assets/img/how-it-works.png') }}" alt="Vote" class="w-full rounded-lg">
            </div>
        </div>
    </div>
</div>
