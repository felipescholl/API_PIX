Endereço documentação: https://documentacao.senior.com.br/gestaoempresarialerp/5.10.4/#webservices/com_senior_g5_co_mfi_cre_titulos.htm#GravarTitulosCR

Endereço Web Service Emater: {
  "produção": "https://webp22.seniorcloud.com.br:30211/g5-senior-services/sapiens_Synccom_senior_g5_co_mfi_cre_titulos?wsdl"
}

Gestão Empresarial PME | GO UP - versão 5.10.2 (XTended)


No conteúdo deste manual são citados Identificadores de Regras, porém, no GO UP não é possível incluir, excluir ou alterar identificadores e suas regras associadas, pois o sistema possui funções nativas devido aos processos de negócio pré-definidos.
Esta versão do sistema foi descontinuada e não recebe atualizações e novas implementações. Acesse a documentação da versão 5.10.3 aqui
Integrações com outros sistemas > Web services > Web services disponíveis no Gestão Empresarial > Com.senior.g5.co.mfi.cre.titulos

Web service Com.senior.g5.co.mfi.cre.titulos
Tipo de execução
Para cada tipo de execução, existem diferentes parâmetros que podem ser comuns a todas as portas.

Autenticação
Caso seja utilizada alguma forma de autenticação para integração de informações através de web services, é necessário identificar o tipo no parâmetro <encryption>, conforme seus valores possíveis.

Campos numéricos
Orientação válida para qualquer campo de web service que possui objetivo de receber valores, independentemente do seu tipo ser Integer, Double e String. Estas orientações devem ser seguidas nas requisições efetuadas via SOAP e em execuções efetuadas através do SGI, relatórios e regras LSP.

OpenCampos que representam valores monetários, quantidade e percentual e estão declarados como String
Envio no formato ZZZZ,ZZ
É fundamental não enviar os campos numéricos com separador de milhar, pois ocorrerá erro ao executar a requisição
Obrigatória a utilização do separador decimal com vírgula, e não com ponto
Obrigatória a utilização do zero a direita. Por exemplo, se o valor for 350,20, a requisição deve ser enviada com este exato valor. Se o valor enviado for enviado como 350,2, o sistema não irá interpretar a requisição adequadamente
OpenExemplo:
number(005,2) = 350,20 - o sistema espera que o número digitado contenha até 3 casas antes da vírgula e obrigatoriamente duas após;

number(015,2): 35000,20 - o sistema espera que o número digitado contenha até 13 casas antes da vírgula e obrigatoriamente duas após;

number(008,4) = 3200,2074 - o sistema espera que o número digitado contenha até 4 casas antes da vírgula e obrigatoriamente duas após.

OpenCampos que representam valores monetários, quantidade e percentual e não estão declarados como String
Envio no formato ZZZZ.ZZ
É fundamental não enviar os campos numéricos com separador de milhar, pois ocorrerá erro ao executar a requisição
Obrigatória a utilização do separador decimal com ponto, e não com vírgula
OpenExemplo:
number(005,2) = 350.20 - o sistema espera que o número digitado contenha até 3 casas antes da vírgula e obrigatoriamente duas após;
number(015,2): 35000.20 - o sistema espera que o número digitado contenha até 13 casas antes da vírgula e obrigatoriamente duas após;
number(008,4) = 3200.2074 - o sistema espera que o número digitado contenha até 4 casas antes da vírgula e obrigatoriamente duas após.


WSDL
Síncrono: http://example.com/g5-senior-services/sapiens_Synccom_senior_g5_co_mfi_cre_titulos?wsdl
Assíncrono: http://example.com/g5-senior-services/sapiens_Asynccom_senior_g5_co_mfi_cre_titulos?wsdl
Agendado: http://example.com/g5-senior-services/sapiens_Scheduledcom_senior_g5_co_mfi_cre_titulos?wsdl
Portas
ConsultarTitulosCR
ConsultarTitulosAbertosCR
GravarTitulosCR
GravarTitulosCR
EntradaTitulosLoteCR
BaixarTitulosCR
ExcluirTitulosCR
SubstituirTitulosCR
GerarBaixaAproveitamentoCR
GerarBaixaPorLoteCR
EstornoBaixaTitulosCR
ExportarBaixaTitulosReceberVenda
ExportarBaixaTitulosReceberIntegração
ProcessarAVM
ProcessarVariacaoCambial
ProcessarTitulosAVP
AlteracaoParcialTitulosCR
OpenConsultarTitulosCR
Finanças - Gestão de Contas a Receber - Contas à Receber - Consultar Títulos

Necessita autenticação: sim.

Situação de versão: atual

Versão: 3

Requisição:

<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.senior.com.br">
  <soapenv:Body>
    <ser:ConsultarTitulosCR>
      <user>String</user>
      <password>String</password>
      <encryption>Integer</encryption>
      <parameters>
        <codEmp>String</codEmp>
        <codFil>String</codFil>
        <codCli>String</codCli>
        <filNff>String</filNff>
        <numNff>String</numNff>
        <numTit>String</numTit>
        <codTpt>String</codTpt>
        <dataBuild>String</dataBuild>
        <codRep>String</codRep>
      </parameters>
    </ser:ConsultarTitulosCR>
  </soapenv:Body>
</soapenv:Envelope>
Parâmetros da requisição:

Nome	Tipo	Descrição
codEmp	String	(Obrigatório) - Number(004) - Código da empresa
codFil	String	(Opcional) - Number(005) - Código da filial
codCli	String	(Obrigatório) - Number(009) - Código do cliente do título a receber
filNff	String	(Opcional) - Number(005) - Código da filial
numNff	String	(Opcional) - Number(005) - Código da filial
numTit	String	(Opcional) - String(015) - Número do título a receber
codTpt	String	(Opcional) - String(003) - Código do tipo de título a receber
dataBuild	String	Mantido por compatibilidade.
codRep	String	Código do Representante
Resposta:

Observação

Envelope SOAP de resposta de requisições síncronas. Para requisições assíncronas ou agendamentos, a resposta é apenas uma String chamada "result" com o valor "OK", se foi executado com sucesso ou, caso contrário, a mensagem do erro ocorrido.

<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.senior.com.br">
  <soapenv:Body>
    <ser:ConsultarTitulosCRResponse>
      <result>
        <titulos>
          <codEmp>Integer</codEmp>
          <codFil>String</codFil>
          <numTit>String</numTit>
          <codTpt>String</codTpt>
          <codTns>String</codTns>
          <codNtg>String</codNtg>
          <datEmi>String</datEmi>
          <datEnt>String</datEnt>
          <codCli>String</codCli>
          <codSac>String</codSac>
          <codRep>String</codRep>
          <codCrp>String</codCrp>
          <obsTcr>String</obsTcr>
          <vctOri>String</vctOri>
          <vlrOri>String</vlrOri>
          <codFpg>String</codFpg>
          <datPpt>String</datPpt>
          <codMoe>String</codMoe>
          <perCom>String</perCom>
          <vlrBco>String</vlrBco>
          <vlrCom>String</vlrCom>
          <perJrs>String</perJrs>
          <tipJrs>String</tipJrs>
          <jrsDia>String</jrsDia>
          <tolJrs>String</tolJrs>
          <perMul>String</perMul>
          <tolMul>String</tolMul>
          <cheBan>String</cheBan>
          <cheAge>String</cheAge>
          <cheCta>String</cheCta>
          <cheNum>String</cheNum>
          <codPor>String</codPor>
          <codCrt>String</codCrt>
          <titBan>String</titBan>
          <numArb>String</numArb>
          <codIn1>String</codIn1>
          <codIn2>String</codIn2>
          <datNeg>String</datNeg>
          <jrsNeg>String</jrsNeg>
          <mulNeg>String</mulNeg>
          <dscNeg>String</dscNeg>
          <outNeg>String</outNeg>
          <ctaFin>String</ctaFin>
          <ctaRed>String</ctaRed>
          <codCcu>String</codCcu>
          <proJrs>String</proJrs>
          <codMpt>String</codMpt>
          <perDsc>String</perDsc>
          <vlrDsc>String</vlrDsc>
          <tolDsc>String</tolDsc>
          <datDsc>String</datDsc>
          <numPrj>String</numPrj>
          <codFpj>String</codFpj>
          <cpgNeg>String</cpgNeg>
          <taxNeg>String</taxNeg>
          <catTef>String</catTef>
          <nsuTef>String</nsuTef>
          <comRec>String</comRec>
          <vlrDca>String</vlrDca>
          <vlrDcb>String</vlrDcb>
          <vlrOud>String</vlrOud>
          <filNff>String</filNff>
          <numNff>String</numNff>
          <cnpjFilial>String</cnpjFilial>
          <ideTxi>String</ideTxi>
          <urlPix>String</urlPix>
          <emvQrc>String</emvQrc>
          <msgPag>String</msgPag>
        </titulos>
        <tipoRetorno>String</tipoRetorno>
        <mensagemRetorno>String</mensagemRetorno>
        <erroExecucao>String</erroExecucao>
      </result>
    </ser:ConsultarTitulosCRResponse>
  </soapenv:Body>
</soapenv:Envelope>
Atributos da resposta:

Nome	Tipo	Descrição
erroExecucao	String	Indica erros ocorridos no servidor ao executar o serviço, podendo conter os seguintes valores:Vazio ou nulo, indicando que a execução foi feita com sucessoA mensagem do erro ocorrido no servidorSó impede a gravação quando o retorno.tipRet for igual a "2"
titulos	Set	
titulos.codEmp	Integer	(Obrigatório) - Number(004) - Código da empresa
titulos.codFil	String	(Obrigatório) - Number(005) - Código da filial
titulos.numTit	String	(Obrigatório) - String(010) - Número do título a receber
titulos.codTpt	String	(Obrigatório) - String(003) - Código do tipo de título a receber
titulos.codTns	String	(Obrigatório) - String(005) - Código da transação que gerou o título a receber
titulos.codNtg	String	(Opcional) - Number(004) - Código da natureza de gasto
titulos.datEmi	String	(Obrigatório) - Date - Data de emissão do título a receber
titulos.datEnt	String	(Obrigatório) - Date - Data de entrada do título a receber
titulos.codCli	String	(Obrigatório) - Number(009) - Código do cliente do título a receber
titulos.codSac	String	(Opcional) - Number(014) - Código do sacado
titulos.codRep	String	Código do Representante
titulos.codRep	String	(Obrigatório) - Number(004) - Código do representante do título a receber
titulos.codCrp	String	(Opcional) - String(003) - Código do grupo de contas a receber
titulos.obsTcr	String	(Opcional) - String(250) - Observação para o título
titulos.vctOri	String	(Obrigatório) - Date - Data do vencimento original do título a receber
titulos.vlrOri	String	(Obrigatório) - Number(015,2) - Valor original do título a receber
titulos.codFpg	String	(Opcional) - Number(002) - Código da forma de pagamento
titulos.datPpt	String	(Obrigatório) - Date - Data do provável pagamento do título
titulos.codMoe	String	(Opcional) - String(003) - Código da moeda do título a receber
titulos.perCom	String	(Opcional) - Number(007,4) - Percentual de comissão do título a receber
titulos.vlrBco	String	(Opcional) - Number(015,2) - Valor base da comissão do título
titulos.vlrCom	String	(Opcional) - Number(015,2) - Valor da comissão do título a receber
titulos.perJrs	String	(Opcional) - Number(005,2) - Percentual de juros de mora ao mês do título a receber
titulos.tipJrs	String	(Opcional) - String(001) - Indicativo se os juros de mora é simples ou composto - Lista: S = Juros Simples, C = Juros Composto
titulos.jrsDia	String	(Opcional) - Number(009,2) - Valor de juros de mora ao dia do título a receber
titulos.tolJrs	String	(Opcional) - Number(004) - Dias de tolerância para os juros de mora do título a receber
titulos.perMul	String	(Opcional) - Number(005,2) - Percentual de multa prevista para o título a receber
titulos.tolMul	String	(Opcional) - Number(004) - Dias de tolerância para a multa prevista para o título a receber
titulos.cheBan	String	(Opcional) - String(003) - Número do banco na FEBRABAN do cheque
titulos.cheAge	String	(Opcional) - String(007) - Número da agência do banco do cheque
titulos.cheCta	String	(Opcional) - String(014) - Número da conta no banco do cheque
titulos.cheNum	String	(Opcional) - String(010) - Número do cheque no banco
titulos.codPor	String	(Obrigatório) - String(004) - Código do portador do título
titulos.codCrt	String	(Obrigatório) - String(002) - Código da carteira do título a receber
titulos.titBan	String	(Opcional) - String(020) - Número do título no banco (nosso número)
titulos.numArb	String	(Opcional) - Number(009) - Número de arquivo de remessa para banco
titulos.codIn1	String	(Opcional) - String(003) - Código da primeira instrução bancária
titulos.codIn2	String	(Opcional) - String(003) - Código da segunda instrução bancária
titulos.datNeg	String	(Opcional) - Date - Data base dos valores negociados (data até)
titulos.jrsNeg	String	(Opcional) - Number(015,2) - Valor dos juros negociados
titulos.mulNeg	String	(Opcional) - Number(015,2) - Valor da multa negociada
titulos.dscNeg	String	(Opcional) - Number(015,2) - Valor dos descontos negociados
titulos.outNeg	String	(Opcional) - Number(015,2) - Valor de outros valores negociados
titulos.ctaFin	String	(Opcional) - Number(007) - Conta financeira reduzida
titulos.ctaRed	String	(Opcional) - Number(007) - Conta contábil reduzida
titulos.codCcu	String	(Opcional) - String(009) - Código do centro de custo
titulos.proJrs	String	(Obrigatório) - String(001) - Indicativo se a prorrogação do vencimento é com juros - Lista: S = Sim, N = Não
titulos.codMpt	String	(Opcional) - String(003) - Código do motivo de prorrogação do título
titulos.perDsc	String	(Opcional) - Number(005,2) - Percentual/Valor do desconto do título
titulos.vlrDsc	String	(Opcional) - Number(015,2) - Valor do desconto a ser concedido ao título a receber
titulos.tolDsc	String	(Opcional) - Number(004) - Dias de tolerância para desconto
titulos.datDsc	String	(Opcional) - Date - Data válidas para desconto do título
titulos.numPrj	String	(Opcional) - Number(008) - Número do projeto
titulos.codFpj	String	(Opcional) - Number(004) - Código da fase do projeto
titulos.cpgNeg	String	(Opcional) - String(006) - Código da condição de pagamento negociada
titulos.taxNeg	String	(Opcional) - Number(013,10) - Taxa negociada
titulos.catTef	String	(Opcional) - String(100) - Código de Autorização da Transação (TEF - Sitef)
titulos.nsuTef	String	(Opcional) - String(100) - Número Sequencial Único da Transação TEF (Host - Operadora)
titulos.comRec	String	(Opcional) - Number(005,2) - Percentual de comissão pago no recebimento do título a receber
titulos.vlrDca	String	(Opcional) - Number(015,2) - Valor das despesas cartoriais
titulos.vlrDcb	String	(Opcional) - Number(015,2) - Valor das despesas de cobrança
titulos.vlrOud	String	(Opcional) - Number(015,2) - Valor de outras despesas
titulos.filNff	String	Código da filial da nota fiscal fatura origem do título
titulos.numNff	String	Número da nota fiscal fatura origem do título
titulos.cnpjFilial	String	(Obrigatório) - Number(015) - Número do cadastro nacional da pessoa jurídica da filial da empresa
titulos.ideTxi	String	(Obrigatório) - String(035) - Id. Transação PIX
titulos.urlPix	String	(Obrigatório) - String(100) - Location URL
titulos.emvQrc	String	(Obrigatório) - String(500) - EMV do QR-Code
titulos.msgPag	String	(Obrigatório) - String(250) - Mensagem do Pagador Final
tipoRetorno	String	(Obrigatório) - Number(001) - Indicativo do tipo de retorno da solicitação - Lista: 1 = Processado com sucesso, 2 = Processado com erro
mensagemRetorno	String	(Obrigatório) - String(250) - Mensagem de retorno da importação
OpenConsultarTitulosAbertosCR
Finanças - Gestão de Contas a Receber - Contas à Receber - Consultar Títulos Abertos com Rateios

Necessita autenticação: Sim

Situação de versão: Atual

Versão: 1

Importante

O web service não apresenta títulos com situação AE (Aberto Encontro de Contas) e CE (Aberto CE - Preparação Cobrança Escritural). Ele filtra o campo de transação RECDEC(Adiciona/entradas ou subtrai/baixas dos saldos duplicatas, outros ou créditos) e LISMOD (Módulo pertencente a transação), da seguinte forma:

Se "Tipo Movimento" = 1 - então será filtrado pelo campo Adiciona/Subtrai = 1 (RECDEC);
Se "Tipo Movimento" = 2 - então será filtrado pelo campo Adiciona/Subtrai = 2 (RECDEC) e o Módulo = 'CRE' (LISMOD);
Se "Tipo Movimento" = 3 ou "Tipo Movimento" = vazio - então será filtrado pelo Módulo = 'CRP' (LISMOD) e pelo campo Adiciona/Subtrai = 1 (RECDEC) ou pelo Módulo = 'CRE' (LISMOD).
Requisição:

