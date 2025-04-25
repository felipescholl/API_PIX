@extends('layouts.app')

@section('content')

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="justify-between flex items-center mb-6">
                <h1 class="text-2xl font-bold mb-4">Detalhes da Cobrança PIX</h1>
                <div class="space-x-3">
                    {{-- Botão para voltar para dashboard --}}
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">
                        Dashboard
                    </a>
                    {{-- botão voltar atuando como clicar um voltar no navegador --}}
                    <a href="javascript:history.back()" class="btn btn-tertiary btn-sm">
                        Voltar
                    </a>
                </div>
            </div>
            <div id="content" class="space-y-4">
                @if(isset($error))
                    <div class="bg-red-50 text-red-700 p-4 rounded">
                        <h2 class="text-xl font-semibold mb-2">Erro</h2>
                        <p>{{ $error }}</p>
                    </div>
                @else
                    <div class="animate-pulse" id="loading">
                        <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                        <div class="space-y-3 mt-4">
                            <div class="h-4 bg-gray-200 rounded"></div>
                            <div class="h-4 bg-gray-200 rounded"></div>
                            <div class="h-4 bg-gray-200 rounded"></div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if(!isset($error))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const data = @json($data);
            
            try {
                displayData(data);
            } catch (error) {
                showError('Erro ao processar dados: ' + error.message);
            }
        });

        function displayData(data) {
            const content = document.getElementById('content');
            document.getElementById('loading').style.display = 'none';

            // Criar uma classe CSS baseada na validade
            const validadeClass = data.validade?.isValida ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700';
            
            content.innerHTML = `
                <div class="space-y-4">
                    <!-- Status da Validade -->
                    <div class="p-4 rounded-lg ${validadeClass} mb-6">
                        <h2 class="text-xl font-semibold mb-2">Status da Cobrança</h2>
                        <p class="mb-2">${data.validade?.mensagem || 'Cobrança válida'}</p>
                        <div class="text-sm">
                            <p>Data de Vencimento: ${data.validade?.dataVencimentoFormatada}</p>
                            <p>Validade após vencimento: ${data.validade?.validadeAposVencimento}</p>
                        </div>
                    </div>

                    <!-- Informações da Cobrança -->
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h2 class="text-xl font-semibold mb-4">Detalhes da Cobrança</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Informações Básicas -->
                            <div class="space-y-3">
                                <div>
                                    <span class="font-medium">Status:</span>
                                    <span class="ml-2">${data.status}</span>
                                </div>
                                <div>
                                    <span class="font-medium">TXID:</span>
                                    <span class="ml-2">${data.txid}</span>
                                </div>
                                <div>
                                    <span class="font-medium">Valor:</span>
                                    <span class="ml-2">R$ ${data.valor?.original || '0,00'}</span>
                                </div>
                                <!-- Multa e Juros (se existirem) -->
                                    <div>
                                        <span class="font-medium">Multa:</span>
                                        <span class="ml-2"> ${data.valor?.multa} % </span>
                                    </div>
                                    <div>
                                        <span class="font-medium">Juros:</span>
                                        <span class="ml-2"> ${data.valor?.juros} % ao mês</span>
                                    </div>
                                <div>
                                    <span class="font-medium">Criação:</span>
                                    <span class="ml-2">${formatDate(data.calendario?.criacao)}</span>
                                </div>
                                <div>
                                    <span class="font-medium">Vencimento:</span>
                                    <span class="ml-2">${(data.calendario?.dataDeVencimento)}</span>
                                </div>
                            </div>

                            <!-- Informações do Devedor -->
                            <div class="space-y-3">
                                <h3 class="font-semibold">Dados do Pagador</h3>
                                <div>
                                    <span class="font-medium">Nome:</span>
                                    <span class="ml-2">${data.devedor?.nome || '-'}</span>
                                </div>
                                <div>
                                    <span class="font-medium">CNPJ:</span>
                                    <span class="ml-2">${formatCnpj(data.devedor?.cnpj) || '-'}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Informações do Recebedor -->
                        <div class="mt-6">
                            <h3 class="font-semibold mb-3">Dados do Recebedor</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <span class="font-medium">Nome:</span>
                                    <span class="ml-2">${data.recebedor?.nome || '-'}</span>
                                </div>
                                <div>
                                    <span class="font-medium">CNPJ:</span>
                                    <span class="ml-2">${formatCnpj(data.recebedor?.cnpj) || '-'}</span>
                                </div>
                                <div>
                                    <span class="font-medium">Cidade:</span>
                                    <span class="ml-2">${data.recebedor?.cidade || '-'}</span>
                                </div>
                                <div>
                                    <span class="font-medium">UF:</span>
                                    <span class="ml-2">${data.recebedor?.uf || '-'}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Informações de Localização -->
                        ${data.loc ? `
                        <div class="mt-6">
                            <h3 class="font-semibold mb-3">Dados de Localização</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <span class="font-medium">ID:</span>
                                    <span class="ml-2">${data.loc.id || '-'}</span>
                                </div>
                                <div>
                                    <span class="font-medium">Tipo:</span>
                                    <span class="ml-2">${data.loc.tipoCob || '-'}</span>
                                </div>
                                <div>
                                    <span class="font-medium">Location:</span>
                                    <span class="ml-2">${data.loc.location || '-'}</span>
                                </div>
                                <div>
                                    <span class="font-medium">Criação:</span>
                                    <span class="ml-2">${formatDate(data.loc.criacao) || '-'}</span>
                                </div>
                            </div>
                        </div>
                        ` : ''}
                    </div>
                </div>
            `;
        }

        function showError(message) {
            const content = document.getElementById('content');
            document.getElementById('loading').style.display = 'none';
            content.innerHTML = `
                <div class="bg-red-50 text-red-700 p-4 rounded">
                    <h2 class="text-xl font-semibold mb-2">Erro</h2>
                    <p>${message}</p>
                </div>
            `;
        }

        function formatDate(dateString) {
            if (!dateString) return '-';
            return new Date(dateString).toLocaleString('pt-BR');
        }

        function formatCnpj(cnpj) {
            if (!cnpj) return '-';
            return cnpj.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/, "$1.$2.$3/$4-$5");
        }
    </script>
    @endif
@endsection