<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    @vite('resources/css/app.css')
    @vite(['resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-amber-50 to-yellow-100">
    <div class="container max-w-[800px] mx-auto px-4 py-8">
        @yield('content')
    </div>
</body>

@yield('scripts')

</html>
