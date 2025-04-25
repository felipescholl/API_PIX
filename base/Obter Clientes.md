ObterCliente
Cadastros - Clientes e Fornecedores - Clientes - Obter Cliente.

Necessita autenticação: sim.

Situação de versão: atual.

Versão: 1.

OpenRequisição:
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.senior.com.br">
  <soapenv:Body>
    <ser:obterCliente>
      <user>String</user>
      <password>String</password>
      <encryption>Integer</encryption>
      <parameters>
        <codigoEmpresa>Integer</codigoEmpresa>
        <codigoFilial>Integer</codigoFilial>
        <codigoCliente>Integer</codigoCliente>
      </parameters>
    </ser:obterCliente>
  </soapenv:Body>
</soapenv:Envelope>
OpenAtributos da resposta:
Nome	Tipo	Descrição
codigoEmpresa	Integer	(Obrigatório) - Number(004) - Código da Empresa
codigoFilial	Integer	(Obrigatório) - Number(005) - Código da Filial
codigoCliente	Integer	(Obrigatório) - Number(009) - Código do Cliente
OpenResposta:
Observação

Envelope SOAP de resposta de requisições síncronas. Para requisições assíncronas ou agendamentos, a resposta é apenas uma String chamada "result" com o valor "OK", se foi executado com sucesso ou, caso contrário, a mensagem do erro ocorrido.

<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.senior.com.br">
  <soapenv:Body>
    <ser:obterClienteResponse>
      <result>
        <saldoDuplicatas>Double</saldoDuplicatas>
        <saldoOutros>Double</saldoOutros>
        <saldoCreditos>Double</saldoCreditos>
        <tipoRetorno>Integer</tipoRetorno>
        <mensagemRetorno>String</mensagemRetorno>
        <valorLimiteCredito>Double</valorLimiteCredito>
        <motivoSituacoCliente>String</motivoSituacoCliente>
        <bloqueiaCredito>String</bloqueiaCredito>
        <observacaoMotivo>String</observacaoMotivo>
        <erroExecucao>String</erroExecucao>
      </result>
    </ser:obterClienteResponse>
  </soapenv:Body>
</soapenv:Envelope>
OpenAtributos da resposta:
Nome	Tipo	Descrição
erroExecucao	String	Indica erros ocorridos no servidor ao executar o serviço, podendo conter os seguintes valores:Vazio ou nulo, indicando que a execução foi feita com sucessoA mensagem do erro ocorrido no servidorSó impede a gravação quando o retorno.tipRet for igual a "2"
saldoDuplicatas	Double	(Obrigatório) - Number(15,2) - Saldo devedor de duplicatas do cliente
saldoOutros	Double	(Obrigatório) - Number(15,2) - Saldo devedor de outros títulos do cliente
saldoCreditos	Double	(Obrigatório) - Number(15,2) - Saldo de créditos do cliente
tipoRetorno	Integer	(Obrigatório) - Number(001) - Tipo de Retorno de Processamento - Lista: 1 = Processado, 2 = Erro na Solicitação
mensagemRetorno	String	(Obrigatório) - String(1000) - Mensagem de Retorno de Processamento
valorLimiteCredito	Double	(Obrigatório) - Number(15,2) - Valor do limite de crédito do cliente
motivoSituacoCliente	String	(Opcional) - String(030) - Descrição do motivo da observação ou situação
bloqueiaCredito	String	(Opcional) - String(001) - Indicativo se o motivo bloqueia crédito para o cliente (Faturamento)
S - Sim
N - Não
observacaoMotivo	String	(Opcional) - String(250) - Observação do motivo da situação do cliente
