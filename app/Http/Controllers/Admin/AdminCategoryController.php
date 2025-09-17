<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function store(StoreCategoryRequest $request)
    {
        Category::create($request->validated());
        return redirect()->route('admin.categories.index')->with('success', 'Category added successfully!');
    }

    public function json($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);
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
