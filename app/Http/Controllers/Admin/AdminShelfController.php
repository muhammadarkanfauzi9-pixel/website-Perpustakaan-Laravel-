<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShelfRequest;
use App\Http\Requests\UpdateShelfRequest;
use App\Models\Shelf;
use Illuminate\Http\Request;

class AdminShelfController extends Controller
{
    public function index()
    {
        $shelves = Shelf::paginate(10);
        return view('admin.shelves.index', compact('shelves'));
    }

    public function create()
    {
         return view('admin.shelves.create');
    }

    public function store(StoreShelfRequest $request)
    {
        Shelf::create($request->validated());
        return redirect()->route('admin.shelves.index')->with('success', 'Shelf added successfully!');
    }

    public function show(string $id)
    {
        // ...
    }

    public function edit(Shelf $shelf)
    {
        return response()->json($shelf);
    }

    public function update(UpdateShelfRequest $request, Shelf $shelf)
    {
        dd($shelf->id);
        $shelf->update($request->validated());
        return redirect()->route('admin.shelves.index')->with('success', 'Shelf updated successfully!');
    }

    public function destroy(Shelf $shelf)
    {
        $shelf->delete();
        return response()->json(['success' => 'Shelf deleted successfully!']);
    }
}