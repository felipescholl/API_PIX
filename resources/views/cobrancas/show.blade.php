@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalhes da Cobrança</h1>
    <p><strong>TXID:</strong> {{ $cobranca->txid }}</p>
    <p><strong>Nome do Pagador:</strong> {{ $cobranca->nome_pagador }}</p>
    <p><strong>Valor:</strong> R$ {{ number_format($cobranca->valor, 2, ',', '.') }}</p>
    <p><strong>Data de Vencimento:</strong> {{ $cobranca->data_vencimento->format('d/m/Y') }}</p>
    <p><strong>Status:</strong> {{ $cobranca->status }}</p>
    <p><strong>Data de Pagamento:</strong> {{ $cobranca->data_pagamento ? $cobranca->data_pagamento->format('d/m/Y H:i') : 'Não pago' }}</p>
    <a href="{{ route('cobrancas.index') }}" class="btn btn-primary">Voltar</a>
</div>
@endsection