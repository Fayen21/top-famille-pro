import { chromium } from '@playwright/test';
const b = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
for (const w of [320,375,768,1024,1440,1920]) {
  const p = await b.newPage({ viewport: { width: w, height: 900 } });
  await p.goto('http://localhost:8899/', { waitUntil: 'networkidle' });
  const m = await p.evaluate(() => ({ s: document.documentElement.scrollWidth, c: document.documentElement.clientWidth,
    toggle: getComputedStyle(document.querySelector('.tfp-menu-toggle')).display,
    cta: document.querySelector('.tfp-header__actions .tfp-btn') ? getComputedStyle(document.querySelector('.tfp-header__actions .tfp-btn')).display : 'absent' }));
  console.log(`${String(w).padStart(5)}px  débordement=${m.s>m.c?('OUI +'+(m.s-m.c)):'non'}  menu-burger=${m.toggle}  CTA header=${m.cta}`);
  await p.close();
}
await b.close();
