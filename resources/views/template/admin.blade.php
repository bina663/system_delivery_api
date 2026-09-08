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
    <link href="https://fonts.googleapis.com/css2?family=Robohref:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/header.css') }}">
    @yield('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <title>Ki Burguer | @yield('title')</title>
</head>
<body>
    <header>
    <aside class="sidebar bg-dark text-light" style="width: 260px; min-height: 100vh;">
        <div class="p-3">
            <h5 class="text-white mb-4">{{ $storeName }}</h5>

            <ul class="nav flex-column">

                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link text-light {{ request()->routeIs('admin.dashboard') ? 'active fw-bold' : '' }}">
                        <i class="fa-solid fa-gauge me-2"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.orders.painel') }}" class="nav-link text-light {{ request()->routeIs('admin.orders.*') ? 'active fw-bold' : '' }}">
                        <i class="fa-solid fa-receipt me-2"></i> Pedidos
                    </a>
                </li>

                {{-- Submenu: Produtos --}}
                <li class="nav-item">
                    <a href="#produtosSubmenu"
                    class="nav-link text-light d-flex justify-content-between align-items-center {{ request()->routeIs('admin.products.*') || request()->routeIs('admin.category.*') || request()->routeIs('admin.additionals.*') ? 'active fw-bold' : '' }}"
                    data-bs-toggle="collapse"
                    role="button"
                    aria-expanded="{{ request()->routeIs('admin.products.*') || request()->routeIs('admin.category.*') || request()->routeIs('admin.additionals.*') ? 'true' : 'false' }}">
                        <span><i class="fa-solid fa-burger me-2"></i> Produtos</span>
                        <i class="fa-solid fa-chevron-down small"></i>
                    </a>

                    <div class="collapse {{ request()->routeIs('admin.products.*') || request()->routeIs('admin.category.*') || request()->routeIs('admin.additionals.*') ? 'show' : '' }}" id="produtosSubmenu">
                        <ul class="nav flex-column ms-3 mt-1">
                            <li class="nav-item">
                                <a href="{{ route('admin.category.painel') }}" class="nav-link text-light {{ request()->routeIs('admin.category.*') ? 'active fw-bold' : '' }}">
                                    <i class="fa-solid fa-tags me-2"></i> Categorias
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.products.painel') }}" class="nav-link text-light {{ request()->routeIs('admin.products.*') ? 'active fw-bold' : '' }}">
                                    <i class="fa-solid fa-box me-2"></i> Produtos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.additionals.painel') }}" class="nav-link text-light {{ request()->routeIs('admin.additionals.*') ? 'active fw-bold' : '' }}">
                                    <i class="fa-solid fa-plus me-2"></i> Adicionais
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- Submenu: Configurações --}}
                <li class="nav-item">
                    <a href="#configSubmenu"
                    class="nav-link text-light d-flex justify-content-between align-items-center {{ request()->routeIs('admin.store.*') || request()->routeIs('admin.settings.*') ? 'active fw-bold' : '' }}"
                    data-bs-toggle="collapse"
                    role="button"
                    aria-expanded="{{ request()->routeIs('admin.store.*') || request()->routeIs('admin.settings.*') ? 'true' : 'false' }}">
                        <span><i class="fa-solid fa-gear me-2"></i> Configurações</span>
                        <i class="fa-solid fa-chevron-down small"></i>
                    </a>

                    <div class="collapse {{ request()->routeIs('admin.store.*') || request()->routeIs('admin.settings.*') ? 'show' : '' }}" id="configSubmenu">
                        <ul class="nav flex-column ms-3 mt-1">
                            <li class="nav-item">
                                <a href="{{ route('admin.store.painel') }}" class="nav-link text-light {{ request()->routeIs('admin.store.*') ? 'active fw-bold' : '' }}">
                                    <i class="fa-solid fa-store me-2"></i> Loja
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.settings.painel') }}" class="nav-link text-light {{ request()->routeIs('admin.settings.*') ? 'active fw-bold' : '' }}">
                                    <i class="fa-solid fa-sliders me-2"></i> Configurações Gerais
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>
        </div>
    </aside>
    </header>
    <div class="container">
        @yield('content')
    </div>
    @yield('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>