<x-filament-panels::page>
    <style>
        .nfc-receipt-page-wrap {
            width: 100%;
            font-family: inherit;
        }

        /* Top Executive Hero Header */
        .nfc-receipt-hero {
            background: linear-gradient(135deg, #0b1120 0%, #1e293b 50%, #1a160d 100%);
            border: 1px solid rgba(212, 164, 55, 0.4);
            border-radius: 1.25rem;
            padding: 1.35rem 1.75rem;
            box-shadow: 0 8px 30px -4px rgba(0, 0, 0, 0.35);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        /* Card Container Styling */
        .nfc-spec-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1.25rem;
            padding: 1.5rem;
            box-shadow: 0 4px 16px -2px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
        }
        .dark .nfc-spec-card {
            background: #0f172a;
            border-color: #334155;
            box-shadow: 0 6px 20px -2px rgba(0, 0, 0, 0.4);
        }

        /* Thermal Receipt Paper Container */
        .nfc-paper-receipt-wrap {
            background: #f1f5f9;
            border: 2px dashed #cbd5e1;
            border-radius: 1.25rem;
            padding: 2rem 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        .dark .nfc-paper-receipt-wrap {
            background: #020617;
            border-color: #1e293b;
        }

        .nfc-paper-ticket {
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15), 0 1px 3px rgba(0, 0, 0, 0.08);
            border-radius: 4px;
            overflow: hidden;
            position: relative;
        }

        /* Hardware Spec Tiles */
        .nfc-hw-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 0.85rem;
            padding: 0.85rem 1rem;
        }
        .dark .nfc-hw-card {
            background: #1e293b !important;
            border-color: #334155 !important;
        }

        /* License Clause Box */
        .nfc-license-box {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 0.85rem;
            padding: 1rem 1.25rem;
        }
        .dark .nfc-license-box {
            background: rgba(120, 53, 15, 0.25) !important;
            border-color: rgba(217, 119, 6, 0.4) !important;
        }

        .dark .nfc-logo-badge {
            background: #0f172a !important;
        }

        /* Primary Action Button */
        .nfc-btn-thermal-print {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            font-weight: 800;
            border-radius: 0.85rem;
            padding: 10px 22px;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            border: none;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35);
            transition: all 0.18s ease;
        }
        .nfc-btn-thermal-print:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.5);
        }
    </style>

    <div class="nfc-receipt-page-wrap">
        <!-- 1. Executive Hero Header -->
        <div class="nfc-receipt-hero">
            <div class="flex items-center gap-4">
                <div style="width: 50px; height: 50px; border-radius: 16px; background: rgba(212, 164, 55, 0.15); border: 2px solid #d4a437; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; box-shadow: 0 4px 14px rgba(212, 164, 55, 0.3);">
                    🖨️
                </div>
                <div>
                    <h2 class="text-lg font-black text-white tracking-tight flex items-center gap-2">
                        <span>POS THERMAL RECEIPT & BRANDING CENTER</span>
                        <span style="font-size: 0.65rem; padding: 3px 9px; border-radius: 9999px; background: #10b981; color: #ffffff; font-weight: 800;">STANDARD 80MM ESC/POS</span>
                    </h2>
                    <p class="text-xs text-slate-300 mt-0.5">
                        Certified receipt print layout for EPSON, Xprinter, and all standard counter thermal registers.
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button 
                    type="button" 
                    onclick="printOfficialThermalReceipt()"
                    class="nfc-btn-thermal-print"
                >
                    <span>🖨️</span>
                    <span>Print Test Ticket (80mm)</span>
                </button>
            </div>
        </div>

        <!-- 2. Dual-Column Architecture: Specs & Live Ticket Preview -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- Left Column: Specs, Store Info & Permanent License (7 Cols) -->
            <div class="lg:col-span-7 space-y-5">

                <!-- Card A: Restaurant Header Identity -->
                <div class="nfc-spec-card">
                    <div class="flex items-center justify-between pb-3 mb-4 border-b border-gray-100 dark:border-gray-800">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base">👑</span>
                            <h3 class="text-sm font-black uppercase tracking-wider text-gray-900 dark:text-gray-100">
                                Official Restaurant Header Information
                            </h3>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 dark:bg-amber-950/70 dark:text-amber-300 text-[11px] font-bold">
                            Live on Tickets
                        </span>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-16 h-16 rounded-full border-2 border-amber-400 bg-white dark:!bg-slate-900 nfc-logo-badge p-1 overflow-hidden flex-shrink-0 shadow-md shadow-amber-500/10">
                            <img src="{{ asset('images/logo_circular.png') }}" alt="Nawabi Food Corner Logo" class="w-full h-full object-cover rounded-full">
                        </div>
                        <div class="space-y-2 text-xs flex-1">
                            <div>
                                <div class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Restaurant Name (Brand)</div>
                                <div class="text-sm font-black text-gray-900 dark:text-gray-100">NAWABI FOOD CORNER</div>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Branch Address</div>
                                <div class="font-bold text-gray-800 dark:text-gray-200">Near Al-Rehman Garden Akbar Road, Okara</div>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Customer Helpline & Phone Numbers</div>
                                <div class="font-mono font-black text-emerald-600 dark:text-emerald-400">0311-8484987 : 0339-8484987</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card B: Thermal Printer Specifications -->
                <div class="nfc-spec-card">
                    <div class="flex items-center justify-between pb-3 mb-4 border-b border-gray-100 dark:border-gray-800">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base">⚡</span>
                            <h3 class="text-sm font-black uppercase tracking-wider text-gray-900 dark:text-gray-100">
                                Thermal Hardware Hardware Specifications
                            </h3>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-800 dark:bg-blue-950/70 dark:text-blue-300 text-[11px] font-bold border border-blue-200 dark:border-blue-800">
                            Zero-Config
                        </span>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 text-xs">
                        <div class="nfc-hw-card">
                            <div class="text-[10px] font-bold text-gray-400 uppercase">Paper Width</div>
                            <div class="font-black text-gray-900 dark:text-gray-100 text-sm mt-0.5">80mm / 58mm</div>
                            <div class="text-[10px] text-gray-500 dark:text-gray-400 mt-0.5">Auto-fitted width</div>
                        </div>
                        <div class="nfc-hw-card">
                            <div class="text-[10px] font-bold text-gray-400 uppercase">Print Driver</div>
                            <div class="font-black text-gray-900 dark:text-gray-100 text-sm mt-0.5">ESC/POS Direct</div>
                            <div class="text-[10px] text-gray-500 dark:text-gray-400 mt-0.5">USB / COM / LAN</div>
                        </div>
                        <div class="nfc-hw-card">
                            <div class="text-[10px] font-bold text-gray-400 uppercase">Barcode Standard</div>
                            <div class="font-black text-gray-900 dark:text-gray-100 text-sm mt-0.5">Code 128</div>
                            <div class="text-[10px] text-gray-500 dark:text-gray-400 mt-0.5">Scannable reference</div>
                        </div>
                    </div>
                </div>

                <!-- Card C: Permanent Developer Attribution & Copyright Statement -->
                <div class="nfc-spec-card" style="border-left: 5px solid #d4a437;">
                    <div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-100 dark:border-gray-800">
                        <div class="flex items-center gap-2">
                            <span class="text-base">🔒</span>
                            <h3 class="text-sm font-black uppercase tracking-wider text-gray-900 dark:text-gray-100">
                                Permanent Software Attribution & Licensing
                            </h3>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full bg-rose-100 text-rose-800 dark:bg-rose-950/70 dark:text-rose-300 text-[10px] font-black uppercase tracking-wider border border-rose-200 dark:border-rose-800">
                            Non-Editable Clause
                        </span>
                    </div>

                    <p class="text-xs text-gray-600 dark:text-gray-300 leading-relaxed mb-4">
                        As mandated in the software licensing agreement, the following developer attribution statement is permanently rendered at the bottom of all cashier receipts and customer portals:
                    </p>

                    <div class="nfc-license-box font-mono text-xs text-stone-900 dark:text-amber-100 leading-relaxed">
                        <div class="font-black text-sm text-amber-800 dark:text-amber-400 mb-1">
                            Software designed and developed by: MNS Technologies and consultant
                        </div>
                        <div class="font-bold text-emerald-700 dark:text-emerald-400 text-sm">
                            Direct Support & Development Helpline: 0347-6824180
                        </div>
                    </div>

                    <div class="mt-3 flex items-center gap-2 text-[11px] text-gray-500 dark:text-gray-400 font-medium">
                        <span class="text-amber-600 dark:text-amber-400 font-bold">ℹ️ Note:</span>
                        <span>This copyright section is permanently locked in core source code and cannot be modified by any admin, cashier, or manager account.</span>
                    </div>
                </div>

            </div>

            <!-- Right Column: Live Physical Paper Receipt Simulation (5 Cols) -->
            <div class="lg:col-span-5">
                <div class="nfc-paper-receipt-wrap">
                    <div class="mb-3 text-center">
                        <span class="text-xs font-black uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center justify-center gap-1.5">
                            <span>📄 Live 80mm Receipt Print Simulation</span>
                        </span>
                        <span class="text-[11px] text-gray-400 dark:text-gray-500">Sample Ticket Bill #29021</span>
                    </div>

                    <div class="nfc-paper-ticket" id="official-thermal-print-area">
                        @include('receipts.thermal-receipt', [
                            'order' => null,
                            'cashierName' => 'admin',
                            'type' => 'bill',
                        ])
                    </div>

                    <div class="mt-4 w-full flex justify-center">
                        <button 
                            type="button" 
                            onclick="printOfficialThermalReceipt()"
                            class="nfc-btn-thermal-print w-full justify-center"
                        >
                            <span>🖨️</span>
                            <span>Print Thermal Receipt Now</span>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Official Thermal Printing Script -->
    <script>
        function printOfficialThermalReceipt() {
            var printArea = document.getElementById('official-thermal-print-area');
            if (!printArea) {
                console.error('Thermal print area not found');
                return;
            }
            var printContents = printArea.innerHTML;

            // Direct silent printing if running inside Electron Desktop POS bridge
            if (window.posDesktop && typeof window.posDesktop.printReceiptDirect === 'function') {
                window.posDesktop.printReceiptDirect(printContents).then(function(res) {
                    console.log('Direct thermal receipt printed:', res);
                }).catch(function(err) {
                    console.warn('Desktop printer fallback:', err);
                    printViaHiddenIframe(printContents, 'Official 80mm Thermal Receipt');
                });
                return;
            }

            printViaHiddenIframe(printContents, 'Official 80mm Thermal Receipt');
        }

        function printViaHiddenIframe(contents, title) {
            var printFrame = document.createElement('iframe');
            printFrame.style.position = 'fixed';
            printFrame.style.right = '0';
            printFrame.style.bottom = '0';
            printFrame.style.width = '0';
            printFrame.style.height = '0';
            printFrame.style.border = '0';
            document.body.appendChild(printFrame);

            var frameDoc = printFrame.contentWindow.document;
            frameDoc.open();
            frameDoc.write('<!DOCTYPE html><html><head><title>' + (title || 'Receipt') + '<' + '/title>');
            frameDoc.write('<style>');
            frameDoc.write('@page { margin: 0; size: 80mm auto; } ');
            frameDoc.write('body { font-family: "Courier New", Courier, monospace; font-size: 11px; line-height: 1.25; padding: 6px 4px; width: 280px; margin: 0 auto; color: #000; background: #fff; } ');
            frameDoc.write('@media print { body { width: 100%; margin: 0; padding: 0; } }');
            frameDoc.write('<' + '/style>');
            frameDoc.write('<' + '/head><body>');
            frameDoc.write(contents);
            frameDoc.write('<' + '/body><' + '/html>');
            frameDoc.close();

            setTimeout(function() {
                printFrame.contentWindow.focus();
                printFrame.contentWindow.print();
                setTimeout(function() {
                    if (printFrame.parentNode) {
                        printFrame.parentNode.removeChild(printFrame);
                    }
                }, 1500);
            }, 300);
        }
    </script>
</x-filament-panels::page>
