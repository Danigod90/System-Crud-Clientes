<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1>Client Details</h1>

    <div class="card">
        <div class="card-body">
            <p><strong>Name:</strong> {{ $cliente->name }}</p>
            <p><strong>Lastname:</strong> {{ $cliente->lastname }}</p>
            <p><strong>Email:</strong> {{ $cliente->email }}</p>
            <p><strong>Phone:</strong> {{ $cliente->phone }}</p>
            <p><strong>Address:</strong> {{ $cliente->address }}</p>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Back</a>
        <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning">Edit</a>
        <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" style="display:inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
        </form>
    </div>
</div>
</body>
</html>