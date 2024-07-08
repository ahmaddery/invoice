<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        // Mengambil semua produk yang belum dihapus secara lunak
        $products = Product::orderBy('created_at', 'DESC')->with('user')->whereNull('deleted_at')->get();
        
        // Mengambil semua produk yang sudah dihapus secara lunak
        $deletedProducts = Product::onlyTrashed()->orderBy('deleted_at', 'DESC')->with('user')->get();

        return view('admin.products.index', compact('products', 'deletedProducts'));
    }
    

    public function create()
    {
        $users = User::all(); // Misalnya, ambil semua data user dari model User
        $categories = Category::all(); // Ambil semua data category dari model Category
    
        return view('admin.products.create', compact('users', 'categories'));
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'category_id' => 'required',
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        Product::create($request->all());

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $users = User::all(); // Misalnya, ambil semua data user dari model User
        $categories = Category::all(); // Ambil semua data category dari model Category
    
        return view('admin.products.edit', compact('product', 'users', 'categories'));
    }
    

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required',
            'category_id' => 'required',
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->all());

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
    public function restore($id)
{
    $product = Product::onlyTrashed()->findOrFail($id);
    $product->restore();

    return redirect()->route('admin.products.index')
        ->with('success', 'Product restored successfully.');
}


}
