<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePublisherRequest;
use App\Http\Requests\UpdatePublisherRequest;
use App\Models\Publisher;
use Illuminate\Http\Request;

class AdminPublisherController extends Controller
{
    public function index(Request $request)
    {
        $query = Publisher::orderBy('name');

        if ($request->has('publisher_name')) {
            $query->where('name', 'like', '%' . $request->publisher_name . '%');
        }

        $publishers = $query->paginate(2);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.publishers._table', compact('publishers'))->render(),
                'links' => $publishers->links()->toHtml()
            ]);
        }

        return view('admin.publishers.index', compact('publishers'));
    }

    public function create()
    {
        // Tidak diperlukan karena kita menggunakan modal
    }

   public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
    ]);

    Publisher::create([
        'name' => $request->name,
        'address' => $request->address,
        'phone' => $request->phone,
    ]);

    return redirect()->route('admin.publishers.index')->with('success', 'Publisher berhasil ditambahkan.');
}


    public function show(string $id)
    {
        // Tidak diperlukan
    }

    public function showJson(Publisher $publisher)
    {
        return response()->json($publisher);
    }

    public function edit(Publisher $publisher)
    {
        return response()->json($publisher);
    }

    public function update(UpdatePublisherRequest $request, Publisher $publisher)
    {
        $publisher->update($request->validated());
        return redirect()->route('admin.publishers.index')->with('success', 'Publisher updated successfully!');
    }

    public function destroy(Publisher $publisher)
    {
        $publisher->delete();
        return redirect()
            ->route('admin.publishers.index')
            ->with('success', 'Publisher deleted successfully!');
    }
}
