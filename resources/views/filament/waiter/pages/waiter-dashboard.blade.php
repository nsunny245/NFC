<x-filament-panels::page>
    <!-- HANDHELD MOBILE & TABLET POS APP STYLING (DARK & LIGHT MODE) -->
    <style>
        /* 1. Reset Filament desktop shell and lock window scroll */
        html, body {
            height: 100% !important;
            max-height: 100% !important;
            overflow: hidden !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }
        .fi-topbar, .fi-header, .fi-breadcrumbs {
            display: none !important;
        }
        .fi-layout, .fi-main, .fi-main-ctn, .fi-page, .fi-page-content, .fi-page > section {
            padding: 0 !important;
            margin: 0 !important;
            max-width: 100% !important;
            height: 100% !important;
            max-height: 100% !important;
            overflow: hidden !important;
        }

        /* 2. CSS Design Tokens for Light & Dark Modes */
        .pos-handheld-shell {
            --wp-bg: #F4F6F9;
            --wp-surface: #FFFFFF;
            --wp-surface-hover: #F8FAFC;
            --wp-surface-card: #FFFFFF;
            --wp-surface-subtle: #F1F5F9;
            --wp-border: #E2E8F0;
            --wp-border-subtle: #EDF2F7;
            --wp-text-primary: #0F172A;
            --wp-text-secondary: #475569;
            --wp-text-muted: #94A3B8;
            --wp-gold: #D4A437;
            --wp-gold-bg: #FEF3C7;
            --wp-gold-border: #FCD34D;
            --wp-gold-text: #92400E;
            --wp-emerald: #10B981;
            --wp-emerald-dark: #059669;
            --wp-emerald-bg: #ECFDF5;
            --wp-emerald-border: #A7F3D0;
            --wp-emerald-text: #065F46;
            --wp-rose: #F43F5E;
            --wp-rose-bg: #FFF1F2;
            --wp-rose-border: #FECDD3;
            --wp-rose-text: #9F1239;
            --wp-nav-bg: rgba(255, 255, 255, 0.96);
            --wp-nav-border: #E2E8F0;
            --wp-header-bg: rgba(255, 255, 255, 0.98);
            --wp-header-border: #E2E8F0;
            --wp-modal-bg: #FFFFFF;
            --wp-modal-backdrop: rgba(15, 23, 42, 0.65);
            --wp-card-shadow: 0 2px 8px -2px rgba(15, 23, 42, 0.06), 0 1px 3px -1px rgba(15, 23, 42, 0.04);
            --wp-card-hover-shadow: 0 8px 16px -4px rgba(15, 23, 42, 0.1);
            --wp-card-active: #F1F5F9;
            --wp-dock-active: #0F172A;
            --wp-dock-active-text: #FFFFFF;

            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Inter", Helvetica, Arial, sans-serif;
            background-color: var(--wp-bg);
            color: var(--wp-text-primary);
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            width: 100% !important;
            height: 100% !important;
            max-height: 100% !important;
            display: flex !important;
            flex-direction: column !important;
            overflow: hidden !important;
            box-sizing: border-box !important;
            user-select: none;
            -webkit-user-select: none;
            -webkit-tap-highlight-color: transparent;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .pos-handheld-shell.theme-dark {
            --wp-bg: #090D16;
            --wp-surface: #111827;
            --wp-surface-hover: #1A2234;
            --wp-surface-card: #131C2E;
            --wp-surface-subtle: #162032;
            --wp-border: #1E293B;
            --wp-border-subtle: #192338;
            --wp-text-primary: #F8FAFC;
            --wp-text-secondary: #CBD5E1;
            --wp-text-muted: #64748B;
            --wp-gold: #F59E0B;
            --wp-gold-bg: rgba(245, 158, 11, 0.15);
            --wp-gold-border: rgba(245, 158, 11, 0.35);
            --wp-gold-text: #FBBF24;
            --wp-emerald: #10B981;
            --wp-emerald-dark: #059669;
            --wp-emerald-bg: rgba(16, 185, 129, 0.14);
            --wp-emerald-border: rgba(16, 185, 129, 0.3);
            --wp-emerald-text: #34D399;
            --wp-rose: #FB7185;
            --wp-rose-bg: rgba(244, 63, 94, 0.15);
            --wp-rose-border: rgba(244, 63, 94, 0.3);
            --wp-rose-text: #FDA4AF;
            --wp-nav-bg: rgba(17, 24, 39, 0.96);
            --wp-nav-border: #1E293B;
            --wp-header-bg: rgba(17, 24, 39, 0.98);
            --wp-header-border: #1E293B;
            --wp-modal-bg: #111827;
            --wp-modal-backdrop: rgba(0, 0, 0, 0.82);
            --wp-card-shadow: 0 4px 14px -2px rgba(0, 0, 0, 0.5);
            --wp-card-hover-shadow: 0 8px 24px -4px rgba(0, 0, 0, 0.65);
            --wp-card-active: #1A2234;
            --wp-dock-active: #D4A437;
            --wp-dock-active-text: #000000;
        }

        /* 3. Header Bar */
        .handheld-header {
            height: 54px;
            background: var(--wp-header-bg);
            border-bottom: 1px solid var(--wp-header-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            flex-shrink: 0;
            z-index: 40;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .handheld-header-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .handheld-logo {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 2px solid var(--wp-gold);
            object-fit: cover;
            background: #FFFFFF;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
        }
        .handheld-title {
            font-size: 14px;
            font-weight: 800;
            color: var(--wp-text-primary);
            line-height: 1.1;
            margin: 0;
            letter-spacing: -0.2px;
        }
        .handheld-server {
            font-size: 11px;
            font-weight: 600;
            color: var(--wp-text-muted);
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 1px;
        }
        .status-dot-green {
            width: 7px;
            height: 7px;
            background-color: var(--wp-emerald);
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 6px var(--wp-emerald);
        }

        /* Dark / Light Mode Toggle Button */
        .theme-toggle-btn {
            background: var(--wp-surface-subtle);
            border: 1px solid var(--wp-border);
            color: var(--wp-text-secondary);
            border-radius: 20px;
            padding: 5px 10px;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.2s ease;
        }
        .theme-toggle-btn:active {
            transform: scale(0.94);
        }
        .theme-toggle-btn:hover {
            border-color: var(--wp-gold);
            color: var(--wp-text-primary);
        }

        /* Active Table Pill in Header */
        .table-pill-header {
            background: var(--wp-gold-bg);
            border: 1.5px solid var(--wp-gold-border);
            color: var(--wp-gold-text);
            font-size: 11.5px;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .btn-table-change {
            background: var(--wp-surface);
            border: 1px solid var(--wp-gold);
            color: var(--wp-gold-text);
            border-radius: 12px;
            padding: 2px 8px;
            font-size: 10px;
            font-weight: 800;
            cursor: pointer;
            transition: transform 0.15s;
        }
        .btn-table-change:active {
            transform: scale(0.92);
        }

        /* 4. Main Content Viewport */
        .handheld-main-viewport {
            flex: 1;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            padding: 12px 12px 76px 12px;
            box-sizing: border-box;
        }

        /* 5. Modern Segmented Zone Control Bar */
        .zone-segmented-bar {
            display: flex;
            gap: 6px;
            overflow-x: auto;
            padding-bottom: 2px;
            margin-bottom: 12px;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }
        .zone-segmented-bar::-webkit-scrollbar {
            display: none;
        }
        .zone-segment-pill {
            flex: 1;
            min-width: 82px;
            white-space: nowrap;
            border-radius: 12px;
            padding: 8px 10px;
            font-size: 11px;
            font-weight: 800;
            border: 1px solid var(--wp-border);
            background: var(--wp-surface-card);
            color: var(--wp-text-secondary);
            cursor: pointer;
            text-align: center;
            transition: all 0.15s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
        }
        .zone-segment-pill:active {
            transform: scale(0.96);
        }
        .zone-segment-pill.active {
            background: var(--wp-text-primary);
            color: var(--wp-bg);
            border-color: var(--wp-text-primary);
            box-shadow: 0 3px 8px rgba(0,0,0,0.15);
        }
        .pos-handheld-shell.theme-dark .zone-segment-pill.active {
            background: var(--wp-gold);
            color: #000000;
            border-color: var(--wp-gold);
            box-shadow: 0 3px 12px rgba(212, 164, 55, 0.3);
        }

        /* 6. Redesigned Modern Table Cards */
        .tables-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }
        @media (min-width: 640px) {
            .tables-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 12px;
            }
        }
        @media (min-width: 960px) {
            .tables-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 12px;
            }
        }

        .table-app-card {
            background: var(--wp-surface-card);
            border: 1.5px solid var(--wp-border);
            border-radius: 16px;
            padding: 12px;
            cursor: pointer;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 124px;
            box-shadow: var(--wp-card-shadow);
            transition: all 0.18s cubic-bezier(0.4, 0, 0.2, 1);
            box-sizing: border-box;
            overflow: hidden;
        }
        .table-app-card:hover {
            box-shadow: var(--wp-card-hover-shadow);
            transform: translateY(-1px);
        }
        .table-app-card:active {
            transform: scale(0.97);
            background: var(--wp-card-active);
        }

        /* Vacant Table Styling */
        .table-app-card.card-vacant {
            border-color: var(--wp-border);
        }
        .table-app-card.card-vacant::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--wp-emerald);
            border-radius: 16px 16px 0 0;
        }

        /* Occupied Table Styling */
        .table-app-card.card-occupied {
            border-color: var(--wp-rose-border);
            background: var(--wp-surface-card);
        }
        .pos-handheld-shell.theme-dark .table-app-card.card-occupied {
            border-color: rgba(244, 63, 94, 0.35);
        }
        .table-app-card.card-occupied::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--wp-rose);
            border-radius: 16px 16px 0 0;
        }

        /* Card Header & Badges */
        .card-top-meta {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 6px;
            margin-bottom: 8px;
        }
        .table-number-title {
            font-size: 16px;
            font-weight: 800;
            color: var(--wp-text-primary);
            line-height: 1.15;
            letter-spacing: -0.2px;
        }
        .table-zone-sub {
            font-size: 10px;
            font-weight: 600;
            color: var(--wp-text-muted);
            margin-top: 2px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .table-badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 9.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            flex-shrink: 0;
        }
        .badge-vacant {
            background: var(--wp-emerald-bg);
            color: var(--wp-emerald-text);
            border: 1px solid var(--wp-emerald-border);
        }
        .badge-occupied {
            background: var(--wp-rose-bg);
            color: var(--wp-rose-text);
            border: 1px solid var(--wp-rose-border);
        }
        .pulse-dot-green {
            width: 6px;
            height: 6px;
            background: var(--wp-emerald);
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 5px var(--wp-emerald);
        }
        .pulse-dot-rose {
            width: 6px;
            height: 6px;
            background: var(--wp-rose);
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 5px var(--wp-rose);
        }

        /* Card Middle Info */
        .card-middle-info {
            flex: 1;
            margin-bottom: 8px;
        }
        .occupied-order-row {
            font-size: 11px;
            font-weight: 700;
            color: var(--wp-text-secondary);
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 3px;
        }
        .occupied-total-amount {
            font-size: 13px;
            font-weight: 800;
            color: var(--wp-emerald-dark);
        }
        .pos-handheld-shell.theme-dark .occupied-total-amount {
            color: var(--wp-emerald);
        }
        .occupied-timer-tag {
            font-size: 9.5px;
            font-weight: 700;
            color: var(--wp-text-muted);
            display: inline-flex;
            align-items: center;
            gap: 3px;
            margin-top: 2px;
        }

        .vacant-capacity-row {
            font-size: 11px;
            font-weight: 600;
            color: var(--wp-text-muted);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Card Action Button Row */
        .card-action-bar {
            border-top: 1px solid var(--wp-border-subtle);
            padding-top: 7px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .card-action-text-vacant {
            font-size: 10.5px;
            font-weight: 800;
            color: var(--wp-emerald-dark);
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .pos-handheld-shell.theme-dark .card-action-text-vacant {
            color: var(--wp-emerald);
        }
        .card-action-text-occupied {
            font-size: 10.5px;
            font-weight: 800;
            color: var(--wp-rose-text);
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .card-action-arrow {
            font-size: 12px;
            font-weight: 800;
        }

        /* 7. Search & Filter Bar */
        .search-container-box {
            background: var(--wp-surface-card);
            border: 1.5px solid var(--wp-border);
            border-radius: 14px;
            padding: 8px 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
            transition: border-color 0.15s ease;
        }
        .search-container-box:focus-within {
            border-color: var(--wp-gold);
        }
        .search-container-box input {
            border: none;
            outline: none;
            width: 100%;
            font-size: 13px;
            color: var(--wp-text-primary);
            background: transparent;
        }
        .search-container-box input::placeholder {
            color: var(--wp-text-muted);
        }

        /* Category Chips Bar */
        .cat-chips-bar {
            display: flex;
            gap: 6px;
            overflow-x: auto;
            padding-bottom: 4px;
            margin-bottom: 10px;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }
        .cat-chips-bar::-webkit-scrollbar {
            display: none;
        }
        .cat-filter-chip {
            flex-shrink: 0;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 800;
            cursor: pointer;
            border: 1px solid var(--wp-border);
            background: var(--wp-surface-card);
            color: var(--wp-text-secondary);
            transition: all 0.15s;
        }
        .cat-filter-chip:active {
            transform: scale(0.95);
        }
        .cat-filter-chip.active-all {
            border-color: var(--wp-text-primary);
            background: var(--wp-text-primary);
            color: var(--wp-bg);
        }
        .pos-handheld-shell.theme-dark .cat-filter-chip.active-all {
            border-color: var(--wp-gold);
            background: var(--wp-gold);
            color: #000000;
        }
        .cat-filter-chip.active-deals {
            border-color: var(--wp-gold);
            background: var(--wp-gold);
            color: #000000;
        }
        .cat-filter-chip.active-platters {
            border-color: var(--wp-emerald);
            background: var(--wp-emerald);
            color: #FFFFFF;
        }

        /* Category Selector Card */
        .category-selector-card {
            background: var(--wp-surface-card);
            border: 1.5px solid var(--wp-gold);
            border-radius: 14px;
            padding: 10px 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
            cursor: pointer;
            box-shadow: 0 1px 4px rgba(212, 164, 55, 0.12);
            transition: all 0.15s;
        }
        .category-selector-card:active {
            transform: scale(0.98);
            background: var(--wp-gold-bg);
        }
        .cat-card-info {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }
        .cat-card-icon {
            font-size: 20px;
            flex-shrink: 0;
        }
        .cat-card-label {
            font-size: 9.5px;
            font-weight: 700;
            color: var(--wp-text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            line-height: 1;
        }
        .cat-card-title {
            font-size: 13.5px;
            font-weight: 800;
            color: var(--wp-text-primary);
            line-height: 1.2;
            margin-top: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .cat-card-badge {
            background: var(--wp-gold-bg);
            color: var(--wp-gold-text);
            font-size: 11px;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 10px;
            border: 1px solid var(--wp-gold-border);
            flex-shrink: 0;
        }

        /* 8. Food List Rows */
        .dishes-list-layout {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .dish-row-card {
            background: var(--wp-surface-card);
            border: 1px solid var(--wp-border);
            border-radius: 14px;
            padding: 11px 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            box-shadow: var(--wp-card-shadow);
            box-sizing: border-box;
            width: 100%;
            transition: all 0.15s;
        }
        .dish-row-card:active {
            border-color: var(--wp-gold);
        }
        .dish-details-col {
            flex: 1;
            min-width: 0;
        }
        .dish-name-heading {
            font-size: 13.5px;
            font-weight: 800;
            color: var(--wp-text-primary);
            line-height: 1.25;
            margin-bottom: 2px;
            word-break: break-word;
        }
        .dish-price-tag {
            font-size: 13.5px;
            font-weight: 800;
            color: var(--wp-gold);
        }

        /* Stepper & Add Button */
        .btn-add-handheld {
            background-color: #059669 !important;
            color: #FFFFFF !important;
            border: none !important;
            border-radius: 10px !important;
            height: 38px !important;
            min-width: 82px !important;
            padding: 0 14px !important;
            font-size: 13px !important;
            font-weight: 800 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 5px !important;
            cursor: pointer !important;
            box-shadow: 0 2px 6px rgba(5, 150, 105, 0.3) !important;
            transition: all 0.15s !important;
            flex-shrink: 0 !important;
            text-align: center !important;
        }
        .btn-add-handheld:active {
            transform: scale(0.94) !important;
            background-color: #047857 !important;
        }

        .handheld-stepper {
            display: inline-flex;
            align-items: center;
            justify-content: space-between;
            background: var(--wp-surface-subtle);
            border: 1.5px solid var(--wp-border);
            border-radius: 10px;
            height: 38px;
            padding: 0 4px;
            box-sizing: border-box;
            flex-shrink: 0;
            gap: 6px;
        }
        .stepper-btn-minus {
            background: var(--wp-surface);
            border: 1px solid var(--wp-rose);
            color: var(--wp-rose);
            width: 28px;
            height: 28px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 900;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            line-height: 1;
        }
        .stepper-btn-minus:active {
            transform: scale(0.9);
        }
        .stepper-qty-display {
            font-size: 14px;
            font-weight: 800;
            color: var(--wp-text-primary);
            min-width: 20px;
            text-align: center;
        }
        .stepper-btn-plus {
            background: #059669;
            border: 1px solid #047857;
            color: #FFFFFF;
            width: 28px;
            height: 28px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 900;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            line-height: 1;
        }
        .stepper-btn-plus:active {
            transform: scale(0.9);
        }

        /* 9. Tablet Split Layout */
        .handheld-tablet-split {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 16px;
            height: 100%;
        }
        @media (max-width: 860px) {
            .handheld-tablet-split {
                grid-template-columns: 1fr;
            }
            .tablet-order-column {
                display: none !important;
            }
        }
        @media (min-width: 861px) {
            .mobile-bottom-pill-bar {
                display: none !important;
            }
        }

        /* 10. Floating Bottom Cart Bar (Phone) */
        .mobile-bottom-pill-bar {
            position: fixed;
            bottom: 68px;
            left: 12px;
            right: 12px;
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
            color: #FFFFFF;
            border-radius: 16px;
            padding: 10px 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.45);
            z-index: 50;
            cursor: pointer;
            animation: slideInBar 0.2s ease-out;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }
        @keyframes slideInBar {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .mobile-bottom-pill-bar:active {
            transform: scale(0.98);
        }
        .pill-badge-qty {
            background: var(--wp-gold);
            color: #000000;
            font-size: 11px;
            font-weight: 800;
            padding: 3px 8px;
            border-radius: 8px;
        }
        .pill-total-amount {
            font-size: 14.5px;
            font-weight: 800;
            color: #FFFFFF;
        }
        .pill-btn-action {
            background: #059669;
            color: #FFFFFF;
            border: none;
            border-radius: 10px;
            padding: 7px 12px;
            font-size: 12px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* 11. Modern Bottom Sheet Modals */
        .sheet-modal-backdrop {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 58px !important;
            background: var(--wp-modal-backdrop) !important;
            backdrop-filter: blur(6px) !important;
            -webkit-backdrop-filter: blur(6px) !important;
            z-index: 500 !important;
            display: flex !important;
            align-items: flex-end !important;
            justify-content: center !important;
            overflow: hidden !important;
            animation: fadeIn 0.15s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .sheet-modal-box {
            background: var(--wp-modal-bg) !important;
            color: var(--wp-text-primary) !important;
            width: 100% !important;
            max-width: 540px !important;
            border-radius: 24px 24px 0 0 !important;
            padding: 14px 16px 16px 16px !important;
            box-shadow: 0 -8px 30px rgba(0, 0, 0, 0.35) !important;
            max-height: calc(100vh - 110px) !important;
            max-height: calc(100dvh - 110px) !important;
            display: flex !important;
            flex-direction: column !important;
            overflow: hidden !important;
            box-sizing: border-box !important;
            animation: slideUpSheet 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            border-top: 1px solid var(--wp-border);
        }
        @keyframes slideUpSheet {
            from { transform: translateY(100%); }
            to { transform: translateY(0); }
        }
        .sheet-drag-handle {
            width: 40px;
            height: 4px;
            background: var(--wp-border);
            border-radius: 4px;
            margin: 0 auto 10px auto;
            flex-shrink: 0;
        }
        .sheet-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--wp-border);
            padding-bottom: 10px;
            margin-bottom: 12px;
            flex-shrink: 0;
        }
        .sheet-modal-title {
            font-size: 16px;
            font-weight: 800;
            color: var(--wp-text-primary);
            margin: 0;
        }
        .sheet-btn-close {
            background: var(--wp-surface-subtle);
            border: 1px solid var(--wp-border);
            border-radius: 50%;
            width: 30px;
            height: 30px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            color: var(--wp-text-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Categories Modal Grid */
        .cat-modal-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            flex: 1;
            min-height: 0;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            padding: 4px 2px 14px 2px;
        }
        .cat-modal-tile {
            background: var(--wp-surface-card);
            border: 1.5px solid var(--wp-border);
            border-radius: 14px;
            padding: 10px 12px;
            text-align: left;
            cursor: pointer;
            transition: all 0.15s;
        }
        .cat-modal-tile:active {
            transform: scale(0.96);
        }
        .cat-modal-tile.active {
            background: var(--wp-gold-bg);
            border-color: var(--wp-gold);
        }
        .cat-tile-name {
            font-size: 13px;
            font-weight: 800;
            color: var(--wp-text-primary);
            margin-bottom: 2px;
        }
        .cat-tile-tag {
            font-size: 10px;
            font-weight: 700;
            color: var(--wp-gold-text);
        }

        /* 1-Tap Quick Instruction Chips */
        .chips-inline-flex {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin: 6px 0;
        }
        .quick-instruction-chip {
            font-size: 11px;
            font-weight: 700;
            padding: 5px 10px;
            border-radius: 16px;
            border: 1px solid var(--wp-border);
            background: var(--wp-surface-card);
            color: var(--wp-text-secondary);
            cursor: pointer;
            transition: all 0.15s;
        }
        .quick-instruction-chip:active {
            transform: scale(0.94);
        }
        .quick-instruction-chip.selected {
            background: var(--wp-gold);
            color: #000000;
            border-color: var(--wp-gold);
            font-weight: 800;
        }

        /* Large Green KOT Dispatch Button */
        .btn-send-kot {
            width: 100%;
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
            color: #FFFFFF !important;
            border: none;
            border-radius: 14px;
            padding: 14px;
            font-size: 14.5px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.15s;
        }
        .btn-send-kot:active {
            transform: scale(0.97);
            background: #047857;
        }
        .btn-send-kot:disabled {
            background: var(--wp-surface-subtle);
            color: var(--wp-text-muted) !important;
            cursor: not-allowed;
            box-shadow: none;
            transform: none;
            border: 1px solid var(--wp-border);
        }

        /* 12. Floating Bottom Navigation Bar */
        .handheld-bottom-nav {
            position: fixed !important;
            bottom: 0 !important;
            left: 0 !important;
            right: 0 !important;
            height: 58px !important;
            background: var(--wp-nav-bg) !important;
            border-top: 1px solid var(--wp-nav-border) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-around !important;
            z-index: 1000 !important;
            box-shadow: 0 -4px 16px rgba(0, 0, 0, 0.08) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
        }
        .nav-item-tab {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 3px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px 12px;
            position: relative;
            color: var(--wp-text-muted);
            transition: all 0.15s;
            flex: 1;
        }
        .nav-item-tab:active {
            transform: scale(0.92);
        }
        .nav-item-tab.active {
            color: var(--wp-gold);
        }
        .pos-handheld-shell:not(.theme-dark) .nav-item-tab.active {
            color: #0F172A;
        }
        .nav-item-icon {
            font-size: 19px;
            line-height: 1;
        }
        .nav-item-text {
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .nav-item-badge {
            position: absolute;
            top: 3px;
            right: calc(50% - 16px);
            background: var(--wp-rose);
            color: #FFFFFF;
            border-radius: 10px;
            font-size: 9px;
            font-weight: 800;
            padding: 1px 5px;
            line-height: 1.2;
            border: 1.5px solid var(--wp-nav-bg);
        }
    </style>

    <!-- ALPINE ROOT WITH DARK/LIGHT MODE STATE -->
    <div 
        x-data="{ 
            isDark: (localStorage.getItem('waiter_theme') === 'dark' || (!('waiter_theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) 
        }" 
        :class="isDark ? 'theme-dark' : 'theme-light'" 
        class="pos-handheld-shell" 
        wire:poll.5s
    >

        <!-- TOP APP HEADER -->
        <header class="handheld-header">
            <div class="handheld-header-left">
                <img src="{{ asset('images/logo_circular.png') }}" alt="NFC Logo" class="handheld-logo">
                <div>
                    <h1 class="handheld-title">NFC WAITER PAD</h1>
                    <div class="handheld-server">
                        <span class="status-dot-green"></span>
                        <span>{{ filament()->auth()->user()?->name ?? Auth::user()?->name }}</span>
                    </div>
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 8px;">
                @if($selectedTable)
                    @php
                        $tableDisplay = str_starts_with($selectedTable, 'Table') ? $selectedTable : ('Table ' . $selectedTable);
                    @endphp
                    <div class="table-pill-header">
                        <span>🪑 {{ $tableDisplay }}</span>
                        <button wire:click="deselectTable" class="btn-table-change">
                            ✕ Switch
                        </button>
                    </div>
                @else
                    @php
                        $vacantCount = collect($this->tables)->where('status', 'vacant')->count();
                    @endphp
                    <span style="font-size: 11px; font-weight: 800; color: var(--wp-emerald-text); background: var(--wp-emerald-bg); padding: 4px 8px; border-radius: 10px; border: 1px solid var(--wp-emerald-border);">
                        ● {{ $vacantCount }} Vacant
                    </span>
                @endif

                <!-- Dark / Light Mode Switcher -->
                <button 
                    type="button" 
                    @click="isDark = !isDark; localStorage.setItem('waiter_theme', isDark ? 'dark' : 'light')" 
                    class="theme-toggle-btn"
                    :title="isDark ? 'Switch to Light Mode' : 'Switch to Dark Mode'"
                >
                    <span x-show="!isDark" style="display: inline-flex; align-items: center; gap: 3px;">
                        <span>🌙</span>
                        <span>Dark</span>
                    </span>
                    <span x-show="isDark" style="display: inline-flex; align-items: center; gap: 3px;">
                        <span>☀️</span>
                        <span>Light</span>
                    </span>
                </button>

                <!-- Logout Link -->
                <a href="{{ route('filament.waiter.auth.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="font-size: 11px; font-weight: 700; color: var(--wp-text-secondary); text-decoration: none; padding: 4px 8px; border: 1px solid var(--wp-border); border-radius: 8px; background: var(--wp-surface-subtle);">
                    🚪
                </a>
                <form id="logout-form" action="{{ route('filament.waiter.auth.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </header>

        <!-- MAIN VIEWPORT -->
        <main class="handheld-main-viewport">

            <!-- ========================================== -->
            <!-- 1. TAB: TABLES (FLOOR SEATING MAP)         -->
            <!-- ========================================== -->
            @if($currentTab === 'tables' || (!$selectedTable && $currentTab === 'order'))
                <div>
                    <!-- Ready to Serve Alert Banner if any -->
                    @if(count($this->servingNotifications) > 0)
                        <div style="background: var(--wp-emerald-bg); border: 1.5px solid var(--wp-emerald-border); border-radius: 14px; padding: 10px 14px; margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15);">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="font-size: 22px;">🔔</span>
                                <div>
                                    <div style="font-size: 13px; font-weight: 800; color: var(--wp-emerald-text);">
                                        {{ count($this->servingNotifications) }} Order(s) Ready to Serve!
                                    </div>
                                    <div style="font-size: 10.5px; color: var(--wp-text-secondary);">
                                        Plated at pass counter. Tap to deliver.
                                    </div>
                                </div>
                            </div>
                            <button wire:click="setTab('alerts')" style="background: #059669; color: #FFF; border: none; border-radius: 10px; padding: 7px 12px; font-size: 11px; font-weight: 800; cursor: pointer;">
                                View Alerts ➔
                            </button>
                        </div>
                    @endif

                    <!-- Modern Zone Switcher Pills -->
                    <div class="zone-segmented-bar">
                        <button wire:click="setSection('all')" class="zone-segment-pill {{ $activeSection === 'all' ? 'active' : '' }}">
                            🍽️ All (18)
                        </button>
                        <button wire:click="setSection('main_dining')" class="zone-segment-pill {{ $activeSection === 'main_dining' ? 'active' : '' }}">
                            🏢 Main Hall (6)
                        </button>
                        <button wire:click="setSection('family_hall')" class="zone-segment-pill {{ $activeSection === 'family_hall' ? 'active' : '' }}">
                            👨‍👩‍👧 Family (6)
                        </button>
                        <button wire:click="setSection('outdoor_dera')" class="zone-segment-pill {{ $activeSection === 'outdoor_dera' ? 'active' : '' }}">
                            🌿 Dera (6)
                        </button>
                    </div>

                    <!-- Redesigned Modern Table Cards Grid -->
                    <div class="tables-grid">
                        @foreach($this->tables as $table)
                            @php
                                $match = true;
                                if ($activeSection === 'main_dining' && !str_starts_with($table['id'], 'T-')) $match = false;
                                if ($activeSection === 'family_hall' && !str_starts_with($table['id'], 'F-')) $match = false;
                                if ($activeSection === 'outdoor_dera' && !str_starts_with($table['id'], 'O-')) $match = false;
                            @endphp

                            @if($match)
                                <div 
                                    wire:click="selectTableForFeast('{{ $table['id'] }}')" 
                                    class="table-app-card {{ $table['status'] === 'occupied' ? 'card-occupied' : 'card-vacant' }}"
                                >
                                    <!-- Top Meta: Table Number & Status Pill -->
                                    <div class="card-top-meta">
                                        <div>
                                            <div class="table-number-title">{{ $table['id'] }}</div>
                                            <div class="table-zone-sub">
                                                <span>{{ $table['section'] }}</span>
                                            </div>
                                        </div>

                                        @if($table['status'] === 'vacant')
                                            <span class="table-badge-pill badge-vacant">
                                                <span class="pulse-dot-green"></span> Vacant
                                            </span>
                                        @else
                                            @if(!empty($table['bill_requested']))
                                                <span class="table-badge-pill" style="background: rgba(234, 179, 8, 0.2); color: #b45309; border: 1px solid rgba(234, 179, 8, 0.5); font-weight: 900;">
                                                    <span>🧾</span> Bill Requested
                                                </span>
                                            @elseif(($table['order_status'] ?? '') === 'pending')
                                                <span class="table-badge-pill" style="background: rgba(245, 158, 11, 0.15); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.35); font-weight: 800;">
                                                    <span style="width: 7px; height: 7px; border-radius: 50%; background: #f59e0b; display: inline-block; margin-right: 4px;"></span> ⏸️ On Hold
                                                </span>
                                            @elseif(($table['order_status'] ?? '') === 'ready')
                                                <span class="table-badge-pill" style="background: rgba(16, 185, 129, 0.15); color: #059669; border: 1px solid rgba(16, 185, 129, 0.35); font-weight: 800;">
                                                    <span class="pulse-dot-green"></span> ✅ Food Ready
                                                </span>
                                            @else
                                                <span class="table-badge-pill badge-occupied">
                                                    <span class="pulse-dot-rose"></span> 🔥 In Kitchen
                                                </span>
                                            @endif
                                        @endif
                                    </div>

                                    <!-- Middle Info: Capacity or Live Dining Order Meta -->
                                    <div class="card-middle-info">
                                        @if($table['status'] === 'vacant')
                                            <div class="vacant-capacity-row">
                                                <span>👤 Capacity:</span>
                                                <strong style="color: var(--wp-text-primary);">{{ $table['capacity'] }} Guests</strong>
                                            </div>
                                            <div style="font-size: 10px; color: var(--wp-text-muted); margin-top: 3px;">
                                                Clean & ready for seating
                                            </div>
                                        @else
                                            <div class="occupied-order-row">
                                                <span>#{{ $table['order_number'] ?? 'Dining' }}</span>
                                                <span>&bull;</span>
                                                <span>{{ $table['items_count'] ?? 0 }} Items</span>
                                            </div>
                                            <div class="occupied-total-amount">
                                                Rs. {{ number_format($table['order_total'] ?? 0, 0) }}
                                            </div>
                                            @if(!empty($table['elapsed_mins']))
                                                <div class="occupied-timer-tag">
                                                    <span>⏱️</span>
                                                    <span>{{ $table['elapsed_mins'] }}m elapsed</span>
                                                </div>
                                            @endif
                                        @endif
                                    </div>

                                    <!-- Action Prompt Footer -->
                                    <div class="card-action-bar">
                                        @if($table['status'] === 'vacant')
                                            <span class="card-action-text-vacant">
                                                <span>+</span>
                                                <span>Tap to Take Order</span>
                                            </span>
                                            <span class="card-action-arrow" style="color: var(--wp-emerald);">➔</span>
                                        @else
                                            <span class="card-action-text-occupied">
                                                <span>View / Add Items</span>
                                            </span>
                                            <span class="card-action-arrow" style="color: var(--wp-rose-text);">➔</span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

            <!-- ========================================== -->
            <!-- 2. TAB: TABLE-SIDE TOUCH ORDERING          -->
            <!-- ========================================== -->
            @elseif($currentTab === 'order')
                @if($selectedTable)
                <div class="handheld-tablet-split">
                    
                    <!-- LEFT / MAIN: DISHES SEARCH & SELF-ADAPTIVE ROWS -->
                    <div>
                        <!-- Streamlined Search Bar -->
                        <div class="search-container-box">
                            <span style="color: var(--wp-text-muted); font-size: 15px;">🔍</span>
                            <input wire:model.live.debounce.250ms="search" type="text" placeholder="Search deals, platters, pizza, burger, drinks..." />
                            @if($search)
                                <button wire:click="$set('search', '')" style="background: none; border: none; font-size: 14px; color: var(--wp-text-muted); cursor: pointer; padding: 0 4px;">✕</button>
                            @endif
                        </div>

                        <!-- 1-Tap Quick Category Filter Chips -->
                        <div class="cat-chips-bar">
                            <button type="button" wire:click="resetFilters" 
                                    class="cat-filter-chip {{ is_null($selectedCategoryId) && is_null($dealFilter) ? 'active-all' : '' }}">
                                🍽️ All Dishes
                            </button>
                            <button type="button" wire:click="filterDeals" 
                                    class="cat-filter-chip {{ $dealFilter === 'deals' ? 'active-deals' : '' }}">
                                🎁 All Deals (35)
                            </button>
                            <button type="button" wire:click="filterPlatters" 
                                    class="cat-filter-chip {{ $dealFilter === 'platters' ? 'active-platters' : '' }}">
                                🍱 Platters
                            </button>
                            <button type="button" wire:click="openCategoryModal" 
                                    class="cat-filter-chip" style="border-color: var(--wp-gold); color: var(--wp-gold);">
                                📑 More Categories ▼
                            </button>
                        </div>

                        <!-- Clean Self-Adaptive Category Indicator Card -->
                        <div wire:click="openCategoryModal" class="category-selector-card">
                            <div class="cat-card-info">
                                <span class="cat-card-icon">
                                    @if($dealFilter === 'deals') 🎁
                                    @elseif($dealFilter === 'platters') 🍱
                                    @elseif($selectedCategoryId && str_contains(strtolower($this->activeCategoryName), 'burger')) 🍔
                                    @elseif($selectedCategoryId && str_contains(strtolower($this->activeCategoryName), 'pizza')) 🍕
                                    @elseif($selectedCategoryId && (str_contains(strtolower($this->activeCategoryName), 'karahi') || str_contains(strtolower($this->activeCategoryName), 'handi'))) 🥘
                                    @elseif($selectedCategoryId && (str_contains(strtolower($this->activeCategoryName), 'bbq') || str_contains(strtolower($this->activeCategoryName), 'tikka'))) 🍢
                                    @elseif($selectedCategoryId && (str_contains(strtolower($this->activeCategoryName), 'shake') || str_contains(strtolower($this->activeCategoryName), 'drink'))) 🥤
                                    @else 📑
                                    @endif
                                </span>
                                <div>
                                    <div class="cat-card-label">Category Filter</div>
                                    <div class="cat-card-title">{{ $this->activeCategoryName }} ({{ count($this->menuItems) }} Dishes)</div>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 6px;">
                                @if($selectedCategoryId || $dealFilter)
                                    <button wire:click.stop="resetFilters" style="background: var(--wp-surface-subtle); border: 1px solid var(--wp-border); color: var(--wp-text-secondary); font-size: 10px; font-weight: 800; padding: 4px 8px; border-radius: 8px; cursor: pointer;">
                                        Reset
                                    </button>
                                @endif
                                <span class="cat-card-badge">Change ▼</span>
                            </div>
                        </div>

                        <!-- Dishes Rows List -->
                        <div class="dishes-list-layout">
                            @forelse($this->menuItems as $item)
                                <div class="dish-row-card">
                                    <div class="dish-details-col">
                                        <div class="dish-name-heading">
                                            {{ $item->name }}
                                            @if(str_contains(strtolower($item->name), 'deal') || (isset($item->category) && str_contains(strtolower($item->category->name), 'deal')))
                                                <span style="display: inline-block; background: var(--wp-gold-bg); color: var(--wp-gold-text); border: 1px solid var(--wp-gold-border); font-size: 9px; font-weight: 800; padding: 2px 6px; border-radius: 6px; margin-left: 4px; vertical-align: middle;">🎁 COMBO</span>
                                            @elseif(str_contains(strtolower($item->name), 'platter') || (isset($item->category) && str_contains(strtolower($item->category->name), 'platter')))
                                                <span style="display: inline-block; background: var(--wp-emerald-bg); color: var(--wp-emerald-text); border: 1px solid var(--wp-emerald-border); font-size: 9px; font-weight: 800; padding: 2px 6px; border-radius: 6px; margin-left: 4px; vertical-align: middle;">🍱 PLATTER</span>
                                            @endif
                                        </div>

                                        @if(!empty($item->description))
                                            <div style="background: var(--wp-surface-subtle); border-left: 2.5px solid var(--wp-gold); padding: 4px 8px; margin: 4px 0 6px 0; border-radius: 0 6px 6px 0; font-size: 11px; line-height: 1.35; color: var(--wp-text-secondary);">
                                                <span style="color: var(--wp-gold-text); font-weight: 800;">📦 Includes:</span>
                                                <span style="font-weight: 600;">{{ $item->description }}</span>
                                            </div>
                                        @endif

                                        @php
                                            $hasSizes = isset($item->details['sizes']) && is_array($item->details['sizes']) && count($item->details['sizes']) > 0;
                                            $itemCartQty = 0;
                                            foreach($cart as $ck => $ci) {
                                                if ($ci['id'] == $item->id) {
                                                    $itemCartQty += $ci['quantity'];
                                                }
                                            }
                                        @endphp

                                        @if($hasSizes)
                                            <div class="dish-price-tag" style="font-size: 11px;">
                                                <span style="font-size: 9px; font-weight: 700; color: var(--wp-text-muted); text-transform: uppercase;">From</span>
                                                Rs. {{ number_format($item->price, 0) }}
                                            </div>
                                        @else
                                            <div class="dish-price-tag">Rs. {{ number_format($item->price, 0) }}</div>
                                        @endif
                                    </div>

                                    <div>
                                        @if($hasSizes)
                                            <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 4px;">
                                                <button 
                                                    type="button" 
                                                    wire:click="openPortionModal({{ $item->id }})" 
                                                    class="btn-add-handheld"
                                                    style="background: linear-gradient(135deg, #f59e0b, #d97706); border-color: #b45309; min-width: 74px; padding: 6px 8px;"
                                                    title="Select portion size"
                                                >
                                                    <span style="font-weight: 900; font-size: 12px; line-height: 1;">📐</span>
                                                    <span style="font-weight: 800; font-size: 11px; line-height: 1;">SIZES</span>
                                                </button>
                                                @if($itemCartQty > 0)
                                                    <span style="font-size: 9.5px; font-weight: 800; color: var(--wp-gold-text); background: var(--wp-gold-bg); border: 1px solid var(--wp-gold-border); border-radius: 6px; padding: 1px 6px;">
                                                        {{ $itemCartQty }} in order
                                                    </span>
                                                @endif
                                            </div>
                                        @else
                                            @if(isset($cart[$item->id]))
                                                <div class="handheld-stepper">
                                                    <button wire:click="updateQuantity('{{ $item->id }}', {{ $cart[$item->id]['quantity'] - 1 }})" class="stepper-btn-minus">−</button>
                                                    <span class="stepper-qty-display">{{ $cart[$item->id]['quantity'] }}</span>
                                                    <button wire:click="updateQuantity('{{ $item->id }}', {{ $cart[$item->id]['quantity'] + 1 }})" class="stepper-btn-plus">+</button>
                                                </div>
                                            @else
                                                <button 
                                                    type="button" 
                                                    wire:click="addToCart({{ $item->id }})" 
                                                    class="btn-add-handheld"
                                                >
                                                    <span style="font-weight: 900; font-size: 14px; line-height: 1;">+</span>
                                                    <span style="font-weight: 800; font-size: 13px; line-height: 1;">ADD</span>
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div style="background: var(--wp-surface-card); border: 1.5px dashed var(--wp-border); border-radius: 14px; padding: 26px; text-align: center; color: var(--wp-text-muted);">
                                    <div style="font-size: 26px;">🍽️</div>
                                    <div style="font-size: 13px; font-weight: 700; color: var(--wp-text-primary); margin-top: 4px;">No dishes found.</div>
                                    <button wire:click="resetFilters" style="margin-top: 8px; background: var(--wp-gold); color: #000; border: none; border-radius: 8px; padding: 6px 14px; font-size: 11px; font-weight: 800; cursor: pointer;">
                                        View All Dishes
                                    </button>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- TABLET RIGHT ORDER COLUMN (Visible on Tablets & Landscape) -->
                    <div class="tablet-order-column" style="background: var(--wp-surface-card); border: 1px solid var(--wp-border); border-radius: 16px; padding: 14px; display: flex; flex-direction: column; justify-content: space-between; box-shadow: var(--wp-card-shadow); max-height: calc(100vh - 120px); overflow-y: auto;">
                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1.5px dashed var(--wp-border); padding-bottom: 8px; margin-bottom: 10px;">
                                <div>
                                    <h3 style="font-size: 15px; font-weight: 800; margin: 0; color: var(--wp-text-primary);">
                                        {{ str_starts_with($selectedTable, 'Table') ? $selectedTable : ('Table ' . $selectedTable) }} Ticket
                                    </h3>
                                    <span style="font-size: 11px; color: var(--wp-text-muted);">{{ count($cart) }} Dish(es) added</span>
                                </div>
                                @if(count($cart) > 0)
                                    <span style="background: #059669; color: #FFF; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 8px;">
                                        {{ $this->cartCount }} Items
                                    </span>
                                @endif
                            </div>

                            <!-- Optional Guest Record Strip (For waiter record keeping) -->
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px; margin-bottom: 8px; background: var(--wp-surface-subtle); padding: 6px 8px; border-radius: 10px; border: 1px solid var(--wp-border);">
                                <input 
                                    type="text" 
                                    wire:model.live.debounce.300ms="customerName" 
                                    placeholder="👤 Guest Name (Opt)" 
                                    style="width: 100%; border: 1px solid var(--wp-border); background: var(--wp-surface); color: var(--wp-text-primary); border-radius: 6px; padding: 4px 6px; font-size: 10.5px; outline: none; box-sizing: border-box;"
                                />
                                <input 
                                    type="text" 
                                    wire:model.live.debounce.300ms="customerPhone" 
                                    placeholder="📱 Phone # (Opt)" 
                                    style="width: 100%; border: 1px solid var(--wp-border); background: var(--wp-surface); color: var(--wp-text-primary); border-radius: 6px; padding: 4px 6px; font-size: 10.5px; outline: none; box-sizing: border-box;"
                                />
                            </div>

                            <!-- Cart Items -->
                            @if(count($cart) > 0)
                                <div style="max-height: 220px; overflow-y: auto; margin-bottom: 10px;">
                                    @foreach($cart as $itemId => $cartItem)
                                        <div style="padding: 6px 0; border-bottom: 1px solid var(--wp-border-subtle);">
                                            <div style="display: flex; justify-content: space-between; font-size: 12px; font-weight: 700; color: var(--wp-text-primary);">
                                                <span>
                                                    {{ $cartItem['name'] }}
                                                    @if(!empty($cartItem['size_label']))
                                                        <span style="display: inline-block; font-size: 9.5px; font-weight: 800; background: var(--wp-gold-bg); color: var(--wp-gold-text); border: 1px solid var(--wp-gold-border); border-radius: 4px; padding: 1px 5px; margin-left: 4px; vertical-align: middle;">
                                                            {{ $cartItem['size_label'] }}
                                                        </span>
                                                    @endif
                                                </span>
                                                <span style="font-weight: 800;">Rs. {{ number_format($cartItem['price'] * $cartItem['quantity'], 0) }}</span>
                                            </div>
                                            @if(!empty($cartItem['description']))
                                                <div style="font-size: 10px; color: var(--wp-gold-text); background: var(--wp-gold-bg); border: 1px solid var(--wp-gold-border); border-radius: 6px; padding: 2px 6px; margin: 3px 0; font-weight: 600; line-height: 1.25;">
                                                    📦 {{ $cartItem['description'] }}
                                                </div>
                                            @endif
                                            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 4px;">
                                                <span style="font-size: 10px; color: var(--wp-text-muted);">Rs. {{ number_format($cartItem['price'], 0) }}</span>
                                                <div style="display: flex; align-items: center; gap: 4px;">
                                                    <button wire:click="updateQuantity('{{ $itemId }}', {{ $cartItem['quantity'] - 1 }})" style="background: var(--wp-surface-subtle); border: 1px solid var(--wp-border); color: var(--wp-text-primary); border-radius: 6px; width: 24px; height: 24px; font-weight: 800; cursor: pointer;">−</button>
                                                    <span style="font-size: 12px; font-weight: 800; min-width: 18px; text-align: center; color: var(--wp-text-primary);">{{ $cartItem['quantity'] }}</span>
                                                    <button wire:click="updateQuantity('{{ $itemId }}', {{ $cartItem['quantity'] + 1 }})" style="background: var(--wp-surface-subtle); border: 1px solid var(--wp-border); color: var(--wp-text-primary); border-radius: 6px; width: 24px; height: 24px; font-weight: 800; cursor: pointer;">+</button>
                                                    <button wire:click="removeFromCart('{{ $itemId }}')" style="background: var(--wp-rose-bg); color: var(--wp-rose); border: 1px solid var(--wp-rose-border); border-radius: 6px; width: 24px; height: 24px; font-weight: 800; margin-left: 4px; cursor: pointer;">✕</button>
                                                </div>
                                            </div>
                                            <input 
                                                type="text" 
                                                wire:change="updateItemComment('{{ $itemId }}', $event.target.value)" 
                                                value="{{ $cartItem['comment'] ?? '' }}" 
                                                placeholder="Dish kitchen instruction..." 
                                                style="width: 100%; border: 1px solid var(--wp-border); background: var(--wp-surface); color: var(--wp-text-primary); border-radius: 6px; padding: 4px 8px; font-size: 10.5px; outline: none; margin-top: 4px; box-sizing: border-box;"
                                            />
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div style="padding: 24px 10px; text-align: center; color: var(--wp-text-muted); border: 1.5px dashed var(--wp-border); border-radius: 12px; margin-bottom: 10px;">
                                    <div style="font-size: 22px;">🛒</div>
                                    <div style="font-size: 12px; font-weight: 700; color: var(--wp-text-primary);">Cart is Empty</div>
                                    <div style="font-size: 10.5px;">Tap dishes to add items to table ticket.</div>
                                </div>
                            @endif

                            <!-- Quick Kitchen Instruction Chips -->
                            <div style="background: var(--wp-surface-subtle); border: 1px solid var(--wp-border); border-radius: 12px; padding: 10px; margin-bottom: 10px;">
                                <div style="font-size: 10px; font-weight: 800; color: var(--wp-text-muted); text-transform: uppercase; margin-bottom: 4px;">
                                    ⚡ 1-Tap Kitchen Notes
                                </div>
                                <div class="chips-inline-flex">
                                    @php
                                        $quickChips = ['🌶️ Mild', '🔥 Spicy', '🧂 Less Salt', '🧅 No Onions', '⏱️ Jaldi', '🥤 Drinks 1st'];
                                    @endphp
                                    @foreach($quickChips as $chip)
                                        <button 
                                            type="button" 
                                            wire:click="toggleQuickNote('{{ $chip }}')" 
                                            class="quick-instruction-chip {{ str_contains($specialNotes, $chip) ? 'selected' : '' }}"
                                        >
                                            {{ $chip }}
                                        </button>
                                    @endforeach
                                </div>
                                <textarea 
                                    wire:model.live.debounce.300ms="specialNotes" 
                                    rows="1" 
                                    placeholder="Extra kitchen note..." 
                                    style="width: 100%; border: 1px solid var(--wp-border); background: var(--wp-surface); color: var(--wp-text-primary); border-radius: 8px; padding: 5px 8px; font-size: 11px; outline: none; box-sizing: border-box; resize: none; margin-top: 4px;"
                                ></textarea>
                            </div>
                        </div>

                        <div>
                            <!-- Order Totals -->
                            @php
                                $subtotal = $this->cartTotal;
                                $isVatEnabled = \App\Models\PosSetting::isVatEnabled();
                                $vatRate = \App\Models\PosSetting::getVatPercentage();
                                $tax = $isVatEnabled ? ($subtotal * ($vatRate / 100)) : 0;
                                $grandTotal = $subtotal + $tax;
                            @endphp
                            <div style="background: var(--wp-surface-subtle); border: 1px solid var(--wp-border); border-radius: 12px; padding: 10px; margin-bottom: 10px; font-size: 11px;">
                                <div style="display: flex; justify-content: space-between; color: var(--wp-text-secondary); margin-bottom: 3px;">
                                    <span>Subtotal ({{ $this->cartCount }} items)</span>
                                    <span>Rs. {{ number_format($subtotal, 0) }}</span>
                                </div>
                                @if($isVatEnabled)
                                    <div style="display: flex; justify-content: space-between; color: var(--wp-text-secondary); margin-bottom: 3px;">
                                        <span>GST Tax ({{ $vatRate }}%)</span>
                                        <span>Rs. {{ number_format($tax, 0) }}</span>
                                    </div>
                                @else
                                    <div style="display: flex; justify-content: space-between; color: var(--wp-text-muted); margin-bottom: 3px;">
                                        <span>Tax / VAT</span>
                                        <span>Exempt (0%)</span>
                                    </div>
                                @endif
                                <div style="display: flex; justify-content: space-between; font-size: 14.5px; font-weight: 800; color: var(--wp-text-primary); border-top: 1px solid var(--wp-border); padding-top: 5px; margin-top: 3px;">
                                    <span>Total Payable</span>
                                    <span style="color: #059669;">Rs. {{ number_format($grandTotal, 0) }}</span>
                                </div>
                            </div>

                            <div style="display: flex; gap: 8px;">
                                <button 
                                    wire:click="holdOrder" 
                                    @if(count($cart) === 0) disabled @endif 
                                    type="button"
                                    style="flex: 1; padding: 11px 8px; border-radius: 12px; border: 1.5px solid var(--wp-gold); background: var(--wp-gold-bg); color: var(--wp-gold-text); font-size: 11px; font-weight: 800; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 4px;"
                                    title="Save table order on hold as draft without sending KOT yet"
                                >
                                    <span>⏸️</span>
                                    <span>HOLD / DRAFT</span>
                                </button>
                                <button 
                                    wire:click="sendToKitchen" 
                                    @if(count($cart) === 0) disabled @endif 
                                    type="button"
                                    class="btn-send-kot"
                                    style="flex: 1.6;"
                                    title="Dispatch KOT to kitchen cook queue"
                                >
                                    <span>🍳</span>
                                    <span>DISPATCH KOT</span>
                                </button>
                            </div>

                            @if($activeOrderId)
                                @php
                                    $activeOrderObj = \App\Models\Order::find($activeOrderId);
                                @endphp
                                @if($activeOrderObj && $activeOrderObj->bill_requested)
                                    <div style="margin-top: 8px; padding: 10px; border-radius: 12px; background: rgba(245, 158, 11, 0.15); border: 1.5px solid #d97706; color: #b45309; font-size: 11px; font-weight: 800; text-align: center; display: flex; align-items: center; justify-content: center; gap: 6px;">
                                        <span>🧾</span>
                                        <span>Bill Requested (Awaiting Cashier Settle)</span>
                                    </div>
                                @else
                                    <button 
                                        wire:click="requestBillSettlement" 
                                        type="button" 
                                        style="width: 100%; margin-top: 8px; padding: 11px 12px; border-radius: 12px; border: 1.5px solid #059669; background: #ecfdf5; color: #065f46; font-size: 11.5px; font-weight: 800; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px;"
                                        class="dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-emerald-800 hover:bg-emerald-100"
                                        title="Guests requested bill - alert Cashier to prepare and settle invoice"
                                    >
                                        <span>🧾</span>
                                        <span>REQUEST BILL / SETTLE</span>
                                    </button>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <!-- FLOATING BOTTOM CART BAR (On mobile screens when cart has items) -->
                @if(count($cart) > 0)
                    <div wire:click="openCartDrawer" class="mobile-bottom-pill-bar">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span class="pill-badge-qty">{{ $this->cartCount }} Dishes</span>
                            <span class="pill-total-amount">Rs. {{ number_format($this->cartTotal, 0) }}</span>
                        </div>
                        <button class="pill-btn-action">
                            <span>View Order</span>
                            <span>➔</span>
                        </button>
                    </div>
                @endif
                @endif

            <!-- ========================================== -->
            <!-- 3. TAB: KITCHEN ALERTS                     -->
            <!-- ========================================== -->
            @elseif($currentTab === 'alerts')
                <div style="max-width: 620px; margin: 0 auto;">
                    
                    <!-- Section 1: Ready to Serve Counter Pickups -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                        <h2 style="font-size: 14.5px; font-weight: 800; color: var(--wp-text-primary); margin: 0;">
                            🔔 Counter Pickups (Ready to Serve)
                        </h2>
                        <span style="font-size: 10.5px; font-weight: 800; color: var(--wp-emerald-text); background: var(--wp-emerald-bg); border: 1px solid var(--wp-emerald-border); padding: 3px 8px; border-radius: 8px;">
                            {{ count($this->servingNotifications) + count($this->kitchenOrders->where('status', 'ready')) }} Ready
                        </span>
                    </div>

                    @php
                        $readyOrders = $this->kitchenOrders->where('status', 'ready');
                    @endphp

                    @if(count($this->servingNotifications) > 0 || count($readyOrders) > 0)
                        @foreach($this->servingNotifications as $notif)
                            <div style="background: var(--wp-surface-card); border: 1.5px solid var(--wp-emerald); border-radius: 14px; padding: 12px; margin-bottom: 8px; box-shadow: var(--wp-card-shadow); display: flex; align-items: center; justify-content: space-between; gap: 10px;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <span style="font-size: 24px;">🍳</span>
                                    <div>
                                        <h4 style="font-size: 13.5px; font-weight: 800; color: var(--wp-emerald-dark); margin: 0;">
                                            {{ $notif->title }}
                                        </h4>
                                        <p style="font-size: 11px; color: var(--wp-text-secondary); margin: 2px 0 0 0;">
                                            {{ $notif->message }} &bull; Pick up at Kitchen Counter
                                        </p>
                                    </div>
                                </div>
                                <button wire:click="dismissServingNotification({{ $notif->id }})" style="background: #059669; color: #FFFFFF; border: none; border-radius: 10px; padding: 8px 12px; font-size: 11px; font-weight: 800; cursor: pointer; white-space: nowrap;">
                                    ✅ Delivered
                                </button>
                            </div>
                        @endforeach

                        @foreach($readyOrders as $rOrder)
                            <div style="background: var(--wp-surface-card); border: 1.5px solid var(--wp-emerald); border-radius: 14px; padding: 12px; margin-bottom: 8px; box-shadow: var(--wp-card-shadow); display: flex; align-items: center; justify-content: space-between; gap: 10px;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <span style="font-size: 24px;">🔔</span>
                                    <div>
                                        <h4 style="font-size: 13.5px; font-weight: 800; color: var(--wp-emerald-dark); margin: 0;">
                                            {{ str_starts_with($rOrder->table_number, 'Table') ? $rOrder->table_number : ('Table ' . $rOrder->table_number) }} is READY!
                                        </h4>
                                        <p style="font-size: 11px; color: var(--wp-text-secondary); margin: 2px 0 0 0;">
                                            Order #{{ $rOrder->order_number }} &bull; Pick up from counter now
                                        </p>
                                    </div>
                                </div>
                                <button wire:click="selectTableForFeast('{{ $rOrder->table_number }}')" style="background: #059669; color: #FFFFFF; border: none; border-radius: 10px; padding: 8px 12px; font-size: 11px; font-weight: 800; cursor: pointer; white-space: nowrap;">
                                    View Table ➔
                                </button>
                            </div>
                        @endforeach
                    @else
                        <div style="background: var(--wp-surface-card); border: 1.5px dashed var(--wp-border); border-radius: 14px; padding: 22px; text-align: center; color: var(--wp-text-muted); margin-bottom: 14px;">
                            <div style="font-size: 26px;">🍽️</div>
                            <div style="font-size: 12.5px; font-weight: 800; color: var(--wp-text-primary); margin-top: 4px;">No Orders Waiting at Counter</div>
                            <div style="font-size: 10.5px; margin-top: 2px;">When the kitchen marks dishes ready, alerts will appear here instantly.</div>
                        </div>
                    @endif

                    <!-- Section 2: Live Kitchen Cooking Queue -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; margin-top: 18px;">
                        <h2 style="font-size: 14.5px; font-weight: 800; color: var(--wp-text-primary); margin: 0;">
                            🔥 In Kitchen Process (Cooking)
                        </h2>
                        @php
                            $cookingOrders = $this->kitchenOrders->whereIn('status', ['pending', 'preparing']);
                        @endphp
                        <span style="font-size: 10.5px; font-weight: 800; color: var(--wp-gold-text); background: var(--wp-gold-bg); border: 1px solid var(--wp-gold-border); padding: 3px 8px; border-radius: 8px;">
                            {{ count($cookingOrders) }} Cooking
                        </span>
                    </div>

                    @forelse($cookingOrders as $cOrder)
                        <div style="background: var(--wp-surface-card); border: 1px solid var(--wp-gold-border); border-radius: 14px; padding: 12px; margin-bottom: 8px; box-shadow: var(--wp-card-shadow);">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
                                <div>
                                    <div style="font-size: 13.5px; font-weight: 800; color: var(--wp-text-primary);">
                                        🪑 {{ str_starts_with($cOrder->table_number, 'Table') ? $cOrder->table_number : ('Table ' . $cOrder->table_number) }}
                                        <span style="font-size: 10.5px; font-weight: 600; color: var(--wp-text-muted);">(#{{ $cOrder->order_number }})</span>
                                    </div>
                                    <div style="font-size: 10.5px; color: var(--wp-gold-text); font-weight: 700; margin-top: 1px;">
                                        ⏱️ Dispatched {{ $cOrder->created_at->diffForHumans() }}
                                    </div>
                                </div>
                                <span style="background: var(--wp-gold-bg); color: var(--wp-gold-text); border: 1px solid var(--wp-gold-border); font-size: 9.5px; font-weight: 800; padding: 2px 7px; border-radius: 6px;">
                                    🔥 In Kitchen
                                </span>
                            </div>

                            <div style="margin: 6px 0; font-size: 11px; color: var(--wp-text-secondary); background: var(--wp-surface-subtle); border-radius: 8px; padding: 6px 10px;">
                                @foreach($cOrder->items as $ci)
                                    <div>&bull; <strong style="color: var(--wp-text-primary);">{{ $ci->quantity }}x</strong> {{ $ci->menuItem->name ?? 'Dish' }}</div>
                                @endforeach
                            </div>

                            <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--wp-border-subtle); padding-top: 6px;">
                                <div style="font-size: 12.5px; font-weight: 800; color: var(--wp-text-primary);">
                                    Total: <span style="color: #059669;">Rs. {{ number_format($cOrder->total, 0) }}</span>
                                </div>
                                <button wire:click="selectTableForFeast('{{ $cOrder->table_number }}')" style="background: var(--wp-surface-subtle); border: 1px solid var(--wp-border); color: var(--wp-text-primary); border-radius: 8px; padding: 5px 10px; font-size: 10.5px; font-weight: 800; cursor: pointer;">
                                    View Table ➔
                                </button>
                            </div>
                        </div>
                    @empty
                        <div style="background: var(--wp-surface-card); border: 1.5px dashed var(--wp-border); border-radius: 14px; padding: 22px; text-align: center; color: var(--wp-text-muted);">
                            <div style="font-size: 26px;">👨‍🍳</div>
                            <div style="font-size: 12.5px; font-weight: 700; color: var(--wp-text-primary); margin-top: 4px;">Kitchen queue is currently clear.</div>
                        </div>
                    @endforelse

                </div>

            <!-- ========================================== -->
            <!-- 4. TAB: SHIFT PERFORMANCE STATS            -->
            <!-- ========================================== -->
            @elseif($currentTab === 'shift')
                @php
                    $stats = $this->shiftStats;
                @endphp
                <div style="max-width: 620px; margin: 0 auto;">
                    <!-- Server Profile Header -->
                    <div style="background: var(--wp-surface-card); border: 1px solid var(--wp-border); border-radius: 16px; padding: 14px; margin-bottom: 12px; display: flex; align-items: center; gap: 12px; box-shadow: var(--wp-card-shadow);">
                        <img src="{{ asset('images/logo_circular.png') }}" alt="Server Profile" style="width: 48px; height: 48px; border-radius: 50%; border: 2px solid var(--wp-gold);">
                        <div>
                            <h3 style="font-size: 15.5px; font-weight: 800; color: var(--wp-text-primary); margin: 0;">
                                {{ $stats['server_name'] }}
                            </h3>
                            <p style="font-size: 11px; color: var(--wp-text-muted); margin: 2px 0 0 0;">
                                Floor Service Captain &bull; NFC Restaurant
                            </p>
                            <div style="display: flex; align-items: center; gap: 5px; font-size: 10px; font-weight: 700; color: var(--wp-emerald-dark); margin-top: 4px;">
                                <span class="status-dot-green"></span> Active On Duty
                            </div>
                        </div>
                    </div>

                    <!-- Metrics Grid -->
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; margin-bottom: 14px;">
                        <div style="background: var(--wp-surface-card); border: 1px solid var(--wp-border); border-radius: 14px; padding: 12px; text-align: center; box-shadow: var(--wp-card-shadow);">
                            <div style="font-size: 20px; font-weight: 800; color: var(--wp-text-primary);">{{ $stats['total_orders'] }}</div>
                            <div style="font-size: 10px; color: var(--wp-text-muted); font-weight: 700; margin-top: 2px;">Orders Taken</div>
                        </div>
                        <div style="background: var(--wp-surface-card); border: 1px solid var(--wp-border); border-radius: 14px; padding: 12px; text-align: center; box-shadow: var(--wp-card-shadow);">
                            <div style="font-size: 20px; font-weight: 800; color: #059669;">{{ $stats['active_orders'] }}</div>
                            <div style="font-size: 10px; color: var(--wp-text-muted); font-weight: 700; margin-top: 2px;">Active Tables</div>
                        </div>
                        <div style="background: var(--wp-surface-card); border: 1px solid var(--wp-border); border-radius: 14px; padding: 12px; text-align: center; box-shadow: var(--wp-card-shadow);">
                            <div style="font-size: 16px; font-weight: 800; color: var(--wp-gold);">Rs. {{ number_format($stats['total_sales'], 0) }}</div>
                            <div style="font-size: 10px; color: var(--wp-text-muted); font-weight: 700; margin-top: 2px;">Completed</div>
                        </div>
                    </div>

                    <!-- Live Kitchen Orders (In Process) Block -->
                    <div style="background: var(--wp-surface-card); border: 1px solid var(--wp-border); border-radius: 16px; padding: 14px; margin-bottom: 12px; box-shadow: var(--wp-card-shadow);">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <span style="font-size: 16px;">🍳</span>
                                <h4 style="font-size: 13.5px; font-weight: 800; color: var(--wp-text-primary); margin: 0;">
                                    Kitchen Orders In Process
                                </h4>
                            </div>
                            <span style="font-size: 10px; font-weight: 800; padding: 3px 8px; border-radius: 8px; background: {{ count($this->kitchenOrders) > 0 ? 'var(--wp-gold-bg)' : 'var(--wp-surface-subtle)' }}; color: {{ count($this->kitchenOrders) > 0 ? 'var(--wp-gold-text)' : 'var(--wp-text-muted)' }};">
                                {{ count($this->kitchenOrders) }} Active
                            </span>
                        </div>

                        @forelse($this->kitchenOrders as $kOrder)
                            <div style="border: 1px solid {{ $kOrder->status === 'ready' ? 'var(--wp-emerald)' : 'var(--wp-gold-border)' }}; background: var(--wp-surface-subtle); border-radius: 12px; padding: 10px 12px; margin-bottom: 8px;">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
                                    <div>
                                        <div style="display: flex; align-items: center; gap: 6px;">
                                            <span style="font-size: 13.5px; font-weight: 800; color: var(--wp-text-primary);">
                                                🪑 {{ str_starts_with($kOrder->table_number, 'Table') ? $kOrder->table_number : ('Table ' . $kOrder->table_number) }}
                                            </span>
                                            <span style="font-size: 10px; font-weight: 700; color: var(--wp-text-muted);">
                                                #{{ $kOrder->order_number }}
                                            </span>
                                        </div>
                                        <div style="font-size: 10px; color: var(--wp-text-muted); margin-top: 2px;">
                                            ⏱️ Placed {{ $kOrder->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                    <div>
                                        @if($kOrder->status === 'ready')
                                            <span style="display: inline-block; background: var(--wp-emerald-bg); color: var(--wp-emerald-text); border: 1px solid var(--wp-emerald-border); font-size: 9.5px; font-weight: 800; padding: 2px 7px; border-radius: 6px;">
                                                🔔 Ready
                                            </span>
                                        @elseif($kOrder->status === 'preparing')
                                            <span style="display: inline-block; background: var(--wp-gold-bg); color: var(--wp-gold-text); border: 1px solid var(--wp-gold-border); font-size: 9.5px; font-weight: 800; padding: 2px 7px; border-radius: 6px;">
                                                🔥 Cooking
                                            </span>
                                        @else
                                            <span style="display: inline-block; background: var(--wp-gold-bg); color: var(--wp-gold-text); border: 1px solid var(--wp-gold-border); font-size: 9.5px; font-weight: 800; padding: 2px 7px; border-radius: 6px;">
                                                ⏳ In Process
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Items summary -->
                                <div style="background: var(--wp-surface-card); border: 1px solid var(--wp-border-subtle); border-radius: 8px; padding: 6px 8px; margin-bottom: 8px; font-size: 11px;">
                                    @foreach($kOrder->items as $item)
                                        <div style="display: flex; justify-content: space-between; color: var(--wp-text-secondary); line-height: 1.4;">
                                            <span><strong style="color: var(--wp-text-primary);">{{ $item->quantity }}x</strong> {{ $item->menuItem->name ?? 'Dish' }}</span>
                                            <span style="font-weight: 700; color: var(--wp-text-muted);">Rs. {{ number_format($item->total_price, 0) }}</span>
                                        </div>
                                    @endforeach
                                    @if($kOrder->special_notes)
                                        <div style="margin-top: 4px; font-size: 10px; color: var(--wp-gold-text); font-weight: 700;">
                                            📝 {{ $kOrder->special_notes }}
                                        </div>
                                    @endif
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div style="font-size: 12.5px; font-weight: 800; color: var(--wp-text-primary);">
                                        Total: <span style="color: #059669;">Rs. {{ number_format($kOrder->total, 0) }}</span>
                                    </div>
                                    <button wire:click="selectTableForFeast('{{ $kOrder->table_number }}')" 
                                            style="background: var(--wp-surface-subtle); border: 1px solid var(--wp-border); color: var(--wp-text-primary); border-radius: 8px; padding: 5px 10px; font-size: 10.5px; font-weight: 800; cursor: pointer;">
                                        View / Add Items ➔
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div style="padding: 16px; text-align: center; color: var(--wp-text-muted); background: var(--wp-surface-subtle); border: 1.5px dashed var(--wp-border); border-radius: 12px;">
                                <div style="font-size: 22px;">🍳</div>
                                <div style="font-size: 12px; font-weight: 700; color: var(--wp-text-primary); margin-top: 2px;">No active orders in kitchen.</div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Completed Orders (Today) -->
                    @if(count($this->completedOrders) > 0)
                        <div style="background: var(--wp-surface-card); border: 1px solid var(--wp-border); border-radius: 16px; padding: 14px; margin-bottom: 12px; box-shadow: var(--wp-card-shadow);">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                <h4 style="font-size: 12.5px; font-weight: 800; color: var(--wp-text-primary); margin: 0;">
                                    ✅ Completed Orders (Today)
                                </h4>
                                <span style="font-size: 10.5px; color: #059669; font-weight: 700;">{{ count($this->completedOrders) }} Paid</span>
                            </div>
                            @foreach($this->completedOrders as $cOrder)
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 6px 0; border-bottom: 1px solid var(--wp-border-subtle); font-size: 11px;">
                                    <div>
                                        <span style="font-weight: 800; color: var(--wp-text-primary);">{{ str_starts_with($cOrder->table_number, 'Table') ? $cOrder->table_number : ('Table ' . $cOrder->table_number) }}</span>
                                        <span style="color: var(--wp-text-muted); font-size: 10px;">&bull; #{{ $cOrder->order_number }}</span>
                                    </div>
                                    <div style="font-weight: 800; color: #059669;">
                                        Rs. {{ number_format($cOrder->total, 0) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Quick Actions -->
                    <div style="background: var(--wp-surface-card); border: 1px solid var(--wp-border); border-radius: 16px; padding: 14px; box-shadow: var(--wp-card-shadow);">
                        <h4 style="font-size: 12.5px; font-weight: 800; color: var(--wp-text-primary); margin: 0 0 8px 0;">Shift Actions</h4>
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <button wire:click="$refresh" style="background: var(--wp-surface-subtle); border: 1px solid var(--wp-border); border-radius: 10px; padding: 10px; font-size: 12px; font-weight: 700; color: var(--wp-text-primary); text-align: left; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                                <span>🔄</span> Refresh Floor Tables & Orders
                            </button>
                            <a href="{{ route('filament.waiter.auth.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="background: var(--wp-rose-bg); border: 1px solid var(--wp-rose-border); border-radius: 10px; padding: 10px; font-size: 12px; font-weight: 700; color: var(--wp-rose); text-decoration: none; display: flex; align-items: center; gap: 8px;">
                                <span>🚪</span> End Shift & Logout
                            </a>
                        </div>
                    </div>
                </div>
            @endif

        </main>

        <!-- ========================================== -->
        <!-- 5. CATEGORY POPUP MODAL (BOTTOM SHEET)     -->
        <!-- ========================================== -->
        @if($categoryModalOpen)
            <div class="sheet-modal-backdrop" wire:click.self="closeCategoryModal">
                <div class="sheet-modal-box">
                    <div class="sheet-drag-handle"></div>
                    <div class="sheet-modal-header">
                        <h3 class="sheet-modal-title">📑 Select Menu Category</h3>
                        <button wire:click="closeCategoryModal" class="sheet-btn-close">✕</button>
                    </div>

                    <div class="cat-modal-grid">
                        <!-- Featured Full-Width All Menu Items Card at Top -->
                        <div wire:click="resetFilters" 
                             class="cat-modal-tile {{ is_null($selectedCategoryId) && is_null($dealFilter) ? 'active' : '' }}"
                             style="grid-column: span 2; display: flex; align-items: center; justify-content: space-between; padding: 12px 14px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="font-size: 22px;">🍽️</span>
                                <div>
                                    <div class="cat-tile-name" style="margin: 0;">All Menu Items</div>
                                    <div style="font-size: 10.5px; color: var(--wp-text-muted); font-weight: 600; margin-top: 1px;">Show all dishes from all categories</div>
                                </div>
                            </div>
                            @if(is_null($selectedCategoryId) && is_null($dealFilter))
                                <span style="background: var(--wp-gold); color: #000; font-size: 10px; font-weight: 800; padding: 3px 8px; border-radius: 6px;">✓ Active</span>
                            @else
                                <span style="font-size: 11px; font-weight: 700; color: var(--wp-text-muted);">Select ➔</span>
                            @endif
                        </div>

                        <!-- Quick Deals & Platters Section -->
                        <div wire:click="filterDeals" 
                             class="cat-modal-tile {{ $dealFilter === 'deals' ? 'active' : '' }}"
                             style="display: flex; align-items: center; gap: 8px;">
                            <span style="font-size: 22px;">🎁</span>
                            <div style="min-width: 0;">
                                <div class="cat-tile-name" style="color: var(--wp-gold); margin: 0;">All Deals (35)</div>
                                <div style="font-size: 10px; color: var(--wp-text-muted); font-weight: 600;">Combos & Deals</div>
                            </div>
                        </div>

                        <div wire:click="filterPlatters" 
                             class="cat-modal-tile {{ $dealFilter === 'platters' ? 'active' : '' }}"
                             style="display: flex; align-items: center; gap: 8px;">
                            <span style="font-size: 22px;">🍱</span>
                            <div style="min-width: 0;">
                                <div class="cat-tile-name" style="color: #059669; margin: 0;">Special Platters</div>
                                <div style="font-size: 10px; color: var(--wp-text-muted); font-weight: 600;">Feast & Finger Combos</div>
                            </div>
                        </div>

                        <!-- Individual Categories -->
                        @foreach($this->categories as $cat)
                            <div wire:click="selectCategory({{ $cat->id }})" 
                                 class="cat-modal-tile {{ $selectedCategoryId == $cat->id ? 'active' : '' }}"
                                 style="display: flex; align-items: center; gap: 8px;">
                                <div style="font-size: 20px; flex-shrink: 0;">
                                    @php $cName = strtolower($cat->name); @endphp
                                    @if(str_contains($cName, 'deal')) 🎁
                                    @elseif(str_contains($cName, 'platter')) 🍱
                                    @elseif(str_contains($cName, 'burger')) 🍔
                                    @elseif(str_contains($cName, 'pizza')) 🍕
                                    @elseif(str_contains($cName, 'karahi') || str_contains($cName, 'handi')) 🥘
                                    @elseif(str_contains($cName, 'bbq') || str_contains($cName, 'tikka')) 🍢
                                    @elseif(str_contains($cName, 'shake') || str_contains($cName, 'drink') || str_contains($cName, 'beverage')) 🥤
                                    @elseif(str_contains($cName, 'rice') || str_contains($cName, 'biryani')) 🍚
                                    @elseif(str_contains($cName, 'fries')) 🍟
                                    @elseif(str_contains($cName, 'roll') || str_contains($cName, 'shawarma')) 🌯
                                    @elseif(str_contains($cName, 'pasta')) 🍝
                                    @elseif(str_contains($cName, 'sandwich')) 🥪
                                    @elseif(str_contains($cName, 'appetizer')) 🥟
                                    @elseif(str_contains($cName, 'dessert') || str_contains($cName, 'sweet')) 🍨
                                    @else 🍽️
                                    @endif
                                </div>
                                <div style="flex: 1; min-width: 0;">
                                    <div class="cat-tile-name" style="line-height: 1.2; word-break: break-word;">{{ $cat->name }}</div>
                                    @if($selectedCategoryId == $cat->id)
                                        <div class="cat-tile-tag">✓ Active</div>
                                    @elseif(isset($cat->menu_items_count))
                                        <div style="font-size: 9.5px; color: var(--wp-text-muted); font-weight: 600;">{{ $cat->menu_items_count }} items</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- ========================================== -->
        <!-- 6. MOBILE CART BOTTOM SHEET (DRAWER)       -->
        <!-- ========================================== -->
        @if($cartDrawerOpen && $selectedTable)
            <div class="sheet-modal-backdrop" wire:click.self="closeCartDrawer">
                <div class="sheet-modal-box">
                    <div class="sheet-drag-handle"></div>
                    <div class="sheet-modal-header">
                        <div>
                            <h3 class="sheet-modal-title">
                                📋 {{ str_starts_with($selectedTable, 'Table') ? $selectedTable : ('Table ' . $selectedTable) }} Order
                            </h3>
                            <span style="font-size: 11px; color: var(--wp-text-muted);">{{ $this->cartCount }} item(s) in order</span>
                        </div>
                        <button wire:click="closeCartDrawer" class="sheet-btn-close">✕</button>
                    </div>

                    <!-- Optional Guest Record Strip (For waiter record keeping) -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px; margin: 8px 0; background: var(--wp-surface-subtle); padding: 6px 8px; border-radius: 10px; border: 1px solid var(--wp-border);">
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="customerName" 
                            placeholder="👤 Guest Name (Opt)" 
                            style="width: 100%; border: 1px solid var(--wp-border); background: var(--wp-surface); color: var(--wp-text-primary); border-radius: 6px; padding: 4px 6px; font-size: 10.5px; outline: none; box-sizing: border-box;"
                        />
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="customerPhone" 
                            placeholder="📱 Phone # (Opt)" 
                            style="width: 100%; border: 1px solid var(--wp-border); background: var(--wp-surface); color: var(--wp-text-primary); border-radius: 6px; padding: 4px 6px; font-size: 10.5px; outline: none; box-sizing: border-box;"
                        />
                    </div>

                    <!-- Items List -->
                    <div style="max-height: 40vh; overflow-y: auto; margin-bottom: 10px;">
                        @foreach($cart as $itemId => $cartItem)
                            <div style="padding: 6px 0; border-bottom: 1px solid var(--wp-border-subtle);">
                                <div style="display: flex; justify-content: space-between; font-size: 13px; font-weight: 700; color: var(--wp-text-primary);">
                                    <span>
                                        {{ $cartItem['name'] }}
                                        @if(!empty($cartItem['size_label']))
                                            <span style="display: inline-block; font-size: 9.5px; font-weight: 800; background: var(--wp-gold-bg); color: var(--wp-gold-text); border: 1px solid var(--wp-gold-border); border-radius: 4px; padding: 1px 5px; margin-left: 4px; vertical-align: middle;">
                                                {{ $cartItem['size_label'] }}
                                            </span>
                                        @endif
                                    </span>
                                    <span style="font-weight: 800;">Rs. {{ number_format($cartItem['price'] * $cartItem['quantity'], 0) }}</span>
                                </div>
                                @if(!empty($cartItem['description']))
                                    <div style="font-size: 10.5px; color: var(--wp-gold-text); background: var(--wp-gold-bg); border: 1px solid var(--wp-gold-border); border-radius: 6px; padding: 3px 6px; margin: 3px 0 4px 0; font-weight: 600; line-height: 1.3;">
                                        📦 {{ $cartItem['description'] }}
                                    </div>
                                @endif
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 4px;">
                                    <span style="font-size: 11px; color: var(--wp-text-muted);">Rs. {{ number_format($cartItem['price'], 0) }} each</span>
                                    <div style="display: flex; align-items: center; gap: 4px;">
                                        <button wire:click="updateQuantity('{{ $itemId }}', {{ $cartItem['quantity'] - 1 }})" style="background: var(--wp-surface-subtle); border: 1px solid var(--wp-border); color: var(--wp-text-primary); border-radius: 6px; width: 24px; height: 24px; font-weight: 800; cursor: pointer;">−</button>
                                        <span style="font-size: 13px; font-weight: 800; min-width: 18px; text-align: center; color: var(--wp-text-primary);">{{ $cartItem['quantity'] }}</span>
                                        <button wire:click="updateQuantity('{{ $itemId }}', {{ $cartItem['quantity'] + 1 }})" style="background: var(--wp-surface-subtle); border: 1px solid var(--wp-border); color: var(--wp-text-primary); border-radius: 6px; width: 24px; height: 24px; font-weight: 800; cursor: pointer;">+</button>
                                        <button wire:click="removeFromCart('{{ $itemId }}')" style="background: var(--wp-rose-bg); color: var(--wp-rose); border: 1px solid var(--wp-rose-border); border-radius: 6px; width: 24px; height: 24px; font-weight: 800; margin-left: 4px; cursor: pointer;">✕</button>
                                    </div>
                                </div>
                                <input 
                                    type="text" 
                                    wire:change="updateItemComment('{{ $itemId }}', $event.target.value)" 
                                    value="{{ $cartItem['comment'] ?? '' }}" 
                                    placeholder="Dish instruction..." 
                                    style="width: 100%; border: 1px solid var(--wp-border); background: var(--wp-surface); color: var(--wp-text-primary); border-radius: 6px; padding: 4px 8px; font-size: 10.5px; outline: none; margin-top: 4px; box-sizing: border-box;"
                                />
                            </div>
                        @endforeach
                    </div>

                    <!-- Quick Kitchen Instructions Chips -->
                    <div style="background: var(--wp-surface-subtle); border: 1px solid var(--wp-border); border-radius: 12px; padding: 10px; margin-bottom: 10px;">
                        <div style="font-size: 10px; font-weight: 800; color: var(--wp-text-muted); text-transform: uppercase; margin-bottom: 4px;">
                            ⚡ 1-Tap Kitchen Notes
                        </div>
                        <div class="chips-inline-flex">
                            @php
                                $quickChips = ['🌶️ Mild', '🔥 Spicy', '🧂 Less Salt', '🧅 No Onions', '⏱️ Jaldi', '🥤 Drinks 1st'];
                            @endphp
                            @foreach($quickChips as $chip)
                                <button 
                                    type="button" 
                                    wire:click="toggleQuickNote('{{ $chip }}')" 
                                    class="quick-instruction-chip {{ str_contains($specialNotes, $chip) ? 'selected' : '' }}"
                                >
                                    {{ $chip }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Total & Dual Action Buttons (Hold / Dispatch) -->
                    @php
                        $subtotal = $this->cartTotal;
                        $isVatEnabled = \App\Models\PosSetting::isVatEnabled();
                        $vatRate = \App\Models\PosSetting::getVatPercentage();
                        $tax = $isVatEnabled ? ($subtotal * ($vatRate / 100)) : 0;
                        $grandTotal = $subtotal + $tax;
                    @endphp
                    <div style="display: flex; justify-content: space-between; font-size: 15px; font-weight: 800; color: var(--wp-text-primary); margin-bottom: 10px;">
                        <span>Total ({{ $isVatEnabled ? "Incl. {$vatRate}% Tax" : "Tax Exempt" }})</span>
                        <span style="color: #059669;">Rs. {{ number_format($grandTotal, 0) }}</span>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1.6fr; gap: 8px;">
                        <button 
                            type="button"
                            wire:click="holdOrder" 
                            @if(count($cart) === 0) disabled @endif 
                            style="background: var(--wp-surface-subtle); color: var(--wp-text-primary); border: 1.5px solid var(--wp-gold); border-radius: 12px; padding: 12px 10px; font-weight: 800; font-size: 12px; cursor: pointer; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 2px;"
                            title="Park order on hold without sending to kitchen"
                        >
                            <span style="font-size: 16px;">⏸️</span>
                            <span style="letter-spacing: 0.3px;">HOLD / DRAFT</span>
                        </button>

                        <button 
                            type="button"
                            wire:click="sendToKitchen" 
                            @if(count($cart) === 0) disabled @endif 
                            class="btn-send-kot"
                            style="margin: 0; padding: 12px 14px;"
                        >
                            <span style="font-size: 18px;">🍳</span>
                            <span>DISPATCH KOT</span>
                        </button>
                    </div>

                    @if($activeOrderId)
                        @php
                            $activeOrderMobile = \App\Models\Order::find($activeOrderId);
                        @endphp
                        @if($activeOrderMobile && $activeOrderMobile->bill_requested)
                            <div style="margin-top: 8px; padding: 10px; border-radius: 12px; background: rgba(245, 158, 11, 0.15); border: 1.5px solid #d97706; color: #b45309; font-size: 11px; font-weight: 800; text-align: center; display: flex; align-items: center; justify-content: center; gap: 6px;">
                                <span>🧾</span>
                                <span>Bill Requested (Awaiting Cashier Settle)</span>
                            </div>
                        @else
                            <button 
                                wire:click="requestBillSettlement" 
                                type="button" 
                                style="width: 100%; margin-top: 8px; padding: 11px 12px; border-radius: 12px; border: 1.5px solid #059669; background: #ecfdf5; color: #065f46; font-size: 12px; font-weight: 800; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px;"
                                class="dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-emerald-800 hover:bg-emerald-100"
                                title="Guests requested bill - alert Cashier to prepare and settle invoice"
                            >
                                <span>🧾</span>
                                <span>REQUEST BILL / SETTLE</span>
                            </button>
                        @endif
                    @endif
                </div>
            </div>
        @endif

        <!-- ========================================== -->
        <!-- 6.5. PORTION / SIZE SELECTION MODAL        -->
        <!-- ========================================== -->
        @if($portionSelectionModalOpen && $portionModalItemId)
            @php
                $modalDish = \App\Models\MenuItem::find($portionModalItemId);
            @endphp
            @if($modalDish)
                <div class="sheet-modal-backdrop" wire:click.self="closePortionModal" style="z-index: 9999;">
                    <div class="sheet-modal-box" style="max-width: 480px; margin: auto; border-radius: 20px 20px 0 0;">
                        <div class="sheet-drag-handle"></div>
                        <div class="sheet-modal-header" style="align-items: flex-start; padding-bottom: 12px; border-bottom: 1px solid var(--wp-border);">
                            <div>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span style="font-size: 22px;">🍲</span>
                                    <div>
                                        <h3 class="sheet-modal-title" style="font-size: 16px; margin: 0;">
                                            {{ $modalDish->name }}
                                        </h3>
                                        <span style="font-size: 11px; color: var(--wp-text-muted); font-weight: 600;">
                                            Select Portion / Serving Size
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <button wire:click="closePortionModal" class="sheet-btn-close">✕</button>
                        </div>

                        @if(!empty($modalDish->description))
                            <div style="background: var(--wp-surface-subtle); border-left: 3px solid var(--wp-gold); border-radius: 0 8px 8px 0; padding: 6px 10px; margin: 12px 0; font-size: 11.5px; color: var(--wp-text-secondary); line-height: 1.35;">
                                <span style="font-weight: 800; color: var(--wp-gold-text);">ℹ️ Details:</span> {{ $modalDish->description }}
                            </div>
                        @endif

                        <!-- Portions Grid -->
                        <div style="display: grid; grid-template-columns: 1fr; gap: 8px; margin: 14px 0; max-height: 48vh; overflow-y: auto;">
                            @php
                                $sizes = is_array($modalDish->details['sizes'] ?? null) ? $modalDish->details['sizes'] : [];
                            @endphp

                            @forelse($sizes as $sizeKey => $sizePrice)
                                @php
                                    $sizeKeyClean = (string)$sizeKey;
                                    $cartItemKey = $modalDish->id . '_' . $sizeKeyClean;
                                    $currentQty = $cart[$cartItemKey]['quantity'] ?? 0;
                                    $numPrice = is_array($sizePrice) ? (float)($sizePrice['price'] ?? 0) : (float)$sizePrice;
                                    $portionTitle = is_array($sizePrice) && isset($sizePrice['label']) ? $sizePrice['label'] : ucwords(str_replace(['_', '-'], ' ', $sizeKeyClean));
                                    
                                    // Portion icons
                                    $portionIcon = '🥣';
                                    $lowerKey = strtolower($sizeKeyClean);
                                    if (str_contains($lowerKey, 'half') || str_contains($lowerKey, 'small') || str_contains($lowerKey, 'personal')) {
                                        $portionIcon = '🍲';
                                    } elseif (str_contains($lowerKey, 'full') || str_contains($lowerKey, 'large') || str_contains($lowerKey, 'jumbo')) {
                                        $portionIcon = '🥘';
                                    } elseif (str_contains($lowerKey, 'kg') || str_contains($lowerKey, 'kilo')) {
                                        $portionIcon = '⚖️';
                                    } elseif (str_contains($lowerKey, 'medium') || str_contains($lowerKey, 'regular')) {
                                        $portionIcon = '🍛';
                                    }
                                @endphp
                                <div style="background: var(--wp-surface); border: 1.5px solid {{ $currentQty > 0 ? 'var(--wp-gold)' : 'var(--wp-border)' }}; border-radius: 12px; padding: 10px 14px; display: flex; align-items: center; justify-content: space-between; transition: all 0.15s ease; box-shadow: {{ $currentQty > 0 ? '0 2px 8px rgba(245, 158, 11, 0.15)' : 'none' }};">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="font-size: 22px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; background: var(--wp-surface-subtle); border-radius: 8px;">
                                            {{ $portionIcon }}
                                        </div>
                                        <div>
                                            <div style="font-size: 13.5px; font-weight: 800; color: var(--wp-text-primary); display: flex; align-items: center; gap: 6px;">
                                                <span>{{ $portionTitle }}</span>
                                                @if($currentQty > 0)
                                                    <span style="font-size: 10px; font-weight: 800; background: var(--wp-gold-bg); color: var(--wp-gold-text); border: 1px solid var(--wp-gold-border); border-radius: 4px; padding: 1px 5px;">
                                                        {{ $currentQty }} in cart
                                                    </span>
                                                @endif
                                            </div>
                                            <div style="font-size: 12.5px; font-weight: 800; color: #059669; margin-top: 2px;">
                                                Rs. {{ number_format($numPrice, 0) }}
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        @if($currentQty > 0)
                                            <div class="handheld-stepper" style="border-color: var(--wp-gold);">
                                                <button wire:click="updateQuantity('{{ $cartItemKey }}', {{ $currentQty - 1 }})" class="stepper-btn-minus" style="width: 32px; height: 32px; font-size: 16px;">−</button>
                                                <span class="stepper-qty-display" style="min-width: 24px; font-size: 14px;">{{ $currentQty }}</span>
                                                <button wire:click="updateQuantity('{{ $cartItemKey }}', {{ $currentQty + 1 }})" class="stepper-btn-plus" style="width: 32px; height: 32px; font-size: 16px;">+</button>
                                            </div>
                                        @else
                                            <button 
                                                type="button" 
                                                wire:click="addToCart({{ $modalDish->id }}, '{{ $sizeKeyClean }}')"
                                                class="btn-add-handheld"
                                                style="padding: 7px 14px; font-size: 12.5px; min-width: 76px;"
                                            >
                                                <span style="font-weight: 900; font-size: 14px;">+</span>
                                                <span>ADD</span>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div style="text-align: center; padding: 20px; color: var(--wp-text-muted);">
                                    No specific portion sizes defined for this dish.
                                </div>
                            @endforelse
                        </div>

                        <!-- Footer -->
                        <div style="display: flex; gap: 10px; margin-top: 14px; padding-top: 12px; border-top: 1px solid var(--wp-border);">
                            <button 
                                type="button" 
                                wire:click="closePortionModal"
                                style="flex: 1; background: var(--wp-gold); color: #000; border: none; border-radius: 12px; padding: 12px; font-size: 13px; font-weight: 800; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px;"
                            >
                                <span>✓</span>
                                <span>Done</span>
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        @endif

        <!-- ========================================== -->
        <!-- 7. HANDHELD BOTTOM NAVIGATION TAB BAR      -->
        <!-- ========================================== -->
        <nav class="handheld-bottom-nav">
            <button wire:click="setTab('tables')" class="nav-item-tab {{ $currentTab === 'tables' ? 'active' : '' }}">
                <span class="nav-item-icon">🪑</span>
                <span class="nav-item-text">Tables</span>
            </button>

            <button wire:click="setTab('order')" class="nav-item-tab {{ $currentTab === 'order' ? 'active' : '' }}">
                <span class="nav-item-icon">🍽️</span>
                <span class="nav-item-text">Order</span>
                @if(count($cart) > 0)
                    <span class="nav-item-badge">{{ $this->cartCount }}</span>
                @endif
            </button>

            <button wire:click="setTab('alerts')" class="nav-item-tab {{ $currentTab === 'alerts' ? 'active' : '' }}">
                <span class="nav-item-icon">🔔</span>
                <span class="nav-item-text">Alerts</span>
                @if(count($this->servingNotifications) > 0)
                    <span class="nav-item-badge">{{ count($this->servingNotifications) }}</span>
                @endif
            </button>

            <button wire:click="setTab('shift')" class="nav-item-tab {{ $currentTab === 'shift' ? 'active' : '' }}">
                <span class="nav-item-icon">👤</span>
                <span class="nav-item-text">Shift</span>
            </button>
        </nav>

    </div>
</x-filament-panels::page>
