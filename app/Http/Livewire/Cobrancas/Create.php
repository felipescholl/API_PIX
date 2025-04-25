<?php

namespace App\Http\Livewire\Cobrancas;

use Livewire\Component;
use App\Models\Cliente;
use App\Models\Cobranca;
use App\Services\PixService;
use App\Services\TxidService;
use Illuminate\Support\Str;

class Create extends Component
{
    public $cliente_id;
    public $valor;
    public $descricao;
    public $expiracao;

    protected $rules = [
        'cliente_id' => 'required|exists:clientes,id',
        'valor' => 'required|numeric|min:0.01',
        'descricao' => 'nullable|string|max:255',
        'expiracao' => 'required|date|after:now'
    ];

    public function mount()
    {
        $this->expiracao = now()->addDays(1)->format('Y-m-d\TH:i');
    }

    public function gerarCobranca()
    {
        $this->validate();

        try {
            // Gerar TXID conforme as regras
            $txid = TxidService::generate(
                'RC', // Usando RC como padrão
                random_int(1, 999999999), // Código do título aleatório
                random_int(1, 999999999), // Número da operação aleatório
                $this->valor,
                now()->format('Y-m-d')
            );

            $cobranca = new Cobranca([
                'cliente_id' => $this->cliente_id,
                'valor' => $this->valor,
                'descricao' => $this->descricao,
                'expiracao' => $this->expiracao,
                'txid' => $txid,
                'status' => 'ATIVA'
            ]);

            $cobranca->save();

            $pixService = new PixService();
            if ($pixService->gerarCobranca($cobranca)) {
                session()->flash('message', 'Cobrança gerada com sucesso!');
                return redirect()->route('cobrancas.show', $cobranca);
            }

            $cobranca->delete();
            throw new \Exception('Não foi possível gerar a cobrança PIX.');
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao gerar cobrança: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.cobrancas.create', [
            'clientes' => Cliente::orderBy('nome')->get()
        ]);
    }
} 