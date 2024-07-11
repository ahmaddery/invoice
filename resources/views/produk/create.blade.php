@include('layouts.sidebar')
@include('layouts.toastr')

<div class="container-fluid py-4">
    <div class="row justify-content-end">
        <div class="col-lg-10">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Tambah Data Produk</p>
                    </div>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('produk.store') }}" method="POST">
                        @csrf
                        <p class="text-uppercase text-sm">Informasi Produk</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category_id" class="form-control-label">Kategori</label>
                                    <select class="form-control" id="category_id" name="category_id" required>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-control-label">Nama Produk</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price_display" class="form-control-label">Harga (RP)</label>
                                    <input type="text" class="form-control" id="price_display" required onkeyup="formatRupiah(this)">
                                    <input type="hidden" id="price" name="price" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stock" class="form-control-label">Stok</label>
                                    <input type="number" class="form-control" id="stock" name="stock" required>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function formatRupiah(element) {
    var value = element.value.replace(/[^,\d]/g, '').toString();
    var split = value.split(',');
    var sisa = split[0].length % 3;
    var rupiah = split[0].substr(0, sisa);
    var ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        var separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
    element.value = 'RP ' + rupiah;

    // Set the hidden input value to the numeric value
    document.getElementById('price').value = value.replace(/\./g, '');
}
</script>
