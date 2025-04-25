BaixarTitulosCR_3
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
    <ser:BaixarTitulosCR_3>
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