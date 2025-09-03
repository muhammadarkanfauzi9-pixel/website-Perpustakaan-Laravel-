<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Form Register</title>
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-400 to-purple-600 min-h-screen flex items-center justify-center p-4">

   <div class="flex items-center justify-center min-h-screen">
    <div class="bg-gradient-to-r from-gray-100 to-gray-200 p-8 rounded-2xl shadow-2xl w-full max-w-lg">
        <h1 class="text-3xl font-bold mb-8 text-center text-gray-800">Daftar Akun Baru</h1>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-800 p-4 mb-6 rounded-md" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-4 mb-6 rounded-md" role="alert">
                <p class="font-bold">Terjadi Kesalahan!</p>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="flex space-x-4" >
                <div class="flex-1">
                    <label for="first_name" class="block mb-2 font-semibold text-gray-700">Nama Depan</label>
                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('first_name') border-red-500 @enderror" placeholder="John">
                </div>
                <div class="flex-1">
                    <label for="last_name" class="block mb-2 font-semibold text-gray-700">Nama Belakang</label>
                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('last_name') border-red-500 @enderror" placeholder="Doe">
                </div>
            </div>

            <div>
                <label for="username" class="block mb-2 font-semibold text-gray-700">Username</label>
                <input type="text" name="username" id="username" value="{{ old('username') }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('username') border-red-500 @enderror" placeholder="username_anda">
            </div>

            <div>
                <label for="email" class="block mb-2 font-semibold text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror" placeholder="email@example.com">
            </div>

            <div>
                <label for="password" class="block mb-2 font-semibold text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror" placeholder="Masukkan password">
            </div>

            <div>
                <label for="password_confirmation" class="block mb-2 font-semibold text-gray-700">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Masukkan ulang password">
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold py-3 rounded-lg shadow-lg hover:from-blue-600 hover:to-indigo-700">
                Daftar
            </button>
        </form>
    </div>
</div>

</body>
</html>