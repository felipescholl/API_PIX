<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\SeniorsService;

class Cobranca extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cobrancas';

    protected $fillable = [
        'cliente_codCli',
        'titulo_id',
        'sistema_origem',
        'titulo_numTit',
        'titulo_numPrj',
        'txid',
        'valor',
        'data_vencimento',
        'data_pagamento',
        'endToEndId',
        'status_pagamento',
        'status_senior',
        'msg_senior',
        'verif_no_venc',
        'validade_apos_vencimento',
        'expiracao',
        'responsavel',
    ];

    protected $casts = [
        'data_vencimento' => 'date:Y-m-d',
        'data_pagamento' => 'date:Y-m-d',
        'valor' => 'decimal:2',
        'status_pagamento' => 'string',
        'status_senior' => 'string',
        'validade_apos_vencimento' =>'integer',
        'expiracao' => 'date:Y-m-d'
    ];

    // Status pagamentos possiveis
    const PAGAMENTO_PENDENTE = 'PENDENTE';
    const PAGAMENTO_ATIVO = 'ATIVO';
    const PAGAMENTO_PAGO = 'PAGO';
    const PAGAMENTO_CANCELADO = 'CANCELADO';
    const PAGAMENTO_VENCIDO = 'VENCIDO';
    const PAGAMENTO_SUBSTITUIDO = 'SUBSTITUIDO';
    const PAGAMENTO_EXPIRADO = 'EXPIRADO';
    const PAGAMENTO_EXCLUIDO = 'EXCLUIDO';
            
    // Status possíveis
    const SENIOR_REGISTRADO = 'REGISTRADO';
    const SENIOR_ERRO = 'ERRO';
    const SENIOR_REMOVIDO_PSP = 'REMOVIDO_PSP';
    const SENIOR_NAO_ENVIADO = 'NAO_ENVIADO';

    // Relacionamentos
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_codCli', 'codCli');
    }

    public function titulo()
    {
        return $this->belongsTo(Titulo::class, 'titulo_id');
    }

    public function transacoes()
    {
        return $this->hasMany(Transacao::class, 'cobranca_id');
    }

    // Métodos úteis
    public function isPendente()
    {
        return $this->status_pagamento === 'PENDENTE';
    }

    public function isPaga()
    {
        return $this->status_pagamento === 'PAGO';
    }

    public function isCancelada()
    {
        return $this->status_pagamento === 'CANCELADO';
    }

    public function isVencida()
    {
        return $this->data_vencimento < now() && $this->isPendente();
    }

    public function isVerificadaNoVencimento()
    {
        return $this->verif_no_venc;
    }

    public function getValorFormatadoAttribute()
    {
        return 'R$ ' . number_format($this->valor, 2, ',', '.');
    }

    public function getDataVencimentoFormatadaAttribute()
    {
        return $this->data_vencimento->format('d/m/Y');
    }

    public function getDataPagamentoFormatadaAttribute()
    {
        return $this->data_pagamento ? $this->data_pagamento->format('d/m/Y H:i') : null;
    }

    // // RegistrarSapiens
    // public function registrarSapiens($resultado, $mensagem)
    // {
    //     $this->update([
    //         'status_pagamento' => $resultado['status_pagamento'],
    //         'data_registro_sapiens' => now(),
    //         'status_senior' => $resultado['status_senior'],
    //         'msg_senior' => $mensagem
    //     ]);
    // }
}