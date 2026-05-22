const CACHE_NAME = 'sisal-cache-v2';

self.addEventListener('install', event => {
    self.skipWaiting();
});

self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys => {
            return Promise.all(
                keys.map(key => caches.delete(key))
            );
        })
    );

    self.clients.claim();
});

self.addEventListener('fetch', event => {

    const requestUrl = new URL(event.request.url);

    // NO cachear rutas dinámicas Laravel
    if (
        requestUrl.pathname.startsWith('/dashboard') ||
        requestUrl.pathname.startsWith('/alertas') ||
        requestUrl.pathname.startsWith('/anexos') ||
        requestUrl.pathname.startsWith('/vecinos') ||
        requestUrl.pathname.startsWith('/admin')
    ) {
        event.respondWith(fetch(event.request));
        return;
    }

    // Cache solo para archivos estáticos
    if (
        requestUrl.pathname.startsWith('/build/') ||
        requestUrl.pathname.startsWith('/icons/') ||
        requestUrl.pathname.endsWith('.css') ||
        requestUrl.pathname.endsWith('.js') ||
        requestUrl.pathname.endsWith('.png') ||
        requestUrl.pathname.endsWith('.webp')
    ) {
        event.respondWith(
            caches.match(event.request).then(response => {
                return response || fetch(event.request);
            })
        );

        return;
    }

    event.respondWith(fetch(event.request));
});
