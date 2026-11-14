import { chromium } from 'playwright';

const REF = 'file:///home/user/top-famille-pro/reference/Top-Famille-Pro-HANDOFF-READY.html';
const WP = 'http://localhost:8901/nettoyage-professionnel/';

/**
 * Relève les SIX vignettes de prestation de la page pilier, et rien d'autre.
 *
 * Deux pièges, tous deux rencontrés lors du premier relevé :
 *
 *  - la sélection « toute image de 20 à 90 px » ramenait aussi le logo du pied de page, dont la
 *    carte fait 2 000 px de haut : une valeur aberrante au milieu des mesures ;
 *  - « le premier texte de la carte » ne désigne pas la même chose des deux côtés — le titre sur la
 *    maquette, la description sur le site — ce qui faisait conclure à un écart de 17 → 13 px là où
 *    deux éléments différents étaient comparés. On relève donc TITRE et DESCRIPTION séparément.
 */
const RELEVE = () => {
  const px = (v) => Math.round(parseFloat(v) * 10) / 10;
  const cs = getComputedStyle;
  const txt = (e) => (e ? (e.textContent || '').replace(/\s+/g, ' ').trim() : '');

  /* Les six libellés de prestation : c'est le contenu qui identifie la bande, pas une classe. */
  const LIBELLES = ['Nettoyage de bureaux', 'Nettoyage de commerces', 'Cabinets', 'Copropriétés', 'Locations meublées', 'Nettoyage ponctuel'];

  const cartes = [];
  for (const im of document.images) {
    const ri = im.getBoundingClientRect();
    /* Les six vignettes du pilier font 56 px : c'est leur signature, et elle écarte d'emblée les
       visuels de 60 px d'autres bandes qui portent les mêmes libellés. */
    if (Math.round(ri.width) !== 56) continue;
    /* Remonter jusqu'au conteneur qui porte l'un des six libellés en titre. */
    let c = im.parentElement, titre = null;
    for (let i = 0; i < 6 && c; i++) {
      const t = [...c.querySelectorAll('h3, h4, strong, b, span, div, p')].find((e) =>
        e.children.length === 0 && LIBELLES.some((l) => txt(e).startsWith(l))
      );
      if (t) { titre = t; break; }
      c = c.parentElement;
    }
    if (!titre || !c) continue;
    if (cartes.some((x) => x.el === c)) continue;

    /* La description est le premier texte de la carte qui n'est ni le titre ni vide. */
    const desc = [...c.querySelectorAll('p, span, div')].find((e) =>
      e.children.length === 0 && e !== titre && txt(e).length > 6 && !LIBELLES.some((l) => txt(e).startsWith(l))
    );

    const rc = c.getBoundingClientRect(), sc = cs(c), si = cs(im);
    const st = cs(titre), rt = titre.getBoundingClientRect();
    const sd = desc ? cs(desc) : null;
    cartes.push({
      el: c,
      libelle: txt(titre).slice(0, 30),
      carteL: px(rc.width), carteH: px(rc.height),
      carteTop: Math.round(rc.top + window.scrollY),
      carteLeft: Math.round(rc.left),
      bordL: sc.borderTopWidth, bordStyle: sc.borderTopStyle, bordCouleur: sc.borderTopColor,
      fond: sc.backgroundColor,
      rayonCarte: sc.borderTopLeftRadius,
      padding: [sc.paddingTop, sc.paddingRight, sc.paddingBottom, sc.paddingLeft].map(px).join('/'),
      imgL: px(ri.width), imgH: px(ri.height), rayonImg: si.borderTopLeftRadius,
      ecartImgTitre: px(rt.top - ri.bottom),
      /*
       * Le rectangle d'un SPAN en ligne est la boîte des glyphes ; celui d'un bloc est la boîte de
       * ligne, plus haute de deux demi-interlignes. Comparer les deux « hauts » fait apparaître un
       * décalage qui n'existe pas à l'œil. On relève donc aussi le display et la hauteur du titre,
       * et un repère indépendant du modèle de boîte : la BASE de la première ligne.
       */
      titreDisplay: st.display,
      titreH: px(rt.height),
      titreCentreVsImg: px(rt.top + rt.height / 2 - ri.bottom),
      titreFS: px(st.fontSize), titreLH: px(st.lineHeight), titreFW: st.fontWeight,
      descFS: sd ? px(sd.fontSize) : null, descLH: sd ? px(sd.lineHeight) : null,
      desc: desc ? txt(desc).slice(0, 28) : null,
    });
  }
  cartes.sort((a, b) => a.carteTop - b.carteTop || a.carteLeft - b.carteLeft);

  /* Écarts entre cartes voisines : vertical si empilées, horizontal si sur la même rangée. */
  const ecarts = [];
  for (let i = 1; i < cartes.length; i++) {
    const a = cartes[i - 1], b = cartes[i];
    ecarts.push(a.carteTop === b.carteTop
      ? { sens: 'h', px: b.carteLeft - (a.carteLeft + a.carteL) }
      : { sens: 'v', px: b.carteTop - (a.carteTop + a.carteH) });
  }
  cartes.forEach((c) => delete c.el);
  return { n: cartes.length, cartes, ecarts };
};

const b = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium' });
const out = {};
for (const w of [375, 768, 1440]) {
  const pm = await b.newPage({ viewport: { width: w, height: 900 } });
  await pm.goto(REF, { waitUntil: 'load' });
  await pm.waitForTimeout(4000);
  await pm.evaluate(() => { location.hash = '/nettoyage-professionnel'; });
  await pm.waitForTimeout(1500);
  await pm.evaluate(async () => { for (let y=0;y<document.body.scrollHeight;y+=600){window.scrollTo(0,y);await new Promise(r=>setTimeout(r,40));} window.scrollTo(0,0); });
  await pm.waitForTimeout(400);
  const m = await pm.evaluate(RELEVE);
  await pm.close();

  const pw = await b.newPage({ viewport: { width: w, height: 900 } });
  await pw.goto(WP, { waitUntil: 'networkidle' });
  await pw.evaluate(async () => { for (let y=0;y<document.body.scrollHeight;y+=600){window.scrollTo(0,y);await new Promise(r=>setTimeout(r,40));} window.scrollTo(0,0); });
  await pw.waitForTimeout(400);
  const s = await pw.evaluate(RELEVE);
  await pw.close();
  out[w] = { maquette: m, site: s };
}
await b.close();
console.log(JSON.stringify(out, null, 1));
