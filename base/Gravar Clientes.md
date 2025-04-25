GravarClientes
Cadastros - Clientes e Fornecedores - Clientes - Gravar Clientes.

Importante

Os campos definicoesCliente.codCpg, definicoesCliente.codFpg e definicoesCliente.codCrp são obrigatórios para usar a rotina no Gestão Empresarial PME | GO UP.

Quando houver mais de um cadastro com o mesmo CNPJ/CPF onde apenas um dos registros está ativo, é necessário que o parâmetro dinâmico EMPRESA.WS.IGNORARINATIVOAOVALIDARDUPLICIDADE esteja configurado como "S - Sim".

O parâmetro global AltFisCad define se os campos referente a tributação do cadastro de cliente serão atualizados no cadastro do fornecedor caso o vínculo Cliente X Fornecedor estiver ativo. O valor padrão é "S - Sim" para atualizar os campos fiscais. Para mais informações, acesse a documentação do parâmetro global.

A gravação das definições do cliente apenas na filial enviada na requisição depende do parâmetro Replicar as definições do cliente para a filial matriz, definido na tela Parâmetros de Integração (F191CPT) no Grupo Cliente. Caso este parâmetro esteja definido como "S - Sim", a criação das definições também será feita para a filial matriz, além da filial que foi enviada na requisição.

O parâmetro global UtiViaCep pode ser habilitado para utilizar o web service ViaCep para buscar dados de CEPs não cadastrados na tela F008CEP.

Necessita autenticação: sim.

Situação de versão: atual.

Versão: 5.

Versão atual: 5.

OpenRequisição:
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.senior.com.br">
  <soapenv:Body>
    <ser:GravarClientes>
      <user>String</user>
      <password>String</password>
      <encryption>Integer</encryption>
      <parameters>
        <dadosGeraisCliente>
          <codCli>Integer</codCli>
          <nomCli>String</nomCli>
          <apeCli>String</apeCli>
          <tipCli>String</tipCli>
          <tipEmp>Integer</tipEmp>
          <tipMer>String</tipMer>
          <cliCon>String</cliCon>
          <insEst>String</insEst>
          <insMun>String</insMun>
          <cgcCpf>String</cgcCpf>
          <zonFra>Integer</zonFra>
          <codSuf>String</codSuf>
          <endCli>String</endCli>
          <nenCli>String</nenCli>
          <cplEnd>String</cplEnd>
          <cliPrx>String</cliPrx>
          <zipCod>String</zipCod>
          <cepCli>String</cepCli>
          <cepIni>String</cepIni>
          <baiCli>String</baiCli>
          <cidCli>String</cidCli>
          <sigUfs>String</sigUfs>
          <codPai>String</codPai>
          <fonCli>String</fonCli>
          <fonCl2>String</fonCl2>
          <fonCl3>String</fonCl3>
          <fonCl4>String</fonCl4>
          <fonCl5>String</fonCl5>
          <faxCli>String</faxCli>
          <cxaPst>Integer</cxaPst>
          <intNet>String</intNet>
          <sitCli>String</sitCli>
          <obsMot>String</obsMot>
          <triIcm>String</triIcm>
          <triIpi>String</triIpi>
          <ideCli>String</ideCli>
          <triPis>String</triPis>
          <triCof>String</triCof>
          <retCof>String</retCof>
          <retCsl>String</retCsl>
          <retPis>String</retPis>
          <retOur>String</retOur>
          <retPro>String</retPro>
          <retIrf>String</retIrf>
          <calFun>String</calFun>
          <calSen>String</calSen>
          <emaNfe>String</emaNfe>
          <definicoesCliente>
            <codEmp>Integer</codEmp>
            <codFil>Integer</codFil>
            <datLim>String</datLim>
            <vlrLim>Double</vlrLim>
            <limApr>String</limApr>
            <perDs1>Double</perDs1>
            <perDs2>Double</perDs2>
            <perDs3>Double</perDs3>
            <perDs4>Double</perDs4>
            <perDs5>Double</perDs5>
            <codRep>Integer</codRep>
            <codTpr>String</codTpr>
            <codCpg>String</codCpg>
            <codFpg>Integer</codFpg>
            <codTra>Integer</codTra>
            <codRed>Integer</codRed>
            <recJmm>Double</recJmm>
            <recDtj>Integer</recDtj>
            <recMul>Double</recMul>
            <recDtm>Integer</recDtm>
            <perDsc>Double</perDsc>
            <tolDsc>Integer</tolDsc>
            <perFre>Double</perFre>
            <perSeg>Double</perSeg>
            <perEmb>Double</perEmb>
            <perEnc>Double</perEnc>
            <perOut>Double</perOut>
            <perIss>Double</perIss>
            <cifFob>String</cifFob>
            <codTab>String</codTab>
            <diaMe1>Integer</diaMe1>
            <diaEsp>String</diaEsp>
            <diaMe2>Integer</diaMe2>
            <diaMe3>Integer</diaMe3>
            <cnpjFilial>String</cnpjFilial>
            <qtdDcv>Integer</qtdDcv>
            <ctaRed>Integer</ctaRed>
            <ctaAux>Integer</ctaAux>
            <ctaAad>Integer</ctaAad>
            <catCli>Integer</catCli>
            <acePar>String</acePar>
            <perAqa>Integer</perAqa>
            <codCrp>String</codCrp>
            <codVen>Integer</codVen>
            <perCom>Integer</perCom>
            <codRve>String</codRve>
            <recTjr>String</recTjr>
            <prdDsc>String</prdDsc>
            <antDsc>String</antDsc>
            <porSi1>String</porSi1>
            <porSi2>String</porSi2>
            <codCrt>String</codCrt>
            <porNa1>String</porNa1>
            <porNa2>String</porNa2>
            <codIn1>String</codIn1>
            <codIn2>String</codIn2>
            <codBan>String</codBan>
            <codAge>String</codAge>
            <ccbCli>String</ccbCli>
            <perOf1>Integer</perOf1>
            <perOf2>Integer</perOf2>
            <datPmr>DateTime</datPmr>
            <criEdv>String</criEdv>
            <codFrj>String</codFrj>
            <ctaRcr>Integer</ctaRcr>
            <ctaFdv>Integer</ctaFdv>
            <ctaFcr>Integer</ctaFcr>
            <exiLcp>String</exiLcp>
            <fveTns>String</fveTns>
            <fveFpg>String</fveFpg>
            <fveCpg>String</fveCpg>
            <codMar>String</codMar>
            <gerTcc>String</gerTcc>
            <ctrPad>Integer</ctrPad>
            <ecpCnp>String</ecpCnp>
            <exiAge>String</exiAge>
            <codFcr>String</codFcr>
            <seqCob>Integer</seqCob>
            <seqEnt>Integer</seqEnt>
            <indOrf>String</indOrf>
            <codTic>String</codTic>
            <codTrd>String</codTrd>
            <perCcr>String</perCcr>
            <dscPrd>String</dscPrd>
            <avaVlr>Double</avaVlr>
            <avaVlu>Double</avaVlu>
            <avaVls>Double</avaVls>
            <avaAti>String</avaAti>
            <avaMot>Integer</avaMot>
            <avaObs>String</avaObs>
            <qtdChs>Integer</qtdChs>
            <qtdPrt>Integer</qtdPrt>
            <vlrPrt>Double</vlrPrt>
            <acrDia>Integer</acrDia>
            <vlrAcr>Double</vlrAcr>
            <conFin>String</conFin>
            <indPre>String</indPre>
            <camposUsuario>
              <campo>String</campo>
              <valor>String</valor>
            </camposUsuario>
          </definicoesCliente>
          <enderecosEntrega>
            <seqEnv>String</seqEnv>
            <seqEnt>Integer</seqEnt>
            <nomCli>String</nomCli>
            <endEnt>String</endEnt>
            <cplEnt>String</cplEnt>
            <prxEnt>String</prxEnt>
            <cepEnt>String</cepEnt>
            <iniEnt>String</iniEnt>
            <zipEnt>String</zipEnt>
            <cidEnt>String</cidEnt>
            <estEnt>String</estEnt>
            <insEnt>String</insEnt>
            <baiEnt>String</baiEnt>
            <cgcEnt>String</cgcEnt>
            <sitReg>String</sitReg>
            <nenEnt>String</nenEnt>
            <tipEnt>String</tipEnt>
            <codRoe>String</codRoe>
            <seqRoe>Integer</seqRoe>
            <codSro>String</codSro>
            <acrDia>Double</acrDia>
            <vlrAcr>Double</vlrAcr>
            <empFre>Integer</empFre>
            <tabFre>String</tabFre>
            <datIni>DateTime</datIni>
            <locEnt>Integer</locEnt>
            <seqFlc>Integer</seqFlc>
            <filFlc>Integer</filFlc>
            <faxEnt>String</faxEnt>
            <fonEnt>String</fonEnt>
            <celEnt>String</celEnt>
            <emaEnt>String</emaEnt>
            <indOba>Integer</indOba>
            <nroCno>String</nroCno>
            <paiEnt>String</paiEnt>
            <vlrLat>String</vlrLat>
            <vlrLon>String</vlrLon>
            <camposUsuario>
              <campo>String</campo>
              <valor>String</valor>
            </camposUsuario>
          </enderecosEntrega>
          <clientePessoaFisica>
            <estCiv>Integer</estCiv>
            <codSex>String</codSex>
            <datNas>String</datNas>
            <cidNat>String</cidNat>
            <numRge>String</numRge>
            <orgRge>String</orgRge>
            <datRge>String</datRge>
            <nomPai>String</nomPai>
            <nomMae>String</nomMae>
            <refCm1>String</refCm1>
          </clientePessoaFisica>
          <ideExt>String</ideExt>
          <cadastroCEP>
            <cepIni>String</cepIni>
            <cepFim>String</cepFim>
            <codRai>Integer</codRai>
            <nomCid>String</nomCid>
            <baiCid>String</baiCid>
            <endCid>String</endCid>
            <cepPol>String</cepPol>
          </cadastroCEP>
          <codFor>Integer</codFor>
          <codGre>String</codGre>
          <datSuf>String</datSuf>
          <eenCli>String</eenCli>
          <eenEnt>String</eenEnt>
          <endEnt>String</endEnt>
          <nenEnt>String</nenEnt>
          <cplEnt>String</cplEnt>
          <cepEnt>Integer</cepEnt>
          <baiEnt>String</baiEnt>
          <zipEnt>String</zipEnt>
          <cidEnt>String</cidEnt>
          <estEnt>String</estEnt>
          <insEnt>String</insEnt>
          <cgcEnt>Double</cgcEnt>
          <eenCob>String</eenCob>
          <nenCob>String</nenCob>
          <endCob>String</endCob>
          <cplCob>String</cplCob>
          <cepCob>Integer</cepCob>
          <baiCob>String</baiCob>
          <cidCob>String</cidCob>
          <estCob>String</estCob>
          <cgcCob>Double</cgcCob>
          <cepFre>Integer</cepFre>
          <entCor>String</entCor>
          <cliFor>String</cliFor>
          <cliRep>Integer</cliRep>
          <cliTra>Integer</cliTra>
          <marCli>String</marCli>
          <codMot>Integer</codMot>
          <codCnv>Integer</codCnv>
          <perAin>Integer</perAin>
          <tipAce>Integer</tipAce>
          <insAnp>Integer</insAnp>
          <indCoo>String</indCoo>
          <codRtr>Integer</codRtr>
          <regEst>Integer</regEst>
          <natRet>Integer</natRet>
          <natPis>Integer</natPis>
          <natCof>Integer</natCof>
          <entPaa>String</entPaa>
          <codRam>String</codRam>
          <codRoe>String</codRoe>
          <seqRoe>Integer</seqRoe>
          <codSro>String</codSro>
          <limRet>String</limRet>
          <indNif>Integer</indNif>
          <numIdf>String</numIdf>
          <tipEmc>Integer</tipEmc>
          <vlrLat>String</vlrLat>
          <vlrLon>String</vlrLon>
          <camposUsuario>
            <campo>String</campo>
            <valor>String</valor>
          </camposUsuario>
          <codMsg>Integer</codMsg>
          <codMs2>Integer</codMs2>
          <codMs3>Integer</codMs3>
          <codMs4>Integer</codMs4>
          <codHas>String</codHas>
          <catEst>String</catEst>
        </dadosGeraisCliente>
        <dataBuild>String</dataBuild>
        <sigInt>String</sigInt>
        <idtReq>String</idtReq>
      </parameters>
    </ser:GravarClientes>
  </soapenv:Body>
