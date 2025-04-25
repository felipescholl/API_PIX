<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            // Campos obrigatórios
            $table->bigInteger('codCli')->primary(); // Código do cliente (chave primária)
            $table->string('nomCli', 100); // Nome do cliente
            $table->string('apeCli', 50); // Nome fantasia do cliente
            $table->enum('tipCli', ['J', 'F']); // Tipo do cliente: J = Jurídica, F = Física
            $table->enum('tipMer', ['I', 'E', 'P']); // Tipo de mercado: I = Interno, E = Externo, P = Prospect
            $table->enum('cliCon', ['S', 'N']); // Indicativo se o cliente é contribuinte de ICMS: S = Sim, N = Não
            $table->enum('sitCli', ['A', 'I']); // Situação do cliente: A = Ativo, I = Inativo
    //CodEmp
    //CodFil
    //codCpg
    //codFpg
    //codCpr
    //exiLcp
    //seqEnt
    //endEnt
    //cepIni
    //cepFin
    //nomCid
    
            // Campos opcionais
            $table->string('insEst', 25)->nullable(); // Inscrição estadual
            $table->string('insMun', 16)->nullable(); // Inscrição municipal
            $table->string('cgcCpf', 14)->nullable(); // CNPJ ou CPF
            $table->integer('zonFra')->nullable(); // Benefício fiscal (Zona Franca)
            $table->string('codSuf', 10)->nullable(); // Número do cliente na Suframa
            $table->string('endCli', 100)->nullable(); // Endereço do cliente
            $table->string('nenCli', 60)->nullable(); // Número do endereço
            $table->string('cplEnd', 20)->nullable(); // Complemento do endereço
            $table->string('cliPrx', 120)->nullable(); // Ponto de referência
            $table->string('zipCod', 14)->nullable(); // Código da cidade (ZIP CODE)
            $table->string('cepCli', 8)->nullable(); // CEP do cliente
            $table->string('cepIni', 8)->nullable(); // Faixa inicial do CEP
            $table->string('baiCli', 75)->nullable(); // Bairro do cliente
            $table->string('cidCli', 60)->nullable(); // Cidade do cliente
            $table->string('sigUfs', 2)->nullable(); // Sigla do estado
            $table->string('codPai', 4)->nullable(); // Código do país
            $table->string('fonCli', 20)->nullable(); // Telefone 1
            $table->string('fonCl2', 20)->nullable(); // Telefone 2
            $table->string('fonCl3', 20)->nullable(); // Telefone 3
            $table->string('fonCl4', 20)->nullable(); // Telefone 4
            $table->string('fonCl5', 20)->nullable(); // Telefone 5
            $table->string('faxCli', 20)->nullable(); // Fax
            $table->integer('cxaPst')->nullable(); // Caixa postal
            $table->string('intNet', 100)->nullable(); // E-mail
            $table->string('obsMot', 250)->nullable(); // Observação do motivo da situação
            $table->enum('triIcm', ['S', 'N'])->nullable(); // Tributação de ICMS: S = Sim, N = Não
            $table->enum('triIpi', ['S', 'N'])->nullable(); // Tributação de IPI: S = Sim, N = Não
            $table->enum('triPis', ['S', 'N'])->nullable(); // Tributação de PIS: S = Sim, N = Não
            $table->enum('triCof', ['S', 'N'])->nullable(); // Tributação de COFINS: S = Sim, N = Não
            $table->enum('retCof', ['S', 'N'])->nullable(); // Retenção de COFINS: S = Sim, N = Não
            $table->enum('retCsl', ['S', 'N'])->nullable(); // Retenção de CSLL: S = Sim, N = Não
            $table->enum('retPis', ['S', 'N'])->nullable(); // Retenção de PIS: S = Sim, N = Não
            $table->enum('retOur', ['S', 'N'])->nullable(); // Outras retenções: S = Sim, N = Não
            $table->enum('retPro', ['S', 'N'])->nullable(); // Retenção por produto: S = Sim, N = Não
            $table->enum('retIrf', ['S', 'N'])->nullable(); // Retenção de IRRF: S = Sim, N = Não
            $table->enum('calFun', ['S', 'N'])->nullable(); // Cálculo de Funrural: S = Sim, N = Não
            $table->enum('calSen', ['S', 'N'])->nullable(); // Cálculo de Senar: S = Sim, N = Não
            $table->string('emaNfe', 100)->nullable(); // E-mail para envio de NF-e
            $table->string('ideCli', 20)->nullable(); // Identificação do cliente
            $table->string('sigInt', 15)->nullable(); // Sigla do sistema integrado

            // Timestamps e soft deletes
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('codCli');
            $table->index('cgcCpf');
            $table->index('nomCli');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
