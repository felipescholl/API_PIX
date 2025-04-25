<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Cobranca;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public $totalCobrancas;
    public $totalRecebido;
    public $totalPendente;
    public $cobrancasRecentes;

    public function mount()
    {
        $this->atualizarEstatisticas();
    }

    public function atualizarEstatisticas()
    {
        $this->totalCobrancas = Cobranca::count();
        $this->totalRecebido = Cobranca::pagas()->sum('valor');
        $this->totalPendente = Cobranca::pendentes()->sum('valor');
        
        $this->cobrancasRecentes = Cobranca::with([])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->map(function ($cobranca) {
                return [
                    'id' => $cobranca->id,
                    'sistema_origem' => $cobranca->sistema_origem,
                    'num_tit' => $cobranca->num_tit,
                    'data' => $cobranca->created_at->format('d/m/Y H:i'),
                    'cpf_cnpj' => $cobranca->cpf_cnpj_pagador,
                    'codigo_projeto' => $cobranca->codigo_projeto,
                    'valor' => $cobranca->valor_formatado,
                    'status' => $cobranca->status_formatado,
                    'data_pagamento' => $cobranca->data_pagamento_formatada,
                    'registrado_sapiens' => $cobranca->registrado_sapiens
                ];
            });
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
} 