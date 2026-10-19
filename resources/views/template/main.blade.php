<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @yield('styles')
    <link rel="icon" type="image/png" href="{{ asset('storage/' . ($globalBranch->image ?? '')) }}">
    <title>{{ $globalBranch->name ?? 'Não cadastrado' }} | @yield('title')</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg shadow-sm py-2">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center gap-2" href="#">
                <img
                    src="{{ asset('storage/' . ($globalBranch->image ?? '')) }}"
                    id="logo"
                    alt="{{ $globalBranch->name ?? 'Não cadastrado' }}"
                    class="d-inline-block align-text-top rounded-circle"
                >
                <span class="navbar-title">{{ $globalBranch->name ?? 'Não cadastrado' }}</span>
            </a>
        </div>
    </nav>
    <div class="container">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>