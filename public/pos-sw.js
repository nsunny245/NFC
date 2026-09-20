/**
 * Nawabi Food Corner POS - Offline Service Worker (v1.0)
 * Provides offline application caching and network resilience for POS terminals.
 */

const CACHE_NAME = 'nfc-pos-cache-v1';
const PRECACHE_URLS = [
    '/pos',
    '/pos-manifest.json',
    '/images/logo_circular.png',
    '/favicon.ico'
];

// Install event - precache core shell
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            console.log('[POS-SW] Precaching app shell and offline core');
            return cache.addAll(PRECACHE_URLS).catch((err) => {
                console.warn('[POS-SW] Precache non-critical failure:', err);
            });
        }).then(() => self.skipWaiting())
    );
});

// Activate event - purge old caches
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((name) => {
                    if (name !== CACHE_NAME) {
                        console.log('[POS-SW] Purging outdated cache:', name);
                        return caches.delete(name);
                    }
                })
            );
        }).then(() => self.clients.claim())
    );
});

// Fetch event - Network-first with cache fallback for pages, Cache-first for assets
self.addEventListener('fetch', (event) => {
    const url = new URL(event.request.url);

    // Bypass API sync endpoints (handled by application sync engine)
    if (url.pathname.startsWith('/api/pos/sync')) {
        return;
    }

    // Navigation requests (HTML pages) - Network first, fall back to cached shell
    if (event.request.mode === 'navigate') {
        event.respondWith(
            fetch(event.request)
                .then((networkResponse) => {
                    if (networkResponse && networkResponse.status === 200) {
                        const copy = networkResponse.clone();
                        caches.open(CACHE_NAME).then((cache) => {
                            cache.put(event.request, copy);
                        });
                    }
                    return networkResponse;
                })
                .catch(async () => {
                    console.log('[POS-SW] Offline detected: serving cached POS shell');
                    const cachedResponse = await caches.match(event.request);
                    if (cachedResponse) {
                        return cachedResponse;
                    }
                    return caches.match('/pos');
                })
        );
        return;
    }

    // Static assets (CSS, JS, Fonts, Images) - Stale-while-revalidate
    if (
        url.pathname.match(/\.(css|js|png|jpg|jpeg|gif|svg|woff|woff2|ttf|eot|ico)$/) ||
        url.pathname.includes('/livewire/') ||
        url.pathname.includes('/filament/') ||
        url.pathname.includes('/build/')
    ) {
        event.respondWith(
            caches.match(event.request).then((cachedResponse) => {
                const fetchPromise = fetch(event.request)
                    .then((networkResponse) => {
                        if (networkResponse && networkResponse.status === 200) {
                            const copy = networkResponse.clone();
                            caches.open(CACHE_NAME).then((cache) => {
                                cache.put(event.request, copy);
                            });
                        }
                        return networkResponse;
                    })
                    .catch(() => cachedResponse);

                return cachedResponse || fetchPromise;
            })
        );
        return;
    }

    // Default network fetch
    event.respondWith(
        fetch(event.request).catch(() => caches.match(event.request))
    );
});
