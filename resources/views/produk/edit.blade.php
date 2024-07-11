@include('layouts.sidebar')
@include('layouts.toastr')

<div class="container-fluid py-4">
    <div class="row justify-content-end">
        <div class="col-lg-10">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Edit Data Produk</p>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('produk.update', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <p class="text-uppercase text-sm">Produk Information</p>
                        <div class="row">
                           
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category_id" class="form-control-label">Kategori</label>
                                    <select name="category_id" class="form-control">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-control-label">Nama Produk</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price_display" class="form-control-label">Harga (RP)</label>
                                    <input type="text" class="form-control" id="price_display" value="{{ number_format($product->price, 0, ',', '.') }}" required onkeyup="formatRupiah(this)">
                                    <input type="hidden" id="price" name="price" value="{{ $product->price }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stock" class="form-control-label">Stok</label>
                                    <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" required>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update product</button>
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



