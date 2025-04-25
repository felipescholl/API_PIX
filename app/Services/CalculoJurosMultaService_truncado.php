<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Titulo;
use Illuminate\Support\Facades\Log;

class CalculoJurosMultaService
{
    /**
     * Calcula juros e multa para um título em atraso
     *
     * @param Titulo $titulo
     * @param Carbon|null $dataPagamento
     * @return array
     */
    public function calcular(Titulo $titulo, ?Carbon $dataPagamento = null, $valorPix)
    {
        $dataPagamento = $dataPagamento ?? Carbon::now();
        $dataVencimento = $titulo->vctOri;
        
        $proximoDiaUtil = BusinessDayBrazilCarbon::adjustDueDate($dataVencimento);
        
        // Se não estiver em atraso, retorna zero
        if ($dataPagamento->lessThanOrEqualTo($proximoDiaUtil)) {
            return [
                'vlrOri' => $titulo->vlrOri,
                'vlrJrs' => 0,
                'vlrMul' => 0,
                'diasAtraso' => 0,
                'valorTotal' => $titulo->vlrOri
            ];
        }
        
        // Calcula dias de atraso
        $diasAtraso = $dataPagamento->diffInDays($dataVencimento);
        
        // Verifica tolerância para juros
        $diasJuros = max(0, $diasAtraso - ($titulo->tolJrs ?? 0));
        
        // Verifica tolerância para multa
        $aplicarMulta = $diasAtraso > ($titulo->tolMul ?? 0);
        
        // Calcula juros
        $vlrJrs = 0;
        
        if ($diasJuros > 0 && $titulo->perJrs > 0) {
            // Implementação da fórmula: Vj = (Vo - Va) × ((Ij/100)/n) × Dα
            // Onde:
            // Vo: valor original da cobrança ($titulo->vlrOri)
            // Va: valor de abatimento (considerando 0 neste caso)
            // Ij: taxa de juros percentual ($titulo->perJrs)
            // n: 30 (considerando taxa mensal)
            // Dα: dias de atraso ($diasJuros)
            
            // Valor original menos abatimento
            $valorBase = (string)$titulo->vlrOri; // Va é zero neste caso
            
            // Cálculo do fator de juros ((Ij/100)/n) com precisão de 6 casas decimais sem arredondamento
            
            $taxaJuros = (string)$titulo->perJrs;
            $fatorJuros = bcmul(bcdiv(bcdiv($taxaJuros, '100', 10), '30', 10), (string)$diasJuros, 10); // Considerando taxa mensal (n=30)
            
            // Truncar para 6 casas decimais sem arredondamento
            $fatorJuros = substr($fatorJuros, 0, strpos($fatorJuros, '.') + 7);
            
            // Multiplicação pelo número de dias de atraso
            $vlrJrs = bcmul($valorBase, $fatorJuros, 6);
            
            // Converter para float para continuar com o processamento
            $vlrJrs = (float)$vlrJrs;
        } elseif ($diasJuros > 0 && $titulo->jrsDia > 0) {
            // Se tiver valor fixo de juros por dia
            $vlrJrs = $titulo->jrsDia * $diasJuros;
        }
        
        // Calcula multa
        $vlrMul = 0;
        if ($aplicarMulta && $titulo->perMul > 0) {
            $vlrMul = $titulo->vlrOri * ($titulo->perMul / 100);
        }
        // print_r($vlrJrs);
        // print_r('-');
        // print_r($vlrMul);
        // Truncate values to 2 decimal places
        $vlrJrs = number_format($vlrJrs, 2, '.', '');
        $vlrMul = number_format($vlrMul, 2, '.', '');

        // Log::info('L-JMS-001: Webhook Sicredi - CalculoJurosMultaService', [
        //     'dataPagamento' => $dataPagamento,
        //     'dataVenciemnto' => $dataVencimento,
        //     'proximoDiaUtil' => $proximoDiaUtil,
        //     'aplicaMulta' => $aplicarMulta,
        //     'fatorJuros' => $fatorJuros,
        //     'taxaJuros' => $taxaJuros,
        //     'taxaMulta' => $titulo->perMul,
        //     'vlrJrs' => $vlrJrs,
        //     'vlrMul' => $vlrMul,
        //     'diasAtraso' => $diasAtraso,
        //     'valorTotal' => $valorPix
        // ]);

        $valorTotal = $titulo->vlrOri + $vlrJrs + $vlrMul;

        // Verifica se valorTotal é igual ao valor pago
        if ($valorTotal != $valorPix) {
            Log::warning('L-JMS-001: Webhook Sicredi - Valor total diferente do valor pago', [
                'valorTotal calculado: ' => $valorTotal,
                'valorPix recebido: ' => $valorPix,
                'titulo: ' => $titulo->numTit
            ]);
            $valorTotal = $valorPix;
        }
        
        return [
            'vlrOri' => $titulo->vlrOri,
            'vlrJrs' => $vlrJrs,
            'vlrMul' => $vlrMul,
            'diasAtraso' => $diasAtraso,
            'valorTotal' => $valorTotal
        ];
    }
}