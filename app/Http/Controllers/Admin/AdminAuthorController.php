<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author; 
use Illuminate\Http\Request;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;

class AdminAuthorController extends Controller
{
    public function index(Request $request)
    {
        $query = Author::orderBy('name');

        if ($request->has('author_name')) {
            $query->where('name', 'like', '%' . $request->author_name . '%');
        }

        $authors = $query->paginate(2);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.authors._table', compact('authors'))->render(),
                'links' => $authors->links()->toHtml()
            ]);
        }

        return view('admin.authors.index', compact('authors'));
    }

    public function create()
    {
        return redirect()->route('admin.authors.index');
    }

    public function store(StoreAuthorRequest $request)
    {
        Author::create($request->validated());
        return redirect()->route('admin.authors.index')->with('success', 'Author added successfully!');
    }

    public function edit(Author $author)
    {
        return response()->json($author);
    }

    public function update(UpdateAuthorRequest $request, Author $author)
    {
        $author->update($request->validated());
        return redirect()->route('admin.authors.index')->with('success', 'Author updated successfully!');
    }

    public function destroy(Author $author)
    {
        // Check if author has associated books
        if ($author->books()->count() > 0) {
            return redirect()->route('admin.authors.index')
                             ->with('error', 'Cannot delete author. There are books associated with this author.');
        }

        $author->delete();
        return redirect()->route('admin.authors.index')->with('success', 'Author deleted successfully!');
    }
    public function json($id)
{
    $author = Author::findOrFail($id);
    return response()->json($author);
}
    // ... (metode lainnya)
}