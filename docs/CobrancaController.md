# Documentação do CobrancaController

## Visão Geral

O `CobrancaController` é um controlador da API responsável por gerenciar a criação, consulta e exclusão de cobranças PIX. Este controlador atua como intermediário entre os sistemas internos (SCR e Sisclass) e os serviços de pagamento PIX do Sicredi, além de integrar com o sistema SAPIENS para registro de títulos.

## Dependências

- **PixService**: Serviço para interação com a API PIX do Sicredi
- **SeniorsService**: Serviço para interação com o sistema SAPIENS
- **TxidService**: Serviço para geração de identificadores de transação (TXID)
- **Modelos**: Cliente, Cobranca, Titulo, Transacao

## Métodos Principais

### `__construct(PixService $pixService, SeniorsService $seniorService)`

Inicializa o controlador com as dependências necessárias.

- **Parâmetros**:
  - `$pixService`: Instância do serviço PIX para comunicação com o Sicredi
  - `$seniorService`: Instância do serviço para comunicação com o SAPIENS

### `gerarCobrancaSCR(Request $request)`

Gera uma cobrança PIX para o sistema SCR com configurações específicas.

- **Parâmetros**:
  - `$request`: Objeto Request contendo os dados da cobrança
- **Configurações específicas**:
  - Validade após vencimento: 730 dias
  - Sistema de origem: SCR
  - Modalidade de multa: Percentual (2)
  - Valor da multa: 1%
  - Modalidade de juros: Percentual por mês em dias corridos (3)
  - Valor de juros: 1% ao mês
- **Retorno**: Resposta JSON com os dados da cobrança gerada

### `gerarCobrancaSisclass(Request $request)`

Gera uma cobrança PIX para o sistema Sisclass com configurações específicas.

- **Parâmetros**:
  - `$request`: Objeto Request contendo os dados da cobrança
- **Configurações específicas**:
  - Validade após vencimento: 5 dias
  - Sistema de origem: CLA
- **Retorno**: Resposta JSON com os dados da cobrança gerada

### `gerarCobranca(Request $request, $sistema)`

Método principal que processa a geração de cobranças PIX. É chamado pelos métodos específicos de cada sistema.

- **Parâmetros**:
  - `$request`: Objeto Request contendo os dados da cobrança
  - `$sistema`: Array com configurações específicas do sistema de origem
- **Fluxo de processamento**:
  1. Validação dos dados recebidos
  2. Verificação/cadastro do cliente
  3. Verificação da existência do título
  4. Geração da cobrança PIX (novo TXID)
  5. Criação/atualização do título no banco de dados
  6. Criação da cobrança vinculada ao título
  7. Registro de transação inicial
  8. Preparação dos dados para o SAPIENS
  9. Registro no SAPIENS (gravação ou atualização)
  10. Atualização do status da cobrança com base no resultado do SAPIENS
  11. Registro de transação de sucesso
- **Tratamento de exceções**:
  - Registro de erros no log
  - Atualização do status do título para 'ER' em caso de erro
  - Atualização do status da cobrança para 'CANCELADO' em caso de erro
- **Retorno**: Resposta JSON com os dados da cobrança gerada ou mensagem de erro

### `gerarPix($validated, $sistema)`

Método privado que gera uma cobrança PIX utilizando o serviço PIX.

- **Parâmetros**:
  - `$validated`: Array com dados validados da cobrança
  - `$sistema`: Array com configurações específicas do sistema de origem
- **Processamento**:
  1. Geração do TXID através do TxidService
  2. Preparação dos dados para cobrança PIX
  3. Adição de configurações de multa e juros quando aplicável
  4. Geração da cobrança PIX através do PixService
- **Retorno**: Array com dados da cobrança PIX gerada (txid, location, pixCopiaECola)

### `webhookSicredi(Request $request)`

Processa notificações de webhook recebidas do Sicredi.

- **Parâmetros**:
  - `$request`: Objeto Request contendo os dados do webhook
- **Processamento**:
  1. Validação da assinatura do webhook
  2. Processamento dos dados do webhook através do serviço TratamentoWebhook
- **Retorno**: Resposta JSON com o resultado do processamento ou mensagem de erro

### `excluirTitulo($numTit)`

Exclui um título e suas cobranças associadas.

- **Parâmetros**:
  - `$numTit`: Número do título a ser excluído
- **Processamento**:
  1. Carregamento do título pelo número
  2. Verificação se o título já foi pago ou excluído
  3. Carregamento das cobranças relacionadas ao título
  4. Envio de requisição de exclusão para o SAPIENS
  5. Atualização do status do título para 'EX'
  6. Cancelamento das cobranças PIX no Sicredi
  7. Atualização do status das cobranças para 'EXCLUIDO'
- **Retorno**: Resposta JSON com o resultado da exclusão ou mensagem de erro

## Validações e Regras de Negócio

1. **Validação de dados**: Todos os campos obrigatórios são validados antes do processamento
2. **Verificação de alterações**: Não é permitido alterar valores ou data de vencimento de títulos já cadastrados
3. **Tratamento de títulos existentes**:
   - Se o título já existe e não está em situação de erro ('ER'), retorna os dados existentes
   - Se o título já existe e está em situação de erro, gera nova cobrança com novo TXID
4. **Substituição de cobranças**: Quando uma nova cobrança é gerada para um título existente, a cobrança anterior é marcada como substituída
5. **Tratamento de erros**: Todos os erros são registrados no log e retornados na resposta

## Códigos de Erro

- **E-Api-CC-001**: Erro genérico ao gerar cobrança
- **E-Api-CC-002**: Título já cadastrado - Não é possível alterar valores ou data de vencimento
- **E-Api-CC-003**: Assinatura do webhook inválida
- **E-Api-CC-004**: Título não encontrado
- **E-Api-CC-005**: Título já foi pago
- **E-Api-CC-006**: Título já foi excluído
- **E-Api-CC-007**: Erro ao excluir título / Cobrança não encontrada
- **E-Api-CC-009**: Erro ao cancelar cobrança

## Logs

- **L-Api-CC-001**: Erro ao gerar cobrança
- **L-Api-CC-002**: Erro no webhook Sicredi
- **L-Api-CC-003**: Erro ao cancelar título
- **L-Api-CC-004**: Erro ao processar cancelamento da cobrança

## Integração com Outros Sistemas

### SAPIENS
- Registro de títulos através do método `gravarTitulo` do SeniorsService
- Atualização de títulos através do método `atualizarTitulo` do SeniorsService
- Exclusão de títulos através do método `excluirTitulo` do SeniorsService

### Sicredi PIX
- Geração de cobranças PIX através do método `gerarCobranca` do PixService
- Cancelamento de cobranças PIX através do método `cancelarCobranca` do PixService
- Recebimento de notificações de pagamento através do webhook

## Fluxo de Dados

1. **Entrada**: Dados do título e do pagador recebidos via API
2. **Processamento**: Validação, geração de TXID, criação de registros no banco de dados
3. **Integração**: Comunicação com SAPIENS e Sicredi PIX
4. **Saída**: Dados da cobrança PIX (TXID, URL, código copia e cola)
5. **Notificação**: Recebimento de webhooks para atualização do status de pagamento

## Observações

- O controlador utiliza transações para garantir a consistência dos dados
- Todos os erros são tratados e registrados para facilitar o diagnóstico de problemas
- A documentação dos campos e parâmetros está disponível nos comentários do código