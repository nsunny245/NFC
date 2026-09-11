@php
    $report = $report ?? [];
    $cashierName = $report['cashierName'] ?? auth()->user()?->name ?? 'Cashier';
    $businessDate = $report['businessDate'] ?? now()->format('Y-m-d');
    $closedAt = $report['closedAt'] ?? now()->format('M d, Y h:i A');
    $totalOrders = $report['totalOrders'] ?? 0;
    $totalSales = $report['totalSales'] ?? 0;
    $cashSales = $report['cashSales'] ?? 0;
    $tenderedCash = $report['tenderedCash'] ?? 0;
    $changeReturned = $report['changeReturned'] ?? 0;
    $cardSales = $report['cardSales'] ?? 0;
    $bankSales = $report['bankSales'] ?? 0;
    $jazzCashSales = $report['jazzCashSales'] ?? 0;
    $easyPaisaSales = $report['easyPaisaSales'] ?? 0;
    $expensesTotal = $report['expensesTotal'] ?? 0;
    $expensesList = $report['expensesList'] ?? [];
    $openingCash = $report['openingCash'] ?? 0;
    $expectedCash = $report['expectedCash'] ?? 0;
    $countedCash = $report['countedCash'] ?? 0;
    $discrepancy = $report['discrepancy'] ?? 0;
@endphp

