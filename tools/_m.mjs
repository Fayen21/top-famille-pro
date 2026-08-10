import { chromium } from '@playwright/test';
const b = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
const p = await b.newPage({ viewport: { width: 1440, height: 900 } });
await p.goto('file:///home/user/top-famille-pro/reference/Top-Famille-Pro-HANDOFF-READY.html', { waitUntil: 'load', timeout: 60000 });
await p.waitForTimeout(6000);
await p.evaluate(() => { location.hash = '/service/bureaux'; });
await p.waitForTimeout(1500);
const r = await p.evaluate(() => {
  let best = document.body, count = 0;
  for (const el of document.querySelectorAll('body *')) {
    const n = el.querySelectorAll(':scope > section, :scope > div').length;
    if (n > count && el.getBoundingClientRect().height > 3000) { count = n; best = el; }
  }
  return Array.from(best.children).filter(c => c.getBoundingClientRect().height >= 20)
    .map((c, i) => ({ i: i + 1, h: Math.round(c.getBoundingClientRect().height), text: c.innerText }));
});
const want = process.argv[2] ? process.argv[2].split(',').map(Number) : null;
for (const b2 of r) {
  if (want && !want.includes(b2.i)) continue;
  console.log(`\n########## BLOC ${b2.i} (h=${b2.h}) ##########`);
  console.log(b2.text.slice(0, 2200));
}
await b.close();
