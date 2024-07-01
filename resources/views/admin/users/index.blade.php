@include('admin.layouts.sidebar')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if (session('success'))
<script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 6000,
        timerProgressBar: true,
    });
</script>
@endif
@if (session('error'))
<script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'error',
        title: '{{ session('error') }}',
        showConfirmButton: false,
        timer: 6000,
        timerProgressBar: true,
    });
</script>
@endif

<div class="container-fluid py-4">
  <div class="row justify-content-end">
    <div class="col-lg-10">
      <div class="card mb-4">
        
        <div class="card-header pb-0">
          <div class="row align-items-center">
            <div class="col-lg-6">
              <h6 class="mb-0">Data pengguna</h6>
            </div>
            <div class="col-lg-6 text-lg-end">
              <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
                <i class="fas fa-plus-circle me-2"></i> Tambah Pengguna
              </button>
            </div>
          </div>
        </div>

        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Usertype</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Dibuat Pada</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                  <th class="text-secondary opacity-7"></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($activeUsers as $user)
                <tr>
                  <td>
                    <div class="d-flex px-2 py-1">
                      <div>
                        <img src="../assets/img/team-4.jpg" class="avatar avatar-sm me-3" alt="user avatar">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm">{{ $user->name }}</h6>
                        <p class="text-xs text-secondary mb-0">{{ $user->email }}</p>
                      </div>
                    </div>
                  </td>
                  <td>
                    <p class="text-xs font-weight-bold mb-0">{{ $user->email }}</p>
                    <p class="text-xs text-secondary mb-0">{{ $user->usertype }}</p>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <span class="badge badge-sm bg-gradient-secondary">{{ $user->usertype }}</span>
                  </td>
                  <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">{{ $user->created_at->format('d/m/Y') }}</span>
                  </td>
                  <td class="align-middle">
                    <button class="btn btn-info btn-sm me-2" data-toggle="tooltip" data-placement="top" title="Detail user" onclick="window.location='{{ route('admin.users.show', $user->id) }}'">
                      <i class="fas fa-eye"></i> Detail
                    </button>
                    <button class="btn btn-primary btn-sm me-2" data-toggle="tooltip" data-placement="top" title="Edit user" onclick="window.location='{{ route('admin.users.edit', $user->id) }}'">
                      <i class="fas fa-edit"></i> Edit
                    </button>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline-block;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete user" onclick="return confirm('Are you sure?')">
                        <i class="fas fa-trash"></i> Delete
                      </button>
                    </form>
                  </td>
                </tr>
                @endforeach

                {{-- Deleted Users --}}
                <tr>
                  <td colspan="6">
                    <h4 class="mt-4 mb-3">Pengguna Terrhapus</h4>
                    <table class="table align-items-center mb-0">
                      <thead>
                        <tr>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Usertype</th>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Dihapus Pada</th>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                          <th class="text-secondary opacity-7"></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($deletedUsers as $user)
                        <tr>
                          <td>
                            <div class="d-flex px-2 py-1">
                              <div>
                                <img src="../assets/img/team-4.jpg" class="avatar avatar-sm me-3" alt="user avatar">
                              </div>
                              <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">{{ $user->name }}</h6>
                                <p class="text-xs text-secondary mb-0">{{ $user->email }}</p>
                              </div>
                            </div>
                          </td>
                          <td>
                            <p class="text-xs font-weight-bold mb-0">{{ $user->email }}</p>
                            <p class="text-xs text-secondary mb-0">{{ $user->usertype }}</p>
                          </td>
                          
                          <td class="align-middle text-center text-sm">
                            <span class="badge badge-sm bg-gradient-secondary">{{ $user->usertype }}</span>
                          </td>
                          <td class="align-middle text-center">
                            <span class="text-secondary text-xs font-weight-bold">{{ $user->deleted_at->format('d/m/Y') }}</span>
                          </td>
                          <td class="align-middle">
                            <form action="{{ route('admin.users.restore', $user->id) }}" method="POST" style="display: inline-block;">
                              @csrf
                              @method('PUT')
                              <button type="submit" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Restore user" onclick="return confirm('Are you sure?')">Kembalikan</button>
                            </form>
                            <form action="{{ route('admin.users.permanently-delete', $user->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Permanently Delete User" onclick="return confirm('Are you sure?')">Hapus Permanen</button>
                            </form>
                            
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Create User Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createUserModalLabel">Create New User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="form-group">
              <label for="name">Name <i class="fas fa-user"></i></label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}">
            </div>
            <div class="form-group">
              <label for="email">Email <i class="fas fa-envelope"></i></label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}">
            </div>
            <div class="form-group">
              <label for="password">Password <i class="fas fa-lock"></i></label>
                <input type="password" id="password" name="password" class="form-control">
            </div>
            <div class="form-group">
              <label for="password_confirmation">Confirm Password <i class="fas fa-lock"></i></label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
            </div>
            <div class="form-group">
              <label for="usertype">User Type <i class="fas fa-user-tag"></i></label>
              <select name="usertype" id="usertype" class="form-control">
                  <option value="user" {{ old('usertype') == 'user' ? 'selected' : '' }}>User</option>
                  <option value="admin" {{ old('usertype') == 'admin' ? 'selected' : '' }}>Admin</option>
              </select>
          </div>          
            <button type="submit" class="btn btn-primary">Create User</button>
        </form>
      </div>
    </div>
  </div>
</div>