</soapenv:Envelope>
OpenParâmetros da requisição:
Nome	Preenchimento	Tipo	Descrição
dadosGeraisCliente	Opcional	Set	 
dadosGeraisCliente.codCli	Obrigatório	Integer	(Obrigatório) - Number(009) - Código do cliente. Se esse parâmetro não for passado na requisição, o sistema vai buscar a próxima numeração disponível para gerar o cadastro e retornará o código do cliente gerado como saída do processamento do web service
dadosGeraisCliente.nomCli	Obrigatório	String	(Obrigatório) - String(100) - Nome do cliente
dadosGeraisCliente.apeCli	Obrigatório	String	(Obrigatório) - String(050) - Nome fantasia do cliente
dadosGeraisCliente.tipCli	Obrigatório	String	(Obrigatório) - String(001) - Tipo do cliente - Lista : J= Jurídica, F = Física
dadosGeraisCliente.tipEmp	Opcional	Integer	Tipo de empresa
dadosGeraisCliente.tipMer	Obrigatório	String	(Obrigatório) - String(001) - Tipo de mercado do cliente - Lista: I = Interno (Nacional), E = Externo (Internacional), P = Prospect.)
dadosGeraisCliente.cliCon	Obrigatório	String	(Obrigatório) - String(001) - Indicativo se o cliente é contribuinte de ICMS - Lista S = Sim, N = Não
dadosGeraisCliente.insEst	Opcional	String	(Opcional) - String(025) - Inscrição estadual do cliente
dadosGeraisCliente.insMun	Opcional	String	(Opcional) - String(016) - Inscrição municipal do cliente
dadosGeraisCliente.cgcCpf	Opcional	String	(Opcional) - Number(014) - Número do CNPJ ou CPF do cliente
dadosGeraisCliente.zonFra	Opcional	Integer	(Opcional) - Number(001) - Indicativo de qual é o benefício fiscal do cliente - Lista: 1 = Zona Franca de Manaus, 2 = Zona Franca, 3 = Área de livre comércio, 4 = Amazônia Ocidental
dadosGeraisCliente.codSuf	Opcional	String	(Opcional) - String(010) - Número do cliente junto a Suframa
dadosGeraisCliente.endCli	Opcional	String	(Opcional) - String(100) - Endereço do cliente.
dadosGeraisCliente.nenCli	Opcional	String	(Opcional) - String(060) - Número do Endereço do Cliente
dadosGeraisCliente.cplEnd	Opcional	String	(Opcional) - String(020) - Complemento do endereço do cliente (sala, andar, etc.)
dadosGeraisCliente.cliPrx	Opcional	String	(Opcional) - String(120) - Ponto de referência ou proximidade do cliente
dadosGeraisCliente.zipCod	Opcional	String	(Opcional) - String(014) - Código da cidade do cliente externo - ZIP CODE
dadosGeraisCliente.cepCli	Opcional	String	(Opcional) - Number(008) - CEP do cliente
dadosGeraisCliente.cepIni	Opcional	String	(Opcional) - Number(008) - Faixa inicial do CEP da cidade do cliente
dadosGeraisCliente.baiCli	Opcional	String	(Opcional) - String(075) - Bairro do cliente
dadosGeraisCliente.cidCli	Opcional	String	(Opcional) - String(060) - Cidade do cliente
dadosGeraisCliente.sigUfs	Opcional	String	(Opcional) - String(002) - Sigla do estado do cliente
dadosGeraisCliente.codPai	Opcional	String	(Opcional) - String(004) - Código do país do cliente
dadosGeraisCliente.fonCli	Opcional	String	(Opcional) - String(020) - Número do telefone - 1
dadosGeraisCliente.fonCl2	Opcional	String	(Opcional) - String(020) - Número do telefone - 2
dadosGeraisCliente.fonCl3	Opcional	String	(Opcional) - String(020) - Número do telefone - 3
dadosGeraisCliente.fonCl4	Opcional	String	(Opcional) - String(020) - Número do telefone - 4
dadosGeraisCliente.fonCl5	Opcional	String	(Opcional) - String(020) - Número do telefone - 5
dadosGeraisCliente.faxCli	Opcional	String	(Opcional) - String(020) - Número do FAX do cliente
dadosGeraisCliente.cxaPst	Opcional	Integer	(Opcional) - Number(006) - Número da caixa postal do cliente
dadosGeraisCliente.intNet	Opcional	String	(Opcional) - String(100) - Endereço eletrônico (E-Mail)
dadosGeraisCliente.sitCli	Obrigatório	String	(Obrigatório) - String(001) - Situação do cliente - Lista: A = Ativo, I = Inativo
dadosGeraisCliente.obsMot	Opcional	String	(Opcional) - String(250) - Observação do motivo da situação do cliente
dadosGeraisCliente.triIcm	Opcional	String	(Opcional) - String(001) - Indicativo se o cliente tem tributação de ICMS ou não - Lista: S = Sim, N = Não
dadosGeraisCliente.triIpi	Opcional	String	(Opcional) - String(001) - Indicativo se o cliente tem tributação de IPI ou não - Lista: S = Sim, N = Não
dadosGeraisCliente.ideCli	Opcional	String	(Opcional) - String(020) - Código para identificação do cliente
dadosGeraisCliente.triPis	Opcional	String	(Opcional) - String(001) - Indicativo se o cliente tem tributação de PIS ou não - Lista: S = Sim, N = Não
dadosGeraisCliente.triCof	Opcional	String	(Opcional) - String(001) - Indicativo se o cliente tem tributação de COFINS ou não - Lista: S = Sim, N = Não
dadosGeraisCliente.retCof	Opcional	String	(Opcional) - String(001) - Indicativo se as notas fiscais poderão ter retenção de Cofins - Lista: S = Sim, N = Não
dadosGeraisCliente.retCsl	Opcional	String	(Opcional) - String(001) - Indicativo se as notas fiscais poderão ter retenção de CSLL - Lista: S = Sim, N = Não
dadosGeraisCliente.retPis	Opcional	String	(Opcional) - String(001) - Indicativo se as notas fiscais poderão ter retenção de PIS - Lista: S = Sim, N = Não
dadosGeraisCliente.retOur	Opcional	String	(Opcional) - String(001) - Indicativo se as notas fiscais poderão ter Outras Retenções - Lista: S = Sim, N = Não
dadosGeraisCliente.retPro	Opcional	String	(Opcional) - String(001) - Indicativo se o cliente controla retenções de PIS, Cofins, CSLL, IRRF, e Outras Retenções por produto - Lista: S = Sim, N = Não
dadosGeraisCliente.retIrf	Opcional	String	(Opcional) - String(001) - Indicativo se as notas fiscais poderão ter retenção de IRRF - Lista: S = Sim, N = Não
dadosGeraisCliente.calFun	Opcional	String	(Opcional) - String(001) - Indicativo se calcula Funrural nas notas fiscais de saídas. - Lista: S = Sim, N = Não
dadosGeraisCliente.calSen	Opcional	String	(Opcional) - String(001) - <Indicativo se calcula Senar nas notas fiscais de saídas. - Lista: S = Sim, N = Não
dadosGeraisCliente.emaNfe	Opcional	String	(Opcional) - String(100) - Endereço eletrônico (E-mail) para envio de arquivos de notas fiscais eletrônicas
dadosGeraisCliente.indNif	Opcional	Number	(Opcional) - Number(001) - Indicativo do número de identificação fiscal
definicoesCliente	Opcional	Set	 
definicoesCliente.codEmp	Obrigatório	Integer	(Obrigatório) - Number(004) - Código da empresa
definicoesCliente.codFil	Obrigatório	Integer	(Obrigatório) - Number(005) - Código da filial
definicoesCliente.datLim	Opcional	String	(Opcional) - Date - Data da última atualização do limite de crédito do cliente
definicoesCliente.vlrLim	Opcional	Double	(Opcional) - Number(015,2) - Valor do limite de crédito do cliente
definicoesCliente.limApr	Opcional	String	(Opcional) - String(001) - Indicativo se o limite de crédito do cliente esta ou não aprovado - Lista: S = Sim, N = Não
definicoesCliente.perDs1	Opcional	Double	(Opcional) - Number(005,2) - Percentual de desconto - 1 para o cliente
definicoesCliente.perDs2	Opcional	Double	(Opcional) - Number(005,2) - Percentual de desconto - 2 para o cliente
definicoesCliente.perDs3	Opcional	Double	(Opcional) - Number(005,2) - Percentual de desconto - 3 para o cliente
definicoesCliente.perDs4	Opcional	Double	(Opcional) - Number(005,2) - Percentual de desconto - 4 para o cliente
definicoesCliente.perDs5	Opcional	Double	(Opcional) - Number(005,2) - Percentual de desconto - 5 para o cliente
definicoesCliente.codRep	Opcional	Integer	(Opcional) - Number(004) - Código do representante padrão para o cliente. Serão permitidos somente representantes com a situação ativa
definicoesCliente.codTpr	Opcional	String	(Opcional) - String(004) - Código da tabela de preço padrão para o cliente
definicoesCliente.codCpg	Opcional	String	(Opcional) - String(006) - Código da condição de pagamento padrão para o cliente. Esse campo é obrigatório para o GO UP
definicoesCliente.codFpg	Opcional	Integer	(Opcional) - Number(002) - Código da forma de pagamento. Esse campo é obrigatório para o GO UP (PGGOUP: FIN-FORMAPAGAMENTO)
definicoesCliente.codTra	Opcional	Integer	(Opcional) - Number(006) - Código da transportadora padrão para o cliente
definicoesCliente.codRed	Opcional	Integer	(Opcional) - Number(009) - Código da transportadora de redespacho padrão para o cliente
definicoesCliente.recJmm	Opcional	Double	(Opcional) - Number(005,2) - Percentual de juros de mora mês para o contas a receber
definicoesCliente.recDtj	Opcional	Integer	(Opcional) - Number(004) - Dias de tolerância para calculo de juros de mora
definicoesCliente.recMul	Opcional	Double	(Opcional) - Number(005,2) - Percentual de multa para atraso contas a receber
definicoesCliente.recDtm	Opcional	Integer	(Opcional) - Number(004) - Dias de tolerância para multa do contas a receber
definicoesCliente.perDsc	Opcional	Double	(Opcional) - Number(004,2) - Percentual padrão de desconto para os títulos gerados
definicoesCliente.tolDsc	Opcional	Integer	(Opcional) - Number(004) - Quantidade padrão de dias de tolerância para desconto
definicoesCliente.perFre	Opcional	Double	(Opcional) - Number(005,2) - Percentual de Frete
definicoesCliente.perSeg	Opcional	Double	(Opcional) - Number(005,2) - Percentual de Seguro
definicoesCliente.perEmb	Opcional	Double	(Opcional) - Number(005,2) - Percentual de Embalagens
definicoesCliente.perEnc	Opcional	Double	(Opcional) - Number(005,2) - Percentual de Encargos
definicoesCliente.perOut	Opcional	Double	(Opcional) - Number(005,2) - Percentual de Outras Despesas
definicoesCliente.perIss	Opcional	Double	(Opcional) - Number(004,2) - Percentual do ISS para os serviços prestados ao cliente
definicoesCliente.cifFob	Opcional	String	(Opcional) - String(001) - Indicativo se o frete para o cliente e CIF ou FOB. Lista: C= Por conta do cliente, F = Por conta do destinatário, T = Por conta de terceiros, X = Sem frete
definicoesCliente.codTab	Opcional	String	(Opcional) - String(004) - Código da tabela de preço frete
definicoesCliente.diaMe1	Opcional	Integer	(Opcional) - Number(002) - Primeiro dia especial do mês para vencimento das parcelas do cliente
definicoesCliente.diaEsp	Opcional	String	(Opcional) - String(001) - Indicativo do dia da semana para vencimento parcelas para o cliente. Lista: 1 = Normal - Qualquer dia, 2 = Segunda-Feira, 3 = terça-Feira, 4 = Quarta-Feira, 5 = Quinta-Feira, 6 = Sexta-Feira, 7 = Fora semana antes, 8 = Fora decêndio antes, 9 = Fora quinzena antes, A = Fora mês antes, S = Fora semana depois, D = Fora decêndio depois, Q = Fora quinzena depois, M = Fora mês depois
definicoesCliente.diaMe2	Opcional	Integer	(Opcional) - Number(002) - Segundo dia especial do mês para vencimento das parcelas do cliente
definicoesCliente.diaMe3	Opcional	Integer	(Opcional) - Number(002) - Terceiro dia especial do mês para vencimento das parcelas do cliente
definicoesCliente.cnpjFilial	Opcional	String	(Opcional) - CNPJ da Filial - Condição: Obrigatório quando não informado os campos CodEmp e CodFil
definicoesCliente.qtdDcv	Opcional	Integer	(Opcional) - Number(003) - Quantidade de dias para cálculo de vencimento - Condição: Obrigatório quando o campo "Critério Vencimento" estiver definido como "U" (Só dias úteis) na tela Cadastros > Filiais > Parâmetros por Gestão > Contas a Receber (F070FRE).
definicoesCliente.ctaRed	Opcional	Integer	(Opcional) - Number(007) - Conta contábil reduzida
definicoesCliente.ctaAux	Opcional	Integer	(Opcional) - Number(007) - Número reduzido da conta de composição auxiliar - 1
definicoesCliente.ctaAad	Opcional	Integer	(Opcional) - Number(007) - Número reduzido da conta de composição auxiliar - 2
definicoesCliente.catCli	Opcional	Integer	(Opcional) - Number(003) - Categoria do cliente (prioridade para faturamento)
definicoesCliente.acePar	Opcional	String	AcePar - (Opcional) - String(001) - Indicativo se o cliente aceita faturamento parcial de pedidos - Lista: N = Não, S = Sim
definicoesCliente.perAqa	Opcional	Integer	(Opcional) - Number(005,2) - Percentual acima da quantidade do pedido aceito no faturamento pelo cliente
definicoesCliente.codCrp	Opcional	String	(Opcional) - String(003) - Código de grupo do contas a receber. Esse campo é obrigatório para o GO UP (PGGOUP: FIN-GRUPOCPCR)
definicoesCliente.codVen	Opcional	Integer	(Opcional) - Number(009) - Código do Vendedor do Cliente. Somente permitido vendedores com a situação ativa.
definicoesCliente.perCom	Opcional	Integer	(Opcional) - Number(005,2) - Percentual de comissão nas vendas para o cliente (+ ou -)
definicoesCliente.codRve	Opcional	String	(Opcional) - String(003) - Código da região de venda do cliente
definicoesCliente.recTjr	Opcional	String	RecTjr - (Opcional) - String(001) - Tipo de juros para contas a receber - Lista: S = Juros Simples, C = Juros Compostos
definicoesCliente.prdDsc	Opcional	String	PrdDsc - (Opcional) - String(001) - Indicativo do período para cálculo do desconto antecipado - Lista: D = Diário, M = Mensal
definicoesCliente.antDsc	Opcional	String	AntDsc - (Opcional) - String(001) - Indicativo se calcula desconto por antecipação de recebimento - Lista: N = Não, S = Sim
definicoesCliente.porSi1	Opcional	String	(Opcional) - String(004) - Código do primeiro portador aceito pelo cliente
definicoesCliente.porSi2	Opcional	String	(Opcional) - String(004) - Código do segundo portador aceito pelo cliente
definicoesCliente.codCrt	Opcional	String	(Opcional) - String(002) - Código da carteira padrão para o cliente
definicoesCliente.porNa1	Opcional	String	(Opcional) - String(004) - Código do primeiro portador não aceito pelo cliente
definicoesCliente.porNa2	Opcional	String	(Opcional) - String(004) - Código do segundo portador não aceito pelo cliente
definicoesCliente.codIn1	Opcional	String	(Opcional) - String(003) - Código da primeira instrução bancária
definicoesCliente.codIn2	Opcional	String	(Opcional) - String(003) - Código da segunda instrução bancária
definicoesCliente.codBan	Opcional	String	(Opcional) - String(003) - Código do banco onde o cliente mantém conta corrente
definicoesCliente.codAge	Opcional	String	(Opcional) - String(007) - Código da agência bancária onde o cliente mantém conta corrente
definicoesCliente.ccbCli	Opcional	String	(Opcional) - String(014) - Número da conta corrente bancária do cliente
definicoesCliente.perOf1	Opcional	Integer	(Opcional) - Number(005,2) - Percentual de oferta 1 para o cliente
definicoesCliente.perOf2	Opcional	Integer	(Opcional) - Number(005,2) - Percentual de oferta 2 para o cliente
definicoesCliente.datPmr	Opcional	DateTime	(Opcional) - Date - Data de início de contagem para cálculo do prazo médio de recebimento dos títulos
definicoesCliente.criEdv	Opcional	String	CriEdv - (Opcional) - String(001) - Critério para escolha do dia de vencimento das parcelas e títulos - Lista: A = Dias Corridos - Antecipa, S = Dias Corridos - Mantém, N = Dias Corridos - Posterga, U = Só Dias Úteis
definicoesCliente.codFrj	Opcional	String	(Opcional) - String(003) - Código da fórmula de reajuste do título a receber
definicoesCliente.ctaRcr	Opcional	Integer	(Opcional) - Number(007) - Conta contábil reduzida - 2
definicoesCliente.ctaFdv	Opcional	Integer	(Opcional) - Number(007) - Conta contábil reduzida - 3
definicoesCliente.ctaFcr	Opcional	Integer	(Opcional) - Number(007) - Conta contábil reduzida - 4
definicoesCliente.exiLcp	Obrigatório	String	ExiLcp - (Obrigatório) - String(001) - Indicativo se o cliente exige ligação de cliente X produto/derivação - Lista: N = Não, S = Sim
definicoesCliente.fveTns	Opcional	String	(Opcional) - String(010) - Hierarquia da Forma de Venda. Só é assumido se na tela Cadastros > Filiais > Parâmetros por Gestão > Vendas e Faturamento, aba Vendas 2 o campo "Utiliza Forma de Venda" estiver definido como "S".
definicoesCliente.fveFpg	Opcional	String	(Opcional) - String(010) - Hierarquia da Forma de Venda. Só é assumido se na tela Cadastros > Filiais > Parâmetros por Gestão > Vendas e Faturamento, aba Vendas 2 o campo "Utiliza Forma de Venda" estiver definido como "S".
definicoesCliente.fveCpg	Opcional	String	(Opcional) - String(010) - Hierarquia da Forma de Venda. Só é assumido se na tela Cadastros > Filiais > Parâmetros por Gestão > Vendas e Faturamento, aba Vendas 2 o campo "Utiliza Forma de Venda" estiver definido como "S".
definicoesCliente.codMar	Opcional	String	(Opcional) - String(010) - Código da Marca/Etiqueta padrão do cliente
definicoesCliente.gerTcc	Opcional	String	GerTcc - (Opcional) - String(001) - Indicativo se, no momento do faturamento de um contrato, gera título para o cliente do contrato, e não do faturamento - Lista: N = Não, S = Sim
definicoesCliente.ctrPad	Opcional	Integer	(Opcional) - Number(009) - Número do contrato padrão
definicoesCliente.ecpCnp	Opcional	String	EcpCnp - (Opcional) - String(001) - Exige código do produto do cliente no pedido - Lista: N = Não, S = Sim
definicoesCliente.exiAge	Opcional	String	ExiAge - (Opcional) - String(001) - Indicativo se o cliente exige o agendamento da entrega - Lista: N = Não, S = Sim
definicoesCliente.codFcr	Opcional	String	(Opcional) - String(003) - Código da moeda ou índice como fator de correção dos contratos
definicoesCliente.seqCob	Opcional	Integer	(Opcional) - Number(005) - Sequência do endereço de cobrança padrão do cliente
definicoesCliente.seqEnt	Opcional	Integer	(Obrigatório) - Number(005) - Sequência do endereço de entrega padrão do cliente
definicoesCliente.indOrf	Opcional	String	IndOrf - (Opcional) - String(001) - Indica se o cliente obriga o recebimento do recibo para cobrança via fatura automática - Lista: N = Não, S = Sim
definicoesCliente.codTic	Opcional	String	(Opcional) - String(003) - Código do ICMS especial
definicoesCliente.codTrd	Opcional	String	(Opcional) - String(003) - Código de redução de impostos
definicoesCliente.perCcr	Opcional	String	PerCcr - (Opcional) - String(001) - Origem do percentual de comissão - Lista: R = Representante, C = Cliente
definicoesCliente.dscPrd	Opcional	String	DscPrd - (Opcional) - String(001) - Desconsidera percentual de perda do componente utilizado para industrialização - Lista: N = Não, S = Sim
definicoesCliente.avaVlr	Opcional	Double	(Opcional) - Number(015,2) - Valor total para avalizar
definicoesCliente.avaVlu	Opcional	Double	(Opcional) - Number(015,2) - Valor avalizado no atual momento
definicoesCliente.avaVls	Opcional	Double	(Opcional) - Number(015,2) - Valor disponível para avalizar
definicoesCliente.avaAti	Opcional	String	AvaAti - (Opcional) - String(001) - Determina se o cliente pode ser usado como avalista - Lista: N = Não, S = Sim
definicoesCliente.avaMot	Opcional	Integer	(Opcional) - Number(006) - Código do motivo usado para justificar porque o avalista está inativo
definicoesCliente.avaObs	Opcional	String	(Opcional) - String(250) - Observação do motivo da inativação do avalista
definicoesCliente.qtdChs	Opcional	Integer	(Opcional) - Number(004) - Quantidade de cheques sem fundo do cliente
definicoesCliente.qtdPrt	Opcional	Integer	(Opcional) - Number(004) - Quantidade de protestos do cliente
definicoesCliente.vlrPrt	Opcional	Double	(Opcional) - Number(015,2) - Valor total de protestos do cliente
definicoesCliente.acrDia	Opcional	Integer	(Opcional) - Number(005) - Percentual de acréscimo na diária paga ao motorista
definicoesCliente.vlrAcr	Opcional	Double	(Opcional) - Number(015,2) - Valor de acréscimo na diária paga ao motorista
definicoesCliente.conFin	Opcional	String	(Opcional) - String(001) - Consumidor Final - Lista : S= Possui consumidor final, N= Não possui consumidor final.
definicoesCliente.indPre	Opcional	String	String(001) - Indicativo presencial do consumidor - [ 0=Não se aplica;1=Operação presencial; 2=Operação não presencial, pela Internet; 3=Operação não presencial, Teleatendimento; 4=NFC-e em operação com entrega em domicílio; 9=Operação não presencial, outros]|
camposUsuario	Opcional	Set	Lista de campos de usuário
camposUsuario.campo	Opcional	String	Nome do campo de usuário
camposUsuario.valor	Opcional	String	Valor do campo de usuário
enderecosEntrega	Opcional	Set	 
enderecosEntrega.seqEnv	Obrigatório	String	(Obrigatório) - String(004) - Sequência de envio do endereço de entrega (sequência do sistema externo)
enderecosEntrega.seqEnt	Obrigatório	Integer	(Obrigatório) - Number(004) - Sequência de endereços de entrega
enderecosEntrega.nomCli	Opcional	String	(Opcional) - String(100) - Nome do cliente de entrega
enderecosEntrega.endEnt	Obrigatório	String	(Obrigatório) - String(100) - Endereço de entrega do cliente
enderecosEntrega.cplEnt	Opcional	String	(Opcional) - String(020) - Complemento do endereço de entrega do cliente
enderecosEntrega.prxEnt	Opcional	String	(Opcional) - String(120) - Ponto de referencia ou proximidade do endereço de entrega
enderecosEntrega.cepEnt	Opcional	String	(Opcional) - Number(008) - CEP do endereço de entrega do cliente
enderecosEntrega.iniEnt	Opcional	String	(Opcional) - Number(008) - Faixa inicial do CEP do endereço de entrega do cliente
enderecosEntrega.cidEnt	Opcional	String	(Opcional) - String(060) - Cidade do endereço de entrega do cliente
enderecosEntrega.estEnt	Opcional	String	(Opcional) - String(002) - estado do endereço de entrega do cliente
enderecosEntrega.insEnt	Opcional	String	(Opcional) - String(025) - Inscrição estadual do endereço de entrega
enderecosEntrega.baiEnt	Opcional	String	(Opcional) - String(075) - Bairro de entrega do cliente
enderecosEntrega.zipEnt	Opcional	String	(Opcional) - String(014) - Código da cidade do endereço de entrega do cliente externo - ZIP CODE
enderecosEntrega.cgcEnt	Opcional	String	(Opcional) - Number(014) - Numero do CNPJ/CPF de entrega
enderecosEntrega.sitReg	Opcional	String	(Opcional) - String(001) - Situação do registro. - Lista : A = Ativo, I = Inativo
enderecosEntrega.nenEnt	Opcional	String	(Opcional) - String(060) - Numero do Endereço de Entrega do Cliente
enderecosEntrega.tipEnt	Opcional	String	(Opcional) - Define o tipo de pessoa do endereço de entrega. Lista: J= Jurídica, F = Física
enderecosEntrega.codRoe	Opcional	String	(Opcional) - String(003) - Código da Rota de Entrega
enderecosEntrega.seqRoe	Opcional	Integer	(Opcional) - Number(003) - Sequência da Rota de Entrega
enderecosEntrega.codSro	Opcional	String	(Opcional) - String(003) - Código da Sub-Rota de Entrega
enderecosEntrega.acrDia	Opcional	Integer	(Opcional) - Number(005,2) - Percentual de acréscimo na diária paga ao motorista
enderecosEntrega.vlrAcr	Opcional	Integer	(Opcional) - Number(015,2) - Valor de acréscimo na diária paga ao motorista
enderecosEntrega.empFre	Opcional	Integer	(Opcional) - Number(003) - Código da empresa da tabela de preço de frete
enderecosEntrega.tabFre	Opcional	String	(Opcional) - String(004) - Código da tabela de preço de frete
enderecosEntrega.datIni	Opcional	DateTime	(Opcional) - Date - Data início de validade da tabela de preço de frete
enderecosEntrega.locEnt	Opcional	Integer	(Opcional) - Number(008) - Código da localização do local para entrega do frete
enderecosEntrega.seqFlc	Opcional	Integer	(Opcional) - Number(004) - Sequência da localização do frete
enderecosEntrega.filFlc	Opcional	Integer	(Opcional) - Number(004) - Código da filial da localização do frete
enderecosEntrega.faxEnt	Opcional	String	(Opcional) - String(020) - Número do fax de contato no endereço de entrega
enderecosEntrega.fonEnt	Opcional	String	(Opcional) - String(020) - Número do telefone de contato no endereço de entrega
enderecosEntrega.celEnt	Opcional	String	(Opcional) - String(020) - Número do celular de contato no endereço de entrega
enderecosEntrega.emaEnt	Opcional	String	(Opcional) - String(100) - E-Mail de contato no endereço de entrega
enderecosEntrega.indOba	Opcional	Integer	(Opcional) - Number(001) - Indicativo de Prestação de Serviços em Obra de Construção Civil
enderecosEntrega.nroCno	Opcional	String	(Opcional) - String(014) - Número de inscrição do cadastro nacional de obra (CNO)
enderecosEntrega.paiEnt	Opcional	Integer	(Opcional) - Number(004) - Código do país de entrega do cliente
enderecosEntrega.vlrLat	Opcional	String	(Opcional) - String(100) - Valor da Latitude do endereço de entrega do cliente
enderecosEntrega.vlrLon	Opcional	String	(Opcional) - String(100) - Valor da Longitude do endereço de entrega do cliente
clientePessoaFisica	Opcional	Set	 
clientePessoaFisica.estCiv	Opcional	Integer	(Opcional) - Number(001) - Estado civil do cliente - Lista: 1 = Solteiro, 2 = Casado, 3 = Desquitado, 4 = Divorciado, 5 = Viúvo, 6 = Concubinado, 7 = Separado Judicialmente, 9 = Outros
clientePessoaFisica.codSex	Opcional	String	(Opcional) - String(003) - Código do sexo
clientePessoaFisica.datNas	Opcional	String	(Opcional) - Date - Data do nascimento do cliente
clientePessoaFisica.cidNat	Opcional	String	(Opcional) - String(060) - Nome da cidade de naturalidade
clientePessoaFisica.numRge	Opcional	String	(Opcional) - String(013) - Número do RG (Identidade)
clientePessoaFisica.orgRge	Opcional	String	(Opcional) - String(005) - Órgão emissor do RG
clientePessoaFisica.datRge	Opcional	String	(Opcional) - Date - Data de emissão do RG
clientePessoaFisica.nomPai	Opcional	String	(Opcional) - String(030) - Nome do pai do cliente
clientePessoaFisica.nomMae	Opcional	String	(Opcional) - String(030) - Nome da mãe do cliente
clientePessoaFisica.refCm1	Opcional	String	(Opcional) - String(060) - Referência comercial - 1
dadosGeraisCliente.ideExt	Opcional	String	(Opcional) - String(030) - Identificação externa do cliente. Este código é útil quando este serviço é utilizado para incluir vários clientes numa única requisição. O código fornecido neste elemento é devolvido na mensagem de retorno, caso o registro não possa ser incluído ou atualizado. Com isso, é possível relacionar os dados enviados na requisição com a mensagem de retorno
cadastroCEP	Opcional	Set	(Opcional) - Caso o CEP informado em CepCli não existir no banco de dados, o CEP será cadastrado no cadastro de CEPs com os dados desta estrutura
cadastroCEP.cepIni	Obrigatório	String	(Obrigatório) - Number(008) - CEP Inicial
cadastroCEP.cepFim	Obrigatório	String	(Obrigatório) - Number(008) - CEP final
cadastroCEP.codRai	Opcional	Integer	(Opcional) - Number(007) - Código da cidade para o RAIS
cadastroCEP.nomCid	Obrigatório	String	(Obrigatório) - String(060) - Nome da cidade
cadastroCEP.baiCid	Opcional	String	(Opcional) - String(075) - Bairro
cadastroCEP.endCid	Opcional	String	(Opcional) - String(100) - Endereço referente ao CEP (quando faixa de apenas um CEP)
cadastroCEP.cepPol	Opcional	String	(Opcional) - Number(008) - CEP da Cidade Polo
dadosGeraisCliente.codFor	Opcional	Integer	(Opcional) - Number(009) - Código do cliente no cadastro de fornecedores. Utilizar somente quando for desejado vincular o cliente a um fornecedor específico ou remover o vínculo do cliente com o fornecedor, preenchendo o campo com o valor 0
dadosGeraisCliente.codGre	Opcional	String	(Opcional) - Number(004) - Código do grupo de empresas
dadosGeraisCliente.datSuf	Opcional	String	(Opcional) - Date - Data de validade do registro do SUFRAMA
dadosGeraisCliente.eenCli	Opcional	String	(Opcional) - String(018) - Código do endereço do cliente
dadosGeraisCliente.eenEnt	Opcional	String	(Opcional) - String(018) - Código do endereço de entrega do cliente
dadosGeraisCliente.endEnt	Opcional	String	(Obrigatório) - String(100) - Endereço de entrega do cliente
dadosGeraisCliente.nenEnt	Opcional	String	(Opcional) - String(060) - Número do endereço de entrega do cliente
dadosGeraisCliente.cplEnt	Opcional	String	(Opcional) - String(200) - Complemento do endereço de entrega do cliente
dadosGeraisCliente.cepEnt	Opcional	Integer	(Opcional) - Number(008) - CEP do endereço de entrega do cliente
dadosGeraisCliente.baiEnt	Opcional	String	(Opcional) - String(075) - Bairro de Entrega do cliente
dadosGeraisCliente.zipEnt	Opcional	String	(Opcional) - String(014) - Código da cidade do endereço de entrega do cliente externo - ZIP CODE
dadosGeraisCliente.cidEnt	Opcional	String	(Opcional) - String(060) - Cidade do endereço de entrega do cliente
dadosGeraisCliente.estEnt	Opcional	String	(Opcional) - String(002) - Estado do endereço de entrega do cliente
dadosGeraisCliente.insEnt	Opcional	String	(Opcional) - String(025) - Inscrição estadual do endereço de entrega
dadosGeraisCliente.cgcEnt	Opcional	Double	(Opcional) - Number(014) - Número do CNPJ de Entrega
dadosGeraisCliente.eenCob	Opcional	String	(Opcional) - String(018) - Código do endereço de cobrança do cliente
dadosGeraisCliente.nenCob	Opcional	String	(Opcional) - String(060) - Número do endereço de cobrança do cliente
dadosGeraisCliente.endCob	Opcional	String	(Opcional) - String(100) - Endereço de cobrança do cliente
dadosGeraisCliente.cplCob	Opcional	String	(Opcional) - String(200) - Complemento do endereço de cobrança do cliente
dadosGeraisCliente.cepCob	Opcional	Integer	(Opcional) - Number(008) - CEP do endereço de cobrança do cliente
dadosGeraisCliente.baiCob	Opcional	String	(Opcional) - String(075) - Bairro de Cobrança do cliente
dadosGeraisCliente.cidCob	Opcional	String	(Opcional) - String(060) - Cidade do endereço de cobrança do cliente
dadosGeraisCliente.estCob	Opcional	String	(Opcional) - String(002) - Estado do endereço de cobrança do cliente
dadosGeraisCliente.cgcCob	Opcional	Double	(Opcional) - Number(014) - Número do CNPJ de cobrança
dadosGeraisCliente.cepFre	Opcional	Integer	(Opcional) - Number(008) - Faixa inicial do CEP para cálculo do frete no pedido
dadosGeraisCliente.entCor	Opcional	String	EntCor - (Opcional) - String(001) - Indicativo do endereço de entrega de correspondências - Lista: N = Endereço Normal, E = Endereço de Entrega, C = Endereço de Cobrança
dadosGeraisCliente.cliFor	Opcional	String	CliFor - (Opcional) - String(001) - Indicativo se o registro representa um cliente ou um fornecedor ou ambos - Lista: C = Cliente, F = Fornecedor, A = Cliente/Fornecedor
dadosGeraisCliente.cliRep	Opcional	Integer	(Opcional) - Number(009) - Código do cliente como representante
dadosGeraisCliente.cliTra	Opcional	Integer	(Opcional) - Number(009) - Código do cliente como transportadora
dadosGeraisCliente.marCli	Opcional	String	(Opcional) - String(020) - Marca do cliente
dadosGeraisCliente.codMot	Opcional	Integer	(Opcional) - Number(006) - Código do motivo da situação do cliente
dadosGeraisCliente.codCnv	Opcional	Integer	(Opcional) - Number(004) - Código do convênio
dadosGeraisCliente.perAin	Opcional	Integer	(Opcional) - Number(004) - Percentual adicional do INSS
dadosGeraisCliente.tipAce	Obrigatório	Integer	TipAce - (Obrigatório) - Number(001) - Tipo de acerto(arredondamento) do cliente - Lista: 1 = Arredonda, 2 = Trunca
dadosGeraisCliente.insAnp	Opcional	Integer	(Opcional) - Number(007) - Código da instalação conforme cadastro da ANP
dadosGeraisCliente.indCoo	Opcional	String	IndCoo - (Opcional) - String(001) - Indicativo se cliente/fornecedor é cooperado. - Lista: N = Não, S = Sim
dadosGeraisCliente.codRtr	Opcional	Integer	CodRtr - (Opcional) - Number(001) - Código do Regime Tributário - Lista: 1 = Simples Nacional, 2 = Simples Nacional - excesso de sublimite de receita bruta, 3 = Regime Normal
dadosGeraisCliente.regEst	Opcional	Integer	RegEst - (Opcional) - Number(001) - Regime Especial de Tributação (Meramente Informativo para NF-e) - Lista: 1 = Microempresa municipal, 2 = Estimativa, 3 = Sociedade de profissionais, 4 = Cooperativa, 5 = Microempresário Individual (MEI), 6 = Microempresário e Empresa de Pequeno Porte (ME EPP)
dadosGeraisCliente.natRet	Opcional	Integer	NatRet - (Opcional) - Number(002) - Indicador de natureza da retenção na fonte de PIS e Cofins - Lista: 01 = Retenção por órgãos, autarquias e fundações federais, 02 = Retenção por outras entidades da administração pública federal, 03 = Retenção por pessoas jurídicas de direito privado, 04 = Recolhimento por sociedade cooperativa, 05 = Retenção por fabricante de máquinas e veículos, 99 = Outras retenções
dadosGeraisCliente.natPis	Opcional	Integer	(Opcional) - Number(005) - Natureza da receita do PIS
dadosGeraisCliente.natCof	Opcional	Integer	(Opcional) - Number(005) - Natureza da receita do COFINS
dadosGeraisCliente.codRam	Opcional	String	(Opcional) - String(005) - Código do ramo de atividade
dadosGeraisCliente.codRoe	Opcional	String	(Opcional) - String(003) - Código da Rota ou Localidade do Cliente
dadosGeraisCliente.seqRoe	Opcional	Integer	(Opcional) - Number(004) - Sequência da rota ou localidade
dadosGeraisCliente.codSro	Opcional	String	(Opcional) - String(003) - Código da Sub Rota
dadosGeraisCliente.limRet	Opcional	String	LimRet - (Opcional) - String(001) - Indicativo de como é utilizado o valor limite para cálculos de retenção para o cliente nas notas fiscais de saída - Lista: P = Produto, E = Serviço, S = Ambos, N = Não Utiliza
dadosGeraisCliente.numIdf	Opcional	String	(Opcional) - String(040) - Número de identificação fiscal
dadosGeraisCliente.tipEmc	Opcional	Integer	TipEmc - (Opcional) - Number(001) - Tipo Empresa do cliente para geração de título de COFINS
dadosGeraisCliente.entPaa	Opcional	String	EntPaa - (Opcional) - String(001) - Entidade inscrita no Programa de Aquisição de Alimentos (PAA)
dadosGeraisCliente.vlrLat	Opcional	String	(Opcional) - String(100) - Valor da Latitude do endereço do cliente
dadosGeraisCliente.vlrLon	Opcional	String	(Opcional) - String(100) - Valor da Longitude do endereço do cliente
camposUsuario	Opcional	Set	Lista de campos de usuário
camposUsuario.campo	Opcional	String	Nome do campo de usuário
camposUsuario.valor	Opcional	String	Valor do campo de usuário
dadosGeraisCliente.codMsg	Opcional	Integer	Number(004) - Código da mensagem - 1
dadosGeraisCliente.codMs2	Opcional	Integer	Number(004) - Código da mensagem - 2
dadosGeraisCliente.codMs3	Opcional	Integer	Number(004) - Código da mensagem - 3
dadosGeraisCliente.codMs4	Opcional	Integer	Number(004) - Código da mensagem - 4
dadosGeraisCliente.codHas	Opcional	String	String(50) - Código da hash da requisição
dadosGeraisCliente.catEst	Opcional	String	
String(003) - Categoria do estabelecimento

