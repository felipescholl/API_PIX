# Diagrama de Fluxo de Informações e Variáveis

```mermaid
---
config:
  layout: elk
---
flowchart TD
    %% Definição dos componentes principais
    Usuario(Usuario/Sistema) 
    AuthService[AuthService]
    DashboardController[DashboardController]
    CobrancaController[CobrancaController]
    RelatorioController[RelatorioController]
    ConfiguracaoController[ConfiguracaoController]
    PixService[PixService]
    SeniorsService[SeniorsService]
    TxidService[TxidService] 
    GeradorCode[GeradorCode]
    SicrediAPI[Sicredi API]
    SapiensAPI[Sapiens API]
    DB[(Database)]
    WebhookController[WebhookController]

    %% Fluxo de Autenticação
    Usuario -->|1 Login| AuthService
    AuthService -->|2 Valida Credenciais| DB
    DB -->|3 Retorna Usuário| AuthService
    AuthService -->|4 Redireciona| DashboardController

    %% Variáveis trocadas
    classDef var fill:#f9f,stroke:#333,stroke-width:2px
    classDef service fill:#bbf,stroke:#333,stroke-width:2px
    classDef api fill:#dfd,stroke:#333,stroke-width:2px
    classDef db fill:#ffd,stroke:#333,stroke-width:2px

    subgraph Variáveis
        email
        password
        user
        dashboardData
        cobrancaData
        txid
        pixData
        qrcode
        webhookPayload
        relatorioData
        configuracaoData
    end

    %% Fluxo do Dashboard
    Usuario -->|5 Acessa Dashboard| DashboardController
    DashboardController -->|6 Busca Dados| DB
    DB -->|7 Retorna Dados| DashboardController
    DashboardController -->|8 Renderiza View| Usuario

    %% Fluxo de Geração de Cobrança
    Usuario -->|9 Solicita Cobrança| CobrancaController
    CobrancaController -->|10 Gera TXID| TxidService
    CobrancaController -->|11 Cria Cobrança| PixService
    PixService -->|12 Envia para Sicredi| SicrediAPI
    SicrediAPI -->|13 Retorna Dados PIX| PixService
    PixService -->|14 Gera QRCode| GeradorCode
    GeradorCode -->|15 Retorna QRCode| PixService
    PixService -->|16 Salva Cobrança| DB
    CobrancaController -->|17 Retorna Dados| Usuario

    %% Fluxo de Webhook
    SicrediAPI -->|18 Notifica Pagamento| WebhookController
    WebhookController -->|19 Valida Webhook| PixService
    PixService -->|20 Registra Pagamento| SeniorsService
    SeniorsService -->|21 Baixa Título| SapiensAPI
    PixService -->|22 Atualiza Status| DB

    %% Fluxo de Relatórios
    Usuario -->|23 Acessa Relatórios| RelatorioController
    RelatorioController -->|24 Busca Dados| DB
    DB -->|25 Retorna Dados| RelatorioController
    RelatorioController -->|26 Renderiza View| Usuario

    %% Fluxo de Configurações
    Usuario -->|27 Acessa Configurações| ConfiguracaoController
    ConfiguracaoController -->|28 Busca Dados| DB
    DB -->|29 Retorna Dados| ConfiguracaoController
    ConfiguracaoController -->|30 Renderiza View| Usuario

    %% Estilização
    class PixService,SeniorsService,TxidService,GeradorCode service
    class SicrediAPI,SapiensAPI api
    class DB db
    class email,password,user,dashboardData,cobrancaData,txid,pixData,qrcode,webhookPayload,relatorioData,configuracaoData var