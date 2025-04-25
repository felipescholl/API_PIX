<!-- Main Content -->
<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            @if (session()->has('error'))
                <div class="alert alert-error mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form wire:submit.prevent="gerarCobranca">
                <!-- Cliente -->
                <div class="mb-4">
                    <label for="cliente_id" class="block text-sm font-medium text-gray-700">Cliente</label>
                    <select id="cliente_id" 
                            wire:model="cliente_id"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">Selecione um cliente</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                        @endforeach
                    </select>
                    @error('cliente_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Valor -->
                <div class="mb-4">
                    <label for="valor" class="block text-sm font-medium text-gray-700">Valor</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">R$</span>
                        </div>
                        <input type="text" 
                               wire:model="valor"
                               id="valor"
                               class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 pr-12 sm:text-sm border-gray-300 rounded-md"
                               placeholder="0,00">
                    </div>
                    @error('valor') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Descrição -->
                <div class="mb-4">
                    <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição (opcional)</label>
                    <textarea id="descricao" 
                              wire:model="descricao"
                              rows="3" 
                              class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md"></textarea>
                    @error('descricao') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Data de Expiração -->
                <div class="mb-4">
                    <label for="expiracao" class="block text-sm font-medium text-gray-700">Data de Expiração</label>
                    <input type="datetime-local" 
                           wire:model="expiracao"
                           id="expiracao"
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    @error('expiracao') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Botões -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('cobrancas.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Gerar Cobrança
                    </button>
                </div>
            </form>
        </div>
    </div>
</div> 