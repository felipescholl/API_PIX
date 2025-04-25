<!-- filepath: /n:/dev/docker/pix/resources/views/emails/error_notification.blade.php -->

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $details['tipo_erro'] }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #d9534f;
            font-size: 24px;
            margin-bottom: 20px;
            justify-content: center;
            text-align: center;
        }
        p {
            font-size: 16px;
            line-height: 1.6;
            margin: 10px 0;
        }
        .details {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .details p {
            margin: 5px 0;
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>{{ $details['tipo_erro'] }}</h1>
        <div class="details">
            <p><strong>Erro:</strong> {{ $details['error'] ?? 'N/A'}}</p>
            <p><strong>TXID:</strong> {{ $details['txid'] ?? 'N/A' }}</p>
            <p><strong>Empresa:</strong> {{ $details['codEmp'] ?? 'N/A' }}</p>
            <p><strong>Filial:</strong> {{ $details['codFil'] ?? 'N/A' }}</p>
            <p><strong>Número do Título:</strong> {{ $details['numTit'] ?? 'N/A' }}</p>
            <p><strong>End to End ID:</strong> {{ $details['endToEndId'] ?? 'N/A' }}</p>
            <p><strong>Horário:</strong> {{ $details['horario'] ?? 'N/A' }}</p>
            <p><strong>CPF/CNPJ:</strong> {{ $details['cpfCnpj'] ?? 'N/A' }}</p>
            <p><strong>Código do Tipo de Título:</strong> {{ $details['codTpt'] ?? 'N/A' }}</p>
            <p><strong>Valor:</strong> {{ $details['valor'] ?? 'N/A' }}</p>
            <p><strong>Descrição:</strong> {{ $details['descricao'] ?? 'N/A' }}</p>
        </div>
        <div class="footer">
            <p>Este é um e-mail automático, por favor não responda.</p>
        </div>
    </div>
</body>
</html>