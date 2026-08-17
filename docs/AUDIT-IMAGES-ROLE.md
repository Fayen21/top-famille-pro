# Audit des images par rôle — maquette ↔ WordPress

> Fichier **généré** par `node tools/audit-images-role.mjs`. Ne pas éditer à la main.
>
> Les images sont appariées sur leur **rôle** dans la page (logo, hero, éditoriale, vignette),
> pas comptées en bloc, puis comparées sur les **octets de leur source** (SHA-256).

**38 images auditées sur 7 routes · 2 écart(s).**

| Route | Rôle | # | SHA-256 maquette | SHA-256 WordPress | Slot | Résultat |
|---|---|---:|---|---|---|---|
| `#/` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | ✅ identique |
| `#/` | hero | 1 | 0f8fb0ce37ddc15c | 0f8fb0ce37ddc15c | hero-main | ✅ identique |
| `#/` | editoriale | 1 | d90ac841df35ad7a | d90ac841df35ad7a | hero-secondary | ✅ identique |
| `#/` | editoriale | 2 | 91b93f915a21fbd9 | 91b93f915a21fbd9 | service-bureaux | ✅ identique |
| `#/` | editoriale | 3 | 46a86c7e9eac3d5f | 46a86c7e9eac3d5f | service-commerces | ✅ identique |
| `#/` | editoriale | 4 | 18af9088fd99e88a | 18af9088fd99e88a | audrey-portrait | ✅ identique |
| `#/` | editoriale | 5 | 4ba2bd2ba288216e | 4ba2bd2ba288216e | article-1 | ✅ identique |
| `#/` | editoriale | 6 | 31c59a38757a0320 | 31c59a38757a0320 | article-2 | ✅ identique |
| `#/` | editoriale | 7 | f1c64c6392df9f43 | f1c64c6392df9f43 | article-3 | ✅ identique |
| `#/` | vignette | 1 | e73f0f091f2cad51 | — | — | ⚠️ MANQUANTE côté thème |
| `#/` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | ✅ identique |
| `#/nettoyage-professionnel` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | ✅ identique |
| `#/nettoyage-professionnel` | hero | 1 | dbc3d6162557a762 | dbc3d6162557a762 | hero-pilier | ✅ identique |
| `#/nettoyage-professionnel` | editoriale | 1 | 18af9088fd99e88a | 18af9088fd99e88a | audrey-portrait | ✅ identique |
| `#/nettoyage-professionnel` | vignette | 1 | 0d32ae6733eee622 | 0d32ae6733eee622 | thumb-bureaux | ✅ identique |
| `#/nettoyage-professionnel` | vignette | 2 | 0d8cf57d64f5124d | 0d8cf57d64f5124d | thumb-commerces | ✅ identique |
| `#/nettoyage-professionnel` | vignette | 3 | c55d8a5619d299c5 | c55d8a5619d299c5 | thumb-cabinets | ✅ identique |
| `#/nettoyage-professionnel` | vignette | 4 | ecee90efb0f2ef69 | ecee90efb0f2ef69 | thumb-coproprietes | ✅ identique |
| `#/nettoyage-professionnel` | vignette | 5 | e2440e590fa6dd38 | e2440e590fa6dd38 | thumb-meubles | ✅ identique |
| `#/nettoyage-professionnel` | vignette | 6 | 03752d889ac8f8d3 | 03752d889ac8f8d3 | thumb-ponctuel | ✅ identique |
| `#/nettoyage-professionnel` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | ✅ identique |
| `#/ville/dijon` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | ✅ identique |
| `#/ville/dijon` | hero | 1 | 5f1f95810af0a046 | 5f1f95810af0a046 | ville-dijon | ✅ identique |
| `#/ville/dijon` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | ✅ identique |
| `#/conseils` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | ✅ identique |
| `#/conseils` | editoriale | 1 | 4ba2bd2ba288216e | 4ba2bd2ba288216e | article-1 | ✅ identique |
| `#/conseils` | editoriale | 2 | 31c59a38757a0320 | 31c59a38757a0320 | article-2 | ✅ identique |
| `#/conseils` | editoriale | 3 | f1c64c6392df9f43 | f1c64c6392df9f43 | article-3 | ✅ identique |
| `#/conseils` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | ✅ identique |
| `#/a-propos` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | ✅ identique |
| `#/a-propos` | hero | 1 | c6c51783628e3170 | c6c51783628e3170 | audrey-placeholder | ✅ identique |
| `#/a-propos` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | ✅ identique |
| `#/recrutement` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | ✅ identique |
| `#/recrutement` | hero | 1 | 600a388c7750c405 | 600a388c7750c405 | service-generic | ✅ identique |
| `#/recrutement` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | ✅ identique |
| `#/contact` | logo-entete | 1 | 667325a99b8b8f2e | 667325a99b8b8f2e | logo-horizontal | ✅ identique |
| `#/contact` | vignette | 1 | f9c6cb81f75acb82 | c6c51783628e3170 | audrey-placeholder | ⚠️ IMAGE DIFFÉRENTE |
| `#/contact` | logo-pied | 1 | 4190421a67a40922 | 4190421a67a40922 | logo-carre | ✅ identique |
