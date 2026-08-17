import { chromium } from '@playwright/test';
const REF='file:///home/user/top-famille-pro/reference/Top-Famille-Pro-HANDOFF-READY.html';
const b=await chromium.launch({executablePath:'/opt/pw-browsers/chromium'});
const releve=(p)=>p.evaluate(()=>{
  const out=[];
  const f=document.querySelector('form')||document.body;
  for(const e of f.querySelectorAll('input,select,textarea,button,label,legend,fieldset,h2,h3,p')){
    const r=e.getBoundingClientRect(); const s=getComputedStyle(e);
    const visible = r.width>0 && r.height>0 && s.visibility!=='hidden' && s.display!=='none';
    const t=(e.textContent||'').replace(/\s+/g,' ').trim().slice(0,54);
    if(['INPUT','SELECT','TEXTAREA'].includes(e.tagName)){
      out.push(`${visible?'●':'○'} ${e.tagName}[${e.type||''}] name=${e.name||'—'} id=${e.id||'—'} req=${e.required?'oui':'non'} ph="${(e.placeholder||'').slice(0,28)}" ${Math.round(r.width)}×${Math.round(r.height)}`);
    } else if(['BUTTON'].includes(e.tagName)){
      out.push(`${visible?'●':'○'} BUTTON[${e.type}] ${Math.round(r.width)}×${Math.round(r.height)} « ${t} »`);
    } else if(['LABEL','LEGEND'].includes(e.tagName)){
      out.push(`${visible?'●':'○'} ${e.tagName} for=${e.getAttribute('for')||'—'} « ${t} »`);
    } else if(visible && t && ['H2','H3'].includes(e.tagName)){
      out.push(`  ${e.tagName} « ${t} »`);
    }
  }
  return out.join('\n');
});
const ref=await b.newPage({viewport:{width:1440,height:900}});
await ref.goto(REF,{waitUntil:'load',timeout:90000}); await ref.waitForTimeout(5500);
await ref.evaluate(()=>{location.hash='/demande-de-devis';}); await ref.waitForTimeout(1400);
console.log('##### MAQUETTE étape 1'); console.log(await releve(ref));
await ref.close();
const wp=await b.newPage({viewport:{width:1440,height:900}});
await wp.goto('http://localhost:8901/demande-de-devis/',{waitUntil:'networkidle'});
console.log('\n##### WORDPRESS étape 1'); console.log(await releve(wp));
await wp.close();
await b.close();
