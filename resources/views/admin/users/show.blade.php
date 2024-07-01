
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">User Details</h3>
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>User Type:</strong> {{ $user->usertype }}</p>
            <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Back</a>
        </div>
    </div>

