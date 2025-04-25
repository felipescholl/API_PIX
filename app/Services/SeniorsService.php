<?php

namespace App\Services;

use App\Mail\ErrorNotification;
use SoapClient;
use Exception;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use stdClass;
use App\Services\PixService;
use App\Models\Cobranca;
use App\Models\Titulo;
use App\Models\Transacao;
use Crmdesenvolvimentos\PixSicredi\Resources\Cob;
use Illuminate\Support\Facades\Mail;
use Artisaninweb\SoapWrapper\SoapWrapper;

/**
 * Classe responsável pela integração com o sistema SAPIENS via SOAP
 * 
 * Esta classe gerencia operações relacionadas a títulos financeiros no sistema SAPIENS,
 * incluindo gravação, atualização, exclusão e baixa de títulos. Também lida com o
 * tratamento de erros e atualização de status de cobrança no sistema PIX.
 */
class SeniorsService
{
    /**
     * Instância do SoapWrapper para comunicação SOAP
     * @var SoapWrapper
     */
    protected $wrapper;
    
    /**
     * Instância do serviço SOAP
     * @var mixed
     */
    protected $service;
    
    /**
     * URL do WSDL do serviço SAPIENS
     * @var string
     */
    protected $wsdl;
    
    /**
     * Opções de configuração do SOAP
     * @var array
     */
    protected $options;
    
    /**
     * Serviço para operações relacionadas ao PIX
     * @var PixService
     */
    protected $pixService;

    /**
     * Construtor da classe SeniorsService
     * 
     * Inicializa a classe com as dependências necessárias e configura o WSDL
     * para comunicação com o serviço SAPIENS.
     * 
     * @param SoapWrapper $wrapper Instância do wrapper SOAP para comunicação
     * @param PixService $pixService Serviço para operações relacionadas ao PIX
     */
    public function __construct(SoapWrapper $wrapper, PixService $pixService)
    {
        $this->wrapper = $wrapper;
        $this->pixService = $pixService;
        $this->wsdl = 'https://webp22.seniorcloud.com.br:30211/g5-senior-services/sapiens_Synccom_senior_g5_co_mfi_cre_titulos?wsdl';
        
        $this->initializeSoapWrapper();
    }

