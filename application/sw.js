self.addEventListener("install", (event) => {
  event.waitUntil(
    caches.open("kiwanis-app-v1").then((cache) => {
      return cache.addAll([
        "/",
        "/index.html",
        "/manifest.json",
        "/images/mhklogo.png",
        "/images/web-app-manifest-192x192.png",
        "/images/web-app-manifest-512x512.png",
      ]);
    }),
  );
});

self.addEventListener("fetch", (event) => {
  event.respondWith(
    caches.match(event.request).then((response) => {
      return response || fetch(event.request);
    }),
  );
});
