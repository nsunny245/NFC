<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $report['title'] }} • Nawabi Dera Okara</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 1.2cm;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            color: #0f172a;
            background: #ffffff;
            padding: 24px;
            font-size: 11px;
            line-height: 1.4;
        }

        /* Interactive Print Header for Screen */
        .no-print {
            background: #0f172a;
            color: #ffffff;
            padding: 12px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
        }

        .btn-print {
            background: linear-gradient(135deg, #d4a437 0%, #b8861b 100%);
            color: #ffffff;
            border: none;
            padding: 8px 18px;
            border-radius: 8px;
            font-weight: 800;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-print:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .btn-close {
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff;
            border: none;
            padding: 8px 14px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 12px;
            cursor: pointer;
        }

        /* Document Header */
        .report-header {
            border-bottom: 2px solid #d4a437;
            padding-bottom: 14px;
            margin-bottom: 18px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .brand-title {
            font-size: 20px;
            font-weight: 900;
            color: #0f172a;
            letter-spacing: -0.02em;
        }

        .brand-sub {
            font-size: 11px;
            color: #64748b;
            margin-top: 2px;
        }

        .report-title-badge {
            display: inline-block;
            background: #fef3c7;
            color: #92400e;
            padding: 4px 12px;
            border-radius: 6px;
            font-weight: 800;
            font-size: 13px;
            margin-bottom: 4px;
        }

        .meta-text {
            font-size: 10px;
            color: #64748b;
            text-align: right;
        }

        /* Summary Cards */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 12px;
            margin-bottom: 20px;
        }

        .summary-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px 14px;
        }

        .summary-label {
            font-size: 10px;
            text-transform: uppercase;
            font-weight: 700;
            color: #64748b;
            letter-spacing: 0.04em;
        }

        .summary-val {
            font-size: 16px;
            font-weight: 900;
            color: #0f172a;
            margin-top: 2px;
            font-family: monospace;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            background: #0f172a;
            color: #ffffff;
            font-weight: 800;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 8px 10px;
            text-align: left;
            border: 1px solid #0f172a;
        }

        td {
            padding: 7px 10px;
            border: 1px solid #e2e8f0;
            font-size: 10.5px;
        }

        tr:nth-child(even) td {
            background: #f8fafc;
        }

        /* Footer */
        .report-footer {
            border-top: 1px solid #e2e8f0;
            padding-top: 12px;
            font-size: 9px;
            color: #94a3b8;
            display: flex;
            justify-content: space-between;
        }

        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
            th {
                background: #0f172a !important;
                color: #ffffff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            tr:nth-child(even) td {
                background: #f8fafc !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .report-title-badge {
                background: #fef3c7 !important;
                color: #92400e !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

    <!-- On-Screen Action Bar -->
    <div class="no-print">
        <div>
            <strong style="font-size: 13px;">Executive Restaurant Report Preview</strong>
            <span style="color: #94a3b8; margin-left: 8px;">(Ready to print or export as PDF)</span>
        </div>
        <div style="display: flex; gap: 8px;">
            <button class="btn-print" onclick="window.print()">🖨️ Print / Save as PDF</button>
            <button class="btn-close" onclick="window.close()">✕ Close</button>
        </div>
    </div>

    <!-- Official Letterhead Header -->
    <div class="report-header">
        <div>
            <div class="brand-title">👑 NAWABI DERA — ROYAL FOOD CORNER</div>
            <div class="brand-sub">Okara Cantt, Punjab, Pakistan • Tel: +92 (044) 123-4567 • POS RRP Management System</div>
            <div style="margin-top: 8px;">
                <div class="report-title-badge">{{ $report['title'] }}</div>
                <div style="font-size: 11px; color: #475569;">{{ $report['description'] }}</div>
            </div>
        </div>
        <div class="meta-text">
            <div><strong>Time Window:</strong> {{ strtoupper($range) }}</div>
            <div><strong>Generated At:</strong> {{ $generatedAt }}</div>
            <div><strong>Authority:</strong> Executive General Manager</div>
        </div>
    </div>

    <!-- Summary Aggregates -->
    @if(!empty($report['summaries']))
        <div class="summary-grid">
            @foreach($report['summaries'] as $label => $val)
                <div class="summary-card">
                    <div class="summary-label">{{ $label }}</div>
                    <div class="summary-val">{{ $val }}</div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Data Table -->
    <table>
        <thead>
            <tr>
                @foreach($report['columns'] as $col)
                    <th>{{ $col }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($report['rows'] as $row)
                <tr>
                    @foreach($row as $cell)
                        <td>{{ $cell }}</td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($report['columns']) }}" style="text-align: center; padding: 24px; color: #64748b;">
                        No records found for the selected timeframe.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Official Verification Footer -->
    <div class="report-footer">
        <div>Nawabi Dera Management Information System (MIS) • Secure Audit Trail</div>
        <div>Page 1 of 1 • System Certified True Record</div>
    </div>

</body>
</html>
