<?php

namespace App\Http\Controllers;

use App\Mail\ErrorNotification;
use App\Models\Cobranca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Services\PixService;
use App\Models\Titulo;
use App\Models\Transacao;
use App\Services\SeniorsService;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Stmt\Switch_;
use Carbon\Carbon;

class CobrancaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cobrancas = Cobranca::with('cliente')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('cobrancas.index', compact('cobrancas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cobrancas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Cobranca $cobranca)
    {
        return view('livewire.cobrancas.show', compact('cobranca'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function export(Request $request)
    {
        $format = $request->query('format', 'csv');
        $cobrancas = Cobranca::with('cliente')->get();

        switch ($format) {
            case 'csv':
                $headers = array(
                    "Content-type" => "text/csv",
                    "Content-Disposition" => "attachment; filename=cobrancas.csv",
                    "Pragma" => "no-cache",
                    "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                    "Expires" => "0"
                );

                $callback = function() use ($cobrancas) {
                    $file = fopen('php://output', 'w');
                    fputcsv($file, ['Cliente', 'TXID', 'Valor', 'Status', 'Data Emissão', 'Data Vencimento']);

                    foreach($cobrancas as $cobranca) {
                        fputcsv($file, [
                            $cobranca->cliente->nome,
                            $cobranca->txid,
                            $cobranca->valor,
                            $cobranca->status,
                            $cobranca->created_at->format('d/m/Y H:i'),
                            $cobranca->data_vencimento->format('d/m/Y')
                        ]);
                    }
                    fclose($file);
                };

                return Response::stream($callback, 200, $headers);

            case 'pdf':
                // Implementar exportação PDF
                return response()->json(['error' => 'Formato PDF em desenvolvimento']);

            case 'excel':
                // Implementar exportação Excel
                return response()->json(['error' => 'Formato Excel em desenvolvimento']);

            default:
                return response()->json(['error' => 'Formato não suportado']);
        }
    }

    public function verificarNoVencimento()
    { 
        log::info('Verificando cobranças vencidas');
        
        try {
            $cobrancasVencidas = Cobranca::where('status_pagamento', 'ATIVO')
                ->where('data_vencimento', '<', now()->addDay(-1))
                ->get();  
                
            // Filtra cobranças não verificadas no vencimento
            $cobrancasVencidas = $cobrancasVencidas->filter(function($cobranca) {
                return !$cobranca->isVerificadaNoVencimento();
            });

            foreach ($cobrancasVencidas as $cobranca) {
                $this->verificar($cobranca->txid);
                $cobranca->update(['verif_no_venc' => true]); // Adicionar informação de verificação após vencimento
            }

            return response()->json(['success' => true]);

        } catch (\Throwable $th) {
            Log::error('Erro ao verificar cobranças vencidas: ' . $th->getMessage());
            return response()->json(['success' => false, 'error' => $th->getMessage()], 500);
        }
    }

    public function verificar($txid)
    { 
       
        try {
            $cobranca = Cobranca::where('txid', $txid)->firstOrFail();
            $PixService = new PixService();
            $consultaSicredi = $PixService->consultarCobranca($txid);
            $statusAnterior = $cobranca->status_pagamento;

 
            if ($consultaSicredi['status'] === 'ATIVA' && $cobranca->status_pagamento !== 'ATIVO') {
                // Se já tiver passado data de expiracao mudar status para cancelada
                if ($cobranca['expiracao'] < now()) {
                    $consultaSicredi['status'] = $cobranca->status_pagamento = Cobranca::PAGAMENTO_EXPIRADO; // TODO - Mudar para EXPIRADO
                    $this->registrarTransacao($cobranca->titulo, $statusAnterior, $consultaSicredi, $cobranca);
                } else {
                    $cobranca->status_pagamento = 'ATIVO';
                    $this->registrarTransacao($cobranca->titulo, $statusAnterior, $consultaSicredi, $cobranca);
                }
            } elseif ($consultaSicredi['status'] === 'REMOVIDA_PELO_USUARIO_RECEBEDOR' && $cobranca->status_pagamento !== 'CANCELADO') {
                $cobranca->status_pagamento = 'CANCELADO';
                $this->registrarTransacao($cobranca->titulo, $statusAnterior, $consultaSicredi, $cobranca);
            } elseif ($consultaSicredi['status'] === 'CONCLUIDA' && $cobranca->status_pagamento !== 'PAGO') {
                $cobranca->status_pagamento = 'PAGO';
                $cobranca->data_pagamento = Carbon::parse($consultaSicredi['pix'][0]['horario']);
                $this->registrarTransacao($cobranca->titulo, $statusAnterior, $consultaSicredi, $cobranca);
            } elseif ($consultaSicredi['status'] === 'REMOVIDA_PELO_PSP' && $cobranca->status_pagamento !== 'VENCIDO') {
                $cobranca->status_pagamento = 'VENCIDO';
                $this->registrarTransacao($cobranca->titulo, $statusAnterior, $consultaSicredi, $cobranca);
            }

            $cobranca->save();

            // TODO - Atualizar status no Sênior se for paga
            

            return response()->json(['status' => $consultaSicredi['status']]);

        } catch (Exception $e) {
            Log::error('Erro ao verificar cobrança: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao verificar cobrança'], 500);
        }
    }

    private function registrarTransacao($titulo, $statusAnterior, $consultaSicredi, $cobranca) {
        Transacao::registrar($titulo, Transacao::TIPO_VERIFICACAO, [
            'cobranca_id' => $cobranca->id,
            'titulo_id' => $titulo->id,
            'status' => Transacao::STATUS_SUCESSO,
            'descricao' => 'Status cobrança consultaSicredi alterada',
            'dados_adicionais' => 'Titulo alterado de status: ' . $statusAnterior . ' para: ' . $consultaSicredi['status']
        ]);

        $sitTit = match ($consultaSicredi['status']) {
            'PENDENTE' => 'AB',
            'ATIVA' => 'AB',
            'REMOVIDA_PELO_USUARIO_RECEBEDOR' => 'CA',
            'CONCLUIDA' => 'LQ',
            'REMOVIDA_PELO_PSP' => 'CA',
        };

        Titulo::where('id', $titulo->id)->update(['sitTit' => $sitTit]);

        if ($sitTit === 'CA') {
            $registradoCancelamento = Transacao::registrar($titulo, Transacao::TIPO_CANCELAMENTO, [
                'cobranca_id' => $cobranca->id,
                'titulo_id' => $titulo->id,
                'status' => Transacao::STATUS_SUCESSO,
                'descricao' => 'Status cobrança alterada',
                'dados_adicionais' => 'Titulo alterado de status: ' . $statusAnterior . ' para: ' . $consultaSicredi['status']
            ]);
        }

        // Registrar baixa no Sênior se sitTit for LQ ou CA
            $wrapper = new SoapWrapper();
            $pixService = new PixService();
            $seniorsService = new SeniorsService($wrapper, $pixService);

        if ($sitTit === 'LQ') {
            $seniorsService->registrarBaixa([
                'tipoBaixa' => 'pagamento',
                'titulo' => $titulo,
                'cobranca_id' => $cobranca->id,
                'codEmp' => $cobranca->titulo->codEmp,
                'codFil' => $cobranca->titulo->codFil,
                'numTit' => $cobranca->titulo->numTit,
                'codTpt' => $cobranca->titulo->codTpt,
                'codCrt' => $cobranca->titulo->codCrt,
                'numCco' => $cobranca->titulo->numCco,  // TODO - Precisa ver quem informa este código 01, 99 (para cliente 512 numCco = 1118-5) Movimento de fluxo de caixa entra na rubrica da Ascar geral.
                'txid' => $consultaSicredi['txid'],
                'valor' => $consultaSicredi['pix'][0]['valor'],
                'dataPagamento' => $consultaSicredi['pix'][0]['horario'],
                'endToEndId' => $consultaSicredi['pix'][0]['endToEndId'],
                'numDoc' => $cobranca->titulo->numDoc,
                'codTns' => 90350 // TODO - Verificar se não tem que ser o codTns padrão de baixa por pagamento 90300 !!!
            ]);
        } else if ($sitTit === 'CA' && $registradoCancelamento) {
            $resultadoSapiens = $seniorsService->registrarBaixa([  // TODO - Pode ser usado o baixarPorCancelamento
                'tipoBaixa' => 'cancelamento',
                'codEmp' => $cobranca->titulo->codEmp,
                'codFil' => $cobranca->titulo->codFil,
                'numTit' => $cobranca->titulo->numTit,
                'codTpt' => $cobranca->titulo->codTpt,
                'codCrt' => $cobranca->titulo->codCrt,
                'numCco' => '',  // TODO - Precisa ver quem informa este código
                'txid' => null,
                'valor' => $cobranca->titulo->vlrOri,
                'dataPagamento' => null,
                'endToEndId' => null,
                'numDoc' => null,
                'codTns' => 90354 // TODO - Verificar se não tem que ser o codTns padrão de baixa por pagamento 90300 !!!
            ]);
        }

        if (isset($resultadoSapiens)) {
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
                    'descricao' => 'Erro retorno ao registrar cancelamento no SAPIENS',
                    'dados_adiconais' => $resultadoSapiens['erro'] ?? null,
                ]);
                $cobranca->update([
                    'status_senior' => Cobranca::SENIOR_ERRO,
                    'msg_senior' => json_encode($resultadoSapiens['status'] ?? '')
                ]);
            }
        }

        // Enviar e-mail informando alteração de status
        $details = [
            'tipo_erro' => 'ATUALIZAÇÃO AUTOMÁTICA DE COBRANÇA',
            'error' => 'Atualização automatica da cobrança: ' . $cobranca->txid,
            'txid' => $cobranca->txid,
            'codEmp' => $cobranca->titulo->codEmp,
            'codFil' => $cobranca->titulo->codFil,
            'numTit' => $cobranca->titulo->numTit,
            'codTpt' => $cobranca->titulo->codTpt,
            'valor' => $cobranca->valor,
            'descricao' => 'Titulo alterado de status: ' . $statusAnterior . ' para: ' . $consultaSicredi['status'] . ' - Vencimento: ' . $cobranca->data_vencimento
        ];

        if(Mail::to(config('services.admin.email'))->send(new ErrorNotification($details))) {
            log::info('L-CC-Mail Email enviado com sucesso', $details);
        }
        
    }

    public function cancelar($txid)
    {
        # Este método realiza o cancelamento e registro do cancelamento do título no banco de dados e no Sapiens 

        //log::info($txid);
        $wrapper = new SoapWrapper();
        $pixService = new PixService();
        $seniorsService = new SeniorsService($wrapper, $pixService);
        
        $baixa = $seniorsService->baixaPorCancelamento($txid);
        
        return $baixa;
    }

    public function cancelarNaExpiracao()
    {

        // TODO - Verificar se pagamento deve ter a situação do título no Sapiens mudado para CANCELADO quando ocorrer a expiração ou se isso impacta na contabilidade

        $cobrancas = Cobranca::where('status_pagamento', 'ATIVO')
            ->where('expiracao', '<', now())
            ->get()
            // ->each(function ($cobranca) {
            //     $this->cancelar($cobranca->txid);
            // })
            ;

        foreach ($cobrancas as $cobranca) {
            $cobranca->update([
                'status_pagamento' => Cobranca::PAGAMENTO_EXPIRADO,
            ]);
        }

            
            return response()->json([
                'success' => true,
               'message' => 'Cobranças canceladas na expiração',
               'TXIDs' => $cobrancas->pluck('txid')->toArray()
            ]);

        
    }

    public function location($txid)
    {
        try {
            $PixService = new PixService();
            $consultaSicredi = $PixService->consultarCobranca($txid); //dd($consultaSicredi);

            // Verificar se a cobrança é válida
            $dataVencimento = isset($consultaSicredi['calendario']['dataDeVencimento']) 
                ? Carbon::parse($consultaSicredi['calendario']['dataDeVencimento']) 
                : null;
            
            $validadeAposVencimento = $consultaSicredi['calendario']['validadeAposVencimento'] ?? 0;
            $status = $consultaSicredi['status'] ?? 'DESCONHECIDO';
            
            // Verificar se a cobrança ainda é válida
            $isValida = true;
            $mensagemValidade = '';
            
            if ($status !== 'ATIVA') {
                $isValida = false;
                $mensagemValidade = "Cobrança não está ativa (Status: {$status})";
            } elseif ($dataVencimento) {
                $dataLimite = $dataVencimento->copy()->addDays($validadeAposVencimento + 1);
                if (now() > $dataLimite) {
                    $isValida = false;
                    $mensagemValidade = "Cobrança vencida desde " . $dataVencimento->format('d/m/Y');
                }
            }

            // Formatar os dados para a view
            $dadosFormatados = [
                'validade' => [
                    'isValida' => $isValida,
                    'mensagem' => $mensagemValidade,
                    'dataVencimentoFormatada' => $dataVencimento ? $dataVencimento->format('d/m/Y') : 'N/A',
                    'validadeAposVencimento' => $validadeAposVencimento . ' dias'
                ],
                'status' => $status,
                'txid' => $consultaSicredi['txid'] ?? '',
                'valor' => [
                    'original' => $consultaSicredi['valor']['original'] ?? '0.00',
                    'multa' => $consultaSicredi['valor']['multa']['valorPerc']?? '0.00',
                    'juros' => $consultaSicredi['valor']['juros']['valorPerc']?? '0.00'
                ],
                'calendario' => [
                    'criacao' => $consultaSicredi['calendario']['criacao'] ?? '',
                    'dataDeVencimento' => $consultaSicredi['calendario']['dataDeVencimento'] ?? ''
                ],
                'devedor' => [
                    'nome' => $consultaSicredi['devedor']['nome'] ?? '',
                    'cnpj' => $consultaSicredi['devedor']['cnpj'] ?? ''
                ],
                'recebedor' => [
                    'nome' => $consultaSicredi['recebedor']['nome'] ?? '',
                    'cnpj' => $consultaSicredi['recebedor']['cnpj'] ?? '',
                    'cidade' => $consultaSicredi['recebedor']['cidade'] ?? '',
                    'uf' => $consultaSicredi['recebedor']['uf'] ?? ''
                ],
                'loc' => $consultaSicredi['loc'] ?? [],
                'consultaSicredi' => $consultaSicredi['consultaSicredi'] ?? []
            ];

            return view('livewire.cobrancas.location', [
                'data' => $dadosFormatados,
                'type' => 'json'
            ]);

        } catch (Exception $e) {
            Log::error('Erro ao processar location consultaSicredi: ' . $e->getMessage());
            return view('livewire.cobrancas.location', [
                'error' => 'Erro ao processar dados do consultaSicredi: ' . $e->getMessage()
            ]);
        }
    }
}