<div id="thermal-shift-report-container" class="pos-receipt-ticket" style="width: 280px; max-width: 100%; margin: 0 auto; background: #ffffff; color: #000000; font-family: 'Courier New', Courier, monospace; font-size: 11px; line-height: 1.25; padding: 12px 6px; box-sizing: border-box; text-align: left;">

    <!-- TOP HEADER / ROUND LOGO -->
    <div style="text-align: center; margin-bottom: 8px;">
        <div style="width: 60px; height: 60px; margin: 0 auto 5px; border-radius: 50%; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #ffffff;">
            <img src="{{ asset('images/logo_circular.png') }}" 
                 alt="Nawabi Food Corner" 
                 style="width: 100%; height: 100%; object-fit: cover; display: block; filter: grayscale(100%) contrast(140%);">
        </div>
        
        <div style="font-size: 13px; font-weight: 900; letter-spacing: 0.5px; text-transform: uppercase;">
            NAWABI FOOD CORNER
        </div>
        <div style="font-size: 9.5px; font-weight: 700; text-transform: uppercase; line-height: 1.2; margin-top: 2px;">
            NEAR AL-REHMAN GARDEN AKBAR ROAD OKARA
        </div>
        <div style="font-size: 10px; font-weight: 800; margin-top: 2px;">
            0311-8484987 : 0339-8484987
        </div>

        <div style="margin-top: 6px; padding: 3px 0; background: #000000; color: #ffffff; font-weight: 900; font-size: 11.5px; text-transform: uppercase; letter-spacing: 1px;">
            DAILY SHIFT Z-REPORT
        </div>
    </div>

    <!-- SHIFT INFO -->
    <div style="border-top: 1px dashed #000; border-bottom: 1px dashed #000; padding: 5px 0; font-size: 10px; line-height: 1.35;">
        <div style="display: flex; justify-content: space-between;">
            <span>Business Date:</span>
            <span style="font-weight: 900;">{{ $businessDate }}</span>
        </div>
        <div style="display: flex; justify-content: space-between;">
            <span>Print Timestamp:</span>
            <span>{{ $closedAt }}</span>
        </div>
        <div style="display: flex; justify-content: space-between;">
            <span>Register Cashier:</span>
            <span style="font-weight: 900;">{{ $cashierName }}</span>
        </div>
        <div style="display: flex; justify-content: space-between;">
            <span>Orders Completed:</span>
            <span style="font-weight: 900;">{{ $totalOrders }} orders</span>
        </div>
    </div>

    <!-- 1. PAYMENT METHODS BREAKDOWN -->
    <div style="margin-top: 8px;">
        <div style="font-size: 10.5px; font-weight: 900; text-transform: uppercase; border-bottom: 1px solid #000; padding-bottom: 2px; margin-bottom: 4px;">
            PAYMENT METHODS SUMMARY
        </div>

        <!-- Cash Details -->
        <div style="margin-bottom: 4px; padding-left: 2px;">
            <div style="display: flex; justify-content: space-between; font-weight: 900;">
                <span>💵 CASH PAYMENTS (NET):</span>
                <span>Rs. {{ number_format($cashSales, 2) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 9.5px; color: #444; padding-left: 8px;">
                <span>• Tendered Received:</span>
                <span>Rs. {{ number_format($tenderedCash, 2) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 9.5px; color: #444; padding-left: 8px;">
                <span>• Change Given:</span>
                <span>-Rs. {{ number_format($changeReturned, 2) }}</span>
            </div>
        </div>

        <!-- Digital / Non-Cash Channels -->
        <div style="display: flex; justify-content: space-between; padding: 2px 0;">
            <span>💳 Card / POS Machine:</span>
            <span style="font-weight: 800;">Rs. {{ number_format($cardSales, 2) }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; padding: 2px 0;">
            <span>🏦 Bank Transfer:</span>
            <span style="font-weight: 800;">Rs. {{ number_format($bankSales, 2) }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; padding: 2px 0;">
            <span>📱 JazzCash:</span>
            <span style="font-weight: 800;">Rs. {{ number_format($jazzCashSales, 2) }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; padding: 2px 0;">
            <span>📱 EasyPaisa:</span>
            <span style="font-weight: 800;">Rs. {{ number_format($easyPaisaSales, 2) }}</span>
        </div>

        <!-- Gross Sales Total -->
        <div style="border-top: 1.5px solid #000; border-bottom: 1.5px solid #000; margin-top: 5px; padding: 4px 0; display: flex; justify-content: space-between; font-size: 11.5px; font-weight: 900;">
            <span>ACTUAL GROSS SALES:</span>
            <span>Rs. {{ number_format($totalSales, 2) }}</span>
        </div>
    </div>

    <!-- 2. SHIFT EXPENSES / PAID-OUT -->
    <div style="margin-top: 8px;">
        <div style="display: flex; justify-content: space-between; font-size: 10.5px; font-weight: 900; border-bottom: 1px solid #000; padding-bottom: 2px;">
            <span>PAID-OUT EXPENSES:</span>
            <span style="color: #000;">-Rs. {{ number_format($expensesTotal, 2) }}</span>
        </div>

        @if(count($expensesList) > 0)
            <div style="font-size: 9.5px; margin-top: 3px; line-height: 1.3;">
                @foreach($expensesList as $exp)
                    <div style="display: flex; justify-content: space-between; padding: 1px 0;">
                        <span style="max-width: 190px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            • {{ $exp['recipient'] }} ({{ ucwords(str_replace('_', ' ', $exp['category'])) }})
                        </span>
                        <span>Rs. {{ number_format($exp['amount']) }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <div style="font-size: 9px; color: #666; padding: 2px 0; font-style: italic;">
                No paid-out expenses recorded during shift.
            </div>
        @endif
    </div>

    <!-- 3. DRAWER CASH RECONCILIATION -->
    <div style="margin-top: 8px; border: 1.5px solid #000; padding: 6px 6px;">
        <div style="text-align: center; font-weight: 900; font-size: 10.5px; text-transform: uppercase; margin-bottom: 4px; border-bottom: 1px dashed #000; padding-bottom: 3px;">
            DRAWER CASH RECONCILIATION
        </div>
        <div style="display: flex; justify-content: space-between; font-size: 10px; padding: 1px 0;">
            <span>Starting Float (Opening):</span>
            <span>Rs. {{ number_format($openingCash, 2) }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; font-size: 10px; padding: 1px 0;">
            <span>(+) Net Cash Sales:</span>
            <span>Rs. {{ number_format($cashSales, 2) }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; font-size: 10px; padding: 1px 0;">
            <span>(-) Drawer Expenses:</span>
            <span>-Rs. {{ number_format($expensesTotal, 2) }}</span>
        </div>
        <div style="border-top: 1px dashed #000; margin-top: 3px; padding-top: 3px; display: flex; justify-content: space-between; font-weight: 900; font-size: 11px;">
            <span>EXPECTED IN DRAWER:</span>
            <span>Rs. {{ number_format($expectedCash, 2) }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; font-weight: 900; font-size: 11px; padding-top: 2px;">
            <span>COUNTED PHYSICAL CASH:</span>
            <span>Rs. {{ number_format($countedCash, 2) }}</span>
        </div>
        <div style="border-top: 1px solid #000; margin-top: 3px; padding-top: 3px; display: flex; justify-content: space-between; font-weight: 900; font-size: 11px;">
            <span>DISCREPANCY / VARIANCE:</span>
            <span>
                @if(abs($discrepancy) < 0.01)
                    BALANCED (Rs. 0)
                @elseif($discrepancy > 0)
                    +Rs. {{ number_format($discrepancy, 2) }} (SURPLUS)
                @else
                    -Rs. {{ number_format(abs($discrepancy), 2) }} (SHORTAGE)
                @endif
            </span>
        </div>
    </div>

    <!-- SIGN-OFF SECTION -->
    <div style="margin-top: 16px; font-size: 9.5px;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 18px;">
            <div>
                <div>______________________</div>
                <div style="margin-top: 2px;">Cashier Signature</div>
            </div>
            <div style="text-align: right;">
                <div>______________________</div>
                <div style="margin-top: 2px;">Manager Signature</div>
            </div>
        </div>
        <div style="text-align: center; border-top: 1px dashed #000; padding-top: 6px; font-size: 9px; font-weight: 800;">
            *** OFFICIAL SHIFT CLOSING RECORD ***<br>
            SOFTWARE BY NAWABI DERA POS
        </div>
    </div>

</div>
