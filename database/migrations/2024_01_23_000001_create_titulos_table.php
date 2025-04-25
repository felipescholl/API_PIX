<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('titulos', function (Blueprint $table) {
            $table->id();
            // Campos obrigatórios
            $table->integer('codEmp')->comment('Código da empresa');
            $table->string('codFil', 5)->comment('Código da filial');
            $table->string('numTit', 10)->comment('Número do título');
            $table->string('cpf_cnpj', 14)->comment('CPF/CNPJ do cliente');
            $table->string('nome_pagador', 250)->comment('Nome do pagador');
            $table->string('txid', 35)->comment('Id. Transação PIX');
            $table->string('codTpt', 3)->comment('Código do tipo de título');
            $table->string('codTns', 5)->comment('Código da transação');
            $table->date('datEmi')->comment('Data de emissão');
            $table->date('datEnt')->comment('Data de entrada');
            $table->integer('codCli')->comment('Código do cliente');
            $table->integer('codRep')->comment('Código do representante');
            $table->date('vctOri')->comment('Data de vencimento original');
            $table->decimal('vlrOri', 15, 2)->comment('Valor original');
            $table->date('datPpt')->comment('Data do provável pagamento');
            $table->string('codPor', 4)->nullable()->comment('Código do portador');
            $table->string('codCrt', 2)->comment('Código da carteira');
            $table->string('proJrs', 1)->comment('Prorrogação com juros (S/N)');
            $table->string('sitTit')->comment('Situação atual do título');
            $table->string('sitAnt')->comment('Situação anterior do título');

            // Campos opcionais
            $table->integer('numPrj')->nullable()->comment('Número do projeto');
            $table->integer('codNtg')->nullable()->comment('Código da natureza de gasto');
            $table->string('codCrp', 3)->nullable()->comment('Código do grupo de contas a receber');
            $table->string('numNff', 5)->nullable()->comment('Número da nota fiscal fatura origem do título');
            $table->string('ideTxi', 35)->nullable()->comment('Id. Transação PIX');
            $table->string('urlPix', 100)->nullable()->comment('Location URL');
            $table->string('emvQrc', 500)->nullable()->comment('EMV do QR-Code');
            $table->string('msgPag', 250)->nullable()->comment('Mensagem do Pagador Final');
            $table->date('datMov')->nullable()->comment('Data do movimento do título');
            $table->date('datPgt')->nullable()->comment('Data do pagamento/baixa do título');
            $table->decimal('vlrMov', 15, 2)->nullable()->comment('Valor do movimento do título');
            $table->string('numCco', 14)->nullable()->comment('Número da conta interna');
            $table->decimal('vlrLiq', 15, 2)->nullable()->comment('Valor líquido do movimento do título');
            $table->integer('empCco')->nullable()->comment('Código da empresa do movimento da conta interna');
            $table->date('datCco')->nullable()->comment('Data do movimento da conta interna');
            $table->integer('seqCco')->nullable()->comment('Sequência do movimento da conta interna');
            $table->integer('seqMov')->nullable()->comment('Sequência de movimento do título');
            $table->date('datLib')->nullable()->comment('Data da liberação para comissão e caixa/bancos');
            $table->integer('diaAtr')->nullable()->comment('Dias de atraso no pagamento do título');
            $table->integer('diaJrs')->nullable()->comment('Dias de atraso para efeito de juros');
            $table->decimal('vlrEnc', 15, 2)->nullable()->comment('Valor dos encargos do título');
            $table->decimal('vlrCor', 15, 2)->nullable()->comment('Valor da correção monetária do título');
            $table->decimal('vlrOac', 15, 2)->nullable()->comment('Valor de outros acréscimos do título');
            $table->decimal('vlrOde', 15, 2)->nullable()->comment('Valor de outros descontos do título');
            $table->decimal('cotMcr', 19, 6)->nullable()->comment('Valor da cotação da moeda na data base do movimento');
            $table->integer('filRlc')->nullable()->comment('Código da filial do título relacionado');
            $table->string('numRlc', 10)->nullable()->comment('Número do título relacionado');
            $table->string('tptRlc', 3)->nullable()->comment('Tipo do título relacionado');
            $table->integer('seqRlc')->nullable()->comment('Sequência do movimento relacionado');
            $table->string('numDoc', 10)->nullable()->comment('Número do documento do movimento do título');
            $table->string('tnsBxa', 5)->nullable()->comment('Transação de crédito na tesouraria');
            $table->integer('codSac')->nullable()->comment('Código do sacado');
            $table->string('codMoe', 3)->nullable()->comment('Código da moeda do título');
            $table->string('filNff', 5)->nullable()->comment('Código da filial da nota fiscal fatura origem do título');
            $table->string('obsTcr', 250)->nullable()->comment('Observação do título');
            $table->decimal('vlrMoe', 15, 2)->nullable()->comment('Valor na moeda do título');
            $table->decimal('perCom', 7, 4)->nullable()->comment('Percentual de comissão');
            $table->decimal('vlrBco', 15, 2)->nullable()->comment('Valor base da comissão');
            $table->decimal('vlrCom', 15, 2)->nullable()->comment('Valor da comissão');
            $table->decimal('perJrs', 5, 2)->nullable()->comment('Percentual de juros');
            $table->string('tipJrs', 1)->nullable()->comment('Tipo de juros (S/C)');
            $table->decimal('jrsDia', 9, 2)->nullable()->comment('Juros ao dia');
            $table->integer('tolJrs')->nullable()->comment('Dias de tolerância para juros');
            $table->decimal('perMul', 5, 2)->nullable()->comment('Percentual de multa');
            $table->integer('tolMul')->nullable()->comment('Dias de tolerância para multa');
            $table->string('cheBan', 3)->nullable()->comment('Número do banco do cheque');
            $table->string('cheAge', 7)->nullable()->comment('Agência do cheque');
            $table->string('cheCta', 14)->nullable()->comment('Conta do cheque');
            $table->string('cheNum', 10)->nullable()->comment('Número do cheque');
            $table->string('titBan', 20)->nullable()->comment('Número do título no banco');
            $table->integer('numArb')->nullable()->comment('Número de arquivo de remessa');
            $table->string('codIn1', 3)->nullable()->comment('Primeira instrução bancária');
            $table->string('codIn2', 3)->nullable()->comment('Segunda instrução bancária');
            $table->date('datNeg')->nullable()->comment('Data base dos valores negociados');
            $table->decimal('jrsNeg', 15, 2)->nullable()->comment('Juros negociados');
            $table->decimal('mulNeg', 15, 2)->nullable()->comment('Multa negociada');
            $table->decimal('dscNeg', 15, 2)->nullable()->comment('Descontos negociados');
            $table->decimal('outNeg', 15, 2)->nullable()->comment('Outros valores negociados');
            $table->integer('ctaFin')->nullable()->comment('Conta financeira reduzida');
            $table->integer('ctaRed')->nullable()->comment('Conta contábil reduzida');
            $table->string('codCcu', 9)->nullable()->comment('Código do centro de custo');
            $table->string('codMpt', 3)->nullable()->comment('Código do motivo de prorrogação');
            $table->decimal('perDsc', 5, 2)->nullable()->comment('Percentual de desconto');
            $table->decimal('vlrDsc', 15, 2)->nullable()->comment('Valor do desconto');
            $table->integer('tolDsc')->nullable()->comment('Dias de tolerância para desconto');
            $table->date('datDsc')->nullable()->comment('Data válida para desconto');
            $table->integer('codFpj')->nullable()->comment('Código da fase do projeto');
            $table->string('cpgNeg', 6)->nullable()->comment('Condição de pagamento negociada');
            $table->decimal('taxNeg', 13, 6)->nullable()->comment('Taxa negociada');
            $table->string('catTef', 100)->nullable()->comment('Código de autorização TEF');
            $table->string('nsuTef', 100)->nullable()->comment('NSU da transação TEF');
            $table->decimal('comRec', 5, 2)->nullable()->comment('Comissão no recebimento');
            $table->decimal('vlrDca', 15, 2)->nullable()->comment('Despesas cartoriais');
            $table->decimal('vlrDcb', 15, 2)->nullable()->comment('Despesas de cobrança');
            $table->decimal('vlrOud', 15, 2)->nullable()->comment('Outras despesas');
            $table->bigInteger('cnpjFilial')->nullable()->comment('CNPJ da filial');
            $table->integer('seqCob')->nullable()->comment('Código de endereço de cobrança');
            $table->integer('ideExt')->nullable()->comment('Identificador externo');
            $table->string('ctrExt')->nullable()->comment('Número do contrato externo');
            $table->string('sigInt')->nullable()->comment('Sigla do sistema integrado');

            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index('codCli');
            $table->index('numTit');
            $table->index('numPrj');
            $table->index('sitTit');
        });
    }

    public function down()
    {
        Schema::dropIfExists('titulos');
    }
};
