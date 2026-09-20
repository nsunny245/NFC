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
            case 'windows-modern':
                $installer = $downloadsDir . DIRECTORY_SEPARATOR . 'Nawabi-Food-Corner-POS-Windows-10-11-x64-Setup.exe';
                if (File::exists($installer)) {
                    return response()->download($installer, basename($installer), [
                        'Content-Type' => 'application/vnd.microsoft.portable-executable',
                    ]);
                }
                return $this->fallbackSuite($downloadsDir, 'windows');

            case 'windows-legacy':
            case 'windows-7':
            case 'windows-8':
                $installer = $downloadsDir . DIRECTORY_SEPARATOR . 'Nawabi-Food-Corner-POS-Windows-7-8-Setup.exe';
                if (File::exists($installer)) {
                    return response()->download($installer, basename($installer), [
                        'Content-Type' => 'application/vnd.microsoft.portable-executable',
                    ]);
                }
                return $this->fallbackSuite($downloadsDir, 'windows');

            case 'windows-zip':
                $zipPath = $downloadsDir . DIRECTORY_SEPARATOR . 'Nawabi-Food-Corner-POS-Windows.zip';
                if (File::exists($zipPath)) {
                    return response()->download($zipPath, basename($zipPath), ['Content-Type' => 'application/zip']);
                }
                break;

            case 'portable':
                $portable = $downloadsDir . DIRECTORY_SEPARATOR . 'Nawabi-Food-Corner-POS-Windows-10-11-x64-Portable.exe';
                if (File::exists($portable)) {
                    return response()->download($portable, basename($portable), [
                        'Content-Type' => 'application/vnd.microsoft.portable-executable',
                    ]);
                }
                return $this->fallbackSuite($downloadsDir, 'windows');

            case 'mac':
            case 'dmg':
            case 'mac-arm64':
            case 'apple-silicon':
                $realDmg = $downloadsDir . DIRECTORY_SEPARATOR . 'Nawabi-Food-Corner-POS-macOS-Apple-Silicon.dmg';
                if (File::exists($realDmg) && File::size($realDmg) > 10000000) {
                    return response()->download($realDmg, basename($realDmg), [
                        'Content-Type' => 'application/x-apple-diskimage',
                    ]);
                }
                return $this->fallbackSuite($downloadsDir, 'mac');

            case 'mac-intel':
            case 'mac-x64':
                $realDmg = $downloadsDir . DIRECTORY_SEPARATOR . 'Nawabi-Food-Corner-POS-macOS-Intel.dmg';
                if (File::exists($realDmg) && File::size($realDmg) > 10000000) {
                    return response()->download($realDmg, basename($realDmg), [
                        'Content-Type' => 'application/x-apple-diskimage',
                    ]);
                }
                return $this->fallbackSuite($downloadsDir, 'mac');

            case 'mac-zip':
                $macZip = $downloadsDir . DIRECTORY_SEPARATOR . 'Nawabi-Food-Corner-POS-Mac.zip';
                if (File::exists($macZip)) {
                    return response()->download($macZip, basename($macZip), ['Content-Type' => 'application/zip']);
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

        $fallback = $downloadsDir . DIRECTORY_SEPARATOR . 'Nawabi-Food-Corner-POS-Windows-10-11-x64-Setup.exe';
        if (File::exists($fallback)) {
            return response()->download($fallback, basename($fallback), [
                'Content-Type' => 'application/vnd.microsoft.portable-executable',
            ]);
        }

        return redirect('/pos')->with('status', 'POS Terminal is directly accessible in your browser.');
    }

    private function fallbackSuite(string $downloadsDir, string $platform): mixed
    {
        $filename = $platform === 'mac'
            ? 'Nawabi-Food-Corner-POS-Mac.zip'
            : 'Nawabi-Food-Corner-POS-Windows.zip';
        $path = $downloadsDir . DIRECTORY_SEPARATOR . $filename;

        if (File::exists($path)) {
            return response()->download($path, $filename, ['Content-Type' => 'application/zip']);
        }

        return redirect('/pos')->with('status', 'The desktop installer is not available on this server yet.');
    }
}