<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.senior.com.br">
  <soapenv:Body>
    <ser:ConsultarTitulosAbertosCR>
      <user>String</user>
      <password>String</password>
      <encryption>Integer</encryption>
      <parameters>
        <codEmp>Integer</codEmp>
        <codFil>Integer</codFil>
        <codCli>String</codCli>
        <filNfv>Integer</filNfv>
        <codSnf>String</codSnf>
        <numNfv>Integer</numNfv>
        <filCtr>Integer</filCtr>
        <numCtr>Integer</numCtr>
        <seqImo>Integer</seqImo>
        <filNff>Integer</filNff>
        <numNff>Integer</numNff>
        <filPed>Integer</filPed>
        <numPed>Integer</numPed>
        <filNfc>Integer</filNfc>
        <forNfc>Integer</forNfc>
        <snfNfc>String</snfNfc>
        <numNfc>Integer</numNfc>
        <vctIni>String</vctIni>
        <vctFim>String</vctFim>
        <datBas>String</datBas>
        <retRat>String</retRat>
        <indVrj>String</indVrj>
        <tipTit>String</tipTit>
        <numTit>String</numTit>
        <codTpt>String</codTpt>
      </parameters>
    </ser:ConsultarTitulosAbertosCR>
  </soapenv:Body>
</soapenv:Envelope>
Parâmetros da requisição:

