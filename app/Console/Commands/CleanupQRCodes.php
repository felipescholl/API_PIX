<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CleanupQRCodes extends Command
{
    protected $signature = 'cleanup:qrcodes';
    protected $description = 'Delete QR code files older than one week';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $directory = public_path('qrcode');
        $files = File::files($directory);
        $now = time();

        foreach ($files as $file) {
            if ($file->getExtension() === 'svg') {
                $fileCreationTime = $file->getCTime();
                $fileAge = ($now - $fileCreationTime) / (60 * 60 * 24); // idade do arquivo em dias

                if ($fileAge > 7) {
                    File::delete($file->getRealPath()); // apaga o arquivo se tiver mais de uma semana
                }
            }
        }

        $this->info('Old QR code files deleted successfully.');
    }
}
?>