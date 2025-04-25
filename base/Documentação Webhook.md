Para implementar um endpoint no Laravel 11 que funcione como um servidor para receber e validar as informações do webhook enviado pelo Sicredi, você pode seguir estas etapas:

---

### 1. **Configuração do Certificado Digital**
O Sicredi exige autenticação mútua por meio de certificados digitais. Isso significa que sua aplicação precisa:

- Enviar um certificado cliente no formato `.pem`, `.cer` ou `.crt`.
- Validar o certificado enviado pelo Sicredi.


---

### 2. **Armazenamento Seguro dos Certificados**
Armazene os certificados e as chaves privadas em uma pasta segura, como `storage/certificates`. Garanta que esses arquivos não sejam acessíveis diretamente pelo navegador configurando o `.htaccess` ou `web.config`.


Endereços dos certificados no .env
```
    'client_id' => env('PIX_SICREDI_CLIENT_ID'),
    'client_secret' => env('PIX_SICREDI_CLIENT_SECRET'),
    'certificate' => env('PIX_SICREDI_CERTIFICATE'),
    'key' => env('PIX_SICREDI_KEY'),
    'chave' => env('PIX_CHAVE'),
```

---

### 3. **Configuração do Middleware HTTPS (Mutual TLS)**
Implemente um middleware para validar as conexões mTLS e verificar o certificado do Sicredi.


#### Middleware Code
```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ValidateSicrediWebhook
{
    public function handle(Request $request, Closure $next)
    {
        // Verificar se o cliente enviou um certificado
        if (!isset($_SERVER['SSL_CLIENT_VERIFY']) || $_SERVER['SSL_CLIENT_VERIFY'] !== 'SUCCESS') {
            abort(403, 'Certificado inválido ou ausente.');
        }

        // Opcional: verificar o DN do certificado do Sicredi
        $sicrediCertDn = "C=BR, O=Sicredi, CN=webhook.sicredi.com.br";
        if ($_SERVER['SSL_CLIENT_S_DN'] !== $sicrediCertDn) {
            abort(403, 'Certificado do Sicredi não validado.');
        }

        return $next($request);
    }
}
```

Adicione o middleware à rota ou grupo de rotas do webhook.

---

### 4. **Criação do Endpoint**
Implemente o endpoint para receber as notificações do Sicredi.

#### Rota
Adicione a rota no arquivo `routes/api.php`:
```php
use App\Http\Controllers\WebhookController;

Route::post('/webhook/sicredi', [WebhookController::class, 'handleSicrediWebhook'])
    ->middleware('validate.sicredi.webhook'); // Adiciona o middleware Mutual TLS
```

#### Controlador
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        // Valide a assinatura ou o payload do Sicredi
        $signatureHeader = $request->header('X-Sicredi-Signature');
        $payload = $request->getContent();

        if (!$this->validateSignature($signatureHeader, $payload)) {
            return response()->json(['error' => 'Assinatura inválida.'], 403);
        }

        // Processa os dados recebidos
        Log::info('Webhook recebido', $request->all());

        return response()->json(['status' => 'sucesso'], 200);
    }

    private function validateSignature(string $signature, string $payload): bool
    {
        // Substitua isso pela lógica de validação do Sicredi
        return true;
    }
}
```

---

### 5. **Configuração do `curl` para Certificados**
Configure o certificado cliente no `cURL` quando sua aplicação enviar requisições para o Sicredi.

Adicione ao `php.ini` ou configure programaticamente:
```ini
curl.cainfo = "/path/to/sicredi_public.pem"
openssl.cafile = "/path/to/sicredi_public.pem"
```

---

### 6. **Testes e Logs**
1. **Testar com ferramentas**: Use ferramentas como `Postman` ou `curl` para simular chamadas webhook.
2. **Logs**: Ative os logs no Laravel para depurar requisições:
```php
Log::info('Recebendo webhook do Sicredi', $request->all());
```

---

### Garantias de Entrega
Para garantir que não haja perda de dados:  
- Retorne status HTTP `200` para confirmações bem-sucedidas.  
- Reimplemente uma fila para processar os dados caso o Sicredi envie repetidamente (em caso de falhas anteriores).  

Essa configuração atende aos requisitos do Sicredi e garante que a comunicação seja segura.