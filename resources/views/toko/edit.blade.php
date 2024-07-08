<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Toko</div>

                <div class="card-body">
                    <form action="{{ route('toko.update', $store->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $store->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $store->address) }}" required>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                     <!--   <div class="form-group">
                            <label for="api_url">API URL</label>
                            <input type="text" class="form-control" id="api_url" name="api_url" value="{{ old('api_url', $store->api_url) }}" placeholder="Kosongkan jika tidak ada">
                        </div>   -->
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="{{ route('toko.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
