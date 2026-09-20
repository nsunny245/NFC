<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PosAppDownloadController extends Controller
{
    /**
     * Download standalone POS application packages and offline suites.
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
            case 'windows-zip':
            case 'portable':
                $zipPath = $downloadsDir . DIRECTORY_SEPARATOR . 'Nawabi-Food-Corner-POS-Windows.zip';
                if (File::exists($zipPath)) {
                    return response()->download($zipPath, 'Nawabi-Food-Corner-POS-Windows.zip', [
                        'Content-Type' => 'application/zip',
                    ]);
                }
                break;

            case 'mac':
            case 'dmg':
            case 'mac-zip':
                $realDmg = $downloadsDir . DIRECTORY_SEPARATOR . 'Nawabi-Food-Corner-POS.dmg';
                // Only serve DMG if it is a real disk image binary (> 10MB), not a text stub
                if (File::exists($realDmg) && File::size($realDmg) > 10000000) {
                    return response()->download($realDmg, 'Nawabi-Food-Corner-POS.dmg', [
                        'Content-Type' => 'application/x-apple-diskimage',
                    ]);
                }

                $macZip = $downloadsDir . DIRECTORY_SEPARATOR . 'Nawabi-Food-Corner-POS-Mac.zip';
                if (File::exists($macZip)) {
                    return response()->download($macZip, 'Nawabi-Food-Corner-POS-Mac.zip', [
                        'Content-Type' => 'application/zip',
                    ]);
                }
                break;

            case 'kiosk':
            case 'html':
            case 'offline':
                $kioskHtml = $downloadsDir . DIRECTORY_SEPARATOR . 'pos-offline-kiosk.html';
                if (File::exists($kioskHtml)) {
                    return response()->download($kioskHtml, 'Nawabi-Food-Corner-POS-Offline.html', [
                        'Content-Type' => 'text/html',
                    ]);
                }
                break;
        }

        // Default fallback: serve Windows or Mac suite
        $fallback = $downloadsDir . DIRECTORY_SEPARATOR . 'Nawabi-Food-Corner-POS-Windows.zip';
        if (File::exists($fallback)) {
            return response()->download($fallback, 'Nawabi-Food-Corner-POS-Windows.zip', [
                'Content-Type' => 'application/zip',
            ]);
        }

        return redirect('/pos')->with('status', 'POS Terminal is directly accessible in your browser.');
    }
}
