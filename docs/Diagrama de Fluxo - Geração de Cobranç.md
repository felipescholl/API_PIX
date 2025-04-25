# Diagrama de Fluxo - Geração de Cobrança

```mermaid
flowchart TD
    A[Cliente] -->|Request| B(CobrancaController)
    B -->|1. Gerar txid| C{PixService}
    B -->|2. Registrar Título| D{SeniorService}
    
    C -->|Retorna| E[pixCopiaECola]
    D -->|Grava| F[SAPIENS]
    
    B -->|3. Salvar| G[(Database)]
    
    subgraph DadosCobranca
        H[txid]
        I[pix_copia_cola]
        J[valor]
        K[data_vencimento]
        L[status]
        M[cpf_cnpj_pagador]
        N[sistema_origem]
        O[codigo_projeto]
    end
    
    G --> DadosCobranca
    
    subgraph Validacoes
        P[Verificar dados]
        Q[Gerar txid único]
        R[Formatar data]
    end
    
    B --> Validacoes
    
    style A fill:#f9f,stroke:#333,stroke-width:2px
    style B fill:#bbf,stroke:#333,stroke-width:2px
    style C fill:#dfd,stroke:#333,stroke-width:2px
    style D fill:#dfd,stroke:#333,stroke-width:2px
    style G fill:#ffd,stroke:#333,stroke-width:2px