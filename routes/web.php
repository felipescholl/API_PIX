<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CobrancaController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\ConfiguracaoController;
use App\Services\SeniorsService;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Clientes
    Route::resource('clientes', ClienteController::class);
    
    // Cobranças
    Route::get('/cobrancas', [CobrancaController::class, 'index'])->name('cobrancas.index');
    Route::get('/cobrancas/create', [CobrancaController::class, 'create'])->name('cobrancas.create');
    Route::post('/cobrancas', [CobrancaController::class, 'store'])->name('cobrancas.store');
    Route::get('/cobrancas/{cobranca}', [CobrancaController::class, 'show'])->name('cobrancas.show');
    Route::get('/cobrancas/export', [CobrancaController::class, 'export'])->name('cobrancas.export');

    Route::get('/cobrancas/verificar/{txid}', [CobrancaController::class, 'verificar'])->name('cobrancas.verificar');
    
    Route::get('/verificarVencidas', [ CobrancaController::class, 'verificarNoVencimento'])->name('verificarVencidas');

    Route::get('/cobrancas/cancelar/{txid}', [CobrancaController::class, 'cancelar']);
    Route::get('/cobrancas/location/{txid}', [CobrancaController::class, 'location'])->name('cobrancas.location');

    Route::get('/verificarExpiracao', [CobrancaController::class, 'cancelarNaExpiracao'])->name('cancelarNaExpiracao');
    
    // Relatórios
    Route::get('/relatorios', [RelatorioController::class, 'index'])->name('relatorios.index');
    Route::post('/relatorios/gerar', [RelatorioController::class, 'gerarRelatorio'])->name('relatorios.gerar');
    
    // Configurações
    Route::get('/configuracoes', [ConfiguracaoController::class, 'index'])->name('configuracoes.index');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
