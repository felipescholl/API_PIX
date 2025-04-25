<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiKeyAuth
{
    /**
     * Manipula a solicitação recebida.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('X-API-KEY');
        
        // Verifica se a API key foi fornecida
        if (!$apiKey) {
            return response()->json(['error' => 'API key não fornecida'], 401);
        }
        
        // Lista de API keys válidas
        $validApiKeys = [
            'SCR' => env('API_KEY_SCR'),
            'CLA' => env('API_KEY_SISCLAS'),
        ];
        
        // Verifica se a API key é válida
        if (!in_array($apiKey, $validApiKeys)) {
            Log::warning('Tentativa de acesso com API key inválida', ['ip' => $request->ip()]);
            return response()->json(['error' => 'API key inválida'], 403);
        }
        
        // Identifica qual sistema está fazendo a requisição (opcional)
        $sistema = array_search($apiKey, $validApiKeys);
        $request->attributes->add(['sistemaOrigem' => $sistema]);
        
        return $next($request);
    }
}