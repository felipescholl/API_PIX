Para configurar um servidor em PHP 7.4 e Laravel 8 para receber Webhooks do Banco Sicredi na API Pix, as principais características e especificações são:

### Requisitos Técnicos
1. **HTTPS e TLS:**
   - O servidor deve operar com HTTPS, utilizando TLS na porta 443.
   - O certificado deve ser assinado por uma CA pública reconhecida (ex.: Digicert, Entrust, GlobalSign).
   - O atributo CN do certificado deve corresponder ao nome do domínio do servidor.

2. **Certificados e Autenticação:**
   - Utilize certificados disponibilizados pelo Sicredi (cadeia completa).
   - Inclua o certificado `webhook-sicredi.CER` para validar as chamadas recebidas, caso opte por essa segurança adicional.
   - Configure a autenticação mTLS para a comunicação com o Sicredi.

3. **Endpoint do Webhook:**
   - Configure o endpoint no formato `PUT /webhook/{chave}` para registrar o Webhook.
   - A URL deve ser indicada no body do request sob o campo `webhookUrl`.
   - O Webhook será acionado apenas para transações associadas a uma chave Pix vinculada ao webhook cadastrado.

4. **Segurança e Boas Práticas:**
   - Mantenha os arquivos de chave privada e certificados em local seguro.
   - Evite configurar a chave privada com senha, pois algumas ferramentas podem não suportá-la.
   - Recomenda-se entender e configurar adequadamente conexões mTLS (autenticação mútua via TLS).

### Requisitos de Software e Frameworks
1. **Laravel 8:**
   - Configure as rotas para receber as notificações no formato JSON e autentique conforme necessário.
   - Utilize middlewares para verificar o certificado e autenticação das requisições recebidas.

2. **Banco de Dados:**
   - Estruture o banco para armazenar as notificações recebidas, associando-as ao txid ou chave Pix.

3. **Bibliotecas de Suporte:**
   - Utilize uma biblioteca para manipular certificados (ex.: `league/oauth2-server` ou similar).
   - Configure o ambiente de desenvolvimento para gerar logs detalhados em caso de falhas nas requisições recebidas.

----

Com base nas informações fornecidas no guia técnico do Sicredi e na documentação do Banco Central, a especificação do endpoint para receber notificações de Webhook do Banco Sicredi é a seguinte:

---

### **Especificação do Endpoint**
1. **Método HTTP:**
   - **POST** - O Sicredi enviará notificações utilizando este método para o endpoint configurado.

2. **URL do Endpoint:**
   - A URL deve ser configurada durante o cadastro do Webhook no Sicredi.
   - Formato típico:
     ```
     https://seuservidor.com.br/webhook/sicredi
     ```

3. **Headers:**
   - Os headers comuns incluídos na requisição serão:
     - `Content-Type: application/json` (para indicar o formato da mensagem).
     - Headers adicionais relacionados à autenticação podem ser configurados, como tokens.

4. **Payload (Body da Requisição):**
   - A notificação será enviada no formato JSON e incluirá os seguintes campos principais:
     - `endToEndId`: Identificador único da transação (proveniente do Banco Central).
     - `chave`: Chave Pix associada à transação.
     - `valor`: Valor da transação.
     - `horario`: Data e hora da transação no formato ISO 8601 (ex.: `2025-01-16T12:00:00Z`).
     - `status`: Status da transação (ex.: `CONCLUIDA` ou `DEVOLVIDA`).

     Exemplo de Payload:
     ```json
     {
       "endToEndId": "E1234567890123456789012345678901",
       "chave": "email@dominio.com",
       "valor": "150.00",
       "horario": "2025-01-16T12:00:00Z",
       "status": "CONCLUIDA"
     }
     ```

5. **Resposta Esperada do Servidor:**
   - O servidor deve retornar um status **HTTP 200 OK** para confirmar o recebimento e processamento da notificação.
   - Caso contrário, o Sicredi pode tentar reenviar a notificação em um intervalo de tempo pré-definido.

6. **Autenticação e Segurança:**
   - **mTLS:** Utilize autenticação mútua TLS para validar a origem da requisição.
   - **Tokens ou Assinatura Digital:** O Sicredi pode incluir assinaturas digitais ou tokens para garantir a autenticidade, que devem ser validados no servidor.

7. **Configuração do Webhook:**
   - Durante o registro do Webhook, informe:
     - URL do endpoint.
     - Escopos e chaves associados à notificação.

8. **Observações:**
   - Certifique-se de que o endpoint seja idempotente, ou seja, ele deve poder processar a mesma notificação mais de uma vez sem causar inconsistências.

---
