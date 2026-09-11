<x-filament-panels::page>
    <style>
        /* =========================================================================
         * NAWABI FOOD CORNER - STANDALONE POS APPS & OFFLINE HUB STYLING
         * Scoped CSS Architecture: 100% immune to missing Tailwind purge classes
         * ========================================================================= */

        .nfc-downloads-container {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            width: 100%;
            font-family: inherit;
        }

        /* 1. Hero Banner */
        .nfc-hero-banner {
            position: relative;
            overflow: hidden;
            border-radius: 1.5rem;
            padding: 1.75rem 2rem;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 55%, #2a1f0a 100%);
            border: 1.5px solid rgba(212, 164, 55, 0.45);
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.3);
            color: #ffffff !important;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .nfc-hero-title {
            font-size: 1.75rem;
            font-weight: 900;
            letter-spacing: -0.03em;
            color: #ffffff !important;
            margin: 0.35rem 0;
            line-height: 1.2;
        }

        .nfc-hero-desc {
            font-size: 0.85rem;
            color: #cbd5e1 !important;
            max-width: 650px;
            line-height: 1.5;
            margin: 0;
        }

        .nfc-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 4px 12px;
            border-radius: 9999px;
            background: rgba(212, 164, 55, 0.2);
            border: 1px solid rgba(212, 164, 55, 0.5);
            color: #fef08a !important;
            font-size: 0.7rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .nfc-sync-chip {
            padding: 0.75rem 1.25rem;
            border-radius: 1rem;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        /* 2. Download Cards 3-Column Grid */
        .nfc-apps-grid {
            display: grid !important;
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
            gap: 1.5rem !important;
            width: 100% !important;
        }

        @media (max-width: 1024px) {
            .nfc-apps-grid {
                grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
            }
        }

        /* App Card */
        .nfc-app-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1.5rem;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.06);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        }

        .dark .nfc-app-card {
            background: #1e293b;
            border-color: #334155;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.35);
        }

        .nfc-app-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 32px -4px rgba(0, 0, 0, 0.12);
        }

        .dark .nfc-app-card:hover {
            box-shadow: 0 16px 36px -4px rgba(0, 0, 0, 0.45);
        }

        .nfc-app-card-body {
            padding: 1.75rem;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .nfc-app-card-footer {
            padding: 1.25rem 1.75rem;
            background: #f8fafc;
            border-top: 1px solid #f1f5f9;
            display: flex;
            flex-direction: column;
            gap: 0.65rem;
        }

        .dark .nfc-app-card-footer {
            background: #0f172a;
            border-top-color: #334155;
        }

        /* Platform Icon Boxes */
        .nfc-icon-win {
            width: 3.5rem;
            height: 3.5rem;
            border-radius: 1rem;
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff !important;
            box-shadow: 0 6px 16px rgba(2, 132, 199, 0.35);
        }

        .nfc-icon-mac {
            width: 3.5rem;
            height: 3.5rem;
            border-radius: 1rem;
            background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff !important;
            box-shadow: 0 6px 16px rgba(124, 58, 237, 0.35);
        }

        .nfc-icon-web {
            width: 3.5rem;
            height: 3.5rem;
            border-radius: 1rem;
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff !important;
            box-shadow: 0 6px 16px rgba(5, 150, 105, 0.35);
        }

        /* Typography Inside Cards */
        .nfc-app-title {
            font-size: 1.3rem;
            font-weight: 900;
            letter-spacing: -0.02em;
            color: #0f172a;
            margin: 0;
        }

        .dark .nfc-app-title {
            color: #f8fafc;
        }

        .nfc-app-sub {
            font-size: 0.75rem;
            color: #64748b;
            margin-top: 0.25rem;
        }

        .dark .nfc-app-sub {
            color: #94a3b8;
        }

        /* Feature Checklist */
        .nfc-checklist {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 0.65rem;
        }

        .nfc-check-item {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            font-size: 0.775rem;
            color: #334155;
            font-weight: 600;
        }

        .dark .nfc-check-item {
            color: #cbd5e1;
        }

        .nfc-check-bullet {
            width: 1.15rem;
            height: 1.15rem;
            border-radius: 9999px;
            background: #dcfce7;
            color: #15803d;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.65rem;
            font-weight: 900;
            flex-shrink: 0;
        }

        .dark .nfc-check-bullet {
            background: rgba(22, 101, 52, 0.3);
            color: #4ade80;
        }

        /* 3-Step Setup Box */
        .nfc-setup-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            padding: 0.85rem 1rem;
            font-size: 0.725rem;
            color: #475569;
            line-height: 1.5;
        }

        .dark .nfc-setup-box {
            background: rgba(15, 23, 42, 0.5);
            border-color: #334155;
            color: #94a3b8;
        }

        .nfc-setup-box b {
            color: #0f172a;
        }

        .dark .nfc-setup-box b {
            color: #f8fafc;
        }

        /* Primary Download Action Buttons */
        .nfc-btn-win {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.85rem 1.25rem;
            border-radius: 1rem;
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            color: #ffffff !important;
            font-size: 0.85rem;
            font-weight: 900;
            text-decoration: none !important;
            box-shadow: 0 4px 14px rgba(2, 132, 199, 0.4);
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .nfc-btn-win:hover {
            background: linear-gradient(135deg, #0369a1 0%, #075985 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(2, 132, 199, 0.5);
        }

        .nfc-btn-mac {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.85rem 1.25rem;
            border-radius: 1rem;
            background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
            color: #ffffff !important;
            font-size: 0.85rem;
            font-weight: 900;
            text-decoration: none !important;
            box-shadow: 0 4px 14px rgba(124, 58, 237, 0.4);
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .nfc-btn-mac:hover {
            background: linear-gradient(135deg, #6d28d9 0%, #5b21b6 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(124, 58, 237, 0.5);
        }

        .nfc-btn-web {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.85rem 1.25rem;
            border-radius: 1rem;
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: #ffffff !important;
            font-size: 0.85rem;
            font-weight: 900;
            text-decoration: none !important;
            box-shadow: 0 4px 14px rgba(5, 150, 105, 0.4);
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .nfc-btn-web:hover {
            background: linear-gradient(135deg, #047857 0%, #065f46 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(5, 150, 105, 0.5);
        }

        /* Secondary Action Links */
        .nfc-btn-secondary {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 0.45rem;
            font-size: 0.725rem;
            font-weight: 700;
            color: #64748b !important;
            text-decoration: none !important;
            transition: color 0.2s ease;
        }

        .dark .nfc-btn-secondary {
            color: #94a3b8 !important;
        }

        .nfc-btn-secondary:hover {
            color: #0284c7 !important;
        }

        /* 3. Terminal & Machine Tokens Box */
        .nfc-tokens-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1.5rem;
            padding: 1.75rem 2rem;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .dark .nfc-tokens-card {
            background: #1e293b;
            border-color: #334155;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.35);
        }

        .nfc-token-field {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            padding: 0.85rem 1.15rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .dark .nfc-token-field {
            background: #0f172a;
            border-color: #334155;
        }

        .nfc-copy-btn {
            padding: 0.4rem 0.9rem;
            border-radius: 0.65rem;
            background: #e2e8f0;
            border: 1px solid #cbd5e1;
            color: #334155;
            font-size: 0.725rem;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .dark .nfc-copy-btn {
            background: #334155;
            border-color: #475569;
            color: #f8fafc;
        }

        .nfc-copy-btn:hover {
            background: #cbd5e1;
            color: #0f172a;
        }

        .dark .nfc-copy-btn:hover {
            background: #475569;
            color: #ffffff;
        }

        .nfc-term-th {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }
        .dark .nfc-term-th {
            background: #0f172a !important;
            border-bottom-color: #334155 !important;
        }

        .nfc-token-code {
            background: #f1f5f9;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.65rem;
            color: #475569;
        }
        .dark .nfc-token-code {
            background: #0f172a !important;
            color: #cbd5e1 !important;
            border: 1px solid #334155;
        }
    </style>

    <div class="nfc-downloads-container">

        <!-- Top Hero Banner -->
        <div class="nfc-hero-banner">
            <div style="display: flex; align-items: center; gap: 1.25rem;">
                <div style="width: 4.25rem; height: 4.25rem; border-radius: 9999px; border: 2.5px solid #d4a437; background: #ffffff; padding: 2px; overflow: hidden; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 16px rgba(212, 164, 55, 0.4); flex-shrink: 0;">
                    <img src="{{ asset('images/logo_circular.png') }}" alt="NFC Logo" style="width: 100%; height: 100%; object-fit: cover; border-radius: 9999px;">
                </div>
                <div>
                    <div class="nfc-hero-badge">
                        <span>🚀 Easy 1-Click Install • Zero Terminal Commands</span>
                    </div>
                    <h2 class="nfc-hero-title">
                        Standalone POS & Waiter Apps
                    </h2>
                    <p class="nfc-hero-desc">
                        Pre-packaged desktop installers for cashiers and counter touchscreen registers. Cashiers can continue billing, taking orders, and printing thermal receipts even during total internet dropouts.
                    </p>
                </div>
            </div>

            <div class="nfc-sync-chip">
                <span style="width: 10px; height: 10px; border-radius: 9999px; background: #34d399; box-shadow: 0 0 10px #34d399; display: inline-block;"></span>
                <div>
                    <div style="font-size: 0.65rem; font-weight: 800; text-transform: uppercase; color: #cbd5e1; letter-spacing: 0.05em;">Cloud Sync Hub</div>
                    <div style="font-size: 0.8rem; font-weight: 900; color: #6ee7b7;">ONLINE & REAL-TIME SYNC</div>
                </div>
            </div>
        </div>

        <!-- 3-Column Download Cards Grid -->
        <div class="nfc-apps-grid">

            <!-- CARD 1: Windows PC Terminal Edition -->
            <div class="nfc-app-card">
                <div class="nfc-app-card-body">
                    <!-- Top Icon & Badge -->
                    <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 0.75rem;">
                        <div class="nfc-icon-win">
                            <svg style="width: 1.85rem; height: 1.85rem;" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M0 3.449L9.75 2.1v9.451H0m10.949-9.602L24 0v11.4H10.949M0 12.6h9.75v9.451L0 20.699M10.949 12.6H24V24l-12.951-1.801"/>
                            </svg>
                        </div>
                        <span style="padding: 4px 10px; border-radius: 9999px; background: rgba(2, 132, 199, 0.15); border: 1px solid rgba(2, 132, 199, 0.35); color: #0284c7; font-size: 0.675rem; font-weight: 900; text-transform: uppercase;">
                            Recommended
                        </span>
                    </div>

                    <!-- Title & Subtitle -->
                    <div>
                        <h3 class="nfc-app-title">Windows POS Terminal</h3>
                        <p class="nfc-app-sub">For Windows 10 & 11 Touchscreen Registers</p>
                    </div>

                    <!-- Feature Checklist -->
                    <ul class="nfc-checklist">
                        <li class="nfc-check-item">
                            <span class="nfc-check-bullet">✓</span>
                            <span>Direct Thermal Receipt Printing (USB / COM)</span>
                        </li>
                        <li class="nfc-check-item">
                            <span class="nfc-check-bullet">✓</span>
                            <span>100% Offline order taking & shift balance</span>
                        </li>
                        <li class="nfc-check-item">
                            <span class="nfc-check-bullet">✓</span>
                            <span>Auto Cloud Sync when internet restores</span>
                        </li>
                        <li class="nfc-check-item">
                            <span class="nfc-check-bullet">✓</span>
                            <span>Touchscreen Kiosk Fullscreen Mode</span>
                        </li>
                    </ul>

                    <!-- 3-Step Guide -->
                    <div class="nfc-setup-box">
                        <div style="font-weight: 800; margin-bottom: 0.25rem;">Easy Setup (30 Seconds):</div>
                        <div>1. Click <b>Download .exe</b> below.</div>
                        <div>2. Double-click the downloaded file to install.</div>
                        <div>3. Enter terminal code (e.g. <b>POS-01</b>) and start billing!</div>
                    </div>
                </div>

                <!-- Footer Action Buttons -->
                <div class="nfc-app-card-footer">
                    <a href="{{ route('pos.app.download', ['platform' => 'exe']) }}" class="nfc-btn-win">
                        <svg style="width: 1.15rem; height: 1.15rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span>Download Windows App (.exe)</span>
                    </a>

                    <a href="{{ route('pos.app.download', ['platform' => 'windows-zip']) }}" class="nfc-btn-secondary">
                        <span>📦 Download Portable .zip (No installation)</span>
                    </a>
                </div>
            </div>

            <!-- CARD 2: Apple macOS Edition -->
            <div class="nfc-app-card">
                <div class="nfc-app-card-body">
                    <!-- Top Icon & Badge -->
                    <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 0.75rem;">
                        <div class="nfc-icon-mac">
                            <svg style="width: 1.85rem; height: 1.85rem;" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M15.97 6.37c.62-.75 1.04-1.8 0.93-2.85-.9.04-2 .6-2.64 1.35-.57.65-1.06 1.72-.93 2.74 1.01.08 2.03-.5 2.64-1.24z"/>
                            </svg>
                        </div>
                        <span style="padding: 4px 10px; border-radius: 9999px; background: rgba(124, 58, 237, 0.15); border: 1px solid rgba(124, 58, 237, 0.35); color: #7c3aed; font-size: 0.675rem; font-weight: 900; text-transform: uppercase;">
                            Universal Build
                        </span>
                    </div>

                    <!-- Title & Subtitle -->
                    <div>
                        <h3 class="nfc-app-title">Apple macOS POS App</h3>
                        <p class="nfc-app-sub">For MacBook, Mac Mini & iMac Cashier Stations</p>
                    </div>

                    <!-- Feature Checklist -->
                    <ul class="nfc-checklist">
                        <li class="nfc-check-item">
                            <span class="nfc-check-bullet">✓</span>
                            <span>Apple Silicon (M1/M2/M3/M4) & Intel native</span>
                        </li>
                        <li class="nfc-check-item">
                            <span class="nfc-check-bullet">✓</span>
                            <span>Dedicated Standalone POS Cashier Window</span>
                        </li>
                        <li class="nfc-check-item">
                            <span class="nfc-check-bullet">✓</span>
                            <span>Zero-configuration thermal printer support</span>
                        </li>
                        <li class="nfc-check-item">
                            <span class="nfc-check-bullet">✓</span>
                            <span>Sandboxed high-security cashier session</span>
                        </li>
                    </ul>

                    <!-- 3-Step Guide -->
                    <div class="nfc-setup-box">
                        <div style="font-weight: 800; margin-bottom: 0.25rem;">Easy Setup (3 Steps):</div>
                        <div>1. Click <b>Download .dmg</b> below.</div>
                        <div>2. Open disk image & drag to <b>Applications</b>.</div>
                        <div>3. Launch from Launchpad and start billing!</div>
                    </div>
                </div>

                <!-- Footer Action Buttons -->
                <div class="nfc-app-card-footer">
                    <a href="{{ route('pos.app.download', ['platform' => 'dmg']) }}" class="nfc-btn-mac">
                        <svg style="width: 1.15rem; height: 1.15rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span>Download macOS App (.dmg)</span>
                    </a>

                    <div class="nfc-btn-secondary" style="cursor: default;">
                        <span>Works on macOS Monterey, Ventura, Sonoma & Sequoia</span>
                    </div>
                </div>
            </div>

            <!-- CARD 3: Waiter Pad Mobile Web App -->
            <div class="nfc-app-card">
                <div class="nfc-app-card-body">
                    <!-- Top Icon & Badge -->
                    <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 0.75rem;">
                        <div class="nfc-icon-web">
                            <svg style="width: 1.85rem; height: 1.85rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span style="padding: 4px 10px; border-radius: 9999px; background: rgba(5, 150, 105, 0.15); border: 1px solid rgba(5, 150, 105, 0.35); color: #059669; font-size: 0.675rem; font-weight: 900; text-transform: uppercase;">
                            Mobile Ready
                        </span>
                    </div>

                    <!-- Title & Subtitle -->
                    <div>
                        <h3 class="nfc-app-title">Waiter Pad Mobile App</h3>
                        <p class="nfc-app-sub">For Android Phones, Tablets, iPhones & iPads</p>
                    </div>

                    <!-- Feature Checklist -->
                    <ul class="nfc-checklist">
                        <li class="nfc-check-item">
                            <span class="nfc-check-bullet">✓</span>
                            <span>Instant table order taking & kitchen KOT dispatch</span>
                        </li>
                        <li class="nfc-check-item">
                            <span class="nfc-check-bullet">✓</span>
                            <span>Audio chime alerts when dishes are ready</span>
                        </li>
                        <li class="nfc-check-item">
                            <span class="nfc-check-bullet">✓</span>
                            <span>Runs on 4G/5G mobile internet or restaurant Wi-Fi</span>
                        </li>
                        <li class="nfc-check-item">
                            <span class="nfc-check-bullet">✓</span>
                            <span>Zero App Store downloads — tap "Add to Home Screen"</span>
                        </li>
                    </ul>

                    <!-- 2-Step Guide -->
                    <div class="nfc-setup-box">
                        <div style="font-weight: 800; margin-bottom: 0.25rem;">How Waiters Install:</div>
                        <div>1. Open <b>/waiter/login</b> on phone browser.</div>
                        <div>2. In browser menu, tap <b>"Add to Home Screen"</b>.</div>
                        <div>3. Waiter Pad icon appears like a native app!</div>
                    </div>
                </div>

                <!-- Footer Action Buttons -->
                <div class="nfc-app-card-footer">
                    <a href="{{ url('/waiter/login') }}" target="_blank" class="nfc-btn-web">
                        <svg style="width: 1.15rem; height: 1.15rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        <span>Launch Waiter Pad Online</span>
                    </a>

                    <div class="nfc-btn-secondary" style="cursor: default;">
                        <span>PWA Progressive Web App enabled</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Terminal & Cloud Connection Parameters -->
        <div class="nfc-tokens-card">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.75rem; border-bottom: 1px solid #f1f5f9; padding-bottom: 1rem;" class="dark:border-slate-800">
                <div>
                    <h3 style="font-size: 1.1rem; font-weight: 900; margin: 0; display: flex; align-items: center; gap: 0.5rem;" class="text-slate-900 dark:text-white">
                        <span>⚙️ Terminal Connection & Machine Tokens</span>
                    </h3>
                    <p style="font-size: 0.75rem; color: #64748b; margin-top: 0.25rem;" class="dark:text-slate-400">
                        These parameters are automatically pre-configured. Use these if you need to connect an external hardware register.
                    </p>
                </div>
                <a href="{{ url('/admin/users') }}" style="font-size: 0.75rem; font-weight: 800; color: #d97706; text-decoration: none;" class="hover:underline">
                    Manage Cashiers & Terminals in Back Office →
                </a>
            </div>

            <!-- Server Sync URLs -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1rem;">
                <div class="nfc-token-field">
                    <div>
                        <div style="font-size: 0.65rem; font-weight: 800; text-transform: uppercase; color: #64748b; letter-spacing: 0.05em;">Restaurant Server Base URL</div>
                        <div style="font-family: monospace; font-size: 0.825rem; font-weight: 800; color: #0f172a; margin-top: 0.25rem;" class="dark:text-white">{{ $serverUrl }}</div>
                    </div>
                    <button type="button"
                            onclick="navigator.clipboard.writeText('{{ $serverUrl }}'); alert('Server URL copied to clipboard!');"
                            class="nfc-copy-btn">
                        Copy
                    </button>
                </div>

                <div class="nfc-token-field">
                    <div>
                        <div style="font-size: 0.65rem; font-weight: 800; text-transform: uppercase; color: #64748b; letter-spacing: 0.05em;">POS Cloud Sync API Endpoint</div>
                        <div style="font-family: monospace; font-size: 0.825rem; font-weight: 800; color: #0f172a; margin-top: 0.25rem;" class="dark:text-white">{{ $apiSyncUrl }}</div>
                    </div>
                    <button type="button"
                            onclick="navigator.clipboard.writeText('{{ $apiSyncUrl }}'); alert('Sync Endpoint copied to clipboard!');"
                            class="nfc-copy-btn">
                        Copy
                    </button>
                </div>
            </div>

            <!-- Terminals Table -->
            <div style="overflow-x: auto; border: 1px solid #e2e8f0; border-radius: 1rem;" class="dark:border-slate-800">
                <table style="width: 100%; text-align: left; border-collapse: collapse; font-size: 0.75rem;">
                    <thead>
                        <tr class="nfc-term-th">
                            <th style="padding: 0.75rem 1rem; font-weight: 800; text-transform: uppercase; font-size: 0.65rem; color: #64748b;">Staff / Terminal</th>
                            <th style="padding: 0.75rem 1rem; font-weight: 800; text-transform: uppercase; font-size: 0.65rem; color: #64748b;">Role</th>
                            <th style="padding: 0.75rem 1rem; font-weight: 800; text-transform: uppercase; font-size: 0.65rem; color: #64748b;">Terminal Code</th>
                            <th style="padding: 0.75rem 1rem; font-weight: 800; text-transform: uppercase; font-size: 0.65rem; color: #64748b;">Quick PIN</th>
                            <th style="padding: 0.75rem 1rem; font-weight: 800; text-transform: uppercase; font-size: 0.65rem; color: #64748b;">Sync Token</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($terminals as $term)
                            <tr style="border-bottom: 1px solid #f1f5f9;" class="dark:!border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/50">
                                <td style="padding: 0.75rem 1rem; font-weight: 800;" class="text-slate-900 dark:text-white">
                                    {{ $term['name'] }}
                                    <div style="font-size: 0.675rem; color: #94a3b8; font-weight: normal;">{{ $term['email'] }}</div>
                                </td>
                                <td style="padding: 0.75rem 1rem;">
                                    <span style="padding: 2px 8px; border-radius: 9999px; font-size: 0.65rem; font-weight: 900; text-transform: uppercase; {{ $term['role'] === 'cashier' ? 'background: rgba(30, 64, 175, 0.2); color: #60a5fa;' : 'background: rgba(22, 101, 52, 0.2); color: #4ade80;' }}">
                                        {{ $term['role'] }}
                                    </span>
                                </td>
                                <td style="padding: 0.75rem 1rem; font-family: monospace; font-weight: 800; color: #d97706;">
                                    {{ $term['terminal_code'] ?? 'POS-01' }}
                                </td>
                                <td style="padding: 0.75rem 1rem; font-family: monospace; font-weight: 800;">
                                    {{ $term['pin'] ? '•••• (Configured)' : 'Not Set' }}
                                </td>
                                <td style="padding: 0.75rem 1rem;">
                                    @if(!empty($term['api_token']))
                                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                                            <code class="nfc-token-code">
                                                {{ substr($term['api_token'], 0, 10) }}...
                                            </code>
                                            <button type="button"
                                                    onclick="navigator.clipboard.writeText('{{ $term['api_token'] }}'); alert('Token copied!');"
                                                    style="background: none; border: none; font-size: 0.7rem; color: #0284c7; font-weight: 800; cursor: pointer; text-decoration: underline;">
                                                Copy
                                            </button>
                                        </div>
                                    @else
                                        <span style="color: #94a3b8; font-style: italic;">None</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="padding: 1.5rem; text-align: center; color: #94a3b8;">
                                    No terminals configured.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-filament-panels::page>
