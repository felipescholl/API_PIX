<?php

namespace App\Services;

use App\Models\Cobranca;
use App\Models\Transacao;
use Crmdesenvolvimentos\PixSicredi\Api;
use Illuminate\Support\Facades\Log;
use Exception;
use DateTime;
use App\Services\GeradorCode;

/**
 * Classe responsável pela integração com a API PIX do Sicredi
 * 
 * Esta classe gerencia todas as operações relacionadas ao PIX, incluindo
 * geração de cobranças, consulta, cancelamento e validação de webhooks.
 * Utiliza a biblioteca Crmdesenvolvimentos\PixSicredi\Api para comunicação com o PSP.
 */
class PixService
{
    /**
     * Instância da API do Sicredi para comunicação com o PSP
     * 
     * @var \Crmdesenvolvimentos\PixSicredi\Api
     */
    protected $api;

    /**
     * Inicializa a instância da API do Sicredi com as configurações necessárias
     * 
     * Configura a API com as credenciais e certificados obtidos do arquivo de configuração.
     * Este método é chamado automaticamente pelo construtor ou pode ser chamado manualmente
     * quando necessário reinicializar a API.
     * 
     * @return \Crmdesenvolvimentos\PixSicredi\Api Instância configurada da API
     */
    protected function initApi()
    {
        if (!$this->api) {
            $this->api = (new Api)
                ->setClientId(config('pix.client_id'))
                ->setClientSecret(config('pix.client_secret'))
                ->setCertificadoPsp(base_path(config('pix.certificate')))
                ->setCertificadoAplicacao(base_path(config('pix.key')))
                ->setPasswordCertificadoAplicacao('')
                ->setCertificadoCadeiaCompleta(base_path(config('pix.cadeiaCompleta')));
        }
        return $this->api;
    }

    /**
     * Define uma instância personalizada da API
     * 
     * Permite injetar uma instância da API já configurada, útil para testes
     * ou para configurações personalizadas.
     * 
     * @param \Crmdesenvolvimentos\PixSicredi\Api $api Instância da API a ser utilizada
     * @return $this Retorna a própria instância para encadeamento de métodos
     */
    public function setApi($api)
    {
        $this->api = $api;
        return $this;
    }

    /**
     * Construtor da classe
     * 
     * Inicializa a instância da API do Sicredi automaticamente ao criar
     * uma nova instância desta classe.
     */
    public function __construct()
    {
        $this->initApi();
    }

