<div class="flex flex-col items-center justify-center p-2">
    <style>
        .nfc-thermal-preview-wrap {
            background: #e2e8f0;
            padding: 16px;
            border-radius: 12px;
            box-shadow: inset 0 2px 8px rgba(0,0,0,0.1);
            width: 100%;
            display: flex;
            justify-content: center;
        }
        .dark .nfc-thermal-preview-wrap {
            background: #020617 !important;
        }
    </style>

    <!-- Action bar -->
    <div class="w-full flex items-center justify-between mb-3 pb-2 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center gap-2">
            <span class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">ESC/POS 80mm Print Layout</span>
            <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-black">Official Format</span>
        </div>
        <button 
            type="button" 
            onclick="printAdminThermalReceipt()"
            class="px-4 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow transition flex items-center gap-1.5"
        >
            <span>🖨️</span>
            <span>Print Thermal Ticket</span>
        </button>
    </div>

    <!-- Thermal Preview Wrapper -->
    <div class="nfc-thermal-preview-wrap">
        <div id="admin-thermal-print-area" style="box-shadow: 0 4px 16px rgba(0,0,0,0.15); border-radius: 4px; overflow: hidden;">
            @include('receipts.thermal-receipt', [
                'order' => $order,
                'cashierName' => auth()->user()?->name ?? 'admin',
                'type' => 'bill',
            ])
        </div>
    </div>

    <script>
        function printAdminThermalReceipt() {
            var printArea = document.getElementById('admin-thermal-print-area');
            if (!printArea) return;
            var printContents = printArea.innerHTML;

            if (window.posDesktop && typeof window.posDesktop.printReceiptDirect === 'function') {
                window.posDesktop.printReceiptDirect(printContents).then(function(res) {
                    console.log('Direct thermal receipt printed:', res);
                }).catch(function(err) {
                    console.warn('Desktop printer fallback:', err);
                    printAdminThermalViaIframe(printContents);
                });
                return;
            }

            printAdminThermalViaIframe(printContents);
        }

        function printAdminThermalViaIframe(contents) {
            var printFrame = document.createElement('iframe');
            printFrame.style.position = 'fixed';
            printFrame.style.right = '0';
            printFrame.style.bottom = '0';
            printFrame.style.width = '0';
            printFrame.style.height = '0';
            printFrame.style.border = '0';
            document.body.appendChild(printFrame);

            var doc = printFrame.contentWindow.document;
            doc.open();
            doc.write('<!DOCTYPE html><html><head><title>Thermal Ticket<' + '/title>');
            doc.write('<style>@page { margin: 0; size: 80mm auto; } body { font-family: "Courier New", Courier, monospace; font-size: 11px; line-height: 1.25; padding: 6px 4px; width: 280px; margin: 0 auto; color: #000; background: #fff; } @media print { body { width: 100%; margin: 0; padding: 0; } }<' + '/style>');
            doc.write('<' + '/head><body>');
            doc.write(contents);
            doc.write('<' + '/body><' + '/html>');
            doc.close();

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
</div>
