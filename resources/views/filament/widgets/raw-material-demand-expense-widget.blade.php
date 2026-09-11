<x-filament-widgets::widget>
    @php
        $d = $this->getViewData();
    @endphp

    <style>
        /* =========================================================================
         * NAWABI FOOD CORNER - MATCHED EXPENSE & RAW DEMAND KPI GRID
         * (Directly matched to top KPI grid specifications)
         * ========================================================================= */

        .nfc-demand-box {
            width: 100% !important;
            margin-bottom: 1.25rem !important;
            font-family: inherit;
        }

        /* 4-COLUMN RESPONSIVE KPI CARD GRID - IDENTICAL TO TOP CARDS */
        .nfc-demand-cards-grid {
            display: grid !important;
            grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
            gap: 0.9rem !important;
            width: 100% !important;
            margin-bottom: 1rem !important;
        }

        @media (max-width: 1180px) {
            .nfc-demand-cards-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            }
        }

        @media (max-width: 640px) {
            .nfc-demand-cards-grid {
                grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
            }
        }

        /* Elite KPI Metric Card Styling - Matching PakistaniRestaurantKpisWidget */
        .nfc-demand-metric-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1.15rem;
            padding: 1rem 1.15rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
            text-decoration: none !important;
            color: inherit !important;
            cursor: pointer;
            box-shadow: 0 2px 8px -1px rgba(0, 0, 0, 0.04), 0 1px 3px rgba(0, 0, 0, 0.02);
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .dark .nfc-demand-metric-card {
            background: #1e293b;
            border-color: #334155;
            box-shadow: 0 4px 14px -2px rgba(0, 0, 0, 0.35);
        }

        .nfc-demand-metric-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px -4px rgba(0, 0, 0, 0.12);
        }

        .dark .nfc-demand-metric-card:hover {
            box-shadow: 0 12px 28px -4px rgba(0, 0, 0, 0.45);
        }

        /* Top Accent Indicator Bar */
        .nfc-demand-metric-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3.5px;
        }

        .nfc-accent-emerald::before { background: linear-gradient(90deg, #10b981, #059669); }
        .nfc-accent-amber::before { background: linear-gradient(90deg, #f59e0b, #d97706); }
        .nfc-accent-rose::before { background: linear-gradient(90deg, #f43f5e, #e11d48); }
        .nfc-accent-purple::before { background: linear-gradient(90deg, #8b5cf6, #7c3aed); }

        .nfc-card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.5rem;
            margin-bottom: 0.4rem;
        }

        .nfc-card-label {
            font-size: 0.675rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #64748b;
        }

        .dark .nfc-card-label {
            color: #94a3b8;
        }

        .nfc-card-chip {
            width: 2.25rem;
            height: 2.25rem;
            border-radius: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            flex-shrink: 0;
            transition: transform 0.2s ease;
        }

        .nfc-demand-metric-card:hover .nfc-card-chip {
            transform: scale(1.08);
        }

        .nfc-card-value {
            font-size: 1.4rem;
            font-weight: 900;
            letter-spacing: -0.03em;
            line-height: 1.2;
            color: #0f172a;
            margin-bottom: 0.35rem;
            font-family: inherit;
        }

        .dark .nfc-card-value {
            color: #f8fafc;
        }

        .nfc-card-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.7rem;
            font-weight: 600;
            color: #64748b;
            padding-top: 0.4rem;
            border-top: 1px dashed #e2e8f0;
        }

        .dark .nfc-card-bottom {
            color: #94a3b8;
            border-top-color: #334155;
        }

        /* Breakdown Panels Container */
        .nfc-breakdown-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1.15rem;
            padding: 1.15rem 1.25rem;
            box-shadow: 0 2px 8px -1px rgba(0, 0, 0, 0.04);
        }

        .dark .nfc-breakdown-card {
            background: #1e293b !important;
            border-color: #334155 !important;
            box-shadow: 0 4px 14px -2px rgba(0, 0, 0, 0.35);
        }

        /* 2-Column Responsive Demand Ingredients Grid */
        .nfc-ingredient-grid {
            display: grid !important;
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            gap: 0.75rem !important;
        }

        @media (max-width: 640px) {
            .nfc-ingredient-grid {
                grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
            }
        }

        /* Ingredient Row Card */
        .nfc-demand-item {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 0.85rem;
            padding: 0.75rem 0.9rem;
            transition: all 0.2s ease;
        }

        .dark .nfc-demand-item {
            background: #0f172a !important;
            border-color: #334155 !important;
        }

        .nfc-demand-item:hover {
            border-color: #d4a437;
            transform: translateY(-1px);
        }

        .dark .nfc-demand-item:hover {
            border-color: #d4a437 !important;
        }

        /* Store Stock Breakdown Row */
        .nfc-stock-item {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            padding: 0.65rem 0.85rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.2s ease;
        }

        .dark .nfc-stock-item {
            background: #0f172a !important;
            border-color: #334155 !important;
        }

        .nfc-stock-item:hover {
            border-color: #d4a437;
        }

        .dark .nfc-stock-item:hover {
            border-color: #d4a437 !important;
        }

        /* Mandi Alert Container */
        .nfc-alert-box {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 0.75rem;
            padding: 0.75rem 0.9rem;
            margin-top: 0.75rem;
        }

        .dark .nfc-alert-box {
            background: rgba(120, 53, 15, 0.25) !important;
            border-color: rgba(245, 158, 11, 0.35) !important;
        }

        .nfc-progress-track {
            height: 6px;
            background: #e2e8f0;
            border-radius: 9999px;
            overflow: hidden;
        }

        .dark .nfc-progress-track {
            background: #334155 !important;
        }

        .nfc-progress-bar {
            height: 100%;
            border-radius: 9999px;
        }
    </style>

    <div class="nfc-demand-box" wire:poll.10s>
        <!-- Telemetry Command Bar (Matched in size & elegance to top command bar) -->
        <div style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #1a160d 100%); border: 1px solid rgba(212, 164, 55, 0.35); border-radius: 1.25rem; padding: 0.75rem 1.25rem; margin-bottom: 1rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.75rem; box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.25); color: #ffffff;">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <div style="width: 2.25rem; height: 2.25rem; border-radius: 0.75rem; background: rgba(212, 164, 55, 0.15); border: 1px solid rgba(212, 164, 55, 0.4); display: flex; align-items: center; justify-content: center; font-size: 1.15rem;">
                    🥩
                </div>
                <div>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span style="font-size: 0.875rem; font-weight: 900; letter-spacing: -0.01em; color: #ffffff; text-transform: uppercase;">
                            Raw Material Demand & Expense Intelligence
                        </span>
                        <span style="padding: 2px 7px; border-radius: 9999px; background: rgba(16, 185, 129, 0.2); border: 1px solid rgba(16, 185, 129, 0.4); color: #6ee7b7; font-size: 0.625rem; font-weight: 900; text-transform: uppercase;">
                            Mandi Live Sync
                        </span>
                    </div>
                    <div style="font-size: 0.7rem; color: #94a3b8; margin-top: 0.1rem;">
                        Pakistani Kitchen Ingredients ("Demand"), Store Room Stock & Expenditure
                    </div>
                </div>
            </div>

            <!-- Time Filter Pills -->
            <div style="display: inline-flex; align-items: center; background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 9999px; padding: 3px; gap: 2px;">
                @foreach(['today' => 'Today', 'yesterday' => 'Yesterday', 'week' => 'Last 7 Days', 'month' => 'This Month', 'all' => 'All Time'] as $key => $label)
                    <button 
                        type="button"
                        wire:click="setTimeRange('{{ $key }}')"
                        style="padding: 4px 12px; border-radius: 9999px; font-size: 0.7rem; font-weight: 800; letter-spacing: 0.03em; border: none; cursor: pointer; transition: all 0.2s ease; {{ $d['timeRange'] === $key ? 'background: linear-gradient(135deg, #d4a437 0%, #b8861b 100%); color: #ffffff; box-shadow: 0 2px 8px rgba(212, 164, 55, 0.4);' : 'background: transparent; color: #94a3b8;' }}"
                    >
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- 4 Key Executive Expense & Demand KPI Cards (Exact Style Match to Top Cards) -->
        <div class="nfc-demand-cards-grid">

            <!-- Card 1: Available Stock Capital (Emerald Accent) -->
            <a href="{{ url('/admin/inventory-items') }}" class="nfc-demand-metric-card nfc-accent-emerald" title="View In-Store Raw Materials Inventory">
                <div>
                    <div class="nfc-card-top">
                        <span class="nfc-card-label">📦 Available Stock Capital</span>
                        <div class="nfc-card-chip" style="background: rgba(16, 185, 129, 0.15); color: #10b981;">
                            🏬
                        </div>
                    </div>
                    <div class="nfc-card-value" style="color: #059669;">
                        Rs. {{ number_format($d['totalStockValue'], 0) }}
                    </div>
                </div>
                <div class="nfc-card-bottom">
                    <span style="color: #059669; font-weight: 800;">
                        ✓ {{ $d['totalStockCount'] }} Active Raw Items
                    </span>
                    <span>Ready for Kitchen</span>
                </div>
            </a>

            <!-- Card 2: Kitchen Demand Served (Amber Accent) -->
            <a href="{{ url('/admin/orders') }}" class="nfc-demand-metric-card nfc-accent-amber" title="View Daily Kitchen Order Ingredients">
                <div>
                    <div class="nfc-card-top">
                        <span class="nfc-card-label">🍗 Kitchen Demand Served</span>
                        <div class="nfc-card-chip" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b;">
                            👨‍🍳
                        </div>
                    </div>
                    <div class="nfc-card-value" style="color: #d97706;">
                        {{ number_format($d['demandIngredients']['chicken']['qty'] + $d['demandIngredients']['mutton']['qty'], 1) }} <span style="font-size: 0.95rem; font-weight: 700;">kg Meats</span>
                    </div>
                </div>
                <div class="nfc-card-bottom">
                    <span style="color: #b45309; font-weight: 800;">
                        🍚 {{ number_format($d['demandIngredients']['rice']['qty'], 1) }} kg Rice
                    </span>
                    <span>🛢️ {{ number_format($d['demandIngredients']['oil']['qty'], 1) }} L Oil</span>
                </div>
            </a>

            <!-- Card 3: Operating Expenses & Procurement (Rose Accent) -->
            <a href="{{ url('/admin/expenses') }}" class="nfc-demand-metric-card nfc-accent-rose" title="View Expense Ledger & Spendings">
                <div>
                    <div class="nfc-card-top">
                        <span class="nfc-card-label">💸 Operating Expenses</span>
                        <div class="nfc-card-chip" style="background: rgba(244, 63, 94, 0.15); color: #f43f5e;">
                            💸
                        </div>
                    </div>
                    <div class="nfc-card-value" style="color: #e11d48;">
                        Rs. {{ number_format($d['totalExpenses'], 0) }}
                    </div>
                </div>
                <div class="nfc-card-bottom">
                    <span style="color: #e11d48; font-weight: 800;">
                        Stock: Rs. {{ number_format($d['procurementExpenses'], 0) }}
                    </span>
                    <span>Bills: Rs. {{ number_format($d['overheadExpenses'], 0) }}</span>
                </div>
            </a>

            <!-- Card 4: Food Cost Efficiency Index (Purple Accent) -->
            <a href="{{ url('/admin/restaurant-reports') }}" class="nfc-demand-metric-card nfc-accent-purple" title="View Profitability & Food Cost Index">
                <div>
                    <div class="nfc-card-top">
                        <span class="nfc-card-label">🎯 Food Cost Efficiency</span>
                        <div class="nfc-card-chip" style="background: rgba(139, 92, 246, 0.15); color: #8b5cf6;">
                            📊
                        </div>
                    </div>
                    <div class="nfc-card-value" style="color: #7c3aed;">
                        {{ $d['foodCostRatio'] }}% <span style="font-size: 0.85rem; font-weight: 700; color: #64748b;">Index</span>
                    </div>
                </div>
                <div class="nfc-card-bottom">
                    <span style="color: {{ $d['foodCostRatio'] <= 35 ? '#059669' : '#b45309' }}; font-weight: 800;">
                        {{ $d['foodCostRatio'] <= 35 ? '✓ Target 28% – 35%' : '⚠️ Cost Warning' }}
                    </span>
                    <span>{{ $d['foodCostRatio'] <= 35 ? 'Profitable' : 'High Waste' }}</span>
                </div>
            </a>

        </div>

        <!-- Two Operational Detail Panes -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
            <!-- Left Pane: Daily Demand & Ingredient Depletion (7 cols) -->
            <div class="lg:col-span-7 nfc-breakdown-card">
                <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-800 mb-3">
                    <div class="flex items-center gap-2 font-black text-xs uppercase tracking-wider text-gray-900 dark:text-gray-100">
                        <span>🔥</span>
                        <span>Kitchen Ingredients Dispatched ("Demand")</span>
                    </div>
                    <span class="text-xs text-amber-600 dark:text-amber-400 font-mono font-bold">{{ $d['rangeLabel'] }}</span>
                </div>

                <div class="nfc-ingredient-grid">
                    @foreach($d['demandIngredients'] as $ing)
                        <div class="nfc-demand-item">
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="font-bold text-xs text-gray-800 dark:text-gray-100 flex items-center gap-1.5">
                                    <span>{{ $ing['icon'] }}</span>
                                    <span>{{ $ing['name'] }}</span>
                                </span>
                                <span class="text-xs font-black font-mono text-amber-600 dark:text-amber-400">
                                    {{ number_format($ing['qty'], 1) }} {{ $ing['unit'] }}
                                </span>
                            </div>
                            <div class="nfc-progress-track mt-2">
                                <div class="nfc-progress-bar bg-gradient-to-r from-amber-500 to-amber-600" style="width: {{ min(100, max(15, $ing['qty'] * 2)) }}%;"></div>
                            </div>
                            <div class="mt-2 flex justify-between text-[10px] text-gray-500 dark:text-gray-400 font-medium">
                                <span>Dispatched to Kitchen</span>
                                <span class="text-emerald-600 dark:text-emerald-400 font-bold">● Fulfilled</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Right Pane: Store Room Stock Valuation & Mandi Procurement Alerts (5 cols) -->
            <div class="lg:col-span-5 nfc-breakdown-card">
                <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-800 mb-3">
                    <div class="flex items-center gap-2 font-black text-xs uppercase tracking-wider text-gray-900 dark:text-gray-100">
                        <span>🏬</span>
                        <span>Store Room Capital & Mandi Alerts</span>
                    </div>
                    @if($d['lowStockCount'] > 0)
                        <span class="px-2 py-0.5 rounded-full bg-rose-100 text-rose-700 dark:bg-rose-950/80 dark:text-rose-300 font-bold text-xs border border-rose-200 dark:border-rose-800">
                            ⚠️ {{ $d['lowStockCount'] }} Low Stock
                        </span>
                    @else
                        <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-950/80 dark:text-emerald-300 font-bold text-xs border border-emerald-200 dark:border-emerald-800">
                            ✓ Stock Healthy
                        </span>
                    @endif
                </div>

                <!-- Stock Category Valuation -->
                <div class="space-y-2 mb-3">
                    @foreach($d['categoryBreakdown'] as $cat)
                        <div class="nfc-stock-item">
                            <span class="font-bold text-xs text-gray-800 dark:text-gray-200 flex items-center gap-1.5">
                                <span>{{ $cat['icon'] }}</span>
                                <span>{{ $cat['name'] }}</span>
                            </span>
                            <div class="text-right">
                                <div class="font-bold font-mono text-xs text-gray-900 dark:text-gray-100">Rs. {{ number_format($cat['val'], 0) }}</div>
                                <div class="text-[10px] text-gray-500 dark:text-gray-400 font-mono">{{ number_format($cat['qty'], 1) }} {{ $cat['unit'] }} in store</div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Mandi Procurement Checklist -->
                @if(!empty($d['lowStockItems']))
                    <div class="nfc-alert-box">
                        <div class="text-xs font-black text-amber-800 dark:text-amber-300 flex items-center gap-1 mb-1.5">
                            <span>🛒</span>
                            <span>Immediate Mandi Procurement Required:</span>
                        </div>
                        <div class="space-y-1.5 text-xs">
                            @foreach($d['lowStockItems'] as $l)
                                <div class="flex items-center justify-between text-gray-800 dark:text-gray-200">
                                    <span class="font-medium">• {{ $l['name'] }}</span>
                                    <span class="font-bold text-rose-600 dark:text-rose-400 font-mono">{{ $l['current'] }} {{ $l['unit'] }} left (Min: {{ $l['threshold'] }})</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
