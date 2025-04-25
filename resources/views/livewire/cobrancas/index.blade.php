<div>
    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="label">Buscar</label>
                    <input type="text" wire:model.debounce.300ms="search" class="input input-bordered w-full" placeholder="Nome, email, CPF/CNPJ ou TxId">
                </div>

                <div>
                    <label class="label">Status</label>
                    <select wire:model="status" class="select select-bordered w-full">
                        <option value="">Todos</option>
                        <option value="ATIVA">Ativa</option>
                        <option value="CONCLUIDA">Concluída</option>
                        <option value="REMOVIDA_PELO_USUARIO_RECEBEDOR">Removida</option>
                    </select>
                </div>

                <div>
                    <label class="label">Cliente</label>
                    <select wire:model="cliente_id" class="select select-bordered w-full">
                        <option value="">Todos</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="label">Período</label>
                    <div class="flex space-x-2">
                        <input type="date" wire:model="data_inicio" class="input input-bordered w-full">
                        <input type="date" wire:model="data_fim" class="input input-bordered w-full">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Cobranças -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold">Cobranças</h3>
            <a href="{{ route('cobrancas.create') }}" class="btn btn-primary">
                Nova Cobrança
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Valor</th>
                        <th>Status</th>
                        <th>Data de Criação</th>
                        <th>Expiração</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cobrancas as $cobranca)
                        <tr>
                            <td>
                                <div>
                                    <p class="font-semibold">{{ $cobranca->cliente->nome }}</p>
                                    <p class="text-sm text-gray-600">{{ $cobranca->cliente->cpf_cnpj }}</p>
                                </div>
                            </td>
                            <td>R$ {{ number_format($cobranca->valor, 2, ',', '.') }}</td>
                            <td>
                                <span class="badge badge-{{ $cobranca->status === 'ATIVA' ? 'warning' : ($cobranca->status === 'CONCLUIDA' ? 'success' : 'error') }}">
                                    {{ $cobranca->status_formatado }}
                                </span>
                            </td>
                            <td>{{ $cobranca->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $cobranca->expiracao->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="flex space-x-2">
                                    <a href="{{ route('cobrancas.show', $cobranca) }}" class="btn btn-sm">
                                        Detalhes
                                    </a>
                                    @if($cobranca->status === 'ATIVA')
                                        <button wire:click="cancelarCobranca({{ $cobranca->id }})" class="btn btn-sm btn-error">
                                            Cancelar
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                Nenhuma cobrança encontrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4">
            {{ $cobrancas->links() }}
        </div>
    </div>
</div> 