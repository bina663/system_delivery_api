<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/brands.min.css" crossorigin="anonymous"/>
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <title>Ki Burguer | @yield('title')</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
        <a class="navbar-brand fs-2" href="#">
            <img 
            src="{{  asset('logo.png') }}" 
            id="logo" 
            alt="Ki-Burguer"
            >
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav fs-5 ms-auto">
            <li class="nav-item">
                <a class="nav-link p-2 active" aria-current="page" href="#">Tudo</a>
            </li>
            <li class="nav-item">
                <a class="nav-link p-2" href="#">Hambuguers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link p-2" href="#">Bebidas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link p-2" href="#">Sobremesas</a>
            </li>
            </ul>
        </div>
        </div>
    </nav>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>