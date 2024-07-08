<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    // Menampilkan semua produk
    public function index()
    {
        $products = Product::where('user_id', Auth::id())->get();
        return view('produk.index', compact('products'));
    }

    // Menampilkan form untuk membuat produk baru
    // Menampilkan form untuk membuat produk baru
    public function create()
    {
        $categories = Category::all(); // Ambil semua kategori
        return view('produk.create', compact('categories'));
    }

    // Menyimpan produk baru ke dalam database
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $product = new Product([
            'user_id' => Auth::id(),
            'category_id' => $request->get('category_id'),
            'name' => $request->get('name'),
            'price' => $request->get('price'),
            'stock' => $request->get('stock'),
        ]);

        $product->save();

        return redirect('/produk')->with('success', 'Produk telah berhasil ditambahkan.');
    }




    // Menampilkan form untuk mengedit produk
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('produk.edit', compact('product'));
    }

    // Mengupdate produk di dalam database
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $product = Product::findOrFail($id);
        $product->category_id = $request->get('category_id');
        $product->name = $request->get('name');
        $product->price = $request->get('price');
        $product->stock = $request->get('stock');
        $product->save();

        return redirect('/produk')->with('success', 'Produk telah berhasil diperbarui.');
    }

    // Menghapus produk dari database
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect('/produk')->with('success', 'Produk telah berhasil dihapus.');
    }
}
