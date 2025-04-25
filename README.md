<div align="center">

# API Pix 
# Emater 🔄 Sicredi 🔄 Sênior

[![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![SQL Server](https://img.shields.io/badge/SQL%20Server-2017-CC2927?style=for-the-badge&logo=microsoft-sql-server&logoColor=white)](https://www.microsoft.com/en-us/sql-server/sql-server-downloads)
[![License](https://img.shields.io/badge/Licença-MIT-green?style=for-the-badge)](LICENSE)

Solução para integração com o sistema de pagamentos instantâneos Pix, desenvolvida para a Emater-RS/ASCAR

</div>

## 📋 Visão Geral

O Projeto API Pix é uma solução completa para integração com o sistema de pagamentos instantâneos Pix, desenvolvida utilizando o framework Laravel. Esta API facilita a gestão de transações financeiras, proporcionando uma interface segura e eficiente para operações com Pix.

## ✨ Funcionalidades Principais

- 🔄 Geração de QR Code Pix dinâmico e estático
- 💰 Recebimento de pagamentos em tempo real
- 📊 Consulta e monitoramento de transações
- 🔑 Gestão completa de chaves Pix
- 📱 Integração com sistemas internos da Emater-RS/ASCAR
- 📈 Relatórios e análises de transações

## 🔧 Requisitos do Sistema

- PHP 8.1 ou superior
- Composer 2.x
- SQL Server 17+
- Laravel 10.x

## 🚀 Instalação

1. Clone o repositório
   ```bash
   git clone git@github.com:felipescholl/API_PIX.git
   cd API_PIX
   ```

2. Instale as dependências:
   ```bash
   composer install
   ```

3. Configure o arquivo .env
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Execute as migrations:
   ```bash
   php artisan migrate
   ```

5. Inicie o servidor:
   ```bash
   php artisan serve
   ```

## 💻 Exemplos de Uso



### Exemplo de Requisição para Geração de Cobrança SCR

### Exemplo de Requisição para Geração de Cobrança SCR

**Endpoint:**

*Método:* `POST`  
*URL:* `{base_url}/api/cobrancas/gerar-scr`


**Headers:**

```makefile
X-API-KEY: chave_secreta_api_key
Content-Type: application/json
```


**Body:**

```json
{
  "codEmp": "2",
  "codFil": "100",
  "numTit": "048026",
  "codTpt": "R44",
  "codTns": "90305",
  "codCli": "113229",
  "codRep": "1",
  "codCrp": "CTR",
  "codCrt": "99",
  "numCco": "26860-7",
  "datEmi": "2025-04-02",
  "vctOri": "2025-04-07",
  "vlrOri": 0.05,
  "codFpg": "23",
  "codNtg": null,
  "datEnt": "2025-04-02",
  "proJrs": "S",
  "codPor": null,
  "msgPag": null,
  "numPrj": "31002",
  "cpf_cnpj": "01368145060",
  "nome_pagador": "Felipe Scholl",
  "responsavel": "Edna Marcondes",
  "apeCli": "nomeFantasiaEmpresa",
  "intNet": "cliente@email.com",
  "fonCli": "(51) 99999-6666",
  "fonCl2": "",
  "endCli": "Rua Botafogo",
  "nenCli": "1051",
  "cplCli": "3º Andar",
  "baiCli": "Menino Deus",
  "cidCli": "Porto Alegre",
  "cepCli": "92000-000"
}
```	

## 💻 Dashboard de acompanhamento

Visualize a dashboard de acompanhamento das cobranças geradas pelo sistema.
- Verifique o status das cobranças
- Acompanhe o histórico de pagamentos
- Visualize os detalhes de cada cobrança

### Layout da Dashboard

![Dashboard](/docs/dashboard.png)


Acesse os detalhes de cada cobrança para obter informações mais específicas.
- Informações sobre o pagador
- Dados bancários do pagador
- Dados do projeto/produtor
- Dados do pagamento
- QR Code Pix / Codigo copia e cola

### Layout Detalhes da Cobrança

![Detalhes da cobrança](/docs/Detalhes_cobrança.png)

## 🔄 Integrações

### 🏦 Sicredi

Integração completa com o sistema de pagamentos do Sicredi, permitindo:
- Geração de QR Codes para pagamentos via Pix
- Recebimento de notificações de pagamento em tempo real
- Consulta de status de transações
- Emissão de comprovantes

### 💼 ERP Sênior

Conexão bidirecional com o ERP Sênior para:
- Sincronização automática de dados financeiros
- Registro de transações no sistema contábil
- Conciliação bancária automatizada
- Gestão de fluxo de caixa integrada

### 🌱 Sistema de Crédito Rural (SCR)

Integração com o Sistema de Crédito Rural da Emater-RS/ASCAR:
- Facilitação de pagamentos relacionados a crédito rural
- Rastreamento de transações por projeto/produtor
- Geração de relatórios específicos para prestação de contas
- Automatização de processos financeiros do setor agrícola

### 📊 Sistema de Classificação (SISCLAS) da Emater-RS/ASCAR

Automatização da classificação de produtos agrícolas:
- Vinculação de pagamentos a produtos classificados
- Rastreabilidade financeira por categoria de produto
- Relatórios de desempenho por classificação
- Otimização do processo de comercialização

## 👨‍💻 Criador

Este projeto foi desenvolvido por **Felipe Elemar Scholl**, Analista de Sistemas da Emater-RS/ASCAR, com foco em proporcionar uma solução eficiente para a gestão de pagamentos via Pix, integrada aos sistemas internos da instituição.

## 🤝 Contribuição

Leia nosso [guia de contribuição](CONTRIBUTING.md) para detalhes sobre como contribuir com o projeto.

## 📄 Licença

Este projeto está licenciado sob a [Licença MIT](LICENSE).
