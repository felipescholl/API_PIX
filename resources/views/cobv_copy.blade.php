<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PIX - Cobrança</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold text-center mb-6">Cobrança PIX</h1>
            
            <div class="flex flex-col items-center space-y-6">
                <!-- QR Code -->
                <div class="qr-code-container p-4 bg-gray-50 rounded-lg">
                    <!-- //<?php if (isset($qrcode)): ?> -->
                        <img src="public/qrcode_<?php echo $txid; ?>.svg" alt="QR Code PIX" class="mx-auto" type="image/svg+xml">
                    <!-- //<?php endif; ?> -->
                </div>

                <!-- PIX Copia e Cola -->
                <div class="w-full">
                    <h2 class="text-lg font-semibold mb-2">PIX Copia e Cola</h2>
                    <div class="relative">
                        <input type="text" 
                               id="pixCopyCola" 
                               value="<?php echo isset($resposta['pixCopiaECola']) ? $resposta['pixCopiaECola'] : ''; ?>" 
                               class="w-full p-3 border rounded-lg pr-24 bg-gray-50"
                               readonly>
                        <button onclick="copyPixCode()" 
                                class="absolute right-2 top-2 bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600">
                            Copiar
                        </button>
                    </div>
                </div>

                <!-- Informações da Transação -->
                <div class="w-full space-y-4">
                    <div class="border-t pt-4">
                        <h2 class="text-lg font-semibold mb-4">Detalhes da Transação</h2>
                        <dl class="grid grid-cols-1 gap-3">
                            <div class="flex justify-between py-2 px-4 bg-gray-50 rounded">
                                <dt class="font-medium">TXID:</dt>
                                <dd><?php echo isset($txid) ? $txid : ''; ?></dd>
                            </div>
                            <div class="flex justify-between py-2 px-4 bg-gray-50 rounded">
                                <dt class="font-medium">Valor:</dt>
                                <dd>R$ <?php echo isset($resposta['valor']['original']) ? number_format($resposta['valor']['original'], 2, ',', '.') : '0,00'; ?></dd>
                            </div>
                            <div class="flex justify-between py-2 px-4 bg-gray-50 rounded">
                                <dt class="font-medium">Vencimento:</dt>
                                <dd><?php echo isset($resposta['calendario']['dataDeVencimento']) ? date('d/m/Y', strtotime($resposta['calendario']['dataDeVencimento'])) : ''; ?></dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyPixCode() {
            const pixInput = document.getElementById('pixCopyCola');
            pixInput.select();
            document.execCommand('copy');
            
            // Feedback visual
            const button = event.target;
            const originalText = button.textContent;
            button.textContent = 'Copiado!';
            button.classList.remove('bg-blue-500');
            button.classList.add('bg-green-500');
            
            setTimeout(() => {
                button.textContent = originalText;
                button.classList.remove('bg-green-500');
                button.classList.add('bg-blue-500');
            }, 2000);
        }
    </script>
</body>
</html> 