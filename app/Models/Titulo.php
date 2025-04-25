<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Titulo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'titulos';

    protected $fillable = [
        'cpf_cnpj',
        'nome_pagador',
        'codEmp',
        'codFil',
        'numTit',
        'txid',
        'codTpt',
        'codTns',
        'datEmi',
        'datEnt',
        'codCli',
        'codRep',
        'vctOri',
        'vlrOri',
        'datPpt',
        'codPor',
        'codCrt',
        'proJrs',
        'numPrj',
        'sitTit',
        'sitAnt',
        'codNtg',
        'codCrp',
        'numNff',
        'ideTxi',
        'urlPix',
        'emvQrc',
        'msgPag',
        'datMov',
        'datPgt',
        'vlrMov',
        'numCco',
        'vlrLiq',
        'empCco',
        'datCco',
        'seqCco',
        'seqMov',
        'datLib',
        'diaAtr',
        'diaJrs',
        'vlrEnc',
        'vlrCor',
        'vlrOac',
        'vlrOde',
        'cotMcr',
        'filRlc',
        'numRlc',
        'tptRlc',
        'seqRlc',
        'numDoc',
        'tnsBxa',
        'codSac',
        'codMoe',
        'filNff',
        'obsTcr',
        'vlrMoe',
        'perCom',
        'vlrBco',
        'vlrCom',
        'perJrs',
        'tipJrs',
        'jrsDia',
        'tolJrs',
        'perMul',
        'tolMul',
        'cheBan',
        'cheAge',
        'cheCta',
        'cheNum',
        'titBan',
        'numArb',
        'codIn1',
        'codIn2',
        'datNeg',
        'jrsNeg',
        'mulNeg',
        'dscNeg',
        'outNeg',
        'ctaFin',
        'ctaRed',
        'codCcu',
        'codMpt',
        'perDsc',
        'vlrDsc',
        'tolDsc',
        'datDsc',
        'codFpj',
        'cpgNeg',
        'taxNeg',
        'catTef',
        'nsuTef',
        'comRec',
        'vlrDca',
        'vlrDcb',
        'vlrOud',
        'cnpjFilial',
        'seqCob',
        'ideExt',
        'ctrExt',
        'sigInt',
    ];

    protected $casts = [
        'datEmi' => 'date:Y-m-d',
        'datEnt' => 'date:Y-m-d',
        'vctOri' => 'date:Y-m-d',
        'datPpt' => 'date:Y-m-d',
        'datMov' => 'date:Y-m-d',
        'datPgt' => 'date:Y-m-d',
        'datCco' => 'date:Y-m-d',
        'datLib' => 'date:Y-m-d',
        'datNeg' => 'date:Y-m-d',
        'datDsc' => 'date:Y-m-d',
        'vlrOri' => 'decimal:2',
        'vlrMov' => 'decimal:2',
        'vlrLiq' => 'decimal:2',
        'vlrEnc' => 'decimal:2',
        'vlrCor' => 'decimal:2',
        'vlrOac' => 'decimal:2',
        'vlrOde' => 'decimal:2',
        'cotMcr' => 'decimal:10',
        'vlrMoe' => 'decimal:2',
        'perCom' => 'decimal:4',
        'vlrBco' => 'decimal:2',
        'vlrCom' => 'decimal:2',
        'perJrs' => 'decimal:2',
        'jrsDia' => 'decimal:2',
        'perMul' => 'decimal:2',
        'jrsNeg' => 'decimal:2',
        'mulNeg' => 'decimal:2',
        'dscNeg' => 'decimal:2',
        'outNeg' => 'decimal:2',
        'perDsc' => 'decimal:2',
        'vlrDsc' => 'decimal:2',
        'taxNeg' => 'decimal:10',
        'comRec' => 'decimal:2',
        'vlrDca' => 'decimal:2',
        'vlrDcb' => 'decimal:2',
        'vlrOud' => 'decimal:2',
    ];

    // Relacionamentos
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'codCli');
    }

    public function cobranca()
    {
        return $this->hasOne(Cobranca::class, 'titulo_id');
    }

    public function transacoes()
    {
        return $this->hasMany(Transacao::class, 'titulo_id');
    }

    
}