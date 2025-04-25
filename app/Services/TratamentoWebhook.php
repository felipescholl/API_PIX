<?php

namespace App\Services;

use App\Mail\ErrorNotification;
use App\Models\Cobranca;
use App\Models\Transacao;
use App\Services\SeniorsService;
use App\Services\PixService;
use Illuminate\Support\Facades\Log;
use Exception;
use Carbon\Carbon;
use Crmdesenvolvimentos\PixSicredi\Resources\Cob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

/**
 * Classe responsável pelo tratamento de webhooks PIX.
 *
 * Esta classe processa os dados recebidos via webhook, atualiza o status das cobranças
 * e envia callbacks para sistemas de origem. Utiliza os serviços PixService e SeniorsService
 * para realizar operações relacionadas ao PIX e ao sistema SAPIENS.
 */
class TratamentoWebhook
{
    protected $pixService;
    protected $seniorService;

    /**
     * Construtor da classe TratamentoWebhook.
     *
     * @param PixService $pixService Serviço para operações relacionadas ao PIX.
     * @param SeniorsService $seniorService Serviço para operações relacionadas ao sistema SAPIENS.
     */
    public function __construct(PixService $pixService, SeniorsService $seniorService)
    {
        $this->pixService = $pixService;
        $this->seniorService = $seniorService;
    }

