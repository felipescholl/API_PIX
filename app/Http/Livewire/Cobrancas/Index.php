<?php

namespace App\Http\Livewire\Cobrancas;

use Livewire\Component;
use App\Models\Cobranca;
use App\Models\Cliente;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $cliente_id = '';
    public $data_inicio;
    public $data_fim;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'cliente_id' => ['except' => ''],
        'data_inicio' => ['except' => ''],
        'data_fim' => ['except' => '']
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $cobrancas = Cobranca::with('cliente')
            ->when($this->search, function ($query) {
                $query->whereHas('cliente', function ($q) {
                    $q->where('nome', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('cpf_cnpj', 'like', '%' . $this->search . '%');
                })
                ->orWhere('txid', 'like', '%' . $this->search . '%');
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->when($this->cliente_id, function ($query) {
                $query->where('cliente_id', $this->cliente_id);
            })
            ->when($this->data_inicio, function ($query) {
                $query->whereDate('created_at', '>=', $this->data_inicio);
            })
            ->when($this->data_fim, function ($query) {
                $query->whereDate('created_at', '<=', $this->data_fim);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $clientes = Cliente::orderBy('nome')->get();

        return view('livewire.cobrancas.index', [
            'cobrancas' => $cobrancas,
            'clientes' => $clientes
        ]);
    }
} 