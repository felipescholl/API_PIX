<?php

namespace Tests\Unit\Services;

use App\Services\PixService;
use Tests\TestCase;
use Mockery;
use DateTime;

class PixServiceTest extends TestCase
{
    protected $pixService;
    protected $apiMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->apiMock = Mockery::mock('Crmdesenvolvimentos\PixSicredi\Api');
        $this->pixService = new PixService();
        $this->pixService->setApi($this->apiMock);

        // Mock config values
        config(['pix.client_id' => 'test_client_id']);
        config(['pix.client_secret' => 'test_client_secret']);
        config(['pix.certificate' => 'test_certificate']);
        config(['pix.key' => 'test_key']);
        config(['pix.chave' => 'test_chave']);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_gerar_cobranca_com_dados_validos()
    {
        $dados = [
            'vctOri' => '2024-12-31',
            'valor' => 100.50,
            'numTit' => '12345',
            'codCli' => '67890',
            'numPrj' => 'PRJ001',
            'txid' => 'TEST12345678911234567890123456789',
            'nome_pagador' => 'Cliente Teste',
            'solicitacao_pagador' => 'Pagamento de teste',
            'documento_pagador' => '12345678901',
            'validade_apos_vencimento' => 30
        ];

        $cobvMock = Mockery::mock('Crmdesenvolvimentos\\PixSicredi\\Resources\\Cobv');
        $requestMock = Mockery::mock('stdClass');
        $responseMock = Mockery::mock('stdClass');
        
        $responseData = [
            'qrcode' => 'base64_encoded_qrcode',
            'pixCopiaECola' => 'pix_copy_paste_code',
            'txid' => 'generated_txid',
            'status' => 'ATIVA',
            'calendario' => [],
            'revisao' => 0,
            'devedor' => [],
            'recebedor' => [],
            'loc' => [],
            'location' => '',
            'valor' => ['original' => '100.50'],
            'chave' => 'chave-pix',
            'solicitacaoPagador' => 'Pagamento de teste'
        ];
        
        $this->apiMock->shouldReceive('requestToken')->once()->andReturn($this->apiMock);
        $this->apiMock->shouldReceive('cobv')->once()->andReturn($cobvMock);
        
        $cobvMock->shouldReceive('setChave')->once()->andReturn($cobvMock);
        $cobvMock->shouldReceive('setTxId')->once()->andReturn($cobvMock);
        $cobvMock->shouldReceive('setValor')->once()->andReturn($cobvMock);
        $cobvMock->shouldReceive('setNome')->once()->andReturn($cobvMock);
        $cobvMock->shouldReceive('setSolicitacaoPagador')->once()->andReturn($cobvMock);
        $cobvMock->shouldReceive('setDataVencimento')->once()->andReturn($cobvMock);
        $cobvMock->shouldReceive('setValidadeVencimento')->once()->andReturn($cobvMock);
        $cobvMock->shouldReceive('setCpf')->once()->andReturn($cobvMock);
        $cobvMock->shouldReceive('create')->once()->andReturn($cobvMock);
        
        $cobvMock->request = $requestMock;
        $requestMock->response = $responseMock;
        $responseMock->shouldReceive('getData')->once()->andReturn($responseData);
        
        // Mock para o GeradorCode
        $geradorCodeMock = Mockery::mock('alias:App\\Services\\GeradorCode');
        $geradorCodeMock->shouldReceive('qrcode')->once()->andReturn('qrcode_base64');
        
        $result = $this->pixService->gerarCobranca($dados);
        
        $this->assertIsArray($result);
        $this->assertArrayHasKey('status', $result);
        $this->assertEquals('ATIVA', $result['status']);
    }

    public function test_gerar_cobranca_com_data_invalida()
    {
        $this->expectException(\Exception::class);

        $dados = [
            'vctOri' => 'data-invalida',
            'valor' => 100.50,
            'numTit' => '12345',
            'codCli' => '67890',
            'numPrj' => 'PRJ001',
            'txid' => 'TEST12345',
            'nome_pagador' => 'Cliente Teste',
            'solicitacao_pagador' => 'Pagamento de teste',
            'documento_pagador' => '12345678901',
            'validade_apos_vencimento' => 30
        ];

        $this->pixService->gerarCobranca($dados);
    }

    public function test_gerar_cobranca_com_valor_zero()
    {
        $this->expectException(\InvalidArgumentException::class);

        $dados = [
            'vctOri' => '2024-12-31',
            'valor' => 0,
            'numTit' => '12345',
            'codCli' => '67890',
            'numPrj' => 'PRJ001',
            'txid' => 'TEST12345',
            'nome_pagador' => 'Cliente Teste',
            'solicitacao_pagador' => 'Pagamento de teste',
            'documento_pagador' => '12345678901',
            'validade_apos_vencimento' => 30
        ];

        $this->pixService->gerarCobranca($dados);
    }
}
