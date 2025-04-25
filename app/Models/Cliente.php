<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'clientes';

    // Define a chave primária
    protected $primaryKey = 'codCli';

    // Se necessário, defina se a chave primária é autoincrementável
    public $incrementing = false;

    protected $fillable = [
        'codCli',
        'nomCli',
        'apeCli',
        'tipCli',
        'tipMer',
        'cliCon',
        'sitCli',
        'insEst',
        'insMun',
        'cgcCpf',
        'zonFra',
        'codSuf',
        'endCli',
        'nenCli',
        'cplEnd',
        'cliPrx',
        'zipCod',
        'cepCli',
        'cepIni',
        'baiCli',
        'cidCli',
        'sigUfs',
        'codPai',
        'fonCli',
        'fonCl2',
        'fonCl3',
        'fonCl4',
        'fonCl5',
        'faxCli',
        'cxaPst',
        'intNet',
        'obsMot',
        'triIcm',
        'triIpi',
        'triPis',
        'triCof',
        'retCof',
        'retCsl',
        'retPis',
        'retOur',
        'retPro',
        'retIrf',
        'calFun',
        'calSen',
        'emaNfe',
        'ideCli',
        'sigInt',
    ];

    protected $casts = [
        'tipCli' => 'string',
        'tipMer' => 'string',
        'cliCon' => 'string',
        'sitCli' => 'string',
        'triIcm' => 'string',
        'triIpi' => 'string',
        'triPis' => 'string',
        'triCof' => 'string',
        'retCof' => 'string',
        'retCsl' => 'string',
        'retPis' => 'string',
        'retOur' => 'string',
        'retPro' => 'string',
        'retIrf' => 'string',
        'calFun' => 'string',
        'calSen' => 'string',
    ];

    // Relacionamentos
    public function cobrancas()
    {
        return $this->hasMany(Cobranca::class, 'cliente_codCli');
    }

    public function titulos()
    {
        return $this->hasMany(Titulo::class, 'codCli');
    }

    // Métodos úteis
    public function getNomeCompletoAttribute()
    {
        return $this->nomCli . ' ' . $this->apeCli;
    }

    public function getEnderecoCompletoAttribute()
    {
        return "{$this->endCli}, {$this->nenCli}, {$this->baiCli}, {$this->cidCli} - {$this->sigUfs}, CEP: {$this->cepCli}";
    }

    // Ciente.id deve retornar o código do cliente (codCli)
    public function getRouteKeyName()
    {
        return 'codCli';
    }

}