<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TratamentoWebhook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * Controlador responsável por receber e processar webhooks do Sicredi para o sistema PIX
 *
 * Esta classe gerencia o recebimento de notificações de pagamento PIX enviadas pelo Sicredi,
 * valida o payload recebido e encaminha para processamento no serviço TratamentoWebhook.
 * Implementa validações de formato e conteúdo do payload JSON e tratamento de erros.
 *
 * @package App\Http\Controllers\Api
 */
class WebhookController extends Controller
{
    /**
     * Instância do serviço responsável pelo processamento dos webhooks
     *
     * @var \App\Services\TratamentoWebhook
     */
    protected $tratamentoWebhook;

    /**
     * Construtor do controlador
     *
     * @param \App\Services\TratamentoWebhook $tratamentoWebhook Serviço de processamento de webhooks
     */
    public function __construct(TratamentoWebhook $tratamentoWebhook)
    {
        $this->tratamentoWebhook = $tratamentoWebhook;
    }

    /**
     * Processa webhooks recebidos do Sicredi
     *
     * Este método recebe as notificações de pagamento PIX enviadas pelo Sicredi,
     * valida o formato e conteúdo do payload JSON e encaminha para processamento.
     * Implementa logs detalhados para facilitar o rastreamento e depuração.
     *
     * Códigos de log:
     * - L-Api-WH-001: Log informativo do payload recebido
     * - L-Api-WH-002: Aviso de payload vazio
     * - L-Api-WH-003: Aviso de JSON inválido
     * - L-Api-WH-004: Erro ao processar o webhook
     *
     * @param \Illuminate\Http\Request $request Requisição HTTP contendo o payload do webhook
     * @return \Illuminate\Http\JsonResponse Resposta JSON com o resultado do processamento ou mensagem de erro
     */
    public function handleSicrediWebhook(Request $request)
    {
        try {
            // Define o cabeçalho para aceitar JSON
            header("Content-Type: application/json");

            // Lê o conteúdo da requisição
            $payload = $request->getContent();

            // Log do payload recebido
            Log::info('L-Api-WH-001: Webhook Sicredi - Payload recebido', [
                'payload' => $payload,
                'ip' => $request->ip(),
                'headers' => $request->headers->all()
            ]);

            // Verifica se o payload está vazio
            if (empty($payload)) {
                Log::warning('L-Api-WH-002: Webhook Sicredi - Payload vazio');
                return response()->json([
                    'error' => 'Payload vazio'
                ], 400);
            }

            // Decodifica o JSON
            $data = json_decode($payload, true);

            // Verifica se o JSON é válido
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::warning('L-Api-WH-003: Webhook Sicredi - JSON inválido', [
                    'error' => json_last_error_msg()
                ]);
                return response()->json([
                    'error' => 'Payload inválido'
                ], 400);
            }

            // Processa o webhook
            $resultado = $this->tratamentoWebhook->processar($data);

            return response()->json($resultado);

        } catch (Exception $e) {
            Log::error('L-Api-WH-004: Webhook Sicredi - Erro ao processar', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Erro ao processar webhook: ' . $e->getMessage()
            ], 500);
        }
    }
}