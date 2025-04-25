<?php

namespace Tests\Unit\Services;

use App\Services\TxidService;
use Tests\TestCase;
use InvalidArgumentException;

class TxidServiceTest extends TestCase
{
    public function test_generate_txid_com_parametros_validos()
    {
        $txid = TxidService::generate(
            'SCR',
            12345,
            67890,
            'PRJ001',
            100.50,
            '2024-03-25'
        );

        $this->assertIsString($txid);
        $this->assertGreaterThanOrEqual(26, strlen($txid));
        $this->assertLessThanOrEqual(35, strlen($txid));
        $this->assertMatchesRegularExpression('/^[a-zA-Z0-9]+$/', $txid);
    }

    public function test_generate_txid_sem_data()
    {
        $this->expectException(InvalidArgumentException::class);
        
        TxidService::generate(
            'SCR',
            12345,
            67890,
            'PRJ001',
            100.50,
            null
        );
    }

    public function test_generate_txid_com_valor_zero()
    {
        $this->expectException(InvalidArgumentException::class);

        TxidService::generate(
            'SCR',
            12345,
            67890,
            'PRJ001',
            0,
            '2024-03-25'
        );
    }

    public function test_generate_txid_com_valor_negativo()
    {
        $this->expectException(InvalidArgumentException::class);

        TxidService::generate(
            'SCR',
            12345,
            67890,
            'PRJ001',
            -100.50,
            '2024-03-25'
        );
    }

    public function test_generate_txid_com_sistema_invalido()
    {
        $this->expectException(InvalidArgumentException::class);

        TxidService::generate(
            'INVALID',
            12345,
            67890,
            'PRJ001',
            100.50,
            '2024-03-25'
        );
    }
}