    /**
     * Processa o payload recebido via webhook.
     *
     * Este método valida o payload, processa cada item PIX contido nele e retorna o resultado do processamento.
     *
     * @param array $payload Dados recebidos via webhook.
     * @return array Resultado do processamento do webhook.
     * @throws Exception Se ocorrer um erro durante o processamento.
     */
    public function processar($payload)
    {
        try {
            //Log::info('L-Api-TWH-001: Processando webhook Sicredi', $payload);

            // Validar se existe o array pix
            if (!isset($payload['pix']) || !is_array($payload['pix'])) {
                return [
                    'success' => false,
                    'message' => 'E-Api-TWH-002: Payload inválido: array pix não encontrado'
                ];
            }

            $resultados = [];

            foreach ($payload['pix'] as $pix) {
                $resultados[] = $this->processarPix($pix);
            }

            return [
                'success' => true,
                'message' => 'Webhook processado com sucesso',
                'resultados' => $resultados
            ];

        } catch (Exception $e) {
            Log::error('L-Api-TWH-003: Erro ao processar webhook: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Erro ao processar webhook: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Processa um único item PIX do payload.
     *
     * Este método valida os dados do PIX, atualiza a cobrança correspondente e registra a transação.
     *
     * @param array $pix Dados do PIX a serem processados.
     * @return array Resultado do processamento do PIX.
     * @throws Exception Se os dados do PIX estiverem incompletos ou ocorrer um erro durante o processamento.
     */
    protected function processarPix($pix)
    {
        try { 
            
            // Validar dados do PIX
            if (!isset($pix['txid']) || !isset($pix['endToEndId']) || !isset($pix['valor']) || !isset($pix['horario'])) {
                throw new Exception('E-Api-TWH-004: Dados do PIX incompletos');
            }

            // Buscar cobrança
            $cobranca = Cobranca::where('txid', $pix['txid'])->firstOrFail();

            // Verificar se a cobrança já foi processada para não gerar erro no status da Sênior
            if ($cobranca->status_pagamento === Cobranca::PAGAMENTO_PAGO && $cobranca->status_senior === Cobranca::SENIOR_REGISTRADO) {
                return [
                    'success' => true,
                    'txid' => $pix['txid'],
                    'mensagem' => 'PIX já processado'
                ];
            }

            // Calcular juros e multa
            $calculoService = new CalculoJurosMultaService;
            $dataPagamento = Carbon::parse($pix['horario']);
            $calculos = $calculoService->calcular($cobranca->titulo, $dataPagamento, $pix['valor']);
    print_r($calculos);
    exit;
            // Atualizar cobrança
            $cobrancaAtualizada = $cobranca->update([
                'status_pagamento' => Cobranca::PAGAMENTO_PAGO,
                'data_pagamento' => Carbon::parse($pix['horario'])->setTimezone('America/Sao_Paulo'),
                'endToEndId' => $pix['endToEndId'],
            ]);


            // Atualizar título
            $cobranca->titulo->update([
                'sitTit' => 'LQ',
                'datPgt' => Carbon::parse($pix['horario'])->setTimezone('America/Sao_Paulo'), //  'Data do pagamento/baixa do título'
                'datMov' => Carbon::parse($pix['horario'])->setTimezone('America/Sao_Paulo'), // 'Data do movimento do título'
                //'ideTxi' => $pix['txid'], // 'Id. Transação PIX'
                //'msgPag' => $pix['infoPagador'] ?? 'Pagamento Pix', // 'Mensagem do Pagador Final'
                'vlrMov' => $calculos['vlrOri'], // 'Valor do movimento do título'
                'vlrJrs' => $calculos['vlrJrs'],
                'vlrMul' => $calculos['vlrMul'],
                'vlrLiq' => $calculos['valorTotal'],
                'diaAtr' => $calculos['diasAtraso'],
                'diaJrs' => $calculos['diasAtraso'],
                // TODO - Adicionar mais dados que devem ser informados quando do pagamento, Valor líquido do movimento do título:, Dias de atraso no pagamento do título:, Dias de atraso para efeito de juros:, encargos, acrescimos, descontos
            ]);

            
            // Registrar transação
            if ($cobrancaAtualizada) {
                $cobranca->transacoes()->create([
                    'cobranca_id' => $cobranca->id,
                    'titulo_id' => $cobranca->titulo_id,
                    'tipo' => Transacao::TIPO_PAGAMENTO,
                    'status' => Transacao::STATUS_SUCESSO,
                    'descricao' => 'Webhook PIX recebido',
                ]);
            } else {
                $cobranca->transacoes()->create([
                    'cobranca_id' => $cobranca->id,
                    'titulo_id' => $cobranca->titulo_id,
                    'tipo' => Transacao::TIPO_PAGAMENTO,
                    'status' => Transacao::STATUS_ERRO,
                    'descricao' => 'Erro ao registrar pagamento no SAPIENS: ',
                    'dados_adicionais' => $cobrancaCriada['erro'] ?? null,
                ]);
            }

            // Registrar pagamento no SAPIENS
            $resultadoSapiens = $this->seniorService->registrarBaixa([
                'tipoBaixa' => 'pagamento',
                'codEmp' => $cobranca->titulo->codEmp,
                'codFil' => $cobranca->titulo->codFil,
                'numTit' => $cobranca->titulo->numTit,
                'codTpt' => $cobranca->titulo->codTpt,
                'numCco' => $cobranca->titulo->numCco,  // TODO - Precisa ver quem informa este código 01, 99 (para cliente 512 numCco = 1118-5) Movimento de fluxo de caixa entra na rubrica da Ascar geral.
                'txid' => $pix['txid'],
                    'vlrMov' => $calculos['vlrOri'], // 'Valor do movimento do título'
                    'vlrJrs' => $calculos['vlrJrs'],
                    'vlrMul' => $calculos['vlrMul'],
                    'vlrLiq' => $calculos['valorTotal'],
                    'diaAtr' => $calculos['diasAtraso'],
                    'diaJrs' => $calculos['diasAtraso'],
                'dataPagamento' => $pix['horario'],
                'endToEndId' => $pix['endToEndId'],
                'numDoc' => $cobranca->titulo->numDoc,
                'codTns' => 90350
            ]);

            // Enviar webhook de callback para o sistema de origem
            $this->enviarWebhookCallback($cobranca, $pix, $resultadoSapiens);
            
            if ($resultadoSapiens) {
                $cobranca->transacoes()->create([
                    'cobranca_id' => $cobranca->id,
                    'titulo_id' => $cobranca->titulo_id,
                    'tipo' => Transacao::TIPO_REG_PAGAMENTO,
                    'status' => Transacao::STATUS_SUCESSO,
                    'descricao' => 'Pagamento registrado no SAPIENS',
                ]);
                $cobranca->update([
                    'status_senior' => Cobranca::SENIOR_REGISTRADO,
                    'msg_senior' => json_encode($resultadoSapiens['status'] ?? '')
                ]);
                

            } else {
                $cobranca->transacoes()->create([
                    'cobranca_id' => $cobranca->id,
                    'titulo_id' => $cobranca->titulo_id,
                    'tipo' => Transacao::TIPO_REG_PAGAMENTO,
                    'status' => Transacao::STATUS_ERRO,
                    'descricao' => 'Erro retorno ao registrar pagamento no SAPIENS',
                    'dados_adiconais' => $resultadoSapiens['erro'] ?? null,
                ]);

                $cobranca->update([
                    'status_senior' => Cobranca::SENIOR_ERRO,
                ]);
            }


            return [
                'success' => true,
                'txid' => $pix['txid'],
                'mensagem' => 'PIX processado com sucesso',
                'sapiens' => $resultadoSapiens
            ];

        } catch (Exception $e) {
            Log::error('L-Api-TWH-005: Erro ao processar PIX', [
                'error' => $e->getMessage(),
                'pix' => $pix
            ]);

            // Se encontrou a cobrança, marca como não registrada no SAPIENS
            if (isset($cobranca)) {
                $cobranca->update([
                    'status_senior' => Cobranca::SENIOR_ERRO,
                    'msg_senior' => $e->getMessage()
                ]);
                $cobranca->transacoes()->create([
                    'cobranca_id' => $cobranca->id,
                    'titulo_id' => $cobranca->titulo_id,
                    'tipo' => Transacao::TIPO_PAGAMENTO,
                    'status' => Transacao::STATUS_ERRO,
                    'descricao' => 'Erro ao registrar pagamento no SAPIENS',
                    'dados_adicionais' => $e->getMessage()
                ]);
            }

            // Enviar e-mail em caso de erro
            $details = [
                'tipo_erro' => 'Erro ao processar PIX',
                'error' => $e->getMessage(),
                'txid' => $pix['txid'] ?? 'N/A',
                'endToEndId' => $pix['endToEndId'] ?? 'N/A',
                'horario' => $pix['horario'] ?? 'N/A',
                'valor' => $pix['valor'] ?? 'N/A',
            ];

            if(Mail::to(config('services.admin.email'))->send(new ErrorNotification($details))) {
                log::info('L-Api-TWH-Mail: Email enviado com sucesso', $details);
            }

            return [
                'success' => false,
                'txid' => $pix['txid'] ?? 'N/A',
                'erro' => $e->getMessage()
            ];
        }
    }

    /**
     * Envia um webhook de callback para o sistema de origem.
     *
     * Este método envia um webhook de callback para o sistema de origem, informando o resultado do processamento do PIX.
     *
     * @param Cobranca $cobranca A cobrança associada ao PIX.
     * @param array $pix Os dados do PIX.
     * @param array $resultadoSapiens O resultado do registro no SAPIENS.
     * @return bool Retorna true se o webhook foi enviado com sucesso, false caso contrário.
     */
    protected function enviarWebhookCallback($cobranca, $pix, $resultadoSapiens)
    {
        try {
            // Verificar se existe sistema de origem
            if (empty($cobranca->sistema_origem)) {
                Log::info('L-Api-TWH-006: Sistema de origem não definido para a cobrança', [
                    'txid' => $pix['txid']
                ]);
                return false;
            }
            
            // Determinar qual sistema de origem para enviar o callback
            $sistemaOrigem = strtolower($cobranca->sistema_origem);
            
            // Verificar se o sistema é SCR ou SISCLAS
            if ($sistemaOrigem === 'SCR') {
                $configWebhook = config('webhooks.scr');
            } elseif ($sistemaOrigem === 'CLA') {
                $configWebhook = config('webhooks.sisclas');
            } else {
                Log::warning('L-Api-TWH-007: Sistema de origem desconhecido', [
                    'sistema' => $sistemaOrigem,
                    'txid' => $pix['txid']
                ]);
                return false;
            }
            
            // Verificar se existe URL de callback configurada
            if (empty($configWebhook['callback_url'])) {
                Log::warning('L-Api-TWH-008: URL de callback não configurada para o sistema ' . $sistemaOrigem);
                return false;
            }
            
            // Preparar dados para enviar ao sistema de origem
            $dadosCallback = [
                'txid' => $pix['txid'],
                'endToEndId' => $pix['endToEndId'],
                'valor' => $pix['valor'],
                'horario' => $pix['horario'],
                'status' => 'PAGO',
                'data_pagamento' => $cobranca->data_pagamento,
                'titulo_numTit' => $cobranca->titulo_numTit,
                'titulo_numPrj' => $cobranca->titulo_numPrj,
                'sapiens_status' => $cobranca->status_senior
            ];
            
            // Adicionar assinatura se configurada
            if (!empty($configWebhook['secret'])) {
                $dadosCallback['signature'] = hash_hmac('sha256', json_encode($dadosCallback), $configWebhook['secret']);
            }
            
            // Configurar timeout
            $timeout = $configWebhook['timeout'] ?? 30;
            
            // Enviar webhook via HTTP POST
            $client = new \GuzzleHttp\Client(['timeout' => $timeout]);
            $response = $client->post($configWebhook['callback_url'], [
                'json' => $dadosCallback,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'User-Agent' => 'PIX-Webhook-Callback/1.0'
                ]
            ]);
                Log::info('L-Api-TWH-009: Callback enviado com sucesso para '. $sistemaOrigem, [
                    'response_code' => $response->getStatusCode(),
                    'response_body' => (string) $response->getBody()
                ]);
            // Registrar transação de callback
            $cobranca->transacoes()->create([
                'cobranca_id' => $cobranca->id,
                'titulo_id' => $cobranca->titulo_id,
                'tipo' => Transacao::TIPO_CALLBACK,
                'status' => Transacao::STATUS_SUCESSO,
                'descricao' => 'Callback enviado para ' . $sistemaOrigem,
                'dados_adicionais' => json_encode([
                    'url' => $configWebhook['callback_url'],
                    'response_code' => $response->getStatusCode(),
                    'response_body' => (string) $response->getBody()
                ])
            ]);
            
            Log::info('L-Api-TWH-009: Callback enviado com sucesso para ' . $sistemaOrigem, [
                'txid' => $pix['txid'],
                'status_code' => $response->getStatusCode()
            ]);
            
            return true;
            
        } catch (\Exception $e) {
            // Registrar erro na transação
            if (isset($cobranca)) {
                $cobranca->transacoes()->create([
                    'cobranca_id' => $cobranca->id,
                    'titulo_id' => $cobranca->titulo_id,
                    'tipo' => Transacao::TIPO_CALLBACK,
                    'status' => Transacao::STATUS_ERRO,
                    'descricao' => 'Erro ao enviar callback',
                    'dados_adicionais' => $e->getMessage()
                ]);
            }
            
            Log::error('L-Api-TWH-010: Erro ao enviar callback', [
                'error' => $e->getMessage(),
                'txid' => $pix['txid'] ?? 'N/A'
            ]);
            
            return false;
        }
    }
}