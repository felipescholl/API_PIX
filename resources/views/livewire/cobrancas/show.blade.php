@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold">Detalhes da Cobrança</h3>
                    <div class="flex space-x-2">
                        @if ($cobranca->status_pagamento === 'ATIVO')
                            {{-- <button wire:click="atualizarStatus" class="btn btn-primary btn-sm opacity-50"
                                wire:loading.attr="disabled">
                                <span wire:loading wire:target="atualizarStatus"></span>
                                Atualizar Status
                            </button> --}}
                            {{-- <button wire:click="cancelarCobranca" class="btn btn-error btn-sm opacity-50"
                                wire:loading.attr="disabled">
                                <span wire:loading wire:target="cancelarCobranca" class=""></span>
                                Cancelar Cobrança
                            </button> --}}
                            {{-- Botão para reenviar a cobrança --}}
                            {{-- <button wire:click="reenviarCobranca" class="btn btn-secondary btn-sm opacity-50"
                                wire:loading.attr="disabled">
                                <span wire:loading wire:target="reenviarCobranca" class=""></span>
                                Reenviar Cobrança
                            </button> --}}
                        @endif
                        {{-- Botão para voltar para dashboard --}}
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">
                            Voltar para Dashboard
                        </a>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Informações da Cobrança -->
                    <div>
                        <h4 class="font-semibold mb-4">Informações da Cobrança</h4>
                        <div class="space-y-3">
                            <div>
                                <span class="text-gray-600 font-semibold text-lg">Projeto: </span>
                                <span class="text-gray-600 font-bold text-lg">{{ $cobranca->titulo->numPrj}}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Status:</span>
                                <span
                                    class="badge font-bold text-lg p-4 badge-{{ $cobranca->status_pagamento === 'ATIVO' ? 'warning' : ($cobranca->status_pagamento === 'PAGO' ? 'success' : 'error') }}">
                                    {{ $cobranca->status_pagamento }}
                                </span>
                            </div>
                            
                            <div>
                                <span class="text-gray-600">Valor:</span>
                                <span class="font-semibold">R$ {{ number_format($cobranca->valor, 2, ',', '.') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Data de Criação:</span>
                                <span class="font-semibold">{{ $cobranca->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Expiração:</span>
                                <span class="font-semibold">{{ $cobranca->data_vencimento->format('d/m/Y H:i') }}</span>
                            </div>

                            @if ($cobranca->msg_senior)
                                <div>
                                    <span class="text-gray-600">Mensagem Sênior:</span>
                                    <p class="mt-1 ">{{ $cobranca->msg_senior }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Informações do Cliente -->
                    <div>
                        <h4 class="font-semibold mb-4">Informações do Cliente</h4>
                        <div class="space-y-3">
                            <div>
                                <span class="text-gray-600">Nome:</span>
                                <span class="font-semibold">{{ $cobranca->cliente->nomCli }}</span>
                            </div>
                            @if ($cobranca->cliente->apeCli)
                                <div>
                                    <span class="text-gray-600">Nome fantasia:</span>
                                    <span class="font-semibold">{{ $cobranca->cliente->apeCli }}</span>
                                </div>
                            @endif
                            <div>
                                <span class="text-gray-600">CPF/CNPJ:</span>
                                <span class="font-semibold">{{ $cobranca->cliente->cgcCpf }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Email:</span>
                                <span class="font-semibold">{{ $cobranca->cliente->intNet }}</span>
                            </div>
                            
                            @if ($cobranca->cliente->fonCli)
                                <div>
                                    <span class="text-gray-600">Telefone:</span>
                                    <span class="font-semibold">{{ $cobranca->cliente->fonCli }}</span>
                                </div>
                            @endif
                            @if ($cobranca->cliente->fonCl2)
                                <div>
                                    <span class="text-gray-600">Telefone:</span>
                                    <span class="font-semibold">{{ $cobranca->cliente->fonCl2 }}</span>
                                </div>
                            @endif
                            @if ($cobranca->cliente->endCli)
                                <div>
                                    <span class="text-gray-600">Endereço:</span>
                                    <span class="font-semibold">{{ $cobranca->cliente->endCli }} Nº {{ $cobranca->cliente->nenCli }} - {{$cobranca->cliente->cplEnd}}, Bairro {{$cobranca->cliente->baiCli}}, {{$cobranca->cliente->cidCli}} / RS - CEP: {{$cobranca->cliente->cepCli}}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex items-center mx-auto mt-8 max-w-md">
                    <div class="join w-full mx-auto">
                        <input type="text" readonly value="{{ $cobranca->txid }}"
                            class="input input-bordered join-item w-full">
                        <button onclick="navigator.clipboard.writeText('{{ $cobranca->txid }}')" class="btn join-item">
                            Copiar
                        </button>
                    </div>

                </div>

                @if ($cobranca->status_pagamento === 'ATIVO' || 'PAGO')
                    <!-- QR Code -->
                    <div class="mt-8 border-t border-gray-200 pt-6">
                        {{-- <h4 class="font-semibold mb-4">QR Code PIX</h4> --}}
                        <div class="flex flex-col items-center space-y-4">
                            
                            @if ($cobranca->titulo->urlPix)
                                <div class="w-full max-w-md">
                                    <label class="label">Location PIX</label>
                                    <div class="join w-full">
                                        <input type="text" readonly value="{{ $cobranca->titulo->urlPix }}"
                                            class="input input-bordered join-item w-full">
                                        <a href="{{ route('cobrancas.location', ['txid' => $cobranca->txid]) }}" 
                                            {{-- //target="_blank" --}}
                                            class="btn join-item">
                                            Visualizar
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif


                <div class="mt-8 border-t border-gray-200 pt-6">
                    <h4 class="text-lg font-semibold mb-4">Informações do título</h4>
                    <div x-data="{ open: false }">
                        <button @click="open = !open" class="btn btn-primary btn-sm mb-2">
                            <span x-show="!open">Mostrar</span>
                            <span x-show="open">Esconder</span> Informações do título
                        </button>
                        <div x-show="open">
                    <div>
                    <!-- Informações do título -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                            <div>
                                <h4 class="font-semibold mb-4">Informações do título</h4>
                                <div class="space-y-3">
                                    <div>
                                        <span class="text-gray-600">Código da empresa: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->codEmp }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Códido da Filial: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->codFil }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Número do Título: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->numTit }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Código do tipo de título: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->codTpt }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Código da transação: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->codTns }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Data de emissão: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->datEmi }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Data de entrada: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->datEnt }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Código do cliente: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->codCli }}</span>
                                    </div>
                                    {{-- <div>
                                        <span class="text-gray-600">Código do representante: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->codRep }}</span>
                                    </div> --}}
                                    <div>
                                        <span class="text-gray-600">Data de vencimento original: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->vctOri }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Valor original: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->vlrOri }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Multa: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->perMul }}%</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Juros: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->perJrs }}% ao mês</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Data do provável pagamento: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->datPpt }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Código do portador: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->codPor }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Código da carteira: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->codCrt }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Prorrogação com juros: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->proJrs }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Situação atual do título: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->sitTit }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Situação anterior do título: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->sitAnt }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Número do projeto: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->numPrj }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Código da natureza de gasto: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->codNtg }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Código do grupo de contas a receber: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->codCrp }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Número da nota fiscal fatura origem do título: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->numNff }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Id. Transação PIX: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->ideTxi }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Location URL: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->urlPix }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">EMV do QR-Code: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->emvQrc }}</span>
                                    </div>
                                    @if ($cobranca->msg_senior)
                                        <div>
                                            <span class="text-gray-600">Descrição:</span>
                                            <p class="mt-1">{{ $cobranca->msg_senior }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <!-- Informações do Cliente -->
                            <div>
                                <h4 class="font-semibold mb-4">Informações do Pagamento</h4>
                                <div class="space-y-3">
                                    <div>
                                        <span class="text-gray-600">Mensagem do Pagador Final: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->msgPag }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Data do movimento do título: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->datMov }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Data do pagamento/baixa do título: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->datPgt }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Dias de atraso no pagamento do título: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->diaAtr }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Valor do movimento do título: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->vlrMov }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Valor líquido do movimento do título: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->vlrLiq }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Valor Multa: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->vlrMul }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Valor Juros: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->vlrJrs }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Número da conta interna: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->numCco }}</span>
                                    </div>
                                    {{-- <div>
                                        <span class="text-gray-600">Código da empresa do movimento da conta interna: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->empCco }}</span>
                                    </div> --}}
                                    {{-- <div>
                                        <span class="text-gray-600">Data do movimento da conta interna: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->datCco }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Sequência do movimento da conta interna: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->seqCco }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Sequência de movimento do título: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->seqMov }}</span>
                                    </div> --}}
                                    
                                    
                                    
                                    {{-- <div>
                                        <span class="text-gray-600">Valor dos encargos do título: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->vlrEnc }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Valor da correção monetária do título: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->vlrCor }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Valor de outros acréscimos do título: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->vlrOac }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Valor de outros descontos do título: </span>
                                        <span class="font-semibold">{{ $cobranca->titulo->vlrOde }}</span>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informações das transações realizadas -->
                <div class="mt-8 border-t border-gray-200 pt-6">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <h4 class="font-semibold mb-4">Informações das transações</h4>
                            <div class="space-y-4 ">
                                @foreach ($cobranca->transacoes as $transacao)
                                    <div class="gap-3">
                                        <div>
                                            <span class="text-gray-600">Transação ID: </span>
                                            <span class="font-semibold">{{ $transacao->id }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Tipo: </span>
                                            <span class="font-semibold">{{ $transacao->tipo }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Status: </span>
                                            <span class="font-semibold">{{ $transacao->status }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Descrição: </span>
                                            <span class="font-semibold">{{ $transacao->descricao }}</span>
                                        </div>
                                        @if ($transacao->dados_adicionais && $transacao->status === 'ERRO')
                                            <div class="mt-2 ml-6">
                                                <span class="text-gray-600">Retorno: </span>
                                                {{-- {{dd($transacao->dados_adicionais);}} --}}
                                                <span class="font-semibold">
                                                {{ json_encode($transacao->dados_adicionais, JSON_UNESCAPED_UNICODE) }} </span>
                                        
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>


                </div>
            </div>

            @if (session()->has('message'))
                <div class="alert alert-success mt-4">
                    {{ session('message') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="alert alert-error mt-4">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    @endsection
