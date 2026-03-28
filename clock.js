(function(){
  // place clock near the left-side navigation area (top-left)
  const css = `#site-clock{position:fixed;top:12px;left:12px;background:rgba(0,0,0,0.5);color:#fff;padding:6px 10px;border-radius:8px;font-family:Segoe UI, Arial, sans-serif;font-size:13px;z-index:99999;backdrop-filter:blur(6px);box-shadow:0 6px 20px rgba(0,0,0,0.4)}@media (max-width:420px){#site-clock{font-size:12px;left:8px;top:8px;padding:5px 8px}}`;
  const style = document.createElement('style'); style.textContent = css; document.head.appendChild(style);

  const el = document.createElement('div'); el.id = 'site-clock'; el.setAttribute('role','status'); el.setAttribute('aria-live','polite');
  document.addEventListener('DOMContentLoaded', function(){ document.body.appendChild(el); });

  function two(n){ return n<10? '0'+n : n; }
  function update(){
    const d = new Date();
    const hh = two(d.getHours());
    const mm = two(d.getMinutes());
    const ss = two(d.getSeconds());
    el.textContent = hh + ':' + mm + ':' + ss;
  }

  if (document.readyState !== 'loading') document.body.appendChild(el);
  update();
  setInterval(update, 1000);
})();
