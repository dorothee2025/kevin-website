// Registers service worker, requests notification permission and tries to subscribe for push (if VAPID key provided)
(function(){
  if (!('serviceWorker' in navigator)) return;

  const PUBLIC_VAPID_KEY = '<YOUR_VAPID_PUBLIC_KEY_HERE>'; // replace with your VAPID public key

  async function registerSW(){
    try{
      const reg = await navigator.serviceWorker.register('service-worker.js');
      console.log('ServiceWorker registered', reg);

      // Listen for updates
      reg.addEventListener('updatefound', ()=> console.log('SW update found'));

      // Optionally request push permission and subscribe
      if ('PushManager' in window && PUBLIC_VAPID_KEY && PUBLIC_VAPID_KEY.indexOf('<')===-1) {
        const perm = await Notification.requestPermission();
        if (perm === 'granted') {
          const sub = await reg.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: urlBase64ToUint8Array(PUBLIC_VAPID_KEY)
          });
          console.log('Push subscribed:', sub);
          // send subscription to server endpoint to save
          fetch('/subscribe', { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify(sub) }).catch(()=>{});
        }
      }
    }catch(e){ console.warn('SW registration failed', e); }
  }

  // utility
  function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
    const rawData = atob(base64);
    const outputArray = new Uint8Array(rawData.length);
    for (let i = 0; i < rawData.length; ++i) outputArray[i] = rawData.charCodeAt(i);
    return outputArray;
  }

  if (document.readyState !== 'loading') registerSW(); else document.addEventListener('DOMContentLoaded', registerSW);
})();
