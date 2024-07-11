<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use DataTables;


class ProdukController extends Controller
{
    // Menampilkan semua produk
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10); // Jumlah default per halaman: 10
    
        $query = Product::where('user_id', Auth::id());
    
        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }
    
        // Filter berdasarkan kategori
        if ($request->filled('category')) {
            $query->whereHas('category', function($query) use ($request) {
                $query->where('id', $request->input('category'));
            });
        }
    
        // Sorting
        $query->orderBy('name', 'asc');
    
        // Ambil kategori untuk dropdown filter
        $categories = Category::all(); // Ubah sesuai dengan model dan kolom yang sesuai dengan struktur aplikasi Anda
    
        // Ambil produk dengan pagination
        $products = $query->paginate($perPage);
    
        return view('produk.index', compact('products', 'categories'));
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
        $categories = Category::all(); // Fetch all categories
        return view('produk.edit', compact('product', 'categories'));
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