    /**
     * Inicializa o wrapper SOAP para comunicação com o serviço SAPIENS
     * 
     * Configura o serviço SOAP com as opções necessárias para comunicação
     * com o sistema SAPIENS, incluindo configurações de SSL e cache.
     * 
     * @throws Exception Se ocorrer um erro durante a inicialização do wrapper
     */
    protected function initializeSoapWrapper()
    {        
        try {
            $this->wrapper->add('senior', function ($service) {
                $service
                    ->wsdl($this->wsdl)
                    ->trace(true)
                    ->options([
                        'exceptions' => true,
                        'cache_wsdl' => WSDL_CACHE_NONE,
                        'stream_context' => stream_context_create([
                            'ssl' => [
                                'verify_peer' => false,
                                'verify_peer_name' => false
                            ]
                        ])
                    ]);
            });
        } catch (Exception $e) {
            Log::error('L-Api-SEN-001: Erro ao inicializar SOAP wrapper: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Formata um valor numérico para o padrão esperado pelo SAPIENS
     * 
     * Converte um valor numérico para o formato de string com separador decimal
     * conforme esperado pelo sistema SAPIENS.
     * 
     * @param float|null $value Valor a ser formatado
     * @param int $decimals Número de casas decimais (padrão: 2)
     * @param string $default Valor padrão caso o valor seja nulo (padrão: '0')
     * @return string Valor formatado como string
     */
    protected function formatValue($value, $decimals = 2, $default = '0')
    {
        return isset($value) ? number_format($value, $decimals, ',', '') : $default;
    }

    /**
     * Formata uma data para o padrão esperado pelo SAPIENS
     * 
     * Converte uma data para o formato dd/mm/yyyy conforme esperado pelo sistema SAPIENS.
     * 
     * @param string|\DateTime|null $date Data a ser formatada
     * @return string Data formatada ou string vazia se a data for nula
     */
    protected function formatDate($date)
    {
        return $date ? Carbon::parse($date)->format('d/m/Y') : '';
    }

    /**
     * Grava um novo título no sistema SAPIENS
     * 
     * Envia os dados do título para o sistema SAPIENS através do serviço SOAP,
     * construindo os parâmetros necessários e tratando a resposta ou possíveis erros.
     * 
     * @param array $dados Dados do título a ser gravado, incluindo informações como:
     *                     codEmp (código da empresa), codFil (código da filial),
     *                     numTit (número do título), codTpt (código do tipo de título),
     *                     e outros campos necessários para o registro do título
     * @return array|mixed Resultado da operação com informações de sucesso ou erro
     */
    public function gravarTitulo($dados)
    {
        try {
            //Log::info('L-Api-SEN-002: Dados recebidos em gravarTitulo:', ['dados' => $dados]);

            $parameters = $this->buildRequestParameters($dados);
            
            $response = $this->wrapper->call('senior.GravarTitulosCR', [
                'user' => config('services.senior.user'),
                'password' => config('services.senior.password'),
                'encryption' => 0,
                'parameters' => $parameters
            ]);

            return $this->handleResponse($response, $dados);

        } catch (Exception $e) {
            return $this->handleError($e, $dados);
        }
    }

    /**
     * Constrói os parâmetros para a requisição de gravação de título no SAPIENS
     * 
     * Formata os dados do título conforme a estrutura esperada pelo serviço SOAP do SAPIENS,
     * aplicando as formatações necessárias para datas e valores.
     * 
     * @param array $dados Dados do título a ser gravado
     * @return array Parâmetros formatados para a requisição SOAP
     */
    protected function buildRequestParameters($dados)
    {
        return [
            'dataBuild' => '',
            'flowInstanceID' => '',
            'flowName' => '',
            'titulos' => [
                'codEmp' => $dados['codEmp'],
                'codFil' => $dados['codFil'],
                'numTit' => $dados['numTit'],
                'codTpt' => $dados['codTpt'],
                'codTns' => $dados['codTns'],
                //'codNtg' => $dados['codNtg'] ?? '',
                'datEmi' => $this->formatDate($dados['datEmi']),
                'datEnt' => $this->formatDate($dados['datEnt']),
                'codCli' => $dados['codCli'],
                //'codSac' => $dados['codSac'] ?? '',
                'codRep' => $dados['codRep'],
                'codCrp' => $dados['codCrp'],
                'obsTcr' => $dados['obsTcr'] ?? '',
                'vctOri' => $this->formatDate($dados['vctOri']),
                'vlrOri' => $this->formatValue($dados['vlrOri']),
                'codFpg' => $dados['codFpg'] ?? null,
                'vctPro' => $this->formatDate($dados['vctPro'] ?? null),
                'codMoe' => '01',
                //'cotEmi' => $this->formatValue($dados['cotEmi'] ?? 0, 10),
                'datPpt' => $this->formatDate($dados['datPpt'] ?? null),
                'proJrs' => $dados['proJrs'],
                'codCrt' => $dados['codCrt'],
                'ideTxi' => $dados['ideTxi'] ?? '',
                'urlPix' => $dados['urlPix'] ?? '',
                'emvQrc' => $dados['emvQrc'] ?? '',
                'msgPag' => $dados['msgPag'] ?? 'Pagamento PIX - Tit ' . $dados['numTit'] . ' - '. $dados['nome_pagador'] . ' - Proj '. $dados['numPrj'],
                    // perJrs	String - Number(005,2) - Percentual de juros de mora ao mês do título a receber
                    // tipJrs	String - String(001) - Indicativo se os juros de mora é simples ou composto - Lista: S = Juros Simples, C = Juros Composto
                    // jrsDia	String - Number(009,2) - Valor de juros de mora ao dia do título a receber
                    // tolJrs	String - Number(004) - Dias de tolerância para os juros de mora do título a receber
                    // perMul	String - Number(005,2) - Percentual de multa prevista para o título a receber
                // Adicionando campos de multa e juros
                'tipJrs' => $dados['tipJrs'] ?? 'S',
                'perJrs' => $dados['perJrs'] ?? 0,
                'perMul' => $dados['perMul'] ?? 0,    
            ]
        ];
    }

    /**
     * Método genérico para tratamento de respostas do serviço Senior
     * 
     * Processa a resposta recebida do serviço SOAP do SAPIENS, verificando erros de execução
     * e validando o resultado conforme o tipo de operação realizada. Também registra transações
     * de sucesso e atualiza status de cobrança quando necessário.
     * 
     * @param mixed $response Resposta do serviço SOAP
     * @param array $dados Dados da requisição original enviada ao serviço
     * @param string $operacao Tipo de operação (gravar, alterar, baixar, excluir)
     * @return array|bool Resultado formatado da operação ou true para operações de baixa/exclusão
     * @throws Exception Se ocorrer um erro na resposta do serviço
     */
    protected function handleServiceResponse($response, $dados, $operacao = 'gravar')
    {
        $result = $response;
        $mensagem = '';
        $resultado = '';
        $dadosRetorno = [];

        // Verificar erros de execução
        if (!empty($result->erroExecucao)) {
            $mensagemErro = $operacao === 'alterar' ? $result->gridRetorno->retorno : $result->mensagemRetorno . ($result->resultado->resultado ?? '');
            throw new Exception('E-Api-SEN-003: ' . $mensagemErro);
        }

        // Verificar tipo de operação para validar a resposta
        switch ($operacao) {
            case 'gravar':
                if ($result->tipoRetorno !== '1' || $result->resultado->resultado !== 'OK') {
                    throw new Exception('E-Api-SEN-004: Erro no processamento - ' . $result->mensagemRetorno . $result->resultado->resultado);
                }
                $mensagem = $result->mensagemRetorno . $result->resultado->resultado;
                $resultado = $result->resultado->resultado;
                $dadosRetorno = [
                    'empresa' => $result->resultado->codEmp,
                    'filial' => $result->resultado->codFil,
                    'tipo' => $result->resultado->codTpt,
                    'numero' => $result->resultado->numTit
                ];
                break;

            case 'alterar':
                if ($result->retorno !== 'OK') {
                    throw new Exception('E-Api-SEN-004: Erro no processamento - ' . $result->gridRetorno->retorno);
                }
                $mensagem = $result->gridRetorno->retorno;
                $resultado = $result->retorno;
                $dadosRetorno = [
                    'empresa' => $result->gridRetorno->codEmp,
                    'filial' => $result->gridRetorno->codFil,
                    'tipo' => $result->gridRetorno->codTpt,
                    'numero' => $result->gridRetorno->numTit
                ];
                break;

            case 'baixar':
                // Verificar mensagem de erro específica
                if ($result->mensagemRetorno === 'Ocorreram erros.') {
                    throw new Exception('E-Api-SEN-010: Erro ao registrar ' . $dados['tipoBaixa'] . 
                        ' no Senior: ' . $result->mensagemRetorno . $result->resultado->resultado);
                }

                // Se for cancelamento, retornar true
                if (isset($dados['tipoBaixa']) && $dados['tipoBaixa'] === 'cancelamento') {
                    return true;
                }

                // Atualizar status da cobrança      
                $this->atualizarStatusCobranca($dados, $result->mensagemRetorno . $result->resultado->resultado);
                return true;
                break;

            case 'excluir':
                return true;
                break;
        }

        // Registrar transação de sucesso
        $this->registrarTransacaoSucesso($dados, $result);

        return [
            'success' => true,
            'status' => 'ATIVA',
            'resultado' => $resultado,
            'mensagem' => $mensagem,
            'dados' => $dadosRetorno
        ];
    }

    /**
     * Método específico para tratamento de resposta de gravação de título
     * 
     * Wrapper para o método genérico handleServiceResponse, específico para operação de gravação.
     * Mantido para compatibilidade com código existente.
     * 
     * @param mixed $response Resposta do serviço SOAP
     * @param array $dados Dados da requisição original
     * @return array Resultado formatado da operação de gravação
     * @throws Exception Se ocorrer um erro na resposta do serviço
     */
    protected function handleResponse($response, $dados)
    { 
        return $this->handleServiceResponse($response, $dados, 'gravar');
    }

    /**
     * Método genérico para tratamento de erros do serviço Senior
     * 
     * Processa exceções ocorridas durante a comunicação com o serviço SAPIENS,
     * registrando logs, atualizando status de cobrança e realizando ações específicas
     * conforme o tipo de operação que gerou o erro. Também pode cancelar a cobrança PIX
     * relacionada em caso de erro na gravação do título.
     * 
     * @param Exception $e Exceção capturada durante a comunicação com o serviço
     * @param array $dados Dados da requisição original enviada ao serviço
     * @param string $operacao Tipo de operação (gravar, alterar, baixar, excluir)
     * @param bool $cancelarCobranca Indica se deve cancelar a cobrança PIX em caso de erro
     * @return mixed Resultado do tratamento do erro, que pode variar conforme a operação
     * @throws Exception Relança a exceção com código e mensagem formatados
     */
    protected function handleServiceError(Exception $e, $dados, $operacao = 'gravar', $cancelarCobranca = true)
    {
        $prefixoLog = 'L-Api-SEN-Error: ';
        $prefixoExcecao = 'E-Api-SEN-';
        $mensagemLog = '';
        $codigoErro = '007';
        
        switch ($operacao) {
            case 'gravar':
                $mensagemLog = 'Erro ao gravar título: ';
                $codigoErro = '007';
                break;
            case 'alterar':
                $mensagemLog = 'Erro ao atualizar título: ';
                $codigoErro = '008';
                break;
            case 'baixar':
                $mensagemLog = 'Erro ao registrar baixa no Senior: ';
                $codigoErro = '011';
                
                // Atualizar status da cobrança para erro
                if (isset($dados['txid'])) {
                    $this->atualizarStatusCobrancaErro($dados, $e->getMessage());
                }
                
                // Verificar se é um título já liquidado
                if (strpos($e->getMessage(), 'Título Liquidado') !== false) {
                    $this->atualizarStatusCobrancaLiquidado($dados);
                    return true;
                }
                
                // Enviar notificação por email
                $this->enviarNotificacaoErro($dados, $e);
                break;
            case 'excluir':
                $mensagemLog = 'Erro ao excluir título no Senior: ';
                $codigoErro = '013';
                
                // Modificar o status do registrado_sapiens para 0
                if (isset($dados['txid'])) {
                    $cobranca = Cobranca::where('txid', $dados['txid'])->firstOrFail();
                    $cobranca->update([
                        'registrado_sapiens' => 0
                    ]);
                }
                break;
        }
        
        // Registrar log de erro
        Log::error($prefixoLog . $mensagemLog . $e->getMessage());
        
        // Registrar transação de erro
        $this->registrarTransacaoErro($dados, $e);
        
        // Tratar cancelamento da cobrança se necessário
        if ($cancelarCobranca && isset($dados['txid']) && $operacao === 'gravar') {
            $this->tratarCancelamentoCobranca($dados);
        }
        
        throw new Exception($prefixoExcecao . $codigoErro . ': ' . $e->getMessage());
    }
    
    /**
     * Método específico para tratamento de erro na gravação de título
     * 
     * Wrapper para o método genérico handleServiceError, específico para operação de gravação.
     * Mantido para compatibilidade com código existente.
     * 
     * @param Exception $e Exceção capturada durante a comunicação com o serviço
     * @param array $dados Dados da requisição original
     * @return mixed Resultado do tratamento do erro
     * @throws Exception Relança a exceção com código e mensagem formatados
     */
    protected function handleError(Exception $e, $dados)
    {
        return $this->handleServiceError($e, $dados, 'gravar', true);
    }

    /**
     * Registra uma transação de sucesso no sistema
     * 
     * Cria um registro de transação bem-sucedida relacionada à operação
     * realizada no sistema SAPIENS, associando-a ao título correspondente.
     * 
     * @param array $dados Dados da operação realizada
     * @param object $result Resultado da operação retornado pelo serviço SAPIENS
     * @return void
     */
    protected function registrarTransacaoSucesso($dados, $result)
    {
        if (isset($dados['titulo']) && $dados['titulo'] instanceof \App\Models\Titulo) {
            Transacao::create([
                'titulo_id' => $dados['titulo_id'],
                'cobranca_id' => $dados['cobranca_id'] ?? null,
                'tipo' => 'REGISTRO_SENIOR',
                'status' => 'SUCESSO',
                'descricao' => 'Transação de criação de título registrada com sucesso',
                'dados_adicionais' => [
                    'mensagem_retorno' => $result->mensagemRetorno . $result->resultado->resultado
                ]
            ]);
        }
    }

    /**
     * Registra uma transação de erro no sistema
     * 
     * Cria um registro de transação com erro relacionada à operação
     * realizada no sistema SAPIENS, associando-a ao título correspondente
     * e armazenando a mensagem de erro para análise posterior.
     * 
     * @param array $dados Dados da operação realizada
     * @param Exception $e Exceção capturada durante a operação
     * @return void
     */
    protected function registrarTransacaoErro($dados, Exception $e)
    {
        if (isset($dados['titulo']) && $dados['titulo'] instanceof \App\Models\Titulo) {
            Transacao::create([
                'titulo_id' => $dados['titulo']->id,
                'cobranca_id' => $dados['cobranca_id'] ?? null,
                'tipo' => Transacao::TIPO_REGISTRO_SENIOR,
                'status' => Transacao::STATUS_ERRO,
                'descricao' => 'Erro ao registrar título no SAPIENS',
                'dados_adicionais' => [
                    'erro' => $e->getMessage()
                ]
            ]);
        }
    }

    /**
     * Trata o cancelamento de uma cobrança PIX em caso de erro
     * 
     * Verifica o status atual da cobrança e, se não estiver já cancelada,
     * solicita o cancelamento através do serviço PIX. Também registra
     * a transação de cancelamento em caso de sucesso.
     * 
     * @param array $dados Dados da cobrança a ser cancelada
     * @return void
     */
    protected function tratarCancelamentoCobranca($dados)
    {
        $status = $this->pixService->consultarCobranca($dados['txid']);
        
        if ($status['status'] !== 'REMOVIDA_PELO_USUARIO_RECEBEDOR') {
            $cancelado = $this->pixService->cancelarCobranca($dados['txid']);
            
            if ($cancelado) {
                Log::info('L-Api-SEN-011: Pix cancelado com sucesso');
                $this->registrarTransacaoCancelamento($dados);
            } else {
                Log::error('L-Api-SEN-012: Erro ao cancelar cobrança TXID');
            }
        }
    }

    /**
     * Registra uma transação de cancelamento de cobrança PIX
     * 
     * Cria um registro de transação de cancelamento associada ao título,
     * indicando que a cobrança PIX foi cancelada devido a um erro no SAPIENS.
     * 
     * @param array $dados Dados da cobrança cancelada
     * @return void
     */
    protected function registrarTransacaoCancelamento($dados)
    {
        if (isset($dados['titulo']) && $dados['titulo'] instanceof \App\Models\Titulo) {
            Transacao::registrar(
                Transacao::TIPO_CANCELAMENTO,
                [
                    'status' => Transacao::STATUS_SUCESSO,
                    'valor' => $dados['vlrOri'],
                    'descricao' => 'Cobrança PIX cancelada devido a erro no SAPIENS'
                ]
            );
        }
    }

    /**
     * Registra a baixa de um título no sistema SAPIENS
     * 
     * Envia os dados de baixa para o sistema SAPIENS através do serviço SOAP,
     * seja por pagamento ou cancelamento. Constrói os parâmetros necessários
     * e trata a resposta ou possíveis erros.
     * 
     * @param array $dados Dados da baixa a ser registrada, incluindo:
     *                     tipoBaixa (tipo de baixa: pagamento ou cancelamento),
     *                     codEmp (código da empresa), codFil (código da filial),
     *                     numTit (número do título), codTpt (código do tipo de título),
     *                     e outros campos necessários para o registro da baixa
     * @return array|bool Resultado da operação com informações de sucesso ou erro
     */
    public function registrarBaixa($dados)
    {
        try {
            Log::info('L-Api-SEN-014: Iniciando registro de ' . $dados['tipoBaixa'], ['dados' => $dados]);

            $parameters = $this->buildBaixaParameters($dados);
                Log::info('L-Api-SEN-015: Parâmetros de baixa', ['parameters' => $parameters]);
            $response = $this->wrapper->call('senior.BaixarTitulosCR_3', [
                'user' => config('services.senior.user'),
                'password' => config('services.senior.password'),
                'encryption' => 0,
                'parameters' => $parameters
            ]);

            return $this->handleBaixaResponse($response, $dados);

        } catch (Exception $e) {
            return $this->handleBaixaError($e, $dados);
        }
    }

    /**
     * Constrói os parâmetros para a requisição de baixa de título no SAPIENS
     * 
     * Formata os dados da baixa conforme a estrutura esperada pelo serviço SOAP do SAPIENS,
     * incluindo valores de juros, multa e valores de movimento e líquido.
     * 
     * @param array $dados Dados da baixa a ser registrada
     * @return array Parâmetros formatados para a requisição SOAP
     */
    protected function buildBaixaParameters($dados)
    {
        // Calcular valores de juros e multa se aplicável
        $vlrJrs = isset($dados['vlrJrs']) ? $dados['vlrJrs'] : 0;
        $vlrMul = isset($dados['vlrMul']) ? $dados['vlrMul'] : 0;
        $vlrMov = isset($dados['vlrMov'])? $dados['vlrMov'] : 0;
        $vlrLiq = isset($dados['vlrLiq'])? $dados['vlrLiq'] : 0;

        return [
            'baixaTituloReceber' => [
                'codEmp' => $dados['codEmp'],
                'codFil' => $dados['codFil'],
                'numTit' => $dados['numTit'],
                'codTpt' => $dados['codTpt'],
                'datMov' => $this->formatDate(now()),
                'datPgt' => $this->formatDate($dados['dataPagamento']),
                'vlrMov' => $this->formatValue($vlrMov),
                'vlrLiq' => $this->formatValue($vlrLiq), // Valor líquido do movimento do título
                'vlrJrs' => $this->formatValue($vlrJrs),
                'vlrMul' => $this->formatValue($vlrMul),
                'numCco' => $dados['numCco'],
                'numDoc' => $dados['numDoc'],
                'codTns' => $dados['codTns']
            ],
            'dataBuild' => '',
            'flowInstanceID' => '',
            'flowName' => ''
        ];
    }

    /**
     * Método específico para tratamento de resposta de baixa de título
     * 
     * Wrapper para o método genérico handleServiceResponse, específico para operação de baixa.
     * 
     * @param mixed $response Resposta do serviço SOAP
     * @param array $dados Dados da requisição original
     * @return array|bool Resultado formatado da operação de baixa
     * @throws Exception Se ocorrer um erro na resposta do serviço
     */
    protected function handleBaixaResponse($response, $dados)
    {
        return $this->handleServiceResponse($response, $dados, 'baixar');
    }

    /**
     * Método específico para tratamento de erro na baixa de título
     * 
     * Wrapper para o método genérico handleServiceError, específico para operação de baixa.
     * Define cancelarCobranca como false para evitar cancelamento da cobrança PIX em caso de erro.
     * 
     * @param Exception $e Exceção capturada durante a comunicação com o serviço
     * @param array $dados Dados da requisição original
     * @return mixed Resultado do tratamento do erro
     * @throws Exception Relança a exceção com código e mensagem formatados
     */
    protected function handleBaixaError(Exception $e, $dados)
    {
        return $this->handleServiceError($e, $dados, 'baixar', false);
    }

    /**
     * Atualiza o status de uma cobrança para pago e registrado no sistema Senior
     * 
     * @param array $dados Array contendo o txid da cobrança
     * @param string $mensagem Mensagem de status a ser registrada
     * @return void
     * @throws ModelNotFoundException Se a cobrança não for encontrada
     */
    protected function atualizarStatusCobranca($dados, $mensagem)
    {
        $cobranca = Cobranca::where('txid', $dados['txid'])->firstOrFail();
        $cobranca->update([
            'status_pagamento' => Cobranca::PAGAMENTO_PAGO,
            'status_senior' => Cobranca::SENIOR_REGISTRADO,
            'msg_senior' => $mensagem
        ]);
    }

    /**
     * Atualiza o status de uma cobrança para erro no sistema Senior
     * 
     * @param array $dados Array contendo o txid da cobrança
     * @param string $mensagem Mensagem de erro a ser registrada
     * @return void
     * @throws ModelNotFoundException Se a cobrança não for encontrada
     */
    protected function atualizarStatusCobrancaErro($dados, $mensagem)
    {
        $cobranca = Cobranca::where('txid', $dados['txid'])->firstOrFail();
        $cobranca->update([
            'status_senior' => 'ERRO',
            'msg_senior' => $mensagem
        ]);
    }

    /**
     * Atualiza o status de uma cobrança para liquidado no sistema Senior
     * 
     * @param array $dados Array contendo o txid da cobrança
     * @return void
     * @throws ModelNotFoundException Se a cobrança não for encontrada
     */
    protected function atualizarStatusCobrancaLiquidado($dados)
    {
        $cobranca = Cobranca::where('txid', $dados['txid'])->firstOrFail();
        $cobranca->update([
            'status_senior' => Cobranca::SENIOR_REGISTRADO,
            'msg_senior' => 'Título Liquidado'
        ]);
    }

    /**
     * Envia notificação por email em caso de erro no registro de pagamento
     * 
     * @param array $dados Dados do título/pagamento que gerou o erro
     * @param Exception $e Exceção capturada durante o processamento
     * @return void
     */
    protected function enviarNotificacaoErro($dados, Exception $e)
    {
        $details = [
            'tipo_erro' => 'Erro ao registrar pagamento no SAPIENS',
            'error' => $e->getMessage(),
            'txid' => $dados['txid'],
            'codEmp' => $dados['codEmp'],
            'codFil' => $dados['codFil'],
            'numTit' => $dados['numTit'],
            'codTpt' => $dados['codTpt'],
            'valor' => $dados['vlrLiq']
        ];

        try {
            Mail::to(config('services.admin.email'))->send(new ErrorNotification($details));
            Log::info('L-Api-SEN-Mail: Email enviado com sucesso', $details);
        } catch (Exception $e) {
            Log::error('L-Api-SEN-Mail: Erro ao enviar email', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Atualiza um título no sistema SAPIENS através do serviço Senior
     * 
     * @param array $dados Dados do título a ser atualizado
     * @return array Resultado da operação de atualização
     * @throws Exception Em caso de erro na comunicação com o serviço
     */
    public function atualizarTitulo($dados)
    {
        try {
            $parameters = $this->buildRequestAlteracaoParameters($dados);

            $response = $this->wrapper->call('senior.AlteracaoParcialTitulosCR', [
                'user' => config('services.senior.user'),
                'password' => config('services.senior.password'),
                'encryption' => 0,
                'parameters' => $parameters
            ]);

            return $this->handleAlteracaoResponse($response, $dados);

        } catch (Exception $e) {
            return $this->handleServiceError($e, $dados, 'alterar', false);
        }
    }

    /**
     * Constrói os parâmetros para a requisição de alteração de título
     * 
     * @param array $dados Dados do título para construção dos parâmetros
     * @return array Parâmetros formatados para a requisição
     */
    protected function buildRequestAlteracaoParameters($dados)
    {
        
        return [
            'dataBuild' => '',
            'flowInstanceID' => '',
            'flowName' => '',
            'camposAlterados' => 'ideTxi,urlPix,emvQrc,msgPag,sitTit',
            'codEmp' => $dados['codEmp'],
            'gridTitulosAlterar' => [
                'codFil' => $dados['codFil'],
                'numTit' => $dados['numTit'],
                'codTpt' => $dados['codTpt'],
                'codCli' => $dados['codCli'],
                'ideTxi' => $dados['ideTxi'],
                'urlPix' => $dados['urlPix'],
                'emvQrc' => $dados['emvQrc'],
                'msgPag' => $dados['msgPag'],
                'sitTit' => $dados['sitTit']
            ]
        ];
    }

    /**
     * Processa a resposta da requisição de alteração de título
     * 
     * @param mixed $response Resposta do serviço Senior
     * @param array $dados Dados originais do título
     * @return array Resultado do processamento da resposta
     */
    protected function handleAlteracaoResponse($response, $dados)
    { 
        return $this->handleServiceResponse($response, $dados, 'alterar');
    }

    /**
     * Exclui um título no sistema SAPIENS e atualiza os registros relacionados
     * 
     * @param array $dados Dados do título a ser excluído
     * @param Collection $cobrancas Coleção de cobranças relacionadas ao título
     * @return bool True em caso de sucesso
     * @throws Exception Em caso de erro na exclusão
     */
    public function excluirTitulo($dados, $cobrancas)
    {
        try {
            $parameters = [
                'titulos' => [
                    'codEmp' => $dados['codEmp'],
                    'codFil' => $dados['codFil'],
                    'numTit' => $dados['numTit'],
                    'codTpt' => $dados['codTpt']
                ]
            ];

            Log::info('L-Api-SEN-017: Enviando requisição de exclusão para Senior:', ['params' => json_encode($parameters)]);

            $response = $this->wrapper->call('senior.ExcluirTitulosCR', [
                'user' => config('services.senior.user'),
                'password' => config('services.senior.password'),
                'encryption' => 0,
                'parameters' => $parameters
            ]);

            Log::info('L-Api-SEN-018: Resposta Senior exclusão:', ['response' => json_encode((array)$response)]);

            // Usar o método genérico para tratamento de resposta
            $result = $this->handleServiceResponse($response, $dados, 'excluir');

            foreach ($cobrancas as $cobranca) {
                // Registrar transação de exclusão
                if (isset($dados['titulo']) && $dados['titulo'] instanceof \App\Models\Titulo) {
                    \App\Models\Transacao::registrar(
                        $dados['titulo'],
                        \App\Models\Transacao::TIPO_CANCELAMENTO,
                        [
                            'cobranca_id' => $cobranca->id,
                            'status' => \App\Models\Transacao::STATUS_SUCESSO,
                            'descricao' => 'Título excluído no SAPIENS com sucesso',
                            'dados_adicionais' => []
                        ]
                    );
                }
            }

            // Modificar o status do registrado_sapiens para 1
            $cobranca = Cobranca::where('txid', $dados['txid'])->firstOrFail();
            $cobranca->update([
                'registrado_sapiens' => 1
            ]);

            return true;

        } catch (Exception $e) {
            // Usar o método genérico para tratamento de erro
            return $this->handleServiceError($e, $dados, 'excluir', false);
        }
    }

    /**
     * Processa a baixa de um título por cancelamento no sistema SAPIENS
     * 
     * Este método realiza as seguintes operações:
     * - Busca a cobrança pelo txid
     * - Verifica se a cobrança já foi processada
     * - Atualiza o status da cobrança para cancelado
     * - Registra a transação de cancelamento
     * - Registra a baixa no SAPIENS
     * - Atualiza os status e envia notificações em caso de erro
     * 
     * @param string $txid Identificador único da transação
     * @return array Resultado do processamento do cancelamento
     * @throws Exception Em caso de erro no processamento
     */
    public function baixaPorCancelamento($txid)
    {
        try { 
            
            // Buscar cobrança
            $cobranca = Cobranca::where('txid', $txid)->firstOrFail();

            // Verificar se a cobrança já foi processada para não gerar erro no status da Sênior
            if ($cobranca->status_pagamento === Cobranca::PAGAMENTO_PAGO && $cobranca->status_senior === Cobranca::SENIOR_REGISTRADO) {
                return [
                    'success' => true,
                    'txid' => $txid,
                    'mensagem' => 'Cobrança já foi paga'
                ];
            }

            // Atualizar cobrança
            $cobrancaAtualizada = $cobranca->update([
                'status_pagamento' => Cobranca::PAGAMENTO_CANCELADO,
            ]);
            
            $cobranca->titulo->update([
                'sitTit' => 'CA',
            ]);

            // Registrar transação
            if ($cobrancaAtualizada) {
                $cobranca->transacoes()->create([
                    'cobranca_id' => $cobranca->id,
                    'titulo_id' => $cobranca->titulo_id,
                    'tipo' => Transacao::TIPO_CANCELAMENTO,
                    'status' => Transacao::STATUS_SUCESSO,
                    'descricao' => 'Cancelamento de cobrança',
                ]);
            } else {
                $cobranca->transacoes()->create([
                    'cobranca_id' => $cobranca->id,
                    'titulo_id' => $cobranca->titulo_id,
                    'tipo' => Transacao::TIPO_CANCELAMENTO,
                    'status' => Transacao::STATUS_ERRO,
                    'descricao' => 'Erro ao registrar cancelamento de cobrança: ',
                    'dados_adicionais' => $cobrancaAtualizada['erro'] ?? null,
                ]);
            }

            // Registrar pagamento no SAPIENS
            $resultadoSapiens = $this->registrarBaixa([
                'tipoBaixa' => 'cancelamento',
                'codEmp' => $cobranca->titulo->codEmp,
                'codFil' => $cobranca->titulo->codFil,
                'numTit' => $cobranca->titulo->numTit,
                'codTpt' => $cobranca->titulo->codTpt,
                'numCco' => '',  // TODO - Precisa ver quem informa este código
                'txid' => null,
                'valor' => $cobranca->titulo->vlrOri,
                'dataPagamento' => null,
                'vlrMov' => $cobranca->titulo->vlrOri,
                'vlrLiq' => 0,
                'vlrJur' => 0,
                'vlrMulta' => 0,
                'endToEndId' => null,
                'numDoc' => null,
                'codTns' => 90353 // TODO - Verificar se não tem que ser o codTns padrão de baixa por pagamento 90300 !!!
            ]);
            print_r($resultadoSapiens);

            // Registrar transação de baixa no SAPIENS
            if ($resultadoSapiens) {
                
            }
            if ($resultadoSapiens) {
                $cobranca->transacoes()->create([
                    'cobranca_id' => $cobranca->id,
                    'titulo_id' => $cobranca->titulo_id,
                    'tipo' => Transacao::TIPO_REG_CANCELAMENTO,
                    'status' => Transacao::STATUS_SUCESSO,
                    'descricao' => 'Cancelamento registrado no SAPIENS',
                ]);
                $cobranca->update([
                    'status_senior' => Cobranca::SENIOR_REGISTRADO,
                    'msg_senior' => json_encode($resultadoSapiens['status'] ?? '')
                ]);
            } else {
                $cobranca->transacoes()->create([
                    'cobranca_id' => $cobranca->id,
                    'titulo_id' => $cobranca->titulo_id,
                    'tipo' => Transacao::TIPO_REG_CANCELAMENTO,
                    'status' => Transacao::STATUS_ERRO,
                    'descricao' => 'Erro ao registrar cancelamento no SAPIENS',
                    'dados_adiconais' => $resultadoSapiens['erro'] ?? null,
                ]);

                $cobranca->update([
                    'status_senior' => Cobranca::SENIOR_ERRO,
                ]);
            }

            return [
                'success' => true,
                'txid' => $txid,
                'mensagem' => 'Cancelamento processado com sucesso',
                'sapiens' => $resultadoSapiens
            ];

        } catch (Exception $e) {
            Log::error('L-Api-TWH-005: Erro ao processar PIX', [
                'txid' => $txid,
                'error' => $e->getMessage(),
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
                    'tipo' => Transacao::TIPO_REG_CANCELAMENTO,
                    'status' => Transacao::STATUS_ERRO,
                    'descricao' => 'Erro ao registrar cancelamento no SAPIENS',
                    'dados_adicionais' => $e->getMessage()
                ]);
            }

            // Enviar e-mail em caso de erro
            $details = [
                'tipo_erro' => 'Erro ao cancelar cobrança',
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
                'txid' => $txid ?? 'N/A',
                'erro' => $e->getMessage()
            ];
        }
    }
    

}