

    
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

                        <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <p class="text-uppercase text-sm">Produk Information</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="user_id" class="form-control-label">Pengguna</label>
                                        <select name="user_id" class="form-control">
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}" {{ $user->id == $product->user_id ? 'selected' : '' }}>{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="form-control-label">Category</label>
                                        <select name="category_id" class="form-control">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address" class="form-control-label">Nama Produk</label>
                                        <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="api_url" class="form-control-label">Harga</label>
                                        <input type="text" name="price" class="form-control" value="{{ $product->price }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="api_url" class="form-control-label">Stok</label>
                                        <input type="text" name="stock" class="form-control" value="{{ $product->stock }}" required>
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