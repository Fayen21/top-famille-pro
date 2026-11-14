import { chromium } from '@playwright/test';
const b = await chromium.launch({executablePath:'/opt/pw-browsers/chromium'}); const p = await b.newPage();
for (const r of process.argv.slice(2)) { await p.setViewportSize({width:375,height:800}); await p.goto('http://localhost:8901'+r);
const res = await p.evaluate(()=>{ const main=document.querySelector('main'); const secs=[...main.querySelectorAll(':scope > section, :scope > div > section, :scope > article, main section')].filter((s,i,a)=>!a.some(o=>o!==s&&o.contains(s)));
 return {total: main.innerText.split(/\s+/).length, h: document.documentElement.scrollHeight, secs: secs.map(s=>({h2:(s.querySelector('h2')||{}).textContent?.trim().slice(0,60), mots:s.innerText.split(/\s+/).length, haut:Math.round(s.getBoundingClientRect().height), classe:s.className.slice(0,40)}))};});
 console.log('== '+r, res.total, 'mots', res.h, 'px'); for (const s of res.secs) console.log(String(s.mots).padStart(5), String(s.haut).padStart(5), s.h2, '|', s.classe); }
await b.close();
