<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Halaman Login</title>
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
<body class="bg-gradient-to-br from-purple-400 to-blue-600 min-h-screen flex items-center justify-center p-4">

    <div class="flex items-stretch justify-center w-full max-w-4xl shadow-50xl border-2 rounded-2xl overflow-hidden">

        <div class="flex-1 bg-gradient-to-r from-purple-500 to-white-600 text-white font-bold text-2xl text-center rounded-xl p-8 flex items-center justify-center">
            <p>PERPUSTAKAAN <br> ARKAN FAUZI</p>
        </div>

        <div class="flex-1 bg-gradient-to-r from-gray-100 to-gray-200 p-8 rounded-2xl shadow-2xl w-full max-w-md">
            <h1 class="text-3xl font-bold mb-8 text-center text-gray-800">Masuk ke Akun Anda</h1>

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

            <form action="{{ route('login.authenticate') }}" method="POST" class="space-y-6">
                @csrf

                

                <div>
                    <label for="username" class="block mb-2 font-semibold text-gray-700">Email atau Username</label>
                    <input type="text" name="username" id="username" value="{{ old('username') }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('username') border-red-500 @enderror" placeholder="email@example.com atau username">
                </div>



                <div>
                    <label for="password" class="block mb-2 font-semibold text-gray-700">Password</label>
                    <input type="password" name="password" id="password" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror" placeholder="Masukkan password">
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold py-3 rounded-lg shadow-lg hover:from-blue-600 hover:to-indigo-700">
                    Masuk
                </button>
            </form>
            
            <p class="mt-6 text-center text-gray-600">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-semibold">Daftar sekarang</a>
            </p>
        </div>
    </div>

</body>
</html>