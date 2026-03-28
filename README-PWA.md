PWA scaffold for CS DREAM

What I added
- `manifest.json` — app metadata and icons
- `service-worker.js` — precache shell, runtime caching, push & notification handlers
- `sw-register.js` — registers SW and optionally subscribes for push (replace VAPID key)
- `push-server-example.js` — Node example to accept subscriptions and send push (requires `web-push`)

Quick setup
1. Add icons at `images/icon-192.png` and `images/icon-512.png`.
2. Update `sw-register.js` with your VAPID public key.
3. (Optional push) Generate VAPID keys:

```bash
npm install -g web-push
web-push generate-vapid-keys
```

4. Run example server (optional):

```bash
npm install express body-parser web-push
node push-server-example.js
```

5. Serve the site over HTTPS (required for push) — for local dev use `localhost` or `mkcert`.
