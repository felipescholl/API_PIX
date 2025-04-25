<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cobranca_id')->nullable()->constrained();
            $table->foreignId('titulo_id')->constrained();
            $table->string('tipo')->nullable();
            $table->enum('status', ['SUCESSO', 'ERRO']);
            $table->text('descricao');
            $table->json('dados_adicionais')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['cobranca_id', 'titulo_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('transacoes');
    }
};
