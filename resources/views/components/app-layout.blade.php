<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PIX API') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet">
    @livewireStyles

    <!-- Scripts -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        function verificarCobranca(txid) {
            // Lógica para verificar a cobrança
            alert('Verificando cobrança: ' + txid);
        }

        function cancelarCobranca(txid) {
            if (confirm('Tem certeza que deseja cancelar a cobrança?')) {
                // Lógica para cancelar a cobrança
                alert('Cancelando cobrança: ' + txid);
            }
        }
    </script>
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-base-200 shadow-lg">
            <div class="flex items-center justify-center h-16 bg-primary">
                <h1 class="text-xl font-bold text-white">PIX API</h1>
            </div>
            <nav class="mt-5">
                <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary hover:text-white">
                    <span class="mx-3">Dashboard</span>
                </a>
                <a href="{{ route('cobrancas.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary hover:text-white">
                    <span class="mx-3">Cobranças</span>
                </a>
                <a href="{{ route('relatorios.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary hover:text-white">
                    <span class="mx-3">Relatórios</span>
                </a>
                <a href="{{ route('configuracoes.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-primary hover:text-white">
                    <span class="mx-3">Configurações</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="ml-64">
            <header class="bg-white shadow">
                <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    {{ $header ?? '' }}
                </div>
            </header>

            <div class="py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>

    @livewireScripts
</body>
</html>