<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transacao extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'transacoes';

    protected $fillable = [
        'cobranca_id',
        'titulo_id',
        'tipo',
        'status',
        'descricao',
        'dados_adicionais',
    ];

    protected $casts = [
        'dados_adicionais' => 'json',
    ];

    // Tipos de transação
    const TIPO_CRIACAO = 'CRIACAO';
    const TIPO_PAGAMENTO = 'PAGAMENTO';
    const TIPO_CANCELAMENTO = 'CANCELAMENTO';
    const TIPO_REMOVIDO_PSP = 'REMOVIDO_PSP';
    const TIPO_ALTERACAO = 'ALTERACAO';
    const TIPO_REGISTRO_SENIOR = 'REGISTRO_SENIOR';
    const TIPO_VERIFICACAO = 'VERIFICACAO';
    const TIPO_SUBSTITUICAO = 'SUBSTITUICAO';
    const TIPO_CALLBACK = 'CALLBACK';

    //novos tipos
    const TIPO_REG_CRIACAO = 'REG_CRIACAO';
    const TIPO_REG_BAIXA = 'REG_BAIXA';
    const TIPO_REG_ALTERACAO = 'REG_ALTERACAO';
    const TIPO_REG_CANCELAMENTO = 'REG_CANCELAMENTO';
    const TIPO_REG_PAGAMENTO = 'REG_PAGAMENTO';

    // Status possíveis
    const STATUS_SUCESSO = 'SUCESSO';
    const STATUS_ERRO = 'ERRO';

    // Relacionamentos
    public function cobranca()
    {
        return $this->belongsTo(Cobranca::class, 'cobranca_id');
    }

    public function titulo()
    {
        return $this->belongsTo(Titulo::class, 'titulo_id');
    }

    public static function registrar($titulo, $tipo, $dados = [])
    {
        return self::create([
            'titulo_id' => $titulo->id,
            'cobranca_id' => $dados['cobranca_id'],
            'tipo' => $tipo,
            'status' => $dados['status'],
            'descricao' => $dados['descricao'] ?? null,
            'dados_adicionais' => $dados['dados_adicionais'] ?? null
        ]);
    }

    // public static function registrar($cobranca, $tipo, $dados = [])
    // {
    //     return self::create([
    //         'titulo_id' => $cobranca->titulo->id,
    //         'cobranca_id' => $cobranca->id,
    //         'tipo' => $tipo,
    //         'status' => $dados['status'],
    //         'descricao' => $dados['descricao'] ?? null,
    //         'dados_adicionais' => $dados['dados_adicionais'] ?? null
    //     ]);
    // }
}