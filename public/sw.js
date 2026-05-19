const CACHE_NAME = 'ravion-cache-v1';
const urlsToCache = [
    '/engineer-form',
    'https://cdn.tailwindcss.com'
];

// Install the service worker and cache baseline assets
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => {
            return cache.addAll(urlsToCache);
        })
    );
});

// Cache-first strategy for rapid mobile loading
self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request).then(response => {
            return response || fetch(event.request);
        })
    );
});