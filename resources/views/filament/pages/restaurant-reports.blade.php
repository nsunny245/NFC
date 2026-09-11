<x-filament-panels::page>
    @php
        $catalog = $this->getReportsCatalog();
        $reportData = $this->getActiveReportData();
        $activeConfig = $catalog[$this->activeReport] ?? $catalog['sales'];

        $categoryThemes = [
            'Financial' => ['bg' => '#ecfdf5', 'darkBg' => 'rgba(6, 78, 59, 0.4)', 'border' => '#a7f3d0', 'text' => '#065f46', 'accent' => '#10b981'],
            'Operations' => ['bg' => '#fffbeb', 'darkBg' => 'rgba(120, 53, 15, 0.4)', 'border' => '#fde68a', 'text' => '#92400e', 'accent' => '#f59e0b'],
            'Kitchen' => ['bg' => '#eff6ff', 'darkBg' => 'rgba(30, 58, 138, 0.4)', 'border' => '#bfdbfe', 'text' => '#1e40af', 'accent' => '#3b82f6'],
            'Guest Relations' => ['bg' => '#f5f3ff', 'darkBg' => 'rgba(76, 29, 149, 0.4)', 'border' => '#ddd6fe', 'text' => '#5b21b6', 'accent' => '#8b5cf6'],
            'Assets' => ['bg' => '#f0fdfa', 'darkBg' => 'rgba(19, 78, 74, 0.4)', 'border' => '#99f6e4', 'text' => '#115e59', 'accent' => '#14b8a6'],
            'HR & Payroll' => ['bg' => '#fdf2f8', 'darkBg' => 'rgba(131, 24, 67, 0.4)', 'border' => '#fbcfe8', 'text' => '#9d174d', 'accent' => '#ec4899'],
            'POS Audit' => ['bg' => '#fff7ed', 'darkBg' => 'rgba(124, 45, 18, 0.4)', 'border' => '#fed7aa', 'text' => '#9a3412', 'accent' => '#f97316'],
        ];
    @endphp

    <style>
        /* =========================================================================
         * NAWABI FOOD CORNER - EXECUTIVE REPORTS & EXPORT HUB STYLING
         * ========================================================================= */

        .nfc-reports-wrap {
            width: 100% !important;
            font-family: inherit;
        }

        /* Top Hero Command Deck */
        .nfc-reports-deck {
            background: linear-gradient(135deg, #0b1120 0%, #1e293b 50%, #1a160d 100%);
            border: 1px solid rgba(212, 164, 55, 0.4);
            border-radius: 1.25rem;
            padding: 1.25rem 1.5rem;
            box-shadow: 0 8px 30px -4px rgba(0, 0, 0, 0.35);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.25rem;
        }

        /* Segmented Time Range Selector */
        .nfc-range-segmented {
            display: inline-flex;
            align-items: center;
            background: rgba(15, 23, 42, 0.85);
            border: 1px solid rgba(212, 164, 55, 0.35);
            border-radius: 9999px;
            padding: 4px;
            gap: 2px;
            box-shadow: inset 0 2px 6px rgba(0, 0, 0, 0.4);
        }

        .nfc-range-pill {
            padding: 6px 14px;
            border-radius: 9999px;
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.02em;
            color: #94a3b8;
            background: transparent;
            border: none;
            cursor: pointer;
            transition: all 0.18s ease-in-out;
        }

        .nfc-range-pill:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
        }

        .nfc-range-pill.active {
            background: linear-gradient(135deg, #d4a437 0%, #b8861b 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 2px 10px rgba(212, 164, 55, 0.5) !important;
        }

        /* 8 Report Dossier Cards */
        .nfc-dossier-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1.25rem;
            padding: 1.35rem 1.4rem;
            transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            cursor: pointer;
        }

        .dark .nfc-dossier-card {
            background: #0f172a;
            border-color: #334155;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.3);
        }

        .nfc-dossier-card:hover {
            transform: translateY(-3px);
            border-color: #cbd5e1;
            box-shadow: 0 10px 28px -4px rgba(0, 0, 0, 0.08);
        }

        .dark .nfc-dossier-card:hover {
            border-color: #475569;
            box-shadow: 0 10px 28px -4px rgba(0, 0, 0, 0.45);
        }

        .nfc-dossier-card.active-dossier {
            border: 2px solid #d4a437 !important;
            background: linear-gradient(180deg, rgba(212, 164, 55, 0.08) 0%, rgba(212, 164, 55, 0.02) 100%) !important;
            box-shadow: 0 12px 32px -4px rgba(212, 164, 55, 0.35) !important;
        }

        /* Active Glow Dot */
        .nfc-active-indicator {
            position: absolute;
            top: 14px;
            right: 14px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 9999px;
            font-size: 0.68rem;
            font-weight: 800;
            background: linear-gradient(135deg, #d4a437 0%, #b8861b 100%);
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(212, 164, 55, 0.4);
        }

        /* Action Buttons on Dossier Cards */
        .nfc-card-action-btn {
            padding: 6px 12px;
            border-radius: 0.65rem;
            font-size: 0.72rem;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .nfc-card-action-excel {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .dark .nfc-card-action-excel {
            background: rgba(6, 78, 59, 0.4);
            color: #6ee7b7;
            border-color: rgba(6, 95, 70, 0.5);
        }

        .nfc-card-action-excel:hover {
            background: #10b981;
            color: #ffffff;
        }

        .nfc-card-action-pdf {
            background: #fffbeb;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .dark .nfc-card-action-pdf {
            background: rgba(120, 53, 15, 0.4);
            color: #fde68a;
            border-color: rgba(180, 83, 9, 0.5);
        }

        .nfc-card-action-pdf:hover {
            background: #d4a437;
            color: #ffffff;
        }

        .nfc-card-action-json {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        .dark .nfc-card-action-json {
            background: #1e293b;
            color: #94a3b8;
            border-color: #334155;
        }

        .nfc-card-action-json:hover {
            background: #475569;
            color: #ffffff;
        }

        /* Main Preview Console (Lower Card) */
        .nfc-console-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1.25rem;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            margin-top: 1.25rem;
        }

        .dark .nfc-console-card {
            background: #0f172a;
            border-color: #334155;
            box-shadow: 0 6px 24px -2px rgba(0, 0, 0, 0.4);
        }

        /* Console Action Toolbar */
        .nfc-btn-primary-export {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
            color: #ffffff !important;
            font-weight: 800 !important;
            border-radius: 0.75rem !important;
            padding: 8px 18px !important;
            font-size: 0.78rem !important;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            box-shadow: 0 3px 12px rgba(16, 185, 129, 0.3) !important;
            transition: all 0.15s ease;
        }

        .nfc-btn-primary-export:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.45) !important;
        }

        .nfc-btn-primary-pdf {
            background: linear-gradient(135deg, #d4a437 0%, #b8861b 100%) !important;
            color: #ffffff !important;
            font-weight: 800 !important;
            border-radius: 0.75rem !important;
            padding: 8px 18px !important;
            font-size: 0.78rem !important;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            box-shadow: 0 3px 12px rgba(212, 164, 55, 0.35) !important;
            transition: all 0.15s ease;
        }

        .nfc-btn-primary-pdf:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(212, 164, 55, 0.5) !important;
        }

        .nfc-btn-primary-json {
            background: #334155 !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            border-radius: 0.75rem !important;
            padding: 8px 14px !important;
            font-size: 0.78rem !important;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .nfc-btn-primary-json:hover {
            background: #475569 !important;
        }

        /* Horizontal Scroll Table Wrapper */
        .nfc-table-scroll-wrap {
            width: 100% !important;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
            border-top: 1px solid #e2e8f0;
        }

        .dark .nfc-table-scroll-wrap {
            border-top-color: #334155;
        }

        .nfc-preview-table {
            width: 100%;
            min-width: 1100px;
            border-collapse: collapse;
            font-size: 0.78rem;
        }

        .nfc-preview-table th {
            background: #0f172a;
            color: #f8fafc;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 10px 14px;
            text-align: left;
            border-bottom: 2px solid rgba(212, 164, 55, 0.4);
            white-space: nowrap;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .dark .nfc-preview-table th {
            background: #090e17;
            color: #f1f5f9;
        }

        .nfc-preview-table td {
            padding: 9px 14px;
            border-bottom: 1px solid #f1f5f9;
            color: #1e293b;
            white-space: nowrap;
        }

        .dark .nfc-preview-table td {
            border-bottom-color: #1e293b;
            color: #cbd5e1;
        }

        .nfc-preview-table tbody tr:hover td {
            background-color: rgba(212, 164, 55, 0.05);
        }

        .dark .nfc-preview-table tbody tr:hover td {
            background-color: rgba(212, 164, 55, 0.1);
        }

        /* Metric Pill Strip */
        .nfc-metric-chip {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 0.85rem;
            padding: 0.65rem 1rem;
        }

        .dark .nfc-metric-chip {
            background: #0f172a !important;
            border-color: #334155 !important;
        }

        .nfc-metric-ribbon {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }

        .dark .nfc-metric-ribbon {
            background: #090e17 !important;
            border-bottom-color: #1e293b !important;
        }

        .nfc-layout-toggle {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
        }

        .dark .nfc-layout-toggle {
            background: #1e293b !important;
            border-color: #334155 !important;
        }

        .nfc-cat-badge {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
            border: 1.5px solid transparent;
        }

        .dark .nfc-cat-badge {
            background: #1e293b !important;
            border-color: #334155 !important;
        }
    </style>

    <div class="nfc-reports-wrap">
        <!-- 1. Executive Header & Date Range Switcher -->
        <div class="nfc-reports-deck">
            <div class="flex items-center gap-3.5">
                <div style="width: 44px; height: 44px; border-radius: 14px; background: rgba(212, 164, 55, 0.15); border: 2px solid #d4a437; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; box-shadow: 0 4px 12px rgba(212, 164, 55, 0.25);">
                    📊
                </div>
                <div>
                    <h2 class="text-base font-black text-white tracking-tight flex items-center gap-2">
                        <span>EXECUTIVE RESTAURANT REPORTS & AUDIT HUB</span>
                        <span style="font-size: 0.65rem; padding: 2px 8px; border-radius: 9999px; background: #10b981; color: #ffffff; font-weight: 800;">ALL 8 DOMAINS READY</span>
                    </h2>
                    <p class="text-xs text-slate-300 mt-0.5">
                        Download certified audits in Microsoft Excel (.CSV), Official Printable PDF, or JSON format.
                    </p>
                </div>
            </div>

            <!-- Segmented Date Filter Bar -->
            <div class="nfc-range-segmented">
                @foreach(['today' => 'Today', 'yesterday' => 'Yesterday', 'week' => '7 Days', 'month' => 'This Month', 'all' => 'All Time'] as $rangeKey => $rangeTitle)
                    <button
                        type="button"
                        wire:click="setTimeRange('{{ $rangeKey }}')"
                        class="nfc-range-pill {{ $timeRange === $rangeKey ? 'active' : '' }}"
                    >
                        {{ $rangeTitle }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- 2. Catalog of 8 Operational Dossiers -->
        <!-- 2. Catalog of 8 Operational Dossiers (Default 3 Columns Per Row) -->
        <div x-data="{ gridCols: 3 }">
            <div class="flex flex-wrap items-center justify-between mb-4 px-1 gap-2.5">
                <div>
                    <h3 class="text-xs font-black uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center gap-2">
                        <span>Select Operational Domain to Inspect & Export</span>
                        <span class="text-gray-400 dark:text-gray-600 font-normal">({{ count($catalog) }} Certified Reports)</span>
                    </h3>
                </div>

                <div class="flex items-center gap-3">
                    <!-- Column View Selector: 3 Per Row (Recommended) vs 4 Per Row -->
                    <div class="flex items-center gap-1 nfc-layout-toggle p-1 rounded-xl shadow-inner">
                        <span class="text-[11px] font-bold text-gray-400 dark:text-gray-500 px-1.5 uppercase tracking-wider">Layout:</span>
                        <button
                            type="button"
                            @click="gridCols = 3"
                            :class="gridCols === 3 ? 'bg-gradient-to-r from-amber-500 to-amber-600 text-white font-black shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white'"
                            class="px-2.5 py-1 text-xs rounded-lg transition-all flex items-center gap-1.5"
                            title="3 Columns Per Row (Spacious & Highly Legible)"
                        >
                            <span>3 Per Row</span>
                            <span class="text-[10px] font-bold px-1.5 py-0.2 rounded bg-amber-700/40 text-amber-100">Featured</span>
                        </button>
                        <button
                            type="button"
                            @click="gridCols = 4"
                            :class="gridCols === 4 ? 'bg-gradient-to-r from-amber-500 to-amber-600 text-white font-black shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white'"
                            class="px-2.5 py-1 text-xs rounded-lg transition-all"
                            title="4 Columns Per Row (Compact Grid)"
                        >
                            <span>4 Per Row</span>
                        </button>
                    </div>

                    <span class="text-xs text-amber-600 dark:text-amber-400 font-mono font-bold bg-amber-50 dark:bg-amber-950/40 px-2.5 py-1 rounded-lg border border-amber-200 dark:border-amber-800/50">
                        Window: {{ strtoupper($timeRange) }}
                    </span>
                </div>
            </div>

            <!-- Dynamic Columns Grid (Defaults to 3 Columns Per Row) -->
            <div 
                class="grid grid-cols-1 md:grid-cols-2 gap-5 transition-all duration-300"
                :class="gridCols === 3 ? 'lg:grid-cols-3' : 'lg:grid-cols-4'"
            >
                @foreach($catalog as $key => $card)
                    @php
                        $catTheme = $categoryThemes[$card['category']] ?? ['bg' => '#f1f5f9', 'darkBg' => '#1e293b', 'border' => '#cbd5e1', 'text' => '#475569', 'accent' => '#64748b'];
                        $isActive = $this->activeReport === $key;
                    @endphp

                    <div 
                        class="nfc-dossier-card {{ $isActive ? 'active-dossier' : '' }}"
                        wire:click="setActiveReport('{{ $key }}')"
                    >
                        @if($isActive)
                            <div class="nfc-active-indicator">
                                <span>✓</span>
                                <span>Active Domain</span>
                            </div>
                        @endif

                        <div>
                            <!-- Top Tag & Category Badge -->
                            <div class="flex items-center gap-3 mb-3">
                                <div class="nfc-cat-badge" style="background: {{ $catTheme['bg'] }}; border-color: {{ $catTheme['border'] }};">
                                    {{ $card['icon'] }}
                                </div>
                                <div class="min-w-0 pr-16">
                                    <div style="font-size: 0.68rem; font-weight: 800; text-transform: uppercase; color: {{ $catTheme['accent'] }}; letter-spacing: 0.06em; line-height: 1.2;">
                                        {{ $card['category'] }}
                                    </div>
                                    <span style="font-size: 0.7rem; font-weight: 700; color: #64748b;" class="truncate block">
                                        {{ $card['badge'] }}
                                    </span>
                                </div>
                            </div>

                            <!-- Card Title & Description -->
                            <h4 class="font-black text-[0.95rem] text-gray-900 dark:text-gray-100 mb-1.5 leading-snug">
                                {{ $card['title'] }}
                            </h4>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mb-4 leading-relaxed line-clamp-2">
                                {{ $card['description'] }}
                            </p>
                        </div>

                        <!-- Card Action Buttons -->
                        <div class="pt-3 border-t border-gray-100 dark:border-gray-800 flex items-center justify-between gap-2" onclick="event.stopPropagation()">
                            <div class="flex items-center gap-2">
                                <a 
                                    href="{{ route('admin.reports.export.csv', ['type' => $key, 'range' => $timeRange]) }}"
                                    target="_blank"
                                    class="nfc-card-action-btn nfc-card-action-excel"
                                    title="Download Excel CSV"
                                >
                                    <span>📥</span>
                                    <span>Excel (.CSV)</span>
                                </a>

                                <a 
                                    href="{{ route('admin.reports.print', ['type' => $key, 'range' => $timeRange]) }}"
                                    target="_blank"
                                    class="nfc-card-action-btn nfc-card-action-pdf"
                                    title="Open Printable PDF"
                                >
                                    <span>🖨️</span>
                                    <span>Print PDF</span>
                                </a>
                            </div>

                            <a 
                                href="{{ route('admin.reports.export.json', ['type' => $key, 'range' => $timeRange]) }}"
                                target="_blank"
                                class="nfc-card-action-btn nfc-card-action-json"
                                title="Export JSON"
                            >
                                <span>📋 JSON</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- 3. Active Report Inspection & Export Console (Lower Deck) -->
        <div class="nfc-console-card">
            <!-- Console Top Bar -->
            <div class="p-5 border-b border-gray-200 dark:border-gray-800 flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(212, 164, 55, 0.15); border: 2px solid #d4a437; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                        {{ $activeConfig['icon'] }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-base font-black text-gray-900 dark:text-gray-100 tracking-tight">
                                {{ $reportData['title'] }}
                            </h3>
                            <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300 font-mono text-xs font-bold">
                                {{ count($reportData['rows']) }} Records Found
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                            {{ $reportData['description'] }}
                        </p>
                    </div>
                </div>

                <!-- Prominent Master Export Buttons -->
                <div class="flex items-center gap-2">
                    <a 
                        href="{{ route('admin.reports.export.csv', ['type' => $activeReport, 'range' => $timeRange]) }}"
                        target="_blank"
                        class="nfc-btn-primary-export"
                    >
                        <span>📥</span>
                        <span>Export Excel (.CSV)</span>
                    </a>

                    <a 
                        href="{{ route('admin.reports.print', ['type' => $activeReport, 'range' => $timeRange]) }}"
                        target="_blank"
                        class="nfc-btn-primary-pdf"
                    >
                        <span>🖨️</span>
                        <span>Print / Save as PDF</span>
                    </a>

                    <a 
                        href="{{ route('admin.reports.export.json', ['type' => $activeReport, 'range' => $timeRange]) }}"
                        target="_blank"
                        class="nfc-btn-primary-json"
                    >
                        <span>📋</span>
                        <span>JSON</span>
                    </a>
                </div>
            </div>

            <!-- Compact Metric Summary Ribbon -->
            @if(!empty($reportData['summaries']))
                <div class="p-4 nfc-metric-ribbon grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
                    @foreach($reportData['summaries'] as $label => $val)
                        <div class="nfc-metric-chip">
                            <div class="text-[10px] font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">{{ $label }}</div>
                            <div class="text-sm font-black text-gray-900 dark:text-gray-100 font-mono mt-0.5">{{ $val }}</div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Table with Horizontal Scroll Support -->
            <div class="nfc-table-scroll-wrap max-h-[550px] overflow-y-auto">
                <table class="nfc-preview-table">
                    <thead>
                        <tr>
                            @foreach($reportData['columns'] as $col)
                                <th>{{ $col }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reportData['rows'] as $row)
                            <tr>
                                @foreach($row as $idx => $cell)
                                    @php
                                        $isNumeric = is_numeric(str_replace([',', 'Rs.', '%'], '', (string)$cell));
                                        $isPrice = str_contains((string)$cell, 'Rs.');
                                    @endphp
                                    <td class="{{ $idx === 0 ? 'font-black' : '' }} {{ $isPrice ? 'font-bold text-emerald-600 dark:text-emerald-400' : '' }} font-mono">
                                        @if(in_array((string)$cell, ['completed', 'Confirmed', 'Operational', 'Healthy', 'paid']))
                                            <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 font-bold text-[11px]">
                                                ✓ {{ ucfirst($cell) }}
                                            </span>
                                        @elseif(in_array((string)$cell, ['pending', 'LOW STOCK ALERT', 'unpaid', 'Under Maintenance']))
                                            <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 dark:bg-amber-950/60 dark:text-amber-300 font-bold text-[11px]">
                                                ⚠️ {{ ucfirst($cell) }}
                                            </span>
                                        @elseif(in_array((string)$cell, ['cancelled', 'Broken', 'Out of Order']))
                                            <span class="px-2 py-0.5 rounded-full bg-rose-100 text-rose-700 dark:bg-rose-950/60 dark:text-rose-300 font-bold text-[11px]">
                                                ✕ {{ ucfirst($cell) }}
                                            </span>
                                        @else
                                            {{ $cell }}
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($reportData['columns']) }}" class="p-8 text-center text-gray-500 dark:text-gray-400">
                                    No records found for the selected timeframe.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-filament-panels::page>
