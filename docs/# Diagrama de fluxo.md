---
config:
  layout: elk
---
flowchart TD
 subgraph s1["Variáveis"]
        credentials{"email, password"}
        userData{"user, permissions"}
        cobrancaRequest{"codEmp,
            codFil,
            numTit,
            codTpt,
            codTns,
            datEmi,
            datEnt,
            codCli,
            vlrOri,
            vctOri"}
        txidData{"sistema_origem,
            numTit,
            codCli,
            codTpt,
            valor,
            vencimento"}
        pixData{"txid,
            valor,
            pagador,
            vencimento,
            location,
            emv"}
        webhookPayload{"txid,
                endToEndId,
                valor,
                horario"}
        tituloData{"titulo_id,
            status_senior,
            erro_registro"}
        transacaoData{"cobranca_id,
            tipo,
            status,
            valor,
            metadados"}
  end
 subgraph Frontend["Frontend"]
        Usuario("Usuario/Sistema")
  end
 subgraph Controllers["Controllers"]
        AuthController["AuthController"]
        DashboardController["DashboardController"]
        CobrancaController["CobrancaController"]
        WebhookController["WebhookController"]
  end
 subgraph Services["Services"]
        PixService["PixService"]
        SeniorsService["SeniorsService"]
        TxidService["TxidService"]
        TratamentoWebhook["TratamentoWebhook"]
  end
 subgraph External["External"]
        SicrediAPI["Sicredi API"]
        SapiensAPI["Sapiens API"]
  end
 subgraph Database["Database"]
        DB[("Database")]
  end
 subgraph Notifications["Notifications"]
        ErrorNotification["ErrorNotification"]
  end
    Usuario -- 1 Solicita Cobrança --> CobrancaController
    CobrancaController -- 2 Valida Dados --> cobrancaRequest
    CobrancaController -- 3 Gera TXID --> TxidService
    TxidService -- 4 Retorna TXID --> txidData
    CobrancaController -- 5 Cria Título --> DB
    CobrancaController -- 6 Solicita Cobrança PIX --> PixService
    PixService -- 7 Envia para Sicredi --> SicrediAPI
    SicrediAPI -- 8 Retorna Dados PIX --> pixData
    CobrancaController -- 9 Cria Cobrança --> DB
    CobrancaController -- 10 Registra Transação --> DB
    CobrancaController -- 11 Envia para Sapiens --> SeniorsService
    SeniorsService -- 12 Grava Título --> SapiensAPI
    SapiensAPI -- 13 Retorna Status --> tituloData
    CobrancaController -- 14 Retorna Dados --> Usuario
    SicrediAPI -- 15 Notifica Pagamento --> WebhookController
    WebhookController -- 16 Valida Assinatura --> PixService
    WebhookController -- 17 Processa Webhook --> TratamentoWebhook
    TratamentoWebhook -- 18 Busca Cobrança --> DB
    TratamentoWebhook -- 19 Registra Transação --> transacaoData
    TratamentoWebhook -- 20 Atualiza Cobrança --> DB
    TratamentoWebhook -- 21 Registra Pagamento --> SeniorsService
    SeniorsService -- 22 Baixa Título --> SapiensAPI
    SeniorsService -- E1 Notifica Erro --> ErrorNotification
    PixService -- E2 Notifica Erro --> ErrorNotification
    TratamentoWebhook -- E3 Notifica Erro --> ErrorNotification
    ErrorNotification -- E4 Envia Email --> Usuario
    Usuario -- 23 Consulta Dashboard --> DashboardController
    DashboardController -- 24 Busca Dados --> DB
    DB -- 25 Retorna Estatísticas --> DashboardController
    DashboardController -- 26 Renderiza View --> Usuario
     credentials:::var
     userData:::var
     cobrancaRequest:::var
     txidData:::var
     pixData:::var
     webhookPayload:::var
     tituloData:::var
     transacaoData:::var
    classDef var fill:#f9f,stroke:#333,stroke-width:2px
