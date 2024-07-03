<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories_active = Category::whereNull('deleted_at')->get(); // Memuat kategori yang tidak dihapus
        $categories_deleted = Category::onlyTrashed()->get(); // Memuat kategori yang sudah dihapus secara lunak
        
        return view('admin.categories.index', compact('categories_active', 'categories_deleted'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
        ]);

        Category::create($request->only(['name', 'description']));

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Category created successfully');
    }



    public function edit($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
        ]);

        $category = Category::withTrashed()->findOrFail($id);
        $category->update($request->only(['name', 'description']));

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Category updated successfully');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Category deleted successfully');
    }

    public function restore($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Category restored successfully');
    }
    public function permanentDelete($id)
{
    $category = Category::withTrashed()->findOrFail($id);
    $category->forceDelete();

    return redirect()->route('admin.categories.index')
                     ->with('success', 'Category permanently deleted successfully');
}

}
