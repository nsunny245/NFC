<style>
    /* =========================================================================
     * NAWABI FOOD CORNER - ROYAL ADMIN DASHBOARD FULL-SCREEN & VIBRANT STYLING
     * ========================================================================= */

    /* 1. Full-Width Screen Utilization - Zero Wasted Space on Left or Right */
    html, body {
        overflow-x: hidden !important;
    }

    .fi-layout,
    .fi-main-ctn,
    .fi-main,
    .fi-page,
    .fi-page-content,
    .fi-page-content > div,
    .fi-section-content-ctn,
    .fi-wi,
    .fi-widgets-ctn {
        max-width: 100% !important;
        width: 100% !important;
    }

    .fi-main {
        padding-left: 1rem !important;
        padding-right: 1rem !important;
        padding-top: 0.75rem !important;
        padding-bottom: 2rem !important;
    }

    @media (min-width: 1024px) {
        .fi-main {
            padding-left: 1.5rem !important;
            padding-right: 1.5rem !important;
        }
    }

    /* 2. Lift KPI boxes up & Tight Clean Header */
    .fi-page-header {
        margin-bottom: 0.5rem !important;
        padding-top: 0 !important;
        padding-bottom: 0 !important;
    }

    .fi-page-header-heading {
        font-weight: 900 !important;
        letter-spacing: -0.03em !important;
        font-size: 1.55rem !important;
        color: #0f172a !important;
    }

    .dark .fi-page-header-heading {
        color: #f8fafc !important;
    }

    .fi-widgets-ctn {
        gap: 1.15rem !important;
    }

    /* 3. Circular Sidebar Brand Logo with Gold Ring */
    .fi-sidebar-header {
        padding: 0.85rem 1.25rem !important;
    }

    .fi-sidebar-header a,
    .fi-sidebar-header .fi-logo,
    .fi-logo {
        background: transparent !important;
    }

    .fi-sidebar-header img,
    .fi-sidebar-header a img,
    .fi-logo img,
    img.fi-logo {
        border-radius: 9999px !important;
        width: 44px !important;
        height: 44px !important;
        min-width: 44px !important;
        min-height: 44px !important;
        object-fit: contain !important;
        border: 2px solid #d4a437 !important;
        padding: 1px !important;
        background: #ffffff !important;
        box-shadow: 0 4px 12px rgba(212, 164, 55, 0.4) !important;
    }

    /* 4. Pronounced, High-Contrast Colorful Action Buttons */
    .fi-btn-primary,
    .fi-ac-btn-action.fi-color-primary,
    .fi-page-actions .fi-btn-primary,
    .fi-ta-header-toolbar .fi-btn-primary {
        background: linear-gradient(135deg, #d4a437 0%, #b8861b 100%) !important;
        color: #ffffff !important;
        font-weight: 900 !important;
        border-radius: 0.75rem !important;
        box-shadow: 0 4px 14px rgba(212, 164, 55, 0.4) !important;
        border: none !important;
        transition: all 0.2s ease-in-out !important;
    }

    .fi-btn-primary:hover,
    .fi-ac-btn-action.fi-color-primary:hover,
    .fi-page-actions .fi-btn-primary:hover,
    .fi-ta-header-toolbar .fi-btn-primary:hover {
        background: linear-gradient(135deg, #e5b342 0%, #c99320 100%) !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 6px 20px rgba(212, 164, 55, 0.5) !important;
    }

    .fi-btn-color-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        color: #ffffff !important;
        font-weight: 800 !important;
        border-radius: 0.75rem !important;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3) !important;
    }

    .fi-btn-color-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
        color: #ffffff !important;
        font-weight: 800 !important;
        border-radius: 0.75rem !important;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3) !important;
    }

    .fi-btn-color-info {
        background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%) !important;
        color: #ffffff !important;
        font-weight: 800 !important;
        border-radius: 0.75rem !important;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3) !important;
    }

    /* 5. Vibrant Toggle Switches */
    input[type="checkbox"]:checked {
        background-color: #10b981 !important;
        border-color: #059669 !important;
    }

    .fi-toggle input:checked + span {
        background-color: #10b981 !important;
        box-shadow: 0 0 10px rgba(16, 185, 129, 0.4) !important;
    }

    /* 6. Chart Cards & Container Architecture */
    .fi-wi-chart,
    .fi-section {
        border-radius: 1.25rem !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 4px 14px -2px rgba(0, 0, 0, 0.05) !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease !important;
    }

    .dark .fi-wi-chart,
    .dark .fi-section {
        border-color: #334155 !important;
        box-shadow: 0 4px 18px -2px rgba(0, 0, 0, 0.35) !important;
    }

    .fi-wi-chart:hover {
        box-shadow: 0 10px 24px -4px rgba(0, 0, 0, 0.1) !important;
    }

    /* 7. Filament Navigation Active Accent */
    .fi-sidebar-item-button {
        border-radius: 0.75rem !important;
        margin: 1px 6px !important;
        transition: all 0.15s ease !important;
    }

    .fi-sidebar-item-button:hover {
        background: rgba(212, 164, 55, 0.08) !important;
    }

    .fi-sidebar-item-active .fi-sidebar-item-button {
        background: linear-gradient(90deg, rgba(212, 164, 55, 0.18) 0%, rgba(212, 164, 55, 0.04) 100%) !important;
        border-left: 4px solid #d4a437 !important;
        font-weight: 900 !important;
        color: #b45309 !important;
    }

    .dark .fi-sidebar-item-active .fi-sidebar-item-button {
        color: #fef08a !important;
    }

    .fi-sidebar-group-label {
        font-size: 0.675rem !important;
        font-weight: 900 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.08em !important;
        color: #d4a437 !important;
    }

    /* 8. Luxury Filament Table & Resource Styling across Entire System */
    .fi-ta-ctn {
        border-radius: 1.25rem !important;
        overflow: hidden !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 4px 16px -2px rgba(0, 0, 0, 0.05) !important;
    }

    .dark .fi-ta-ctn {
        border-color: #334155 !important;
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.35) !important;
    }

    .fi-ta-header-cell {
        background: #f8fafc !important;
        font-size: 0.675rem !important;
        font-weight: 900 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.06em !important;
        color: #64748b !important;
        padding-top: 0.85rem !important;
        padding-bottom: 0.85rem !important;
    }

    .dark .fi-ta-header-cell {
        background: #0f172a !important;
        color: #94a3b8 !important;
    }

    .fi-ta-row {
        transition: background-color 0.15s ease-in-out !important;
    }

    .fi-ta-row:hover {
        background-color: rgba(212, 164, 55, 0.04) !important;
    }

    .dark .fi-ta-row:hover {
        background-color: rgba(212, 164, 55, 0.08) !important;
    }

    .fi-ta-cell {
        padding-top: 0.85rem !important;
        padding-bottom: 0.85rem !important;
    }

    /* Search Input & Form Inputs */
    .fi-ta-search-input input,
    .fi-input-wrp {
        border-radius: 0.75rem !important;
        transition: border-color 0.2s ease, box-shadow 0.2s ease !important;
    }

    .fi-ta-search-input input:focus,
    .fi-input-wrp:focus-within {
        border-color: #d4a437 !important;
        box-shadow: 0 0 0 2px rgba(212, 164, 55, 0.25) !important;
    }

    /* 9. Breadcrumbs Polish */
    .fi-breadcrumbs {
        font-weight: 700 !important;
        font-size: 0.75rem !important;
        color: #64748b !important;
        padding-top: 0.25rem !important;
    }

    .fi-breadcrumbs a:hover {
        color: #d4a437 !important;
    }

    /* 10. Table Action Buttons & Badges Polish */
    .fi-ta-actions .fi-btn {
        border-radius: 0.65rem !important;
        font-size: 0.75rem !important;
        font-weight: 800 !important;
        padding: 0.35rem 0.75rem !important;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06) !important;
        transition: all 0.15s ease-in-out !important;
    }

    .fi-ta-actions .fi-btn:hover {
        transform: translateY(-1px) !important;
        box-shadow: 0 4px 10px rgba(0,0,0,0.12) !important;
    }

    .fi-badge {
        font-weight: 800 !important;
        border-radius: 9999px !important;
        padding: 0.2rem 0.65rem !important;
        letter-spacing: 0.02em !important;
        box-shadow: 0 1px 2px rgba(0,0,0,0.04) !important;
    }

    /* 11. Modal Dialog Architecture */
    .fi-modal-window {
        border-radius: 1.5rem !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 20px 45px -10px rgba(0, 0, 0, 0.25) !important;
        overflow: hidden !important;
    }

    .dark .fi-modal-window {
        border-color: #334155 !important;
        box-shadow: 0 20px 50px -10px rgba(0, 0, 0, 0.65) !important;
    }

    .fi-modal-header {
        border-bottom: 1px solid #f1f5f9 !important;
        padding: 1.25rem 1.5rem !important;
    }

    .dark .fi-modal-header {
        border-bottom-color: #1e293b !important;
    }

    .fi-modal-heading {
        font-weight: 900 !important;
        color: #0f172a !important;
    }

    .dark .fi-modal-heading {
        color: #f8fafc !important;
    }

    /* 12. Complete Dark-Mode Polish & Global Anti-Bleed Architecture */
    .dark .fi-section,
    .dark .fi-section-content-ctn,
    .dark .fi-wi,
    .dark .fi-wi-stats-overview-stat,
    .dark .fi-ta-ctn,
    .dark .fi-ta-content,
    .dark .fi-dropdown-panel,
    .dark .fi-modal-window,
    .dark .fi-modal-content {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }

    /* Prevent rogue white backgrounds in dark mode while preserving receipt paper preview */
    .dark .bg-white:not(.fi-btn-primary):not(.keep-white):not([data-keep-white]):not(.nfc-paper-ticket):not(.nfc-paper-ticket *):not(#official-thermal-print-area *):not(#admin-thermal-print-area *) {
        background-color: #1e293b !important;
        color: #f8fafc !important;
    }

    .dark .bg-gray-50:not(.keep-white):not(.nfc-paper-ticket *),
    .dark .bg-gray-100:not(.keep-white):not(.nfc-paper-ticket *),
    .dark .bg-slate-50:not(.keep-white):not(.nfc-paper-ticket *),
    .dark .bg-slate-100:not(.keep-white):not(.nfc-paper-ticket *) {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }

    .dark .bg-gray-200:not(.keep-white):not(.nfc-paper-ticket *),
    .dark .bg-slate-200:not(.keep-white):not(.nfc-paper-ticket *) {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }

    .dark .text-gray-900,
    .dark .text-slate-900 {
        color: #f8fafc !important;
    }

    .dark .text-gray-800,
    .dark .text-slate-800 {
        color: #f1f5f9 !important;
    }

    .dark .text-gray-700,
    .dark .text-slate-700 {
        color: #e2e8f0 !important;
    }

    .dark .text-gray-600,
    .dark .text-slate-600 {
        color: #cbd5e1 !important;
    }

    .dark .border-gray-100,
    .dark .border-gray-200,
    .dark .border-slate-100,
    .dark .border-slate-200 {
        border-color: #334155 !important;
    }

    /* Filament form inputs & select dropdowns in dark mode */
    .dark .fi-input-wrp {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #f8fafc !important;
    }

    .dark .fi-input-wrp input,
    .dark .fi-input-wrp select,
    .dark .fi-input-wrp textarea {
        background-color: transparent !important;
        color: #f8fafc !important;
    }

    .dark .fi-fo-field-wrp-label span {
        color: #e2e8f0 !important;
    }

    .dark .fi-tabs-item-active {
        background-color: rgba(212, 164, 55, 0.15) !important;
        color: #fef08a !important;
    }

    .dark .fi-ta-empty-state {
        background-color: #1e293b !important;
        color: #94a3b8 !important;
    }
</style>
