<?php

namespace App\Services;

use chillerlan\QRCode\QRCode as QRCode;
use chillerlan\QRCode\QROptions;

class GeradorCode
{
    public static function qrcode($codpix, $txid)
    {
        $options = new QROptions;
        $options->outputType = QRCode::OUTPUT_MARKUP_SVG;
        $options->imageBase64 = true;

        $options2 = new QROptions;
        $options2->imageBase64 = false;

        // Criar a imagem do QR Code no diretório public com o nome qrcode_<txid>.svg
        $qrcodeimg = (new QRCode($options2))->render($codpix);
        file_put_contents(public_path('/qrcode/qrcode_' . $txid . '.svg'), $qrcodeimg);

        return (new QRCode($options))->render($codpix);
    }
}