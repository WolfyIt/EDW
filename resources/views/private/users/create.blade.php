<!-- resources/views/private/users/create.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Create New User</h1>

        <!-- Displaying validation errors -->
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form for creating a new user -->
        <form action="{{ route('private.users.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required value="{{ old('email') }}">
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="">Select a Role</option>
                    <option value="sales" {{ old('role') == 'sales' ? 'selected' : '' }}>Sales</option>
                    <option value="purchasing" {{ old('role') == 'purchasing' ? 'selected' : '' }}>Purchasing</option>
                    <option value="warehouse" {{ old('role') == 'warehouse' ? 'selected' : '' }}>Warehouse</option>
                    <option value="route" {{ old('role') == 'route' ? 'selected' : '' }}>Route</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Create User</button>
        </form>

        <a href="{{ route('private.users.index') }}" class="btn btn-secondary mt-3">Back to User List</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
