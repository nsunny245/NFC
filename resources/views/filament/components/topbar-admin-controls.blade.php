<div style="display: flex; align-items: center; gap: 0.65rem;" x-data="{
    isDark: document.documentElement.classList.contains('dark'),
    init() {
        const saved = localStorage.getItem('theme');
        if (saved === 'dark' || (!saved && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            this.isDark = true;
        } else if (saved === 'light') {
            document.documentElement.classList.remove('dark');
            this.isDark = false;
        }
    },
    toggle() {
        this.isDark = !this.isDark;
        if (this.isDark) {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
            localStorage.setItem('pos_theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
            localStorage.setItem('pos_theme', 'light');
        }
    }
}" x-init="init()">

    <!-- Real-Time Auto-Refresh Telemetry Heartbeat -->
    <div style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 4px 12px; border-radius: 9999px; background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.4); color: #059669; font-size: 0.65rem; font-weight: 900; letter-spacing: 0.05em;"
         class="dark:text-emerald-300 dark:border-emerald-500/40"
         title="Dashboard metrics automatically sync in real-time every 10 seconds">
        <span style="width: 7px; height: 7px; border-radius: 9999px; background: #10b981; box-shadow: 0 0 8px #10b981;"></span>
        <span style="text-transform: uppercase;">LIVE TELEMETRY (10s)</span>
    </div>

    <!-- Quick Navigation Shortcuts (Colorful, Prominent Buttons) -->
    <div style="display: flex; align-items: center; gap: 0.4rem;">
        <!-- POS Terminal -->
        <a href="{{ url('/pos') }}" target="_blank"
           style="display: inline-flex; align-items: center; gap: 0.35rem; padding: 5px 12px; border-radius: 0.75rem; background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color: #ffffff; text-decoration: none; font-size: 0.725rem; font-weight: 900; box-shadow: 0 2px 8px rgba(2, 132, 199, 0.4); transition: transform 0.15s ease;"
           onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='translateY(0)'"
           title="Open Cashier POS Financial Terminal">
            <span>🖥️</span>
            <span>POS</span>
        </a>

        <!-- Waiter Pad -->
        <a href="{{ url('/waiter') }}" target="_blank"
           style="display: inline-flex; align-items: center; gap: 0.35rem; padding: 5px 12px; border-radius: 0.75rem; background: linear-gradient(135deg, #059669 0%, #047857 100%); color: #ffffff; text-decoration: none; font-size: 0.725rem; font-weight: 900; box-shadow: 0 2px 8px rgba(5, 150, 105, 0.4); transition: transform 0.15s ease;"
           onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='translateY(0)'"
           title="Open Waiter Pad Mobile Operations">
            <span>📱</span>
            <span>Waiter</span>
        </a>

        <!-- POS Offline Apps -->
        <a href="{{ url('/admin/pos-app-downloads') }}"
           style="display: inline-flex; align-items: center; gap: 0.35rem; padding: 5px 12px; border-radius: 0.75rem; background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%); color: #ffffff; text-decoration: none; font-size: 0.725rem; font-weight: 900; box-shadow: 0 2px 8px rgba(124, 58, 237, 0.4); transition: transform 0.15s ease;"
           onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='translateY(0)'"
           title="Download Standalone POS Apps (.exe / .dmg)">
            <span>📦</span>
            <span>Apps</span>
        </a>
    </div>

    <!-- Light / Dark Theme Mode Switcher Toggle Button -->
    <button type="button"
            @click="toggle()"
            style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 5px 12px; border-radius: 0.75rem; border: 1.5px solid #d4a437; background: #ffffff; color: #0f172a; font-size: 0.725rem; font-weight: 900; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08); cursor: pointer; transition: all 0.2s ease;"
            class="dark:!bg-slate-800 dark:!text-white dark:!border-amber-400"
            title="Toggle Light or Dark Dashboard Theme">
        <span x-text="isDark ? '☀️' : '🌙'" style="font-size: 0.85rem;"></span>
        <span x-text="isDark ? 'LIGHT' : 'DARK'" style="letter-spacing: 0.05em; font-weight: 900;"></span>
    </button>

</div>
