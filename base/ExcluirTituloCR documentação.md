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