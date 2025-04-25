<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ValidateSicrediWebhook
{
    public function handle(Request $request, Closure $next)
    {
        
        // Caso esteja em ambiente de desenvolvimento, aceitar sem validar o certificado
        if (env('APP_ENV') == 'local')
        {
             return $next($request);
                
            try {
                Log::info('Iniciando validação (local) do certificado Sicredi');
        
                // Obtém o certificado do cabeçalho (se enviado)
                $certificate = $request->header('X-Certificate') ?? ($_SERVER['SSL_CLIENT_CERT'] ?? null);
                
                if (!$certificate) {
                    Log::warning('L-VSW-01: Certificado não encontrado');
                    return response()->json(['error' => 'L-VSW-01: Certificado não encontrado'], 401);
                }
        
                // Removendo caracteres indesejados
                $certificate = str_replace(["\n", "\r", " "], '', $certificate);
        
                // Decodifica o certificado Base64
                $certData = base64_decode($certificate);
                if (!$certData) {
                    Log::warning('L-VSW-02: Certificado inválido - Não é Base64');
                    return response()->json(['error' => 'L-VSW-02: Certificado inválido - Não é Base64'], 401);
                }
        
                // Carrega e valida o certificado
                $cert = openssl_x509_read($certData);
                if (!$cert) {
                    Log::warning('L-VSW-03: Certificado inválido - Não é um X.509');
                    return response()->json(['error' => 'L-VSW-03: Certificado inválido - Não é um X.509'], 401);
                }
        
                // Caminho do certificado raiz do Sicredi
                $sicrediCaPath = env('PIX_SICREDI_CERTIFICATE');
        
                if (!file_exists($sicrediCaPath)) {
                    Log::error('L-VSW-04: Certificado CA do Sicredi não encontrado no servidor');
                    return response()->json(['error' => 'Erro interno na validação do certificado'], 500);
                }
        
                // Carrega a CA do Sicredi
                $sicrediCa = file_get_contents($sicrediCaPath);
                $caCert = openssl_x509_read($sicrediCa);
        
                if (!$caCert) {
                    Log::error('L-VSW-05: Erro ao carregar o certificado da CA do Sicredi');
                    return response()->json(['error' => 'Erro interno na validação do certificado'], 500);
                }
        
                // Verifica se o certificado recebido foi assinado pela CA do Sicredi
                $valid = openssl_x509_verify($cert, $caCert);
        
                if ($valid !== 1) {
                    Log::warning('L-VSW-06: Certificado não é assinado pelo Sicredi');
                    return response()->json(['error' => 'L-VSW-06: Certificado não é assinado pelo Sicredi'], 401);
                }
        
                // Adiciona o certificado ao request para uso posterior
                $request->attributes->add(['sicredi_certificate' => $cert]);
        
                Log::info('Certificado validado com sucesso');
        
                return response()->json(['message' => 'Certificado válido'], 200);

            } catch (\Exception $e) {

                Log::error('Erro ao validar certificado: ' . $e->getMessage());
                return response()->json(['error' => 'Erro ao validar certificado'], 500);

            }

        } else {

            return $this->validateMTLSCertificate($request, $next);

            // try {
            //     Log::info('Produção - Validando certificado');
            //     // Verifica se o certificado está presente
            //     $certificate = $request->header('X-Certificate');

            //     Log::info($request->all());
            //     Log::info($request->header());

            //     if (!$certificate) {
            //         Log::warning('L-VSW-07 Certificado não encontrado');
            //         return response()->json(['error' => 'L-VSW-07 Certificado não encontrado'], 401);
            //     }

            //     // Decodifica o certificado
            //     $certData = base64_decode($certificate);
            //     if (!$certData) {
            //         Log::warning('Certificado inválido - não é base64');
            //         return response()->json(['error' => 'Certificado inválido - não é base64'], 401);
            //     }

            //     // Carrega e valida o certificado
            //     $cert = openssl_x509_read($certData);
            //     if (!$cert) {
            //         Log::warning(' Certificado inválido - não é um certificado X509');
            //         return response()->json(['error' => 'Certificado inválido - não é um certificado X509'], 401);
            //     }

            //     // Adiciona informações do certificado ao request
            //     $request->attributes->add([
            //         'sicredi_certificate' => $cert
            //     ]);

            //     return $next($request);

            // } catch (\Exception $e) {

            //     Log::error('Erro ao validar certificado: ' . $e->getMessage());
            //     return response()->json(['error' => 'Erro ao validar certificado'], 500);

            // }
        }
    }

    function validateMTLSCertificate(Request $request, $next) {
        try {
                Log::info('Produção - Validando certificado mTLS');
                Log::info('Variáveis SERVER:', [
                    'SSL_CLIENT_CERT' => $_SERVER['SSL_CLIENT_CERT'] ?? 'UNDEFINED',
                    'SSL_CLIENT_VERIFY' => $_SERVER['SSL_CLIENT_VERIFY'] ?? 'NONE',
                    'X-SSL-Client-Cert' => $request->header('X-SSL-Client-Cert') ?? 'UNDEFINED',
                    'X-SSL-Client-Verify' => $request->header('X-SSL-Client-Verify') ?? 'NONE'
                ]);
    
            // 1. Verificar presença do certificado
            if (empty($_SERVER['SSL_CLIENT_CERT']) || empty($_SERVER['X-SSL-Client-Cert'])) {
                Log::warning('L-VSW-07 Certificado mTLS não encontrado na conexão');
                return response()->json(['error' => 'L-VSW-07 Certificado mTLS não encontrado'], 403);
            }
    
            $clientCert = $_SERVER['SSL_CLIENT_CERT'] ?? $request->header('X-SSL-Client-Cert');
    
            // // 2. Validar formato PEM
            // if (strpos($clientCert, '-----BEGIN CERTIFICATE-----') === false) {
            //     Log::warning('Certificado inválido - formato inesperado');
            //     return response()->json(['error' => 'E-VSW-11 Formato de certificado inválido'], 403);
            // }
    
            // 3. Decodificar certificado
            $cert = openssl_x509_read($clientCert);
            if (!$cert) {
                Log::warning('Certificado inválido - erro de decodificação');
                return response()->json(['error' => 'E-VSW-12 Certificado não decodificável'], 403);
            }
    
            // 4. Extrair metadados
            $certInfo = openssl_x509_parse($cert);
            if (!$certInfo) {
                Log::warning('Falha ao extrair metadados do certificado');
                return response()->json(['error' => 'E-VSW-13 Metadados inválidos'], 403);
            }
    
            // 5. Validar expiração
            if ($certInfo['validTo_time_t'] < time()) {
                Log::warning('Certificado expirado', ['validTo' => $certInfo['validTo']]);
                return response()->json(['error' => 'E-VSW-14 Certificado expirado'], 403);
            }
    
            // 6. Validar CA Sicredi (arquivo deve estar em local seguro)
            // Caminho do certificado raiz do Sicredi
            $sicrediCaPath = env('PIX_SICREDI_CERTIFICATE');
            
            if (!file_exists($sicrediCaPath)) {
                Log::error('L-VSW-04: Certificado CA do Sicredi não encontrado no servidor');
                return response()->json(['error' => 'Erro interno na validação do certificado'], 500);
            }
    
            $caCert = file_get_contents($sicrediCaPath);
            $isCAValid = openssl_x509_checkpurpose($cert, X509_PURPOSE_SSL_CLIENT, [$caCert]);
            
            if (!$isCAValid) {
                Log::warning('Emissor não confiável', [
                    'esperado' => 'Sicredi CA',
                    'recebido' => $certInfo['issuer']['CN']
                ]);
                return response()->json(['error' => 'E-VSW-15 Certificado não confiável'], 403);
            }
    
            // 7. Verificação de revogação (OCSP - Exemplo simplificado)
            if (!$this->checkOCSPRevocation($clientCert, $caCert)) {
                Log::warning('Certificado revogado via OCSP');
                return response()->json(['error' => 'E-VSW-16 Certificado revogado'], 403);
            }
    
            // Adicionar dados ao request (sem expor dados sensíveis)
            $request->attributes->add([
                'certificate_info' => [
                    'subject' => $certInfo['subject'],
                    'issuer' => $certInfo['issuer'],
                    'expiration' => date('Y-m-d H:i:s', $certInfo['validTo_time_t'])
                ]
            ]);
    
            Log::info('Validação mTLS bem-sucedida');
            return $next($request);
    
        } catch (\Exception $e) {
            Log::error('Falha crítica na validação: ' . $e->getMessage());
            return response()->json(['error' => 'E-VSW-99 Erro interno na validação'], 500);
        }
    }
    
    private function checkOCSPRevocation($clientCert, $caCert) {
        // Implementação real deve usar biblioteca como phpseclib
        // Consulte a documentação do Sicredi para endpoints OCSP
        return true; // Remover em produção
    }
}
