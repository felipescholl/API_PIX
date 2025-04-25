<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Services\TxidService;
use App\Services\SeniorsService;
use App\Services\PixService;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Models\Cobranca;
use App\Models\Titulo;
use Carbon\Carbon;
use App\Models\Transacao;
use App\Services\TratamentoWebhook;
use Crmdesenvolvimentos\PixSicredi\Resources\Cob;

/**
 * Controlador responsável por gerenciar cobranças PIX
 * 
 * Este controlador gerencia a criação, consulta e exclusão de cobranças PIX,
 * atuando como intermediário entre os sistemas internos (SCR e Sisclass) e os
 * serviços de pagamento PIX do Sicredi, além de integrar com o sistema SAPIENS
 * para registro de títulos.
 */
class CobrancaController extends Controller
{
    /**
     * Serviço para interação com a API PIX do Sicredi
     * 
     * @var PixService
     */
    protected $pixService;
    
    /**
     * Serviço para interação com o sistema SAPIENS
     * 
     * @var SeniorsService
     */
    protected $seniorService;

    /**
     * Inicializa o controlador com as dependências necessárias
     * 
     * @param PixService $pixService Serviço para comunicação com o Sicredi
     * @param SeniorsService $seniorService Serviço para comunicação com o SAPIENS
     */
    public function __construct(PixService $pixService, SeniorsService $seniorService)
    {
        $this->pixService = $pixService;
        $this->seniorService = $seniorService;
    }

    /**
     * Gera uma cobrança PIX para o sistema SCR com configurações específicas
     * 
     * Configurações específicas:
     * - Validade após vencimento: 730 dias
     * - Sistema de origem: SCR
     * - Modalidade de multa: Percentual (2)
     * - Valor da multa: 1%
     * - Modalidade de juros: Percentual por mês em dias corridos (3)
     * - Valor de juros: 1% ao mês
     * 
     * @param Request $request Objeto Request contendo os dados da cobrança
     * @return \Illuminate\Http\JsonResponse Resposta JSON com os dados da cobrança gerada
     */
    public function gerarCobrancaSCR(Request $request) 
    {
        $sistema = [
            'validade_apos_vencimento' => 730,
            'sistemaOrigem' => 'SCR',
            'modalidadeMulta' => '2',   // 2 = percentual
            'valorMulta' => 1.00,       // 1%
            'modalidadeJuros' => '3',   // 3 = percentual por mês em dias corridos, 7 = percentual por mês em dias úteis, 2 = percentual por dias corridos
            'valorJuros' => 1.00,       // 1% ao mês
        ];
        return $this->gerarCobranca($request, $sistema);
    }

    /**
     * Gera uma cobrança PIX para o sistema Sisclass com configurações específicas
     * 
     * Configurações específicas:
     * - Validade após vencimento: 5 dias
     * - Sistema de origem: CLA
     * 
     * @param Request $request Objeto Request contendo os dados da cobrança
     * @return \Illuminate\Http\JsonResponse Resposta JSON com os dados da cobrança gerada
     */
    public function gerarCobrancaSisclass(Request $request)
    {
        $sistema = [
            'validade_apos_vencimento' => 5,
            'sistemaOrigem' => 'CLA',
        ];
        return $this->gerarCobranca($request, $sistema);
    }

