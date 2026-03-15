<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1>Clients</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('clientes.create') }}" class="btn btn-primary mb-3">New Client</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Lastname</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clientes as $cliente)
            <tr>
                <td>{{ $cliente->name }}</td>
                <td>{{ $cliente->lastname }}</td>
                <td>{{ $cliente->email }}</td>
                <td>{{ $cliente->phone }}</td>
                <td>
                    <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>