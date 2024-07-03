<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    /**
     * Display a listing of the stores.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $stores = Store::all();
        $trashedStores = Store::onlyTrashed()->get();
    
        return view('admin.stores.index', compact('stores', 'trashedStores'));
    }
    
    /**
     * Show the form for creating a new store.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Get all users to populate the dropdown
        $users = User::pluck('name', 'id');
        
        return view('admin.stores.create', compact('users'));
    }

    /**
     * Store a newly created store in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi tambahan: satu user_id hanya boleh memiliki satu data toko
        $validator = Validator::make($request->all(), [
            'user_id' => [
                'required',
                'exists:users,id',
                // Rule unik untuk memastikan hanya satu data toko per user_id
                \Illuminate\Validation\Rule::unique('stores')->where(function ($query) use ($request) {
                    return $query->where('user_id', $request->input('user_id'));
                })->ignore($request->id),
            ],
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
        ], [
            'user_id.unique' => 'User sudah memiliki data toko. Hanya satu data toko yang diizinkan per user.',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Generate API URL
        $api_url = $this->generateRandomApiUrl();
    
        Store::create([
            'user_id' => $request->input('user_id'),
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'api_url' => $api_url,
        ]);
    
        return redirect()->route('admin.stores')->with('success', 'Store created successfully.');
    }

    /**
     * Show the form for editing the specified store.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $store = Store::findOrFail($id);
        $users = User::pluck('name', 'id');
        
        return view('admin.stores.edit', compact('store', 'users'));
    }

    /**
     * Update the specified store in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $store = Store::findOrFail($id);
    
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            // 'api_url' => 'required|url|max:255', // Di-comment karena api_url tidak perlu diubah
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $store->update([
            'user_id' => $request->input('user_id'),
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            // 'api_url' => $request->input('api_url'), // Di-comment karena api_url tidak perlu diubah
        ]);
    
        return redirect()->route('admin.stores')->with('success', 'Store updated successfully.');
    }

    /**
     * Soft delete the specified store.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function softDelete($id)
    {
        $store = Store::findOrFail($id);
        $store->delete();

        return redirect()->route('admin.stores')->with('success', 'Store soft deleted successfully.');
    }

    /**
     * Display a listing of the soft deleted stores.
     *
     * @return \Illuminate\View\View
     */
    public function trashed()
    {
        $stores = Store::onlyTrashed()->get();
        return view('admin.stores.trashed', compact('stores'));
    }

    /**
     * Restore the specified soft deleted store.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        $store = Store::onlyTrashed()->findOrFail($id);
        $store->restore();

        return redirect()->route('admin.stores')->with('success', 'Store restored successfully.');
    }

    /**
     * Permanently delete the specified store.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $store = Store::onlyTrashed()->findOrFail($id);
        $store->forceDelete();

        return redirect()->route('admin.stores')->with('success', 'Store permanently deleted successfully.');
    }

    /**
     * Generate a random API URL.
     *
     * @return string
     */
    protected function generateRandomApiUrl()
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $url = 'https://api.example.com/';
        for ($i = 0; $i < 32; $i++) {
            $url .= $chars[random_int(0, strlen($chars) - 1)];
        }
        return $url;
    }
}
