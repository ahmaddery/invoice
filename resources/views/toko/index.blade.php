@include('layouts.sidebar')
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
                            @if($stores->isEmpty())
                                <a href="{{ route('toko.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus-circle me-2"></i> Tambah toko
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Nama</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stores as $store)
                                <tr>
                                    <td>{{ $store->name }}</td>
                                    <td>{{ $store->address }}</td>
                                    <td>
                                        <a href="{{ route('toko.edit', $store->id) }}" class="btn btn-info btn-sm">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
