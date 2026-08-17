import { chromium } from '@playwright/test';
const b=await chromium.launch({executablePath:'/opt/pw-browsers/chromium'});
const p=await b.newPage({viewport:{width:1440,height:900}});
await p.goto('file:///home/user/top-famille-pro/reference/Top-Famille-Pro-HANDOFF-READY.html',{waitUntil:'load',timeout:90000});
await p.waitForTimeout(5500); await p.evaluate(()=>{location.hash='/demande-de-devis';}); await p.waitForTimeout(1400);
await p.selectOption('#devis-type',{index:1}); await p.fill('#devis-ville','Dijon'); await p.fill('#devis-nom','Capture Test'); await p.fill('#devis-tel','0600000000');
await p.click('button[type="submit"]'); await p.waitForTimeout(900);
console.log(await p.evaluate(()=>{
  const out=[]; const f=document.querySelector('form')||document.body;
  for(const e of f.querySelectorAll('input,select,textarea,button,label,legend,h2,h3,p,div')){
    const r=e.getBoundingClientRect(); const s=getComputedStyle(e);
    const vis=r.width>0&&r.height>0&&s.visibility!=='hidden'&&s.display!=='none';
    if(!vis) continue;
    const t=(e.textContent||'').replace(/\s+/g,' ').trim();
    if(['INPUT','SELECT','TEXTAREA'].includes(e.tagName)) out.push(`${e.tagName}[${e.type||''}] name=${e.name||'—'} req=${e.required?'oui':'non'} ph="${(e.placeholder||'').slice(0,32)}" ${Math.round(r.width)}×${Math.round(r.height)}`);
    else if(e.tagName==='BUTTON') out.push(`BUTTON[${e.type}] ${Math.round(r.width)}×${Math.round(r.height)} bg=${s.backgroundColor} « ${t.slice(0,40)} »`);
    else if(['LABEL','LEGEND'].includes(e.tagName)) out.push(`${e.tagName} « ${t.slice(0,70)} »`);
    else if(['H2','H3'].includes(e.tagName)) out.push(`${e.tagName} « ${t.slice(0,60)} »`);
    else if(e.tagName==='DIV' && e.children.length===0 && t) out.push(`DIV bg=${s.backgroundColor} « ${t.slice(0,70)} »`);
  }
  return out.join('\n');
}));
await b.close();
