<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clientes = [
            [
                'nome' => 'João Silva',
                'email' => 'joao@email.com',
                'telefone' => '(11) 99999-9999',
                'cpf_cnpj' => '123.456.789-00',
                'endereco' => 'Rua das Flores, 123',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'cep' => '01234-567'
            ],
            [
                'nome' => 'Maria Santos',
                'email' => 'maria@email.com',
                'telefone' => '(11) 98888-8888',
                'cpf_cnpj' => '987.654.321-00',
                'endereco' => 'Av. Paulista, 1000',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'cep' => '04567-890'
            ],
            [
                'nome' => 'Empresa XYZ Ltda',
                'email' => 'contato@xyz.com',
                'telefone' => '(11) 3333-3333',
                'cpf_cnpj' => '12.345.678/0001-90',
                'endereco' => 'Rua do Comércio, 500',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'cep' => '08765-432'
            ]
        ];

        foreach ($clientes as $cliente) {
            Cliente::create($cliente);
        }
    }
}
