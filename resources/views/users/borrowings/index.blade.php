@extends('layouts.app') {{-- Ganti dengan layout utama Anda --}}

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">Riwayat Peminjaman Anda</h1>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-500 text-white p-4 rounded-lg mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-2 px-4 border-b text-left text-gray-700">Judul Buku</th>
                    <th class="py-2 px-4 border-b text-left text-gray-700">Penulis</th>
                    <th class="py-2 px-4 border-b text-left text-gray-700">Tanggal Pinjam</th>
                    <th class="py-2 px-4 border-b text-left text-gray-700">Tanggal Kembali</th>
                    <th class="py-2 px-4 border-b text-left text-gray-700">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($borrowings as $borrowing)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b text-sm text-gray-600">{{ $borrowing->book->title }}</td>
                        <td class="py-2 px-4 border-b text-sm text-gray-600">{{ $borrowing->book->author->name }}</td>
                        <td class="py-2 px-4 border-b text-sm text-gray-600">{{ $borrowing->borrowed_at->format('d M, Y') }}</td>
                        <td class="py-2 px-4 border-b text-sm text-gray-600">
                            @if ($borrowing->returned_at)
                                {{ $borrowing->returned_at->format('d M, Y') }}
                            @else
                                <span class="text-red-500">Belum Kembali</span>
                            @endif
                        </td>
                        <td class="py-2 px-4 border-b text-sm text-gray-600">
                            @if ($borrowing->returned_at)
                                <span class="text-green-500">Sudah Kembali</span>
                            @else
                                <span class="text-orange-500">Sedang Dipinjam</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 text-center text-gray-500">Anda tidak memiliki riwayat peminjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection