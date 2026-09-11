<x-filament-widgets::widget>
    <style>
        /* =========================================================================
         * NAWABI FOOD CORNER - ELITE INTERACTIVE RESTAURANT KPI COMMAND GRID
         * ========================================================================= */
        
        .nfc-kpi-container {
            width: 100% !important;
            margin-bottom: 0.75rem !important;
            font-family: inherit;
        }

        /* Interactive Telemetry & Filter Bar */
        .nfc-command-bar {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #1a160d 100%);
            border: 1px solid rgba(212, 164, 55, 0.35);
            border-radius: 1.25rem;
            padding: 0.75rem 1.25rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.75rem;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.25);
            color: #ffffff;
        }

        /* Range Filter Buttons Group */
        .nfc-filter-group {
            display: inline-flex;
            align-items: center;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 9999px;
            padding: 3px;
            gap: 2px;
        }

        .nfc-filter-btn {
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 0.03em;
            color: #94a3b8;
            background: transparent;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .nfc-filter-btn:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
        }

        .nfc-filter-btn.active {
            background: linear-gradient(135deg, #d4a437 0%, #b8861b 100%);
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(212, 164, 55, 0.4);
        }

        /* 4-COLUMN RESPONSIVE KPI CARD GRID */
        .nfc-cards-grid {
            display: grid !important;
            grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
            gap: 0.9rem !important;
            width: 100% !important;
        }

        @media (max-width: 1180px) {
            .nfc-cards-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            }
        }

        @media (max-width: 640px) {
            .nfc-cards-grid {
                grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
            }
        }

        /* Elite KPI Card Styling */
        .nfc-metric-card {
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

        .dark .nfc-metric-card {
            background: #1e293b;
            border-color: #334155;
            box-shadow: 0 4px 14px -2px rgba(0, 0, 0, 0.35);
        }

        .nfc-metric-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px -4px rgba(0, 0, 0, 0.12);
        }

        .dark .nfc-metric-card:hover {
            box-shadow: 0 12px 28px -4px rgba(0, 0, 0, 0.45);
        }

        /* Top Accent Indicator */
        .nfc-metric-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3.5px;
        }

        .nfc-card-gold::before { background: linear-gradient(90deg, #d4a437, #f59e0b); }
        .nfc-card-emerald::before { background: linear-gradient(90deg, #10b981, #059669); }
        .nfc-card-indigo::before { background: linear-gradient(90deg, #6366f1, #4f46e5); }
        .nfc-card-amber::before { background: linear-gradient(90deg, #f59e0b, #d97706); }
        .nfc-card-rose::before { background: linear-gradient(90deg, #f43f5e, #e11d48); }
        .nfc-card-sky::before { background: linear-gradient(90deg, #0284c7, #0ea5e9); }
        .nfc-card-purple::before { background: linear-gradient(90deg, #8b5cf6, #7c3aed); }
        .nfc-card-teal::before { background: linear-gradient(90deg, #0d9488, #0f766e); }

        .nfc-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.5rem;
            margin-bottom: 0.4rem;
        }

        .nfc-eyebrow {
            font-size: 0.675rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #64748b;
        }

        .dark .nfc-eyebrow {
            color: #94a3b8;
        }

        .nfc-icon-chip {
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

        .nfc-metric-card:hover .nfc-icon-chip {
            transform: scale(1.08);
        }

        .nfc-value {
            font-size: 1.4rem;
            font-weight: 900;
            letter-spacing: -0.03em;
            line-height: 1.2;
            color: #0f172a;
            margin-bottom: 0.35rem;
        }

        .dark .nfc-value {
            color: #f8fafc;
        }

        .nfc-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 0.45rem;
            border-top: 1px solid #f1f5f9;
            font-size: 0.7rem;
            font-weight: 700;
            color: #64748b;
        }

        .dark .nfc-footer {
            border-top-color: #334155;
            color: #94a3b8;
        }
    </style>

    <div class="nfc-kpi-container">

        <!-- Top Interactive Telemetry & Operations Command Bar -->
        <div class="nfc-command-bar">
            <!-- Brand & Live PKT Telemetry -->
            <div style="display: flex; align-items: center; gap: 0.85rem;">
                <div style="width: 2.5rem; height: 2.5rem; border-radius: 9999px; border: 2px solid #d4a437; background: #ffffff; padding: 1px; overflow: hidden; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 10px rgba(212, 164, 55, 0.4);">
                    <img src="{{ asset('images/logo_circular.png') }}" alt="NFC" style="width: 100%; height: 100%; object-fit: cover; border-radius: 9999px;">
                </div>
                <div>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span style="font-size: 0.95rem; font-weight: 900; letter-spacing: -0.02em; color: #ffffff;">
                            Nawabi Food Corner
                        </span>
                        <span style="padding: 2px 7px; border-radius: 9999px; background: rgba(212, 164, 55, 0.2); border: 1px solid rgba(212, 164, 55, 0.4); color: #fef08a; font-size: 0.625rem; font-weight: 900; text-transform: uppercase;">
                            HQ Command
                        </span>
                    </div>
                    <div style="font-size: 0.7rem; color: #cbd5e1; display: flex; align-items: center; gap: 0.5rem; margin-top: 0.15rem;">
                        <span>🇵🇰 PKT: <b style="color: #ffffff;" id="nfc-live-clock">{{ $pktTime }}</b></span>
                        <span>•</span>
                        <span style="color: #4ade80; font-weight: 800;">● Active Register</span>
                        <span>•</span>
                        <span style="color: #fef08a;">{{ $rangeLabel }} View</span>
                    </div>
                </div>
            </div>

            <!-- Interactive Time Range Switcher Tabs -->
            <div style="display: flex; align-items: center; gap: 0.65rem; flex-wrap: wrap;">
                <div class="nfc-filter-group">
                    <button type="button"
                            wire:click="setTimeRange('today')"
                            class="nfc-filter-btn {{ $timeRange === 'today' ? 'active' : '' }}"
                            title="Filter today's live shift">
                        Today (Live)
                    </button>
                    <button type="button"
                            wire:click="setTimeRange('yesterday')"
                            class="nfc-filter-btn {{ $timeRange === 'yesterday' ? 'active' : '' }}"
                            title="Filter yesterday's audit">
                        Yesterday
                    </button>
                    <button type="button"
                            wire:click="setTimeRange('week')"
                            class="nfc-filter-btn {{ $timeRange === 'week' ? 'active' : '' }}"
                            title="Filter last 7 days metrics">
                        Last 7 Days
                    </button>
                    <button type="button"
                            wire:click="setTimeRange('month')"
                            class="nfc-filter-btn {{ $timeRange === 'month' ? 'active' : '' }}"
                            title="Filter this month's financials">
                        This Month
                    </button>
                </div>

                <!-- 10s Auto-refresh badge + Manual Sync Button -->
                <div style="display: inline-flex; align-items: center; gap: 0.35rem;">
                    <div style="display: inline-flex; align-items: center; gap: 0.35rem; padding: 4px 10px; border-radius: 9999px; background: rgba(16, 185, 129, 0.18); border: 1px solid rgba(16, 185, 129, 0.4); color: #6ee7b7; font-size: 0.65rem; font-weight: 900;">
                        <span style="width: 6px; height: 6px; border-radius: 9999px; background: #34d399; box-shadow: 0 0 8px #34d399;"></span>
                        <span>LIVE 10s</span>
                    </div>

                    <button type="button"
                            wire:click="$refresh"
                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 text-white text-xs font-bold transition-all active:scale-95"
                            title="Click to force immediate sync">
                        <span wire:loading.remove wire:target="$refresh">🔄</span>
                        <span wire:loading wire:target="$refresh" class="inline-block animate-spin">⌛</span>
                        <span class="text-[11px]">Sync</span>
                    </button>
                </div>

                <!-- Quick Terminal Launchers -->
                <div style="display: flex; align-items: center; gap: 0.35rem;">
                    <a href="{{ url('/pos') }}" target="_blank"
                       style="padding: 4px 10px; border-radius: 0.6rem; background: rgba(59, 130, 246, 0.25); border: 1px solid rgba(59, 130, 246, 0.45); color: #93c5fd; font-size: 0.675rem; font-weight: 800; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;">
                        🖥️ POS Terminal
                    </a>
                    <a href="{{ url('/waiter') }}" target="_blank"
                       style="padding: 4px 10px; border-radius: 0.6rem; background: rgba(16, 185, 129, 0.25); border: 1px solid rgba(16, 185, 129, 0.45); color: #a7f3d0; font-size: 0.675rem; font-weight: 800; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;">
                        📱 Waiter Pad
                    </a>
                </div>
            </div>
        </div>

        <!-- 8 INTERACTIVE KPI CARDS IN A CLEAN 4x2 GRID -->
        <div class="nfc-cards-grid">

            <!-- KPI 1: Royal Gross Sales Revenue (PKR) -->
            <a href="{{ url('/pos') }}" target="_blank" class="nfc-metric-card nfc-card-gold" title="Click to view Cashier POS terminal">
                <div>
                    <div class="nfc-card-header">
                        <span class="nfc-eyebrow">👑 Royal Sale Revenue</span>
                        <div class="nfc-icon-chip" style="background: rgba(212, 164, 55, 0.15); color: #d4a437;">
                            👑
                        </div>
                    </div>
                    <div class="nfc-value" style="color: #b45309;">
                        Rs. {{ number_format($grossSales, 0) }}
                    </div>
                </div>
                <div class="nfc-footer">
                    <span style="color: #059669; font-weight: 800;">
                        ✓ {{ $completedCount }} Bills Settle
                    </span>
                    <span>
                        Avg: <b style="color: #0f172a;" class="dark:text-white">Rs. {{ number_format($avgTicketSize, 0) }}</b>
                    </span>
                </div>
            </a>

            <!-- KPI 2: Physical Cash in Hand (Till Balance) -->
            <a href="{{ url('/pos') }}" target="_blank" class="nfc-metric-card nfc-card-emerald" title="Physical cash drawer till balance">
                <div>
                    <div class="nfc-card-header">
                        <span class="nfc-eyebrow">💵 Physical Cash In Till</span>
                        <div class="nfc-icon-chip" style="background: rgba(16, 185, 129, 0.15); color: #10b981;">
                            💵
                        </div>
                    </div>
                    <div class="nfc-value" style="color: #059669;">
                        Rs. {{ number_format($cashInDrawer, 0) }}
                    </div>
                </div>
                <div class="nfc-footer">
                    <span>Drawer Handover</span>
                    <span style="color: #059669; font-weight: 800; display: inline-flex; align-items: center; gap: 0.2rem;">
                        <span>●</span> Shift Ready
                    </span>
                </div>
            </a>

            <!-- KPI 3: Digital & Card Settlements -->
            <a href="{{ url('/admin/orders') }}" class="nfc-metric-card nfc-card-indigo" title="JazzCash, EasyPaisa, and POS bank terminal settlements">
                <div>
                    <div class="nfc-card-header">
                        <span class="nfc-eyebrow">💳 Digital & Cards</span>
                        <div class="nfc-icon-chip" style="background: rgba(99, 102, 241, 0.15); color: #6366f1;">
                            💳
                        </div>
                    </div>
                    <div class="nfc-value" style="color: #4f46e5;">
                        Rs. {{ number_format($digitalSales, 0) }}
                    </div>
                </div>
                <div class="nfc-footer">
                    <span>JazzCash / Bank POS</span>
                    <span style="color: #4f46e5; font-weight: 800;">
                        Direct Settle
                    </span>
                </div>
            </a>

            <!-- KPI 4: Kitchen Cooking Load & Service Speed -->
            <a href="{{ url('/admin/orders') }}" class="nfc-metric-card nfc-card-amber" title="Live active cooking load in kitchen queue">
                <div>
                    <div class="nfc-card-header">
                        <span class="nfc-eyebrow">👨‍🍳 Kitchen Cooking Load</span>
                        <div class="nfc-icon-chip" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b;">
                            🔥
                        </div>
                    </div>
                    <div class="nfc-value" style="color: #d97706;">
                        {{ $kitchenActiveOrders }} Open Orders
                    </div>
                </div>
                <div class="nfc-footer">
                    <span style="color: #d97706; font-weight: 800;">
                        🍳 {{ $kitchenDishesCooking }} Items In Queue
                    </span>
                    <span style="color: #10b981; font-weight: 800;">
                        Speed: Normal
                    </span>
                </div>
            </a>

            <!-- KPI 5: Floor Seating Occupancy & Live Guests -->
            <a href="{{ url('/admin/seating-map') }}" class="nfc-metric-card nfc-card-rose" title="Interactive Seating Map occupancy rate">
                <div>
                    <div class="nfc-card-header">
                        <span class="nfc-eyebrow">🍽️ Floor Occupancy</span>
                        <div class="nfc-icon-chip" style="background: rgba(225, 29, 72, 0.15); color: #e11d48;">
                            🍽️
                        </div>
                    </div>
                    <div class="nfc-value" style="color: #e11d48;">
                        {{ $occupiedTablesCount }} / {{ $totalTables }} Tables
                    </div>
                </div>
                <div class="nfc-footer">
                    <div style="display: flex; align-items: center; gap: 0.4rem; flex: 1;">
                        <div style="flex: 1; max-width: 70px; height: 6px; background: #e2e8f0; border-radius: 9999px; overflow: hidden;">
                            <div style="height: 100%; width: {{ $occupancyPercent }}%; background: #e11d48; border-radius: 9999px;"></div>
                        </div>
                        <span style="color: #e11d48; font-weight: 800;">{{ $occupancyPercent }}%</span>
                    </div>
                    <span style="color: #64748b;">
                        {{ $dineInCount }} Dine Orders
                    </span>
                </div>
            </a>

            <!-- KPI 6: Reservations & Peak Dining Hours -->
            <a href="{{ url('/admin/reservations') }}" class="nfc-metric-card nfc-card-sky" title="Reservations and peak dining rush hours">
                <div>
                    <div class="nfc-card-header">
                        <span class="nfc-eyebrow">📅 Peak Hour & Bookings</span>
                        <div class="nfc-icon-chip" style="background: rgba(2, 132, 199, 0.15); color: #0284c7;">
                            ⏰
                        </div>
                    </div>
                    <div class="nfc-value" style="font-size: 1.15rem; margin-top: 0.15rem; color: #0284c7; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{ $peakStatus }}
                    </div>
                </div>
                <div class="nfc-footer">
                    <span style="color: #0284c7; font-weight: 800;">
                        {{ $peakWindow }}
                    </span>
                    <span>
                        <b>{{ $liveReservationsCount }}</b> Booked ({{ $liveReservedGuests }} Guests)
                    </span>
                </div>
            </a>

            <!-- KPI 7: Star Pakistani Dish Today -->
            <a href="{{ url('/admin/menu-items') }}" class="nfc-metric-card nfc-card-purple" title="Top selling menu item today">
                <div>
                    <div class="nfc-card-header">
                        <span class="nfc-eyebrow">⭐ Top Star Dish</span>
                        <div class="nfc-icon-chip" style="background: rgba(139, 92, 246, 0.15); color: #8b5cf6;">
                            ⭐
                        </div>
                    </div>
                    <div class="nfc-value" style="font-size: 1.15rem; margin-top: 0.15rem; color: #7c3aed; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $topDishName }}">
                        {{ $topDishName }}
                    </div>
                </div>
                <div class="nfc-footer">
                    <span style="color: #7c3aed; font-weight: 800;">
                        {{ $topDishQty }} Units Prepared
                    </span>
                    <span>
                        Top Grosser
                    </span>
                </div>
            </a>

            <!-- KPI 8: Sales Tax (PRA / GST 16%) Audit Total -->
            <a href="{{ url('/admin/orders') }}" class="nfc-metric-card nfc-card-teal" title="Punjab Revenue Authority 16% compliant sales tax">
                <div>
                    <div class="nfc-card-header">
                        <span class="nfc-eyebrow">🧾 PRA / GST Tax (16%)</span>
                        <div class="nfc-icon-chip" style="background: rgba(13, 148, 136, 0.15); color: #0d9488;">
                            🧾
                        </div>
                    </div>
                    <div class="nfc-value" style="color: #0f766e;">
                        Rs. {{ number_format($dailyTaxCollected, 0) }}
                    </div>
                </div>
                <div class="nfc-footer">
                    <span>Tax Compliance Audit</span>
                    <span style="color: #0f766e; font-weight: 800;">
                        PRA 16%
                    </span>
                </div>
            </a>

        </div>

    </div>

    <!-- Real-Time PKT Clock Updater Script -->
    <script>
        function runNfcLiveClock() {
            const clockEl = document.getElementById('nfc-live-clock');
            if (clockEl) {
                const now = new Date();
                clockEl.innerText = now.toLocaleTimeString('en-US', { hour12: true, hour: '2-digit', minute: '2-digit', second: '2-digit' });
            }
        }
        if (!window.nfcClockInterval) {
            window.nfcClockInterval = setInterval(runNfcLiveClock, 1000);
        }
    </script>
</x-filament-widgets::widget>
