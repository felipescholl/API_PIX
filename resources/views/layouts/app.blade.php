<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ config('app.name', 'PIX API') }}</title>
        
        <!-- Styles -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css">
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        
        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        
        @stack('styles')
    </head>
    <body class="bg-gray-100">
        <div class="min-h-screen flex">
            <!-- Sidebar
            <aside class="w-64 bg-gray-800 text-white">
                <div class="p-4">
                    <h2 class="text-2xl font-bold">{{ config('app.name', 'PIX API') }}</h2>
                </div>
                <nav class="mt-4">
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}">
                        <i class="fas fa-home mr-2"></i>Dashboard
                    </a>
                    <a href="{{ route('cobrancas.index') }}" class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('cobrancas.*') ? 'bg-gray-700' : '' }}">
                        <i class="fas fa-file-invoice-dollar mr-2"></i>Cobranças
                    </a>
                    <a href="{{ route('clientes.index') }}" class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('clientes.*') ? 'bg-gray-700' : '' }}">
                        <i class="fas fa-users mr-2"></i>Clientes
                    </a>
                    <a href="{{ route('relatorios.index') }}" class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('relatorios.*') ? 'bg-gray-700' : '' }}">
                        <i class="fas fa-chart-bar mr-2"></i>Relatórios
                    </a>
                    <a href="{{ route('configuracoes.index') }}" class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('configuracoes.*') ? 'bg-gray-700' : '' }}">
                        <i class="fas fa-cog mr-2"></i>Configurações
                    </a>
                </nav>
            </aside> -->

            <!-- Main Content -->
            <div class="flex-1">
                <!-- Header -->
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between items-center">
                            <h1 class="text-2xl font-bold text-gray-900">
                                @yield('header', 'Dashboard')
                            </h1>
                            <div class="flex items-center gap-4">
                                <div class="dropdown dropdown-end">
                                    <button class="btn btn-ghost btn-sm">
                                        <i class="fas fa-user mr-2"></i>{{ Auth::user()->name }}
                                    </button>
                                    <ul class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                                        <li>
                                            <a href="{{ route('profile.edit') }}" class="text-gray-700">
                                                <i class="fas fa-user-cog mr-2"></i>Perfil
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('logout') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="w-full text-left text-gray-700">
                                                    <i class="fas fa-sign-out-alt mr-2"></i>Sair
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main>
                    @if (session('success'))
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                            <div class="alert alert-error">
                                {{ session('error') }}
                            </div>
                        </div>
                    @endif

                    @yield('content')
                </main>
            </div>
        </div>

        @stack('scripts')
    </body>
</html>
