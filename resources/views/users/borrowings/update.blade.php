{{-- resources/views/users/borrowings/index.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">Riwayat Peminjaman Saya</h1>

    {{-- Pesan Sukses --}}
    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-6 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="py-3 px-6 text-left">Judul Buku</th>
                    <th class="py-3 px-6 text-left">Tanggal Pinjam</th>
                    <th class="py-3 px-6 text-left">Status</th>
                    <th class="py-3 px-6 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($borrowings as $borrowing)
                    <tr>
                        <td class="py-4 px-6">{{ $borrowing->book->title }}</td>
                        <td class="py-4 px-6">{{ $borrowing->borrowed_at->format('d M Y') }}</td>
                        <td class="py-4 px-6">
                            @if ($borrowing->returned_at)
                                <span class="bg-green-500 text-white px-2 py-1 rounded">Dikembalikan</span>
                            @else
                                <span class="bg-yellow-500 text-white px-2 py-1 rounded">Dipinjam</span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            {{-- Tampilkan tombol hanya jika buku belum dikembalikan --}}
                            @if (!$borrowing->returned_at)
                                <form action="{{ route('borrowings.update', $borrowing->id) }}" method="POST">
                                    @csrf
                                    @method('PUT') {{-- PENTING: Gunakan @method('PUT') --}}
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 rounded">
                                        Kembalikan
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-4 px-6 text-center text-gray-500">
                            Anda belum meminjam buku.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $borrowings->links() }}
        </div>
    </div>
</div>
@endsection