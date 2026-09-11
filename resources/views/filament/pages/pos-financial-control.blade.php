<x-filament-panels::page>
    <style>
        /* Scoped Custom CSS for POS Financial Terminal Control */
        .pos-fc-container {
            font-family: inherit;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            width: 100%;
        }

        /* Top Hero Header */
        .pos-fc-header {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-left: 6px solid #D4A437;
            border-radius: 1rem;
            padding: 1.25rem 1.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            box-shadow: 0 4px 15px -3px rgba(0, 0, 0, 0.05);
        }
        .dark .pos-fc-header {
            background: #1e293b;
            border-color: #334155;
            border-left-color: #D4A437;
        }

        .pos-fc-title {
            font-size: 1.25rem;
            font-weight: 900;
            letter-spacing: -0.02em;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .dark .pos-fc-title {
            color: #f8fafc;
        }

        .pos-fc-subtitle {
            font-size: 0.8125rem;
            color: #64748b;
            margin-top: 0.25rem;
            font-weight: 500;
        }
        .dark .pos-fc-subtitle {
            color: #94a3b8;
        }

        /* 3-Column Grid */
        .pos-fc-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1.25rem;
            width: 100%;
        }
        @media (max-width: 1024px) {
            .pos-fc-grid {
                grid-template-columns: repeat(1, minmax(0, 1fr));
            }
        }

        /* Card Architecture */
        .pos-fc-card {
            background: #ffffff;
            border-radius: 1rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 12px -2px rgba(0, 0, 0, 0.04);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
            transition: all 0.2s ease;
        }
        .dark .pos-fc-card {
            background: #1e293b;
            border-color: #334155;
        }
        .pos-fc-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px -4px rgba(0, 0, 0, 0.08);
        }

        /* Card Theming Borders */
        .pos-fc-card.vat-card {
            border-top: 5px solid #10b981;
        }
        .pos-fc-card.service-card {
            border-top: 5px solid #f59e0b;
        }
        .pos-fc-card.card-card {
            border-top: 5px solid #6366f1;
        }

        .pos-fc-card-body {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .pos-fc-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px dashed #e2e8f0;
        }
        .dark .pos-fc-card-header {
            border-bottom-color: #334155;
        }

        .pos-fc-card-icon-wrap {
            width: 2.75rem;
            height: 2.75rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            flex-shrink: 0;
        }
        .vat-card .pos-fc-card-icon-wrap {
            background: #ecfdf5;
            color: #059669;
            border: 1px solid #a7f3d0;
        }
        .dark .vat-card .pos-fc-card-icon-wrap {
            background: rgba(16, 185, 129, 0.15);
            border-color: rgba(16, 185, 129, 0.3);
        }

        .service-card .pos-fc-card-icon-wrap {
            background: #fffbeb;
            color: #d97706;
            border: 1px solid #fde68a;
        }
        .dark .service-card .pos-fc-card-icon-wrap {
            background: rgba(245, 158, 11, 0.15);
            border-color: rgba(245, 158, 11, 0.3);
        }

        .card-card .pos-fc-card-icon-wrap {
            background: #eef2ff;
            color: #4f46e5;
            border: 1px solid #c7d2fe;
        }
        .dark .card-card .pos-fc-card-icon-wrap {
            background: rgba(99, 102, 241, 0.15);
            border-color: rgba(99, 102, 241, 0.3);
        }

        .pos-fc-card-title-text {
            font-size: 1rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.2;
        }
        .dark .pos-fc-card-title-text {
            color: #f8fafc;
        }

        .pos-fc-card-desc-text {
            font-size: 0.75rem;
            color: #64748b;
            font-weight: 500;
        }
        .dark .pos-fc-card-desc-text {
            color: #94a3b8;
        }

        /* Interactive Toggle Switch */
        .pos-toggle-btn {
            width: 3.5rem;
            height: 2rem;
            border-radius: 9999px;
            position: relative;
            cursor: pointer;
            border: none;
            outline: none;
            transition: background-color 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            flex-shrink: 0;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.15);
        }
        .pos-toggle-btn .thumb {
            width: 1.6rem;
            height: 1.6rem;
            background: #ffffff;
            border-radius: 9999px;
            position: absolute;
            top: 0.2rem;
            left: 0.25rem;
            transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.65rem;
            font-weight: 900;
        }
        .pos-toggle-btn.active.vat-toggle {
            background: #10b981 !important;
        }
        .pos-toggle-btn.active.service-toggle {
            background: #f59e0b !important;
        }
        .pos-toggle-btn.active.card-toggle {
            background: #6366f1 !important;
        }
        .pos-toggle-btn.inactive {
            background: #cbd5e1 !important;
        }
        .dark .pos-toggle-btn.inactive {
            background: #475569 !important;
        }
        .pos-toggle-btn.active .thumb {
            transform: translateX(1.4rem);
        }

        /* Status Pills */
        .pos-status-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.6875rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.25rem 0.625rem;
            border-radius: 9999px;
        }
        .pos-status-pill.emerald {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        .dark .pos-status-pill.emerald {
            background: rgba(16, 185, 129, 0.2);
            color: #34d399;
            border-color: rgba(16, 185, 129, 0.35);
        }
        .pos-status-pill.amber {
            background: #fffbeb;
            color: #92400e;
            border: 1px solid #fde68a;
        }
        .dark .pos-status-pill.amber {
            background: rgba(245, 158, 11, 0.2);
            color: #fbbf24;
            border-color: rgba(245, 158, 11, 0.35);
        }
        .pos-status-pill.indigo {
            background: #eef2ff;
            color: #3730a3;
            border: 1px solid #c7d2fe;
        }
        .dark .pos-status-pill.indigo {
            background: rgba(99, 102, 241, 0.2);
            color: #818cf8;
            border-color: rgba(99, 102, 241, 0.35);
        }
        .pos-status-pill.slate {
            background: #f1f5f9;
            color: #64748b;
            border: 1px solid #cbd5e1;
        }
        .dark .pos-status-pill.slate {
            background: #334155;
            color: #94a3b8;
            border-color: #475569;
        }

        /* Styled Input Groups */
        .pos-input-group {
            display: flex;
            flex-direction: column;
            gap: 0.375rem;
        }
        .pos-input-label {
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #334155;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .dark .pos-input-label {
            color: #cbd5e1;
        }

        .pos-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }
        .pos-input-box {
            width: 100%;
            height: 2.75rem;
            border-radius: 0.625rem;
            border: 1.5px solid #cbd5e1;
            background: #ffffff;
            color: #0f172a;
            padding: 0 0.875rem;
            font-size: 0.9375rem;
            font-weight: 700;
            font-family: inherit;
            outline: none;
            transition: all 0.2s ease;
        }
        .dark .pos-input-box {
            background: #0f172a;
            border-color: #334155;
            color: #f8fafc;
        }
        .pos-input-box:focus {
            border-color: #D4A437;
            box-shadow: 0 0 0 3px rgba(212, 164, 55, 0.25);
        }
        .pos-input-suffix {
            position: absolute;
            right: 0.75rem;
            font-size: 0.75rem;
            font-weight: 900;
            color: #64748b;
            pointer-events: none;
            background: #f1f5f9;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            border: 1px solid #cbd5e1;
        }
        .dark .pos-input-suffix {
            background: #1e293b;
            color: #94a3b8;
            border-color: #334155;
        }

        /* Preset Chips */
        .pos-preset-chips {
            display: flex;
            align-items: center;
            gap: 0.35rem;
            flex-wrap: wrap;
            margin-top: 0.25rem;
        }
        .pos-chip-btn {
            font-size: 0.6875rem;
            font-weight: 800;
            padding: 0.25rem 0.6rem;
            border-radius: 0.5rem;
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            color: #334155;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .dark .pos-chip-btn {
            background: #0f172a;
            border-color: #334155;
            color: #cbd5e1;
        }
        .pos-chip-btn:hover {
            border-color: #D4A437;
            background: #fffbeb;
            color: #b45309;
            transform: translateY(-1px);
        }
        .dark .pos-chip-btn:hover {
            background: rgba(212, 164, 55, 0.2);
            color: #fde68a;
            border-color: #D4A437;
        }
        .pos-chip-btn.active {
            background: #D4A437;
            color: #000;
            border-color: #b45309;
        }

        /* Card Footer */
        .pos-fc-card-footer {
            padding: 0.875rem 1.5rem;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .dark .pos-fc-card-footer {
            background: #0f172a;
            border-color: #334155;
            color: #94a3b8;
        }

        /* Live Simulator Box */
        .pos-simulator-box {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 15px -3px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .dark .pos-simulator-box {
            background: #1e293b;
            border-color: #334155;
        }

        .pos-sim-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.75rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #e2e8f0;
        }
        .dark .pos-sim-header {
            border-bottom-color: #334155;
        }

        .pos-sim-title {
            font-size: 0.9375rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .dark .pos-sim-title {
            color: #f8fafc;
        }

        .pos-sim-metrics-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1rem;
        }
        @media (max-width: 900px) {
            .pos-sim-metrics-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
        @media (max-width: 550px) {
            .pos-sim-metrics-grid {
                grid-template-columns: repeat(1, minmax(0, 1fr));
            }
        }

        .pos-sim-card {
            padding: 1rem;
            border-radius: 0.75rem;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            transition: all 0.15s ease;
        }
        .dark .pos-sim-card {
            background: #0f172a;
            border-color: #334155;
        }
        .pos-sim-card.highlight-amber {
            background: #fffbeb;
            border-color: #fde68a;
        }
        .dark .pos-sim-card.highlight-amber {
            background: rgba(245, 158, 11, 0.1);
            border-color: rgba(245, 158, 11, 0.3);
        }
        .pos-sim-card.highlight-emerald {
            background: #ecfdf5;
            border-color: #a7f3d0;
        }
        .dark .pos-sim-card.highlight-emerald {
            background: rgba(16, 185, 129, 0.1);
            border-color: rgba(16, 185, 129, 0.3);
        }
        .pos-sim-card.highlight-total {
            background: linear-gradient(135deg, #1e1b18 0%, #000000 100%);
            border-color: #D4A437;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(212, 164, 55, 0.25);
        }

        .pos-sim-label {
            font-size: 0.6875rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
        }
        .dark .pos-sim-label {
            color: #94a3b8;
        }
        .highlight-amber .pos-sim-label {
            color: #b45309;
        }
        .dark .highlight-amber .pos-sim-label {
            color: #fbbf24;
        }
        .highlight-emerald .pos-sim-label {
            color: #047857;
        }
        .dark .highlight-emerald .pos-sim-label {
            color: #34d399;
        }
        .highlight-total .pos-sim-label {
            color: #D4A437;
        }

        .pos-sim-val {
            font-size: 1.25rem;
            font-weight: 900;
            color: #0f172a;
            font-family: monospace;
        }
        .dark .pos-sim-val {
            color: #f8fafc;
        }
        .highlight-amber .pos-sim-val {
            color: #d97706;
        }
        .dark .highlight-amber .pos-sim-val {
            color: #f59e0b;
        }
        .highlight-emerald .pos-sim-val {
            color: #059669;
        }
        .dark .highlight-emerald .pos-sim-val {
            color: #10b981;
        }
        .highlight-total .pos-sim-val {
            color: #34d399;
            font-size: 1.35rem;
        }

        /* Action Buttons */
        .pos-save-btn {
            background: linear-gradient(135deg, #D4A437 0%, #b8860b 100%);
            color: #000000;
            font-weight: 900;
            font-size: 0.8125rem;
            letter-spacing: 0.04em;
            padding: 0.65rem 1.35rem;
            border-radius: 0.625rem;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 14px rgba(212, 164, 55, 0.4);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            text-transform: uppercase;
        }
        .pos-save-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(212, 164, 55, 0.6);
            background: linear-gradient(135deg, #dfb44e 0%, #c49216 100%);
        }
        .pos-save-btn:active {
            transform: translateY(0);
        }

        .pos-reset-btn {
            background: #f8fafc;
            color: #64748b;
            border: 1px solid #cbd5e1;
            font-weight: 800;
            font-size: 0.75rem;
            padding: 0.65rem 1rem;
            border-radius: 0.625rem;
            cursor: pointer;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }
        .dark .pos-reset-btn {
            background: #0f172a;
            border-color: #334155;
            color: #94a3b8;
        }
        .pos-reset-btn:hover {
            background: #fef2f2;
            color: #dc2626;
            border-color: #fca5a5;
        }
    </style>

    <div class="pos-fc-container">

        <!-- 1. Top Header Banner -->
        <div class="pos-fc-header">
            <div style="display: flex; align-items: center; gap: 0.875rem;">
                <div style="width: 3rem; height: 3rem; border-radius: 0.75rem; background: #fffbeb; border: 1.5px solid #D4A437; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0;">
                    👑
                </div>
                <div>
                    <div class="pos-fc-title">
                        <span>POS Financial Terminal Control</span>
                        <span style="font-size: 0.6875rem; font-weight: 800; background: #D4A437; color: #000; padding: 0.15rem 0.5rem; border-radius: 0.375rem; text-transform: uppercase;">
                            Royal Back-Office
                        </span>
                    </div>
                    <div class="pos-fc-subtitle">
                        Live VAT/GST taxation, table hospitality service charges, and POS bank terminal configuration across all registers.
                    </div>
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <button wire:click="resetToDefaults" type="button" class="pos-reset-btn" title="Reset all rates to Nawabi defaults">
                    <span>↺</span>
                    <span>Reset Defaults</span>
                </button>
                <button wire:click="saveSettings" type="button" class="pos-save-btn">
                    <span>💾</span>
                    <span>SAVE & APPLY SETTINGS</span>
                </button>
            </div>
        </div>

        <!-- 2. The 3-Column Configuration Grid (In One Single Row on Desktop) -->
        <div class="pos-fc-grid">

            <!-- ===================== COLUMN 1: VAT / GST TAX ===================== -->
            <div class="pos-fc-card vat-card">
                <div class="pos-fc-card-body">
                    <!-- Header with Toggle -->
                    <div class="pos-fc-card-header">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div class="pos-fc-card-icon-wrap">
                                🏛️
                            </div>
                            <div>
                                <div class="pos-fc-card-title-text">VAT / GST Tax</div>
                                <div class="pos-fc-card-desc-text">Sales Tax (PRA / GST)</div>
                            </div>
                        </div>

                        <!-- Emerald Custom Toggle Switch -->
                        <button wire:click="toggleVat" type="button" class="pos-toggle-btn vat-toggle {{ $vatEnabled ? 'active' : 'inactive' }}" title="Click to Toggle VAT">
                            <span class="thumb">{{ $vatEnabled ? 'ON' : '' }}</span>
                        </button>
                    </div>

                    <!-- Live Status Indicator -->
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <span style="font-size: 0.75rem; font-weight: 700; color: #64748b;">Current Tax State:</span>
                        <span class="pos-status-pill {{ $vatEnabled ? 'emerald' : 'slate' }}">
                            {{ $vatEnabled ? "● ACTIVE ({$vatPercentage}%)" : '○ EXEMPT / OFF' }}
                        </span>
                    </div>

                    <!-- Input: Tax Percentage -->
                    <div class="pos-input-group">
                        <label class="pos-input-label">
                            <span>Tax Percentage Rate</span>
                            <span style="font-size: 0.65rem; color: #10b981; font-weight: 800;">AUTO APPLIED</span>
                        </label>
                        <div class="pos-input-wrapper">
                            <input type="number" step="0.1" min="0" max="100" wire:model.lazy="vatPercentage" class="pos-input-box" />
                            <span class="pos-input-suffix">% RATE</span>
                        </div>

                        <!-- Quick Presets -->
                        <div class="pos-preset-chips">
                            <span style="font-size: 0.65rem; font-weight: 700; color: #94a3b8; margin-right: 0.25rem;">Presets:</span>
                            <button type="button" wire:click="setVatPreset(0, 'Tax Exempt (0%)')" class="pos-chip-btn {{ $vatPercentage == 0 ? 'active' : '' }}">0% Exempt</button>
                            <button type="button" wire:click="setVatPreset(5, 'GST Tax (5%)')" class="pos-chip-btn {{ $vatPercentage == 5 ? 'active' : '' }}">5%</button>
                            <button type="button" wire:click="setVatPreset(13, 'PRA Tax (13%)')" class="pos-chip-btn {{ $vatPercentage == 13 ? 'active' : '' }}">13%</button>
                            <button type="button" wire:click="setVatPreset(16, 'GST Tax (16%)')" class="pos-chip-btn {{ $vatPercentage == 16 ? 'active' : '' }}">16% PRA</button>
                            <button type="button" wire:click="setVatPreset(18, 'Standard GST (18%)')" class="pos-chip-btn {{ $vatPercentage == 18 ? 'active' : '' }}">18%</button>
                        </div>
                    </div>

                    <!-- Input: Receipt Tax Label -->
                    <div class="pos-input-group">
                        <label class="pos-input-label">
                            <span>Thermal Receipt Tax Title</span>
                        </label>
                        <div class="pos-input-wrapper">
                            <input type="text" wire:model.lazy="vatLabel" placeholder="e.g. GST Tax (16%)" class="pos-input-box" />
                        </div>
                    </div>
                </div>

                <div class="pos-fc-card-footer">
                    <span>Target Registers:</span>
                    <span style="font-weight: 800; color: #10b981;">Cashier POS + Waiter Pad</span>
                </div>
            </div>

            <!-- ===================== COLUMN 2: SERVICE FEE CHARGES ===================== -->
            <div class="pos-fc-card service-card">
                <div class="pos-fc-card-body">
                    <!-- Header with Toggle -->
                    <div class="pos-fc-card-header">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div class="pos-fc-card-icon-wrap">
                                🍽️
                            </div>
                            <div>
                                <div class="pos-fc-card-title-text">Service Fee</div>
                                <div class="pos-fc-card-desc-text">Table Hospitality Charge</div>
                            </div>
                        </div>

                        <!-- Amber Custom Toggle Switch -->
                        <button wire:click="toggleServiceFee" type="button" class="pos-toggle-btn service-toggle {{ $serviceFeeEnabled ? 'active' : 'inactive' }}" title="Click to Toggle Service Fee">
                            <span class="thumb">{{ $serviceFeeEnabled ? 'ON' : '' }}</span>
                        </button>
                    </div>

                    <!-- Live Status Indicator -->
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <span style="font-size: 0.75rem; font-weight: 700; color: #64748b;">Service Fee State:</span>
                        <span class="pos-status-pill {{ $serviceFeeEnabled ? 'amber' : 'slate' }}">
                            {{ $serviceFeeEnabled ? "● ACTIVE ({$serviceFeePercentage}%)" : '○ DISABLED (0%)' }}
                        </span>
                    </div>

                    <!-- Input: Service Fee Percentage -->
                    <div class="pos-input-group">
                        <label class="pos-input-label">
                            <span>Service Percentage Rate</span>
                            <span style="font-size: 0.65rem; color: #f59e0b; font-weight: 800;">DINE-IN ONLY</span>
                        </label>
                        <div class="pos-input-wrapper">
                            <input type="number" step="0.1" min="0" max="100" wire:model.lazy="serviceFeePercentage" class="pos-input-box" />
                            <span class="pos-input-suffix">% FEE</span>
                        </div>

                        <!-- Quick Presets -->
                        <div class="pos-preset-chips">
                            <span style="font-size: 0.65rem; font-weight: 700; color: #94a3b8; margin-right: 0.25rem;">Presets:</span>
                            <button type="button" wire:click="setServiceFeePreset(0)" class="pos-chip-btn {{ $serviceFeePercentage == 0 ? 'active' : '' }}">0% Waived</button>
                            <button type="button" wire:click="setServiceFeePreset(3)" class="pos-chip-btn {{ $serviceFeePercentage == 3 ? 'active' : '' }}">3%</button>
                            <button type="button" wire:click="setServiceFeePreset(5)" class="pos-chip-btn {{ $serviceFeePercentage == 5 ? 'active' : '' }}">5% Std</button>
                            <button type="button" wire:click="setServiceFeePreset(7.5)" class="pos-chip-btn {{ $serviceFeePercentage == 7.5 ? 'active' : '' }}">7.5%</button>
                            <button type="button" wire:click="setServiceFeePreset(10)" class="pos-chip-btn {{ $serviceFeePercentage == 10 ? 'active' : '' }}">10% VIP</button>
                        </div>
                    </div>

                    <!-- Scope & Application Box -->
                    <div class="pos-input-group">
                        <label class="pos-input-label">
                            <span>Floor Scope</span>
                        </label>
                        <div style="padding: 0.75rem; border-radius: 0.625rem; background: #fffbeb; border: 1px solid #fde68a; font-size: 0.75rem; color: #92400e; display: flex; align-items: center; gap: 0.5rem; font-weight: 700;">
                            <span style="font-size: 1rem;">🪑</span>
                            <span>Applied exclusively to Dine-In Floor Tables</span>
                        </div>
                    </div>
                </div>

                <div class="pos-fc-card-footer">
                    <span>Takeaway & Counter Orders:</span>
                    <span style="font-weight: 800; color: #f59e0b;">Exempt from Service Fee</span>
                </div>
            </div>

            <!-- ===================== COLUMN 3: POS CARD SECTION ===================== -->
            <div class="pos-fc-card card-card">
                <div class="pos-fc-card-body">
                    <!-- Header with Toggle -->
                    <div class="pos-fc-card-header">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div class="pos-fc-card-icon-wrap">
                                💳
                            </div>
                            <div>
                                <div class="pos-fc-card-title-text">POS Card Section</div>
                                <div class="pos-fc-card-desc-text">Bank Terminal & Gateway</div>
                            </div>
                        </div>

                        <!-- Indigo Custom Toggle Switch -->
                        <button wire:click="toggleCardPayment" type="button" class="pos-toggle-btn card-toggle {{ $cardPaymentEnabled ? 'active' : 'inactive' }}" title="Click to Toggle Card Payments">
                            <span class="thumb">{{ $cardPaymentEnabled ? 'ON' : '' }}</span>
                        </button>
                    </div>

                    <!-- Live Status Indicator -->
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <span style="font-size: 0.75rem; font-weight: 700; color: #64748b;">Cashier Gateway Status:</span>
                        <span class="pos-status-pill {{ $cardPaymentEnabled ? 'indigo' : 'slate' }}">
                            {{ $cardPaymentEnabled ? '● CARDS ACCEPTED' : '🚫 CARDS LOCKED' }}
                        </span>
                    </div>

                    <!-- Input: Card Surcharge Rate -->
                    <div class="pos-input-group">
                        <label class="pos-input-label">
                            <span>Card Surcharge Fee Rate</span>
                            <span style="font-size: 0.65rem; color: #6366f1; font-weight: 800;">MDR CHARGE</span>
                        </label>
                        <div class="pos-input-wrapper">
                            <input type="number" step="0.1" min="0" max="100" wire:model.lazy="cardFeePercentage" class="pos-input-box" />
                            <span class="pos-input-suffix">% FEE</span>
                        </div>

                        <!-- Quick Presets -->
                        <div class="pos-preset-chips">
                            <span style="font-size: 0.65rem; font-weight: 700; color: #94a3b8; margin-right: 0.25rem;">Presets:</span>
                            <button type="button" wire:click="setCardFeePreset(0)" class="pos-chip-btn {{ $cardFeePercentage == 0 ? 'active' : '' }}">0% Free</button>
                            <button type="button" wire:click="setCardFeePreset(1.5)" class="pos-chip-btn {{ $cardFeePercentage == 1.5 ? 'active' : '' }}">1.5%</button>
                            <button type="button" wire:click="setCardFeePreset(2)" class="pos-chip-btn {{ $cardFeePercentage == 2 ? 'active' : '' }}">2% Bank MDR</button>
                            <button type="button" wire:click="setCardFeePreset(2.5)" class="pos-chip-btn {{ $cardFeePercentage == 2.5 ? 'active' : '' }}">2.5%</button>
                        </div>
                    </div>

                    <!-- Input: Terminal Title -->
                    <div class="pos-input-group">
                        <label class="pos-input-label">
                            <span>Terminal Label on POS</span>
                        </label>
                        <div class="pos-input-wrapper">
                            <input type="text" wire:model.lazy="cardTerminalName" placeholder="Bank POS / Cards" class="pos-input-box" />
                        </div>
                    </div>
                </div>

                <div class="pos-fc-card-footer">
                    <span>Checkout Modal Behavior:</span>
                    <span style="font-weight: 800; color: {{ $cardPaymentEnabled ? '#6366f1' : '#ef4444' }};">
                        {{ $cardPaymentEnabled ? 'Enabled & Clickable' : 'Disabled (Cash-Only)' }}
                    </span>
                </div>
            </div>

        </div>

        <!-- 3. Real-time Bill Calculation Simulator -->
        @php
            $sampleSubtotal = 2500;
            $sampleServiceFee = $serviceFeeEnabled ? ($sampleSubtotal * ($serviceFeePercentage / 100)) : 0;
            $sampleVat = $vatEnabled ? ($sampleSubtotal * ($vatPercentage / 100)) : 0;
            $sampleGrandTotal = $sampleSubtotal + $sampleServiceFee + $sampleVat;
        @endphp
        <div class="pos-simulator-box">
            <div class="pos-sim-header">
                <div class="pos-sim-title">
                    <span>🧾</span>
                    <span>Real-Time Bill Calculation Simulator</span>
                    <span style="font-size: 0.7rem; font-weight: 700; color: #64748b; text-transform: none;">(Sample Rs. 2,500 Dine-In Table Order)</span>
                </div>

                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span style="font-size: 0.75rem; font-weight: 700; color: #10b981;">🟢 Live Sync Ready</span>
                    <button wire:click="saveSettings" type="button" class="pos-save-btn" style="padding: 0.5rem 1rem; font-size: 0.75rem;">
                        <span>💾</span>
                        <span>Save & Apply</span>
                    </button>
                </div>
            </div>

            <!-- 4 Visual Metric Cards -->
            <div class="pos-sim-metrics-grid">
                <!-- Subtotal -->
                <div class="pos-sim-card">
                    <span class="pos-sim-label">1. Food Subtotal</span>
                    <span class="pos-sim-val">Rs. {{ number_format($sampleSubtotal, 0) }}</span>
                    <span style="font-size: 0.65rem; color: #94a3b8; font-weight: 600;">Base food items ordered</span>
                </div>

                <!-- Service Fee -->
                <div class="pos-sim-card {{ $serviceFeeEnabled ? 'highlight-amber' : '' }}">
                    <span class="pos-sim-label">
                        2. Service Fee ({{ $serviceFeeEnabled ? $serviceFeePercentage . '%' : 'OFF' }})
                    </span>
                    <span class="pos-sim-val">
                        {{ $serviceFeeEnabled ? '+ Rs. ' . number_format($sampleServiceFee, 0) : 'Rs. 0' }}
                    </span>
                    <span style="font-size: 0.65rem; color: {{ $serviceFeeEnabled ? '#b45309' : '#94a3b8' }}; font-weight: 600;">
                        {{ $serviceFeeEnabled ? 'Table hospitality included' : 'No service fee charged' }}
                    </span>
                </div>

                <!-- VAT Tax -->
                <div class="pos-sim-card {{ $vatEnabled ? 'highlight-emerald' : '' }}">
                    <span class="pos-sim-label">
                        3. VAT / GST ({{ $vatEnabled ? $vatPercentage . '%' : 'OFF' }})
                    </span>
                    <span class="pos-sim-val">
                        {{ $vatEnabled ? '+ Rs. ' . number_format($sampleVat, 0) : 'Rs. 0' }}
                    </span>
                    <span style="font-size: 0.65rem; color: {{ $vatEnabled ? '#047857' : '#94a3b8' }}; font-weight: 600;">
                        {{ $vatEnabled ? $vatLabel : 'Tax exempt / zero rated' }}
                    </span>
                </div>

                <!-- Final Customer Total -->
                <div class="pos-sim-card highlight-total">
                    <span class="pos-sim-label">4. Final Bill Total</span>
                    <span class="pos-sim-val">Rs. {{ number_format($sampleGrandTotal, 0) }}</span>
                    <span style="font-size: 0.65rem; color: #D4A437; font-weight: 700;">Customer payable amount</span>
                </div>
            </div>
        </div>

    </div>
</x-filament-panels::page>
