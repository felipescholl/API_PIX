<?php

namespace Tests\Unit\Services;

use App\Services\TratamentoWebhook;
use App\Services\PixService;
use App\Services\SeniorsService;
use Tests\TestCase;
use Mockery;

class TratamentoWebhookTest extends TestCase
{
    protected $tratamentoWebhook;
    protected $pixServiceMock;
    protected $seniorServiceMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pixServiceMock = Mockery::mock(PixService::class);
        $this->seniorServiceMock = Mockery::mock(SeniorsService::class);
        $this->tratamentoWebhook = new TratamentoWebhook(
            $this->pixServiceMock,
            $this->seniorServiceMock
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_processar_webhook_com_payload_valido()
    {
        // Mock do método processarPix para evitar acesso ao banco de dados
        $tratamentoWebhookMock = Mockery::mock(TratamentoWebhook::class, [
            $this->pixServiceMock, $this->seniorServiceMock
        ])->makePartial();
        
        $tratamentoWebhookMock->shouldReceive('processarPix')
            ->once()
            ->andReturn([
                'success' => true,
                'txid' => 'T12345',
                'mensagem' => 'PIX processado com sucesso'
            ]);

        $payload = [
            'pix' => [
                [
                    'endToEndId' => 'E12345',
                    'txid' => 'T12345',
                    'valor' => '100.00',
                    'horario' => '2024-03-25T10:00:00Z'
                ]
            ]
        ];

        $result = $tratamentoWebhookMock->processar($payload);

        $this->assertTrue($result['success']);
        $this->assertEquals('Webhook processado com sucesso', $result['message']);
    }

    public function test_processar_webhook_com_payload_invalido()
    {
        $payload = ['data' => 'invalid'];

        $result = $this->tratamentoWebhook->processar($payload);

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('array pix não encontrado', $result['message']);
    }

    public function test_processar_webhook_com_multiplos_pix()
    {
        // Mock do método processarPix para evitar acesso ao banco de dados
        $tratamentoWebhookMock = Mockery::mock(TratamentoWebhook::class, [
            $this->pixServiceMock, $this->seniorServiceMock
        ])->makePartial();
        
        $tratamentoWebhookMock->shouldReceive('processarPix')
            ->twice()
            ->andReturn(
                [
                    'success' => true,
                    'txid' => 'T12345',
                    'mensagem' => 'PIX processado com sucesso'
                ],
                [
                    'success' => true,
                    'txid' => 'T67890',
                    'mensagem' => 'PIX processado com sucesso'
                ]
            );

        $payload = [
            'pix' => [
                [
                    'endToEndId' => 'E12345',
                    'txid' => 'T12345',
                    'valor' => '100.00',
                    'horario' => '2024-03-25T10:00:00Z'
                ],
                [
                    'endToEndId' => 'E67890',
                    'txid' => 'T67890',
                    'valor' => '200.00',
                    'horario' => '2024-03-25T10:05:00Z'
                ]
            ]
        ];

        $result = $tratamentoWebhookMock->processar($payload);

        $this->assertTrue($result['success']);
        $this->assertCount(2, $result['resultados']);
    }
}