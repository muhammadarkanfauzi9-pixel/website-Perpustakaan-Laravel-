<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>
<body class="bg-gray-800">
    
    {{-- navbar --}}
    <nav class="bg-blue-600 p-4 text-white">
        <div class="container mx-auto flex justify-between">
            <a href="{{ route('home') }}" class="font-bold">Perpustakaan</a>
            <a href="{{ route('register') }}" class="hover:underline">Register</a>
        </div>
    </nav>

    <main class="container mx-auto py-6">
        @yield('content')
    </main>
</body>
</html>