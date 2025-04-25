<?php

namespace App\Http\Controllers;

use App\Models\Cobranca;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Cobranca::query()->with('cliente');

        // Filtro por tipo de data e período
        if ($request->filled('tipo_data') && $request->filled('data_inicial')) {
            $campo_data = match($request->tipo_data) {
                'emissao' => 'cobrancas.created_at',
                'vencimento' => 'cobrancas.data_vencimento',
                'quitacao' => 'cobrancas.data_pagamento',
                default => 'cobrancas.created_at'
            };
            
            $query->whereDate($campo_data, '>=', $request->data_inicial);
        } 
        // else {
        //     $query->whereDate('cobrancas.created_at', '>=', Carbon::now()->startOfMonth());
        // }
        
        if ($request->filled('tipo_data') && $request->filled('data_final')) {
            $campo_data = match($request->tipo_data) {
                'emissao' => 'cobrancas.created_at',
                'vencimento' => 'cobrancas.data_vencimento',
                'quitacao' => 'cobrancas.data_pagamento',
                default => 'cobrancas.created_at'
            };
            
            $query->whereDate($campo_data, '<=', $request->data_final);
        } 
        // else {
        //     $query->whereDate('cobrancas.created_at', '<=', Carbon::now()->endOfMonth());
        // }
        
        // Filtro por status
        if ($request->filled('status')) {
            $query->where('cobrancas.status_pagamento', $request->status);
        }

        // Filtro por número do título
        if ($request->filled('titulo_numTit')) {
            $query->where('cobrancas.titulo_numTit', 'like', '%' . $request->titulo_numTit . '%');
        }

        // Filtro por status do Sapiens
        if ($request->filled('status_senior')) {
            $query->where('cobrancas.status_senior', 'like', '%' .$request->status_senior . '%');
        }

        // Filtro por CPF/CNPJ do cliente
        //deve trazer o campo cgcCpf da tabela Cliente atraves da cabranca.cliente_codCli

        if ($request->filled('cgcCpf')) {
            $cgcCpf = preg_replace('/[^0-9]/', '', $request->cgcCpf);
            $query->whereHas('cliente', function ($query) use ($cgcCpf) {
            $query->where('cgcCpf', 'like', '%' . $cgcCpf . '%');
            });
        }

        // // Filtro por nome do cliente
        // if ($request->filled('nome_cliente')) {
        //     $query->where('cobrancas.nome_pagador', 'like', '%' . $request->nome_cliente . '%');
        // }
        // Filtro por nome do cliente na tabela clientes
        if ($request->filled('nomCli')) {
            $query->whereHas('cliente', function ($query) use ($request) {
                $query->where('nomCli', 'like', '%' . $request->nomCli . '%');
            });
        }

        // Dados para os cards
        $totalCobrancas = (clone $query)->count();
        
        // Total recebido (usando valor para cobranças concluídas)
        $totalRecebido = (clone $query)
            ->where('cobrancas.status_pagamento', 'PAGO')
            ->sum('cobrancas.valor');
            
        // Total pendente (usando valor para cobranças ativas)
        $totalPendente = (clone $query)
            ->where('cobrancas.status_pagamento', 'ATIVO')
            ->sum('cobrancas.valor');

        // Cobranças paginadas para a tabela
        $cobrancas = $query
            ->orderBy('cobrancas.created_at', 'desc')
            ->paginate(20)
            ->withQueryString(); // Mantém os filtros na paginação

        return view('dashboard', compact(
            'cobrancas',
            'totalCobrancas',
            'totalRecebido',
            'totalPendente'
        ));
    }
}
