<!-- PWA Meta Tags & Service Worker for Nawabi Food Corner POS -->
<link rel="manifest" href="{{ asset('pos-manifest.json') }}">
<meta name="theme-color" content="#d4a437">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="Nawabi POS">
<link rel="apple-touch-icon" href="{{ asset('images/logo_circular.png') }}">

<script>
    // Service Worker Registration for Offline Terminal
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/pos-sw.js')
                .then(reg => {
                    console.log('[POS-PWA] Service Worker registered with scope:', reg.scope);
                })
                .catch(err => {
                    console.warn('[POS-PWA] Service Worker registration failed:', err);
                });
        });
    }

    // PWA Install Prompt Handler
    window.deferredPwaPrompt = null;
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        window.deferredPwaPrompt = e;
        console.log('[POS-PWA] App install prompt captured.');
        
        // Expose event to UI
        const installBtn = document.getElementById('pwa-install-btn');
        if (installBtn) {
            installBtn.style.display = 'inline-flex';
        }
    });

    window.addEventListener('appinstalled', () => {
        window.deferredPwaPrompt = null;
        console.log('[POS-PWA] Nawabi POS installed successfully.');
        const installBtn = document.getElementById('pwa-install-btn');
        if (installBtn) {
            installBtn.style.display = 'none';
        }
    });

    function triggerPwaInstall() {
        if (window.deferredPwaPrompt) {
            window.deferredPwaPrompt.prompt();
            window.deferredPwaPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === 'accepted') {
                    console.log('[POS-PWA] Cashier accepted PWA install');
                }
                window.deferredPwaPrompt = null;
            });
        } else {
            alert('To install Nawabi POS on your Desktop / Mac:\n\n1. In Chrome / Edge: Click the "Install" icon (⬇ or 💻) on the right side of the address bar.\n2. In Safari (Mac): Click File -> Add to Dock.\n\nOnce installed, you can launch Nawabi POS directly from your Desktop anytime, even offline!');
        }
    }
</script>