    /**
     * Método principal que processa a geração de cobranças PIX
     * 
     * Fluxo de processamento:
     * 1. Validação dos dados recebidos
     * 2. Verificação/cadastro do cliente
     * 3. Verificação da existência do título
     * 4. Geração da cobrança PIX (novo TXID)
     * 5. Criação/atualização do título no banco de dados
     * 6. Criação da cobrança vinculada ao título
     * 7. Registro de transação inicial
     * 8. Preparação dos dados para o SAPIENS
     * 9. Registro no SAPIENS (gravação ou atualização)
     * 10. Atualização do status da cobrança com base no resultado do SAPIENS
     * 11. Registro de transação de sucesso
     * 
     * @param Request $request Objeto Request contendo os dados da cobrança
     * @param array $sistema Array com configurações específicas do sistema de origem
     * @return \Illuminate\Http\JsonResponse Resposta JSON com os dados da cobrança gerada ou mensagem de erro
     */
    public function gerarCobranca(Request $request, $sistema)
    {
        $cobrancaPix = [];
        $dadosCobranca = [];

        try {
            // Validar dados recebidos
            $validated = $request->validate([
                'codEmp' => 'required|string',
                'codFil' => 'required|string',
                'numTit' => 'required|string',
                'codTpt' => 'required|string',
                'codTns' => 'required|string',
                'datEmi' => 'required|date_format:Y-m-d',
                'codCli' => 'required|string',
                'cpf_cnpj' => 'required|string',
                'nome_pagador' => 'required|string',
                'responsavel' => 'required|string',
                'vctOri' => 'required|date_format:Y-m-d',
                'vlrOri' => 'required|numeric',
                'codNtg' => 'nullable|string',
                'datEnt' => 'required|date_format:Y-m-d',
                'proJrs' => 'required|string',
                'codPor' => 'nullable|string',
                'sitTit' => 'nullable|string',
                //'sitAnt' => 'nullable|string',
                //'codSac' => 'nullable|string',
                'codRep' => 'nullable|string',
                'codCrp' => 'nullable|string',
                'codCrt' => 'nullable|string',
                'numCco' => 'nullable|string',
                //'obsTcr' => 'nullable|string',
                'codFpg' => 'nullable|string',
                'numPrj' => 'nullable|string',
                //'codJrs' => 'nullable|string',
                //'datPpt' => 'nullable|date_format:Y-m-d',
                //'vlrAbe' => 'nullable|numeric',
                //'vctPro' => 'nullable|date',
                'msgPag' => 'nullable|string',
                //'numNff' => 'nullable|string',
                //'codMpt' => 'nullable|string',
                //'codMoe' => 'nullable|string',
                //'cotEmi' => 'nullable|numeric',
                'apeCli' => 'nullable|string',
                'intNet' => 'nullable|string',
                'fonCli' => 'nullable|string',
                'fonCl2' => 'nullable|string',
                'endCli' => 'nullable|string',
                'nenCli' => 'nullable|string',
                'cplCli' => 'nullable|string',
                'baiCli' => 'nullable|string',
                'cidCli' => 'nullable|string',
                'cepCli' => 'nullable|string',
            ]);

            // Se msgPag não for enviado, preencher com padrão
            if (!isset($validated['msgPag'])) {
                $validated['msgPag'] = 'Cobrança Emater - Tit. '. $validated['numTit'].' - '. $validated['nome_pagador'].' - Proj. '. $validated['numPrj'];
            }
            
            // TODO Verificar se cliente existe ou fazer o cadastro
            $cliente = Cliente::where('codCli', $validated['codCli'])->first();
            if (!$cliente) {
                // Registrar cliente
                $cliente = Cliente::create([  // TODO (Verificar se dados do cadastro chegaram corretamente)
                    'codCli' => $validated['codCli'],
                    'nomCli' => $validated['nome_pagador'],
                    'apeCli' => $validated['apeCli'] ?? '', // Nome fantasia
                    'tipCli' => $validated['tipCli'] ?? 'F', // Física ou Jurídica F, J
                    'tipMer' => $validated['tipMer'] ?? 'I', // Interno, Externo ou Prospect I, E, P
                    'cliCon' => $validated['cliCon'] ?? 'S', // Contribuinte de ICMS S ou N
                    'sitCli' => $validated['sitCli'] ?? 'A', // Ativo ou Inativo A, I
                    'cgcCpf' => $validated['cpf_cnpj'], // CPF ou CNPJ
                    'intNet' => $validated['intNet'],
                    'fonCli' => $validated['fonCli'],
                    'fonCl2' => $validated['fonCl2'],
                    'endCli' => $validated['endCli'],
                    'nenCli' => $validated['nenCli'],
                    'cplCli' => $validated['cplCli'],
                    'baiCli' => $validated['baiCli'],
                    'cidCli' => $validated['cidCli'],
                    'cepCli' => $validated['cepCli'],
                ]);
            }
            // TODO - Verificar se precisa consultar se o cliente já é cadastrado no Sapiens - Caso não seja, cadastrar

            // Verifica se numTit já foi cadastrado
            $titulo = Titulo::where('numTit', $validated['numTit'])->first();
           
            if (!$titulo) {
                // Gerar cobrança PIX
                $cobrancaPix = $this->gerarPix($validated, $sistema);
                $txid = $cobrancaPix['txid'];

                // 1. Primeiro criar o título
                $titulo = Titulo::create([
                    'cpf_cnpj' => $validated['cpf_cnpj'],
                    'nome_pagador' => $validated['nome_pagador'],
                    'txid' => $txid,
                    'urlPix' => $cobrancaPix['location'],
                    'emvQrc' => $cobrancaPix['pixCopiaECola'],
                    'ideTxi' => $txid,
                    'codEmp' => $validated['codEmp'],
                    'codFil' => $validated['codFil'],
                    'numTit' => $validated['numTit'],
                    'codTpt' => $validated['codTpt'],
                    'codTns' => $validated['codTns'],
                    'codNtg' => $validated['codNtg'],
                    'codPor' => $validated['codPor'] ?? '',
                    'sitTit' => $validated['sitTit'] ?? '',
                    'sitAnt' => $validated['sitAnt'] ?? 'AB',
                    'datEmi' => $validated['datEmi'] ?? now(),
                    'datEnt' => $validated['datEnt'],
                    'codCli' => $validated['codCli'],
                    'codRep' => $validated['codRep'],
                    'codCrp' => $validated['codCrp'],
                    'codCrt' => $validated['codCrt'],
                    'numCco' => $validated['numCco'],
                    'obsTcr' => $validated['obsTcr'] ?? '',
                    'vctOri' => $validated['vctOri'],
                    'vlrOri' => $validated['vlrOri'],
                    //'codFpg' => $validated['codFpg'],
                    'proJrs' => $validated['proJrs'] ?? '',
                    'numPrj' => $validated['numPrj'],
                    //'codJrs' => $validated['codJrs'],
                    'datPpt' => $validated['datPpt'] ?? '',
                    'vlrAbe' => $validated['vlrAbe'] ?? '',
                    //'numNff' => $validated['numNff'],
                    'msgPag' => $validated['msgPag'] ?? 'Cobrança Emater - Tit ' . $validated['numTit'] . ' - ' . $validated['nome_pagador'] . ' - Proj ' . $validated['numPrj'],
                    'ideTxi' => $txid,
                    // Adicionando campos de multa e juros
                    'tipJrs' => 'S',
                    'perJrs' => $sistema['valorJuros'],
                    'perMul' => $sistema['valorMulta'],
                    //'jrsDia' => $this->formatValue($dados['jrs_dia'] ?? 0, 2),
                    //'tolJrs' => $dados['tol_jrs'] ?? 0,
                    //'tolMul' => $dados['tol_mul'] ?? 0
                    
                ]);
            } else {
                $chave = null;
                $alterou = false;
                $dateFields = ['datEmi', 'datEnt', 'vctOri', 'datPpt']; // Campos de data

                foreach ($validated as $key => $value) {
                    //print_r($key . ' recebe ' . $value);
                    if ($key == 'cpf_cnpj' || $key == 'nome_pagador' || $key == 'sitTit' || $key == 'responsavel') {
                        continue;
                    }

                    // Se for um campo de data, formate o valor do modelo
                    $tituloValue = in_array($key, $dateFields) && $titulo->$key
                        ? \Carbon\Carbon::parse($titulo->$key)->format('Y-m-d')
                        : $titulo->$key;

                        if ($tituloValue != $value) {
                            $alterou = true;
                            $chave = $key;
                            print_r($chave);
                        }
                }
                    
                    //print_r($chave);
                    if ($alterou) {
                        throw new Exception('E-Api-CC-002: Título já cadastrado - Não é possível alterar valores ou data de vencimento');
                    }

                    // Verifica se sitTit é 'ER' antes de prosseguir com a validação de alterações
                    if ($alterou == false && $titulo->sitTit !== 'ER' && Cobranca::where('titulo_id', $titulo->id)->latest('id')->first()->status_senior == 'REGISTRADO') {
                        Log::info("Título {$titulo->numTit} ignorado: sitTit ({$titulo->sitTit}) diferente de 'ER'");

                        // Dados da cobrança existente para retorno
                        $cobrancaAnterior = $titulo->cobranca; 
                        $txid = $titulo->txid;

                        return response()->json([
                            'success' => true,
                            'message' => "Título existente não está em situação 'ER', nenhuma alteração foi feita",
                            'data' => [
                                'cobranca' => $cobrancaAnterior,
                                'pix' => [
                                    'txid' => $txid,
                                    'location' => $titulo->urlPix,
                                    'pix_copia_cola' => $titulo->emvQrc
                                ],
                                'sapiens' => [], // Inclua os dados Necessários
                                // 'qrcodesgv' => file_exists(public_path('qrcode/qrcode_' . $txid . '.svg'))  ? file_get_contents(public_path('qrcode/qrcode_' . $txid . '.svg')) : null
                            ]
                        ], 200);
                    }
                
                
                if ($alterou) {
                    throw new Exception('E-Api-CC-002: Título já cadastrado - Não é possível alterar valores ou data de vencimento');
                }

                // Gerar novo TXID para o mesmo título
                $cobrancaPix = $this->gerarPix($validated, $sistema);
                $txid = $cobrancaPix['txid'];

                $tituloUpdated = Titulo::where('numTit', $validated['numTit'])->update([
                    'txid' => $txid,
                    'ideTxi' => $txid,
                    'urlPix' => $cobrancaPix['location'],
                    'emvQrc' => $cobrancaPix['pixCopiaECola'],
                    'sitTit' => $validated['sitTit'],
                ]);
                $titulo = Titulo::where('numTit', $validated['numTit'])->first();
                $cobrancaPix['location'] = $titulo->urlPix;
                $cobrancaPix['pixCopiaECola'] = $titulo->emvQrc;
            }

            // Carregar cobrança existente no banco de dados, pegar a ultima cobrança
            $cobrancaAnterior = Cobranca::where('titulo_id', $titulo->id)->latest('id')->first();

            // 3. Criar a cobrança vinculada ao título e à transação
            $cobranca = Cobranca::create([
                'titulo_id' => $titulo->id,
                'cliente_codCli' => $titulo->codCli,
                'txid' => $txid,
                'valor' => $validated['vlrOri'],
                'data_vencimento' => $validated['vctOri'],
                'status_pagamento' => Cobranca::PAGAMENTO_PENDENTE,
                'status_senior' => Cobranca::SENIOR_NAO_ENVIADO,
                'msg_senior' => null,
                'sistema_origem' => $sistema['sistemaOrigem'],
                'titulo_numTit' => $validated['numTit'],
                'titulo_numPrj' => $validated['numPrj'],
                'validade_apos_vencimento' => $sistema['validade_apos_vencimento'],
                'expiracao' => Carbon::parse($request['vctOri'])->addDays($sistema['validade_apos_vencimento'])->format('Y-m-d'),
                'responsavel' => $validated['responsavel'],
            ]);

            

            // 2. Registrar transação inicial
            $transacao = Transacao::registrar($titulo, Transacao::TIPO_CRIACAO, [
                'cobranca_id' => $cobranca->id,
                'titulo_id' => $titulo->id,
                'tipo' => Transacao::TIPO_CRIACAO,
                'status' => Transacao::STATUS_SUCESSO,
                'descricao' => 'Cobrança PIX gerada com sucesso',
                'dados_adicionais' => [
                    'txid' => $txid,
                    //'location' => $cobrancaPix['location'],
                    //'pix_copia_cola' => $cobrancaPix['pixCopiaECola']
                ]
            ]);

            // 4. Preparar dados para o SAPIENS
            $dadosSapiens = array_merge($validated, [
                'titulo_id' => $titulo->id,
                'cobranca_id' => $cobranca->id,
                'txid' => $txid,
                'titulo' => $titulo->numTit,
                'ideTxi' => $titulo->txid,
                'urlPix' => $titulo->urlPix,
                'emvQrc' => $titulo->emvQrc,
                'msgPag' => $titulo->msgPag,
                'sitTit' => $titulo->sitTit,
                // Adicionando campos de multa e juros
                'tipJrs' => 'S',
                'perJrs' => $sistema['valorJuros'],
                'perMul' => $sistema['valorMulta'],
            ]);

            // 5. Registrar no SAPIENS
            if(isset($tituloUpdated) && $cobrancaAnterior['status_senior'] == 'REGISTRADO'){
                $cobrancaAnterior->Update([
                    'status_pagamento' => Cobranca::PAGAMENTO_SUBSTITUIDO, 
                    'msg_senior' => 'Substituído por cobrança com TXID: ' . $txid
                ]);
                Transacao::create([
                    'titulo_id' => $titulo->id,
                    'cobranca_id' => $cobrancaAnterior->id,
                    'tipo' => Transacao::TIPO_SUBSTITUICAO,
                    'status' => Transacao::STATUS_SUCESSO,
                    'descricao' => 'Substituído por cobrança com TXID: ' . $txid,
                    'dados_adicionais' => [
                        'txid' => $txid,
                        'cobranca_substituida' => $cobrancaAnterior->txid
                    ]
                ]);
                $registroSapiens = $this->seniorService->atualizarTitulo($dadosSapiens);
            }else{
                # se titulo já existe, porém houve alteração no valor, vencimento será necessário cancelar o titulo anterior e criar um novo, verificar como isso deve ocorrer
                $registroSapiens = $this->seniorService->gravarTitulo($dadosSapiens);
            }

            // 7. Registrar resultado do SAPIENS na cobrança
            if ($registroSapiens['resultado'] == 'OK') {
                Cobranca::where('id', $cobranca->id)->update([
                    'status_senior' => Cobranca::SENIOR_REGISTRADO,
                    'msg_senior' => null
                ]);
            } else {
                Cobranca::where('id', $cobranca->id)->update([
                    'status_senior' => Cobranca::SENIOR_ERRO,
                    'msg_senior' => $registroSapiens['mensagem']
                ]);
            }

            // 8. Registrar transação de sucesso
            $transacaoSapiens = Transacao::create([
                'titulo_id' => $titulo->id,
                'cobranca_id' => $cobranca->id,
                'tipo' => Transacao::TIPO_REG_CRIACAO,
                'status' => Transacao::STATUS_SUCESSO,
                'descricao' => 'Geração de Título registrado no SAPIENS com sucesso',
                'dados_adicionais' => [
                    'txid' => $txid,
                    //'mensagem_retorno' => $registroSapiens['mensagem'],
                    //'resultado' => $registroSapiens['resultado']
                ]
            ]);

            // 9. Atualizar status da cobrança
            Cobranca::where('id', $cobranca->id)->update([
                'status_pagamento' => Cobranca::PAGAMENTO_ATIVO
            ]);

            return response()->json([
                'success' => true,
                'message' => $registroSapiens['mensagem'],
                'data' => [
                    //'titulo' => $titulo,
                    'cobranca' => $cobranca,
                    'pix' => [
                        'txid' => $txid,
                        'location' => $cobrancaPix['location'],
                        'pix_copia_cola' => $cobrancaPix['pixCopiaECola']
                    ],
                    'sapiens' => $registroSapiens['dados'],
                    # Enviar imagem SVG da pasta /public/qrcode/ para o solicitante
                    //'qrcodesgv' => file(public_path('qrcode/qrcode_' . $txid . '.svg'))
                ]
            ]);
        } catch (Exception $e) {
            Log::error('L-Api-CC-001: Erro ao gerar cobrança: ' . $e->getMessage());

            // Se o título foi criado, registrar o erro
            if (isset($titulo)) {
                $transacaoErro = Transacao::registrar($titulo, Transacao::TIPO_REG_CRIACAO, [
                    'cobranca_id' => Cobranca::latest('id')->first()->id,
                    'status' => Transacao::STATUS_ERRO,
                    'valor' => $validated['vlrOri'],
                    'descricao' => 'Erro ao processar cobrança: ' . $e->getMessage(),
                    'dados_adicionais' => [
                        'erro' => $e->getMessage()
                    ]
                ]);
        
                // Atualizar status do título
                $titulo->update([
                    'sitTit' => 'ER'
                ]);

                // Se a cobrança foi criada, atualizar seu status
                if (isset($cobranca)) {
                    Cobranca::where('id', $cobranca->id)->update([
                        'status_pagamento' => 'CANCELADO',
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Erro ao gerar cobrança: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Gera uma cobrança PIX utilizando o serviço PIX
     * 
     * @param array $validated Array com dados validados da cobrança
     * @param array $sistema Array com configurações específicas do sistema de origem
     * @return array Array com dados da cobrança PIX gerada (txid, location, pixCopiaECola)
     */
    private function gerarPix($validated, $sistema)
    {
        
        // Gerar TXID
        $txid = TxidService::generate(
            $sistema['sistemaOrigem'],
            str_replace('/', '', $validated['numTit']),
            intval($validated['codCli']),
            $validated['numPrj'],
            floatval($validated['vlrOri']),
            $validated['vctOri']
        );

        // Preparar dados para cobrança PIX
        $dadosCobranca = [
            'txid' => $txid,
            'cliente_codCli' => $validated['codCli'],
            'valor' => $validated['vlrOri'],
            'documento_pagador' => $validated['cpf_cnpj'],
            'nome_pagador' => $validated['nome_pagador'],
            'vctOri' => $validated['vctOri'],
            'validade_apos_vencimento' => $sistema['validade_apos_vencimento'],
            'solicitacao_pagador' => $validated['msgPag'],
        ];

        if (isset($sistema['modalidadeMulta'])) {
            $dadosCobranca['modalidadeMulta'] = $sistema['modalidadeMulta'];
            $dadosCobranca['valorMulta'] = $sistema['valorMulta'];
        }

        if (isset($sistema['modalidadeJuros'])) {
            $dadosCobranca['modalidadeJuros'] = $sistema['modalidadeJuros'];
            $dadosCobranca['valorJuros'] = $sistema['valorJuros'];
        }

        // Gerar cobrança PIX
        $cobrancaPix = $this->pixService->gerarCobranca($dadosCobranca);

        return array_merge($cobrancaPix, ['txid' => $txid, 'solicitacao_pagador' => $dadosCobranca['solicitacao_pagador']]);
    }

    /**
     * Processa notificações de webhook recebidas do Sicredi
     * 
     * @param Request $request Objeto Request contendo os dados do webhook
     * @return \Illuminate\Http\JsonResponse Resposta JSON com o resultado do processamento ou mensagem de erro
     */
    public function webhookSicredi(Request $request)
    {
        try {
            // Validar assinatura do webhook
            if (!$this->pixService->validarWebhook($request)) {
                throw new Exception('E-Api-CC-003: Assinatura do webhook inválida');
            }

            // Usar o serviço de tratamento do webhook
            $tratamentoWebhook = app(TratamentoWebhook::class);
            $resultado = $tratamentoWebhook->processar($request->all());

            return response()->json($resultado);

        } catch (Exception $e) {

            Log::error('L-Api-CC-002: Erro no webhook Sicredi: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erro ao processar webhook: ' . $e->getMessage()
            ], 500);

        }
    }

    /**
     * Exclui um título e suas cobranças associadas
     * 
     * @param string $numTit Número do título a ser excluído
     * @return \Illuminate\Http\JsonResponse Resposta JSON com o resultado da exclusão ou mensagem de erro
     */
    public function excluirTitulo($numTit)
    {
        try {
            // Carregar título
            $titulo = Titulo::where('numTit', $numTit)->first();

            if (!$titulo) {
                throw new Exception('E-Api-CC-004: Título não encontrado');
            }

            // Verificar se o título já foi pago
            if ($titulo->sitTit == 'PG') {
                throw new Exception('E-Api-CC-005: Título já foi pago');
            }

            // Verificar se o título já foi cancelado
            if ($titulo->sitTit == 'EX') {
                throw new Exception('E-Api-CC-006: Título já foi excluído');
            }

            // Carregar todas as cobranças relacionadas ao titulo excluído
            $cobrancas = $titulo->cobranca()->get();

            // Enviar requisição de exclusão do título para Senior
            $response = $this->seniorService->excluirTitulo($titulo, $cobrancas);

            if (!$response) {
                throw new Exception('E-Api-CC-007: Erro ao excluir título: ' . $response['message']);
            } else { // Se a requisição foi enviada com sucesso, atualizar status do título para EXCLUIDO
                $titulo->update([
                    'sitTit' => 'EX',
                    'numTit' => 'EX' . $numTit,
                ]);
            }

            if (!$cobrancas) {
                throw new Exception('E-Api-CC-007: Cobrança não encontrada');
            }

            foreach ($cobrancas as $cobranca) {
                try {
                    // Verificar se a cobrança já foi paga
                    if ($cobranca->status_pagamento == 'PAGO') {
                        Log::warning("Cobrança {$cobranca->txid} já está paga, pulando...");
                        continue;
                    } 
                    
                    // Cancelar Pix Sicredi 
                    $response = $this->pixService->cancelarCobranca($cobranca->txid);

                    if (!$response) {
                        Log::error("E-Api-CC-009: Erro ao cancelar cobrança {$cobranca->txid}: " . $response['message']);
                        continue;
                    }
                    
                    // Se a requisição foi enviada com sucesso, atualizar status da cobrança para EXCLUIDO
                    Cobranca::where('id', $cobranca->id)->update(['status_pagamento' => Cobranca::PAGAMENTO_EXCLUIDO]);

                } catch (Exception $e) {
                    Log::error("L-Api-CC-004 Erro ao processar cancelamento da cobrança {$cobranca->txid}: " . $e->getMessage());
                    continue;
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Título excluido com sucesso'
            ]);
        } catch (Exception $e) {
            Log::error('L-Api-CC-003: Erro ao cancelar título: ' . $e->getMessage());

            // foreach ($cobrancas as $cobranca) {
            //     // Registrar transação de erro na exclusão do título
            //     Transacao::create([
            //         'cobranca_id' => $cobranca->id,
            //         'titulo_id' => $titulo->id,
            //         'tipo' => Transacao::TIPO_CANCELAMENTO,
            //         'status' => Transacao::STATUS_ERRO,
            //         'descricao' => 'Erro ao cancelar título: ' . $e->getMessage(),
            //     ]);
            // }

            return response()->json([
                'success' => false,
                'message' => 'Erro ao cancelar título: ' . $e->getMessage()
            ], 500);
        }
    }
}
