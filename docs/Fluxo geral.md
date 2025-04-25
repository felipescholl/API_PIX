# Fluxo Geral - Cobrança PIX

```mermaid
---
config:
  layout: elk
---
flowchart TD
 subgraph s1["Validações"]
    direction TB
        ValidaTXID["Valida TXID"]
        ValidaWebhook["Valida Webhook"]
        ValidaDados["Valida Dados"]
  end
    Usuario("Usuario/Sistema") -- 1 Login --> AuthService["AuthService"]
    AuthService -- 2 Valida Credenciais --> DB[("Database")]
    DB -- 3 Retorna Usuário --> AuthService
    AuthService -- 4 Redireciona --> DashboardController["DashboardController"]
    Usuario -- 5 Acessa Dashboard --> DashboardController
    DashboardController -- 6 Busca Dados --> DB
    DB -- 7 Retorna Dados --> DashboardController
    DashboardController -- 8 Renderiza View --> Usuario
    Usuario -- 9 Solicita Cobrança --> CobrancaController["CobrancaController"]
    CobrancaController -- 10 Gera TXID --> TxidService["TxidService"]
    CobrancaController -- 11 Cria Cobrança --> PixService["PixService"]
    PixService -- 12 Envia para Sicredi --> SicrediAPI["Sicredi API"]
    SicrediAPI -- 13 Retorna Dados PIX --> PixService
    PixService -- 14 Gera QRCode --> GeradorCode["GeradorCode"]
    GeradorCode -- 15 Retorna QRCode --> PixService
    PixService -- 16 Salva Cobrança --> DB
    CobrancaController -- 17 Retorna Dados --> Usuario
    SicrediAPI -- 18 Notifica Pagamento --> WebhookController["WebhookController"]
    WebhookController -- 19 Valida Webhook --> PixService
    PixService -- 20 Registra Pagamento --> SeniorsService["SeniorsService"]
    SeniorsService -- 21 Baixa Título --> SapiensAPI["Sapiens API"]
    PixService -- 22 Atualiza Status --> DB
    Usuario -- 23 Acessa Relatórios --> RelatorioController["RelatorioController"]
    RelatorioController -- 24 Busca Dados --> DB
    DB -- 25 Retorna Dados --> RelatorioController
    RelatorioController -- 26 Renderiza View --> Usuario
    Usuario -- 27 Acessa Configurações --> ConfiguracaoController["ConfiguracaoController"]
    ConfiguracaoController -- 28 Busca Dados --> DB
    DB -- 29 Retorna Dados --> ConfiguracaoController
    ConfiguracaoController -- 30 Renderiza View --> Usuario
     PixService:::service
     SeniorsService:::service
     TxidService:::service
     GeradorCode:::service
     SicrediAPI:::api
     SapiensAPI:::api
     DB:::db
    classDef service fill:#f9f,stroke:#333,stroke-width:2px
    classDef api fill:#bbf,stroke:#333,stroke-width:2px
    classDef db fill:#dfd,stroke:#333,stroke-width:2px
