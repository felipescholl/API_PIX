# Diagrama de Classes

```mermaid
classDiagram
    class User {
        +id
        +name
        +email
        +password
        +created_at
        +updated_at
    }

    class Cobranca {
        +txid
        +pix_copia_cola
        +valor
        +valor_pago
        +data_vencimento
        +status
        +e2eid
        +data_pagamento
        +cpf_cnpj_pagador
        +nome_pagador
        +sistema_origem
        +codigo_projeto
        +cod_emp
        +cod_fil
        +num_tit
        +cod_tpt
        +cod_for
        +registrado_sapiens
        +data_registro_sapiens
        +erro_registro_sapiens
        +cliente_id
        +cliente()
        +getStatusFormatadoAttribute()
        +getValorFormatadoAttribute()
    }

    class Cliente {
        +id
        +nome
        +email
        +telefone
        +cpf_cnpj
        +endereco
        +cidade
        +estado
        +cep
        +created_at
        +updated_at
    }

    class Transacao {
        +id
        +cobranca_id
        +endToEndId
        +valor
        +status
        +tipo
        +chave_pix
        +detalhes_pagador
        +horario_pagamento
        +created_at
        +updated_at
        +cobranca()
    }

    class GeradorCode {
        +qrcode(codpix, txid)
    }

    class PixService {
        // Métodos do serviço Pix
    }

    class SeniorsService {
        // Métodos do serviço Seniors
    }

    class TxidService {
        // Métodos do serviço Txid
    }

    class DashboardController {
        +index()
    }

    class CobrancaController {
        +index()
        +create()
        +store()
        +show()
        +edit()
        +update()
        +destroy()
    }

    class RelatorioController {
        // Métodos do controlador de relatórios
    }

    class ConfiguracaoController {
        // Métodos do controlador de configurações
    }

    class WebhookController {
        +handleSicrediWebhook()
        +processarPix()
    }

    class ApiCobrancaController {
        +gerarCobrancaSCR()
        +webhookSicredi()
    }

    class Controller {
        +AuthorizesRequests
        +DispatchesJobs
        +ValidatesRequests
    }

    User --> Cobranca : hasMany
    Cobranca --> Cliente : belongsTo
    Cobranca --> Transacao : hasMany
    Transacao --> Cobranca : belongsTo
    DashboardController --> Cobranca : Uses
    DashboardController --> View : Uses
    CobrancaController --> Cobranca : Uses
    CobrancaController --> PixService : Uses
    CobrancaController --> SeniorsService : Uses
    CobrancaController --> TxidService : Uses
    WebhookController --> Cobranca : Uses
    WebhookController --> SeniorsService : Uses
    ApiCobrancaController --> Cobranca : Uses
    ApiCobrancaController --> PixService : Uses
    ApiCobrancaController --> SeniorsService : Uses
    Controller <|-- DashboardController
    Controller <|-- RelatorioController
    Controller <|-- ConfiguracaoController
    Controller <|-- CobrancaController
    Controller <|-- WebhookController
    Controller <|-- ApiCobrancaController