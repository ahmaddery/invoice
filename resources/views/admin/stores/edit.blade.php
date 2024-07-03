
    @include('admin.layouts.sidebar')
    @include('admin.layouts.toastr')

    <div class="container-fluid py-4">
        <div class="row justify-content-end">
            <div class="col-lg-10">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <p class="mb-0">Edit Data Toko</p>
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

                        <form action="{{ route('admin.stores.update', $store->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <p class="text-uppercase text-sm">User Information</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="user_id" class="form-control-label">Username</label>
                                        <select id="user_id" name="user_id" class="form-control">
                                            @foreach ($users as $key => $value)
                                                <option value="{{ $key }}" {{ $key == $store->user_id ? 'selected' : '' }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="form-control-label">Nama Toko</label>
                                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $store->name) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address" class="form-control-label">Alamat Toko</label>
                                        <textarea id="address" name="address" class="form-control">{{ old('address', $store->address) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="api_url" class="form-control-label">API</label>
                                        <div class="input-group">
                                            <input type="text" id="api_url" name="api_url" class="form-control" value="{{ old('api_url', $store->api_url) }}" readonly>
                                            <button type="button" class="btn btn-secondary" onclick="generateRandomApiUrl()">Generate</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Store</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function generateRandomApiUrl() {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            let url = 'https://api.example.com/';
            for (let i = 0; i < 32; i++) {
                url += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            document.getElementById('api_url').value = url;
        }
    </script>

