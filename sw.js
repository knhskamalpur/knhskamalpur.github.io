const CACHE_NAME = "knhs-v1";
const urlsToCache = ["/", "/index.html", "/assets/css/styles.css", "/assets/images/knhs.webp", "/manifest.json"];

self.addEventListener("install", (event) => {
    self.skipWaiting(); // Activate new service worker immediately
    event.waitUntil(
        caches
            .open(CACHE_NAME)
            .then((cache) => cache.addAll(urlsToCache))
            .catch((err) => console.log("Caching failed:", err)),
    );
});

self.addEventListener("activate", (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cacheName) => {
                    if (cacheName !== CACHE_NAME) {
                        return caches.delete(cacheName);
                    }
                }),
            );
        }),
    );
});

self.addEventListener("fetch", (event) => {
    event.respondWith(
        caches
            .match(event.request)
            .then((response) => response || fetch(event.request))
            .catch(() => {
                // Fallback for offline or network errors
                if (event.request.destination === "document") {
                    return caches.match("/index.html");
                }
            }),
    );
});

self.addEventListener("push", (event) => {
    let data = { title: "New Notification", body: "Check it out!", icon: "/assets/images/knhs.webp", url: "/" };

    if (event.data) {
        data = { ...data, ...event.data.json() };
    }

    const options = {
        body: data.body,
        icon: data.icon,
        badge: "/assets/images/knhs.webp",
        vibrate: [100, 50, 100],
        data: {
            url: data.url
        }
    };

    event.waitUntil(self.registration.showNotification(data.title, options));
});

self.addEventListener("notificationclick", (event) => {
    event.notification.close();

    event.waitUntil(
        clients.matchAll({ type: "window", includeUncontrolled: true }).then((clientList) => {
            if (clientList.length > 0) {
                let client = clientList[0];
                for (let i = 0; i < clientList.length; i++) {
                    if (clientList[i].focused) {
                        client = clientList[i];
                    }
                }
                return client.focus();
            }
            return clients.openWindow(event.notification.data.url);
        })
    );
});
