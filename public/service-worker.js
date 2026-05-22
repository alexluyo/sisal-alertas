const CACHE_NAME = 'sisal-cache-v3';

const urlsToCache = [
    '/',
    '/manifest.json',
    '/icons/icon-192.png',
    '/icons/icon-512.png',
    '/firebase-messaging-sw.js'
];

self.addEventListener('install', event => {

    self.skipWaiting();

    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => cache.addAll(urlsToCache))
    );
});

self.addEventListener('activate', event => {

    event.waitUntil(
        caches.keys().then(keys => {
            return Promise.all(
                keys
                    .filter(key => key !== CACHE_NAME)
                    .map(key => caches.delete(key))
            );
        })
    );

    self.clients.claim();
});

self.addEventListener('fetch', event => {

    const requestUrl = new URL(event.request.url);

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

    event.respondWith(
        caches.match(event.request)
            .then(response => response || fetch(event.request))
    );
});