Nome	Tipo	Descrição
codEmp	Integer	(Obrigatório) - Number(004) - Código da empresa
codFil	Integer	(Obrigatório) - Number(005) - Código da filial
codCli	String	(Obrigatório) - (Abrangência) - Código do cliente do título a receber
filNfv	Integer	(Opcional) - Number(004 - Código da filial da nota fiscal de saída
codSnf	String	(Opcional) - String(003) - Código da série da nota fiscal origem do título
numNfv	Integer	(Opcional) - Number(009 - Número da nota fiscal origem do título
filCtr	Integer	(Opcional) - Number(005) - Código da filial do contrato de venda
numCtr	Integer	(Opcional) - Number(009) - Número do Contrato que originou o título
seqImo	Integer	(Opcional) - Number(003) - Sequência do item do contrato imobiliário que originou o título
filNff	Integer	(Opcional) - Number(005) - Código da filial da nota fiscal fatura origem do título
numNff	Integer	(Opcional) - Number(004) - Número da nota fiscal fatura origem do título
filPed	Integer	(Opcional) - Number(005) - Código da filial do pedido origem do título
numPed	Integer	(Opcional) - Number(009) - Número do pedido origem do título
filNfc	Integer	(Opcional) - Number(005) - Código da filial da nota fiscal de entrada
forNfc	Integer	(Opcional) - Number(009) - Fornecedor da Nota Fiscal de Entrada origem do título
snfNfc	String	(Opcional) - String(003) - Código da série da nota fiscal de entrada de origem do título
numNfc	Integer	(Opcional) - Number(009) - Número da nota fiscal de entrada que originou o título
vctIni	DateTime	(Opcional) - Date(000) - Vencimento inicial
vctFim	DateTime	(Opcional) - Date(000) - Vencimento final
datBas	DateTime	(Opcional) - Date(000) - Data base para cálculos de outros valores
retRat	String	Parâmetro que irá receber: "S - Retorna rateios" ou "N - Não retorna rateios".
indVrj	String	(Opcional) - String(001) - Indicativo de que a consulta está sendo realizada a partir do sistema de varejo. Lista: S = Consulta efetuada a partir do sistema de varejo, N = Consulta não é efetuada a partir do sistema de varejo.
Quando o elemento não for informado, será considerado "N" como valor para este elemento.
A consulta de títulos para o sistema de varejo não retorna os títulos cuja forma de pagamento seja Cartão ou Cheque.
tipTit	String	(Opcional) - String(001) - Tipo do movimento. Lista: 1 = Duplicatas\Outros, 2 = Créditos, 3 ou nulo = todos menos créditos previstos que é o funcionamento atual.
numTit	String	(Opcional) - String(015) - Número do título a receber
codTpt	String	(Opcional) - String(003) - Código do tipo de título a receber
Resposta:

Observação

Envelope SOAP de resposta de requisições síncronas. Para requisições assíncronas ou agendamentos, a resposta é apenas uma String chamada "result" com o valor "OK", se foi executado com sucesso ou, caso contrário, a mensagem do erro ocorrido.

<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.senior.com.br">
  <soapenv:Body>
    <ser:ConsultarTitulosAbertosCRResponse>
      <result>
        <tipoRetorno>String</tipoRetorno>
        <titulos>
          <codEmp>Integer</codEmp>
          <codFil>Integer</codFil>
          <numTit>String</numTit>
          <codTpt>String</codTpt>
          <codTns>String</codTns>
          <codNtg>Integer</codNtg>
          <sitTit>String</sitTit>
          <datEmi>String</datEmi>
          <datEnt>String</datEnt>
          <codCli>Integer</codCli>
          <codSac>Double</codSac>
          <codRep>Integer</codRep>
          <codCrp>String</codCrp>
          <obsTcr>String</obsTcr>
          <vctOri>String</vctOri>
          <vlrOri>Double</vlrOri>
          <codFpg>Integer</codFpg>
          <vctPro>String</vctPro>
          <proJrs>String</proJrs>
          <codMpt>String</codMpt>
          <datPpt>String</datPpt>
          <vlrAbe>Double</vlrAbe>
          <codMoe>String</codMoe>
          <cotEmi>Double</cotEmi>
          <codFrj>String</codFrj>
          <cotFrj>Double</cotFrj>
          <perCom>Double</perCom>
          <comRec>Double</comRec>
          <vlrBco>Double</vlrBco>
          <vlrCom>Double</vlrCom>
          <datDsc>String</datDsc>
          <tolDsc>Integer</tolDsc>
          <vlrDsc>Double</vlrDsc>
          <perDsc>Double</perDsc>
          <perJrs>Double</perJrs>
          <tipJrs>String</tipJrs>
          <jrsDia>Double</jrsDia>
          <tolJrs>Integer</tolJrs>
          <perMul>Double</perMul>
          <tolMul>Integer</tolMul>
          <cheBan>String</cheBan>
          <cheAge>String</cheAge>
          <cheCta>String</cheCta>
          <cheNum>String</cheNum>
          <codPor>String</codPor>
          <codCrt>String</codCrt>
          <titBan>String</titBan>
          <numArb>Integer</numArb>
          <codOcr>String</codOcr>
          <codIn1>String</codIn1>
          <codIn2>String</codIn2>
          <datNeg>String</datNeg>
          <jrsNeg>Double</jrsNeg>
          <mulNeg>Double</mulNeg>
          <dscNeg>Double</dscNeg>
          <outNeg>Double</outNeg>
          <cpgNeg>String</cpgNeg>
          <taxNeg>Double</taxNeg>
          <vlrDca>Double</vlrDca>
          <vlrDcb>Double</vlrDcb>
          <vlrOud>Double</vlrOud>
          <numPrj>Integer</numPrj>
          <codFpj>Integer</codFpj>
          <ctaFin>Integer</ctaFin>
          <ctaRed>Integer</ctaRed>
          <codCcu>String</codCcu>
          <filNfv>Integer</filNfv>
          <codSnf>String</codSnf>
          <numNfv>Integer</numNfv>
          <filCtr>Integer</filCtr>
          <numCtr>Integer</numCtr>
          <seqImo>Integer</seqImo>
          <filNff>Integer</filNff>
          <numNff>Integer</numNff>
          <filPed>Integer</filPed>
          <numPed>Integer</numPed>
          <filNfc>Integer</filNfc>
          <forNfc>Integer</forNfc>
          <numNfc>Integer</numNfc>
          <snfNfc>String</snfNfc>
          <catTef>String</catTef>
          <nsuTef>String</nsuTef>
          <vlrJrs>Double</vlrJrs>
          <vlrMul>Double</vlrMul>
          <vlrOac>Double</vlrOac>
          <vlrCor>Double</vlrCor>
          <vlrEnc>Double</vlrEnc>
          <vlrDes>Double</vlrDes>
          <vlrOde>Double</vlrOde>
          <titEfe>String</titEfe>
          <dupCre>String</dupCre>
          <rateios>
            <seqMov>Integer</seqMov>
            <seqRat>Integer</seqRat>
            <datBas>String</datBas>
            <codTns>String</codTns>
            <mesAno>String</mesAno>
            <criRat>Integer</criRat>
            <somSub>Integer</somSub>
            <numPrj>Integer</numPrj>
            <codFpj>Integer</codFpj>
            <ctaFin>Integer</ctaFin>
            <ctaRed>Integer</ctaRed>
            <perCta>Double</perCta>
            <vlrCta>Double</vlrCta>
            <codCcu>String</codCcu>
            <perRat>Double</perRat>
            <vlrRat>Double</vlrRat>
            <obsRat>String</obsRat>
            <tipOri>String</tipOri>
          </rateios>
        </titulos>
        <mensagemRetorno>String</mensagemRetorno>
        <erroExecucao>String</erroExecucao>
      </result>
    </ser:ConsultarTitulosAbertosCRResponse>
  </soapenv:Body>
</soapenv:Envelope>
Atributos da resposta:

Nome	Tipo	Descrição
erroExecucao	String	Indica erros ocorridos no servidor ao executar o serviço, podendo conter os seguintes valores:Vazio ou nulo, indicando que a execução foi feita com sucessoA mensagem do erro ocorrido no servidorSó impede a gravação quando o retorno.tipRet for igual a "2"
tipoRetorno	String	(Obrigatório) - Number(001) - Indicativo do tipo de retorno da solicitação - Lista: 1 = Processado com sucesso, 2 = Processado com erro
titulos	Set	
titulos.codEmp	Integer	(Obrigatório) - Number(004) - Empresa
titulos.codFil	Integer	(Obrigatório) - Number(005) - Filial
titulos.numTit	String	(Obrigatório) - String(015) - Título
titulos.codTpt	String	(Obrigatório) - String(003) - Tipo de título
titulos.codTns	String	(Obrigatório) - String(005) - Transação
titulos.codNtg	Integer	(Obrigatório) - Number(004) - Natureza de gasto
titulos.sitTit	String	
(Obrigatório) - String(002) - Sit. - Lista: AA = Aberto Advogado, AB = Aberto Normal, AC = Aberto Cartório, AI = Aberto Impostos, AJ = Aberto Retorno Jurídico, AP = Aberto Protestado, AR = Aberto Representante, AS = Aberto Suspenso, AV = Aberto Gestão de Pessoas, AX = Aberto Externo, PE = Aberto PE (Pagamento Eletrônico).

titulos.datEmi	DateTime	(Obrigatório) - Date(000) - Data de emissão
titulos.datEnt	DateTime	(Obrigatório) - Date(000) - Data de entrada
titulos.codCli	Integer	(Obrigatório) - Number(009) - Cliente
titulos.codSac	Double	(Opcional) - Number(014) - Sacado
titulos.codRep	Integer	(Obrigatório) - Number(009) - Representante
titulos.codCrp	String	(Opcional) - String(003) - Grupo do contas a receber
titulos.obsTcr	String	(Opcional) - String(250) - Observação
titulos.vctOri	DateTime	(Obrigatório) - Date(000) - Vencimento original
titulos.vlrOri	Double	(Obrigatório) - Number(015,2) - Valor original
titulos.codFpg	Integer	(Opcional) - Number(002) - Forma de pagamento
titulos.vctPro	DateTime	(Obrigatório) - Date(000) - Vencimento atual
titulos.proJrs	String	(Obrigatório) - String(001) - Prorrogação com juros. - Lista: S = Sim, N = Não
titulos.codMpt	String	(Opcional) - String(003) - Motivo da prorrogação
titulos.datPpt	DateTime	(Obrigatório) - Date(000) - Data do provável pagamento
titulos.vlrAbe	Double	(Opcional) - Number(015,2) - Valor aberto
titulos.codMoe	String	(Opcional) - String(003) - Moeda
titulos.cotEmi	Double	(Opcional) - Number(019,10) - Cotação da moeda na emissão do título
titulos.codFrj	String	(Opcional) - String(003) - Fórmula de reajuste
titulos.cotFrj	Double	(Opcional) - Number(019,10) - Cotação da moeda no reajuste do título
titulos.perCom	Double	(Opcional) - Number(007,4) - Percentual de comissão
titulos.comRec	Double	(Opcional) - Number(005,2) - Percentual de comissão pago no recebimento do título
titulos.vlrBco	Double	(Opcional) - Number(015,2) - Valor base da comissão
titulos.vlrCom	Double	(Opcional) - Number(015,2) - Valor da comissão
titulos.datDsc	DateTime	(Opcional) - Date(000) - Data para desconto do título
titulos.tolDsc	Integer	(Opcional) - Number(004) - Total do desconto
titulos.vlrDsc	Double	(Opcional) - Number(015,2) - Valor do desconto
titulos.perDsc	Double	(Opcional) - Number(005,2) - Percentual de desconto
titulos.perJrs	Double	(Opcional) - Number(005,2) - Percentual de juros
titulos.tipJrs	String	(Opcional) - String(001) - Tipo de juros - Lista: S = Juros Simples, C = Juros Compostos
titulos.jrsDia	Double	(Opcional) - Number(009,2) - Juros de mora ao dia
titulos.tolJrs	Integer	(Opcional) - Number(004) - Dias de tolerância para os juros de mora
titulos.perMul	Double	(Opcional) - Number(005,2) - Percentual de multa
titulos.tolMul	Integer	(Opcional) - Number(004) - Dias de tolerância para multa
titulos.cheBan	String	(Opcional) - String(003) - Número do banco no cheque
titulos.cheAge	String	(Opcional) - String(007) - Agência do banco no cheque
titulos.cheCta	String	(Opcional) - String(014) - Número da conta do cheque
titulos.cheNum	String	(Opcional) - String(010) - Número do cheque
titulos.codPor	String	(Obrigatório) - String(004) - Portador
titulos.codCrt	String	(Obrigatório) - String(002) - Carteira
titulos.titBan	String	(Opcional) - String(020) - Nosso número
titulos.numArb	Integer	(Opcional) - Number(009) - Número do arquivo de remessa para o banco
titulos.codOcr	String	(Opcional) - String(003) - Ocorrência de remessa para o banco
titulos.codIn1	String	(Opcional) - String(003) - Código da primeira instrução bancária
titulos.codIn2	String	(Opcional) - String(003) - Código da segunda instrução bancária
titulos.datNeg	DateTime	(Opcional) - Date(000) - Data base para os valores negociados
titulos.jrsNeg	Double	(Opcional) - Number(015,2) - Valor dos juros negociados
titulos.mulNeg	Double	(Opcional) - Number(015,2) - Valor da multa negociada
titulos.dscNeg	Double	(Opcional) - Number(015,2) - Valor dos descontos negociados
titulos.outNeg	Double	(Opcional) - Number(015,2) - Valor de outros valores negociados
titulos.cpgNeg	String	(Opcional) - String(006) - Condição de pagamento negociada
titulos.taxNeg	Double	(Opcional) - Number(0013,10) - Taxa Negociada
titulos.vlrDca	Double	(Opcional) - Number(015,2) - Valor das despesas cartoriais
titulos.vlrDcb	Double	(Opcional) - Number(015,2) - Valor das despesas de cobrança
titulos.vlrOud	Double	(Opcional) - Number(015,2) - Valor de outras despesas
titulos.numPrj	Integer	(Opcional) - Number(008) - Projeto
titulos.codFpj	Integer	(Opcional) - Number(004) - Fase
titulos.ctaFin	Integer	(Opcional) - Number(007) - Conta financeira
titulos.ctaRed	Integer	(Opcional) - Number(007) - Conta contábil reduzida
titulos.codCcu	String	(Opcional) - String(009) - Centro de custo
titulos.filNfv	Integer	(Opcional) - Number(005) - Filial da NFS
titulos.codSnf	String	(Opcional) - String(003) - Série da NFS
titulos.numNfv	Integer	(Opcional) - Number(009) - Número da NFS
titulos.filCtr	Integer	(Opcional) - Number(005) - Filial do contrato de venda
titulos.numCtr	Integer	(Opcional) - Number(009) - Número do contrato de venda
titulos.seqImo	Integer	(Opcional) - Number(003) - Sequência do item do contrato
titulos.filNff	Integer	(Opcional) - Number(005) - Filial da NF fatura
titulos.numNff	Integer	(Opcional) - Number(009) - Número da NF fatura
titulos.filPed	Integer	(Opcional) - Number(005) - Filial do pedido
titulos.numPed	Integer	(Opcional) - Number(008) - Número do pedido
titulos.filNfc	Integer	(Opcional) - Number(005) - Filial da NFE
titulos.forNfc	Integer	(Opcional) - Number(009) - Fornecedor da NFE
titulos.numNfc	Integer	(Opcional) - Number(009) - Número da NFE
titulos.snfNfc	String	(Opcional) - String(003) - Série da NFE
titulos.catTef	String	(Opcional) - String(100) - Autorização da transação (TEF)
titulos.nsuTef	String	(Obrigatório) - String(100) - Número da transação (TEF)
titulos.vlrJrs	Double	(Obrigatório) - Number(015,2) - Valor juros
titulos.vlrMul	Double	(Obrigatório) - Number(015,2) - Valor multa
titulos.vlrOac	Double	(Obrigatório) - Number(015,2) - Valor acréscimos
titulos.vlrCor	Double	(Obrigatório) - Number(015,2) - Valor correção
titulos.vlrEnc	Double	(Obrigatório) - Number(015,2) - Valor encargos
titulos.vlrDes	Double	(Obrigatório) - Number(015,2) - Valor descontos
titulos.vlrOde	Double	(Obrigatório) - Number(015,2) - Valor outros descontos
titulos.titEfe	String	(Obrigatório) - String(001) - Indicativo se o título é efetivo ou não. "S - Título Efetivo" ou "N - Título Previsto".
titulos.dupCre	String	(Obrigatório) - String(001) - Indicativo se o título é duplicata ou crédito. "D - Título duplicata" ou "C - Título Crédito".
titulos.rateios	Set	
rateios.seqMov	Integer	(Obrigatório) - Number(004) - Sequência do movimento
rateios.seqRat	Integer	(Obrigatório) - Number(004) - Sequência do rateio
rateios.datBas	DateTime	(Opcional) - Date(000) - Data Base do rateio
rateios.codTns	String	(Opcional) - String(005) - Transação
rateios.mesAno	DateTime	(Opcional) - Date(000) - Competência
rateios.criRat	Integer	(Obrigatório) - Number(001) - Critério de rateio - Lista: 1 = Receitas - Conta X C. Custos, 2 = Receitas - C. Custos X Conta, 3 = Despesas - Conta X C. Custos, 4 = Despesas - C. Custos X Conta, 5 = Nenhum
rateios.somSub	Integer	(Obrigatório) - Number(001) - Somar ou subtrair o valor no plano financeiro/centro de custos - Lista: 1 = Somar Competência, 2 = Somar Caixa, 3 = Somar Competência/Caixa, 4 = Subtrair Competência, 5 = Subtrair Caixa, 6 = Subtrair Competência/Caixa, 7 = Não Considerar
rateios.numPrj	Integer	(Opcional) - Number(008) - Projeto
rateios.codFpj	Integer	(Opcional) - Number(004) - Fase
rateios.ctaFin	Integer	(Opcional) - Number(007) - Conta financeira
rateios.ctaRed	Integer	(Opcional) - Number(007) - Conta contábil
rateios.perCta	Double	(Opcional) - Number(007,4) - Percentual rateado para a conta
rateios.vlrCta	Double	(Opcional) - Number(015,2) - Valor rateado para a conta
rateios.codCcu	String	(Opcional) - String(009) - Código do centro de custos
rateios.perRat	Double	(Opcional) - Number(007,4) - Percentual rateado para o centro de custos
rateios.vlrRat	Double	(Opcional) - Number(015,2) - Valor rateado para o centro de custos
rateios.obsRat	String	(Opcional) - String(120) - Observação
rateios.tipOri	String	(Opcional) - String(001) - Origem do rateio - Lista: A = Automático, M = Manual
mensagemRetorno	String	(Obrigatório) - String(250) - Mensagem de retorno da importação
OpenGravarTitulosCR_2
Finanças - Gestão de Contas a Receber - Contas à Receber - Gravar Títulos

Necessita autenticação: sim.

Situação de versão: atual.

Versão: 2.

Requisição:

<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.senior.com.br">
  <soapenv:Body>
    <ser:GravarTitulosCR>
      <user>String</user>
      <password>String</password>
      <encryption>Integer</encryption>
      <parameters>
        <titulos>
          <codEmp>Integer</codEmp>
          <codFil>String</codFil>
          <numTit>String</numTit>
          <codTpt>String</codTpt>
          <codTns>String</codTns>
          <codNtg>String</codNtg>
          <datEmi>String</datEmi>
          <datEnt>String</datEnt>
          <codCli>String</codCli>
          <codSac>String</codSac>
          <codRep>String</codRep>
          <codCrp>String</codCrp>
          <obsTcr>String</obsTcr>
          <vctOri>String</vctOri>
          <cotEmi>String</cotEmi>
          <vlrMoe>String</vlrMoe>
          <vlrOri>String</vlrOri>
          <codFpg>String</codFpg>
          <datPpt>String</datPpt>
          <codMoe>String</codMoe>
          <perCom>String</perCom>
          <vlrBco>String</vlrBco>
          <vlrCom>String</vlrCom>
          <perJrs>String</perJrs>
          <tipJrs>String</tipJrs>
          <jrsDia>String</jrsDia>
          <tolJrs>String</tolJrs>
          <perMul>String</perMul>
          <tolMul>String</tolMul>
          <cheBan>String</cheBan>
          <cheAge>String</cheAge>
          <cheCta>String</cheCta>
          <cheNum>String</cheNum>
          <codPor>String</codPor>
          <codCrt>String</codCrt>
          <titBan>String</titBan>
          <numArb>String</numArb>
          <codIn1>String</codIn1>
          <codIn2>String</codIn2>
          <datNeg>String</datNeg>
          <jrsNeg>String</jrsNeg>
          <mulNeg>String</mulNeg>
          <dscNeg>String</dscNeg>
          <outNeg>String</outNeg>
          <ctaFin>String</ctaFin>
          <ctaRed>String</ctaRed>
          <codCcu>String</codCcu>
          <proJrs>String</proJrs>
          <codMpt>String</codMpt>
          <perDsc>String</perDsc>
          <vlrDsc>String</vlrDsc>
          <tolDsc>String</tolDsc>
          <datDsc>String</datDsc>
          <numPrj>String</numPrj>
          <codFpj>String</codFpj>
          <cpgNeg>String</cpgNeg>
          <taxNeg>String</taxNeg>
          <catTef>String</catTef>
          <nsuTef>String</nsuTef>
          <comRec>String</comRec>
          <vlrDca>String</vlrDca>
          <vlrDcb>String</vlrDcb>
          <vlrOud>String</vlrOud>
          <cnpjFilial>String</cnpjFilial>
          <seqCob>String</seqCob>
          <ideExt>Integer</ideExt>
          <ctrExt>String</ctrExt>
          <sigInt>String</sigInt>
          <rateios>
            <ctaFin>String</ctaFin>
            <ctaRed>String</ctaRed>
            <codCcu>String</codCcu>
            <perCta>String</perCta>
            <perRat>String</perRat>
            <obsRat>String</obsRat>
            <numPrj>String</numPrj>
            <codFpj>String</codFpj>
          </rateios>
          <ideTxi>String</ideTxi>
          <urlPix>String</urlPix>
          <emvQrc>String</emvQrc>
          <msgPag>String</msgPag>
        </titulos>
        <dataBuild>String</dataBuild>
      </parameters>
    </ser:GravarTitulosCR>
  </soapenv:Body>
</soapenv:Envelope>
		
Parâmetros da requisição:

Nome	Tipo	Descrição
titulos	Set	
titulos.codEmp	Integer	(Obrigatório) - Number(004) - Código da empresa
titulos.codFil	String	(Obrigatório) - Number(005) - Código da filial
titulos.numTit	String	(Obrigatório) - String(010) - Número do título a receber
titulos.codTpt	String	(Obrigatório) - String(003) - Código do tipo de título a receber
titulos.codTns	String	(Obrigatório) - String(005) - Código da transação que gerou o título a receber
titulos.codNtg	String	(Opcional) - Number(004) - Código da natureza de gasto
titulos.datEmi	String	(Obrigatório) - Date - Data de emissão do título a receber
titulos.datEnt	String	(Obrigatório) - Date - Data de entrada do título a receber
titulos.codCli	String	(Obrigatório) - Number(009) - Código do cliente do título a receber
titulos.codSac	String	(Opcional) - Number(014) - Código do sacado
titulos.codRep	String	(Obrigatório) - Number(004) - Código do representante do título a receber
titulos.codCrp	String	(Opcional) - String(003) - Código do grupo de contas a receber
titulos.obsTcr	String	(Opcional) - String(250) - Observação para o título
titulos.vctOri	String	(Obrigatório) - Date - Data do vencimento original do título a receber
titulos.cotEmi	String	Valor da cotação da moeda na data de emissão do título
titulos.vlrMoe	String	Valor original na moeda do título a receber
titulos.vlrOri	String	(Obrigatório) - Number(015,2) - Valor original do título a receber
titulos.codFpg	String	(Opcional) - Number(002) - Código da forma de pagamento
titulos.datPpt	String	(Obrigatório) - Date - Data do provável pagamento do título
titulos.codMoe	String	(Opcional) - String(003) - Código da moeda do título a receber
titulos.perCom	String	(Opcional) - Number(007,4) - Percentual de comissão do título a receber
titulos.vlrBco	String	(Opcional) - Number(015,2) - Valor base da comissão do título
titulos.vlrCom	String	(Opcional) - Number(015,2) - Valor da comissão do título a receber
titulos.perJrs	String	(Opcional) - Number(005,2) - Percentual de juros de mora ao mês do título a receber
titulos.tipJrs	String	(Opcional) - String(001) - Indicativo se os juros de mora é simples ou composto - Lista: S = Juros Simples, C = Juros Composto
titulos.jrsDia	String	(Opcional) - Number(009,2) - Valor de juros de mora ao dia do título a receber
titulos.tolJrs	String	(Opcional) - Number(004) - Dias de tolerância para os juros de mora do título a receber
titulos.perMul	String	(Opcional) - Number(005,2) - Percentual de multa prevista para o título a receber
titulos.tolMul	String	(Opcional) - Number(004) - Dias de tolerância para a multa prevista para o título a receber
titulos.cheBan	String	(Opcional) - String(003) - Número do banco na FEBRABAN do cheque
titulos.cheAge	String	(Opcional) - String(007) - Número da agência do banco do cheque
titulos.cheCta	String	(Opcional) - String(014) - Número da conta no banco do cheque
titulos.cheNum	String	(Opcional) - String(010) - Número do cheque no banco
titulos.codPor	String	(Obrigatório) - String(004) - Código do portador do título
titulos.codCrt	String	(Obrigatório) - String(002) - Código da carteira do título a receber
titulos.titBan	String	(Opcional) - String(020) - Número do título no banco (nosso número)
titulos.numArb	String	(Opcional) - Number(009) - Número de arquivo de remessa para banco
titulos.codIn1	String	(Opcional) - String(003) - Código da primeira instrução bancária
titulos.codIn2	String	(Opcional) - String(003) - Código da segunda instrução bancária
titulos.datNeg	String	(Opcional) - Date - Data base dos valores negociados (data até)
titulos.jrsNeg	String	(Opcional) - Number(015,2) - Valor dos juros negociados
titulos.mulNeg	String	(Opcional) - Number(015,2) - Valor da multa negociada
titulos.dscNeg	String	(Opcional) - Number(015,2) - Valor dos descontos negociados
titulos.outNeg	String	(Opcional) - Number(015,2) - Valor de outros valores negociados
titulos.ctaFin	String	(Opcional) - Number(007) - Conta financeira reduzida
titulos.ctaRed	String	(Opcional) - Number(007) - Conta contábil reduzida
titulos.codCcu	String	(Opcional) - String(009) - Código do centro de custo
titulos.proJrs	String	(Obrigatório) - String(001) - Indicativo se a prorrogação do vencimento é com juros - Lista: S = Sim, N = Não
titulos.codMpt	String	(Opcional) - String(003) - Código do motivo de prorrogação do título
titulos.perDsc	String	(Opcional) - Number(005,2) - Percentual/Valor do desconto do título
titulos.vlrDsc	String	(Opcional) - Number(015,2) - Valor do desconto a ser concedido ao título a receber
titulos.tolDsc	String	(Opcional) - Number(004) - Dias de tolerância para desconto
titulos.datDsc	String	(Opcional) - Date - Data válidas para desconto do título
titulos.numPrj	String	(Opcional) - Number(008) - Número do projeto
titulos.codFpj	String	(Opcional) - Number(004) - Código da fase do projeto
titulos.cpgNeg	String	(Opcional) - String(006) - Código da condição de pagamento negociada
titulos.taxNeg	String	(Opcional) - Number(013,10) - Taxa negociada
titulos.catTef	String	(Opcional) - String(100) - Código de Autorização da Transação (TEF - Sitef)
titulos.nsuTef	String	(Opcional) - String(100) - Número Sequencial Único da Transação TEF (Host - Operadora)
titulos.comRec	String	(Opcional) - Number(005,2) - Percentual de comissão pago no recebimento do título a receber
titulos.vlrDca	String	(Opcional) - Number(015,2) - Valor das despesas cartoriais
titulos.vlrDcb	String	(Opcional) - Number(015,2) - Valor das despesas de cobrança
titulos.vlrOud	String	(Opcional) - Number(015,2) - Valor de outras despesas
titulos.cnpjFilial	String	(Opcional) - Number(015) - Número do cadastro nacional da pessoa jurídica da filial da empresa. Condição: Obrigatório quando não informado os campos CodEmp e CodFil
titulos.seqCob	String	(Opcional) - Number(004) - Cód. Endereço de Cobrança
titulos.ideExt	Integer	Número Identificador Externo
titulos.ctrExt	String	Número do Contrato Externo
titulos.sigInt	String	Sigla do Sistema Integrado
titulos.rateios	Set	-
rateios.ctaFin	String	(Opcional) - Number(007) - Conta financeira reduzida
rateios.ctaRed	String	(Opcional) - Number(007) - Conta contábil reduzida
rateios.codCcu	String	(Opcional) - String(009) - Código do centro de custos
rateios.perCta	String	(Opcional) - Number(007,4) - Percentual rateado para a conta
rateios.perRat	String	(Opcional) - Number(007,4) - Percentual rateado para o centro de custos
rateios.obsRat	String	(Opcional) - String(120) - Observação do rateio
rateios.numPrj	String	(Opcional) - Number(008) - Número do projeto
rateios.codFpj	String	(Opcional) - Number(004) - Código da fase do projeto
titulos.ideTxi	String	(Obrigatório) - String(035) - Id. Transação PIX
titulos.urlPix	String	(Obrigatório) - String(100) - Location URL
titulos.emvQrc	String	(Obrigatório) - String(500) - EMV do QR-Code
titulos.msgPag	String	(Obrigatório) - String(250) - Mensagem do Pagador Final
dataBuild	String	Mantido por compatibilidade.
Resposta:

Observação

Envelope SOAP de resposta de requisições síncronas. Para requisições assíncronas ou agendamentos, a resposta é apenas uma String chamada "result" com o valor "OK", se foi executado com sucesso ou, caso contrário, a mensagem do erro ocorrido.

<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.senior.com.br">
  <soapenv:Body>
    <ser:GravarTitulosCRResponse>
      <result>
        <tipoRetorno>String</tipoRetorno>
        <resultado>
          <codEmp>Integer</codEmp>
          <codFil>String</codFil>
          <cnpjFilial>String</cnpjFilial>
          <numTit>String</numTit>
          <codTpt>String</codTpt>
          <resultado>String</resultado>
        </resultado>
        <mensagemRetorno>String</mensagemRetorno>
        <erroExecucao>String</erroExecucao>
      </result>
    </ser:GravarTitulosCRResponse>
  </soapenv:Body>
</soapenv:Envelope>
		
Atributos da resposta:

Nome	Preenchimento	Tipo	Descrição
erroExecucao	Opcional	String	Indica erros ocorridos no servidor ao executar o serviço, podendo conter os seguintes valores:Vazio ou nulo, indicando que a execução foi feita com sucessoA mensagem do erro ocorrido no servidorSó impede a gravação quando o retorno.tipRet for igual a "2"
tipoRetorno	Opcional	String	(Obrigatório) - Number(001) - Indicativo do tipo de retorno da solicitação - Lista: 1 = Processado com sucesso, 2 = Processado com erro
resultado	Opcional	Set	
resultado.codEmp	Opcional	Integer	(Obrigatório) - Number(004) - Código da empresa
resultado.codFil	Opcional	String	(Obrigatório) - Number(005) - Código da filial
resultado.cnpjFilial	Opcional	String	(Opcional) - Number(015) - Número do cadastro nacional da pessoa jurídica da filial da empresa - Condição: Será retornado caso seja informado no título recebido
resultado.numTit	Opcional	String	(Obrigatório) - String(010) - Número do título a receber
resultado.codTpt	Opcional	String	(Obrigatório) - String(003) - Código do tipo de título a receber
resultado.resultado	Opcional	String	
mensagemRetorno	Opcional	String	(Obrigatório) - String(250) - Mensagem de retorno da importação
OpenEntradaTitulosLoteCR
Finanças - Gestão de Contas a Receber - Contas à Receber - Entrada de Títulos por Lote.

Necessita autenticação: sim.

Situação de versão: atual.

Versão: 1.

Observação

A informação abaixo é referente à transação de entrada cuja forma de rateio é Pré-definido sem Confirmação. Ao entrar com títulos do contas a receber, os seguintes campos serão consistidos para geração do rateio:

quando os campos referentes ao título (Conta Financeira, Conta Contábil e Centro de Custos) estiverem preenchidos, o rateio será gerado de acordo com as informações do título;
quando os campos referentes ao título (Conta Financeira, Conta Contábil e Centro de Custos) estiverem sem preenchimento, os rateios serão gerados de acordo com o enviado na importação (XML).
Requisição:

<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.senior.com.br">
  <soapenv:Body>
    <ser:EntradaTitulosLoteCR>
      <user>String</user>
      <password>String</password>
      <encryption>Integer</encryption>
      <parameters>
        <codEmp>Integer</codEmp>
        <entradaTitulos>
          <codFil>Integer</codFil>
          <numTit>String</numTit>
          <codTpt>String</codTpt>
          <codCli>Integer</codCli>
          <vlrOri>Double</vlrOri>
          <codTns>String</codTns>
          <codFpg>Integer</codFpg>
          <codNtg>Integer</codNtg>
          <datEmi>DateTime</datEmi>
          <datEnt>DateTime</datEnt>
          <codSac>Double</codSac>
          <codRep>Integer</codRep>
          <vctOri>DateTime</vctOri>
          <vctPro>DateTime</vctPro>
          <datPpt>DateTime</datPpt>
          <codMoe>String</codMoe>
          <datDsc>DateTime</datDsc>
          <antDsc>String</antDsc>
          <prdDsc>String</prdDsc>
          <perDsc>Integer</perDsc>
          <vlrDsc>Double</vlrDsc>
          <codPor>String</codPor>
          <codCrt>String</codCrt>
          <titBan>String</titBan>
          <perMul>Integer</perMul>
          <tolMul>Integer</tolMul>
          <perJrs>Integer</perJrs>
          <vlrJrs>Double</vlrJrs>
          <tipJrs>String</tipJrs>
          <tolJrs>Integer</tolJrs>
          <tolDsc>Integer</tolDsc>
          <datNeg>DateTime</datNeg>
          <jrsNeg>Double</jrsNeg>
          <mulNeg>Double</mulNeg>
          <outNeg>Double</outNeg>
          <dscNeg>Double</dscNeg>
          <cotNeg>Double</cotNeg>
          <cheBan>String</cheBan>
          <cheAge>String</cheAge>
          <cheCta>String</cheCta>
          <cheNum>String</cheNum>
          <codFrj>String</codFrj>
          <codCrp>String</codCrp>
          <obsTcr>String</obsTcr>
          <numPrj>Integer</numPrj>
          <codFpj>Integer</codFpj>
          <ctaFin>Integer</ctaFin>
          <ctaRed>Integer</ctaRed>
          <codCcu>String</codCcu>
          <codBar>String</codBar>
          <codCnv>Integer</codCnv>
          <catTef>String</catTef>
          <nsuTef>String</nsuTef>
          <catExt>String</catExt>
          <codOpe>Integer</codOpe>
          <cotEmi>Double</cotEmi>
          <seqCob>String</seqCob>
          <parCar>Integer</parCar>
          <banCar>String</banCar>
          <vlrMoe>Double</vlrMoe>
          <locTit>String</locTit>
          <rateio>
            <numPrj>Integer</numPrj>
            <codFpj>Integer</codFpj>
            <ctaFin>Integer</ctaFin>
            <ctaRed>Integer</ctaRed>
            <perCta>Double</perCta>
            <vlrCta>Double</vlrCta>
            <codCcu>String</codCcu>
            <perRat>Double</perRat>
            <vlrRat>Double</vlrRat>
            <obsRat>String</obsRat>
          </rateio>
          <camposUsuario>
            <campo>String</campo>
            <valor>String</valor>
          </camposUsuario>
        </entradaTitulos>
        <codFil>Integer</codFil>
        <forCli>String</forCli>
      </parameters>
    </ser:EntradaTitulosLoteCR>
  </soapenv:Body>
</soapenv:Envelope>
		
Parâmetros da requisição:

Nome	Tipo	Descrição
codEmp	Integer	(Obrigatório) - Number(004) - Código da empresa.
entradaTitulos	Set	Entrada de Títulos.
entradaTitulos.codFil	Integer	(Obrigatório) - Number(005) - Filial.
entradaTitulos.numTit	String	(Obrigatório) - String(015) - Título.
entradaTitulos.codTpt	String	(Obrigatório) - String(003) - Tipo Título.
entradaTitulos.codCli	Integer	(Obrigatório) - Number(009) - Cliente.
entradaTitulos.vlrOri	Double	(Obrigatório) - Number(015) - Valor Original.
entradaTitulos.codTns	String	(Opcional quando o identificador de regras CRE-301SUBSC01 estiver ativo ou existir integração com varejo) - String(005) - Transação.
entradaTitulos.codFpg	Integer	(Opcional) - Number(002) - Código da forma de pagamento.
entradaTitulos.codNtg	Integer	(Opcional) - Number(004) - Código da natureza de gasto.
entradaTitulos.datEmi	DateTime	(Obrigatório) - Date(00/00/0000) - Data Emissão.
entradaTitulos.datEnt	DateTime	(Obrigatório) - Date(00/00/0000) - Data Entrada.
entradaTitulos.codSac	Double	(Opcional) - Number(014) - Sacado.
entradaTitulos.codRep	Integer	(Obrigatório) - Number(009) - Representante.
entradaTitulos.vctOri	DateTime	(Obrigatório) - Date(00/00/0000) - Vencimento Original.
entradaTitulos.vctPro	DateTime	(Opcional quando o identificador de regras CRE-301SUBSC01 estiver ativo ou existir integração com varejo) - Date(00/00/0000) - Vencimento Prorrogado.
entradaTitulos.datPpt	DateTime	(Opcional quando o identificador de regras CRE-301SUBSC01 estiver ativo ou existir integração com varejo) - Date(00/00/0000) - Data Provável Pagamento.
entradaTitulos.codMoe	String	(Opcional quando o identificador de regras CRE-301SUBSC01 estiver ativo ou existir integração com varejo) - String(003) - Moeda.
entradaTitulos.datDsc	DateTime	(Opcional) - Date(00/00/0000) - Data Desconto.
entradaTitulos.antDsc	String	(Opcional) - String(001) - Calcula Desconto por Antecipação - Lista: S = Sim, N = Não.
entradaTitulos.prdDsc	String	(Opcional) - String(001) - Período Desconto - Lista: D = Diário, M = Mensal.
entradaTitulos.perDsc	Integer	(Opcional) - Number(005) - % Desconto.
entradaTitulos.vlrDsc	Double	(Opcional) - Number(015) - Valor Desconto.
entradaTitulos.codPor	String	(Opcional quando o identificador de regras CRE-301SUBSC01 estiver ativo ou existir integração com varejo) - String(004) - Portador.
entradaTitulos.codCrt	String	(Opcional quando o identificador de regras CRE-301SUBSC01 estiver ativo ou existir integração com varejo) - String(002) - Carteira.
entradaTitulos.titBan	String	(Opcional) - String(020) - Nosso Nº.
entradaTitulos.perMul	Integer	(Opcional) - Number(005) - % Multa.
entradaTitulos.tolMul	Integer	(Opcional) - Number(004) - Dias Tolerância Multa.
entradaTitulos.perJrs	Integer	(Opcional) - Number(005) - % Juros.
entradaTitulos.vlrJrs	Double	(Opcional) - Number(015) - Valor Juros.
entradaTitulos.tipJrs	String	(Opcional) - String(001) - Tipo Juros - Lista: S = Juros Simples, C = Juros Compostos.
entradaTitulos.tolJrs	Integer	(Opcional) - Number(004) - Dias Tolerância Juros.
entradaTitulos.tolDsc	Integer	(Opcional) - Number(004) - Tolerância para Desconto.
entradaTitulos.datNeg	DateTime	(Opcional) - Date(00/00/0000) - Data Validade Negociação.
entradaTitulos.jrsNeg	Double	(Opcional) - Number(015) - Valor Juros Negociados.
entradaTitulos.mulNeg	Double	(Opcional) - Number(015) - Valor Multa Negociada.
entradaTitulos.outNeg	Double	(Opcional) - Number(015) - Valor Outros Valores Negociados.
entradaTitulos.dscNeg	Double	(Opcional) - Number(015) - Valor Desconto Negociado.
entradaTitulos.cotNeg	Double	(Opcional) - Number(019,10) - Cotação Moeda Negociada.
entradaTitulos.cheBan	String	(Opcional) - String(003) - Número do banco na FEBRABAN do cheque.
entradaTitulos.cheAge	String	(Opcional) - String(007) - Número da agência do banco do cheque.
entradaTitulos.cheCta	String	(Opcional) - String(014) - Número da conta no banco do cheque.
entradaTitulos.cheNum	String	(Opcional) - String(010) - Número do cheque no banco.
entradaTitulos.codFrj	String	(Opcional) - String(003) - Fórmula de Reajuste.
entradaTitulos.codCrp	String	(Opcional) - String(003) - Grupo de Contas a Receber.
entradaTitulos.obsTcr	String	(Opcional) - String(250) - Observação.
entradaTitulos.numPrj	Integer	(Opcional) - Number(008) - Projeto.
entradaTitulos.codFpj	Integer	(Opcional) - Number(004) - Fase.
entradaTitulos.ctaFin	Integer	(Opcional) - Number(007) - Conta Financeira.
entradaTitulos.ctaRed	Integer	(Opcional) - Number(007) - Conta Contábil.
entradaTitulos.codCcu	String	(Opcional) - String(009) - Centro de Custos.
entradaTitulos.codBar	String	(Opcional) - String(050) - Código de Barra.
entradaTitulos.codCnv	Integer	(Opcional) - Number(004) - Código do Convênio
entradaTitulos.catTef	String	(Opcional) - String(100) - Autorização da Transação (TEF).
entradaTitulos.nsuTef	String	(Opcional) - String(100) - Número da Transação (TEF).
entradaTitulos.catExt	String	(Opcional) - String(100) - Autorização Externo.
entradaTitulos.codOpe	Integer	(Opcional) - Number(004) - Operadora
entradaTitulos.locTit	String	(Opcional) - String(50) - Localizador do título
rateio	Set	Rateio do título.
rateio.numPrj	Integer	(Opcional) - Number(008) - Projeto.
rateio.codFpj	Integer	(Opcional) - Number(004) - Fase.
rateio.ctaFin	Integer	(Opcional) - Number(007) - Conta Financeira.
rateio.ctaRed	Integer	(Opcional) - Number(007) - Conta Contábil.
rateio.perCta	Double	(Opcional) - Number(007) - Percentual rateado para a conta.
rateio.vlrCta	Double	(Opcional) - Number(015) - Valor rateado para a conta
rateio.codCcu	String	(Opcional) - String(009) - Centro de Custos
rateio.perRat	Double	(Opcional) - Number(007) - Percentual rateado para o centro de custos
rateio.vlrRat	Double	(Opcional) - Number(015) - Valor rateado para o centro de custos
rateio.obsRat	String	(Opcional) - String(120) - Observação do rateio
entradaTitulos.cotEmi	Double	(Opcional) - Number(019,10) - Valor da cotação da moeda na data de emissão do título
entradaTitulos.seqCob	String	(Opcional) - Number(004) - Cód. Endereço de Cobrança
entradaTitulos.parCar	Integer	(Opcional) Número da parcela do cartão
entradaTitulos.banCar	String	(Opcional) Bandeira do cartão
entradaTitulos.vlrMoe	Double	 
entradaTitulos.rateio	Set	 
entradaTitulos.rateio.numPrj	Integer	 
entradaTitulos.rateio.codFpj	Integer	 
entradaTitulos.rateio.ctaFin	Integer	 
entradaTitulos.rateio.ctaRed	Integer	 
entradaTitulos.rateio.perCta	Double	 
entradaTitulos.rateio.vlrCta	Double	 
entradaTitulos.rateio.codCcu	String	 
entradaTitulos.rateio.perRat	Double	 
entradaTitulos.rateio.vlrRat	Double	 
entradaTitulos.rateio.obsRat	String	 
entradaTitulos.camposUsuario	Set	Lista de campos de usuário do título
entradaTitulos.camposUsuario.campo	String	Nome do campo de usuário do título
entradaTitulos.camposUsuario.valor	String	Valor do campo de usuário do título
codFil	Integer	(Obrigatório) - Number(005) - Código da filial. Filial onde irá acontecer os movimentos
forCli	String	(Opcional) - String(001) - Cliente como Fornecedor
Resposta:

Observação

Envelope SOAP de resposta de requisições síncronas. Para requisições assíncronas ou agendamentos, a resposta é apenas uma String chamada "result" com o valor "OK", se foi executado com sucesso ou, caso contrário, a mensagem do erro ocorrido.

<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.senior.com.br">
  <soapenv:Body>
    <ser:EntradaTitulosLoteCRResponse>
      <result>
        <gridResult>
          <codEmp>Integer</codEmp>
          <codFil>Integer</codFil>
          <numTit>String</numTit>
          <codTpt>String</codTpt>
          <codCli>Integer</codCli>
          <numInt>String</numInt>
          <txtRet>String</txtRet>
        </gridResult>
        <resultado>String</resultado>
        <erroExecucao>String</erroExecucao>
      </result>
    </ser:EntradaTitulosLoteCRResponse>
  </soapenv:Body>
</soapenv:Envelope>
Atributos da resposta:

Nome	Tipo	Descrição
gridResult	Set	Itens de retorno.
gridResult.codEmp	Integer	Number(004) - Código da empresa.
gridResult.codFil	Integer	Number(005) - Filial.
gridResult.numTit	String	String(015) - Título.
gridResult.codTpt	String	String(003) - Tipo Título.
gridResult.codCli	Integer	Number(009) - Cliente.
gridResult.numInt	String	String(100) - Número Integração Externo.
gridResult.txtRet	String	String - Retorno
resultado	String	O campo resultado irá retornar as seguintes mensagens:

Execução do serviço sem erros:
"OK" -> Verificar títulos baixados e gerados na grade "Retorno".

Execução do serviço com erros:
"ERRO" -> Analisar os erros na grade "Retorno"
erroExecucao	String	Indica erros ocorridos no servidor ao executar o serviço, podendo conter os seguintes valores:Vazio ou nulo, indicando que a execução foi feita com sucessoA mensagem do erro ocorrido no servidorSó impede a gravação quando o retorno.tipRet for igual a "2"
OpenBaixarTitulosCR_3
Importante

A porta BaixarTitulosCR_2 foi descontinuada e será mantida por questões de compatibilidade. Nessa porta, se algum título da lista tiver algum erro, todo o processamento será cancelado.

A porta BaixarTitulosCR_3 foi criada para permitir executar toda a lista de títulos, gravar todos os títulos que estão corretos e avisar todos os títulos que estão com erros.

Em ambas as portas, se houver algum problema na utilização (Mensagem de erro: Não foi possível incluir movimento de baixa de título a receber. Erro encontrado: Rateio Incompleto!), o usuário deverá migrar para a porta GerarBaixaPorLoteCR.

Finanças - Gestão de Contas a Receber - Contas à Receber - Baixar Títulos

Necessita autenticação: Sim

Situação de versão: Atual

Versão: 2

Requisição:

<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.senior.com.br">
  <soapenv:Body>
    <ser:BaixarTitulosCR>
      <user>String</user>
      <password>String</password>
      <encryption>Integer</encryption>
      <parameters>
        <baixaTituloReceber>
          <codEmp>String</codEmp>
          <codFil>String</codFil>
          <numTit>String</numTit>
          <codTpt>String</codTpt>
          <datMov>String</datMov>
          <datPgt>String</datPgt>
          <codTns>String</codTns>
          <vlrMov>String</vlrMov>
          <numCco>String</numCco>
          <vlrLiq>String</vlrLiq>
          <empCco>String</empCco>
          <datCco>String</datCco>
          <seqCco>String</seqCco>
          <seqMov>String</seqMov>
          <datLib>String</datLib>
          <diaAtr>String</diaAtr>
          <diaJrs>String</diaJrs>
          <vlrDsc>String</vlrDsc>
          <vlrJrs>String</vlrJrs>
          <vlrMul>String</vlrMul>
          <vlrCom>String</vlrCom>
          <vlrBco>String</vlrBco>
          <vlrEnc>String</vlrEnc>
          <vlrCor>String</vlrCor>
          <vlrOac>String</vlrOac>
          <vlrOde>String</vlrOde>
          <cotMcr>String</cotMcr>
          <filRlc>String</filRlc>
          <numRlc>String</numRlc>
          <tptRlc>String</tptRlc>
          <seqRlc>String</seqRlc>
          <codFpg>String</codFpg>
          <numPrj>String</numPrj>
          <codFpj>String</codFpj>
          <numDoc>String</numDoc>
          <tnsBxa>String</tnsBxa>
          <cnpjFilial>String</cnpjFilial>
          <rateios>
            <ctaFin>String</ctaFin>
            <ctaRed>String</ctaRed>
            <codCcu>String</codCcu>
            <perCta>String</perCta>
            <perRat>String</perRat>
            <obsRat>String</obsRat>
            <numPrj>String</numPrj>
            <codFpj>String</codFpj>
          </rateios>
        </baixaTituloReceber>
        <dataBuild>String</dataBuild>
      </parameters>
    </ser:BaixarTitulosCR>
  </soapenv:Body>
</soapenv:Envelope>
Parâmetros da requisição:

Nome	Tipo	Descrição
baixaTituloReceber	Set	Baixa de títulos a receber
baixaTituloReceber.codEmp	String	(Obrigatório) - Number(004) - Código da empresa
baixaTituloReceber.codFil	String	(Obrigatório) - Number(005) - Código da filial
baixaTituloReceber.numTit	String	(Obrigatório) - String(010) - Número do título movimentado
baixaTituloReceber.codTpt	String	(Obrigatório) - String(003) - Código do tipo do título movimentado
baixaTituloReceber.datMov	String	(Opcional) - Date - Data do movimento do título. Caso não seja informada a data para este campo, será processado com a data atual
baixaTituloReceber.datPgt	String	(Opcional) - Date - Data do movimento, pagamento, baixa do título movimentado
baixaTituloReceber.codTns	String	(Opcional) - String(005) - Código da transação do título movimentado
baixaTituloReceber.vlrMov	String	(Obrigatório) - Number(015,2) - Valor do movimento do título
baixaTituloReceber.numCco	String	(Obrigatório) - String(014) - Número da conta interna
baixaTituloReceber.vlrLiq	String	(Opcional) - Number(015,2) - Valor líquido do movimento do título
baixaTituloReceber.empCco	String	(Opcional) - Number(004) - Código da empresa do movimento da conta interna
baixaTituloReceber.datCco	String	(Opcional) - Date - Data do movimento da conta interna
baixaTituloReceber.seqCco	String	(Opcional) - Number(006) - Sequência do movimento da conta interna
baixaTituloReceber.seqMov	String	(Opcional) - Number(004) - Sequência de movimento do título
baixaTituloReceber.datLib	String	(Opcional) - Date - Data da liberação para comissão e caixa/bancos
baixaTituloReceber.diaAtr	String	(Opcional) - Number(004) - Dias de atraso no pagamento do título movimentado
baixaTituloReceber.diaJrs	String	(Opcional) - Number(004) - Dias de atraso para efeito de juros no pagamento do título movimentado
baixaTituloReceber.vlrDsc	String	(Opcional) - Number(015,2) - Valor do desconto concedido ao título movimentado
baixaTituloReceber.vlrJrs	String	(Opcional) - Number(015,2) - Valor dos juros de mora cobrados do título movimentado
baixaTituloReceber.vlrMul	String	(Opcional) - Number(015,2) - Valor da multa cobrada do título movimentado
baixaTituloReceber.vlrCom	String	(Opcional) - Number(015,2) - Valor da comissão do título movimentado
baixaTituloReceber.vlrBco	String	(Opcional) - Number(015,2) - Valor base comissão do título movimentado
baixaTituloReceber.vlrEnc	String	(Opcional) - Number(015,2) - Valor dos encargos do título
baixaTituloReceber.vlrCor	String	(Opcional) - Number(015,2) - Valor da correção monetária do título
baixaTituloReceber.vlrOac	String	(Opcional) - Number(015,2) - Valor de outros acréscimos do títulos
baixaTituloReceber.vlrOde	String	(Opcional) - Number(015,2) - Valor de outros descontos do título
baixaTituloReceber.cotMcr	String	(Opcional) - Number(019,10) - Valor da cotação da moeda na data base do movimento
baixaTituloReceber.filRlc	String	(Opcional) - Number(005) - Código da filial do título relacionado (gerado ou aproveitado)
baixaTituloReceber.numRlc	String	(Opcional) - String(010) - Número do título relacionado (gerado ou aproveitado)
baixaTituloReceber.tptRlc	String	(Opcional) - String(003) - Tipo do título relacionado (gerado ou aproveitado)
baixaTituloReceber.seqRlc	String	(Opcional) - Number(003) - Sequência do movimento relacionado (gerado ou aproveitado)
baixaTituloReceber.codFpg	String	(Opcional) - Number(002) - Código da forma de pagamento
baixaTituloReceber.numPrj	String	(Opcional) - Number(008) - Número do projeto
baixaTituloReceber.codFpj	String	(Opcional) - Number(004) - Código da fase do projeto
baixaTituloReceber.numDoc	String	(Opcional) - String(010) - Número do documento do movimento do título
baixaTituloReceber.tnsBxa	String	(Opcional) - String(005) - Transação de crédito na tesouraria utilizada pela baixa por pagamento no Conta a Receber. Observação: Na ausência do valor desse campo, será buscado a informação definida no campo "Transação Padrão Crédito Tesouraria" do cadastro da Filial - Contas a Receber.
baixaTituloReceber.cnpjFilial	String	(Opcional) - Number(015) - Número do cadastro nacional da pessoa jurídica da filial da empresa. Condição: Obrigatório quando não informado os campos CodEmp e CodFil
baixaTituloReceber.rateios	Set	Campos relacionados ao rateio comissão
rateios.ctaFin	String	(Opcional) - Number(007) - Conta financeira reduzida
rateios.ctaRed	String	(Opcional) - Number(007) - Conta contábil reduzida
rateios.codCcu	String	(Opcional) - String(009) - Código do centro de custos
rateios.perCta	String	(Opcional) - Number(007,4) - Percentual rateado para a conta
rateios.perRat	String	(Opcional) - Number(007,4) - Percentual rateado para o centro de custos
rateios.obsRat	String	(Opcional) - String(120) - Observação do rateio
rateios.numPrj	String	(Opcional) - Number(008) - Número do projeto
rateios.codFpj	String	(Opcional) - Number(004) - Código da fase do projeto
dataBuild	String	Mantido por compatibilidade.
Resposta:

Observação

Envelope SOAP de resposta de requisições síncronas. Para requisições assíncronas ou agendamentos, a resposta é apenas uma String chamada "result" com o valor "OK", se foi executado com sucesso ou, caso contrário, a mensagem do erro ocorrido.

<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.senior.com.br">
  <soapenv:Body>
    <ser:BaixarTitulosCRResponse>
      <result>
        <tipoRetorno>String</tipoRetorno>
        <resultado>
          <codEmp>Integer</codEmp>
          <codFil>String</codFil>
          <cnpjFilial>String</cnpjFilial>
          <numTit>String</numTit>
          <codTpt>String</codTpt>
          <seqMov>String</seqMov>
          <resultado>String</resultado>
        </resultado>
        <mensagemRetorno>String</mensagemRetorno>
        <erroExecucao>String</erroExecucao>
      </result>
    </ser:BaixarTitulosCRResponse>
  </soapenv:Body>
</soapenv:Envelope>
Atributos da resposta:

Nome	Tipo	Descrição
erroExecucao	String	Indica erros ocorridos no servidor ao executar o serviço, podendo conter os seguintes valores:Vazio ou nulo, indicando que a execução foi feita com sucessoA mensagem do erro ocorrido no servidorSó impede a gravação quando o retorno.tipRet for igual a "2"
tipoRetorno	String	(Obrigatório) - Number(001) - Indicativo do tipo de retorno da solicitação - Lista: 1 = Processado com sucesso, 2 = Processado com erro
resultado	Set	Resultado do processamento
resultado.codEmp	Integer	(Obrigatório) - Number(004) - Código da empresa
resultado.codFil	String	(Obrigatório) - Number(005) - Código da filial
resultado.cnpjFilial	String	(Opcional) - Number(015) - Número do cadastro nacional da pessoa jurídica da filial da empresa - Condição: Será retornado caso seja informado na baixa do título recebido
resultado.numTit	String	(Obrigatório) - String(010) - Número do título a receber
resultado.codTpt	String	(Obrigatório) - String(003) - Código do tipo de título a receber
resultado.seqMov	String	(Opcional) - Number(004) - Sequência de movimento do título
resultado.resultado	String	Resultado do processamento da requisição
mensagemRetorno	String	(Obrigatório) - String(250) - Mensagem de retorno da importação
OpenExcluirTitulosCR
Finanças - Gestão de Contas a Receber - Contas à Receber - Excluir Títulos

Necessita autenticação: Sim

Situação de versão: Atual

Versão: 1

Requisição:

<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.senior.com.br">
  <soapenv:Body>
    <ser:ExcluirTitulosCR>
      <user>String</user>
      <password>String</password>
      <encryption>Integer</encryption>
      <parameters>
        <titulos>
          <codEmp>String</codEmp>
          <codFil>String</codFil>
          <numTit>String</numTit>
          <codTpt>String</codTpt>
        </titulos>
      </parameters>
    </ser:ExcluirTitulosCR>
  </soapenv:Body>
</soapenv:Envelope>
Parâmetros da requisição:

Nome	Tipo	Descrição
titulos	Set	
titulos.codEmp	String	(Obrigatório) - Number(004) - Código da empresa
titulos.codFil	String	(Obrigatório) - Number(005) - Código da filial
titulos.numTit	String	(Obrigatório) - String(015) - Número do título a receber
titulos.codTpt	String	(Obrigatório) - String(003) - Código do tipo do título a receber
Resposta:

Observação

Envelope SOAP de resposta de requisições síncronas. Para requisições assíncronas ou agendamentos, a resposta é apenas uma String chamada "result" com o valor "OK", se foi executado com sucesso ou, caso contrário, a mensagem do erro ocorrido.

<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.senior.com.br">
  <soapenv:Body>
    <ser:ExcluirTitulosCRResponse>
      <result>
        <tipoRetorno>String</tipoRetorno>
        <resultado>
          <codEmp>Integer</codEmp>
          <codFil>String</codFil>
          <numTit>String</numTit>
          <codTpt>String</codTpt>
          <resultado>String</resultado>
        </resultado>
        <mensagemRetorno>String</mensagemRetorno>
        <erroExecucao>String</erroExecucao>
      </result>
    </ser:ExcluirTitulosCRResponse>
  </soapenv:Body>
</soapenv:Envelope>
Atributos da resposta:

Nome	Tipo	Descrição
erroExecucao	String	Indica erros ocorridos no servidor ao executar o serviço, podendo conter os seguintes valores:Vazio ou nulo, indicando que a execução foi feita com sucessoA mensagem do erro ocorrido no servidorSó impede a gravação quando o retorno.tipRet for igual a "2"
tipoRetorno	String	(Obrigatório) - Number(001) - Indicativo do tipo de retorno da solicitação - Lista: 1 = Processado com sucesso, 2 = Processado com erro
resultado	Set	
resultado.codEmp	Integer	(Obrigatório) - Number(004) - Código da empresa
resultado.codFil	String	(Obrigatório) - Number(005) - Código da filial
resultado.numTit	String	(Obrigatório) - String(015) - Número do título a receber
resultado.codTpt	String	(Obrigatório) - String(003) - Código do tipo de título a receber
resultado.resultado	String	Mensagem do resultado.
mensagemRetorno	String	(Obrigatório) - String(250) - Mensagem de retorno da exclusão
OpenSubstituirTitulosCR_3
Finanças - Gestão de Contas a Receber - Contas a Receber - Baixas de Títulos - Por Substituição

Necessita autenticação: Sim

Situação de versão: Atual

Versão: 3

Requisição:

<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.senior.com.br">
  <soapenv:Body>
    <ser:SubstituirTitulosCR>
      <user>String</user>
      <password>String</password>
      <encryption>Integer</encryption>
      <parameters>
        <titulosBaixar>
          <codFil>Integer</codFil>
          <numTit>String</numTit>
          <codTpt>String</codTpt>
          <codCli>Integer</codCli>
          <vlrBai>Double</vlrBai>
          <vlrJrs>Double</vlrJrs>
          <vlrMul>Double</vlrMul>
          <vlrEnc>Double</vlrEnc>
          <vlrCor>Double</vlrCor>
          <vlrOac>Double</vlrOac>
          <vlrDsc>Double</vlrDsc>
          <vlrOde>Double</vlrOde>
          <datLib>DateTime</datLib>
          <obsMcr>String</obsMcr>
          <numPrj>Integer</numPrj>
          <codFpj>Integer</codFpj>
          <ctaFin>Integer</ctaFin>
          <ctaRed>Integer</ctaRed>
          <codCcu>String</codCcu>
          <numInt>String</numInt>
          <camposUsuario>
            <campo>String</campo>
            <valor>String</valor>
          </camposUsuario>
        </titulosBaixar>
        <titulosSubstitutos>
          <codFil>Integer</codFil>
          <numTit>String</numTit>
          <codTpt>String</codTpt>
          <codCli>Integer</codCli>
          <vlrOri>Double</vlrOri>
          <codTns>String</codTns>
          <codFpg>Integer</codFpg>
          <codNtg>Integer</codNtg>
          <datEmi>DateTime</datEmi>
          <datEnt>DateTime</datEnt>
          <codSac>Double</codSac>
          <vctOri>DateTime</vctOri>
          <vctPro>DateTime</vctPro>
          <datPpt>DateTime</datPpt>
          <codMoe>String</codMoe>
          <datDsc>DateTime</datDsc>
          <antDsc>String</antDsc>
          <prdDsc>String</prdDsc>
          <perDsc>Integer</perDsc>
          <vlrDsc>Double</vlrDsc>
          <codPor>String</codPor>
          <codCrt>String</codCrt>
          <titBan>String</titBan>
          <seqCob>String</seqCob>
          <perMul>Integer</perMul>
          <tolMul>Integer</tolMul>
          <perJrs>Integer</perJrs>
          <vlrJrs>Double</vlrJrs>
          <tipJrs>String</tipJrs>
          <tolJrs>Integer</tolJrs>
          <tolDsc>Integer</tolDsc>
          <datNeg>DateTime</datNeg>
          <jrsNeg>Double</jrsNeg>
          <mulNeg>Double</mulNeg>
          <outNeg>Double</outNeg>
          <dscNeg>Double</dscNeg>
          <cotNeg>Double</cotNeg>
          <cheBan>String</cheBan>
          <cheAge>String</cheAge>
          <cheCta>String</cheCta>
          <cheNum>String</cheNum>
          <codFrj>String</codFrj>
          <codCrp>String</codCrp>
          <obsTcr>String</obsTcr>
          <numPrj>Integer</numPrj>
          <codFpj>Integer</codFpj>
          <ctaFin>Integer</ctaFin>
          <ctaRed>Integer</ctaRed>
          <codCcu>String</codCcu>
          <codBar>String</codBar>
          <catTef>String</catTef>
          <nsuTef>String</nsuTef>
          <catExt>String</catExt>
          <codOpe>Integer</codOpe>
          <numInt>String</numInt>
          <codCnv>Integer</codCnv>
          <rateio>
            <numPrj>Integer</numPrj>
            <codFpj>Integer</codFpj>
            <ctaFin>Integer</ctaFin>
            <ctaRed>Integer</ctaRed>
            <perCta>Double</perCta>
            <vlrCta>Double</vlrCta>
            <codCcu>String</codCcu>
            <perRat>Double</perRat>
            <vlrRat>Double</vlrRat>
            <obsRat>String</obsRat>
          </rateio>
          <camposUsuario>
            <campo>String</campo>
            <valor>String</valor>
          </camposUsuario>
        </titulosSubstitutos>
        <codEmp>Integer</codEmp>
        <codFil>Integer</codFil>
        <datPgt>DateTime</datPgt>
        <codTns>String</codTns>
        <forCli>String</forCli>
        <sigInt>String</sigInt>
        <idtReq>String</idtReq>
        <gerarExcecao>String</gerarExcecao>
      </parameters>
    </ser:SubstituirTitulosCR>
  </soapenv:Body>
</soapenv:Envelope>
Parâmetros da requisição:

Nome	Tipo	Descrição
titulosBaixar	Set	Títulos a baixar.
titulosBaixar.codFil	Integer	(Obrigatório) - Number(005) - Filial.
titulosBaixar.numTit	String	(Obrigatório) - String(015) - Título.
titulosBaixar.codTpt	String	(Obrigatório) - String(003) - Tipo Título.
titulosBaixar.codCli	Integer	(Obrigatório) - Number(009) - Cliente.
titulosBaixar.vlrBai	Double	(Obrigatório) - Number(015) - Valor a Baixar.
titulosBaixar.vlrJrs	Double	(Opcional) - Number(015) - Valor Juros.
titulosBaixar.vlrMul	Double	(Opcional) - Number(015) - Valor Multa.
titulosBaixar.vlrEnc	Double	(Opcional) - Number(015) - Valor Encargos.
titulosBaixar.vlrCor	Double	(Opcional) - Number(015) - Valor Correção Monetária.
titulosBaixar.vlrOac	Double	(Opcional) - Number(015) - Valor Outros Acréscimos.
titulosBaixar.vlrDsc	Double	(Opcional) - Number(015) - Valor Desconto.
titulosBaixar.vlrOde	Double	(Opcional) - Number(015) - Valor Outros Descontos.
titulosBaixar.datLib	DateTime	(Obrigatório) - Date(00/00/0000) - Data Liberação.
titulosBaixar.obsMcr	String	(Opcional) - String(250) - Observação.
titulosBaixar.numPrj	Integer	(Opcional) - Number(008) - Projeto.
titulosBaixar.codFpj	Integer	(Opcional) - Number(004) - Fase.
titulosBaixar.ctaFin	Integer	(Opcional) - Number(007) - Conta Financeira.
titulosBaixar.ctaRed	Integer	(Opcional) - Number(007) - Conta Contábil.
titulosBaixar.codCcu	String	(Opcional) - String(009) - Centro de Custos.
titulosBaixar.numInt	String	(Opcional) - String(100) - Número Integração Externo.
titulosBaixar.camposUsuario	Set	(Opcional) - Lista com os campos de usuário do título a baixar.
titulosBaixar.camposUsuario.campo	String	(Opcional) - String(20) - Nome do campo de usuário.
titulosBaixar.camposUsuario.campo	String	(Opcional) - String(250) - Valor do campo de usuário.
titulosSubstitutos	Set	Títulos substitutos.
titulosSubstitutos.codFil	Integer	(Obrigatório) - Number(005) - Filial.
titulosSubstitutos.numTit	String	(Obrigatório) - String(015) - Título.
titulosSubstitutos.codTpt	String	(Obrigatório) - String(003) - Tipo Título.
titulosSubstitutos.codCli	Integer	(Obrigatório) - Number(009) - Cliente.
titulosSubstitutos.vlrOri	Double	(Obrigatório) - Number(015) - Valor Original.
titulosSubstitutos.codTns	String	(Obrigatório) - String(005) - Transação.
titulosSubstitutos.codFpg	Integer	(Obrigatório) - Number(002) - Código da forma de pagamento.
titulosSubstitutos.codNtg	Integer	(Opcional) - Number(004) - Código da natureza de gasto.
titulosSubstitutos.datEmi	DateTime	(Obrigatório) - Date(00/00/0000) - Data Emissão.
titulosSubstitutos.datEnt	DateTime	(Obrigatório) - Date(00/00/0000) - Data Entrada.
titulosSubstitutos.codSac	Double	(Opcional) - Number(014) - Sacado.
titulosSubstitutos.vctOri	DateTime	(Obrigatório) - Date(00/00/0000) - Vencimento Original.
titulosSubstitutos.vctPro	DateTime	(Obrigatório) - Date(00/00/0000) - Vencimento Prorrogado.
titulosSubstitutos.datPpt	DateTime	(Obrigatório) - Date(00/00/0000) - Data Provável Pagamento.
titulosSubstitutos.codMoe	String	(Opcional) - String(003) - Moeda. (Este valor é obrigatório a partir da porta 2)
titulosSubstitutos.datDsc	DateTime	(Opcional) - Date(00/00/0000) - Data Desconto.
titulosSubstitutos.antDsc	String	(Opcional) - String(001) - Calcula Desconto por Antecipação - Lista: S = Sim, N = Não.
titulosSubstitutos.prdDsc	String	(Opcional) - String(001) - Período Desconto - Lista: D = Diário, M = Mensal.
titulosSubstitutos.perDsc	Integer	(Opcional) - Number(005) - % Desconto.
titulosSubstitutos.vlrDsc	Double	(Opcional) - Number(015) - Valor Desconto.
titulosSubstitutos.codPor	String	(Opcional) - String(004) - Portador. (Este valor é obrigatório a partir da porta 2)
titulosSubstitutos.codCrt	String	(Opcional) - String(002) - Carteira. (Este valor é obrigatório a partir da porta 2)
titulosSubstitutos.titBan	String	(Opcional) - String(020) - Nosso Nº.
titulosSubstitutos.seqCob	String	(Opcional) - Number(004) - Cód. Endereço de Cobrança
titulosSubstitutos.perMul	Integer	(Opcional) - Number(005) - % Multa.
titulosSubstitutos.tolMul	Integer	(Opcional) - Number(004) - Dias Tolerância Multa.
titulosSubstitutos.perJrs	Integer	(Opcional) - Number(005) - % Juros.
titulosSubstitutos.vlrJrs	Double	(Opcional) - Number(015) - Valor Juros.
titulosSubstitutos.tipJrs	String	(Opcional) - String(001) - Tipo Juros - Lista: S = Juros Simples, C = Juros Compostos.
titulosSubstitutos.tolJrs	Integer	(Opcional) - Number(004) - Dias Tolerância Juros.
titulosSubstitutos.tolDsc	Integer	(Opcional) - Number(004) - Tolerância para Desconto.
titulosSubstitutos.datNeg	DateTime	(Opcional) - Date(00/00/0000) - Data Validade Negociação.
titulosSubstitutos.jrsNeg	Double	(Opcional) - Number(015) - Valor Juros Negociados.
titulosSubstitutos.mulNeg	Double	(Opcional) - Number(015) - Valor Multa Negociada.
titulosSubstitutos.outNeg	Double	(Opcional) - Number(015) - Valor Outros Valores Negociados.
titulosSubstitutos.dscNeg	Double	(Opcional) - Number(015) - Valor Desconto Negociado.
titulosSubstitutos.cotNeg	Double	(Opcional) - Number(019) - Cotação Moeda Negociada.
titulosSubstitutos.cheBan	String	(Opcional) - String(003) - Número do banco na FEBRABAN do cheque.
titulosSubstitutos.cheAge	String	(Opcional) - String(007) - Número da agência do banco do cheque.
titulosSubstitutos.cheCta	String	(Opcional) - String(014) - Número da conta no banco do cheque.
titulosSubstitutos.cheNum	String	(Opcional) - String(010) - Número do cheque no banco.
titulosSubstitutos.codFrj	String	(Opcional) - String(003) - Fórmula de Reajuste.
titulosSubstitutos.codCrp	String	(Opcional) - String(003) - Grupo de Contas a Receber.
titulosSubstitutos.obsTcr	String	(Opcional) - String(250) - Observação.
titulosSubstitutos.numPrj	Integer	(Opcional) - Number(008) - Projeto.
titulosSubstitutos.codFpj	Integer	(Opcional) - Number(004) - Fase.
titulosSubstitutos.ctaFin	Integer	(Opcional) - Number(007) - Conta Financeira.
titulosSubstitutos.ctaRed	Integer	(Opcional) - Number(007) - Conta Contábil.
titulosSubstitutos.codCcu	String	(Opcional) - String(009) - Centro de Custos.
titulosSubstitutos.codBar	String	(Opcional) - String(050) - Código de Barra.
titulosSubstitutos.catTef	String	(Opcional) - String(100) - Autorização da Transação (TEF).
titulosSubstitutos.nsuTef	String	(Opcional) - String(100) - Número da Transação (TEF).
titulosSubstitutos.catExt	String	(Opcional) - String(100) - Autorização Externo.
titulosSubstitutos.codOpe	Integer	(Opcional) - Number(004) - Operadora
titulosSubstitutos.numInt	String	(Opcional) - String(100) - Número Integração Externo.
titulosSubstitutos.codCnv	Integer	(Opcional) - Number(009) - Código do convênio.
titulosSubstitutos.camposUsuario	Set	(Opcional) - Lista com os campos de usuário do título substituto.
titulosSubstitutos.camposUsuario.campo	String	(Opcional) - String(20) - Nome do campo de usuário.
titulosSubstitutos.camposUsuario.valor	String	(Opcional) - String(250) - Valor do campo de usuário.
titulosSubstitutos.rateio	Set	Rateio do título substituto.
rateio.numPrj	Integer	(Opcional) - Number(008) - Projeto.
rateio.codFpj	Integer	(Opcional) - Number(004) - Fase.
rateio.ctaFin	Integer	(Opcional) - Number(007) - Conta Financeira.
rateio.ctaRed	Integer	(Opcional) - Number(007) - Conta Contábil.
rateio.perCta	Double	(Opcional) - Number(007) - Percentual rateado para a conta.
rateio.vlrCta	Double	(Opcional) - Number(015) - Valor rateado para a conta.
rateio.codCcu	String	(Opcional) - String(009) - Centro de Custos.
rateio.perRat	Double	(Opcional) - Number(007) - Percentual rateado para o centro de custos.
rateio.vlrRat	Double	(Opcional) - Number(015) - Valor rateado para o centro de custos.
rateio.obsRat	String	(Opcional) - String(120) - Observação do rateio.
codEmp	Integer	(Obrigatório) - Number(004) - Código da empresa.
codFil	Integer	(Obrigatório) - Number(005) - Código da filial. Filial onde irá acontecer os movimentos.
datPgt	DateTime	(Obrigatório) - Date(00/00/0000) - Data da baixa. Esse campo se refere ao grupo de títulos a baixar.
codTns	String	(Obrigatório) - String(005) - Transação de baixa. Esse campo se refere ao grupo de títulos a baixar.
forCli	String	(Opcional) - String(001) - Cliente como Fornecedor.
sigInt	String	(Obrigatório) - String(15) - Sigla do Sistema de Integração
idtReq	String	(Obrigatório) - String(20) - Identificação da requisição
gerarExcecao	String	(Obrigatório) - Indicativo se o sistema deverá ou não gerar uma exceção de erro quando existe a integração varejo padrão na proprietária do cliente. Opções N - Não e S - Sim, valor padrão N.
Observação

Caso ocorra alguma situação onde será feita a tentativa de integrar uma mesma requisição duas vezes com as tags <sigInt> e <idtReq> informadas, a rotina não processará a segunda requisição porém, retornará para o sistema que a originou o mesmo retorno que foi enviado para a primeira requisição processada. Recomendamos que os registros destas tags sejam informados para evitar duplicidade no processamento de uma requisição.

Resposta:

Observação

Envelope SOAP de resposta de requisições síncronas. Para requisições assíncronas ou agendamentos, a resposta é apenas uma String chamada "result" com o valor "OK", se foi executado com sucesso ou, caso contrário, a mensagem do erro ocorrido.

<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.senior.com.br">
  <soapenv:Body>
    <ser:SubstituirTitulosCRResponse>
      <result>
        <result>
        <gridResult>
          <codEmp>Integer</codEmp>
          <codFil>Integer</codFil>
          <numTit>String</numTit>
          <codTpt>String</codTpt>
          <codCli>Integer</codCli>
          <numInt>String</numInt>
          <txtRet>String</txtRet>
        </gridResult>
        <tipMsg>String</tipMsg>
        <resultado>String</resultado>
        <erroExecucao>String</erroExecucao>
      </result>
    </ser:SubstituirTitulosCRResponse>
  </soapenv:Body>
</soapenv:Envelope>
Atributos da resposta:

Nome	Tipo	Descrição
erroExecucao	String	Indica erros ocorridos no servidor ao executar o serviço, podendo conter os seguintes valores:Vazio ou nulo, indicando que a execução foi feita com sucessoA mensagem do erro ocorrido no servidorSó impede a gravação quando o retorno.tipRet for igual a "2"
gridResult	Set	Itens de retorno.
gridResult.codEmp	Integer	Number(004) - Código da empresa.
gridResult.codFil	Integer	Number(005) - Filial.
gridResult.numTit	String	String(015) - Título.
gridResult.codTpt	String	String(003) - Tipo Título.
gridResult.codCli	Integer	Number(009) - Cliente.
gridResult.numInt	String	String(100) - Número Integração Externo.
gridResult.txtRet	String	String - Retorno
tipMsg	String	(Obrigatório) - String(15) - Sigla do Sistema de Integração
resultado	String	O campo resultado irá retornar as seguintes mensagens:

Execução do serviço sem erros:
"OK" -> Verificar títulos baixados e gerados na grade "Retorno".

Execução do serviço com erros:
"ERRO" -> Analizar os erros na grade "Retorno"
OpenGerarBaixaAproveitamentoCR
Finanças - Gestão de Contas a Receber - Baixa de Títulos - Por Créditos.

Necessita autenticação: sim.

Situação de versão: atual.

Versão: 3.

Requisição:

<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.senior.com.br">
  <soapenv:Body>
    <ser:GerarBaixaAproveitamentoCR>
      <user>String</user>
      <password>String</password>
      <encryption>Integer</encryption>
      <parameters>
        <gridTitulosCRE>
          <numInt>String</numInt>
          <codFil>Integer</codFil>
          <numTit>String</numTit>
          <codTpt>String</codTpt>
          <vlrBai>Double</vlrBai>
          <vlrCor>Double</vlrCor>
          <vlrOac>Double</vlrOac>
          <vlrOde>Double</vlrOde>
          <ctaFin>Integer</ctaFin>
          <numPrj>Integer</numPrj>
          <codFpj>Integer</codFpj>
          <ctaRed>Integer</ctaRed>
          <codCcu>String</codCcu>
          <moeBai>Double</moeBai>
          <moeOac>Double</moeOac>
          <vlrDsc>Double</vlrDsc>
        </gridTitulosCRE>
        <gridTitulosBAI>
          <numInt>String</numInt>
          <codFil>Integer</codFil>
          <numTit>String</numTit>
          <codTpt>String</codTpt>
          <vlrBai>Double</vlrBai>
          <vlrOud>Double</vlrOud>
          <vlrDsc>Double</vlrDsc>
          <vlrOde>Double</vlrOde>
          <vlrJrs>Double</vlrJrs>
          <vlrMul>Double</vlrMul>
          <vlrEnc>Double</vlrEnc>
          <vlrCor>Double</vlrCor>
          <vlrOac>Double</vlrOac>
          <numPrj>Integer</numPrj>
          <codFpj>Integer</codFpj>
          <ctaFin>Integer</ctaFin>
          <ctaRed>Integer</ctaRed>
          <codCcu>String</codCcu>
          <moeBai>Double</moeBai>
          <moeDsc>Double</moeDsc>
          <moeJrs>Double</moeJrs>
          <moeMul>Double</moeMul>
          <moeOac>Double</moeOac>
          <moeEnc>Double</moeEnc>
        </gridTitulosBAI>
        <codEmp>Integer</codEmp>
        <codFil>Integer</codFil>
        <datBai>DateTime</datBai>
        <tnsDup>String</tnsDup>
        <tnsCre>String</tnsCre>
        <idtReq>String</idtReq>
        <sigInt>String</sigInt>
      </parameters>
    </ser:GerarBaixaAproveitamentoCR>
  </soapenv:Body>
</soapenv:Envelope>
Parâmetros da requisição:

Nome	Tipo	Preenchimento	Ajuda
gridTitulosCRE	Set	Opcional	(Obrigatório) - Lista de títulos a aproveitar
gridTitulosCRE.numInt	String	Opcional	(Opcional) - String(100) - Número interno
gridTitulosCRE.codFil	Integer	Opcional	(Obrigatório) - Number(004) - Código da filial
gridTitulosCRE.numTit	String	Opcional	(Obrigatório) - String(015) - Número do título
gridTitulosCRE.codTpt	String	Opcional	(Obrigatório) - String(003) - Código do tipo do título
gridTitulosCRE.vlrBai	Double	Opcional	(Obrigatório) - Number(015,2) - Valor a baixar (aproveitar) do título. Recebe o valor convertido de MoeBai se esse campo for informado
gridTitulosCRE.vlrCor	Double	Opcional	(Opcional) - Number(015,2) - Valor correção da correção monetária. Recebe o valor convertido de MoeBai se esse campo for informado
gridTitulosCRE.vlrOac	Double	Opcional	(Opcional) - Number(015,2) - Valor de outros acréscimos. Recebe o valor convertido de MoeOac se esse campo for informado
gridTitulosCRE.vlrOde	Double	Opcional	(Opcional) - Number(015,2) - Valor de outros descontos.
gridTitulosCRE.ctaFin	Integer	Opcional	(Opcional) - Number(007) - Conta financeira reduzida
gridTitulosCRE.numPrj	Integer	Opcional	(Opcional) - Number(008) - Número do projeto
gridTitulosCRE.codFpj	Integer	Opcional	(Opcional) - Number(004) - Código da fase do projeto
gridTitulosCRE.ctaRed	Integer	Opcional	(Opcional) - Number(007) - Conta contábil reduzida
gridTitulosCRE.codCcu	String	Opcional	(Opcional) - String(009) - Código do centro de custo
gridTitulosCRE.moeBai	Double	Opcional	(Opcional) - Number(015,2) - Valor a baixar (aproveitar) do título na moeda do título. Se informado, irá substituir o valor dos campos VlrBai, VlrCor e VlrOde
gridTitulosCRE.moeOac	Double	Opcional	(Opcional) - Number(015,2) - Valor de outros acréscimos na moeda do título. Se informado, irá substituir o valor do campo VlrOac
gridTitulosCRE.vlrDsc	Double	Opcional	(Opcional) - Number(015,2) - Valor dos descontos.
gridTitulosBAI	Set	Opcional	(Obrigatório) - Lista de títulos a baixar
gridTitulosBAI.numInt	String	Opcional	(Opcional) - String(100) - Número interno
gridTitulosBAI.codFil	Integer	Opcional	(Obrigatório) - Number(004) - Código da filial
gridTitulosBAI.numTit	String	Opcional	(Obrigatório) - String(015) - Número do título
gridTitulosBAI.codTpt	String	Opcional	(Obrigatório) - String(003) - Código do tipo do título
gridTitulosBAI.vlrBai	Double	Opcional	(Obrigatório) - Number(015,2) - Valor a baixar do título. Recebe o valor convertido de MoeBai se esse campo for informado
gridTitulosBAI.vlrOud	Double	Opcional	Campo deprecado. Não utilizar
gridTitulosBAI.vlrDsc	Double	Opcional	(Opcional) - Number(015,2) - Valor do desconto. Recebe o valor convertido de MoeDsc se esse campo for informado

gridTitulosBAI.vlrOde	Double	Opcional	(Opcional) - Number(015,2) - Valor de outros descontos. Recebe o valor convertido de MoeBai se esse campo for informado
gridTitulosBAI.vlrJrs	Double	Opcional	(Opcional) - Number(015,2) - Valor dos juros de mora cobrados. Recebe o valor convertido de MoeJrs se esse campo for informado
gridTitulosBAI.vlrMul	Double	Opcional	(Opcional) - Number(015,2) - Valor da multa cobrada do título movimentado. Recebe o valor convertido de MoeMul se esse campo for informado
gridTitulosBAI.vlrEnc	Double	Opcional	(Opcional) - Number(015,2) - Valor dos encargos do título. Recebe o valor convertido de MoeEnc se esse campo for informado
gridTitulosBAI.vlrCor	Double	Opcional	(Opcional) - Number(015,2) - Valor correção da correção monetária. Recebe o valor convertido de MoeBai se esse campo for informado
gridTitulosBAI.vlrOac	Double	Opcional	(Opcional) - Number(015,2) - Valor de outros acréscimos. Recebe o valor convertido de MoeOac se esse campo for informado
gridTitulosBAI.numPrj	Integer	Opcional	(Opcional) - Number(008) - Número do projeto
gridTitulosBAI.codFpj	Integer	Opcional	(Opcional) - Number(004) - Código da fase do projeto
gridTitulosBAI.ctaFin	Integer	Opcional	(Opcional) - Number(007) - Conta financeira reduzida
gridTitulosBAI.ctaRed	Integer	Opcional	(Opcional) - Number(007) - Conta contábil reduzida
gridTitulosBAI.codCcu	String	Opcional	(Opcional) - String(009) - Código do centro de custo
gridTitulosBAI.moeBai	Double	Opcional	(Opcional) - Number(015,2) - Valor a baixar do título na moeda do título. Se informado, irá substituir o valor dos campos VlrBai, VlrCor e VlrOde
gridTitulosBAI.moeDsc	Double	Opcional	(Opcional) - Number(015,2) - Valor do desconto na moeda da empresa. Se informado, irá substituir o valor do campo VlrDsc
gridTitulosBAI.moeJrs	Double	Opcional	(Opcional) - Number(015,2) - Valor dos juros de mora cobrados na moeda da empresa. Se informado, irá substituir o valor do campo VlrJrs
gridTitulosBAI.moeMul	Double	Opcional	(Opcional) - Number(015,2) - Valor da multa cobrada do título movimentado na moeda da empresa. Se informado, irá substituir o valor do campo VlrMul
gridTitulosBAI.moeOac	Double	Opcional	(Opcional) - Number(015,2) - Valor de outros acréscimos na moeda do título. Se informado, irá substituir o valor do campo VlrOac
gridTitulosBAI.moeEnc	Double	Opcional	(Opcional) - Number(015,2) - Valor dos encargos do título na moeda da empresa. Se informado, irá substituir o valor do campo VlrEnc
codEmp	Integer	Opcional	(Obrigatório) - Number(004) - Código da Empresa
codFil	Integer	Opcional	(Obrigatório) - Number(004) - Código da Filial
datBai	DateTime	Opcional	(Obrigatório) - Date(DD/MM/YYYY) - Data da baixa
tnsDup	String	Opcional	(Obrigatório) - String(005) - Código da transação para baixa dos títulos a baixar
tnsCre	String	Opcional	(Obrigatório) - String(005) - Código da transação para baixa dos créditos
idtReq	String	Opcional	(Obrigatório) - String(005) - Identificação da requisição (Para controle de duplicidade)
sigInt	String	Opcional	(Opcional) - String(15) - Sigla do Sistema de Integração
Resposta:

Observação

Envelope SOAP de resposta de requisições síncronas. Para requisições assíncronas ou agendamentos, a resposta é apenas uma String chamada "result" com o valor "OK", se foi executado com sucesso ou, caso contrário, a mensagem do erro ocorrido.

<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.senior.com.br">
  <soapenv:Body>
    <ser:GerarBaixaAproveitamentoCRResponse>
      <result>
        <gridRetorno>
          <numInt>String</numInt>
          <codEmp>String</codEmp>
          <codFil>String</codFil>
          <numTit>String</numTit>
          <codTpt>String</codTpt>
          <msgErr>String</msgErr>
        </gridRetorno>
        <resultado>String</resultado>
        <erroExecucao>String</erroExecucao>
      </result>
    </ser:GerarBaixaAproveitamentoCRResponse>
  </soapenv:Body>
</soapenv:Envelope>
Atributos da resposta:

Nome	Tipo	Preenchimento	Ajuda
gridRetorno	Set	Opcional	(Opcional) Retorno do processamento
gridRetorno.numInt	String	Opcional	(Opcional) - String(100) - Número interno
gridRetorno.codEmp	String	Opcional	(Opcional) - Number(004) - Código da empresa
gridRetorno.codFil	String	Opcional	(Opcional) - Number(004) - Código da filial
gridRetorno.numTit	String	Opcional	(Opcional) - String(015) - Número do título
gridRetorno.codTpt	String	Opcional	(Opcional) - Number(003) - Código do tipo de título
gridRetorno.msgErr	String	Opcional	(Obrigatório) - Mensagem de retorno do processamento
resultado	String	Opcional	(Obrigatório) - O campo resultado vai retornar as seguintes mensagens: "OK" (Execução do serviço sem erros) e "ERRO" (Analisar os erros na grade "Retorno")
erroExecucao	String	Opcional	
Indica erros ocorridos no servidor ao executar o serviço, podendo conter os seguintes valores:
Vazio ou nulo, indicando que a execução foi feita com sucesso
A mensagem do erro ocorrido no servidor
Só impede a gravação quando o retorno.tipRet for igual a "2"
OpenGerarBaixaPorLoteCR
Finanças - Gestão de Contas a Receber - Baixa de Títulos - Por Lote - Automáticas. Disponível caso a proprietária do cliente tenha o módulo FRCR.

Necessita autenticação: sim.

Situação de versão: atual.

Versão: 3.

Requisição:

<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.senior.com.br">
  <soapenv:Body>
    <ser:GerarBaixaPorLoteCR>
      <user>String</user>
      <password>String</password>
      <encryption>Integer</encryption>
      <parameters>
        <gridTitulosBaixar>
          <numInt>String</numInt>
          <codFil>Integer</codFil>
          <numTit>String</numTit>
          <codTpt>String</codTpt>
          <vlrBai>String</vlrBai>
          <vlrDsc>Double</vlrDsc>
          <vlrOde>Double</vlrOde>
          <vlrJrs>Double</vlrJrs>
          <vlrMul>Double</vlrMul>
          <vlrEnc>Double</vlrEnc>
          <vlrCor>Double</vlrCor>
          <vlrOac>Double</vlrOac>
          <cotPgt>Double</cotPgt>
          <codFpg>Integer</codFpg>
          <obsMcr>String</obsMcr>
          <moeBai>Double</moeBai>
          <moeJrs>Double</moeJrs>
          <moeMul>Double</moeMul>
          <moeEnc>Double</moeEnc>
          <moeOac>Double</moeOac>
          <moeDsc>Double</moeDsc>
          <vlrDcb>Double</vlrDcb>
        </gridTitulosBaixar>
        <gridTesouraria>
          <datCtb>DateTime</datCtb>
          <datLib>DateTime</datLib>
          <codTns>String</codTns>
          <vlrMov>Double</vlrMov>
        </gridTesouraria>
        <codEmp>Integer</codEmp>
        <codFil>Integer</codFil>
        <datBai>DateTime</datBai>
        <tnsBai>String</tnsBai>
        <numDoc>String</numDoc>
        <tnsCxb>String</tnsCxb>
        <datCxb>DateTime</datCxb>
        <numCco>String</numCco>
        <vlrLiq>Double</vlrLiq>
        <sigInt>String</sigInt>
        <idtReq>String</idtReq>
        <codEqu>Integer</codEqu>
      </parameters>
    </ser:GerarBaixaPorLoteCR>
  </soapenv:Body>
</soapenv:Envelope>
Parâmetros da requisição:

Nome	Tipo	Descrição
gridTitulosBaixar	Set	Títulos a baixar
gridTitulosBaixar.numInt	String	(Opcional) - String(100) - Número interno
gridTitulosBaixar.codFil	Integer	(Obrigatório) - Number(005) - Código da filial
gridTitulosBaixar.numTit	String	(Obrigatório) - String(015) - Número do título a receber
gridTitulosBaixar.codTpt	String	(Obrigatório) - String(003) - Código do tipo de título a receber
gridTitulosBaixar.vlrBai	String	(Obrigatório) - Number(15,2) - Valor a Baixar
gridTitulosBaixar.vlrDsc	Double	(Opcional) - Number(15,2) - Valor do desconto título
gridTitulosBaixar.vlrOde	Double	(Opcional) - Number(15,2) - Valor de outros descontos do título
gridTitulosBaixar.vlrJrs	Double	(Opcional) - Number(15,2) - Valor dos juros do título
gridTitulosBaixar.vlrMul	Double	(Opcional) - Number(15,2) - Valor da multa do título
gridTitulosBaixar.vlrEnc	Double	(Opcional) - Number(15,2) - Valor dos encargos do título
gridTitulosBaixar.vlrCor	Double	(Opcional) - Number(15,2) - Valor da correção monetária do título
gridTitulosBaixar.vlrOac	Double	(Opcional) - Number(15,2) - Valor de outros acréscimos do título
gridTitulosBaixar.codFpg	Integer	(Opcional) - Number(002) - Código da forma de pagamento
gridTitulosBaixar.obsMcr	String	(Opcional) - String(250) - Observação do movimento do contas a receber
gridTitulosBaixar.moeBai	Double	Number(015,2) - Valor a baixar do título na moeda dele. Se informado, irá substituir o valor dos campos VlrBai, VlrCor e VlrOde
gridTitulosBaixar.moeJrs	Double	Number(015,2) - Valor dos juros de mora cobrados na moeda da empresa. Se informado, irá substituir o valor do campo VlrJrs
gridTitulosBaixar.moeMul	Double	Number(015,2) - Valor da multa cobrada do título movimentado na moeda da empresa. Se informado, irá substituir o valor do campo VlrMul
gridTitulosBaixar.moeEnc	Double	Number(015,2) - Valor dos encargos do título na moeda da empresa. Se informado, irá substituir o valor do campo VlrEnc
gridTitulosBaixar.moeOac	Double	Number(015,2) - Valor de outros acréscimos na moeda do título. Se informado, irá substituir o valor do campo VlrOac
gridTitulosBaixar.moeDsc	Double	Number(015,2) - Valor do desconto na moeda da empresa. Se informado, irá substituir o valor do campo VlrDsc
gridTitulosBaixar.vlrDcb	Double	Number(015,2) - Valor da taxa de cobrança. Se informada, o valor da taxa será descontado no valor líquido do título
gridTesouraria	Set	Lista de movimentos da Tesouraria
gridTesouraria.datCtb	DateTime	(Obrigatório) - Date - Data contábil do movimento
gridTesouraria.datLib	DateTime	(Obrigatório) - Date - Data da liberação do movimento
gridTesouraria.codTns	String	(Obrigatório) - String(005) - Código da transação de movimento
gridTesouraria.vlrMov	Double	(Obrigatório) - Number(15,2) - Valor do movimento
codEmp	Integer	(Obrigatório) - Number(004) - Código da empresa
codFil	Integer	(Obrigatório) - Number(005) - Código da filial
datBai	DateTime	(Obrigatório) - Date - Data de baixa
tnsBai	String	(Obrigatório) - String(005) - Código da transação para baixa dos títulos a baixar
numDoc	String	(Opcional) - String(020) - Número do Documento
tnsCxb	String	(Opcional) - String(005) - Código da transação para movimento tesouraria
datCxb	DateTime	(Obrigatório) - Date - Data movimento tesouraria
numCco	String	(Opcional) - String(014) - Número da conta interna da Tesouraria. Pode ser sugerido a partir do PDV (CodEqu) ou do portador wiipo
vlrLiq	Double	(Opcional) - Number(015,2) - Valor líquido creditado
sigInt	String	(Obrigatório) - String(15) - Sigla do Sistema de Integração
idtReq	String	(Opcional) - String(005) - Identificação da requisição (Para controle de duplicidade).
codEqu	Integer	(Opcional) - Number(003) - Código do equipamento fiscal da redução Z
vlrDcb	Double	(Opcional) - Number(013,2) - Valor das despesas de cobrança
Resposta:

Observação

Envelope SOAP de resposta de requisições síncronas. Para requisições assíncronas ou agendamentos, a resposta é apenas uma String chamada "result" com o valor "OK", se foi executado com sucesso ou, caso contrário, a mensagem do erro ocorrido.

<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.senior.com.br">
  <soapenv:Body>
    <ser:GerarBaixaPorLoteCRResponse>
      <result>
        <gridRetorno>
          <numInt>String</numInt>
          <codEmp>String</codEmp>
          <codFil>String</codFil>
          <numTit>String</numTit>
          <codTpt>String</codTpt>
          <msgErr>String</msgErr>
        </gridRetorno>
        <resultado>String</resultado>
        <tipMsg>String</tipMsg>
        <erroExecucao>String</erroExecucao>
      </result>
    </ser:GerarBaixaPorLoteCRResponse>
  </soapenv:Body>
</soapenv:Envelope>
Atributos da resposta:

Nome	Tipo	Descrição
erroExecucao	String	Indica erros ocorridos no servidor ao executar o serviço, podendo conter os seguintes valores:Vazio ou nulo, indicando que a execução foi feita com sucessoA mensagem do erro ocorrido no servidorSó impede a gravação quando o retorno.tipRet for igual a "2"
gridRetorno	Set	Retorno
gridRetorno.numInt	String	String(100) - Número interno
gridRetorno.codEmp	String	Number(004) - Código da empresa
gridRetorno.codFil	String	Number(005) - Código da filial
gridRetorno.numTit	String	String(015) - Número do título
gridRetorno.codTpt	String	Number(003) - Código do tipo de título
gridRetorno.msgErr	String	Mensagem de retorno
resultado	String	Resultado da operação: execução do serviço sem erros: "OK"; execução do serviço com erros: "ERRO" - Analisar os erros na grade Retorno
tipMsg	String	(Obrigatório) - String(15) - Sigla do Sistema de Integração
OpenEstornoBaixaTitulosCR
Finanças - Gestão de Contas a Receber - Contas à Receber - Estorno de Baixa de Títulos

Importante

Caso o cliente utilize Controle por Lote, a chave de lote também deve ser informada para proceder a chamada ao Estorno da Baixa de Títulos por Substituição.

Necessita autenticação: Sim

Situação de versão: Atual

Versão: 1

Requisição:

<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.senior.com.br">
  <soapenv:Body>
    <ser:EstornoBaixaTitulosCR>
      <user>String</user>
      <password>String</password>
      <encryption>Integer</encryption>
      <parameters>
        <titulosReceber>
          <codEmp>Integer</codEmp>
          <codFil>Integer</codFil>
          <numTit>String</numTit>
          <codTpt>String</codTpt>
          <seqMov>Integer</seqMov>
          <chvLot>String</chvLot>
          <ideExt>Integer</ideExt>
        </titulosReceber>
        <sistemaIntegracao>String</sistemaIntegracao>
      </parameters>
    </ser:EstornoBaixaTitulosCR>
  </soapenv:Body>
</soapenv:Envelope>
Parâmetros da requisição:

Nome	Tipo	Descrição
titulosReceber	Set	Movimentos de títulos a receber
titulosReceber.codEmp	Integer	(Obrigatório) - CodEmp - Number(004) - Código da empresa
titulosReceber.codFil	Integer	(Obrigatório) - CodFil - Number(005) - Código da filial
titulosReceber.numTit	String	(Obrigatório) - NumTit - String(015) - Número do título a receber
titulosReceber.codTpt	String	(Obrigatório) - CodTpt - String(003) - Código do tipo de título a receber
titulosReceber.seqMov	Integer	(Obrigatório) - SeqMov - Number(004) - Sequência de baixa do título a receber
titulosReceber.chvLot	String	(Opcional) - String(024) - Chave do lote agrupador das baixas.
titulosReceber.ideExt	Integer	(Opcional) - IdeExt - Number(015) - Identificador Externo
sistemaIntegracao	String	String(15) - Identificação do sistema integrado
Resposta:

Observação

Envelope SOAP de resposta de requisições síncronas. Para requisições assíncronas ou agendamentos, a resposta é apenas uma String chamada "result" com o valor "OK", se foi executado com sucesso ou, caso contrário, a mensagem do erro ocorrido.

<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.senior.com.br">
  <soapenv:Body>
    <ser:EstornoBaixaTitulosCRResponse>
      <result>
        <tipoRetorno>Integer</tipoRetorno>
        <retorno>
          <codEmp>Integer</codEmp>
          <codFil>Integer</codFil>
          <numTit>String</numTit>
          <codTpt>String</codTpt>
          <seqMov>Integer</seqMov>
          <chvLot>String</chvLot>
          <ideExt>Integer</ideExt>
          <tipRet>Integer</tipRet>
          <msgRet>String</msgRet>
        </retorno>
        <mensagemRetorno>String</mensagemRetorno>
        <erroExecucao>String</erroExecucao>
      </result>
    </ser:EstornoBaixaTitulosCRResponse>
  </soapenv:Body>
</soapenv:Envelope>
Atributos da resposta:

Nome	Tipo	Descrição
erroExecucao	String	Indica erros ocorridos no servidor ao executar o serviço, podendo conter os seguintes valores:Vazio ou nulo, indicando que a execução foi feita com sucessoA mensagem do erro ocorrido no servidorSó impede a gravação quando o retorno.tipRet for igual a "2"
tipoRetorno	Integer	(Obrigatório) - Number(001) - Tipo de Retorno de Processamento - Lista: 1 = Processado, 2 = Erro na Solicitação
retorno	Set	Retorno do resultado do serviço
retorno.codEmp	Integer	CodEmp - Number(004) - Código da empresa
retorno.codFil	Integer	CodFil - Number(005) - Código da filial
retorno.numTit	String	NumTit - String(015) - Número do título a receber
retorno.codTpt	String	CodTpt - String(003) - Código do tipo de título a receber
retorno.seqMov	Integer	SeqMov - Number(004) - Sequência de baixa do título a receber
retorno.chvLot	String	String(024) - Chave do lote agrupador das baixas.
retorno.ideExt	Integer	IdeExt - Number(015) - Identificador Externo
retorno.tipRet	Integer	TipRet - Number(001) - Tipo de Retorno de Processamento - Lista: 1 = Processado, 2 = Erro na Solicitação
retorno.msgRet	String	MsgRet - String - Mensagem de retorno
mensagemRetorno	String	(Obrigatório) - String(1000) - Mensagem de Retorno de Processamento
OpenExportarBaixaTitulosReceberVenda
Finanças - Gestão de Contas a Receber - Exportar Baixa de Títulos por Título ou Nota Fiscal de Saída

Necessita autenticação: Sim

Situação de versão: Atual

Versão: 1

Requisição:

<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.senior.com.br">
  <soapenv:Body>
    <ser:ExportarBaixaTitulosReceberVenda>
      <user>String</user>
      <password>String</password>
      <encryption>Integer</encryption>
      <parameters>
        <codEmp>Integer</codEmp>
        <consulta>
          <codTpt>String</codTpt>
          <numTit>String</numTit>
          <codSnf>String</codSnf>
          <numNfv>Integer</numNfv>
        </consulta>
        <codFil>Integer</codFil>
        <tipExp>String</tipExp>
      </parameters>
    </ser:ExportarBaixaTitulosReceberVenda>
  </soapenv:Body>
</soapenv:Envelope>
Parâmetros da requisição:

Nome	Tipo	Descrição
codEmp	Integer	(Obrigatório) - Number(004) - Código da Empresa
consulta	Set	Consulta de registros específicos
consulta.codTpt	String	(Opcional) - CodTpt - String(003) - Código do tipo do título movimentado. Condição: obrigatório caso não seja informado o número da nota fiscal de saída.
consulta.numTit	String	(Opcional) - NumTit - String(015) - Número do título movimentado. Condição: obrigatório caso não seja informado o número da nota fiscal de saída.
consulta.codSnf	String	(Opcional) - CodSnf - String(003) - Código da série fiscal da nota fiscal de saída. Condição: obrigatório caso não seja informado o número do título.
consulta.numNfv	Integer	(Opcional) - NumNfv - Number(009) - Número da nota fiscal de saída que gerou os títulos. Condição: obrigatório caso não seja informado o número do título.
codFil	Integer	(Obrigatório) - Number(005) - Código da Filial
tipExp	String	(Obrigatório) - String(001) - Tipo de exportação. Informar "T" para consulta por "Título" ou "N" para consulta por nota fiscal de saída
Resposta:

Observação

Envelope SOAP de resposta de requisições síncronas. Para requisições assíncronas ou agendamentos, a resposta é apenas uma String chamada "result" com o valor "OK", se foi executado com sucesso ou, caso contrário, a mensagem do erro ocorrido.

<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.senior.com.br">
  <soapenv:Body>
    <ser:ExportarBaixaTitulosReceberVendaResponse>
      <result>
        <baixaTitulos>
          <bxaCpt>String</bxaCpt>
          <tipBai>String</tipBai>
          <codEmp>Integer</codEmp>
          <codFil>Integer</codFil>
          <numTit>String</numTit>
          <codTpt>String</codTpt>
          <seqMov>Integer</seqMov>
          <codTns>String</codTns>
          <datMov>String</datMov>
          <obsMcr>String</obsMcr>
          <numDoc>String</numDoc>
          <vctPro>String</vctPro>
          <proJrs>Integer</proJrs>
          <vlrAbe>Double</vlrAbe>
          <codFrj>String</codFrj>
          <cotFrj>Double</cotFrj>
          <datPgt>String</datPgt>
          <codFpg>Integer</codFpg>
          <cotMcr>Double</cotMcr>
          <diaAtr>Integer</diaAtr>
          <diaJrs>Integer</diaJrs>
          <recJoa>Integer</recJoa>
          <recJod>Integer</recJod>
          <datLib>String</datLib>
          <vlrMov>Double</vlrMov>
          <vlrDsc>Double</vlrDsc>
          <vlrOde>Double</vlrOde>
          <vlrJrs>Double</vlrJrs>
          <vlrMul>Double</vlrMul>
          <vlrEnc>Double</vlrEnc>
          <vlrCor>Double</vlrCor>
          <vlrOac>Double</vlrOac>
          <vlrPis>Double</vlrPis>
          <vlrBpr>Double</vlrBpr>
          <vlrCof>Double</vlrCof>
          <vlrBcr>Double</vlrBcr>
          <vlrPit>Double</vlrPit>
          <vlrBpt>Double</vlrBpt>
          <vlrOpt>Double</vlrOpt>
          <vlrCrt>Double</vlrCrt>
          <vlrBct>Double</vlrBct>
          <vlrOct>Double</vlrOct>
          <vlrCsl>Double</vlrCsl>
          <vlrBcl>Double</vlrBcl>
          <vlrOcl>Double</vlrOcl>
          <vlrOur>Double</vlrOur>
          <vlrBor>Double</vlrBor>
          <vlrOor>Double</vlrOor>
          <vlrLiq>Double</vlrLiq>
          <vlrBco>Double</vlrBco>
          <vlrCom>Double</vlrCom>
          <perJrs>Double</perJrs>
          <ultPgt>String</ultPgt>
          <cjmAnt>String</cjmAnt>
          <jrsCal>Double</jrsCal>
          <jrsPro>Integer</jrsPro>
          <codPor>String</codPor>
          <codCrt>String</codCrt>
          <porAnt>String</porAnt>
          <crtAnt>String</crtAnt>
          <numPrj>Integer</numPrj>
          <codFpj>Integer</codFpj>
          <ctaFin>Integer</ctaFin>
          <ctaRed>Integer</ctaRed>
          <codCcu>String</codCcu>
          <empCco>Integer</empCco>
          <numCco>String</numCco>
          <datCco>String</datCco>
          <seqCco>Integer</seqCco>
          <filRlc>Integer</filRlc>
          <numRlc>String</numRlc>
          <tptRlc>String</tptRlc>
          <forRlc>Integer</forRlc>
          <seqRlc>Integer</seqRlc>
          <seqMcp>Integer</seqMcp>
          <indVcr>Integer</indVcr>
          <lctFin>Integer</lctFin>
          <tipCof>Integer</tipCof>
          <lotBai>Integer</lotBai>
          <lotBfi>Integer</lotBfi>
          <numLot>Integer</numLot>
          <usuGer>Double</usuGer>
          <datGer>String</datGer>
          <horGer>String</horGer>
          <indExp>Integer</indExp>
          <filFix>Integer</filFix>
          <numFix>Integer</numFix>
          <recMoa>Integer</recMoa>
          <intImp>Integer</intImp>
          <intDif>Integer</intDif>
          <vlrIrf>Double</vlrIrf>
          <vlrBir>Double</vlrBir>
          <vlrOir>Double</vlrOir>
          <chvLot>String</chvLot>
          <vlrInt>Double</vlrInt>
          <seqLba>Integer</seqLba>
          <filOri>Integer</filOri>
          <reaAnb>String</reaAnb>
          <numPdv>Integer</numPdv>
        </baixaTitulos>
        <erros>
          <msgErr>String</msgErr>
        </erros>
        <tipoRetorno>Integer</tipoRetorno>
        <mensagemRetorno>String</mensagemRetorno>
        <erroExecucao>String</erroExecucao>
      </result>
    </ser:ExportarBaixaTitulosReceberVendaResponse>
  </soapenv:Body>
</soapenv:Envelope>
Atributos da resposta:

Nome	Tipo	Descrição
erroExecucao	String	Indica erros ocorridos no servidor ao executar o serviço, podendo conter os seguintes valores:Vazio ou nulo, indicando que a execução foi feita com sucessoA mensagem do erro ocorrido no servidorSó impede a gravação quando o retorno.tipRet for igual a "2"
baixaTitulos	Set	Campos do registro de baixa de títulos a receber
baixaTitulos.bxaCpt	String	BxaCpt - String(001) - Indicativo se o título é composto (S - composto ou N - simples)
baixaTitulos.tipBai	String	TipBai - String(002) - Tipo de baixa. Lista: "PG" - Pagamento, "AB" - Abatimento, "CR" - Baixa Crédito, "CP" - Compensação, "SU" - Substituição
baixaTitulos.codEmp	Integer	CodEmp - Number(004) - Código da empresa
baixaTitulos.codFil	Integer	CodFil - Number(005) - Código da filial
baixaTitulos.numTit	String	NumTit - String(015) - Número do título movimentado
baixaTitulos.codTpt	String	CodTpt - String(003) - Código do tipo do título movimentado
baixaTitulos.seqMov	Integer	SeqMov - Number(004) - Sequência de movimento do título
baixaTitulos.codTns	String	CodTns - String(005) - Código da transação do título movimentado
baixaTitulos.datMov	DateTime	DatMov - Date(DD/MM/YYYY) - Data do movimento do título
baixaTitulos.obsMcr	String	ObsMcr - String(250) - Observação do movimento do contas a receber
baixaTitulos.numDoc	String	NumDoc - String(020) - Número do documento do movimento do título
baixaTitulos.vctPro	DateTime	VctPro - Date(DD/MM/YYYY) - Data do vencimento atual do título
baixaTitulos.proJrs	Integer	ProJrs - ( Lista: 0 = Não, 1 = Sim) - Byte - Indicativo se o vencimento prorrogado é com ou sem juros
baixaTitulos.vlrAbe	Double	VlrAbe - Number(015,2) - Valor em aberto do título movimentado
baixaTitulos.codFrj	String	CodFrj - String(003) - Código da fórmula de reajuste do título movimentado
baixaTitulos.cotFrj	Double	CotFrj - Number(019,10) - Valor da cotação da moeda do reajuste na data do movimento do título
baixaTitulos.datPgt	DateTime	DatPgt - Date(DD/MM/YYYY) - Data do movimento, pagamento, baixa do título movimentado
baixaTitulos.codFpg	Integer	CodFpg - Number(002) - Código da forma de pagamento
baixaTitulos.cotMcr	Double	CotMcr - Number(019,10) - Valor da cotação da moeda na data base do movimento
baixaTitulos.diaAtr	Integer	DiaAtr - Number(004) - Dias de atraso no pagamento do título movimentado
baixaTitulos.diaJrs	Integer	DiaJrs - Number(004) - Dias de atraso para efeito de juros no pagamento do título movimentado
baixaTitulos.recJoa	Integer	RecJoa - ( Lista: 0 = Não, 1 = Sim) - Byte - Indicativo se considerou o valor de outros acréscimos da Fórmula de Reajuste para cálculo de juros do contas a receber do título movimentado
baixaTitulos.recJod	Integer	RecJod - ( Lista: 0 = Não, 1 = Sim) - Byte - Indicativo se considerou o valor de outros descontos da Fórmula de Reajuste para cálculo de juros do contas a receber do título movimentado
baixaTitulos.datLib	DateTime	DatLib - Date(DD/MM/YYYY) - Data da liberação para comissão e caixa/bancos
baixaTitulos.vlrMov	Double	VlrMov - Number(015,2) - Valor do movimento do título
baixaTitulos.vlrDsc	Double	VlrDsc - Number(015,2) - Valor do desconto concedido ao título movimentado
baixaTitulos.vlrOde	Double	VlrOde - Number(015,2) - Valor de outros descontos do título
baixaTitulos.vlrJrs	Double	VlrJrs - Number(015,2) - Valor dos juros de mora cobrados do título movimentado
baixaTitulos.vlrMul	Double	VlrMul - Number(015,2) - Valor da multa cobrada do título movimentado
baixaTitulos.vlrEnc	Double	VlrEnc - Number(015,2) - Valor dos encargos do título
baixaTitulos.vlrCor	Double	VlrCor - Number(015,2) - Valor da correção monetária do título
baixaTitulos.vlrOac	Double	VlrOac - Number(015,2) - Valor de outros acréscimos do títulos
baixaTitulos.vlrPis	Double	VlrPis - Number(014,2) - Valor do imposto PIS
baixaTitulos.vlrBpr	Double	VlrBpr - Number(015,2) - Base de cálculo do PIS a recuperar
baixaTitulos.vlrCof	Double	VlrCof - Number(014,2) - Valor do imposto COFINS a recuperar
baixaTitulos.vlrBcr	Double	VlrBcr - Number(015,2) - Base de cálculo do COFINS a recuperar
baixaTitulos.vlrPit	Double	VlrPit - Number(015,2) - Valor do PIS retido do título a receber
baixaTitulos.vlrBpt	Double	VlrBpt - Number(015,2) - Soma dos valores base do PIS Retido
baixaTitulos.vlrOpt	Double	VlrOpt - Number(015,2) - Soma dos valores base original do PIS Retido
baixaTitulos.vlrCrt	Double	VlrCrt - Number(015,2) - Valor do COFINS retido do título a receber
baixaTitulos.vlrBct	Double	VlrBct - Number(015,2) - Soma dos valores base do COFINS Retido
baixaTitulos.vlrOct	Double	VlrOct - Number(015,2) - Soma dos valores base original do COFINS Retido
baixaTitulos.vlrCsl	Double	VlrCsl - Number(015,2) - Valor da CSLL retida do título a receber
baixaTitulos.vlrBcl	Double	VlrBcl - Number(015,2) - Soma dos valores base do CSLL Retido
baixaTitulos.vlrOcl	Double	VlrOcl - Number(015,2) - Soma dos valores base original do CSLL Retido
baixaTitulos.vlrOur	Double	VlrOur - Number(015,2) - Valor de Outras Retenções retida do título a receber
baixaTitulos.vlrBor	Double	VlrBor - Number(015,2) - Soma dos valores base de Outras Retenções
baixaTitulos.vlrOor	Double	VlrOor - Number(015,2) - Soma dos valores base original de Outras Retenções
baixaTitulos.vlrLiq	Double	VlrLiq - Number(015,2) - Valor líquido do movimento do título
baixaTitulos.vlrBco	Double	VlrBco - Number(015,2) - Valor base comissão do título movimentado
baixaTitulos.vlrCom	Double	VlrCom - Number(015,2) - Valor da comissão do título movimentado
baixaTitulos.perJrs	Double	PerJrs - Number(005,2) - Percentual de juros mora mês do títulos movimentado
baixaTitulos.ultPgt	DateTime	UltPgt - Date(DD/MM/YYYY) - Última data de pagamento do título movimentado
baixaTitulos.cjmAnt	DateTime	CjmAnt - Date(DD/MM/YYYY) - Última data válida para cálculo de juros de mora
baixaTitulos.jrsCal	Double	JrsCal - Number(015,2) - Valor dos juros de mora calculado
baixaTitulos.jrsPro	Integer	JrsPro - ( Lista: 0 = Não, 1 = Sim) - Byte - Indicativos se os juros devidos já foram processados
baixaTitulos.codPor	String	CodPor - String(004) - Código do portador atual do título
baixaTitulos.codCrt	String	CodCrt - String(002) - Código da carteira atual do título
baixaTitulos.porAnt	String	PorAnt - String(004) - Código do portador anterior do título
baixaTitulos.crtAnt	String	CrtAnt - String(002) - Código da carteira anterior do título
baixaTitulos.numPrj	Integer	NumPrj - Number(008) - Número do projeto
baixaTitulos.codFpj	Integer	CodFpj - Number(004) - Código da fase do projeto
baixaTitulos.ctaFin	Integer	CtaFin - Number(007) - Conta financeira reduzida
baixaTitulos.ctaRed	Integer	CtaRed - Number(007) - Conta contábil reduzida
baixaTitulos.codCcu	String	CodCcu - String(009) - Código do centro de custo
baixaTitulos.empCco	Integer	EmpCco - Number(004) - Código da empresa do movimento da conta interna
baixaTitulos.numCco	String	NumCco - String(014) - Número da conta interna
baixaTitulos.datCco	DateTime	DatCco - Date(DD/MM/YYYY) - Data do movimento da conta interna
baixaTitulos.seqCco	Integer	SeqCco - Number(006) - Sequência do movimento da conta interna
baixaTitulos.filRlc	Integer	FilRlc - Number(005) - Código da filial do título relacionado (gerado ou aproveitado)
baixaTitulos.numRlc	String	NumRlc - String(015) - Número do título relacionado (gerado ou aproveitado)
baixaTitulos.tptRlc	String	TptRlc - String(003) - Tipo do título relacionado (gerado ou aproveitado)
baixaTitulos.forRlc	Integer	ForRlc - Number(009) - Código do fornecedor do título relacionado (p/ Contas a Pagar)
baixaTitulos.seqRlc	Integer	SeqRlc - Number(004) - Sequência do movimento relacionado (gerado ou aproveitado)
baixaTitulos.seqMcp	Integer	SeqMcp - Number(004) - Sequência do movimento do contas a pagar relacionado
baixaTitulos.indVcr	Integer	IndVcr - ( Lista: 0 = Não, 1 = Sim) - Byte - Indicativo se os valores do movimento foram calculados por regra do usuário
baixaTitulos.lctFin	Integer	LctFin - ( Lista: 0 = Não, 1 = Sim) - Byte - Indicativo se o movimento foi lançado no plano financeiro
baixaTitulos.tipCof	Integer	TipCof - Number(001) - Indicativo de controle de geração de COFINS Lista: 1 = Não Gerada, 2 = Gerada, 3 = Desconsiderada
baixaTitulos.lotBai	Integer	LotBai - Number(009) - Número do lote de baixa do título
baixaTitulos.lotBfi	Integer	LotBfi - Number(005) - Código da Filial para controle do lote de baixa do título
baixaTitulos.numLot	Integer	NumLot - Number(009) - Número do lote contábil
baixaTitulos.usuGer	Double	UsuGer - Number(010,0) - Usuário responsável pela geração do registro
baixaTitulos.datGer	DateTime	DatGer - Date(DD/MM/YYYY) - Data da geração do registro
baixaTitulos.horGer	String	HorGer - Time(HH:MM) - Hora da geração do registro
baixaTitulos.indExp	Integer	IndExp - Number(001) - Indicativo de Exportação Lista: 0 = Para Exportar, 1 = Em Exportação, 2 = Exportado, 3 = Aprovado, 4 = Em Digitação, 5 = Aguardando Liberação para Envio, 9 = Erro
baixaTitulos.filFix	Integer	FilFix - Number(005) - Código da filial
baixaTitulos.numFix	Integer	NumFix - Number(009) - Número da Fixação
baixaTitulos.recMoa	Integer	RecMoa - ( Lista: 0 = Não, 1 = Sim) - Byte - Indicativo se considera o valor de outros acréscimos da Fórmula de Reajuste para cálculo de multa do contas a receber
baixaTitulos.intImp	Integer	IntImp - ( Lista: 0 = Não, 1 = Sim) - Byte - Indicativo se o movimento foi integrado com gestão de tributos
baixaTitulos.intDif	Integer	IntDif - ( Lista: 0 = Não, 1 = Sim) - Byte - Indicativo movimento integrado com gestão de tributos para controle do dif.
baixaTitulos.vlrIrf	Double	VlrIrf - Number(015,2) - Valor de Imposto Retido do título a receber
baixaTitulos.vlrBir	Double	VlrBir - Number(015,2) - Soma dos valores base de Imposto Retido
baixaTitulos.vlrOir	Double	VlrOir - Number(015,2) - Soma dos valores base original de Imposto Retido
baixaTitulos.chvLot	String	ChvLot - String(024) - Chave do lote de baixa
baixaTitulos.vlrInt	Double	VlrInt - Number(015,2) - Valor de intermediação de serviços da baixa do título
baixaTitulos.seqLba	Integer	SeqLba - Number(008) - Sequência do Lote de Baixa
baixaTitulos.filOri	Integer	FilOri - Number(005) - Código da filial de origem do título.
baixaTitulos.reaAnb	DateTime	ReaAnb - Date(DD/MM/YYYY) - Data da alocação no projeto antes da baixa
baixaTitulos.numPdv	Integer	NumPdv - Number(003) - Número do que efetuou a baixa
erros	Set	Erros encontrados
erros.msgErr	String	(Obrigatório) - MsgErr - String - Mensagem de erros encontrados no processamento
tipoRetorno	Integer	(Obrigatório) - Number(001) - Tipo de Retorno de Processamento - Lista: 1 = Processado, 2 = Erro na Solicitação
mensagemRetorno	String	(Obrigatório) - String(1000) - Mensagem de Retorno de Processamento
ClosedExportarBaixaTitulosReceberIntegração
ClosedProcessarAVM
ClosedProcessarVariacaoCambial
ClosedProcessarTitulosAVP
ClosedAlteracaoParcialTitulosCR
Este artigo ajudou você?


Sim 
Não

Base de Conhecimento

Portal de Exigências Legais

Documentação em outros idiomas:

 English

 Español

 
seniorX Store

Universidade Corporativa

Fórum de Produtos

Trabalhe conosco

Blog

 




Todos os direitos de cópias reservadas para Senior Sistemas S.A.

A reprodução não autorizada desta publicação, no todo ou em parte, constitui violação dos direitos autorais (Lei 9.610/98).

Retornar ao topo
Ver site completo