@extends('layouts.app')

@section('content')
<div class="py-2">
    <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
        <!-- Filtros -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-2">
            <div class="py-3 px-6">
                <form action="{{ route('dashboard') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Filtros de Data -->
                    <div>
                        {{-- <?php dd($cobrancas); ?> --}}
                        <label class="block text-sm font-medium text-gray-800">Tipo de Data</label>
                        <select name="tipo_data" class="mt-1 block w-full bg-gray-200 text-gray-800 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="emissao" {{ request('tipo_data') === 'emissao' ? 'selected' : '' }}>Data de Emissão</option>
                            <option value="vencimento" {{ request('tipo_data') === 'vencimento' ? 'selected' : '' }}>Data de Vencimento</option>
                            <option value="quitacao" {{ request('tipo_data') === 'quitacao' ? 'selected' : '' }}>Data de Quitação</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-800">Data Inicial</label>
                        <input type="date" name="data_inicial" value="{{ request('data_inicial') }}" class="mt-1 block w-full bg-gray-200 text-gray-800 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-800">Data Final</label>
                        <input type="date" name="data_final" value="{{ request('data_final') }}" class="mt-1 block w-full bg-gray-200 text-gray-800 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-800">Status</label>
                        <select name="status" class="mt-1 block w-full bg-gray-200 text-gray-800 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Todos</option>
                            <option value="ATIVO" {{ request('status') === 'ATIVO' ? 'selected' : '' }}>Aguardando Pagamento</option>
                            <option value="PAGO" {{ request('status') === 'PAGO' ? 'selected' : '' }}>Pago</option>
                            <option value="CANCELADO" {{ request('status') === 'CANCELADO' ? 'selected' : '' }}>Cancelada</option>
                            <option value="REMOVIDO_PSP" {{ request('status') === 'REMOVIDO_PSP' ? 'selected' : '' }}>Cancelada Banco</option>
                        </select>
                    </div>

                    <!-- Filtros de Título e Sapiens -->
                    <div>
                        <label class="block text-sm font-medium text-gray-800">Número do Título</label>
                        <input type="text" name="titulo_numTit" value="{{ request('titulo_numTit') }}" placeholder="Digite o número do título" class="mt-1 block w-full bg-gray-200 text-gray-800 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-800">Status Sapiens</label>
                        <select name="status_senior" class="mt-1 block w-full bg-gray-200 text-gray-800 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Todos</option>
                            <option value="REGISTRADO" {{ request('status_senior') === 'REGISTRADO' ? 'selected' : '' }}>Registrado</option>
                            <option value="ERRO" {{ request('status_senior') === 'ERRO' ? 'selected' : '' }}>Não Registrado</option>
                        </select>
                    </div>

                    <!-- Filtros de Cliente -->
                    <div>
                        <label class="block text-sm font-medium text-gray-800">CPF/CNPJ</label>
                        <input type="text" name="cgcCpf" value="{{ request('cgcCpf') }}" placeholder="Digite o CPF ou CNPJ" class="mt-1 block w-full bg-gray-200 text-gray-800 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-800">Nome do Cliente</label>
                        <input type="text" name="nomCli" value="{{ request('nomCli') }}" placeholder="Digite o nome do cliente" class="mt-1 block w-full bg-gray-200 text-gray-800 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <!-- Botões -->
                    <div class="md:col-span-4 flex justify-end space-x-2">
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm hover:bg-gray-200">
                            <i class="fas fa-times mr-2"></i>Limpar Filtros
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm hover:bg-indigo-600">
                            <i class="fas fa-filter mr-2"></i>Filtrar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- <!-- Cards -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 mb-2">
            <x-dashboard.card
                title="Total de Cobranças"
                :value="$totalCobrancas"
                icon="document-text"
                color="blue"
            />
            
            <x-dashboard.card
                title="Total Recebido"
                :value="'R$ ' . number_format($totalRecebido, 2, ',', '.')"
                icon="currency-dollar"
                color="green"
            />
            
            <x-dashboard.card
                title="Total Pendente"
                :value="'R$ ' . number_format($totalPendente, 2, ',', '.')"
                icon="clock"
                color="yellow"
            />
        </div> --}}

        <!-- Tabela -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="py-3 px-6">
                <div class="flex justify-between items-center mb-2">
                    <h2 class="text-lg font-semibold text-gray-800">Cobranças</h2>
                    <a href="#" class="btn btn-primary btn-sm hover:bg-indigo-600" onclick="verificarVencidas(event)">
                        <i class="fa-solid fa-arrows-rotate mr-2"></i>Verificar Vencidas
                    </a>
                    {{-- <a href="{{ route('relatorios.index') }}" class="btn btn-primary btn-sm hover:bg-indigo-600">
                        <i class="fas fa-file-export mr-2"></i>Gerar Relatório
                    </a> --}}
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-0.5 text-left text-sm font-semibold text-gray-800 uppercase">Cliente</th>
                                <th class="px-4 py-0.5 text-left text-sm font-semibold text-gray-800 uppercase">Sistema</th>
                                <th class="px-4 py-0.5 text-left text-sm font-semibold text-gray-800 uppercase">Título</th>
                                <th class="px-4 py-0.5 text-left text-sm font-semibold text-gray-800 uppercase">Emissão</th>
                                <th class="px-4 py-0.5 text-left text-sm font-semibold text-gray-800 uppercase">Valor</th>
                                <th class="px-4 py-0.5 text-left text-sm font-semibold text-gray-800 uppercase">Vencimento</th>
                                <th class="px-4 py-0.5 text-left text-sm font-semibold text-gray-800 uppercase">Status</th>
                                <th class="px-4 py-0.5 text-left text-sm font-semibold text-gray-800 uppercase">Quitação</th>
                                <th class="px-4 py-0.5 text-left text-sm font-semibold text-gray-800 uppercase">Sapiens</th>
                                <th class="px-4 py-0.5 text-left text-sm font-semibold text-gray-800 uppercase">Ações</th>
                            </tr>
                        </thead>
                        
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($cobrancas as $cobranca)
                                @php
                                    // TODO - opcionalmente adicionar na tabela cobrança a quantidade de dias de validade posterior ao vencimento para fazer a verificação de vencidas
                                    $dataVencimento = \Carbon\Carbon::parse($cobranca->data_vencimento);
                                    $expiracao = $cobranca->expiracao ?? $cobranca->data_vencimento->addDays($cobranca->validade_apos_vencimento);
                                    $validade_apos_vencimento = $cobranca->validade_apos_vencimento ?? 0;
                                    //$hoje = \Carbon\Carbon::now();
                                    //$vencida = ($dataVencimento->lt($hoje->addDays(-$validade_apos_vencimento)) && $cobranca->status_pagamento === ('ATIVO' || 'EXPIRADO')) || $cobranca->status_pagamento === 'CANCELADO';
                                    $vencida = ($expiracao->lt(now()->format('Y-m-d'))) && $cobranca->status_pagamento === ('ATIVO') 
                                    //|| $cobranca->status_pagamento === 'CANCELADO' || 'EXPIRADO'
                                    ;
                                @endphp
                                <tr class="{{ $vencida ? 'opacity-50' : '' }} hover:bg-gray-50">
                                    <td class="px-4 py-0.5 whitespace-nowrap text-gray-800">
                                        {{-- {{ $cobranca->titulo->nome_pagador }}   --}}
                                        {{$cobranca->cliente->nomCli}}
                                        <div class="text-sm text-gray-600">
                                            {{-- {{ $cobranca->titulo->cpf_cnpj }}  --}}
                                            {{$cobranca->cliente->cgcCpf}}
                                        </div>
                                    </td>
                                    <td class="px-4 py-0.5 whitespace-nowrap text-gray-800">{{ $cobranca->sistema_origem }}</td>
                                    <td class="px-4 py-0.5 whitespace-nowrap text-gray-800">{{ $cobranca->titulo_numTit }}</td>
                                    <td class="px-4 py-0.5 whitespace-nowrap text-gray-800">
                                        {{ $cobranca->created_at->format('d/m/Y H:i') }}
                                        <div class="text-sm text-gray-600">{{ $cobranca->responsavel}}</div>
                                    </td>
                                    <td class="px-4 py-0.5 whitespace-nowrap text-gray-800">R$ {{ number_format($cobranca->valor, 2, ',', '.') }}</td>
                                    <td class="px-4 py-0.5 whitespace-nowrap text-gray-800">{{ $dataVencimento->format('d/m/Y') }}</td>
                                    <td class="px-4 py-0.5 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-sm font-semibold rounded-full 
                                        {{-- 'PENDENTE', 'ATIVO', 'PAGO', 'CANCELADO', 'VENCIDO', 'REMOVIDO_PSP' --}}
                                            @if($cobranca->status_pagamento === 'ATIVO') bg-green-100 text-green-800
                                            @elseif($cobranca->status_pagamento === 'PAGO') bg-blue-100 text-blue-800
                                            @elseif($cobranca->status_pagamento === 'PENDENTE') bg-yellow-100 text-yellow-800
                                            @elseif($cobranca->status_pagamento === 'EXCLUIDO') bg-gray-600 text-gray-100
                                            @elseif($cobranca->status_pagamento === 'EXPIRADO') bg-gray-200 text-gray-600
    
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ $cobranca->status_pagamento }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-0.5 whitespace-nowrap text-gray-800">
                                        {{ $cobranca->data_pagamento ? \Carbon\Carbon::parse($cobranca->data_pagamento)->format('d/m/Y H:i') : '-' }}
                                    </td>
                                    <td class="px-4 py-0.5 whitespace-nowrap">
                                        @if($cobranca->status_senior === 'REGISTRADO')
                                            <span class="text-green-600"><i class="fas fa-check"></i></span>
                                        @else
                                            <span class="text-red-600"><i class="fas fa-times"></i></span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-0.5 whitespace-nowrap text-right space-x-2">
                                        <button onclick="verificarCobranca('{{ $cobranca->txid }}')" class="btn btn-sm btn-info hover:bg-blue-600">
                                            Verificar
                                        </button>
                                        {{-- @if($cobranca->status_pagamento === 'ATIVO')
                                            <button onclick="cancelarCobranca('{{ $cobranca->txid }}')" class="btn btn-sm btn-danger hover:bg-red-600">
                                                Cancelar
                                            </button>
                                        @endif --}}
                                        <a href="{{ route('cobrancas.show', $cobranca) }}" class="btn btn-sm btn-primary hover:bg-indigo-600">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $cobrancas->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function verificarCobranca(txid) {
        if (confirm('Deseja verificar o status desta cobrança?')) {
            fetch('/cobrancas/verificar/' + txid, {
                method: 'GET',
                // headers: {
                //     'X-CSRF-TOKEN': '{{ csrf_token() }}',
                //     'Content-Type': 'application/json'
                // }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.status) {
                    alert('Status da cobrança: ' + data.status);
                    location.reload();
                } else {
                    alert('Erro ao verificar cobrança.');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao verificar cobrança.');
            });
        }
    }

    function verificarVencidas(event) {
        event.preventDefault();

        if (confirm('Deseja verificar as cobranças vencidas?')) {
            fetch('/verificarVencidas', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert('Cobranças vencidas verificadas com sucesso.');
                    location.reload();
                } else {
                    alert('Erro ao verificar cobranças vencidas - no data.');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao verificar cobranças vencidas - error.');
            });
        }
    }

    function cancelarCobranca(txid) {
        if (confirm('Tem certeza que deseja cancelar esta cobrança?')) {
            // Implementar chamada AJAX para cancelar cobrança
        }
    }
</script>
@endpush
@endsection