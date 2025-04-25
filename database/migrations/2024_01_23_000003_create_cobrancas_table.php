<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cobrancas', function (Blueprint $table) {

            $table->id();
            $table->foreignId('cliente_codCli')->nullable()->constrained('clientes', 'codCli'); // TODO: Depois tirar o nullable
            $table->foreignId('titulo_id')->constrained('titulos');
            $table->string('sistema_origem'); // SCR, SISCLAS, etc
            $table->string('txid')->unique();
            $table->string('titulo_numTit', 10); // Número do título
            $table->string('titulo_numPrj')->nullable(); // Número do projeto
            $table->decimal('valor', 15, 2);
            $table->date('data_vencimento');
            $table->date('data_pagamento')->nullable();
            $table->integer('validade_apos_vencimento')->nullable();
            $table->date('expiracao')->nullable();
            $table->string('endToEndId', 32)->nullable();
            //$table->enum('status_pagamento', ['PENDENTE', 'ATIVO', 'PAGO', 'CANCELADO', 'VENCIDO', 'SUBSTITUIDA'])->default('PENDENTE');
            $table->string('status_pagamento')->nullable();
            $table->enum('status_senior', ['NAO_ENVIADO', 'REGISTRADO', 'ERRO', 'REMOVIDO_PSP'])->default('NAO_ENVIADO');
            $table->text('msg_senior')->nullable();
            $table->boolean('verif_no_venc')->default(false);
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['cliente_codcli', 'titulo_id', 'txid']);
            $table->index('titulo_numTit');
            $table->index('titulo_numPrj');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cobrancas');
    }
};
