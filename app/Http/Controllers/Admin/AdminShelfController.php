<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShelfRequest;
use App\Http\Requests\UpdateShelfRequest;
use App\Models\Shelf;
use Illuminate\Http\Request;

class AdminShelfController extends Controller
{
    public function index(Request $request)
    {
        $query = Shelf::orderBy('name');

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $shelves = $query->paginate(2);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.shelves._table', compact('shelves'))->render(),
                'links' => $shelves->links()->toHtml()
            ]);
        }

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

    public function update(Request $request, Shelf $shelf)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:shelves,name,' . $shelf->id,
        // ... validasi lain jika ada
    ]);

    $shelf->update($request->all());

    return redirect()->route('admin.shelves.index')
                     ->with('success', 'Shelf updated successfully!');
}

    public function destroy(Shelf $shelf)
{
    $shelf->delete();
    
    return redirect()->route('admin.shelves.index')
                     ->with('success', 'Shelf deleted successfully!');
}
}