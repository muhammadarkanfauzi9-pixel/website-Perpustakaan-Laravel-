<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;

class AdminCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::orderBy('name');

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $categories = $query->paginate(2);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.categories._table', compact('categories'))->render(),
                'links' => $categories->links()->toHtml()
            ]);
        }

        return view('admin.categories.index', compact('categories'));
    }

    public function store(StoreCategoryRequest $request)
    {
        Category::create($request->validated());
        return redirect()->route('admin.categories.index')->with('success', 'Category added successfully!');
    }

    public function json(Category $category)
    {
        return response()->json($category);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy($id)
{
    $category = Category::findOrFail($id);

    // Cek apakah ada buku terkait
    if ($category->books()->count() > 0) {
        return redirect()->route('admin.categories.index')
                         ->with('error', 'Cannot delete category. There are books associated with it.');
    }

    $category->delete();
    return redirect()->route('admin.categories.index')
                     ->with('success', 'Category deleted successfully!');
}

}
