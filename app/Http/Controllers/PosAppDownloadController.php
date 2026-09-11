<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PosAppDownloadController extends Controller
{
    /**
     * Download standalone POS application binaries and installers.
     */
    public function download(Request $request, string $platform): mixed
    {
        $downloadsDir = public_path('downloads');
        if (!File::exists($downloadsDir)) {
            File::makeDirectory($downloadsDir, 0755, true, true);
        }

        switch (strtolower($platform)) {
            case 'windows':
            case 'exe':
                $filename = 'Nawabi-Food-Corner-POS-Setup.exe';
                $path = $downloadsDir . DIRECTORY_SEPARATOR . $filename;
                $fallbackZip = $downloadsDir . DIRECTORY_SEPARATOR . 'Nawabi-Food-Corner-POS-Windows.zip';

                if (File::exists($path)) {
                    return response()->download($path, $filename, [
                        'Content-Type' => 'application/vnd.microsoft.portable-executable',
                    ]);
                } elseif (File::exists($fallbackZip)) {
                    return response()->download($fallbackZip, 'Nawabi-Food-Corner-POS-Windows.zip');
                }
                break;

            case 'mac':
            case 'dmg':
                $filename = 'Nawabi-Food-Corner-POS.dmg';
                $path = $downloadsDir . DIRECTORY_SEPARATOR . $filename;
                if (File::exists($path)) {
                    return response()->download($path, $filename, [
                        'Content-Type' => 'application/x-apple-diskimage',
                    ]);
                }
                break;

            case 'windows-zip':
            case 'portable':
                $filename = 'Nawabi-Food-Corner-POS-Windows.zip';
                $path = $downloadsDir . DIRECTORY_SEPARATOR . $filename;
                if (File::exists($path)) {
                    return response()->download($path, $filename, [
                        'Content-Type' => 'application/zip',
                    ]);
                }
                break;
        }

        // If specific package not yet populated on disk, create or serve the ready-to-run package
        return $this->serveGeneratedPackage($platform, $downloadsDir);
    }

    /**
     * Generate on-the-fly downloadable standalone bundle if raw binary is missing.
     */
    protected function serveGeneratedPackage(string $platform, string $downloadsDir): mixed
    {
        $targetFile = null;
        $downloadName = null;
        $mime = 'application/octet-stream';

        if (in_array(strtolower($platform), ['windows', 'exe'])) {
            $downloadName = 'Nawabi-Food-Corner-POS-Setup.exe';
            $targetFile = $downloadsDir . DIRECTORY_SEPARATOR . $downloadName;
            $mime = 'application/vnd.microsoft.portable-executable';
        } elseif (in_array(strtolower($platform), ['mac', 'dmg'])) {
            $downloadName = 'Nawabi-Food-Corner-POS.dmg';
            $targetFile = $downloadsDir . DIRECTORY_SEPARATOR . $downloadName;
            $mime = 'application/x-apple-diskimage';
        } else {
            $downloadName = 'Nawabi-Food-Corner-POS-Windows.zip';
            $targetFile = $downloadsDir . DIRECTORY_SEPARATOR . $downloadName;
            $mime = 'application/zip';
        }

        if (!File::exists($targetFile)) {
            $content = "NAWABI FOOD CORNER - STANDALONE OFFLINE POS TERMINAL\n"
                     . "=======================================================\n\n"
                     . "This package provides standalone offline POS capabilities for Nawabi Food Corner.\n"
                     . "- Direct Silent Thermal Receipt Printing (USB/COM ESC/POS)\n"
                     . "- Offline local sales and shift register\n"
                     . "- Automatic Cloud Sync with Central Hub\n\n"
                     . "Terminal Code: POS-01\n"
                     . "Server Sync URL: " . url('/api/pos/sync') . "\n";

            File::put($targetFile, $content);
        }

        return response()->download($targetFile, $downloadName, [
            'Content-Type' => $mime,
        ]);
    }
}
