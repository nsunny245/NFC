<div class="pos-integrated-panel" wire:poll.5s>
    
    <!-- ========================================================================= -->
    <!-- SCOPED ROYAL RESTAURANT POS STYLESHEET (High-Contrast, Touch-Optimized)     -->
    <!-- ========================================================================= -->
    <style>
        /* 1. Global Reset & Total Elimination of Filament Native Topbar & Desktop Shell */
        html, body {
            height: 100% !important;
            max-height: 100% !important;
            overflow: hidden !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }
        .fi-topbar,
        .fi-topbar-ctn,
        .fi-topbar-nav,
        nav.fi-topbar,
        header.fi-topbar,
        div[class*="fi-topbar"],
        .fi-header,
        .fi-breadcrumbs,
        aside.fi-sidebar {
            display: none !important;
            height: 0 !important;
            max-height: 0 !important;
            min-height: 0 !important;
            opacity: 0 !important;
            visibility: hidden !important;
            pointer-events: none !important;
            overflow: hidden !important;
            margin: 0 !important;
            padding: 0 !important;
            border: none !important;
        }
        .fi-layout, .fi-main, .fi-main-ctn, .fi-page, .fi-page-content, .fi-page > section {
            padding: 0 !important;
            margin: 0 !important;
            max-width: 100% !important;
            width: 100% !important;
            height: 100% !important;
            max-height: 100% !important;
            overflow: hidden !important;
        }
        :root, body, .fi-layout {
            --sidebar-width: 0px !important;
        }

        .pos-integrated-panel {
            padding: 6px 10px !important;
            height: 100vh !important;
            max-height: 100vh !important;
            overflow: hidden !important;
            box-sizing: border-box !important;
        }

        /* 2. Top Terminal Appbar */
        .pos-appbar {
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            padding: 5px 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            margin-bottom: 6px;
            height: 50px;
            box-sizing: border-box;
        }
        .dark .pos-appbar {
            background: #111827;
            border-color: #1f2937;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.35);
        }

        .pos-brand-badge {
            display: flex;
            align-items: center;
            gap: 9px;
            flex-shrink: 0;
        }
        /* Circular Brand Logo with Gold Ring */
        .pos-brand-logo {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #ffffff;
            border: 2px solid #D4A437;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(212, 164, 55, 0.35);
            flex-shrink: 0;
        }
        .pos-brand-logo-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .pos-brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.15;
        }
        .pos-brand-title {
            font-size: 13px;
            font-weight: 900;
            letter-spacing: 0.02em;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .dark .pos-brand-title {
            color: #f8fafc;
        }
        .pos-brand-tag {
            font-size: 8px;
            font-weight: 800;
            background: #D4A437;
            color: #000000;
            padding: 1px 5px;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .pos-brand-meta {
            font-size: 9.5px;
            font-family: monospace;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 1px;
        }
        .dark .pos-brand-meta {
            color: #94a3b8;
        }

        /* Search Input in Header */
        .pos-search-wrap {
            flex: 1;
            max-width: 280px;
            position: relative;
        }
        .pos-search-input {
            width: 100%;
            height: 32px;
            border-radius: 9999px;
            background: #f8fafc;
            border: 1.5px solid #cbd5e1;
            padding: 0 30px 0 30px;
            font-size: 11px;
            font-weight: 600;
            color: #0f172a;
            outline: none;
            transition: all 0.2s ease;
            box-sizing: border-box;
        }
        .dark .pos-search-input {
            background: #1e293b;
            border-color: #334155;
            color: #f8fafc;
        }
        .pos-search-input:focus {
            background: #ffffff;
            border-color: #D4A437;
            box-shadow: 0 0 0 3px rgba(212, 164, 55, 0.25);
        }
        .dark .pos-search-input:focus {
            background: #0f172a;
        }
        .pos-search-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 12px;
            color: #94a3b8;
            pointer-events: none;
        }
        .pos-search-clear {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #e2e8f0;
            color: #475569;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 800;
            line-height: 1;
        }
        .dark .pos-search-clear {
            background: #334155;
            color: #cbd5e1;
        }

        /* Header Control Buttons */
        .pos-theme-toggle-btn {
            background: #f1f5f9;
            border: 1.5px solid #cbd5e1;
            color: #334155;
            border-radius: 9999px;
            padding: 5px 11px;
            font-size: 10px;
            font-weight: 800;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.15s ease;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .dark .pos-theme-toggle-btn {
            background: #1e293b;
            border-color: #475569;
            color: #f8fafc;
        }
        .pos-theme-toggle-btn:hover {
            border-color: #D4A437;
            color: #b45309;
            transform: translateY(-1px);
        }
        .dark .pos-theme-toggle-btn:hover {
            color: #fde68a;
        }

        /* Larger, Prominent Notification Section next to Theme Switcher */
        .pos-notif-btn {
            background: #f1f5f9;
            border: 1.5px solid #cbd5e1;
            color: #334155;
            border-radius: 9999px;
            padding: 5px 12px;
            font-size: 10px;
            font-weight: 800;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.15s ease;
            white-space: nowrap;
            position: relative;
            flex-shrink: 0;
        }
        .dark .pos-notif-btn {
            background: #1e293b;
            border-color: #475569;
            color: #f8fafc;
        }
        .pos-notif-btn:hover {
            border-color: #D4A437;
            color: #b45309;
            transform: translateY(-1px);
        }
        .dark .pos-notif-btn:hover {
            color: #fde68a;
        }
        .pos-notif-count-badge {
            background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
            color: #ffffff;
            font-size: 8.5px;
            font-weight: 900;
            padding: 1px 5px;
            border-radius: 9999px;
            box-shadow: 0 1px 4px rgba(239, 68, 68, 0.35);
        }

        /* Cloud Sync Engine Status Badge */
        .pos-sync-badge {
            background: #ecfdf5;
            border: 1.5px solid #10b981;
            color: #065f46;
            border-radius: 9999px;
            padding: 5px 10px;
            font-size: 10px;
            font-weight: 800;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
            transition: all 0.15s ease;
            flex-shrink: 0;
        }
        .dark .pos-sync-badge {
            background: rgba(16, 185, 129, 0.15);
            border-color: #059669;
            color: #34d399;
        }
        .pos-sync-badge:hover {
            transform: translateY(-1px);
        }
        .pos-sync-badge.offline {
            background: #fef2f2 !important;
            border-color: #ef4444 !important;
            color: #991b1b !important;
        }
        .dark .pos-sync-badge.offline {
            background: rgba(239, 68, 68, 0.15) !important;
            border-color: #dc2626 !important;
            color: #f87171 !important;
        }
        .pos-sync-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #10b981;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.35);
        }
        .pos-sync-badge.offline .pos-sync-dot {
            background: #ef4444;
            box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.35);
        }
        .pos-install-app-btn {
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            border: 1.5px solid #38bdf8;
            color: #ffffff !important;
            border-radius: 9999px;
            padding: 5px 12px;
            font-size: 10px;
            font-weight: 800;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.15s ease;
            white-space: nowrap;
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(2, 132, 199, 0.3);
        }
        .pos-install-app-btn:hover {
            background: linear-gradient(135deg, #0369a1 0%, #075985 100%);
            transform: translateY(-1px);
        }

        .pos-btn-floormap {
            background: rgba(212, 164, 55, 0.12);
            border: 1.5px solid rgba(212, 164, 55, 0.45);
            color: #b45309;
            border-radius: 9999px;
            padding: 5px 12px;
            font-size: 10px;
            font-weight: 800;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.15s ease;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .dark .pos-btn-floormap {
            background: rgba(212, 164, 55, 0.15);
            color: #fde68a;
            border-color: rgba(212, 164, 55, 0.4);
        }
        .pos-btn-floormap:hover {
            background: rgba(212, 164, 55, 0.25);
            transform: translateY(-1px);
        }

        .pos-btn-expense {
            background: rgba(239, 68, 68, 0.12);
            border: 1.5px solid rgba(239, 68, 68, 0.45);
            color: #b91c1c;
            border-radius: 9999px;
            padding: 5px 12px;
            font-size: 10px;
            font-weight: 800;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.15s ease;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .dark .pos-btn-expense {
            background: rgba(239, 68, 68, 0.18);
            color: #fca5a5;
            border-color: rgba(239, 68, 68, 0.4);
        }
        .pos-btn-expense:hover {
            background: rgba(239, 68, 68, 0.25);
            transform: translateY(-1px);
        }

        .pos-till-status-pill {
            background: #ecfdf5;
            border: 1.5px solid #10b981;
            color: #065f46;
            border-radius: 9999px;
            padding: 5px 11px;
            font-size: 10px;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .dark .pos-till-status-pill {
            background: rgba(16, 185, 129, 0.15);
            border-color: #059669;
            color: #34d399;
        }
        .pos-till-pulse-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #10b981;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.35);
            animation: posPulse 2s infinite;
        }
        @keyframes posPulse {
            0% { transform: scale(0.95); opacity: 0.8; }
            50% { transform: scale(1.2); opacity: 1; }
            100% { transform: scale(0.95); opacity: 0.8; }
        }

        .pos-btn-shift-close {
            background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
            color: #ffffff !important;
            border: 1.5px solid #dc2626;
            border-radius: 9999px;
            padding: 6px 13px;
            font-size: 10px;
            font-weight: 900;
            letter-spacing: 0.03em;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.4);
            transition: all 0.15s ease;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .pos-btn-shift-close:hover {
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.55);
        }

        .pos-btn-shift-open {
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            color: #ffffff !important;
            border: 1.5px solid #059669;
            border-radius: 9999px;
            padding: 6px 13px;
            font-size: 10px;
            font-weight: 900;
            letter-spacing: 0.03em;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.4);
            transition: all 0.15s ease;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .pos-btn-shift-open:hover {
            background: linear-gradient(135deg, #059669 0%, #065f46 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.55);
        }

        /* Cashier Profile Pop-up (Replaces small door icon) */
        .pos-cashier-trigger-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #D4A437;
            color: #000000;
            font-size: 11.5px;
            font-weight: 900;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 1.5px solid #b8860b;
            box-shadow: 0 2px 6px rgba(212, 164, 55, 0.35);
            transition: all 0.15s ease;
            flex-shrink: 0;
        }
        .pos-cashier-trigger-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(212, 164, 55, 0.5);
        }
        .pos-cashier-popup {
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            width: 250px;
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            box-shadow: 0 14px 35px rgba(0, 0, 0, 0.2);
            padding: 12px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .dark .pos-cashier-popup {
            background: #111827;
            border-color: #1f2937;
        }
        .pos-cashier-popup-header {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .pos-cashier-popup-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #D4A437;
            color: #000;
            font-size: 13px;
            font-weight: 900;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .pos-cashier-popup-info {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }
        .pos-cashier-popup-name {
            font-size: 12px;
            font-weight: 900;
            color: #0f172a;
            line-height: 1.2;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .dark .pos-cashier-popup-name {
            color: #f8fafc;
        }
        .pos-cashier-popup-role {
            font-size: 9px;
            font-weight: 800;
            color: #b45309;
            text-transform: uppercase;
            margin-top: 1px;
        }
        .dark .pos-cashier-popup-role {
            color: #fde68a;
        }
        .pos-cashier-popup-email {
            font-size: 9.5px;
            color: #64748b;
            font-family: monospace;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .dark .pos-cashier-popup-email {
            color: #94a3b8;
        }
        .pos-cashier-logout-btn {
            width: 100%;
            padding: 9px 12px;
            border-radius: 8px;
            border: none;
            background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
            color: #ffffff !important;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 0.03em;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.4);
            transition: all 0.15s ease;
        }
        .pos-cashier-logout-btn:hover {
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
        }

        /* 3. Main Split Workspace (Menu Grid + Cart Sidebar) */
        .pos-main-body {
            display: grid;
            grid-template-columns: 1fr 375px;
            gap: 10px;
            height: calc(100vh - 66px);
            min-height: calc(100vh - 66px);
            max-height: calc(100vh - 66px);
            overflow: hidden;
            box-sizing: border-box;
        }
        @media (max-width: 1180px) {
            .pos-main-body {
                grid-template-columns: 1fr 340px;
            }
        }
        @media (max-width: 900px) {
            .pos-main-body {
                grid-template-columns: 1fr;
                height: auto;
                max-height: none;
                overflow-y: auto;
            }
        }

        /* Left Section: Menu Column */
        .pos-menu-panel {
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            height: 100%;
            min-height: 0;
        }
        .dark .pos-menu-panel {
            background: #111827;
            border-color: #1f2937;
        }

        /* Category Horizontal Scroll Dock */
        .pos-cat-dock {
            padding: 6px 10px;
            background: #f8fafc;
            border-bottom: 1.5px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 5px;
            overflow-x: auto;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .dark .pos-cat-dock {
            background: #0f172a;
            border-color: #1f2937;
        }
        .pos-cat-btn {
            padding: 5px 12px;
            border-radius: 9999px;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            border: 1.5px solid #cbd5e1;
            background: #ffffff;
            color: #334155;
            cursor: pointer;
            transition: all 0.15s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            gap: 4px;
            flex-shrink: 0;
        }
        .dark .pos-cat-btn {
            background: #1e293b;
            border-color: #334155;
            color: #cbd5e1;
        }
        .pos-cat-btn:hover {
            border-color: #D4A437;
            color: #b45309;
            transform: translateY(-1px);
        }
        .dark .pos-cat-btn:hover {
            color: #fde68a;
        }
        .pos-cat-btn.active {
            background: linear-gradient(135deg, #D4A437 0%, #b8860b 100%) !important;
            color: #000000 !important;
            border-color: #b8860b !important;
            box-shadow: 0 2px 8px rgba(212, 164, 55, 0.35);
        }

        /* Menu Food Grid: 3 TO 4 SPACIOUS COLUMNS FOR RICH, PREMIUM PRESENTATION */
        .pos-food-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(295px, 1fr));
            grid-auto-rows: minmax(220px, auto);
            gap: 13px;
            padding: 12px;
            overflow-y: auto;
            flex: 1;
            align-content: start;
            min-height: 0;
        }
        @media (max-width: 900px) {
            .pos-food-grid {
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
                grid-auto-rows: minmax(220px, auto);
                gap: 10px;
                padding: 8px;
            }
        }

        /* Enriched Food Card with Details - Generously Sized, High Visibility Box */
        .pos-food-card {
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
            padding: 12px 14px;
            box-sizing: border-box;
            min-height: 220px;
            overflow: hidden;
        }
        .dark .pos-food-card {
            background: #1e293b;
            border-color: #334155;
        }
        .pos-food-card:hover {
            transform: translateY(-2px);
            border-color: #D4A437;
            box-shadow: 0 8px 20px rgba(212, 164, 55, 0.18);
        }

        .pos-food-thumb {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid #cbd5e1;
            flex-shrink: 0;
        }
        .dark .pos-food-thumb {
            border-color: #475569;
        }

        .pos-card-badge {
            font-size: 8.5px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            padding: 2px 7px;
            border-radius: 5px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.15);
            line-height: 1.2;
            display: inline-flex;
            align-items: center;
        }
        .pos-card-badge.gold {
            background: linear-gradient(135deg, #D4A437 0%, #b8860b 100%);
            color: #000000;
        }
        .pos-card-badge.red {
            background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
            color: #ffffff;
        }
        .pos-card-badge.green {
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            color: #ffffff;
        }

        .pos-food-details {
            padding-top: 8px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            flex: 1;
            justify-content: space-between;
        }
        .pos-food-title {
            font-size: 13px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.25;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .dark .pos-food-title {
            color: #f8fafc;
        }

        /* Deal Items & Description Box (Waiter Pad parity) */
        .pos-dish-desc-box {
            background: #f8fafc;
            border-left: 3px solid #f59e0b;
            border-radius: 0 6px 6px 0;
            padding: 4px 8px;
            margin: 3px 0 4px 0;
            font-size: 10px;
            line-height: 1.35;
            color: #334155;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .dark .pos-dish-desc-box {
            background: rgba(245, 158, 11, 0.08);
            border-left-color: #D4A437;
            color: #cbd5e1;
        }
        .pos-desc-tag {
            color: #b45309;
            font-weight: 800;
            margin-right: 2px;
        }
        .dark .pos-desc-tag {
            color: #fde68a;
        }

        .pos-sizes-pills-row {
            display: flex;
            flex-wrap: wrap;
            gap: 3px;
            margin-top: 2px;
        }
        .pos-size-mini-pill {
            background: #fffbeb;
            border: 1px solid #fde68a;
            color: #92400e;
            font-size: 8.5px;
            font-weight: 800;
            padding: 1px 5px;
            border-radius: 4px;
            font-family: monospace;
        }
        .dark .pos-size-mini-pill {
            background: rgba(245, 158, 11, 0.12);
            border-color: rgba(245, 158, 11, 0.3);
            color: #fcd34d;
        }

        .pos-food-bottom-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: 1px solid #f1f5f9;
            padding-top: 8px;
            margin-top: auto;
            flex-shrink: 0;
        }
        .dark .pos-food-bottom-row {
            border-color: #334155;
        }

        .pos-food-price {
            font-size: 14px;
            font-weight: 900;
            color: #b45309;
            font-family: monospace;
            line-height: 1;
        }
        .dark .pos-food-price {
            color: #fde68a;
        }

        /* Tactile Add & Sizes Buttons */
        .pos-add-item-btn {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            font-size: 10.5px;
            font-weight: 900;
            padding: 5px 12px;
            border-radius: 7px;
            border: none;
            cursor: pointer;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            box-shadow: 0 2px 5px rgba(16, 185, 129, 0.35);
        }
        .pos-add-item-btn:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(16, 185, 129, 0.45);
        }
        .pos-add-item-btn:active {
            transform: translateY(0);
        }

        .pos-sizes-item-btn {
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
            color: #92400e;
            border: 1.5px solid #f59e0b;
            font-size: 10px;
            font-weight: 900;
            padding: 4px 10px;
            border-radius: 7px;
            cursor: pointer;
            transition: all 0.15s ease;
            text-transform: uppercase;
        }
        .dark .pos-sizes-item-btn {
            background: rgba(245, 158, 11, 0.15);
            border-color: rgba(245, 158, 11, 0.4);
            color: #fbbf24;
        }
        .pos-sizes-item-btn:hover {
            background: #D4A437;
            color: #000000;
            border-color: #b8860b;
            transform: translateY(-1px);
        }

        /* 4. Right Section: Active Cart Sidebar (Zero Page Scroll) */
        .pos-cart-panel {
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            height: 100%;
            max-height: 100%;
            min-height: 0;
            box-sizing: border-box;
        }
        .dark .pos-cart-panel {
            background: #111827;
            border-color: #1f2937;
        }

        /* Segmented Order Mode Controller */
        .pos-mode-dock {
            padding: 4px 6px;
            background: #f8fafc;
            border-bottom: 1.5px solid #e2e8f0;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 4px;
            flex-shrink: 0;
        }
        .dark .pos-mode-dock {
            background: #0f172a;
            border-color: #1f2937;
        }
        .pos-mode-btn {
            padding: 8px 6px;
            min-height: 38px;
            border-radius: 9px;
            font-size: 11.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            border: 1.5px solid #cbd5e1;
            background: #ffffff;
            color: #334155;
            cursor: pointer;
            transition: all 0.15s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
        }
        .dark .pos-mode-btn {
            background: #1e293b;
            border-color: #334155;
            color: #cbd5e1;
        }
        .pos-mode-btn:hover {
            border-color: #D4A437;
            transform: translateY(-1px);
        }
        .pos-mode-btn.active {
            background: linear-gradient(135deg, #D4A437 0%, #b8860b 100%) !important;
            color: #000000 !important;
            border-color: #b8860b !important;
            box-shadow: 0 2px 8px rgba(212, 164, 55, 0.4);
        }

        /* Table Selector Action Bar */
        .pos-table-strip {
            padding: 6px 10px;
            background: #fffbeb;
            border-bottom: 1px solid #fde68a;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 11px;
            font-weight: 700;
            color: #92400e;
            flex-shrink: 0;
        }
        .dark .pos-table-strip {
            background: rgba(245, 158, 11, 0.12);
            border-color: rgba(245, 158, 11, 0.25);
            color: #fde68a;
        }

        /* Guest Information Strip */
        .pos-guest-strip {
            padding: 6px 8px;
            border-bottom: 1.5px solid #e2e8f0;
            background: #ffffff;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            flex-shrink: 0;
        }
        .dark .pos-guest-strip {
            background: #111827;
            border-color: #1f2937;
        }
        .pos-guest-input {
            width: 100%;
            height: 38px;
            border-radius: 9px;
            border: 1.5px solid #cbd5e1;
            background: #ffffff;
            padding: 0 10px;
            font-size: 12.5px;
            font-weight: 600;
            color: #0f172a;
            outline: none;
            box-sizing: border-box;
            transition: all 0.15s ease;
        }
        .pos-guest-input::placeholder {
            color: #94a3b8;
            font-size: 11.5px;
            font-weight: 500;
        }
        .dark .pos-guest-input {
            background: #1e293b;
            border-color: #334155;
            color: #f8fafc;
        }
        .dark .pos-guest-input::placeholder {
            color: #64748b;
            font-size: 11.5px;
        }
        .pos-guest-input:focus {
            border-color: #D4A437;
            background: #ffffff;
            color: #0f172a;
            box-shadow: 0 0 0 3px rgba(212, 164, 55, 0.2);
        }
        .dark .pos-guest-input:focus {
            border-color: #D4A437 !important;
            background: #1e293b !important;
            color: #ffffff !important;
            box-shadow: 0 0 0 3px rgba(212, 164, 55, 0.35) !important;
        }

        /* Cart Items Scroll List (Self-Scrolling Only, Compact Empty State) */
        .pos-cart-items-list {
            flex: 1 1 auto;
            overflow-y: auto;
            padding: 5px 6px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            min-height: 80px;
        }
        .pos-cart-empty-box {
            padding: 16px 8px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #94a3b8;
        }
        .pos-cart-item-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 5px 7px;
            display: flex;
            flex-direction: column;
            gap: 3px;
            transition: all 0.15s ease;
        }
        .dark .pos-cart-item-card {
            background: #1e293b;
            border-color: #334155;
        }
        .pos-cart-item-card:hover {
            border-color: #cbd5e1;
        }

        .pos-cart-item-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 5px;
        }
        .pos-cart-item-title {
            font-size: 10px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.2;
            flex: 1;
        }
        .dark .pos-cart-item-title {
            color: #f8fafc;
        }
        .pos-cart-item-total {
            font-size: 10px;
            font-weight: 900;
            color: #0f172a;
            font-family: monospace;
            flex-shrink: 0;
        }
        .dark .pos-cart-item-total {
            color: #f8fafc;
        }

        .pos-cart-item-controls {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 4px;
            margin-top: 1px;
        }
        .pos-cart-comment-input {
            flex: 1;
            height: 20px;
            border-radius: 4px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            padding: 0 5px;
            font-size: 8.5px;
            color: #475569;
            outline: none;
            box-sizing: border-box;
        }
        .dark .pos-cart-comment-input {
            background: #0f172a;
            border-color: #334155;
            color: #cbd5e1;
        }

        /* Tactile Stepper Buttons */
        .pos-stepper-btn {
            width: 20px;
            height: 20px;
            border-radius: 4px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            color: #0f172a;
            font-size: 10px;
            font-weight: 900;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.15s ease;
            line-height: 1;
        }
        .dark .pos-stepper-btn {
            background: #0f172a;
            border-color: #334155;
            color: #f8fafc;
        }
        .pos-stepper-btn:hover {
            background: #e2e8f0;
            border-color: #94a3b8;
        }
        .pos-delete-item-btn {
            width: 20px;
            height: 20px;
            border-radius: 4px;
            border: 1px solid #fca5a5;
            background: #fef2f2;
            color: #dc2626;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 9.5px;
            transition: all 0.15s ease;
        }
        .pos-delete-item-btn:hover {
            background: #dc2626;
            color: #ffffff;
        }

        /* Financial Breakdown Ticket */
        .pos-financial-ticket {
            padding: 5px 8px;
            background: #f8fafc;
            border-top: 2px dashed #cbd5e1;
            display: flex;
            flex-direction: column;
            gap: 2px;
            font-size: 10px;
            flex-shrink: 0;
        }
        .dark .pos-financial-ticket {
            background: #0f172a;
            border-color: #334155;
        }
        .pos-financial-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #64748b;
        }
        .dark .pos-financial-row {
            color: #94a3b8;
        }
        .pos-financial-val {
            font-family: monospace;
            font-weight: 700;
            color: #0f172a;
        }
        .dark .pos-financial-val {
            color: #f8fafc;
        }

        /* Grand Total Box */
        .pos-total-box {
            background: linear-gradient(135deg, #0f172a 0%, #020617 100%);
            border: 1.5px solid #D4A437;
            border-radius: 9px;
            padding: 5px 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #ffffff;
            margin-top: 2px;
            box-shadow: 0 3px 10px rgba(212, 164, 55, 0.2);
        }
        .pos-total-label {
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 0.05em;
            color: #D4A437;
            text-transform: uppercase;
        }
        .pos-total-val {
            font-size: 15px;
            font-weight: 900;
            color: #10b981;
            font-family: monospace;
            line-height: 1;
        }

        /* Action Buttons Area: PRONOUNCED ENERGETIC COLORS */
        .pos-cart-actions {
            padding: 7px 8px;
            background: #ffffff;
            border-top: 1.5px solid #e2e8f0;
            display: flex;
            flex-direction: column;
            gap: 7px;
            flex-shrink: 0;
        }
        .dark .pos-cart-actions {
            background: #111827;
            border-color: #1f2937;
        }

        .pos-util-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 6px;
        }
        
        /* 1. Generate / Update KOT Button: Vibrant Indigo */
        .pos-btn-kot {
            background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%) !important;
            color: #ffffff !important;
            border: 1.5px solid #4338ca !important;
            border-radius: 10px;
            padding: 8px 6px;
            min-height: 42px;
            font-size: 11.5px;
            font-weight: 800;
            letter-spacing: 0.02em;
            cursor: pointer;
            box-shadow: 0 2px 7px rgba(79, 70, 229, 0.35);
            transition: all 0.15s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            text-align: center;
            white-space: nowrap;
        }
        .pos-btn-kot:hover:not(:disabled) {
            background: linear-gradient(135deg, #4338ca 0%, #312e81 100%) !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.5);
        }
        .pos-btn-kot:disabled {
            opacity: 0.45;
            cursor: not-allowed;
            box-shadow: none;
        }

        /* 2. Hold Order Button: Vibrant Amber / Orange */
        .pos-btn-hold {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
            color: #ffffff !important;
            border: 1.5px solid #b45309 !important;
            border-radius: 10px;
            padding: 8px 6px;
            min-height: 42px;
            font-size: 11.5px;
            font-weight: 800;
            letter-spacing: 0.02em;
            cursor: pointer;
            box-shadow: 0 2px 7px rgba(217, 119, 6, 0.35);
            transition: all 0.15s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            text-align: center;
            white-space: nowrap;
        }
        .pos-btn-hold:hover:not(:disabled) {
            background: linear-gradient(135deg, #d97706 0%, #92400e 100%) !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(217, 119, 6, 0.5);
        }
        .pos-btn-hold:disabled {
            opacity: 0.45;
            cursor: not-allowed;
            box-shadow: none;
        }

        /* 3. Print Bill Button: Vibrant Emerald / Teal */
        .pos-btn-print {
            background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%) !important;
            color: #ffffff !important;
            border: 1.5px solid #0f766e !important;
            border-radius: 10px;
            padding: 8px 6px;
            min-height: 42px;
            font-size: 11.5px;
            font-weight: 800;
            letter-spacing: 0.02em;
            cursor: pointer;
            box-shadow: 0 2px 7px rgba(13, 148, 136, 0.35);
            transition: all 0.15s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            text-align: center;
            white-space: nowrap;
        }
        .pos-btn-print:hover:not(:disabled) {
            background: linear-gradient(135deg, #0f766e 0%, #115e59 100%) !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(13, 148, 136, 0.5);
        }
        .pos-btn-print:disabled {
            opacity: 0.45;
            cursor: not-allowed;
            box-shadow: none;
        }

        /* 4. Clear Cart Button: Vibrant Crimson Red */
        .pos-btn-clear {
            background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%) !important;
            color: #ffffff !important;
            border: 1.5px solid #dc2626 !important;
            border-radius: 10px;
            padding: 8px 6px;
            min-height: 42px;
            font-size: 11.5px;
            font-weight: 800;
            letter-spacing: 0.02em;
            cursor: pointer;
            box-shadow: 0 2px 7px rgba(239, 68, 68, 0.35);
            transition: all 0.15s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            text-align: center;
            white-space: nowrap;
        }
        .pos-btn-clear:hover:not(:disabled) {
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%) !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.5);
        }

        /* Master Settle Button: RADIANT NAWABI GOLD */
        .pos-settle-cta-btn {
            width: 100%;
            padding: 12px 14px;
            min-height: 48px;
            border-radius: 12px;
            border: 1.5px solid #fcd34d;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 50%, #b45309 100%);
            color: #ffffff;
            font-size: 13.5px;
            font-weight: 900;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 16px rgba(217, 119, 6, 0.45);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.35);
        }
        .pos-settle-cta-btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(217, 119, 6, 0.65);
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 50%, #d97706 100%);
        }
        .pos-settle-cta-btn:active:not(:disabled) {
            transform: translateY(0);
        }
        .pos-settle-cta-btn:disabled {
            background: #cbd5e1 !important;
            color: #64748b !important;
            border-color: #cbd5e1 !important;
            box-shadow: none !important;
            cursor: not-allowed;
            text-shadow: none !important;
        }
        .dark .pos-settle-cta-btn:disabled {
            background: #334155 !important;
            color: #94a3b8 !important;
            border-color: #334155 !important;
        }

        /* Quick Monitor Strip (Ongoing & Kitchen & Expense): HIGH CONTRAST */
        .pos-monitor-strip {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 6px;
            padding-top: 2px;
        }
        .pos-monitor-btn.ongoing {
            padding: 8px 6px;
            min-height: 38px;
            border-radius: 9px;
            border: 1.5px solid #f59e0b;
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
            color: #92400e;
            font-size: 11px;
            font-weight: 800;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.15s ease;
            box-shadow: 0 1px 4px rgba(245, 158, 11, 0.15);
        }
        .dark .pos-monitor-btn.ongoing {
            background: rgba(245, 158, 11, 0.15);
            border-color: #b45309;
            color: #fcd34d;
        }
        .pos-monitor-btn.ongoing:hover {
            background: #f59e0b;
            color: #000000;
        }

        .pos-monitor-btn.kitchen {
            padding: 8px 6px;
            min-height: 38px;
            border-radius: 9px;
            border: 1.5px solid #ea580c;
            background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%);
            color: #9a3412;
            font-size: 11px;
            font-weight: 800;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.15s ease;
            box-shadow: 0 1px 4px rgba(234, 88, 12, 0.15);
        }
        .dark .pos-monitor-btn.kitchen {
            background: rgba(234, 88, 12, 0.15);
            border-color: #c2410c;
            color: #fdba74;
        }
        .pos-monitor-btn.kitchen:hover {
            background: #ea580c;
            color: #ffffff;
        }

        .pos-monitor-btn.expense {
            padding: 8px 6px;
            min-height: 38px;
            border-radius: 9px;
            border: 1.5px solid #ef4444;
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            color: #b91c1c;
            font-size: 11px;
            font-weight: 800;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 3px;
            transition: all 0.15s ease;
            box-shadow: 0 1px 4px rgba(239, 68, 68, 0.15);
        }
        .dark .pos-monitor-btn.expense {
            background: rgba(239, 68, 68, 0.15);
            border-color: #b91c1c;
            color: #fca5a5;
        }
        .pos-monitor-btn.expense:hover {
            background: #ef4444;
            color: #ffffff;
        }

        .pos-monitor-badge {
            background: #0f172a;
            color: #ffffff;
            padding: 2px 7px;
            border-radius: 6px;
            font-size: 11px;
            font-family: monospace;
            font-weight: 900;
        }
        .dark .pos-monitor-badge {
            background: #ffffff;
            color: #0f172a;
        }

        /* Pagination Dock (Dark mode friendly) */
        .pos-pagination-dock {
            padding: 5px 10px;
            background: #f8fafc;
            border-top: 1.5px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            flex-shrink: 0;
        }
        .dark .pos-pagination-dock {
            background: #0f172a !important;
            border-color: #1f2937 !important;
        }
        .pos-page-btn {
            padding: 3px 8px;
            font-size: 9.5px;
            font-family: monospace;
            font-weight: 800;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            color: #334155;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .dark .pos-page-btn {
            background: #1e293b !important;
            border-color: #334155 !important;
            color: #f8fafc !important;
        }
        .pos-page-btn:hover:not(:disabled) {
            border-color: #D4A437;
            color: #b45309;
        }
        .dark .pos-page-btn:hover:not(:disabled) {
            color: #fde68a;
        }
        .pos-page-btn.active {
            background: linear-gradient(135deg, #D4A437 0%, #b8860b 100%) !important;
            color: #000000 !important;
            border-color: #b8860b !important;
        }
        .pos-page-btn:disabled {
            opacity: 0.35;
            cursor: not-allowed;
        }

        /* 5. Modals & Overlays */
        .pos-overlay-backdrop {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            padding: 16px;
        }
        .pos-modal-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            padding: 18px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
            display: flex;
            flex-direction: column;
            gap: 14px;
            color: #0f172a;
        }
        .dark .pos-modal-card {
            background: #111827;
            border-color: #1f2937;
            color: #f8fafc;
        }

        /* Modal Headings & Dividers */
        .pos-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 10px;
        }
        .dark .pos-modal-header {
            border-color: #334155 !important;
        }
        .pos-modal-title {
            font-size: 13px;
            font-weight: 900;
            text-transform: uppercase;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .dark .pos-modal-title {
            color: #f8fafc !important;
        }
        .pos-modal-close-btn {
            background: none;
            border: none;
            font-size: 22px;
            cursor: pointer;
            color: #94a3b8;
            transition: color 0.15s ease;
            line-height: 1;
            padding: 0 4px;
        }
        .pos-modal-close-btn:hover {
            color: #ef4444;
        }

        /* Modal Content Containers (Replaces inline backgrounds) */
        .pos-modal-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px;
            color: #0f172a;
        }
        .dark .pos-modal-box {
            background: #1e293b !important;
            border-color: #334155 !important;
            color: #f8fafc !important;
        }

        /* Modal Sub-cards & Row items */
        .pos-modal-row {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 10px;
            color: #0f172a;
            transition: all 0.15s ease;
        }
        .dark .pos-modal-row {
            background: #1e293b !important;
            border-color: #334155 !important;
            color: #f8fafc !important;
        }

        /* Portion Selection Buttons in Modal */
        .pos-portion-btn {
            padding: 12px 6px;
            border-radius: 10px;
            border: 1.5px solid #cbd5e1;
            background: #ffffff;
            color: #0f172a;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            transition: all 0.15s ease;
        }
        .pos-portion-btn:hover {
            border-color: #D4A437;
            transform: translateY(-1px);
        }
        .dark .pos-portion-btn {
            background: #1e293b !important;
            border-color: #334155 !important;
            color: #f8fafc !important;
        }
        .dark .pos-portion-btn:hover {
            border-color: #D4A437 !important;
            background: #0f172a !important;
        }
        .pos-portion-price {
            font-size: 11px;
            font-weight: 900;
            color: #b45309;
            font-family: monospace;
        }
        .dark .pos-portion-price {
            color: #fde68a !important;
        }
        .pos-portion-crown-wrap {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            background: #fffbeb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
            border: 1px solid #fef3c7;
        }
        .dark .pos-portion-crown-wrap {
            background: #0f172a !important;
            border-color: #334155 !important;
        }

        /* Quick Cash Stepper Chips */
        .pos-chip-btn {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 3px 8px;
            font-size: 9.5px;
            font-weight: 800;
            font-family: monospace;
            color: #334155;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .pos-chip-btn:hover {
            border-color: #D4A437;
            color: #b45309;
        }
        .dark .pos-chip-btn {
            background: #1e293b !important;
            border-color: #334155 !important;
            color: #f8fafc !important;
        }
        .dark .pos-chip-btn:hover {
            border-color: #D4A437 !important;
            color: #fde68a !important;
        }

        /* Modal Secondary / Dismiss Buttons */
        .pos-modal-cancel-btn {
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            color: #475569;
            font-size: 11px;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .pos-modal-cancel-btn:hover {
            background: #f1f5f9;
            color: #0f172a;
        }
        .dark .pos-modal-cancel-btn {
            background: #1e293b !important;
            border-color: #334155 !important;
            color: #cbd5e1 !important;
        }
        .dark .pos-modal-cancel-btn:hover {
            background: #334155 !important;
            color: #f8fafc !important;
        }

        /* Modal Inputs */
        .pos-modal-input {
            width: 100%;
            height: 38px;
            border-radius: 8px;
            border: 1.5px solid #cbd5e1;
            padding: 0 12px;
            font-size: 14px;
            font-weight: 800;
            font-family: monospace;
            background: #ffffff;
            color: #0f172a;
            outline: none;
            box-sizing: border-box;
            transition: border-color 0.15s ease;
        }
        .pos-modal-input:focus {
            border-color: #D4A437;
        }
        .dark .pos-modal-input {
            background: #0f172a !important;
            border-color: #334155 !important;
            color: #f8fafc !important;
        }
        .dark .pos-modal-input:focus {
            border-color: #D4A437 !important;
        }

        /* Payment Method Buttons */
        .pos-pay-method-btn {
            padding: 10px 6px;
            border-radius: 10px;
            border: 1.5px solid #cbd5e1;
            background: #ffffff;
            color: #334155;
            font-size: 10px;
            font-weight: 800;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
            transition: all 0.15s ease;
        }
        .dark .pos-pay-method-btn {
            background: #1e293b !important;
            border-color: #334155 !important;
            color: #e2e8f0 !important;
        }
        .pos-pay-method-btn:hover {
            border-color: #D4A437;
        }
        .pos-pay-method-btn.active {
            background: #D4A437 !important;
            border-color: #b8860b !important;
            color: #000000 !important;
            box-shadow: 0 2px 8px rgba(212, 164, 55, 0.4);
            transform: scale(1.02);
        }
        .pos-pay-method-btn.disabled {
            border-style: dashed;
            opacity: 0.6;
            cursor: not-allowed;
        }
        .dark .pos-pay-method-btn.disabled {
            background: #0f172a !important;
            border-color: #334155 !important;
            color: #64748b !important;
        }

        /* Drawer Change Return Badge */
        .pos-change-badge {
            text-align: right;
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            border-radius: 8px;
            padding: 6px 10px;
        }
        .dark .pos-change-badge {
            background: rgba(16, 185, 129, 0.15) !important;
            border-color: rgba(16, 185, 129, 0.4) !important;
        }

        /* Seating Floor Map Buttons */
        .pos-floor-table-btn {
            height: 54px;
            border-radius: 10px;
            border: 1.5px solid;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .pos-floor-table-btn.vacant {
            background: #ecfdf5;
            color: #065f46;
            border-color: #a7f3d0;
        }
        .dark .pos-floor-table-btn.vacant {
            background: rgba(16, 185, 129, 0.15) !important;
            color: #34d399 !important;
            border-color: rgba(16, 185, 129, 0.4) !important;
        }
        .pos-floor-table-btn.occupied {
            background: #fef2f2;
            color: #b91c1c;
            border-color: #fecaca;
        }
        .dark .pos-floor-table-btn.occupied {
            background: rgba(239, 68, 68, 0.15) !important;
            color: #f87171 !important;
            border-color: rgba(239, 68, 68, 0.4) !important;
        }
        .pos-floor-table-btn.selected {
            background: #D4A437 !important;
            color: #000000 !important;
            border-color: #b8860b !important;
            box-shadow: 0 4px 12px rgba(212, 164, 55, 0.4);
            font-weight: 900;
        }

        /* Delivery Address Box & Discount input */
        .pos-delivery-address-box {
            padding: 6px 10px;
            background: #fff5f5;
            border-bottom: 1px solid #fed7d7;
        }
        .dark .pos-delivery-address-box {
            background: rgba(127, 29, 29, 0.2) !important;
            border-color: rgba(185, 28, 28, 0.4) !important;
        }
        .pos-discount-input {
            width: 70px;
            height: 22px;
            text-align: right;
            border-radius: 4px;
            border: 1px solid #cbd5e1;
            font-family: monospace;
            font-size: 10px;
            padding: 0 4px;
            background: #ffffff;
            color: #0f172a;
        }
        .dark .pos-discount-input {
            background: #1e293b !important;
            border-color: #334155 !important;
            color: #f8fafc !important;
        }

        .compact-scroll::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }
        .compact-scroll::-webkit-scrollbar-thumb {
            background: rgba(212, 164, 55, 0.4);
            border-radius: 9999px;
        }
    </style>

    <div class="pos-terminal-wrapper">

        <!-- Offline Network Warning Banner -->
        <div x-data="{ isOffline: !navigator.onLine }" 
             x-init="
                window.addEventListener('offline', () => isOffline = true);
                window.addEventListener('online', () => isOffline = false);
             "
             x-show="isOffline"
             x-cloak
             style="background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%); color: #ffffff; padding: 8px 16px; border-radius: 12px; margin-bottom: 6px; display: flex; align-items: center; justify-content: space-between; font-size: 11.5px; font-weight: 800; border: 1.5px solid #f87171; box-shadow: 0 4px 12px rgba(185, 28, 28, 0.4); z-index: 9999;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 16px;">⚠️</span>
                <span>INTERNET DISCONNECTED: The online cloud portal requires active network. For 100% uninterrupted offline cashier billing, switch to the Standalone Offline POS Station!</span>
            </div>
            <a href="/downloads/Nawabi-Food-Corner-POS.html" target="_blank" style="background: #ffffff; color: #991b1b; padding: 5px 12px; border-radius: 8px; font-size: 11px; font-weight: 900; text-decoration: none; white-space: nowrap;">
                ⚡ OPEN OFFLINE STATION
            </a>
        </div>

        <!-- ========================================================================= -->
        <!-- TOP APPBAR: Cashier Brand + Live Clock + Shift Status + Actions           -->
        <!-- ========================================================================= -->
        <div class="pos-appbar">
            <!-- Left: Brand Logo & Clock -->
            <div class="pos-brand-badge">
                <div class="pos-brand-logo">
                    <img src="{{ asset('images/logo_circular.png') }}" alt="Nawabi Food Corner" class="pos-brand-logo-img" />
                </div>
                <div class="pos-brand-text">
                    <div class="pos-brand-title">
                        <span>NAWABI FOOD CORNER POS</span>
                        <span class="pos-brand-tag">TERMINAL 01</span>
                    </div>
                    <div class="pos-brand-meta">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span id="pos-live-clock">{{ date('h:i:s A') }}</span>
                        <span>•</span>
                        <span>{{ strtoupper(auth()->user()->role ?? 'CASHIER') }}</span>
                    </div>
                </div>
            </div>

            <!-- Center: Interactive Search Input with clear trigger (Compact & Constrained) -->
            <div class="pos-search-wrap">
                <span class="pos-search-icon">🔍</span>
                <input type="text" 
                       wire:model.live.debounce.300ms="search" 
                       placeholder="Search pizzas, platters, deals..." 
                       class="pos-search-input" />
                @if($search)
                    <button wire:click="$set('search', '')" class="pos-search-clear" title="Clear search">&times;</button>
                @endif
            </div>

            <!-- Right: Sync Status + Theme Mode Switcher + Notifications + Floor Map + Shift Status + Cashier Avatar Pop-up -->
            <div style="display: flex; align-items: center; gap: 7px; flex-shrink: 0;" x-data="{ cashierMenuOpen: false }">

                <!-- 0. POS Cloud Sync Status & Manual Trigger -->
                <button type="button" 
                        onclick="triggerManualCloudSync()"
                        id="pos-sync-badge"
                        class="pos-sync-badge online" 
                        title="Cloud Sync Engine: Click to force synchronization with Cloud Server">
                    <span id="pos-sync-dot" class="pos-sync-dot"></span>
                    <span id="pos-sync-text">ONLINE</span>
                </button>

                <!-- PWA 1-Click Install App (Windows / Mac) -->
                <button type="button" 
                        onclick="triggerPwaInstall()"
                        id="pwa-install-btn"
                        class="pos-install-app-btn" 
                        title="Install Nawabi POS as Desktop App on this PC/Mac (Works Offline)">
                    <span>📲</span>
                    <span class="hidden md:inline">INSTALL APP</span>
                </button>

                <!-- 1. Instant Light / Dark Theme Mode Toggle -->
                <button type="button" 
                        onclick="togglePOSTheme()"
                        class="pos-theme-toggle-btn" 
                        title="Toggle Light or Dark Interface Theme">
                    <span id="pos-theme-icon">🌙</span>
                    <span id="pos-theme-text" class="hidden sm:inline">THEME</span>
                </button>

                <!-- 2. Enlarged Kitchen & Staff Notification Button (Right next to Theme Mode Toggle) -->
                <div class="relative">
                    <button wire:click="$toggle('notificationsOpen')" 
                            type="button"
                            class="pos-notif-btn" 
                            title="View Kitchen & Staff Notifications">
                        <span style="font-size: 13px;">🔔</span>
                        <span class="hidden sm:inline">ALERTS</span>
                        @if(count($this->notifications) > 0)
                            <span class="pos-notif-count-badge">
                                {{ count($this->notifications) }}
                            </span>
                        @endif
                    </button>

                    @if($notificationsOpen)
                        <div class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-2xl z-50 p-4 flex flex-col gap-3">
                            <div class="flex justify-between items-center border-b border-gray-200 dark:border-gray-800 pb-2">
                                <span class="text-[10px] font-extrabold text-gray-800 dark:text-gray-200 uppercase tracking-wider font-mono">Kitchen & Staff Alerts</span>
                                <button wire:click="$set('notificationsOpen', false)" class="text-gray-400 hover:text-gray-200 font-bold">&times;</button>
                            </div>
                            <div class="flex flex-col gap-2 max-h-[260px] overflow-y-auto compact-scroll">
                                @if(count($this->notifications) === 0)
                                    <div class="py-6 text-center text-gray-400 text-[10px] font-semibold">
                                        👑 All orders up to date. No pending alerts.
                                    </div>
                                @else
                                    @foreach($this->notifications as $notif)
                                        <div class="bg-gray-50 dark:bg-gray-800 p-2.5 rounded-xl border border-gray-200 dark:border-gray-700 flex flex-col gap-1.5">
                                            <div class="flex justify-between items-start">
                                                <div class="min-w-0 flex-1">
                                                    <h5 class="text-[10px] font-extrabold text-gray-800 dark:text-gray-100 truncate">{{ $notif->title }}</h5>
                                                    <p class="text-[9px] text-gray-500 mt-0.5 leading-snug">{{ $notif->message }}</p>
                                                </div>
                                                <button wire:click="markNotificationAsRead({{ $notif->id }})" class="text-gray-400 hover:text-gray-200 text-xs font-bold shrink-0 ml-1">&times;</button>
                                            </div>
                                            <div class="flex justify-end gap-1 mt-1">
                                                @if($notif->type === 'online_order')
                                                    <button wire:click="sendKitchenKOT({{ $notif->id }}, {{ $notif->related_id }})" type="button" class="px-2 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded text-[9px] font-extrabold">
                                                        👨‍🍳 Send KOT
                                                    </button>
                                                @elseif($notif->type === 'bill_requested')
                                                    <button wire:click="openDirectSettlement({{ $notif->related_id }})" type="button" class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded text-[9.5px] font-extrabold flex items-center gap-1">
                                                        <span>💰</span> Settle Bill Now
                                                    </button>
                                                @elseif(in_array($notif->type, ['ready_for_pickup', 'ready_for_delivery']))
                                                    <button wire:click="openDirectSettlement({{ $notif->related_id }})" type="button" class="px-2 py-1 bg-amber-600 hover:bg-amber-700 text-white rounded text-[9px] font-extrabold">
                                                        📦 Settle / Dispatch
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- 3. Floor Map Quick Trigger -->
                <button wire:click="$set('seatingModalOpen', true)" 
                        type="button" 
                        class="pos-btn-floormap"
                        title="Open Seating Layout Occupancy Map">
                    <span>🛋️</span>
                    <span class="hidden md:inline">FLOOR MAP</span>
                </button>

                <!-- 3b. Direct Expense Ledger Quick Trigger -->
                <button wire:click="openExpenseModal" 
                        type="button" 
                        class="pos-btn-expense"
                        title="Record Daily Expense Voucher (Syncs directly to Royal Back-Office Expenses Ledger)">
                    <span>💸</span>
                    <span class="hidden sm:inline">EXPENSE</span>
                </button>

                <!-- 4. Shift Status Pill & Action Button -->
                @if($isShiftOpen)
                    <div class="hidden lg:flex items-center gap-1.5 pos-till-status-pill font-mono">
                        <span class="pos-till-pulse-dot"></span>
                        <span>TILL ACTIVE</span>
                        <span class="text-emerald-700 dark:text-emerald-300 font-bold">(Rs. {{ number_format($expectedCash) }})</span>
                    </div>
                    <button wire:click="openCloseShiftModal" 
                            type="button" 
                            class="pos-btn-shift-close"
                            title="Close shift and balance drawer cash">
                        <span>🔒</span>
                        <span>CLOSE SHIFT</span>
                    </button>
                @else
                    <button wire:click="openNewShiftModal" 
                            type="button" 
                            class="pos-btn-shift-open"
                            title="Open cashier register and start shift">
                        <span>🟢</span>
                        <span>OPEN SHIFT</span>
                    </button>
                @endif

                <!-- 5. Cashier Profile Avatar Pop-up (No Door Icon) -->
                <div class="relative">
                    <button type="button" 
                            @click="cashierMenuOpen = !cashierMenuOpen"
                            class="pos-cashier-trigger-btn"
                            title="Cashier Profile & System Actions">
                        {{ strtoupper(substr(auth()->user()->name ?? 'CA', 0, 2)) }}
                    </button>

                    <!-- Dropdown Modal Popup -->
                    <div x-show="cashierMenuOpen" 
                         @click.outside="cashierMenuOpen = false" 
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="pos-cashier-popup"
                         style="display: none;">
                        <div class="pos-cashier-popup-header">
                            <div class="pos-cashier-popup-avatar">
                                {{ strtoupper(substr(auth()->user()->name ?? 'CA', 0, 2)) }}
                            </div>
                            <div class="pos-cashier-popup-info">
                                <span class="pos-cashier-popup-name">{{ auth()->user()->name ?? 'Cashier User' }}</span>
                                <span class="pos-cashier-popup-role">{{ strtoupper(auth()->user()->role ?? 'CASHIER') }} • TERMINAL 01</span>
                                <span class="pos-cashier-popup-email">{{ auth()->user()->email ?? 'cashier@nawabidera.com' }}</span>
                            </div>
                        </div>

                        <div style="border-top: 1px solid #e2e8f0; margin: 2px 0;" class="dark:border-gray-800"></div>

                        <form action="{{ route('filament.pos.auth.logout') }}" method="POST" class="m-0 p-0">
                            @csrf
                            <button type="submit" class="pos-cashier-logout-btn">
                                <span>🚪</span>
                                <span>LOGOUT / EXIT POS</span>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- MAIN SPA LAYOUT: Left Menu Grid (Flex-1) + Right Cart Sidebar (380px)     -->
        <!-- ========================================================================= -->
        <div class="pos-main-body">

            <!-- ======================= LEFT: MENU PANEL ============================ -->
            <div class="pos-menu-panel">

                @if(!$isShiftOpen)
                    <!-- Till Sealed Cover Banner -->
                    <div class="h-full flex flex-col items-center justify-center text-center p-8 text-gray-400">
                        <span style="font-size: 48px; margin-bottom: 8px;">🔒</span>
                        <h3 class="text-sm font-extrabold text-gray-800 dark:text-gray-200 uppercase tracking-wider">POS Register Sealed</h3>
                        <p class="text-xs text-gray-500 max-w-sm mt-1">Please enter your starting cash drawer float in the top header or click <b>OPEN SHIFT</b> to begin taking guest orders.</p>
                        <button wire:click="openNewShiftModal" type="button" class="mt-4 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition-all cursor-pointer">
                            🟢 Open Cashier Register
                        </button>
                    </div>
                @else
                    <!-- 1. Category Dock Navigation -->
                    <div class="pos-cat-dock compact-scroll">
                        <button wire:click="selectCategory(null)" 
                                type="button"
                                class="pos-cat-btn {{ is_null($selectedCategoryId) ? 'active' : '' }}">
                            <span>✨</span>
                            <span>ALL DISHES</span>
                        </button>
                        @foreach($this->categories as $cat)
                            <button wire:click="selectCategory({{ $cat->id }})" 
                                    type="button"
                                    class="pos-cat-btn {{ $selectedCategoryId === $cat->id ? 'active' : '' }}">
                                <span>{{ strtoupper($cat->name) }}</span>
                            </button>
                        @endforeach
                    </div>

                    <!-- 2. Interactive Food Cards Grid -->
                    <div class="pos-food-grid compact-scroll">
                        @if(count($this->menuItems) === 0)
                            <div class="col-span-full py-16 flex flex-col items-center justify-center text-center text-gray-400">
                                <span style="font-size: 40px;">🍽️</span>
                                <h4 class="text-xs font-bold mt-2">No menu items found</h4>
                                <p class="text-[10px] text-gray-500">Try adjusting your category selection or clear search filters.</p>
                            </div>
                        @else
                            @foreach($this->menuItems as $dish)
                                <div class="pos-food-card">
                                    <div style="display: flex; flex-direction: column; gap: 6px; flex: 1;">
                                        <!-- Header: Dish Name & Badges & Generic/Custom Photo Thumbnail -->
                                        <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 8px;">
                                            <div style="display: flex; flex-direction: column; gap: 3px; flex: 1; min-width: 0;">
                                                <div style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                                                    <h4 class="pos-food-title" title="{{ $dish->name }}">
                                                        {{ $dish->name }}
                                                    </h4>
                                                    @if($dish->is_hero_item)
                                                        <span class="pos-card-badge gold">⭐ SPECIAL</span>
                                                    @elseif((isset($dish->details['deal_items']) && count($dish->details['deal_items']) > 0) || str_contains(strtolower($dish->name), 'deal'))
                                                        <span class="pos-card-badge red">🎁 COMBO</span>
                                                    @elseif(str_contains(strtolower($dish->name), 'platter'))
                                                        <span class="pos-card-badge green">🍱 PLATTER</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <img src="{{ $dish->resolved_image }}" alt="{{ $dish->name }}" class="pos-food-thumb" loading="lazy" />
                                        </div>

                                        <!-- Deal Contents & Ingredients Box -->
                                        @if(!empty($dish->description))
                                            <div class="pos-dish-desc-box" title="{{ $dish->description }}">
                                                <span class="pos-desc-tag">📦 Includes:</span>
                                                <span>{{ $dish->description }}</span>
                                            </div>
                                        @elseif(isset($dish->details['deal_items']) && is_array($dish->details['deal_items']) && count($dish->details['deal_items']) > 0)
                                            <div class="pos-dish-desc-box" title="{{ implode(', ', $dish->details['deal_items']) }}">
                                                <span class="pos-desc-tag">📦 Includes:</span>
                                                <span>{{ implode(' • ', $dish->details['deal_items']) }}</span>
                                            </div>
                                        @endif

                                        <!-- Portion Size Mini Pills -->
                                        @if(isset($dish->details['sizes']) && is_array($dish->details['sizes']) && count($dish->details['sizes']) > 0)
                                            <div class="pos-sizes-pills-row">
                                                @foreach($dish->details['sizes'] as $sKey => $sVal)
                                                    <span class="pos-size-mini-pill">
                                                        {{ strtoupper($sKey) }}: Rs. {{ number_format(is_array($sVal) ? ($sVal['price'] ?? 0) : $sVal) }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Bottom Row: Price & Tactile Action Button (Always 100% Visible) -->
                                    <div class="pos-food-bottom-row">
                                        <div>
                                            @if(isset($dish->details['sizes']) && is_array($dish->details['sizes']) && count($dish->details['sizes']) > 0)
                                                <span style="font-size: 8.5px; font-weight: 800; color: #94a3b8; text-transform: uppercase; display: block; line-height: 1;">Starting From</span>
                                                <span class="pos-food-price">
                                                    Rs. {{ number_format($dish->price) }}
                                                </span>
                                            @else
                                                <span class="pos-food-price">
                                                    Rs. {{ number_format($dish->price) }}
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Add to Cart or Select Portion Trigger -->
                                        @if(isset($dish->details['sizes']) && is_array($dish->details['sizes']) && count($dish->details['sizes']) > 0)
                                            <button wire:click="openPortionModal({{ $dish->id }})" 
                                                    type="button" 
                                                    class="pos-sizes-item-btn" 
                                                    title="Select Portion Size">
                                                <span>📐</span>
                                                <span>SIZES</span>
                                            </button>
                                        @else
                                            <button wire:click="addToCart({{ $dish->id }})" 
                                                    type="button" 
                                                    class="pos-add-item-btn" 
                                                    title="Add to Ticket">
                                                <span>+</span>
                                                <span>ADD</span>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    @if($this->menuTotalPages > 1)
                        <div class="pos-pagination-dock">
                            <button wire:click="$set('menuPage', {{ max(1, $menuPage - 1) }})" @if($menuPage === 1) disabled @endif class="pos-page-btn">◀ Prev</button>
                            @for($p = 1; $p <= $this->menuTotalPages; $p++)
                                <button wire:click="$set('menuPage', {{ $p }})" class="pos-page-btn {{ $menuPage === $p ? 'active' : '' }}">{{ $p }}</button>
                            @endfor
                            <button wire:click="$set('menuPage', {{ min($this->menuTotalPages, $menuPage + 1) }})" @if($menuPage === $this->menuTotalPages) disabled @endif class="pos-page-btn">Next ▶</button>
                        </div>
                    @endif
                @endif

            </div>

            <!-- ======================= RIGHT: CART SIDEBAR ========================= -->
            <div class="pos-cart-panel">

                <!-- 1. Order Type Segmented Control -->
                <div class="pos-mode-dock" x-data="{ currentMode: @entangle('orderType').live }">
                    <button wire:key="pos-mode-btn-dine_in"
                            @click="currentMode = 'dine_in'"
                            wire:click="selectOrderSetupType('dine_in')" 
                            type="button" 
                            :class="currentMode === 'dine_in' ? 'pos-mode-btn active' : 'pos-mode-btn'"
                            class="pos-mode-btn {{ $orderType === 'dine_in' ? 'active' : '' }}">
                        <span>🍽️</span>
                        <span>Dine-In</span>
                    </button>
                    <button wire:key="pos-mode-btn-takeaway"
                            @click="currentMode = 'takeaway'"
                            wire:click="selectOrderSetupType('takeaway')" 
                            type="button" 
                            :class="currentMode === 'takeaway' ? 'pos-mode-btn active' : 'pos-mode-btn'"
                            class="pos-mode-btn {{ $orderType === 'takeaway' ? 'active' : '' }}">
                        <span>🥡</span>
                        <span>Takeaway</span>
                    </button>
                    <button wire:key="pos-mode-btn-delivery"
                            @click="currentMode = 'delivery'"
                            wire:click="selectOrderSetupType('delivery')" 
                            type="button" 
                            :class="currentMode === 'delivery' ? 'pos-mode-btn active' : 'pos-mode-btn'"
                            class="pos-mode-btn {{ $orderType === 'delivery' ? 'active' : '' }}">
                        <span>🛵</span>
                        <span>Delivery</span>
                    </button>
                </div>

                <!-- 2. Table Selection Pill (Dine-In only) -->
                @if($orderType === 'dine_in')
                    <div class="pos-table-strip">
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span>🪑 Table Status:</span>
                            @if($selectedTable)
                                <span style="background: #D7262E; color: #fff; padding: 1px 6px; border-radius: 4px; font-weight: 800; font-family: monospace;">
                                    TABLE {{ $selectedTable }}
                                </span>
                            @else
                                <span style="color: #64748b; font-style: italic;">Not Assigned</span>
                            @endif
                        </div>
                        <button wire:click="$set('seatingModalOpen', true)" type="button" style="background: none; border: none; font-size: 10px; font-weight: 800; color: #b45309; text-decoration: underline; cursor: pointer;">
                            {{ $selectedTable ? 'Change Table' : 'Assign Table ➔' }}
                        </button>
                    </div>
                @endif

                <!-- 3. Customer Info Input Strip -->
                <div class="pos-guest-strip">
                    <input type="text" wire:model.live="customerPhone" placeholder="📱 Phone 03XXXXXXXXX" class="pos-guest-input" />
                    <input type="text" wire:model.live="customerName" placeholder="👤 Guest Name" class="pos-guest-input" />
                </div>
                @if($orderType === 'delivery')
                    <div class="pos-delivery-address-box" style="padding: 4px 8px;">
                        <textarea wire:model.live="customerAddress" rows="2" placeholder="📍 House, Street, Area Address (Required for Delivery)..." class="pos-guest-input" style="height: auto; min-height: 52px; padding: 6px 10px; resize: none;"></textarea>
                        @error('customerAddress') <span style="font-size: 10px; color: #dc2626; font-weight: bold;">{{ $message }}</span> @enderror
                        <div style="display: flex; align-items: center; gap: 6px; margin-top: 4px;">
                            <span style="font-size: 10.5px; font-weight: 800; color: #4f46e5; white-space: nowrap;">🛵 Rider:</span>
                            <input 
                                type="text" 
                                wire:model.live="riderName" 
                                placeholder="Delivery Rider Name (Optional)..." 
                                class="pos-guest-input" 
                                style="height: 28px; font-size: 10.5px; padding: 2px 8px;" 
                                list="staff-riders-datalist" 
                            />
                            <datalist id="staff-riders-datalist">
                                @foreach(\App\Models\StaffMember::where('role_designation', 'rider')->get() as $rider)
                                    <option value="{{ $rider->full_name }}">{{ $rider->full_name }}</option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>
                @endif

                <!-- 4. Cart Items Scroll List -->
                <div class="pos-cart-items-list compact-scroll">
                    @if(!$isShiftOpen)
                        <div class="pos-cart-empty-box">
                            <span style="font-size: 24px;">🔒</span>
                            <p class="text-[11px] font-extrabold mt-1 text-gray-700 dark:text-gray-300">Register is Closed</p>
                        </div>
                    @elseif(count($cart) === 0)
                        <div class="pos-cart-empty-box">
                            <span style="font-size: 26px;">🛒</span>
                            <p class="text-[11px] font-extrabold mt-1 text-gray-700 dark:text-gray-300">Cart is Empty</p>
                            <p class="text-[9px] text-gray-400 mt-0.5">Click dishes from the menu to add items.</p>
                        </div>
                    @else
                        @foreach($cart as $cartKey => $cItem)
                            <div class="pos-cart-item-card">
                                <div class="pos-cart-item-top">
                                    <div class="pos-cart-item-title">
                                        {{ $cItem['name'] }}
                                        <div style="font-size: 9px; font-weight: 700; color: #D4A437; font-family: monospace;">
                                            Rs. {{ number_format($cItem['price']) }} each
                                        </div>
                                    </div>
                                    <div class="pos-cart-item-total">
                                        Rs. {{ number_format($cItem['price'] * $cItem['quantity']) }}
                                    </div>
                                </div>

                                <div class="pos-cart-item-controls">
                                    <input type="text" 
                                           value="{{ $cItem['comment'] }}" 
                                           placeholder="Notes (e.g. spicy, less oil)..."
                                           wire:blur="updateItemComment('{{ $cartKey }}', $event.target.value)" 
                                           class="pos-cart-comment-input" />
                                    
                                    <div style="display: flex; align-items: center; gap: 3px;">
                                        <button wire:click="updateQuantity('{{ $cartKey }}', {{ $cItem['quantity'] - 1 }})" class="pos-stepper-btn">−</button>
                                        <span style="width: 20px; text-align: center; font-size: 11px; font-weight: 900; font-family: monospace;">{{ $cItem['quantity'] }}</span>
                                        <button wire:click="updateQuantity('{{ $cartKey }}', {{ $cItem['quantity'] + 1 }})" class="pos-stepper-btn">+</button>
                                        <button wire:click="removeFromCart('{{ $cartKey }}')" class="pos-delete-item-btn" title="Remove Item">🗑️</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- 5. Financial Summary Breakdown -->
                <div class="pos-financial-ticket">
                    <div class="pos-financial-row">
                        <span>Items Subtotal:</span>
                        <span class="pos-financial-val">Rs. {{ number_format($subtotal, 2) }}</span>
                    </div>

                    @if($isServiceFeeEnabled && $orderType === 'dine_in')
                        <div class="pos-financial-row" style="color: #d97706;" class="dark:text-amber-400">
                            <span>Service Fee ({{ $serviceFeeRate }}%):</span>
                            <span class="pos-financial-val" style="color: #d97706;">+ Rs. {{ number_format($serviceCharge, 2) }}</span>
                        </div>
                    @endif

                    @if($isVatEnabled)
                        <div class="pos-financial-row" style="color: #059669;" class="dark:text-emerald-400">
                            <span>{{ $vatLabel ?: "VAT / GST ({$taxRate}%)" }}:</span>
                            <span class="pos-financial-val" style="color: #059669;">+ Rs. {{ number_format($taxAmount, 2) }}</span>
                        </div>
                    @endif

                    <div class="pos-financial-row">
                        <span>Royal Discount (Rs.):</span>
                        <input type="number" wire:model.live="discountAmount" placeholder="0" class="pos-discount-input" />
                    </div>

                    <!-- Grand Total Box -->
                    <div class="pos-total-box">
                        <span class="pos-total-label">Total Receivable</span>
                        <span class="pos-total-val">Rs. {{ number_format($total, 2) }}</span>
                    </div>
                </div>

                <!-- 6. Cart Action Buttons (Pronounced, High-Contrast Utilities) -->
                <div class="pos-cart-actions">
                    <div class="pos-util-grid">
                        <button wire:click="placeOrder" 
                                @if(count($cart) === 0) disabled @endif 
                                class="pos-btn-kot"
                                title="Send order items to kitchen (KOT)">
                            <span>👨‍🍳</span>
                            <span>{{ $activeOrderId ? 'Update KOT' : 'Generate KOT' }}</span>
                        </button>
                        <button wire:click="holdOrder" 
                                @if(count($cart) === 0) disabled @endif 
                                class="pos-btn-hold"
                                title="Hold / Park this order to attend to next customer">
                            <span>⏸️</span>
                            <span>Hold Order</span>
                        </button>
                        <button wire:click="printBill" 
                                @if(count($cart) === 0 && !$activeOrderId) disabled @endif 
                                class="pos-btn-print"
                                title="Print thermal customer invoice">
                            <span>🖨️</span>
                            <span>Print Bill</span>
                        </button>
                        <button wire:click="resetPOSCart" 
                                class="pos-btn-clear"
                                title="Discard all items in cart">
                            <span>🗑️</span>
                            <span>Clear Cart</span>
                        </button>
                    </div>

                    <!-- Master Settle Payment CTA (Radiant Nawabi Gold Gradient) -->
                    <button wire:click="proceedToPayment" 
                            @if(count($cart) === 0) disabled @endif 
                            class="pos-settle-cta-btn">
                        <span style="font-size: 17px;">💰</span>
                        <span>SETTLE BILL PAYMENTS</span>
                    </button>

                    <!-- Bottom Quick Monitors (Ongoing, Kitchen Queue & Direct Expense Voucher) -->
                    <div class="pos-monitor-strip">
                        <button wire:click="openOngoingOrdersModal" type="button" class="pos-monitor-btn ongoing" title="View all running ongoing guest orders">
                            <span>📋 Active</span>
                            <span class="pos-monitor-badge">{{ \App\Models\Order::where('status', '!=', 'completed')->count() }}</span>
                        </button>
                        <button wire:click="openKitchenStatusModal" type="button" class="pos-monitor-btn kitchen" title="View live orders being cooked in kitchen">
                            <span>🍳 Kitchen</span>
                            <span class="pos-monitor-badge">{{ \App\Models\Order::where('status', 'preparing')->count() }}</span>
                        </button>
                        <button wire:click="openExpenseModal" type="button" class="pos-monitor-btn expense" title="Record expense voucher paid-out directly to Royal Back-Office Expenses Ledger">
                            <span>💸</span>
                            <span>Expense</span>
                        </button>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- ========================================================================= -->
    <!-- INTERACTIVE DIALOG MODALS                                                 -->
    <!-- ========================================================================= -->

    <!-- 1. FLOOR SEATING OCCUPANCY MAP MODAL -->
    @if($seatingModalOpen)
        <div class="pos-overlay-backdrop" wire:click.self="$set('seatingModalOpen', false)">
            <div class="pos-modal-card" style="width: 100%; max-width: 800px;">
                <div class="pos-modal-header">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="font-size: 20px;">🛋️</span>
                        <h3 class="pos-modal-title">Royal Seating Layout Occupancy Map</h3>
                    </div>
                    <button wire:click="$set('seatingModalOpen', false)" class="pos-modal-close-btn">&times;</button>
                </div>

                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 16px;">
                    <div>
                        <div style="font-size: 10px; font-weight: 800; color: #64748b; margin-bottom: 8px; text-transform: uppercase;" class="dark:text-gray-400">Select Floor Table (T1 - T16)</div>
                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px;">
                            @foreach($this->tables as $table)
                                <button wire:click="inspectTableOrder('{{ $table['id'] }}')" 
                                        type="button"
                                        class="pos-floor-table-btn {{ $inspectedTableId === $table['id'] ? 'selected' : ($table['status'] === 'occupied' ? 'occupied' : 'vacant') }}">
                                    <span style="font-size: 12px; font-weight: 900; font-family: monospace;">{{ $table['id'] }}</span>
                                    <span style="font-size: 8px; opacity: 0.85;">{{ $table['capacity'] }} Pax</span>
                                </button>
                            @endforeach
                        </div>

                        <!-- Legend -->
                        <div style="display: flex; align-items: center; gap: 12px; margin-top: 12px; font-size: 9px; font-weight: 800;" class="text-gray-600 dark:text-gray-300">
                            <span style="display: flex; align-items: center; gap: 4px;"><span style="width: 10px; height: 10px; border-radius: 2px;" class="bg-emerald-100 border border-emerald-500 dark:bg-emerald-950 dark:border-emerald-500"></span> VACANT</span>
                            <span style="display: flex; align-items: center; gap: 4px;"><span style="width: 10px; height: 10px; border-radius: 2px;" class="bg-red-100 border border-red-500 dark:bg-red-950 dark:border-red-500"></span> OCCUPIED</span>
                            <span style="display: flex; align-items: center; gap: 4px;"><span style="width: 10px; height: 10px; background: #D4A437; border: 1px solid #b8860b; border-radius: 2px;"></span> SELECTED</span>
                        </div>
                    </div>

                    <!-- Right Inspector -->
                    <div class="pos-modal-box" style="display: flex; flex-direction: column; justify-content: space-between;">
                        @if(is_null($inspectedTableId))
                            <div style="text-align: center; color: #94a3b8; padding: 20px 0;">
                                <span style="font-size: 28px;">👈</span>
                                <p style="font-size: 11px; font-weight: 700; margin-top: 4px;">Click a table card</p>
                            </div>
                        @else
                            <div>
                                <h4 style="font-size: 11px; font-weight: 900; font-family: monospace;">TABLE {{ $inspectedTableId }}</h4>
                                <div style="font-size: 10px; font-weight: 800; margin-top: 4px; color: {{ $inspectedTableOrder ? '#D7262E' : '#10b981' }};">
                                    {{ $inspectedTableOrder ? '● OCCUPIED (Order active)' : '○ VACANT TABLE' }}
                                </div>

                                @if($inspectedTableOrder)
                                    <div style="margin-top: 10px; display: flex; flex-direction: column; gap: 4px; font-size: 10px; font-family: monospace;">
                                        @foreach($inspectedTableOrder->items as $oItem)
                                            <div style="display: flex; justify-content: space-between;">
                                                <span>{{ $oItem->menuItem->name ?? 'Dish' }}</span>
                                                <span>x{{ $oItem->quantity }}</span>
                                            </div>
                                        @endforeach
                                        <div style="border-top: 1px solid #e2e8f0; padding-top: 4px; margin-top: 4px; font-weight: 900; color: #10b981; display: flex; justify-content: space-between;" class="dark:border-gray-700">
                                            <span>Current Bill:</span>
                                            <span>Rs. {{ number_format($inspectedTableOrder->total) }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div style="margin-top: 12px; display: flex; flex-direction: column; gap: 6px;">
                                @if($inspectedTableOrder)
                                    <button wire:click="loadTableIntoCart" type="button" style="width: 100%; padding: 8px; border-radius: 8px; border: none; background: #D4A437; color: #000; font-weight: 900; font-size: 11px; cursor: pointer;">
                                        📥 Pull to Cart
                                    </button>
                                @else
                                    <button wire:click="loadTableOrder('{{ $inspectedTableId }}')" type="button" style="width: 100%; padding: 8px; border-radius: 8px; border: none; background: #10b981; color: #fff; font-weight: 900; font-size: 11px; cursor: pointer;">
                                        ➕ Seat & Start Order
                                    </button>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- 2. PAYMENT SETTLEMENT MODAL (Checkout Experience) -->
    @if($isPaymentModalOpen)
        <div class="pos-overlay-backdrop" wire:click.self="$set('isPaymentModalOpen', false)">
            <div class="pos-modal-card" style="width: 100%; max-width: 780px;">
                <!-- Header -->
                <div class="pos-modal-header">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="font-size: 22px;">💰</span>
                        <div>
                            <h3 class="pos-modal-title">Settle Payment & Invoice</h3>
                            <p style="font-size: 10px; color: #64748b;" class="dark:text-gray-400">Select the payment method and enter cash received for automatic change calculation.</p>
                        </div>
                    </div>
                    <button wire:click="$set('isPaymentModalOpen', false)" class="pos-modal-close-btn">&times;</button>
                </div>

                <div style="display: grid; grid-template-columns: 240px 1fr; gap: 18px;">
                    <!-- Left: Invoice Breakdown Card -->
                    <div class="pos-modal-box" style="display: flex; flex-direction: column; justify-content: space-between;">
                        <div style="display: flex; flex-direction: column; gap: 8px; font-size: 11px;">
                            <div style="font-size: 10px; font-family: monospace; font-weight: 800; color: #64748b; border-bottom: 1px solid #e2e8f0; padding-bottom: 4px;" class="dark:text-gray-400 dark:border-gray-700">
                                INVOICE REF: {{ $activeOrderNumber ?? 'NEW ORDER' }}
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span>Subtotal:</span>
                                <span style="font-family: monospace; font-weight: 700;">Rs. {{ number_format($subtotal, 2) }}</span>
                            </div>
                            @if($isServiceFeeEnabled && $orderType === 'dine_in')
                                <div style="display: flex; justify-content: space-between; color: #d97706;" class="dark:text-amber-400">
                                    <span>Service ({{ $serviceFeeRate }}%):</span>
                                    <span style="font-family: monospace; font-weight: 700;">Rs. {{ number_format($serviceCharge, 2) }}</span>
                                </div>
                            @endif
                            @if($isVatEnabled)
                                <div style="display: flex; justify-content: space-between; color: #059669;" class="dark:text-emerald-400">
                                    <span>{{ $vatLabel ?: "VAT / GST ({$taxRate}%)" }}:</span>
                                    <span style="font-family: monospace; font-weight: 700;">Rs. {{ number_format($taxAmount, 2) }}</span>
                                </div>
                            @endif
                            @if($discountAmount > 0)
                                <div style="display: flex; justify-content: space-between; color: #dc2626;" class="dark:text-red-400">
                                    <span>Discount:</span>
                                    <span style="font-family: monospace; font-weight: 700;">- Rs. {{ number_format($discountAmount, 2) }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Due Amount Badge -->
                        <div style="background: #0f172a; border: 1.5px solid #D4A437; border-radius: 10px; padding: 10px; text-align: center; color: #fff; margin-top: 12px;">
                            <span style="font-size: 9px; font-weight: 800; color: #D4A437; text-transform: uppercase; letter-spacing: 0.05em; display: block;">NET AMOUNT DUE</span>
                            <span style="font-size: 20px; font-weight: 900; color: #10b981; font-family: monospace; display: block; margin-top: 2px;">
                                Rs. {{ number_format($total, 2) }}
                            </span>
                        </div>
                    </div>

                    <!-- Right: Payment Method Selector & Cash Calculator -->
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <span style="font-size: 10px; font-weight: 800; color: #64748b; text-transform: uppercase;" class="dark:text-gray-400">Select Payment Method</span>
                        
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px;">
                            @foreach([
                                'cash' => ['icon' => '💵', 'label' => 'Cash Settle'],
                                'card' => ['icon' => '💳', 'label' => ($cardTerminalName ?: 'Bank POS / Cards')],
                                'easypaisa' => ['icon' => '📱', 'label' => 'EasyPaisa'],
                                'jazzcash' => ['icon' => '📱', 'label' => 'JazzCash'],
                                'bank' => ['icon' => '🏢', 'label' => 'Direct Bank'],
                            ] as $mKey => $mVal)
                                @if($mKey === 'card' && !$isCardEnabled)
                                    <button type="button" disabled title="Card payments disabled in Back Office settings"
                                            class="pos-pay-method-btn disabled">
                                        <span>🚫</span>
                                        <span>Card (Disabled)</span>
                                    </button>
                                @else
                                    <button type="button" wire:click="selectPaymentMode('{{ $mKey }}')" 
                                            class="pos-pay-method-btn {{ $paymentMethod === $mKey ? 'active' : '' }}">
                                        <span style="font-size: 14px;">{{ $mVal['icon'] }}</span>
                                        <span>{{ $mVal['label'] }}</span>
                                    </button>
                                @endif
                            @endforeach
                        </div>

                        <!-- Cash Calculator (if cash selected) -->
                        @if($paymentMethod === 'cash')
                            <div class="pos-modal-box" style="display: flex; flex-direction: column; gap: 8px;">
                                <div style="display: flex; align-items: center; justify-content: space-between;">
                                    <span style="font-size: 10px; font-weight: 800; color: #64748b; text-transform: uppercase;" class="dark:text-gray-400">Quick Cash Stepper</span>
                                    <div style="display: flex; gap: 4px;">
                                        <button wire:click="setQuickCash({{ $total }})" type="button" class="pos-chip-btn">EXACT</button>
                                        <button wire:click="setQuickCash(500)" type="button" class="pos-chip-btn">Rs 500</button>
                                        <button wire:click="setQuickCash(1000)" type="button" class="pos-chip-btn">Rs 1,000</button>
                                        <button wire:click="setQuickCash(2000)" type="button" class="pos-chip-btn">Rs 2,000</button>
                                        <button wire:click="setQuickCash(5000)" type="button" class="pos-chip-btn">Rs 5,000</button>
                                    </div>
                                </div>

                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; align-items: center;">
                                    <div>
                                        <label style="font-size: 9px; font-weight: 800; color: #64748b; text-transform: uppercase; display: block; margin-bottom: 2px;" class="dark:text-gray-400">CASH RECEIVED (Rs.)</label>
                                        <input type="number" wire:model.live="cashReceived" placeholder="0" 
                                               class="pos-modal-input" style="height: 36px;" />
                                    </div>
                                    <div class="pos-change-badge">
                                        <span style="font-size: 8px; font-weight: 800; color: #065f46; text-transform: uppercase; display: block;" class="dark:text-emerald-300">DRAWER CHANGE RETURN</span>
                                        <span style="font-size: 16px; font-weight: 900; color: #059669; font-family: monospace; display: block; margin-top: 1px;" class="dark:text-emerald-400">
                                            Rs. {{ number_format($changeAmount, 2) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="pos-modal-box">
                                <label style="font-size: 9px; font-weight: 800; color: #64748b; text-transform: uppercase; display: block; margin-bottom: 2px;" class="dark:text-gray-400">TRANSACTION TRACE / AUTH ID</label>
                                <input type="text" wire:model.live="transactionRef" placeholder="e.g. TXN-9482756 or Approval Code..." 
                                       class="pos-modal-input" style="height: 36px; font-size: 11px;" />
                            </div>
                        @endif

                        <!-- Conclude Action Button -->
                        <div style="display: flex; gap: 8px; margin-top: 6px;">
                            <button wire:click="$set('isPaymentModalOpen', false)" type="button" 
                                    class="pos-modal-cancel-btn" style="width: 30%;">
                                CANCEL
                            </button>
                            <button wire:click="confirmPayment" 
                                    type="button"
                                    @if($paymentMethod === 'cash' && $cashReceived < $total) disabled @endif 
                                    style="flex: 1; padding: 10px; border-radius: 10px; border: none; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #fff; font-size: 11px; font-weight: 900; text-transform: uppercase; cursor: pointer; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35);">
                                💰 CONCLUDE & SEAL TRANSACTION
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- 3. SHIFT REGISTER MANAGEMENT & RECONCILIATION MODAL -->
    @if($isShiftModalOpen)
        <div class="pos-overlay-backdrop" wire:click.self="$set('isShiftModalOpen', false)">
            <div class="pos-modal-card" style="width: 100%; max-width: 680px; max-height: 90vh; overflow-y: auto;">
                <div class="pos-modal-header">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="font-size: 22px;">{{ $isShiftOpen ? '🔒' : '🟢' }}</span>
                        <div>
                            <h3 class="pos-modal-title">
                                {{ $isShiftOpen ? 'Close Cashier Shift & Balance Till' : 'Open Cashier Shift Register' }}
                            </h3>
                            <p style="font-size: 11px; color: #64748b;" class="dark:text-gray-400">
                                {{ $isShiftOpen ? 'Review day sales, payment channels, change given & print official Z-Report.' : 'Enter starting float to initialize the cash drawer and start taking orders.' }}
                            </p>
                        </div>
                    </div>
                    <button wire:click="cancelShiftModal" class="pos-modal-close-btn">&times;</button>
                </div>

                @if($isShiftOpen)
                    <!-- A. TOP CORE METRICS (4 CARDS) -->
                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; text-align: center;">
                        <div class="pos-modal-row" style="padding: 8px;">
                            <span style="font-size: 8.5px; font-weight: 800; color: #64748b; text-transform: uppercase;" class="dark:text-gray-400">Starting Float</span>
                            <span style="font-size: 13px; font-weight: 900; font-family: monospace; display: block; margin-top: 2px;">Rs. {{ number_format($openingCash) }}</span>
                            <span style="font-size: 8px; color: #94a3b8;">Opening Cash</span>
                        </div>
                        <div class="pos-modal-row" style="padding: 8px;">
                            <span style="font-size: 8.5px; font-weight: 800; color: #64748b; text-transform: uppercase;" class="dark:text-gray-400">Actual Gross Sales</span>
                            <span style="font-size: 13px; font-weight: 900; font-family: monospace; color: #D4A437; display: block; margin-top: 2px;">Rs. {{ number_format($shiftTotalSales) }}</span>
                            <span style="font-size: 8px; color: #94a3b8;">{{ $shiftTotalOrdersCount }} orders</span>
                        </div>
                        <div class="pos-modal-row" style="padding: 8px; background: #fef2f2; border-color: #fecaca;" class="dark:bg-red-950/40 dark:border-red-800">
                            <span style="font-size: 8.5px; font-weight: 800; color: #dc2626; text-transform: uppercase;" class="dark:text-red-300">Paid-Out Expenses</span>
                            <span style="font-size: 13px; font-weight: 900; font-family: monospace; color: #dc2626; display: block; margin-top: 2px;">-Rs. {{ number_format($shiftExpensesTotal) }}</span>
                            <span style="font-size: 8px; color: #ef4444;">{{ count($shiftExpensesList) }} vouchers</span>
                        </div>
                        <div class="pos-modal-row" style="padding: 8px; background: #ecfdf5; border-color: #a7f3d0;" class="dark:bg-emerald-950/40 dark:border-emerald-800">
                            <span style="font-size: 8.5px; font-weight: 800; color: #047857; text-transform: uppercase;" class="dark:text-emerald-300">Expected in Till</span>
                            <span style="font-size: 13px; font-weight: 900; font-family: monospace; color: #059669; display: block; margin-top: 2px;" class="dark:text-emerald-400">Rs. {{ number_format($expectedCash) }}</span>
                            <span style="font-size: 8px; color: #10b981;">Physical Cash Target</span>
                        </div>
                    </div>

                    <!-- B. PAYMENT METHODS SUMMARY (CASH, BANK, JAZZCASH, EASYPAISA) -->
                    <div style="border: 1px solid #e2e8f0; border-radius: 12px; padding: 10px;" class="dark:border-gray-800 bg-gray-50/50 dark:bg-gray-900/40">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px; border-bottom: 1px solid #e2e8f0; padding-bottom: 4px;" class="dark:border-gray-800">
                            <span style="font-size: 10.5px; font-weight: 800; text-transform: uppercase; color: #0f172a; letter-spacing: 0.5px;" class="dark:text-gray-200">
                                💳 Payment Methods Breakdown
                            </span>
                            <span style="font-size: 9.5px; color: #64748b;" class="dark:text-gray-400">Audited Collections</span>
                        </div>

                        <!-- 1. Cash Breakdown Card (With Tendered & Change Given) -->
                        <div style="background: #ffffff; border: 1.5px solid #cbd5e1; border-radius: 10px; padding: 8px 12px; margin-bottom: 8px;" class="dark:bg-gray-800 dark:border-gray-700">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    <span style="font-size: 16px;">💵</span>
                                    <div>
                                        <span style="font-size: 11px; font-weight: 800; color: #0f172a;" class="dark:text-gray-100">CASH PAYMENTS (NET SALES)</span>
                                        <div style="font-size: 9.5px; color: #64748b;" class="dark:text-gray-400">
                                            Tendered In: <b class="font-mono">Rs. {{ number_format($shiftTenderedCash) }}</b> • Change Given Out: <b class="font-mono text-amber-600 dark:text-amber-400">-Rs. {{ number_format($shiftChangeReturned) }}</b>
                                        </div>
                                    </div>
                                </div>
                                <span style="font-size: 14px; font-weight: 900; font-family: monospace; color: #059669;" class="dark:text-emerald-400">
                                    Rs. {{ number_format($shiftCashSales) }}
                                </span>
                            </div>
                        </div>

                        <!-- 2. Non-Cash Channels Grid (Card, Bank, JazzCash, EasyPaisa) -->
                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 6px;">
                            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 6px 8px; text-align: center;" class="dark:bg-gray-800 dark:border-gray-700">
                                <span style="font-size: 9px; font-weight: 800; color: #64748b; display: block;" class="dark:text-gray-400">💳 Card / POS</span>
                                <span style="font-size: 11.5px; font-weight: 900; font-family: monospace; display: block; margin-top: 2px;">Rs. {{ number_format($shiftCardSales) }}</span>
                            </div>
                            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 6px 8px; text-align: center;" class="dark:bg-gray-800 dark:border-gray-700">
                                <span style="font-size: 9px; font-weight: 800; color: #64748b; display: block;" class="dark:text-gray-400">🏦 Bank Transfer</span>
                                <span style="font-size: 11.5px; font-weight: 900; font-family: monospace; display: block; margin-top: 2px;">Rs. {{ number_format($shiftBankSales) }}</span>
                            </div>
                            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 6px 8px; text-align: center;" class="dark:bg-gray-800 dark:border-gray-700">
                                <span style="font-size: 9px; font-weight: 800; color: #64748b; display: block;" class="dark:text-gray-400">📱 JazzCash</span>
                                <span style="font-size: 11.5px; font-weight: 900; font-family: monospace; display: block; margin-top: 2px;">Rs. {{ number_format($shiftJazzCashSales) }}</span>
                            </div>
                            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 6px 8px; text-align: center;" class="dark:bg-gray-800 dark:border-gray-700">
                                <span style="font-size: 9px; font-weight: 800; color: #64748b; display: block;" class="dark:text-gray-400">📱 EasyPaisa</span>
                                <span style="font-size: 11.5px; font-weight: 900; font-family: monospace; display: block; margin-top: 2px;">Rs. {{ number_format($shiftEasyPaisaSales) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- C. SHIFT EXPENSES PAID-OUT -->
                    @if(count($shiftExpensesList) > 0)
                        <div style="border: 1px solid #fca5a5; border-radius: 10px; padding: 8px 10px; background: #fff5f5;" class="dark:bg-red-950/30 dark:border-red-800">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                                <span style="font-size: 10px; font-weight: 800; color: #991b1b; text-transform: uppercase;" class="dark:text-red-300">
                                    💸 Paid-Out Expenses Log (Deducted from Drawer)
                                </span>
                                <span style="font-size: 10.5px; font-weight: 900; font-family: monospace; color: #dc2626;">
                                    -Rs. {{ number_format($shiftExpensesTotal) }}
                                </span>
                            </div>
                            <div style="max-height: 90px; overflow-y: auto; display: flex; flex-direction: column; gap: 3px;" class="compact-scroll">
                                @foreach($shiftExpensesList as $exp)
                                    <div style="display: flex; justify-content: space-between; font-size: 9.5px; color: #475569;" class="dark:text-gray-300">
                                        <span>• {{ $exp['recipient'] }} ({{ ucwords(str_replace('_', ' ', $exp['category'])) }}) {{ $exp['invoice_number'] ? '#'.$exp['invoice_number'] : '' }}</span>
                                        <span style="font-weight: 800; font-family: monospace;">Rs. {{ number_format($exp['amount']) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- D. PHYSICAL COUNT & DISCREPANCY -->
                    <div class="pos-modal-box" style="display: flex; flex-direction: column; gap: 6px;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <label style="font-size: 10px; font-weight: 800; color: #0f172a; text-transform: uppercase;" class="dark:text-gray-200">
                                💵 Counted Cash in Till Drawer (Rs.) <span style="color: #ef4444;">*</span>
                            </label>
                            <span style="font-size: 10px; color: #64748b;" class="dark:text-gray-400">Target: <b class="font-mono text-emerald-600">Rs. {{ number_format($expectedCash) }}</b></span>
                        </div>
                        <input type="number" wire:model.live="countedCash" placeholder="Enter counted physical drawer cash..." 
                               class="pos-modal-input" style="height: 40px; font-size: 15px;" />
                        
                        @php
                            $discrepancy = (float)$countedCash - (float)$expectedCash;
                        @endphp
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 4px; font-size: 11px; font-weight: 800; font-family: monospace;">
                            <span style="color: #64748b;" class="dark:text-gray-400">Reconciliation Status:</span>
                            @if(abs($discrepancy) < 0.01)
                                <span style="color: #059669;" class="dark:text-emerald-400">✅ Balanced (Exact match: Rs. 0 discrepancy)</span>
                            @elseif($discrepancy > 0)
                                <span style="color: #059669;" class="dark:text-emerald-400">🟢 Cash Surplus: +Rs. {{ number_format($discrepancy) }}</span>
                            @else
                                <span style="color: #dc2626;" class="dark:text-red-400">🔴 Cash Shortage: -Rs. {{ number_format(abs($discrepancy)) }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- E. MODAL ACTION BUTTONS (KEEP OPEN, PRINT Z-REPORT, SEAL SHIFT) -->
                    <div style="display: flex; gap: 8px;">
                        <button wire:click="cancelShiftModal" type="button" class="pos-modal-cancel-btn" style="width: 22%;">
                            Dismiss
                        </button>
                        <button wire:click="printShiftClosingReport" type="button" style="flex: 1; padding: 10px; border-radius: 10px; border: 1.5px solid #2563eb; background: rgba(37, 99, 235, 0.1); color: #1d4ed8; font-size: 11px; font-weight: 900; text-transform: uppercase; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 6px;" class="dark:text-blue-400 dark:border-blue-700 hover:bg-blue-600 hover:text-white transition" title="Print 80mm thermal shift closing Z-Report">
                            <span>🖨️</span>
                            <span>PRINT Z-REPORT SLIP</span>
                        </button>
                        <button wire:click="closeShift" type="button" style="flex: 1.2; padding: 10px; border-radius: 10px; border: none; background: linear-gradient(135deg, #D7262E 0%, #991b1b 100%); color: #fff; font-size: 11px; font-weight: 900; text-transform: uppercase; cursor: pointer; box-shadow: 0 4px 12px rgba(215, 38, 46, 0.35); display: inline-flex; align-items: center; justify-content: center; gap: 6px;">
                            <span>🔒</span>
                            <span>SEAL & CLOSE SHIFT</span>
                        </button>
                    </div>
                @else
                    <div class="pos-modal-box">
                        <label style="font-size: 10px; font-weight: 800; color: #0f172a; text-transform: uppercase; display: block; margin-bottom: 4px;" class="dark:text-gray-200">
                            💵 Opening Float Amount (Rs.)
                        </label>
                        <input type="number" wire:model="openingCash" placeholder="e.g. 5000" 
                               class="pos-modal-input" />
                        <span style="font-size: 9px; color: #94a3b8; display: block; margin-top: 4px;">Initial petty cash in till drawer before taking orders.</span>
                    </div>

                    <div style="display: flex; gap: 8px;">
                        <button wire:click="cancelShiftModal" type="button" class="pos-modal-cancel-btn" style="width: 35%;">
                            DISMISS
                        </button>
                        <button wire:click="openShift" type="button" style="flex: 1; padding: 10px; border-radius: 10px; border: none; background: #10b981; color: #fff; font-size: 11px; font-weight: 900; text-transform: uppercase; cursor: pointer; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35);">
                            🟢 START CASHIER SHIFT
                        </button>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- 4. PORTION SIZE SELECTION MODAL -->
    @if($portionSelectionModalOpen && $portionModalItemId)
        @php
            $portionItem = \App\Models\MenuItem::find($portionModalItemId);
        @endphp
        @if($portionItem)
            <div class="pos-overlay-backdrop" wire:click.self="$set('portionSelectionModalOpen', false)">
                <div class="pos-modal-card" style="width: 100%; max-width: 440px;">
                    <div class="pos-modal-header">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="font-size: 18px;">👑</span>
                            <h3 class="pos-modal-title">Select Portion Size</h3>
                        </div>
                        <button wire:click="$set('portionSelectionModalOpen', false)" class="pos-modal-close-btn">&times;</button>
                    </div>

                    <div class="pos-modal-box" style="display: flex; align-items: center; gap: 10px;">
                        @if($portionItem->resolved_image)
                            <img src="{{ $portionItem->resolved_image }}" alt="{{ $portionItem->name }}" style="width: 44px; height: 44px; border-radius: 8px; object-fit: cover;" />
                        @elseif($portionItem->image_path)
                            <img src="{{ asset($portionItem->image_path) }}" alt="{{ $portionItem->name }}" style="width: 44px; height: 44px; border-radius: 8px; object-fit: cover;" />
                        @else
                            <div class="pos-portion-crown-wrap">👑</div>
                        @endif
                        <div>
                            <h4 style="font-size: 12px; font-weight: 800;" class="text-gray-900 dark:text-gray-100">{{ $portionItem->name }}</h4>
                            <p style="font-size: 9px; color: #64748b;" class="dark:text-gray-400">{{ $portionItem->description }}</p>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px;">
                        @if(isset($portionItem->details['sizes']) && is_array($portionItem->details['sizes']))
                            @foreach($portionItem->details['sizes'] as $sKey => $sVal)
                                <button wire:click="addToCart({{ $portionItem->id }}, '{{ $sKey }}')" 
                                        type="button" 
                                        class="pos-portion-btn">
                                    <span style="font-size: 11px; font-weight: 800; text-transform: uppercase;">{{ $sVal['label'] }}</span>
                                    <span class="pos-portion-price">Rs. {{ number_format($sVal['price']) }}</span>
                                </button>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        @endif
    @endif

    <!-- 4b. DIRECT EXPENSE LEDGER VOUCHER MODAL -->
    @if($isExpenseModalOpen)
        <div class="pos-overlay-backdrop" wire:click.self="closeExpenseModal">
            <div class="pos-modal-card" style="width: 100%; max-width: 680px; max-height: 90vh; overflow-y: auto;">
                <!-- Header -->
                <div class="pos-modal-header">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-size: 22px; background: rgba(239, 68, 68, 0.12); border-radius: 12px; padding: 6px 10px;">💸</span>
                        <div>
                            <h3 class="pos-modal-title" style="display: flex; align-items: center; gap: 8px;">
                                <span>Record Expense Voucher</span>
                                <span style="font-size: 9px; font-weight: 800; background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; padding: 2px 6px; border-radius: 6px; font-family: monospace;" class="dark:bg-emerald-950/50 dark:border-emerald-700 dark:text-emerald-300">
                                    SYNC: ADMIN LEDGER
                                </span>
                            </h3>
                            <p style="font-size: 11px; color: #64748b; margin-top: 2px;" class="dark:text-gray-400">
                                Record daily expenses paid out from sale proceeds. Entries instantly sync to the Back-Office Expense Ledger.
                            </p>
                        </div>
                    </div>
                    <button wire:click="closeExpenseModal" class="pos-modal-close-btn">&times;</button>
                </div>

                <!-- Form Body -->
                <form wire:submit.prevent="saveExpense" style="display: flex; flex-direction: column; gap: 14px;">
                    
                    <!-- SECTION 1: TRANSACTION CORE (Matches Admin ExpenseResource) -->
                    <div style="border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px;" class="dark:border-gray-800 bg-gray-50/50 dark:bg-gray-900/40">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; border-bottom: 1px solid #e2e8f0; padding-bottom: 6px;" class="dark:border-gray-800">
                            <span style="font-size: 11px; font-weight: 800; text-transform: uppercase; color: #0f172a; letter-spacing: 0.5px;" class="dark:text-gray-200">
                                💳 1. Transaction Core
                            </span>
                            <span style="font-size: 10px; color: #64748b;" class="dark:text-gray-400">Category & Cash Valuation</span>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 10px;">
                            <!-- Category -->
                            <div>
                                <label style="font-size: 10px; font-weight: 800; color: #334155; text-transform: uppercase; display: block; margin-bottom: 4px;" class="dark:text-gray-300">
                                    Expense Category <span style="color: #ef4444;">*</span>
                                </label>
                                <select wire:model="expenseCategory" class="pos-modal-input" style="height: 38px; font-size: 11.5px;">
                                    <option value="utility">⚡ Utilities (Gas / Water / Electric)</option>
                                    <option value="maintenance">🔧 Repairs & Maintenance</option>
                                    <option value="salaries">👨‍🍳 Staff Daily Wages / Tips / Bonus</option>
                                    <option value="marketing">📢 Marketing & Ads</option>
                                    <option value="rent">🏢 Property Rent</option>
                                    <option value="other">🏷️ Other Overhead Expenses</option>
                                </select>
                                <span style="font-size: 9px; color: #64748b; display: block; margin-top: 3px;" class="dark:text-gray-400">
                                    ℹ️ Raw kitchen stock (Chicken, Meat, Dairy) is restocked via Admin Inventory Stocks to update physical quantities.
                                </span>
                                @error('expenseCategory') <span style="font-size: 10px; color: #ef4444; font-weight: bold; margin-top: 2px; display: block;">{{ $message }}</span> @enderror
                            </div>

                            <!-- Amount -->
                            <div>
                                <label style="font-size: 10px; font-weight: 800; color: #334155; text-transform: uppercase; display: block; margin-bottom: 4px;" class="dark:text-gray-300">
                                    Amount Spent (Rs.) <span style="color: #ef4444;">*</span>
                                </label>
                                <div style="position: relative;">
                                    <span style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); font-weight: 800; font-size: 12px; color: #64748b; font-family: monospace;">Rs.</span>
                                    <input type="number" step="any" wire:model="expenseAmount" placeholder="e.g. 1500" class="pos-modal-input" style="padding-left: 36px;" />
                                </div>
                                @error('expenseAmount') <span style="font-size: 10px; color: #ef4444; font-weight: bold; margin-top: 2px; display: block;">{{ $message }}</span> @enderror
                            </div>

                            <!-- Date -->
                            <div>
                                <label style="font-size: 10px; font-weight: 800; color: #334155; text-transform: uppercase; display: block; margin-bottom: 4px;" class="dark:text-gray-300">
                                    Expense Date <span style="color: #ef4444;">*</span>
                                </label>
                                <input type="date" wire:model="expenseDate" class="pos-modal-input" style="font-size: 12px;" />
                                @error('expenseDate') <span style="font-size: 10px; color: #ef4444; font-weight: bold; margin-top: 2px; display: block;">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 2: PAYEE & SUPPORTING DOCUMENTS (Matches Admin ExpenseResource) -->
                    <div style="border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px;" class="dark:border-gray-800 bg-gray-50/50 dark:bg-gray-900/40">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; border-bottom: 1px solid #e2e8f0; padding-bottom: 6px;" class="dark:border-gray-800">
                            <span style="font-size: 11px; font-weight: 800; text-transform: uppercase; color: #0f172a; letter-spacing: 0.5px;" class="dark:text-gray-200">
                                📋 2. Payee & Supporting Details
                            </span>
                            <span style="font-size: 10px; color: #64748b;" class="dark:text-gray-400">Vendor, Voucher & Ledger Context</span>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                            <!-- Paid To / Recipient -->
                            <div>
                                <label style="font-size: 10px; font-weight: 800; color: #334155; text-transform: uppercase; display: block; margin-bottom: 4px;" class="dark:text-gray-300">
                                    Paid To (Recipient) <span style="color: #ef4444;">*</span>
                                </label>
                                <input type="text" wire:model="expenseRecipient" placeholder="e.g. Ice Vendor, Okara Gas, Sabzi Mandi..." class="pos-modal-input" style="font-size: 12px; font-family: inherit;" />
                                @error('expenseRecipient') <span style="font-size: 10px; color: #ef4444; font-weight: bold; margin-top: 2px; display: block;">{{ $message }}</span> @enderror
                            </div>

                            <!-- Invoice / Voucher # -->
                            <div>
                                <label style="font-size: 10px; font-weight: 800; color: #334155; text-transform: uppercase; display: block; margin-bottom: 4px;" class="dark:text-gray-300">
                                    Invoice / Voucher # (Optional)
                                </label>
                                <input type="text" wire:model="expenseInvoiceNumber" placeholder="e.g. VCH-0941 / INV-881" class="pos-modal-input" style="font-size: 12px;" />
                                @error('expenseInvoiceNumber') <span style="font-size: 10px; color: #ef4444; font-weight: bold; margin-top: 2px; display: block;">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Payment Source (Cash Drawer vs External) -->
                        <div style="margin-top: 10px;">
                            <label style="font-size: 10px; font-weight: 800; color: #334155; text-transform: uppercase; display: block; margin-bottom: 4px;" class="dark:text-gray-300">
                                Paid Out From
                            </label>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                                <label style="display: flex; align-items: center; gap: 8px; padding: 8px 12px; border: 1.5px solid {{ $expensePaidFrom === 'cash_drawer' ? '#10b981' : '#cbd5e1' }}; border-radius: 8px; cursor: pointer; background: {{ $expensePaidFrom === 'cash_drawer' ? 'rgba(16, 185, 129, 0.08)' : 'transparent' }}; font-size: 11px; font-weight: 700;">
                                    <input type="radio" wire:model.live="expensePaidFrom" value="cash_drawer" />
                                    <span>💵 Till Drawer (Deducts Expected Cash)</span>
                                </label>
                                <label style="display: flex; align-items: center; gap: 8px; padding: 8px 12px; border: 1.5px solid {{ $expensePaidFrom === 'external' ? '#6366f1' : '#cbd5e1' }}; border-radius: 8px; cursor: pointer; background: {{ $expensePaidFrom === 'external' ? 'rgba(99, 102, 241, 0.08)' : 'transparent' }}; font-size: 11px; font-weight: 700;">
                                    <input type="radio" wire:model.live="expensePaidFrom" value="external" />
                                    <span>🏦 External / Owner Funds</span>
                                </label>
                            </div>
                        </div>

                        <!-- Description Notes -->
                        <div style="margin-top: 10px;">
                            <label style="font-size: 10px; font-weight: 800; color: #334155; text-transform: uppercase; display: block; margin-bottom: 4px;" class="dark:text-gray-300">
                                Contextual Notes / Description
                            </label>
                            <textarea wire:model="expenseDescription" rows="2" placeholder="Provide any contextual details about this expense (e.g. 5 bags of ice cubes for beverage station)..." class="pos-modal-input" style="height: auto; min-height: 54px; padding: 8px 12px; font-size: 12px; font-family: inherit; resize: vertical;"></textarea>
                            @error('expenseDescription') <span style="font-size: 10px; color: #ef4444; font-weight: bold; margin-top: 2px; display: block;">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Modal Actions -->
                    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 8px; margin-top: 4px;">
                        <button type="button" wire:click="closeExpenseModal" class="pos-modal-cancel-btn" style="width: auto; padding: 9px 18px;">
                            Discard
                        </button>
                        <button type="submit" style="padding: 9px 22px; border-radius: 10px; border: none; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; font-size: 11.5px; font-weight: 900; text-transform: uppercase; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35);">
                            <span>💾</span>
                            <span>Record & Post to Ledger</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- 5. ONGOING ORDERS REGISTER MODAL -->
    @if($ongoingOrdersModalOpen)
        <div class="pos-overlay-backdrop" wire:click.self="closeOngoingOrdersModal">
            <div class="pos-modal-card" style="width: 100%; max-width: 720px;">
                <div class="pos-modal-header">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <h3 class="pos-modal-title">📋 Active Ongoing Orders</h3>
                        <span style="font-size: 11px; font-weight: 800; background: #D4A437; color: #000; padding: 2px 8px; border-radius: 12px; font-family: monospace;">
                            {{ count($this->ongoingOrders) }}
                        </span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <button type="button" wire:click="openExpenseModal" style="padding: 4px 10px; border-radius: 8px; border: 1.5px solid rgba(239, 68, 68, 0.4); background: rgba(239, 68, 68, 0.1); color: #dc2626; font-size: 10.5px; font-weight: 800; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;" title="Record an expense voucher directly from sale">
                            <span>💸</span>
                            <span>+ Record Expense</span>
                        </button>
                        <button type="button" wire:click="closeOngoingOrdersModal" class="pos-modal-close-btn" aria-label="Close">&times;</button>
                    </div>
                </div>

                <div style="max-height: 420px; overflow-y: auto; display: flex; flex-direction: column; gap: 8px;" class="compact-scroll">
                    @if(count($this->ongoingOrders) === 0)
                        <div style="text-align: center; color: #94a3b8; padding: 32px 0; font-size: 12px;">
                            <div style="font-size: 28px; margin-bottom: 6px;">📋</div>
                            No active ongoing orders currently running.
                        </div>
                    @else
                        @foreach($this->ongoingOrders as $order)
                            <div class="pos-modal-row" style="display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 10px 12px; border-radius: 10px;">
                                <div style="display: flex; flex-direction: column; gap: 4px;">
                                    <div style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                                        <span style="font-size: 12px; font-weight: 900; font-family: monospace;">{{ $order->order_number }}</span>
                                        
                                        {{-- Order Type Channel Badge --}}
                                        @if($order->type === 'dine_in')
                                            <span style="font-size: 9.5px; font-weight: 800; background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; padding: 1px 6px; border-radius: 4px; font-family: monospace;">
                                                🍽️ DINE-IN • {{ $order->table_number ?: 'Walk-In / Counter' }}
                                            </span>
                                        @elseif($order->type === 'takeaway')
                                            <span style="font-size: 9.5px; font-weight: 800; background: #fef3c7; color: #92400e; border: 1px solid #fcd34d; padding: 1px 6px; border-radius: 4px; font-family: monospace;">
                                                🥡 TAKEAWAY
                                            </span>
                                        @elseif($order->type === 'delivery')
                                            <span style="font-size: 9.5px; font-weight: 800; background: #e0e7ff; color: #3730a3; border: 1px solid #a5b4fc; padding: 1px 6px; border-radius: 4px; font-family: monospace;">
                                                🛵 DELIVERY
                                            </span>
                                        @endif

                                        {{-- Status Indicator --}}
                                        @if($order->bill_requested)
                                            <span style="font-size: 9px; font-weight: 900; background: #fef08a; color: #854d0e; border: 1px solid #facc15; padding: 1px 6px; border-radius: 4px;">
                                                🧾 BILL REQUESTED
                                            </span>
                                        @endif

                                        @if($order->status === 'pending')
                                            <span style="font-size: 9px; font-weight: 800; background: #fef3c7; color: #b45309; border: 1px solid #fde68a; padding: 1px 5px; border-radius: 4px;">
                                                ⏸️ ON HOLD
                                            </span>
                                        @elseif($order->status === 'preparing')
                                            <span style="font-size: 9px; font-weight: 800; background: #ffedd5; color: #c2410c; border: 1px solid #fed7aa; padding: 1px 5px; border-radius: 4px;">
                                                🔥 IN KITCHEN
                                            </span>
                                        @elseif($order->status === 'ready')
                                            <span style="font-size: 9px; font-weight: 800; background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; padding: 1px 5px; border-radius: 4px;">
                                                ✅ READY
                                            </span>
                                        @endif
                                    </div>

                                    <div style="font-size: 10.5px;" class="text-gray-600 dark:text-gray-300">
                                        <span>👤 {{ $order->customer_name ?: 'Walk-In Guest' }}</span>
                                        @if($order->customer_phone)
                                            <span style="margin-left: 6px;">• 📱 {{ $order->customer_phone }}</span>
                                        @endif
                                        @if($order->type === 'delivery' && $order->customer_address)
                                            <div style="font-size: 10px; color: #6366f1; margin-top: 1px;">📍 {{ $order->customer_address }}</div>
                                        @endif
                                    </div>
                                    <div style="font-size: 9.5px; color: #94a3b8; font-family: monospace;">
                                        ⏱️ {{ $order->created_at->format('h:i A') }} ({{ $order->created_at->diffForHumans() }}) • {{ count($order->items) }} items
                                    </div>
                                </div>

                                <div style="display: flex; align-items: center; gap: 6px;">
                                    <span style="font-size: 13.5px; font-weight: 900; font-family: monospace; color: #059669; margin-right: 4px;" class="dark:text-emerald-400">
                                        Rs. {{ number_format($order->total) }}
                                    </span>
                                    @if($order->bill_requested || $order->status === 'ready')
                                        <button wire:click="openDirectSettlement({{ $order->id }})" type="button" style="padding: 7px 11px; border-radius: 8px; border: none; background: {{ $order->bill_requested ? '#059669' : '#D4A437' }}; color: {{ $order->bill_requested ? '#fff' : '#000' }}; font-size: 11px; font-weight: 900; cursor: pointer; display: flex; align-items: center; gap: 3px;" title="Open payment settlement screen to settle guest bill">
                                            <span>💰</span>
                                            <span>Settle</span>
                                        </button>
                                    @endif
                                    <button wire:click="loadOngoingOrder({{ $order->id }})" type="button" style="padding: 7px 12px; border-radius: 8px; border: 1px solid #cbd5e1; background: transparent; color: inherit; font-size: 11px; font-weight: 800; cursor: pointer;" title="Resume and edit order in POS cart">
                                        Pull Cart ➔
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Footer Close Button -->
                <div style="display: flex; justify-content: flex-end; padding-top: 10px; margin-top: 4px; border-top: 1px solid #e2e8f0;" class="dark:border-gray-800">
                    <button type="button" wire:click="closeOngoingOrdersModal" style="padding: 7px 16px; border-radius: 8px; border: 1px solid #cbd5e1; background: #f1f5f9; color: #334155; font-size: 11.5px; font-weight: 800; cursor: pointer;" class="dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                        ✕ Close Window
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- 6. KITCHEN STATUS / KOT QUEUE MODAL -->
    @if($kitchenStatusModalOpen)
        <div class="pos-overlay-backdrop" wire:click.self="closeKitchenStatusModal">
            <div class="pos-modal-card" style="width: 100%; max-width: 720px;">
                <div class="pos-modal-header">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <h3 class="pos-modal-title">🍳 Kitchen Active Cooking Monitor</h3>
                        @php
                            $cookingOrders = \App\Models\Order::where('status', 'preparing')->orderBy('created_at', 'desc')->get();
                            $readyOrders = \App\Models\Order::where('status', 'ready')->orderBy('updated_at', 'desc')->take(8)->get();
                        @endphp
                        <span style="font-size: 11px; font-weight: 800; background: #ef4444; color: #fff; padding: 2px 8px; border-radius: 12px; font-family: monospace;">
                            {{ count($cookingOrders) }} Cooking
                        </span>
                        @if(count($readyOrders) > 0)
                            <span style="font-size: 11px; font-weight: 800; background: #10b981; color: #fff; padding: 2px 8px; border-radius: 12px; font-family: monospace;">
                                {{ count($readyOrders) }} Ready
                            </span>
                        @endif
                    </div>
                    <button type="button" wire:click="closeKitchenStatusModal" class="pos-modal-close-btn" aria-label="Close">&times;</button>
                </div>

                <div style="max-height: 420px; overflow-y: auto; display: flex; flex-direction: column; gap: 10px;" class="compact-scroll">
                    @if(count($cookingOrders) === 0 && count($readyOrders) === 0)
                        <div style="text-align: center; color: #94a3b8; padding: 32px 0; font-size: 12px;">
                            <div style="font-size: 32px; margin-bottom: 6px;">👨‍🍳</div>
                            Kitchen cooking queue is clear. No active tickets on stoves.
                        </div>
                    @else
                        {{-- 1. Orders Currently Cooking --}}
                        @if(count($cookingOrders) > 0)
                            <div style="font-size: 11px; font-weight: 900; color: #ea580c; text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center; gap: 4px;">
                                <span>🔥 Cooking Now ({{ count($cookingOrders) }})</span>
                            </div>

                            @foreach($cookingOrders as $order)
                                <div class="pos-modal-box" style="display: flex; flex-direction: column; gap: 6px; border-left: 3.5px solid #ea580c;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 6px; border-bottom: 1px solid #e2e8f0;" class="dark:border-gray-700">
                                        <div style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                                            <span style="font-size: 12.5px; font-weight: 900; font-family: monospace;">{{ $order->order_number }}</span>

                                            {{-- Channel Badge --}}
                                            @if($order->type === 'dine_in')
                                                <span style="font-size: 9.5px; font-weight: 800; padding: 1px 6px; border-radius: 4px; font-family: monospace;" class="bg-red-50 text-red-600 border border-red-200 dark:bg-red-950/40 dark:text-red-400 dark:border-red-900/60">
                                                    🍽️ DINE-IN • {{ $order->table_number ?: 'Walk-In / Counter' }}
                                                </span>
                                            @elseif($order->type === 'takeaway')
                                                <span style="font-size: 9.5px; font-weight: 800; padding: 1px 6px; border-radius: 4px; font-family: monospace;" class="bg-amber-50 text-amber-700 border border-amber-200 dark:bg-amber-950/40 dark:text-amber-400 dark:border-amber-900/60">
                                                    🥡 TAKEAWAY
                                                </span>
                                            @elseif($order->type === 'delivery')
                                                <span style="font-size: 9.5px; font-weight: 800; padding: 1px 6px; border-radius: 4px; font-family: monospace;" class="bg-indigo-50 text-indigo-700 border border-indigo-200 dark:bg-indigo-950/40 dark:text-indigo-400 dark:border-indigo-900/60">
                                                    🛵 DELIVERY
                                                </span>
                                            @endif

                                            @if(session("kot_version_{$order->id}", 1) > 1)
                                                <span style="font-size: 9px; font-weight: 900; background: #dc2626; color: #fff; padding: 1px 5px; border-radius: 4px;">
                                                    KOT V{{ session("kot_version_{$order->id}") }}
                                                </span>
                                            @endif

                                            {{-- Server / Waiter Badge --}}
                                            @php
                                                $orderServer = $order->waiter?->name ?? ($order->user && $order->user->role === 'waiter' ? $order->user->name : ($order->user?->name ?? 'Counter'));
                                            @endphp
                                            <span style="font-size: 9.5px; font-weight: 700; background: #fef3c7; color: #92400e; padding: 1px 6px; border-radius: 4px; border: 1px solid #fde68a;" class="dark:bg-amber-950/40 dark:text-amber-300 dark:border-amber-800">
                                                🤵 {{ $order->waiter ? 'Waiter: ' : 'Server: ' }}{{ $orderServer }}
                                            </span>

                                            @if($order->type === 'delivery' && $order->rider_name)
                                                <span style="font-size: 9.5px; font-weight: 700; background: #e0e7ff; color: #3730a3; padding: 1px 6px; border-radius: 4px; border: 1px solid #c7d2fe;" class="dark:bg-indigo-950/40 dark:text-indigo-300 dark:border-indigo-800">
                                                    🛵 Rider: {{ $order->rider_name }}
                                                </span>
                                            @endif
                                        </div>

                                        <span style="font-size: 10px; color: #94a3b8; font-family: monospace;">
                                            ⏱️ {{ $order->created_at->diffForHumans() }}
                                        </span>
                                    </div>

                                    {{-- Customer Contact / Address --}}
                                    @if($order->customer_name || $order->customer_phone || ($order->type === 'delivery' && $order->customer_address))
                                        <div style="font-size: 10px; color: #64748b;" class="dark:text-gray-400">
                                            @if($order->customer_name) <span>Guest: <strong>{{ $order->customer_name }}</strong></span> @endif
                                            @if($order->customer_phone) <span style="margin-left: 6px;">📱 {{ $order->customer_phone }}</span> @endif
                                            @if($order->type === 'delivery' && $order->customer_address)
                                                <div style="color: #4f46e5; margin-top: 1px;">📍 {{ $order->customer_address }}</div>
                                            @endif
                                        </div>
                                    @endif

                                    {{-- Order Items --}}
                                    <div style="display: flex; flex-direction: column; gap: 3px; font-size: 11.5px; font-family: monospace; background: rgba(0,0,0,0.02); padding: 6px; border-radius: 6px;">
                                        @foreach($order->items as $oItem)
                                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                                <span>
                                                    • {{ $oItem->menuItem->name ?? 'Dish' }}
                                                    @if($oItem->notes) <span class="text-amber-700 dark:text-amber-300 font-sans text-[10px]">({{ $oItem->notes }})</span> @endif
                                                </span>
                                                <span style="font-weight: 900; color: #D4A437; font-size: 12px;">x{{ $oItem->quantity }}</span>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div style="display: flex; justify-content: flex-end; align-items: center; gap: 6px; margin-top: 6px;">
                                        <button wire:click="reprintKOT({{ $order->id }})" type="button" style="padding: 6px 10px; border-radius: 8px; border: 1px solid #cbd5e1; background: transparent; color: inherit; font-size: 10px; font-weight: 800; cursor: pointer;" title="Re-print Kitchen Order Ticket">
                                            🖨️ Re-Print KOT
                                        </button>
                                        <button wire:click="completeCooking({{ $order->id }})" type="button" style="padding: 6px 14px; border-radius: 8px; border: none; background: #10b981; color: #fff; font-size: 10.5px; font-weight: 900; cursor: pointer;" title="Mark food cooked and ready to serve">
                                            🍳 COOKING READY
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        {{-- 2. Orders Ready for Serving / Pickup --}}
                        @if(count($readyOrders) > 0)
                            <div style="font-size: 11px; font-weight: 900; color: #16a34a; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 10px; display: flex; align-items: center; gap: 4px;">
                                <span>✅ Ready For Serving / Dispatch ({{ count($readyOrders) }})</span>
                            </div>

                            @foreach($readyOrders as $order)
                                <div class="pos-modal-box" style="display: flex; flex-direction: column; gap: 6px; border-left: 3.5px solid #10b981;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
                                        <div style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                                            <span style="font-size: 12px; font-weight: 900; font-family: monospace;">{{ $order->order_number }}</span>
                                            @if($order->type === 'dine_in')
                                                <span style="font-size: 9.5px; font-weight: 800; padding: 1px 6px; border-radius: 4px; background: #fee2e2; color: #991b1b; font-family: monospace;">
                                                    🍽️ {{ str_starts_with($order->table_number, 'Table') ? $order->table_number : ('TABLE ' . ($order->table_number ?: 'Walk-In')) }}
                                                </span>
                                            @elseif($order->type === 'takeaway')
                                                <span style="font-size: 9.5px; font-weight: 800; padding: 1px 6px; border-radius: 4px; background: #fef3c7; color: #92400e; font-family: monospace;">
                                                    🥡 TAKEAWAY
                                                </span>
                                            @else
                                                <span style="font-size: 9.5px; font-weight: 800; padding: 1px 6px; border-radius: 4px; background: #e0e7ff; color: #3730a3; font-family: monospace;">
                                                    🛵 DELIVERY
                                                </span>
                                            @endif

                                            @php
                                                $assignedWaiter = $order->waiter?->name ?? ($order->user && $order->user->role === 'waiter' ? $order->user->name : ($order->user?->name ?? 'Staff'));
                                            @endphp
                                            <span style="font-size: 9.5px; font-weight: 700; background: #f1f5f9; color: #475569; padding: 1px 6px; border-radius: 4px;" class="dark:bg-gray-800 dark:text-gray-300">
                                                🤵 {{ $assignedWaiter }}
                                            </span>

                                            @if($order->bill_requested)
                                                <span style="font-size: 9.5px; font-weight: 900; background: #fef08a; color: #854d0e; padding: 1px 6px; border-radius: 4px; border: 1px solid #facc15;">
                                                    🧾 BILL REQUESTED
                                                </span>
                                            @endif

                                            @if($order->served_at)
                                                <span style="font-size: 9px; font-weight: 800; color: #16a34a;">
                                                    🍽️ Served {{ $order->served_at->diffForHumans() }}
                                                </span>
                                            @else
                                                <span style="font-size: 9px; font-weight: 800; color: #ea580c;">
                                                    COOKED &bull; AWAITING SERVICE
                                                </span>
                                            @endif
                                        </div>

                                        <div style="display: flex; align-items: center; gap: 6px;">
                                            <span style="font-size: 13px; font-weight: 900; font-family: monospace; color: #059669; margin-right: 4px;" class="dark:text-emerald-400">
                                                Rs. {{ number_format($order->total, 0) }}
                                            </span>

                                            @if($order->type === 'dine_in')
                                                {{-- 1. Serve Button (Notifies Waiter) --}}
                                                <button wire:click="notifyWaiterToServe({{ $order->id }})" type="button" style="padding: 5px 10px; border-radius: 7px; border: 1px solid #3b82f6; background: #eff6ff; color: #1d4ed8; font-size: 10px; font-weight: 800; cursor: pointer;" class="dark:bg-blue-950/50 dark:text-blue-300 dark:border-blue-800 hover:bg-blue-100" title="Notify waiter {{ $assignedWaiter }} to pick up food from counter and serve to table">
                                                    🍽️ {{ $order->served_at ? 'Re-Notify Waiter' : 'Serve (Notify Waiter)' }}
                                                </button>

                                                {{-- 2. Settle Button (Opens Direct Settle Screen) --}}
                                                <button wire:click="openDirectSettlement({{ $order->id }})" type="button" style="padding: 5px 12px; border-radius: 7px; border: none; background: {{ $order->bill_requested ? '#059669' : '#D4A437' }}; color: {{ $order->bill_requested ? '#fff' : '#000' }}; font-size: 10px; font-weight: 900; cursor: pointer; display: flex; align-items: center; gap: 4px;" title="Open payment settlement screen to settle guest bill">
                                                    <span>💰</span>
                                                    <span>{{ $order->bill_requested ? 'Settle Requested Bill ➔' : 'Settle Bill ➔' }}</span>
                                                </button>
                                            @elseif($order->type === 'takeaway')
                                                <button wire:click="openDirectSettlement({{ $order->id }})" type="button" style="padding: 5px 12px; border-radius: 7px; border: none; background: #D4A437; color: #000; font-size: 10px; font-weight: 900; cursor: pointer;" title="Handover takeaway package to customer and settle payment">
                                                    🥡 Handover & Settle ➔
                                                </button>
                                            @else
                                                <button wire:click="openDirectSettlement({{ $order->id }})" type="button" style="padding: 5px 12px; border-radius: 7px; border: none; background: #D4A437; color: #000; font-size: 10px; font-weight: 900; cursor: pointer;" title="Handover to delivery rider and settle payment">
                                                    🛵 Dispatch & Settle ➔
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    @endif
                </div>

                <!-- Modal Footer Actions -->
                <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 10px; margin-top: 4px; border-top: 1px solid #e2e8f0;" class="dark:border-gray-800">
                    <span style="font-size: 11px; color: #64748b;" class="dark:text-gray-400">
                        Kitchen orders update in real-time. Marking dishes ready notifies Waiters & Cashiers.
                    </span>
                    <button type="button" wire:click="closeKitchenStatusModal" style="padding: 7px 16px; border-radius: 8px; border: 1px solid #cbd5e1; background: #f1f5f9; color: #334155; font-size: 11.5px; font-weight: 800; cursor: pointer;" class="dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                        ✕ Close Window
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- 7. RECEIPT PRINT PREVIEW MODAL -->
    @if($isReceiptModalOpen && $printedOrder)
        <div class="pos-overlay-backdrop" wire:click.self="$set('isReceiptModalOpen', false)">
            <div class="pos-modal-card" style="width: 100%; max-width: 380px;">
                <div class="pos-modal-header">
                    <h3 class="pos-modal-title">
                        🖨️ {{ $receiptType === 'kot' ? 'Kitchen KOT Ticket' : 'Guest Invoice Statement' }}
                    </h3>
                    <button wire:click="$set('isReceiptModalOpen', false)" class="pos-modal-close-btn">&times;</button>
                </div>

                <!-- Printable Area -->
                <div style="max-height: 480px; overflow-y: auto; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 8px; padding: 8px;" class="compact-scroll">
                    <div id="thermal-print-area">
                        @include('receipts.thermal-receipt', [
                            'order' => $printedOrder,
                            'cashierName' => auth()->user()?->name ?? 'admin',
                            'type' => $receiptType,
                        ])
                    </div>
                </div>

                <div style="display: flex; gap: 8px; margin-top: 6px;">
                    <button wire:click="$set('isReceiptModalOpen', false)" type="button" class="pos-modal-cancel-btn" style="width: 35%; padding: 8px;">
                        Close
                    </button>
                    <button onclick="printThermalReceipt()" type="button" style="flex: 1; padding: 8px; border-radius: 8px; border: none; background: #10b981; color: #fff; font-size: 11px; font-weight: 900; cursor: pointer;">
                        🖨️ Print Ticket
                    </button>
                </div>
            </div>
        </div>

        <script>
            function printThermalReceipt() {
                var printArea = document.getElementById('thermal-print-area');
                if (!printArea) return;
                var printContents = printArea.innerHTML;

                // Check for Standalone Desktop Electron silent thermal printing bridge
                if (window.posDesktop && typeof window.posDesktop.printReceiptDirect === 'function') {
                    window.posDesktop.printReceiptDirect(printContents).then(function(res) {
                        console.log('Direct thermal receipt printed:', res);
                    }).catch(function(err) {
                        console.warn('Desktop printer fallback:', err);
                        fallbackBrowserPrint(printContents, 'Thermal Receipt');
                    });
                    return;
                }

                fallbackBrowserPrint(printContents, 'Thermal Receipt');
            }
        </script>
    @endif

    <!-- 8. SHIFT CLOSING Z-REPORT THERMAL PRINT MODAL -->
    @if($isShiftPrintModalOpen)
        <div class="pos-overlay-backdrop" wire:click.self="closeShiftPrintModal">
            <div class="pos-modal-card" style="width: 100%; max-width: 380px;">
                <div class="pos-modal-header">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="font-size: 20px;">🖨️</span>
                        <div>
                            <h3 class="pos-modal-title">Shift Closing Z-Report</h3>
                            <span style="font-size: 9.5px; color: #64748b;" class="dark:text-gray-400">80mm Thermal Cashier Slip</span>
                        </div>
                    </div>
                    <button wire:click="closeShiftPrintModal" class="pos-modal-close-btn">&times;</button>
                </div>

                <!-- Printable Area -->
                <div style="max-height: 480px; overflow-y: auto; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 8px; padding: 8px;" class="compact-scroll">
                    <div id="thermal-shift-report-area">
                        @include('receipts.thermal-shift-report', [
                            'report' => $shiftClosingReportData,
                        ])
                    </div>
                </div>

                <div style="display: flex; gap: 8px; margin-top: 6px;">
                    <button wire:click="closeShiftPrintModal" type="button" class="pos-modal-cancel-btn" style="width: 35%; padding: 8px;">
                        Close
                    </button>
                    <button onclick="printThermalShiftSlip()" type="button" style="flex: 1; padding: 8px; border-radius: 8px; border: none; background: #2563eb; color: #fff; font-size: 11px; font-weight: 900; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35);">
                        <span>🖨️</span>
                        <span>Print Z-Report</span>
                    </button>
                </div>
            </div>
        </div>

        <script>
            function printThermalShiftSlip() {
                var printArea = document.getElementById('thermal-shift-report-area');
                if (!printArea) return;
                var printContents = printArea.innerHTML;

                if (window.posDesktop && typeof window.posDesktop.printReceiptDirect === 'function') {
                    window.posDesktop.printReceiptDirect(printContents).then(function(res) {
                        console.log('Direct shift Z-report printed:', res);
                    }).catch(function(err) {
                        console.warn('Desktop printer fallback:', err);
                        fallbackBrowserPrint(printContents, 'Shift Z-Report');
                    });
                    return;
                }

                fallbackBrowserPrint(printContents, 'Shift Z-Report');
            }
        </script>
    @endif

</div>

<!-- Scripts: Theme Mode Switcher + Live Clock Synchronizer + Hybrid Cloud Sync Engine -->
<script>
    function fallbackBrowserPrint(content, title) {
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
        doc.write('<!DOCTYPE html><html><head><title>' + (title || 'Print') + '<' + '/title><style>@page { margin: 0; size: 80mm auto; } body { margin: 0; padding: 4mm; font-family: monospace; }<' + '/style><' + '/head><body>' + content + '<' + '/body><' + '/html>');
        doc.close();

        setTimeout(function() {
            printFrame.contentWindow.focus();
            printFrame.contentWindow.print();
            setTimeout(function() {
                if (printFrame.parentNode) {
                    printFrame.parentNode.removeChild(printFrame);
                }
            }, 1000);
        }, 250);
    }

    function initPOSTheme() {
        const saved = localStorage.getItem('pos_theme');
        const isDark = saved === 'dark' || (!saved && document.documentElement.classList.contains('dark'));
        applyPOSTheme(isDark);
    }

    function togglePOSTheme() {
        const isDark = document.documentElement.classList.contains('dark');
        applyPOSTheme(!isDark);
    }

    function applyPOSTheme(isDark) {
        const icon = document.getElementById('pos-theme-icon');
        const txt = document.getElementById('pos-theme-text');
        if (isDark) {
            document.documentElement.classList.add('dark');
            localStorage.setItem('pos_theme', 'dark');
            if (icon) icon.textContent = '☀️';
            if (txt) txt.textContent = 'LIGHT';
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('pos_theme', 'light');
            if (icon) icon.textContent = '🌙';
            if (txt) txt.textContent = 'DARK';
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initPOSTheme);
    } else {
        initPOSTheme();
    }
    document.addEventListener('livewire:navigated', initPOSTheme);
    document.addEventListener('livewire:initialized', initPOSTheme);

    function updatePosClock() {
        const el = document.getElementById('pos-live-clock');
        if (el) {
            const now = new Date();
            el.innerText = now.toLocaleTimeString('en-US', { hour12: true, hour: '2-digit', minute: '2-digit', second: '2-digit' });
        }
    }
    setInterval(updatePosClock, 1000);

    /* =========================================================================
     * NAWABI FOOD CORNER HYBRID OFFLINE & BIDIRECTIONAL CLOUD SYNC ENGINE
     * ========================================================================= */
    const POS_SYNC = {
        isOnline: navigator.onLine,
        isSyncing: false,
        apiHealthUrl: '/api/pos/sync/health',
        apiPullUrl: '/api/pos/sync/pull',
        apiPushUrl: '/api/pos/sync/push',
        terminalCode: '{{ auth()->user()->terminal_code ?? "POS-01" }}',
        token: '{{ auth()->user()->api_token ?? "" }}',

        getOfflineOrders: function() {
            try {
                return JSON.parse(localStorage.getItem('nfc_offline_orders') || '[]');
            } catch (e) {
                return [];
            }
        },

        saveOfflineOrders: function(orders) {
            localStorage.setItem('nfc_offline_orders', JSON.stringify(orders));
            this.updateBadge();
        },

        updateBadge: function(overrideStatus, overrideText) {
            const badge = document.getElementById('pos-sync-badge');
            const dot = document.getElementById('pos-sync-dot');
            const text = document.getElementById('pos-sync-text');
            if (!badge || !text) return;

            const pending = this.getOfflineOrders().length;
            const status = overrideStatus || (this.isSyncing ? 'syncing' : (this.isOnline ? 'online' : 'offline'));

            badge.className = 'pos-sync-badge ' + status;

            if (overrideText) {
                text.textContent = overrideText;
            } else if (status === 'syncing') {
                text.textContent = 'SYNCING...';
            } else if (status === 'offline') {
                text.textContent = pending > 0 ? `OFFLINE (${pending})` : 'OFFLINE';
            } else {
                text.textContent = pending > 0 ? `SYNC (${pending})` : 'ONLINE';
            }
        },

        checkConnectivity: async function() {
            if (!navigator.onLine) {
                this.isOnline = false;
                this.updateBadge();
                return false;
            }

            try {
                const ctrl = new AbortController();
                const timeoutId = setTimeout(() => ctrl.abort(), 4000);
                const resp = await fetch(this.apiHealthUrl, {
                    headers: { 'X-Terminal-Token': this.token },
                    signal: ctrl.signal
                });
                clearTimeout(timeoutId);

                if (resp.ok) {
                    const wasOffline = !this.isOnline;
                    this.isOnline = true;
                    this.updateBadge();
                    if (wasOffline || this.getOfflineOrders().length > 0) {
                        this.pushOfflineOrders();
                    }
                    return true;
                } else {
                    this.isOnline = false;
                    this.updateBadge();
                    return false;
                }
            } catch (err) {
                this.isOnline = false;
                this.updateBadge();
                return false;
            }
        },

        pushOfflineOrders: async function() {
            const orders = this.getOfflineOrders();
            if (!orders || orders.length === 0 || this.isSyncing) return;

            this.isSyncing = true;
            this.updateBadge('syncing', `SYNCING (${orders.length})...`);

            try {
                const resp = await fetch(this.apiPushUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Terminal-Token': this.token,
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        terminal_code: this.terminalCode,
                        orders: orders
                    })
                });

                const data = await resp.json();
                if (data.status === 'success' && Array.isArray(data.synced_uuids)) {
                    const remaining = orders.filter(o => !data.synced_uuids.includes(o.uuid));
                    this.saveOfflineOrders(remaining);
                    console.log(`[POS Sync] Successfully synced ${data.synced_count} offline orders to cloud hub.`);
                    this.showToast(`✅ Synced ${data.synced_count} offline orders to Cloud`);
                }
            } catch (err) {
                console.warn('[POS Sync] Push failed, orders safely retained locally:', err);
            } finally {
                this.isSyncing = false;
                this.updateBadge();
            }
        },

        pullCatalog: async function() {
            try {
                const resp = await fetch(this.apiPullUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Terminal-Token': this.token,
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        terminal_code: this.terminalCode,
                        last_synced_at: localStorage.getItem('nfc_last_catalog_sync') || null
                    })
                });
                const data = await resp.json();
                if (data.status === 'success') {
                    if (data.categories) localStorage.setItem('nfc_cached_categories', JSON.stringify(data.categories));
                    if (data.menu_items) localStorage.setItem('nfc_cached_menu_items', JSON.stringify(data.menu_items));
                    if (data.settings) localStorage.setItem('nfc_cached_settings', JSON.stringify(data.settings));
                    localStorage.setItem('nfc_last_catalog_sync', data.server_time);
                    console.log('[POS Sync] Local catalog updated with cloud snapshot.');
                }
            } catch (err) {
                console.warn('[POS Sync] Pull catalog skipped (offline or server busy):', err);
            }
        },

        showToast: function(msg) {
            const toast = document.createElement('div');
            toast.textContent = msg;
            toast.style.cssText = 'position: fixed; bottom: 20px; right: 20px; z-index: 99999; background: #059669; color: #fff; padding: 10px 18px; border-radius: 12px; font-weight: 800; font-size: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.3); transition: opacity 0.3s;';
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 3500);
        }
    };

    function triggerManualCloudSync() {
        const badge = document.getElementById('pos-sync-badge');
        POS_SYNC.updateBadge('syncing', 'SYNCING...');
        POS_SYNC.checkConnectivity().then(online => {
            if (online) {
                Promise.all([POS_SYNC.pushOfflineOrders(), POS_SYNC.pullCatalog()]).then(() => {
                    POS_SYNC.updateBadge('online', 'SYNCED');
                    setTimeout(() => POS_SYNC.updateBadge(), 2500);
                });
            } else {
                POS_SYNC.updateBadge('offline', 'OFFLINE');
                POS_SYNC.showToast('⚠️ No Cloud Connection: Offline Mode Active');
            }
        });
    }

    // Network status listeners
    window.addEventListener('online', () => {
        console.log('[POS Engine] Network restored. Triggering bidirectional sync...');
        POS_SYNC.checkConnectivity();
    });

    window.addEventListener('offline', () => {
        console.warn('[POS Engine] Network dropped. Offline mode engaged.');
        POS_SYNC.isOnline = false;
        POS_SYNC.updateBadge();
    });

    // Periodic connectivity & sync loop (every 30s)
    setInterval(() => {
        POS_SYNC.checkConnectivity();
    }, 30000);

    // Initial check on load
    document.addEventListener('DOMContentLoaded', () => {
        POS_SYNC.checkConnectivity();
        POS_SYNC.pullCatalog();
    });
</script>