ARM=Armazenador;
CFC=Consumidor Final Contribuinte;
CNF=Consumidor Final Não Contribuinte;
CPQ=Central Petroquímica;
DIS=Distribuidor;
ECE=Empresa Comercializadora de Etanol;
FOR=Formulador;
IMP=Importador;
PRV=Posto Varejista;
REF=Refinaria;
TRR=Transportador e Revendedor Retalhista;
USI=Usina;
VGL=Varejista de GLP
dataBuild	Opcional	String	Mantido por compatibilidade
sigInt	Opcional	String	(Opcional) - String(15) - Sigla do Sistema de Integração
idtReq	Opcional	String	(Opcional) - String(20) - Identificação da Requisição
Obervação

No envio dos parâmetros de requisição codEmp e codFil, as filiais definidas como M - Consolidadoras de movimentos no campo Filial Totalizadora da tela Parâmetros da Filial para Tributos (F070FEF), serão desconsideradas
A busca de um cliente na requisição é feita conforme a sequência abaixo:
Código do cliente (CodCli)
CNPJ/CPF do cliente (CgcCpf)
Identificação do cliente (IdeCli)
Número de identificação fiscal do cliente (NumIdf)
OpenResposta:
Observação

Envelope SOAP de resposta de requisições síncronas. Para requisições assíncronas ou agendamentos, a resposta é apenas uma String chamada "result" com o valor "OK", se foi executado com sucesso ou, caso contrário, a mensagem do erro ocorrido.

