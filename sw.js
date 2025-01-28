const CACHE_NAME = 'fepacoc-v1';
const ASSETS = [
  '/',
  '/index.html',
  '/vendor/css/style.css',
  '/vendor/js/script.js',
  '/vendor/images/icone.png',
  '/vendor/img/logo_escuro.png',
  '/vendor/img/capa-membros.png',
  '/vendor/img/capa-mobile-membros.png'
];

// Instala o Service Worker e faz cache dos recursos
self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      return cache.addAll(ASSETS);
    })
  );
});

// Intercepta as requisições e serve do cache
self.addEventListener('fetch', (event) => {
  event.respondWith(
    caches.match(event.request).then((response) => {
      return response || fetch(event.request);
    })
  );
});

// Limpa caches antigos
self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames.map((cache) => {
          if (cache !== CACHE_NAME) {
            return caches.delete(cache);
          }
        })
      );
    })
  );
});