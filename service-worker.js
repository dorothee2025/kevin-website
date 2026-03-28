const CACHE_NAME = 'csdream-shell-v1';
const RUNTIME_CACHE = 'csdream-runtime-v1';

// Files to precache (shell)
const PRECACHE_URLS = [
  './',
  './home.html',
  './styles.css',
  './clock.js',
  './manifest.json'
];

self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME).then(cache => cache.addAll(PRECACHE_URLS)).then(() => self.skipWaiting())
  );
});

self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(keys => Promise.all(
      keys.map(k => { if (k !== CACHE_NAME && k !== RUNTIME_CACHE) return caches.delete(k); })
    )).then(() => self.clients.claim())
  );
});

self.addEventListener('fetch', event => {
  const request = event.request;

  // Navigation requests -> serve shell
  if (request.mode === 'navigate') {
    event.respondWith(
      caches.match('/home.html').then(resp => resp || fetch(request).catch(()=>caches.match('./')))
    );
    return;
  }

  // Runtime cache for images/videos/fonts
  if (request.destination === 'image' || request.destination === 'video' || request.destination === 'font') {
    event.respondWith(
      caches.open(RUNTIME_CACHE).then(cache =>
        cache.match(request).then(cached => cached || fetch(request).then(resp => { cache.put(request, resp.clone()); return resp; }).catch(()=>cached))
      )
    );
    return;
  }

  // Default: cache first then network
  event.respondWith(caches.match(request).then(cached => cached || fetch(request)));
});

self.addEventListener('push', event => {
  let data = { title: 'CS DREAM', body: 'New update available', url: '/' };
  try { data = event.data.json(); } catch (e) {}

  const options = {
    body: data.body,
    icon: 'images/icon-192.png',
    badge: 'images/icon-192.png',
    data: { url: data.url }
  };

  event.waitUntil(self.registration.showNotification(data.title, options));
});

self.addEventListener('notificationclick', event => {
  event.notification.close();
  const url = event.notification.data && event.notification.data.url ? event.notification.data.url : '/';
  event.waitUntil(clients.matchAll({ type: 'window' }).then(windowClients => {
    for (let client of windowClients) {
      if (client.url === url && 'focus' in client) return client.focus();
    }
    if (clients.openWindow) return clients.openWindow(url);
  }));
});
