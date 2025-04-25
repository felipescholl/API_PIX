<?php

namespace App\Http\Livewire\Cobrancas;

use Livewire\Component;
use App\Models\Cobranca;
use App\Services\PixService;

class Show extends Component
{
    public Cobranca $cobranca;
    public $atualizando = false;

    protected $listeners = ['atualizarStatus'];

    public function mount(Cobranca $cobranca)
    {
        $this->cobranca = $cobranca;
    }

    public function atualizarStatus()
    {
        try {
            $this->atualizando = true;
            $pixService = new PixService();
            $response = $pixService->consultarCobranca($this->cobranca->txid);

            $this->cobranca->update([
                'status' => $response->status
            ]);

            if ($response->status === 'CONCLUIDA') {
                session()->flash('message', 'Cobrança foi paga!');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao atualizar status: ' . $e->getMessage());
        } finally {
            $this->atualizando = false;
        }
    }

    public function cancelarCobranca()
    {
        try {
            $pixService = new PixService();
            $response = $pixService->cancelarCobranca($this->cobranca->txid);

            if ($response->status === 'REMOVIDA_PELO_USUARIO_RECEBEDOR') {
                $this->cobranca->update([
                    'status' => $response->status
                ]);

                session()->flash('message', 'Cobrança cancelada com sucesso!');
            } else {
                throw new \Exception('Não foi possível cancelar a cobrança.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao cancelar cobrança: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.cobrancas.show');
    }
} 