<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-gradient-to-br from-amber-50 to-yellow-100">
    {{-- <div class="bg-gradient-to-r from-amber-400 to-yellow-500 shadow-lg">
        <div class="max-w-6xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <h4 class="text-3xl font-extrabold text-white">
                    <x-feathericon-award class="inline-block mr-2 h-8 w-8" />
                    Ruang Jiwa Danadyaksa
                </h4>
                <div class="text-white text-sm">
                    <span class="bg-amber-600 px-3 py-1 rounded-full">Vote for your favorite artwork</span>
                </div>
            </div>
        </div>
    </div> --}}
    <div class=" mx-auto">
        @yield('content')
    </div>
    @include('layouts.footer')
</body>

</html>
