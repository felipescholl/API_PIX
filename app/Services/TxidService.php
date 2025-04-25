<?php

namespace App\Services;

use Illuminate\Support\Str;
use Carbon\Carbon;
use InvalidArgumentException;
use PhpParser\Node\Expr\AssignOp\Concat;

class TxidService
{
    const SYSTEM_SCR = 'SCR';
    const SYSTEM_SISCLAS = 'CLA';

    /**
     * Gera um TXID único de 35 caracteres
     * 
     * @param string $system_identifier CR ou CL
     * @param int $numTit Número do título
     * @param int $codCli Código do cliente
     * @param string $numPrj Número do projeto
     * @param float $amount Valor do título
     * @param string|null $date Data no formato Y-m-d (se null, usa a data atual)
     * @return string TXID gerado
     * @throws InvalidArgumentException
     */
    public static function generate(
        string $system_identifier,
        int $numTit,
        int $codCli,
        string $numPrj,
        float $amount,
        ?string $date // null para data atual
    ): string {
        // Validar o identificador do sistema
        if (!in_array($system_identifier, [self::SYSTEM_SCR, self::SYSTEM_SISCLAS])) {
            throw new InvalidArgumentException('E-Api-TXID-001: O identificador do sistema deve ser SCR ou CLA');
        }

        // Validar valor
        if ($amount <= 0) {
            throw new InvalidArgumentException('E-Api-TXID-003: O valor deve ser maior que zero');
        }

        // Validar data
        if ($date === null) {
            throw new InvalidArgumentException('E-Api-TXID-004: A data não pode ser nula');
        } elseif (!strtotime($date)) {
            throw new InvalidArgumentException('E-Api-TXID-004: Data inválida');
        }

        // Converter a data para o formato necessário
        $date = $date ? date('ymd', strtotime($date)) : date('ymd');

        // Timestamp
        $timestamp = date('YmdHis');

        // Converter o valor para centavos e formatar como inteiro
        $amount_cents = (int) ($amount * 100);

        $operation = 'C' . $codCli . 'P' . $numPrj;

        // Contador autoincremental com reset diário para garantir TXID único
        $counterKey = 'txid_counter_' . date('Ymd');
        $counter = cache()->increment($counterKey);

        if ($counter === 1) {
            cache()->put($counterKey, $counter, now()->addDay());
        }
        
        $formatted_counter = str_pad($counter, 2, '0', STR_PAD_LEFT); 

        // Formatar cada parte do TXID
        $formatted_numTit = str_pad($numTit, 9, '0', STR_PAD_LEFT);

        // Montar o TXID base
        $txidBase = $system_identifier . $formatted_numTit . $operation . 'T' . $date . $formatted_counter;

        // Adicionar caracteres aleatórios para completar 26 caracteres se necessário
        $txid = str_pad($txidBase, 26, Str::random(), STR_PAD_RIGHT);
        
        // Validar o tamanho final
        if (strlen($txid) > 35 || strlen($txid) < 26) {
            throw new InvalidArgumentException(
                'E-Api-TXID-002: TXID gerado com tamanho inválido. Atual: ' . strlen($txid)
            );
        }

        return strtoupper($txid);
    }
}