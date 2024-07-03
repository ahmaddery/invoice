@include('admin.layouts.sidebar')
@include('admin.layouts.toastr')

<div class="container-fluid py-4">
    <div class="row justify-content-end">
        <div class="col-lg-10">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <h6 class="mb-0">Data Toko</h6>
                        </div>
                        <div class="col-lg-6 text-lg-end">
                            <a href="{{ route('admin.stores.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle me-2"></i> Tambah toko
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Toko</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Api</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Dibuat pada</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($stores as $store)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    <img src="../assets/img/team-4.jpg" class="avatar avatar-sm me-3" alt="user avatar">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $store->user->name }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $store->user->email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $store->name }}</p>
                                            <p class="text-xs text-secondary mb-0">{{ $store->address }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-secondary">{{ $store->api_url }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $store->created_at->format('Y-m-d H:i:s') }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <button class="btn btn-primary btn-sm me-2" data-toggle="tooltip" data-placement="top" title="Edit store" onclick="window.location='{{ route('admin.stores.edit', $store->id) }}'">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <form action="{{ route('admin.stores.soft-delete', $store->id) }}" method="GET" style="display:inline;">
                                                @csrf
                                                <button class="btn btn-danger btn-sm me-2" data-toggle="tooltip" data-placement="top" title="Delete store">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No stores found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Soft Deleted Stores -->
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <h6 class="mb-0">Soft Deleted Stores</h6>
                        </div>
                    </div>
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Toko</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Api</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Dihapus pada</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($trashedStores as $store)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    <img src="../assets/img/team-4.jpg" class="avatar avatar-sm me-3" alt="user avatar">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $store->user->name }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $store->user->email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $store->name }}</p>
                                            <p class="text-xs text-secondary mb-0">{{ $store->address }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-secondary">{{ $store->api_url }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $store->deleted_at->format('Y-m-d H:i:s') }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <form action="{{ route('admin.stores.restore', $store->id) }}" method="GET" style="display:inline;">
                                                @csrf
                                                <button class="btn btn-success btn-sm me-2" data-toggle="tooltip" data-placement="top" title="Restore store">
                                                    <i class="fas fa-undo"></i> Restore
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.stores.delete', $store->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm me-2" data-toggle="tooltip" data-placement="top" title="Permanently delete store">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No soft deleted stores found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Soft Deleted Stores -->

        </div>
    </div>
</div>
