<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Store;

class TokoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Menampilkan semua toko milik user yang sedang login
        $stores = Store::where('user_id', Auth::id())->get();
        return view('toko.index', compact('stores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Menampilkan form untuk membuat toko baru
        return view('toko.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    // Validasi data yang dikirim oleh user
    $request->validate([
        'name' => 'required',
        'address' => 'required',
    ]);

    // Simpan data ke database
    $store = new Store([
        'user_id' => Auth::id(),
        'name' => $request->get('name'),
        'address' => $request->get('address'),
        'api_url' => '', // Atur ke nilai default kosong atau sesuai kebutuhan
    ]);
    $store->save();

    return redirect('/toko')->with('success', 'Toko baru telah berhasil dibuat!');
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
 

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Menampilkan form untuk mengedit toko dengan id tertentu yang dimiliki oleh user yang sedang login
        $store = Store::where('id', $id)
                     ->where('user_id', Auth::id())
                     ->first();

        if (!$store) {
            return redirect('/toko')->with('error', 'Toko tidak ditemukan atau Anda tidak memiliki akses ke toko ini.');
        }

        return view('toko.edit', compact('store'));
    }

/**
 * Update the specified resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
    public function update(Request $request, $id)
    {
        // Validasi data yang dikirim oleh user
        $request->validate([
            'name' => 'required',
            'address' => 'required',
        ]);
    
        // Cari dan perbarui data toko yang sesuai dengan id
        $store = Store::where('id', $id)
                     ->where('user_id', Auth::id())
                     ->first();
    
        if (!$store) {
            return redirect('/toko')->with('error', 'Toko tidak ditemukan atau Anda tidak memiliki akses ke toko ini.');
        }
    
        // Update atribut toko
        $store->name = $request->get('name');
        $store->address = $request->get('address');
        // Tidak mengubah api_url jika tidak ada input dari form
        if ($request->has('api_url')) {
            $store->api_url = $request->get('api_url');
        }
        $store->save();
    
        return redirect('/toko')->with('success', 'Data toko telah berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Hapus toko dengan id tertentu yang dimiliki oleh user yang sedang login
        $store = Store::where('id', $id)
                     ->where('user_id', Auth::id())
                     ->first();

        if (!$store) {
            return redirect('/toko')->with('error', 'Toko tidak ditemukan atau Anda tidak memiliki akses ke toko ini.');
        }

        $store->delete();
        return redirect('/toko')->with('success', 'Toko telah berhasil dihapus!');
    }
}
