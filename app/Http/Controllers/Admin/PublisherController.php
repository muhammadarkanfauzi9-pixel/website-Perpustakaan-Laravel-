<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Mulai dengan query builder
        $query = Publisher::orderBy('name');

        // Tambahkan logika pencarian jika ada
        if ($request->has('publisher_name')) {
            $query->where('name', 'like', '%' . $request->publisher_name . '%');
        }

        // Terapkan paginate() pada query builder
        $publishers = $query->paginate(3); // Menampilkan 3 data per halaman

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.publishers._table', compact('publishers'))->render(),
                'links' => $publishers->links()->toHtml()
            ]);
        }

        return view('admin.publishers.index', compact('publishers'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // View create form (jika terpisah)
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
        ]);

        Publisher::create($request->all());

        return redirect()->route('admin.publishers.index')
                         ->with('success', 'Publisher berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Publisher $publisher)
    {
        // Menampilkan detail publisher
    }

    /**
     * Menampilkan data publisher dalam format JSON.
     */
    public function showJson(Publisher $publisher)
    {
        return response()->json($publisher);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Publisher $publisher)
    {
        // View edit form (jika terpisah)
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Publisher $publisher)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
        ]);

        $publisher->update($request->all());

        return redirect()->route('admin.publishers.index')
                         ->with('success', 'Publisher berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publisher $publisher)
    {
        $publisher->delete();

        return redirect()->route('admin.publishers.index')
                         ->with('success', 'Publisher berhasil dihapus.');
    }
}