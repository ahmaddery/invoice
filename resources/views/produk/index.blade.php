@include('layouts.sidebar')
@include('admin.layouts.toastr')

<div class="container-fluid py-4">
    <div class="row justify-content-end">
        <div class="col-lg-10">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-6">
                            <h6 class="mb-0">Data Produk</h6>
                        </div>
                        <div class="col-lg-6 col-6 text-end">
                            <a href="{{ route('produk.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle me-2"></i> Tambah Produk
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-lg-9">
                            <form action="{{ route('produk.index') }}" method="GET" class="form-inline">
                                <div class="row g-2 align-items-center">
                                    <div class="col-lg-3 col-md-4 col-sm-12 mb-2">
                                        <label for="per_page" class="form-label me-2">Tampilkan per halaman:</label>
                                        <select name="per_page" id="per_page" class="form-select" onchange="this.form.submit()">
                                            @php $perPageOptions = [5, 10, 15, 20]; @endphp
                                            @foreach($perPageOptions as $option)
                                                <option value="{{ $option }}" {{ request('per_page', 10) == $option ? 'selected' : '' }}>{{ $option }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                                        <input type="text" name="search" class="form-control" placeholder="Cari produk..." value="{{ request('search') }}">
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-12 mb-2">
                                        <select name="category" id="category" class="form-select">
                                            <option value="">Semua Kategori</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tabel Produk -->
                    <div class="table-responsive">
                        <table id="produk-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->category->name }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->stock }}</td>
                                        <td>
                                            <a href="{{ route('produk.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('produk.destroy', $product->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="row">
                        <div class="col-lg-12">
                            {{ $products->appends(request()->input())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#produk-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ route('produk.index') }}",
                "type": "GET",
                "data": function(d) {
                    d.per_page = $('#per_page').val();
                    d.search = $('input[name=search]').val();
                    d.category = $('#category').val();
                }
            },
            "columns": [
                { "data": "DT_RowIndex", "orderable": false, "searchable": false },
                { "data": "name" },
                { "data": "category.name" },
                { "data": "price" },
                { "data": "stock" },
                { "data": "actions", "orderable": false, "searchable": false },
            ],
            "order": [[1, 'asc']], // Urutan awal, misalnya berdasarkan nama (kolom 1)
            "language": {
                "paginate": {
                    "previous": "<i class='fas fa-chevron-left'></i>",
                    "next": "<i class='fas fa-chevron-right'></i>"
                }
            }
        });
    });
</script>
@endpush
