const t = document.getElementById('theme');
if (t) t.onclick = () => { const n = document.documentElement.dataset.theme === 'dark' ? 'light' : 'dark'; document.documentElement.dataset.theme = n; localStorage.setItem('theme', n); };
const pm = document.getElementById('pm'), mo = document.getElementById('momo');
if (pm) { const f = () => mo.hidden = pm.value === 'cash'; pm.onchange = f; f(); }