<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.senior.com.br">
  <soapenv:Body>
    <ser:GravarClientesResponse>
      <result>
        <tipoRetorno>Integer</tipoRetorno>
        <retornosClientes>
          <codCli>Integer</codCli>
          <cgcCpf>String</cgcCpf>
          <codFor>String</codFor>
          <ideExt>String</ideExt>
          <retorno>String</retorno>
        </retornosClientes>
        <mensagemRetorno>String</mensagemRetorno>
        <retornosEnderecosEntrega>
          <seqEnv>String</seqEnv>
          <codCli>String</codCli>
          <cgcCpf>String</cgcCpf>
          <seqEnt>String</seqEnt>
          <retorno>String</retorno>
        </retornosEnderecosEntrega>
        <erroExecucao>String</erroExecucao>
      </result>
    </ser:GravarClientesResponse>
  </soapenv:Body>
</soapenv:Envelope>
OpenAtributos da resposta:
Nome	Preenchimento	Tipo	Descrição
tipoRetorno	Obrigatório	Integer	(Obrigatório) - Número(001) - Tipo de Retorno de Processamento - Lista: 1 = Processado, 2 = Erro na Solicitação
retornosClientes	Opcional	Set	(Opcional) - String(030) - Identificação externa do cliente. Enviado apenas quando é fornecida a identificação externa na mensagem de requisição do serviço
ClosedExemplo
retornosClientes.codCli	Opcional	Integer	(Opcional) - Number(009) - Código do cliente
retornosClientes.cgcCpf	Obrigatório	String	(Obrigatório) - Number(014) - Numero do CNPJ ou CPF do cliente
retornosClientes.codFor	Obrigatório	String	(Obrigatório) - Number(009) - Código do fornecedor. Restrição: Somente será retornado, se estiver configurado como cliente igual a fornecedor
retornosClientes.ideExt	Obrigatório	String	(Obrigatório) - String(030) - Retorna o valor do elemento IdeExt enviado na requisição. Quando tratar-se de uma série de retornos para um mesmo ideExt, o último não terá o valor para esse campo
retornosClientes.retorno	Obrigatório	String	(Obrigatório) - String(100) - Retorno do processamento
mensagemRetorno	Obrigatório	String	(Obrigatório) - String(1000) - Mensagem de Retorno de Processamento
retornosEnderecosEntrega.	Opcional	Set	 
retornosEnderecosEntrega.seqEnv	Opcional	String	Sequência de envio do endereço de entrega (Sequência do sistema externo)
retornosEnderecosEntrega.codCli	Opcional	String	Código do cliente no ERP
retornosEnderecosEntrega.cgcCpf	Opcional	String	CPF/CNPJ do cliente
retornosEnderecosEntrega.seqEnt	Opcional	String	(Obrigatório) Sequência do endereço de entrega no ERP
retornosEnderecosEntrega.retorno	Opcional	String	Mensagem de retorno do processamento
erroExecucao	Opcional	String	Indica erros ocorridos no servidor ao executar o serviço, podendo conter os seguintes valores:Vazio ou nulo, indicando que a execução foi feita com sucessoA mensagem do erro ocorrido no servidorSó impede a gravação quando o retorno.tipRet for igual a "2"


// Lista de parametros obrigatórios para gravar clientes
