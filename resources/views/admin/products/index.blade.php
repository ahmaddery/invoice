@include('admin.layouts.sidebar')
@include('admin.layouts.toastr')

<div class="container-fluid py-4">
    <div class="row justify-content-end">
        <div class="col-lg-10">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <h6 class="mb-0">Data Produk Aktif</h6>
                        </div>
                        <div class="col-lg-6 text-lg-end">
                            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle me-2"></i> Tambah Produk
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Produk</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kategori</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Harga</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stok</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Dibuat pada</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    <img src="../assets/img/team-4.jpg" class="avatar avatar-sm me-3" alt="user avatar">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    @if ($product->user)
                                                        <h6 class="mb-0 text-sm">{{ $product->name }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ $product->user->name }}</p>
                                                    @else
                                                        <h6 class="mb-0 text-sm">User Not Found</h6>
                                                        <p class="text-xs text-secondary mb-0">Unknown</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td>
                                            @if ($product->category)
                                                <p class="text-xs font-weight-bold mb-0">{{ $product->category->name }}</p>
                                            @else
                                                <h6 class="mb-0 text-sm">Category Not Found</h6>
                                                <p class="text-xs text-secondary mb-0">Unknown</p>
                                            @endif
                                        </td>
                                        
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-secondary">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        </td>
                                        
                                        <td class="align-middle text-center">
                                            {{ $product->stock }}
                                        </td>
                                        
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $product->created_at->format('Y-m-d H:i:s') }}</span>
                                        </td>
                                        
                                        <td class="align-middle">
                                            <button class="btn btn-primary btn-sm me-2" data-toggle="tooltip" data-placement="top" title="Edit store" onclick="window.location='{{ route('admin.products.edit', $product->id) }}'">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete store" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data produk aktif.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabel untuk menampilkan produk yang telah dihapus secara lunak -->
<div class="container-fluid py-4">
    <div class="row justify-content-end">
        <div class="col-lg-10">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <h6 class="mb-0 text-danger">Data Produk yang Telah Dihapus</h6>
                        </div>
                    </div>
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Produk</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kategori</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Harga</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stok</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Dihapus pada</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($deletedProducts as $deletedProduct)
                                    <tr>
                                        <td class="text-danger">
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    <img src="../assets/img/team-4.jpg" class="avatar avatar-sm me-3" alt="user avatar">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    @if ($deletedProduct->user)
                                                        <h6 class="mb-0 text-sm">{{ $deletedProduct->name }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ $deletedProduct->user->name }}</p>
                                                    @else
                                                        <h6 class="mb-0 text-sm">User Not Found</h6>
                                                        <p class="text-xs text-secondary mb-0">Unknown</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td>
                                            @if ($deletedProduct->category)
                                                <p class="text-xs font-weight-bold mb-0">{{ $deletedProduct->category->name }}</p>
                                            @else
                                                <h6 class="mb-0 text-sm">Category Not Found</h6>
                                                <p class="text-xs text-secondary mb-0">Unknown</p>
                                            @endif
                                        </td>
                                        
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-secondary">Rp {{ number_format($deletedProduct->price, 0, ',', '.') }}</span>
                                        </td>
                                        
                                        <td class="align-middle text-center">
                                            {{ $deletedProduct->stock }}
                                        </td>
                                        
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $deletedProduct->deleted_at->format('Y-m-d H:i:s') }}</span>
                                        </td>
                                        
                                        <td class="align-middle">
                                            <form action="{{ route('admin.products.restore', $deletedProduct->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-link btn-sm text-success" onclick="return confirm('Apakah Anda yakin ingin mengembalikan produk ini?')">Kembalikan</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data produk yang telah dihapus.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