    /**
     * Gera uma cobrança PIX com vencimento (COBV)
     * 
     * Este método cria uma cobrança PIX com vencimento através da API do Sicredi.
     * Valida os dados de entrada, formata a data de vencimento, autentica com o PSP,
     * cria a cobrança e retorna os dados da cobrança incluindo o QR Code gerado.
     * 
     * @param array $dados Array associativo contendo os dados da cobrança:
     *                      - vctOri: Data de vencimento no formato Y-m-d
     *                      - valor: Valor da cobrança (deve ser maior que zero)
     *                      - txid: Identificador da transação
     *                      - nome_pagador: Nome do pagador
     *                      - solicitacao_pagador: Descrição da cobrança
     *                      - documento_pagador: CPF ou CNPJ do pagador
     *                      - validade_apos_vencimento: Dias de validade após o vencimento
     *                      - modalidadeMulta: (opcional) Modalidade da multa
     *                      - valorMulta: (opcional) Valor da multa
     *                      - modalidadeJuros: (opcional) Modalidade dos juros
     *                      - valorJuros: (opcional) Valor dos juros
     * 
     * @return array Dados da cobrança gerada, incluindo QR Code e cópia e cola
     * 
     * @throws \InvalidArgumentException Quando dados obrigatórios não são fornecidos ou valor é inválido
     * @throws \Exception Quando a data de vencimento é inválida ou ocorre erro na API
     */
    public function gerarCobranca($dados)
    { 
        try {
            // Validar dados obrigatórios
            if (!isset($dados['vctOri']) || !isset($dados['valor'])) {
                throw new \InvalidArgumentException('Dados obrigatórios não fornecidos');
            }

            // Validar valor
            if ($dados['valor'] <= 0) {
                throw new \InvalidArgumentException('Valor deve ser maior que zero');
            }
            
            // Converter data de vencimento yyyy-mm-dd para o formato correto
            $dataVencimento = DateTime::createFromFormat('Y-m-d', $dados['vctOri']);
            
            
            if (!$dataVencimento) {
                throw new Exception('E-Api-PIX-001: data de vencimento recebida não é uma data válida');
            }
            $dataVencimentoFormatada = $dataVencimento->format('Y-m-d');
            // Autenticar com o PSP
            $this->api->requestToken();

            // Criar cobrança
            $cobv = $this->api->cobv()
                ->setChave(config('pix.chave'))
                ->setTxId($dados['txid'])
                ->setValor($dados['valor'])
                ->setNome($dados['nome_pagador'])
                ->setSolicitacaoPagador($dados['solicitacao_pagador'])
                ->setDataVencimento($dataVencimentoFormatada)
                ->setValidadeVencimento($dados['validade_apos_vencimento']);
                // ->setModalidadeMulta('2')
                // ->setValorMultaModalidade(0.02) // 2%
                // ->setModalidadeJuros('1')
                // ->setValorJurosModalidade(1.00) // 1% ao mês

                if (isset($dados['modalidadeMulta'])) {
                    $cobv->setModalidadeMulta($dados['modalidadeMulta'])
                         ->setValorMultaModalidade($dados['valorMulta']);
                }
                if (isset($dados['modalidadeJuros'])) {
                    $cobv->setModalidadeJuros($dados['modalidadeJuros'])
                         ->setValorJurosModalidade($dados['valorJuros']);
                }
                // Definir se é CPF ou CNPJ
                if (strlen($dados['documento_pagador']) == 11) {
                    $cobv->setCpf($dados['documento_pagador']);
                } else {
                    $cobv->setCnpj($dados['documento_pagador']);
                }
                $cobv->create();

            // Obter resposta
            $resposta = $cobv->request->response->getData();
            
            // Gerar QR Code
            $qrcode = GeradorCode::qrcode($resposta['pixCopiaECola'], $dados['txid']);

            return [
                'qrcode' => $qrcode,
                'pixCopiaECola' => $resposta['pixCopiaECola'],
                'calendario' => $resposta['calendario'],
                'txid' => $resposta['txid'],
                'revisao' => $resposta['revisao'],
                'devedor' => $resposta['devedor'],
                'recebedor' => $resposta['recebedor'],
                'loc' => $resposta['loc'],
                'location' => $resposta['location'],
                'status' => $resposta['status'],
                'valor' => $resposta['valor'],
                'chave' => $resposta['chave'],
                'solicitacaoPagador' => $resposta['solicitacaoPagador']
            ];

        } catch (Exception $e) {
            Log::error('L-Api-PIX-002: Erro ao gerar PIX no Sicredi: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Valida a autenticidade de uma requisição de webhook recebida do Sicredi
     * 
     * Este método deve implementar a validação da assinatura do webhook conforme
     * a documentação específica do Sicredi. Atualmente retorna sempre true.
     * 
     * @param mixed $request Requisição de webhook recebida
     * @return bool Retorna true se a requisição for válida, false caso contrário
     */
    public function validarWebhook($request)
    {
        try {
            // Implementar validação da assinatura do webhook
            // Isso depende da documentação específica do Sicredi
            
            return true;

        } catch (Exception $e) {
            Log::error('L-Api-PIX-003: Erro ao validar webhook: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Cancela uma cobrança PIX existente pelo TXID
     * 
     * Este método cancela uma cobrança PIX através da API do Sicredi e registra
     * a transação de cancelamento no banco de dados. Também atualiza o status
     * da cobrança no sistema.
     * 
     * @param string $txid Identificador da transação a ser cancelada
     * @return bool Retorna true se o cancelamento foi bem-sucedido, false caso contrário
     */
    public function cancelarCobranca($txid)
    {
        $this->api->requestToken();

        // Cancelar cobrança
        $cobv = $this->api->cobv()
            ->setChave(config('pix.chave'))
            ->cancel($txid);

        // Obter resposta
        $resposta = $cobv->request->response->getData();

        $cobranca = Cobranca::where('txid', $txid)->first();
        
        if ($resposta['status'] == 'REMOVIDA_PELO_USUARIO_RECEBEDOR') {
            Transacao::create([
                'cobranca_id' => $cobranca->id,
                'titulo_id' => $cobranca->titulo_id,
                'tipo' => Transacao::TIPO_CANCELAMENTO,
                'status' => Transacao::STATUS_SUCESSO,
                'descricao' => 'Cobrança cancelada pelo usuário recebedor',
            ]);
            return true;
        } else {
            Transacao::create([
                'cobranca_id' => $cobranca->id,
                'titulo_id' => $cobranca->titulo_id,
                'tipo' => Transacao::TIPO_CANCELAMENTO,
                'status' => Transacao::STATUS_ERRO,
                'descricao' => 'Erro ao cancelar cobrança',
            ]);
            return false;
        }
    }

    /**
     * Consulta informações de uma cobrança PIX existente pelo TXID
     * 
     * Este método consulta os detalhes de uma cobrança PIX através da API do Sicredi
     * e retorna todas as informações disponíveis sobre a cobrança.
     * 
     * @param string $txid Identificador da transação a ser consultada
     * @return array Dados da cobrança consultada
     */
    public function consultarCobranca($txid)
    {
        $this->api->requestToken();

        // Consultar cobrança
        $cobv = $this->api->cobv()
            ->setChave(config('pix.chave'))
            ->consult($txid);

        // Obter resposta
        $resposta = $cobv->request->response->getData();
// log::info($resposta);
        Return $resposta;
        
    }

    /**
     * Cadastra um endpoint para receber notificações de webhook do Sicredi
     * 
     * Este método registra um URL para receber notificações de eventos relacionados
     * às cobranças PIX. Atualmente está comentado e precisa ser implementado
     * conforme a documentação do Sicredi.
     * 
     * @return mixed Dados da resposta do cadastro de webhook ou null
     */
    public function cadastrarWebhook()
    {
        $this->api->requestToken();

        print_r($this->api);

        // Cadastrar webhook
        //$webhook = $this->api->webhook()
            // ->setChave(config('pix.chave'))
            //->setUrl("https://3363-200-132-253-60.ngrok-free.app/api/webhook/sicredi")
            // ->setEventos(['COBRANCA_CRIADA', 'COBRANCA_ALTERADA', 'COBRANCA_REMOVIDA'])
            //->create();

        // Obter resposta
        //$resposta = $webhook->request->response->getData();

        //print_r($resposta);

        //return $resposta;
    }

    /**
     * Cancela uma cobrança PIX de forma simplificada pelo TXID
     * 
     * Este método cancela uma cobrança PIX através da API do Sicredi
     * e exibe a resposta. Versão simplificada do método cancelarCobranca
     * que não registra a transação no banco de dados.
     * 
     * @param string $txid Identificador da transação a ser cancelada
     * @return void
     */
    public function cancelarSimples($txid)
    {
        $this->api->requestToken();
        
        // Cancelar cobrança
        $cobv = $this->api->cobv()
            ->setChave(config('pix.chave'))
            ->cancel($txid);

        // Obter resposta
        $resposta = $cobv->request->response->getData();
        print_r($resposta);
    }
}