OpenGravarTitulosCR
Finanças - Gestão de Contas a Receber - Contas à Receber - Gravar Títulos

Necessita autenticação: sim.

Situação de versão: atual.

Versão: 2.

Requisição:

<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.senior.com.br">
  <soapenv:Body>
    <ser:GravarTitulosCR_3>
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
    </ser:GravarTitulosCR_3>
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