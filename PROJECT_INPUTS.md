# PROJECT_INPUTS — Top-Famille Pro

> Fichier de cadrage lu par Claude Code **avant toute écriture de code**.
> Prioritaire sur le prototype en cas de contradiction.
> Dernière mise à jour : 7 août 2026 — enrichi par relevé du site topentreprise.fr et de ses mentions légales.

## Fiabilité

| Marque | Signification |
|---|---|
| ✅ | Confirmé (Emmanuel, ou relevé sur le site officiel / mentions légales) |
| 🟡 | Hypothèse à valider avant publication |
| ⛔ | Manquant — à récupérer auprès du client |

---

## 1. Identité

| Champ | Valeur | Fiab. |
|---|---|---|
| Marque affichée | **Top-Famille Pro** | ✅ |
| Domaine | **top-famille-pro.fr** — nouveau domaine, site refait à 100 % | ✅ |
| Raison sociale | **SARL TOP-ENTREPRISE** | ✅ mentions légales |
| Gérante | **Audrey Brançon** | ✅ |
| Siège | 650D route de Gray, 21850 Saint-Apollinaire | ✅ |
| Marque sœur | **Top-Famille** (top-famille.fr) — particuliers, services à la personne, crédit d'impôt 50 % | ✅ |
| Ancienne marque / ancien site | Top-Entreprise — topentreprise.fr, site **Wix** | ✅ |
| Activité | Nettoyage professionnel de locaux, en prestataire (les intervenants sont salariés de l'entreprise) | ✅ |
| Couverture | Bourgogne-Franche-Comté, « pas au-delà » | ✅ |
| Mise en ligne | Immédiate | ✅ |

**Contacts publics** ✅
- Audrey Brançon, gérante — 06 36 17 63 39 — audrey.b@top-famille.fr
- Manon G., assistante — 06 02 48 73 79 — manon.g@top-famille.fr
- ⛔ Ces adresses sont en `@top-famille.fr`. **Faut-il créer des adresses `@top-famille-pro.fr` ?** Cohérence de marque à trancher avant la mise en ligne.

**Réseaux sociaux** ✅ — Instagram `@topfamille`, Facebook `topfamillebourgogne`. Ce sont les comptes **Top-Famille**, pas des comptes pro dédiés. 🟡 À lier quand même dans `sameAs`, en assumant la marque groupe.

**Site carrière** ✅ — `careers.werecruit.io/fr/top-famille` (mutualisé avec Top-Famille). La page recrutement du nouveau site doit pointer là, pas dupliquer un formulaire.

---

## 2. Données légales

**Confirmées en phase 7** par extrait Pappers fourni par le client, puis complément (SIRET, code
APE, TVA) transmis directement — cohérence formelle recontrôlée indépendamment avant intégration
(clé Luhn du SIRET, clé de contrôle TVA calculée à partir du SIREN : les deux correspondent).
L'incohérence relevée en phase 0 est levée : le SIREN correct est **938 472 420**, pas
938 472 242 comme l'annonçaient les mentions légales de l'ancien site (déjà identifié comme une
non-conformité de ce dernier).

| Champ | Valeur | Fiab. |
|---|---|---|
| Forme juridique | SARL | ✅ |
| Capital social | **600,00 €** | ✅ Pappers |
| RCS | **938 472 420 R.C.S. Dijon** | ✅ Pappers |
| SIREN | **938 472 420** | ✅ Pappers |
| SIRET (siège, 14 chiffres) | **938 472 420 00018** | ✅ confirmé client, clé Luhn recontrôlée |
| Date d'immatriculation | **16/12/2024** | ✅ Pappers |
| Date de commencement d'activité | **01/01/2025** | ✅ Pappers |
| Code APE/NAF | **81.21Z — Nettoyage courant des bâtiments** | ✅ confirmé client |
| TVA intracommunautaire | **FR32 938 472 420** | ✅ confirmé client, clé recontrôlée (attendue : 32) |
| Gérante | **Audrey Brançon** (nom d'usage) — nom de naissance Michelin confirmé par Pappers, **non publié** (information personnelle non nécessaire à la mention légale) | ✅ Pappers |
| Directeur de la publication | 🟡 Audrey Brançon, gérante — toujours non confirmé explicitement, reste `[À COMPLÉTER]` sur le site | — |
| Assurance RC professionnelle | ⛔ — le site actuel affirme « nous sommes assurés » : nom de l'assureur et n° de police à récupérer avant de reprendre cette affirmation | — |
| Hébergeur à mentionner | Hostinger International Ltd — ⛔ adresse et téléphone exacts à reprendre de la page légale d'Hostinger | — |

Valeurs intégrées dans `includes/site-options.php` (`tfp_site_data()`), consommées par les
mentions légales, le pied de page (forme concise) et les données structurées `Organization`
(`taxID`, `vatID`, `foundingDate` — pas de propriété schema.org appropriée pour le code APE, non
forcé dans le JSON-LD). Ne jamais publier la date de naissance de la gérante ni son nom de
naissance : seul le nom d'usage, déjà utilisé partout sur le site, est rendu public.

---

## 3. Stack technique

| Champ | Valeur | Fiab. |
|---|---|---|
| Plateforme | **WordPress** | ✅ |
| Hébergeur | **Hostinger** | ✅ |
| Thème | Enfant sur mesure (même principe que le site EB Automatisation : parent GeneratePress + enfant dédié) | 🟡 |
| Dépôt Git | Fayen21/top-famille-pro — **thème enfant uniquement** | 🟡 |
| Cache | LiteSpeed Cache (Hostinger) à configurer explicitement | 🟡 |
| Page builder lourd | **Interdit** (Elementor, Divi, WPBakery) — incompatible avec les cibles de performance | ✅ |
| Déploiement / SFTP / hPanel | ⛔ accès à fournir |
| Version PHP | ⛔ à relever |

**Architecture WordPress — à trancher en phase 0 :**
- ⛔ CPT `zone` (champs : département, ville, code postal, prestations desservies, FAQ locale) + template unique, **ou** 26 pages classiques ? Le CPT évite 26 pages copiées-collées à maintenir.
- ⛔ CPT `prestation` ou pages classiques ?
- ⛔ Blocs natifs (Audrey édite librement) ou champs ACF structurés (Audrey ne casse pas la mise en page) ? Sur un site à forte contrainte SEO, ACF est plus sûr.

---

## 4. Prestations réelles ✅

Relevé sur topentreprise.fr. **Base éditoriale de référence pour les 6 pages prestations du prototype** — à mapper en phase 0.

**Nettoyage régulier des espaces professionnels**
Entretien des sols (carrelage, parquet, vinyle, moquette) · cuisine et sanitaires (détartrage, désinfection) · toilettes · dépoussiérage des meubles, bureaux, armoires · équipements (micro-ondes, réfrigérateurs, cafetières) · fenêtres et vitrages · portes et poignées · organisation et rangement des espaces de travail.

**Interventions ponctuelles / sur-mesure**
Nettoyage de fond en comble · avant emménagement ou déménagement de locaux · espaces extérieurs (terrasses, entrepôts, abris) · rangements et placards en profondeur · dégivrage et nettoyage des congélateurs professionnels · préparation d'espaces pour événements.

**Types de locaux desservis** ✅
Locaux commerciaux · entreprises de services · cabinets libéraux (avocat, notaire, architecte) · cabinets médicaux (médecin, dentiste, infirmier) · locations meublées · copropriétés d'immeuble.

**Exclusions explicites** ✅ — locaux **industriels**, **alimentaires**, et **médicaux nécessitant une asepsie complète**.
> Ces exclusions doivent apparaître sur le site : elles qualifient les demandes en amont et évitent des devis perdus.

**Horaires d'intervention** ✅ — généralement du lundi au samedi, 6h–22h. Jours fériés, dimanche et travail de nuit possibles sur demande.

**Point de vigilance commercial** ✅ — le matériel et les produits sont **fournis par le client**, les intervenants utilisent ceux du client. C'est une différence réelle avec une société de propreté classique : à énoncer clairement plutôt qu'à masquer, sous peine de litiges à la première prestation.

---

## 5. Tarifs réels ✅

Relevés sur topentreprise.fr/tarifs-aides. ⛔ **À faire confirmer par Audrey** : ces montants peuvent avoir évolué depuis la dernière mise à jour du site Wix.

| Prestation | Tarif |
|---|---|
| Ménage régulier — locations | 24,30 € HT/heure |
| Ménage régulier — autres locaux | 26,00 € HT/heure |
| Ménage ponctuel (≤ 5 interventions) | 30,00 € HT/heure |
| Majoration dimanche, jours fériés, nuit (22h–7h) | +10 % |
| Indemnités kilométriques (véhicule personnel de l'intervenant) | 0,35 € HT/km |
| Frais de mise en place | 50,00 € HT, une seule fois |
| Frais de gestion mensuels | 9,00 € HT/mois |

**Point d'entrée à afficher : « à partir de 24,30 € HT/heure ».**

> ⚠️ Le prototype affiche des blocs tarifaires par ville. **Ces tarifs sont régionaux, pas locaux** : afficher un prix différent selon la ville serait faux. Utiliser la même grille partout, et faire porter la différenciation locale sur autre chose (types de locaux du secteur, contexte, FAQ).

---

## 6. Zones réelles ✅

Le prototype prévoit 8 pages départementales + 10 pages villes : **cela correspond exactement au maillage actuel**.

| Département | Ville(s) couverte(s) |
|---|---|
| 21 — Côte-d'Or | Dijon |
| 25 — Doubs | Besançon |
| 39 — Jura | Dole, Lons-le-Saunier |
| 58 — Nièvre | Nevers |
| 70 — Haute-Saône | Vesoul |
| 71 — Saône-et-Loire | Chalon-sur-Saône, Mâcon |
| 89 — Yonne | Auxerre |
| 90 — Territoire de Belfort | Belfort |

⛔ **Les 8 « communes secondaires » du prototype n'existent pas sur le site actuel.** Elles ont été inventées ou déduites par Claude Design. À faire valider une par une par Audrey : toute commune non réellement desservie passe en `noindex,follow` ou disparaît.

⛔ Le site actuel ne couvre **pas** le 71 côté Chalon dans le menu principal alors qu'il a une page : vérifier la cohérence du maillage réel avec Audrey.

---

## 7. Preuves et crédibilité

**Avis clients authentiques déjà publiés** ✅ — six témoignages figurent sur le site actuel, signés Jean-Louis D., Anna P., Michel G., Laurent, Laura et Anne-Sophie. Ce sont de vrais avis publiés par le client : ils peuvent être repris, **contrairement aux ~40 avis fictifs du prototype qui doivent tous disparaître**.

⛔ **Fiche Google Business** : le site actuel affiche un badge d'avis Google. Il faut récupérer l'URL réelle de la fiche pour `sameAs` et pour le lien « voir nos avis ». Si la fiche est celle de Top-Famille et non d'une entité pro, ne pas présenter ses avis comme des avis B2B.

⛔ **Note et nombre d'avis réels** — le prototype affiche 5,0/5 et 47 avis, chiffres fictifs. À remplacer par les vrais ou à masquer.

⛔ **Portrait d'Audrey** — un vrai portrait existe sur le site actuel. À récupérer en haute définition. Le portrait de stock du prototype ne doit jamais être publié comme étant elle.

⛔ **Photos d'intervenants** — aucune photo réelle disponible. Utiliser des visuels neutres avec un `alt` qui ne prétend représenter personne.

---

## 8. Arguments et promesses — repris du site actuel ✅

Gestion administrative prise en charge (facturation, arrêts de travail, remplacement de personnel, litiges) · assurance professionnelle couvrant dommages matériels et corporels · gestion sécurisée des clés et des accès · remplacement garanti en cas d'absence · contrôle qualité et suivi régulier · cahier de liaison fourni en début de prestation · tarif tout compris sans frais cachés · recrutement rigoureux avec vérification du CV et du casier judiciaire, et validation par le client lors d'une prestation d'essai.

**Fonctionnement en 4 temps** ✅ — échange sur les attentes → devis personnalisé selon le besoin et le budget → sélection de l'intervenant validée par le client → démarrage et suivi continu.

---

## 9. Redirections 301 depuis topentreprise.fr

⛔ Décision préalable : **que devient topentreprise.fr ?** S'il conserve des positions ou des backlinks, la redirection page à page vaut mieux que l'abandon.

Correspondances identifiées ✅ (à compléter après relevé exhaustif via le plan de site de l'ancien site) :

| Ancienne URL | Nouvelle URL |
|---|---|
| `/` | `/` |
| `/menage` | `/nettoyage-professionnel/` |
| `/tarifs-aides` | `/tarifs/` |
| `/contact` | `/contact/` |
| `/blog` | `/conseils/` |
| `/menage-pro-agence/21000dijon` | `/zones-intervention/cote-dor/dijon/` |
| `/menage-pro-agence/25000besancon` | `/zones-intervention/doubs/besancon/` |
| `/menage-pro-agence/39100dole` | `/zones-intervention/jura/dole/` |
| `/menage-pro-agence/39000lonslesaunier` | `/zones-intervention/jura/lons-le-saunier/` |
| `/menage-pro-agence/58000nevers` | `/zones-intervention/nievre/nevers/` |
| `/menage-pro-agence/70000vesoul` | `/zones-intervention/haute-saone/vesoul/` |
| `/menage-pro-agence/71100chalonsursaone` | `/zones-intervention/saone-et-loire/chalon-sur-saone/` |
| `/menage-pro-agence/71000macon` | `/zones-intervention/saone-et-loire/macon/` |
| `/menage-pro-agence/89000auxerre` | `/zones-intervention/yonne/auxerre/` |
| `/menage-pro-agence/90000belfort` | `/zones-intervention/territoire-de-belfort/belfort/` |
| `/mentions-légales` | `/mentions-legales/` |
| `/cookies` | `/cookies/` |
| `/donnees-personnelles` | `/confidentialite/` |
| `/plan-site` | `/plan-du-site/` |

⛔ Le blog de l'ancien site n'a pas été relevé : ses articles sont à inventorier avant redirection.

---

## 10. SEO local

**Ciblage** ✅ — « entreprise de nettoyage » + ville, sur 10 villes réparties sur 8 départements de Bourgogne-Franche-Comté. Point d'entrée tarifaire « à partir de 24,30 € HT/h » et promesse « réponse en 24 h », déjà utilisés par le client.

**Concurrents locaux (secteur Dijon)** ✅ Google Places :

| Concurrent | Commune | Avis |
|---|---|---|
| France Nettoyage 21 | Talant | 4,9 (62) |
| 1 PEK | Saint-Apollinaire | 4,5 (28) |
| Prop'Vert | Saint-Apollinaire | 4,6 (22) |
| Audacès Propreté | Saint-Apollinaire | 5,0 (15) |

> Sur ce marché, le volume d'avis Google pèse autant que le site. Une fiche Google Business active et alimentée est probablement le premier levier, avant le référencement du site lui-même.

**Données structurées** — `ProfessionalService` avec : nom Top-Famille Pro, adresse réelle du siège, téléphone, e-mail, `areaServed` limité aux 8 départements réellement couverts, logo, `sameAs` (Google Business, Instagram, Facebook, top-famille.fr), `priceRange`. Aucune adresse ni agence locale fictive : **l'entreprise a un seul établissement**, à Saint-Apollinaire.

---

## 11. RGPD

- Données collectées : formulaire de devis. Candidatures gérées hors site via werecruit.
- ⛔ Sous-traitants à mentionner : Hostinger (hébergement), service d'envoi d'e-mails, werecruit, éventuel analytics.
- ⛔ Durée de conservation des demandes de devis.
- ⛔ Contact référent RGPD.
- ⛔ La page « données personnelles » de l'ancien site n'a pas été relevée : à récupérer et à réécrire, pas à recopier.

---

## 12. Questions ouvertes

| # | Question | Pour qui | Bloque |
|---|---|---|---|
| 1 | ~~**Kbis** : SIRET exact, capital, APE, TVA, date d'immatriculation — et lever l'incohérence sur le SIREN~~ | Client | **Résolu phase 7** — voir §2 |
| 2 | Assureur RC pro (nom + police) pour justifier l'affirmation « nous sommes assurés » | Client | Mise en ligne |
| 3 | Les tarifs relevés sont-ils toujours à jour ? | Audrey | Phase 3 |
| 4 | Adresse de réception des demandes de devis + configuration SMTP Hostinger | Client | Phase 4 |
| 5 | E-mails en `@top-famille-pro.fr` ou maintien de `@top-famille.fr` ? | Emmanuel / client | Phase 1 |
| 6 | URL de la fiche Google Business, note et nombre d'avis réels | Client | Mise en ligne |
| 7 | Portrait HD d'Audrey + visuels réels | Client | Mise en ligne |
| 8 | Validation des 8 communes secondaires du prototype (absentes du site actuel) | Audrey | Phase 3 |
| 9 | Que devient topentreprise.fr ? | Emmanuel / client | Phase 6 |
| 10 | Inventaire des articles du blog actuel pour les redirections | Emmanuel | Phase 6 |
| 11 | CPT + ACF ou pages classiques ? | Emmanuel | Phase 0 |
| 12 | Accès hPanel / SFTP / base ; top-famille-pro.fr déposé et pointé ? | Emmanuel | Phase 1 |
| 13 | **Déploiement réel** : `top-famille-pro.fr` fait tourner un thème `V1top-famille-pro` étranger à ce dépôt (constaté 9 août 2026, `docs/AUDIT-PRODUCTION.md`) — qui a provisionné ce thème, et le paquet correctif peut-il être installé (voir procédure staging) ? | Emmanuel / client | Mise en ligne |
| 14 | Les deux fichiers annoncés comme joints à la session du 9 août (référence HTML standalone, ZIP de 31 images) n'étaient pas accessibles dans l'environnement d'exécution — à retransmettre pour confirmer qu'ils correspondent bien à `reference/Top-Famille-Pro-HANDOFF-READY.html` et `assets/` déjà dans le dépôt (équivalence vérifiée par SHA-256, à confirmer si une version plus récente existe) | Emmanuel | Non bloquant — substitution déjà vérifiée |
