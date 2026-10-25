import { chromium } from 'playwright';
const b = await chromium.launch({executablePath:'/opt/pw-browsers/chromium'}); const p = await b.newPage();
const [w, ...routes] = process.argv.slice(2);
for (const r of routes) { await p.setViewportSize({width:+w,height:900}); await p.goto('http://localhost:8901'+r);
console.log('== '+r, await p.evaluate(()=>document.documentElement.scrollHeight));
console.log((await p.evaluate(()=>[...document.querySelectorAll('main h1, main h2')].map(h=>Math.round(h.getBoundingClientRect().top+scrollY)+' '+h.tagName+' '+h.textContent.trim().slice(0,70)))).join('\n')); }
await b.close();
