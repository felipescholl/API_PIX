<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CobrancaController;
use App\Http\Controllers\CobrancaController as CobrancaControllerWeb;
use App\Http\Controllers\Api\WebhookController;
use Illuminate\Support\Facades\Log;

// Rotas que precisam de autenticação via API Key (para sistemas internos)
Route::middleware(['api', 'api.key'])->group(function () {
    // Rota para gerar cobrança SCR
    Route::post('/cobrancas/gerar-scr', [CobrancaController::class, 'gerarCobrancaSCR']);
    Route::post('/cobrancas/gerar-sisclass', [CobrancaController::class, 'gerarCobrancaSisclass']);
    
    // Cancelar título
    Route::post('/cobrancas/excluir/{numTit}', [CobrancaController::class, 'excluirTitulo']);

    // Consultar título
    Route::get('/cobrancas/consultar/{numTit}', [CobrancaController::class, 'consultarTitulo']);
    
    Route::get('/verificarExpiracao', [CobrancaControllerWeb::class, 'cancelarNaExpiracao'])->name('cancelarNaExpiracao');
});

// Rotas públicas (webhook não precisa de autenticação)
Route::middleware('api')->group(function () {
    // Webhook Sicredi
    // Se estiver em ambiente de desenvolvimento, aceitar sem validar o certificado 
    
    // Validação de local esta sendo feita dentro do middleware
    if (env('APP_ENV') == 'local') {    
        Route::post('/webhook/sicredi', [WebhookController::class, 'handleSicrediWebhook'])
            ->name('webhook.sicredi');
    } else {
        Route::post('/webhook/sicredi', [WebhookController::class, 'handleSicrediWebhook'])
            ->middleware(['validate.sicredi.webhook'])
            ->name('webhook.sicredi');
    }
});