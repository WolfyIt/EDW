<!-- resources/views/private/users/show.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>User Profile: {{ $user->name }}</h1>
        
        <table class="table table-bordered">
            <tr>
                <th>Name</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>Role</th>
                <td>{{ $user->role->name }}</td> <!-- Assuming the role relationship is set up -->
            </tr>
            <tr>
                <th>Created At</th>
                <td>{{ $user->created_at }}</td>
            </tr>
            <tr>
                <th>Updated At</th>
                <td>{{ $user->updated_at }}</td>
            </tr>
        </table>

        <a href="{{ route('private.users.index') }}" class="btn btn-secondary">Back to Users List</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
