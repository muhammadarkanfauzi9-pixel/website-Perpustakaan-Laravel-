@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="flex flex-col gap-1">
        <h1 class="font-semibold md:text-lg">Dashboard</h1>
        <div class="flex items-center gap-1">
            <p class="text-xs text-gray-400 md:text-sm">Admin</p>
            <p class="text-xs text-gray-400 md:text-sm">/</p>
            <p class="text-xs text-gray-400 md:text-sm">Dashboard</p>
        </div>
    </div>

    {{-- Statistik Cards --}}
    <div class="mt-6 grid grid-cols-2 gap-y-4 gap-x-2 md:grid-cols-4 md:gap-x-4">
    <!-- Total Books -->
    <div class="px-4 py-5 rounded bg-white border border-gray-200">
        <p class="font-medium text-sm">Total Books</p>
        <hr class="w-full bg-gray-200 my-2">
        <p class="font-semibold text-xl">{{ $totalBooks }}</p>
    </div>

    <!-- Total Users -->
    <div class="px-4 py-5 rounded bg-white border border-gray-200">
        <p class="font-medium text-sm">Total Users</p>
        <hr class="w-full bg-gray-200 my-2">
        <p class="font-semibold text-xl">{{ $totalUsers }}</p>
    </div>
</div>

@endsection