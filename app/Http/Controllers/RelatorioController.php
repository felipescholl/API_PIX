<?php

namespace App\Http\Controllers;

use App\Models\Cobranca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{
    public function index()
    {
        $dadosGrafico = Cobranca::select(
            DB::raw('DATE(created_at) as data'),
            DB::raw('COUNT(*) as total_cobrancas'),
            DB::raw('SUM(valor) as valor_total'),
            DB::raw('SUM(CASE WHEN status = "CONCLUIDA" THEN valor ELSE 0 END) as valor_recebido')
        )
        ->groupBy('data')
        ->orderBy('data')
        ->get();

        $resumo = [
            'total_cobrancas' => Cobranca::count(),
            'valor_total' => Cobranca::sum('valor'),
            'valor_recebido' => Cobranca::where('status', 'CONCLUIDA')->sum('valor'),
            'valor_pendente' => Cobranca::where('status', 'ATIVA')->sum('valor')
        ];

        return view('relatorios.index', compact('dadosGrafico', 'resumo'));
    }

    public function gerarRelatorio(Request $request)
    {
        $dataInicial = $request->input('data_inicial');
        $dataFinal = $request->input('data_final');
        $status = $request->input('status');

        $query = Cobranca::with('cliente')
            ->when($dataInicial, function($q) use ($dataInicial) {
                return $q->whereDate('created_at', '>=', $dataInicial);
            })
            ->when($dataFinal, function($q) use ($dataFinal) {
                return $q->whereDate('created_at', '<=', $dataFinal);
            })
            ->when($status, function($q) use ($status) {
                return $q->where('status', $status);
            });

        $cobrancas = $query->get();
        $totais = [
            'valor_total' => $cobrancas->sum('valor'),
            'valor_recebido' => $cobrancas->where('status', 'CONCLUIDA')->sum('valor'),
            'valor_pendente' => $cobrancas->where('status', 'ATIVA')->sum('valor')
        ];

        return view('relatorios.resultado', compact('cobrancas', 'totais'));
    }
}
