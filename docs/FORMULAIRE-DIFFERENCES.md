# Formulaire de devis — différences avec la maquette, une par une

> Établi en G26 §6, le 17 août 2026. **Complété en G27 §10, le 20 août 2026.**
>
> **Clé de lecture — deux natures d'écart, à ne jamais confondre :**
> - un **écart fonctionnel obligatoire** (§2) vient d'une exigence de `CLAUDE.md` ou d'un contrôle
>   de sécurité. Il est *voulu*, il se documente, il ne se corrige pas ;
> - un **défaut visuel** (§4) est une divergence de rendu sans justification. Il se mesure, et il
>   se corrige.
>
> Les confondre coûte cher dans les deux sens : on retire un jeton de sécurité pour gagner une
> mesure, ou on laisse passer un champ 40 px trop haut en le déclarant « fonctionnel ».
>
> La validation humaine du 17 août 2026 a demandé de **cesser d'affirmer « mêmes champs »** tant
> que des différences fonctionnelles subsistent, et de les documenter précisément. C'est l'objet de
> ce fichier. Il est la contrepartie honnête de `docs/FORMULAIRE-CAPTURES.md`, qui montre les
> triptyques : les images disent ce qui se voit, ce tableau dit ce qui reste.

Le formulaire comparé est `/demande-de-devis/` contre `#/demande-de-devis` du prototype.

---

## 1. Ce qui a été rapproché de la maquette en G26

Aucune de ces corrections ne retire un champ ni un contrôle.

| Élément | Avant | Après |
|---|---|---|
| Régime régulier / ponctuel | deux boutons radio | **liste déroulante**, comme la maquette — même nom `regime`, mêmes valeurs, toujours obligatoire |
| Anti-double-soumission | absent de ce formulaire | **`data-tfp-once` posé** ; le gestionnaire ignore une soumission annulée par la validation |
| Libellé du bouton d'étape 1 | « Continuer → » | **« Continuer ma demande »** |
| Libellé du retour d'étape 2 | « ← Retour » | **« ← Étape précédente »** |
| Libellé du message | « Décrivez votre besoin » | **« Votre message »** |
| Libellé de la fréquence | « Fréquence souhaitée » | **« Fréquence envisagée »** |
| Libellé du créneau | « Créneau préféré » | **« Horaires souhaités »** |
| Libellé de la surface | « Surface approximative (m²) » | **« Surface approximative »** |
| Aides de saisie | absentes | **rétablies** sous Ville, Surface et Nom, au texte de la maquette |
| Textes indicatifs | seuls Surface et Message en avaient | **rétablis** sur Ville, Code postal, Surface, Nom, Téléphone, E-mail, Entreprise, Message, au texte de la maquette |

---

## 2. Différences fonctionnelles qui SUBSISTENT, et pourquoi

Ces différences sont **voulues**. Chacune vient d'une exigence de `CLAUDE.md` ou d'un contrôle de
sécurité, pas d'un oubli. Aucune ne peut être levée sans instruction explicite d'Emmanuel.

### 2.1 Champs présents dans le thème et absents de la maquette

| Champ | Nature | Motif |
|---|---|---|
| `tfp_quote_nonce` | masqué | Jeton WordPress de vérification d'origine. Sans lui, n'importe quel site tiers peut faire soumettre le formulaire au visiteur. La maquette n'a pas de serveur, donc pas de besoin. |
| `_wp_http_referer` | masqué | Posé par `wp_nonce_field()`, contrôlé avec le jeton. |
| `action` | masqué | Route de traitement côté serveur. |
| `tfp_site_web` | **piège à robots** (honeypot) | Champ visuellement retiré du flux, `tabindex="-1"`, `aria-hidden`. Rempli ⇒ soumission rejetée. Exigé par `CLAUDE.md` §8 (« honeypot ou équivalent »). |
| `page_origine`, `referent` | masqués | Contexte visiteur exigé par `CLAUDE.md` §8 : Audrey doit savoir depuis quelle page la demande part. |
| `utm_source`, `utm_medium`, `utm_campaign` | masqués | Idem — attribution de la demande, exigée par `CLAUDE.md` §8. |
| `departement` | masqué | Prérempli depuis les pages locales, exigé par `CLAUDE.md` §8. |
| `prestation` | **visible, étape 2** | Prérempli depuis les pages de prestation et de zone, exigé par `CLAUDE.md` §8 (« prérempli depuis les pages locales et prestations »). La maquette n'a pas ce champ parce qu'elle n'a pas de préremplissage. |

### 2.2 Champs de la maquette rendus différemment

| Champ | Maquette | Thème | Motif |
|---|---|---|---|
| `creneau` (horaires souhaités) | champ de texte libre | **liste fermée** de quatre créneaux | Le créneau qualifie la demande et détermine la faisabilité. Une réponse libre (« quand vous voulez ») n'est pas exploitable ; la liste produit une donnée que le courriel de demande peut restituer telle quelle. Champ facultatif dans les deux cas. |
| `entreprise` | `name="societe"` | `name="entreprise"` | Nom interne du champ, invisible au visiteur. Le libellé affiché est le même. |

### 2.3 Contrôles plus stricts dans le thème

| Champ | Maquette | Thème | Motif |
|---|---|---|---|
| `type_locaux` | facultatif | **obligatoire** | Sans type de local, aucun chiffrage n'est possible : la demande arriverait inexploitable. |
| `regime` | facultatif | **obligatoire** | Idem : le tarif est unique, mais l'organisation d'un régulier et d'un ponctuel n'a rien à voir. |
| `nom` | facultatif | **obligatoire** | Une demande anonyme ne peut pas être rappelée. |
| `message` | facultatif | **obligatoire** | Contrepartie du champ précédent : c'est le seul endroit où le visiteur décrit ses contraintes réelles. |
| `consentement` | présent, non obligatoire | **obligatoire** | Traitement de données personnelles : le consentement est une condition, pas une option. |
| tous | aucune validation serveur | **validation client ET serveur** | `CLAUDE.md` §8. La maquette n'envoie rien ; le thème contrôle chaque champ à la réception, indépendamment du navigateur. |
| — | — | **limitation des soumissions** | `CLAUDE.md` §8. Une même adresse ne peut pas soumettre en rafale. |
| — | — | **anti-double-soumission** | Ajouté en G26 §6 : le bouton d'envoi ne portait pas `data-tfp-once`, que seul le formulaire de contact avait — un double clic produisait deux demandes identiques. Le gestionnaire ignore désormais une soumission annulée par la validation, sans quoi un formulaire incomplet laissait le visiteur devant un bouton grisé. Éprouvé dans les deux sens par `tests/functional/quote-form.spec.js`. |
| — | — | **confirmation après succès réel** | `CLAUDE.md` §8 : la confirmation ne s'affiche que si le serveur a réellement accepté l'envoi, et la page de confirmation est en `noindex`. La maquette affiche sa confirmation sans rien envoyer. |

### 2.4 Structure

| Point | Maquette | Thème | Motif |
|---|---|---|---|
| Ordre des commandes d'étape 2 | envoi puis retour | **envoi puis retour** — aligné en G27 §10 | G26 avait inversé cet ordre au motif que la tabulation devait suivre la lecture. Le motif ne tenait pas : c'est la coïncidence de l'ordre du document et de l'ordre visuel qui compte (WCAG 2.4.3), et elle est respectée dans les deux sens. L'ordre de la maquette est donc rétabli, et le retour en arrière est en outre offert une seconde fois par « Modifier l'étape 1 », juste sous le titre de l'étape. |
| Sans JavaScript | une seule étape visible, rien n'est soumis | **les deux étapes restent visibles et le formulaire reste soumissible en une fois** | Dégradation correcte plutôt que blocage : un visiteur sans JavaScript doit pouvoir demander un devis. |

---

## 3. Ce que les captures montrent, et ce qu'elles ne montrent pas

`docs/FORMULAIRE-CAPTURES.md` porte, pour chacune des quatre captures, le tableau des valeurs
**réellement présentes dans les champs des deux côtés au moment du déclenchement**. C'est ce qui
permet d'affirmer que les deux formulaires étaient dans le même état — et non que leurs champs
sont les mêmes, ce qui serait faux au vu du §2 ci-dessus.

Les écarts de pixels mesurés sur les triptyques (34 à 51 % selon la largeur et l'étape) **incluent
les différences du §2** : les champs de contexte, le champ `prestation` et les mentions
obligatoires allongent la colonne du thème. Un écart nul serait ici le signe d'une erreur de
protocole, pas d'une fidélité parfaite.

---

## 4. Défauts purement visuels relevés et corrigés en G27 §10

Aucun de ces points n'était une différence voulue : c'étaient des divergences de rendu, mesurables
au pixel, sans justification fonctionnelle. L'instrument est `tools/mesurer-formulaire.mjs`, qui
relève des deux côtés la géométrie des champs, des rangées et des commandes aux largeurs demandées.

### 4.1 Champs

| Point | Maquette | Thème avant | Après |
|---|---|---|---|
| Corps des saisies et des listes | 16 px | 16 px pour les saisies, **17 px pour les listes** | 16 px partout |
| Rembourrage | `13px 15px` | `13px 14px` sur listes et zones de texte | `13px 15px` |
| Rayon | 10 px | 10 px | inchangé |
| Hauteur d'une saisie | 49 px | 49 px | inchangée |
| Hauteur d'une liste | 51 px | **52 px** | 51 px |

**Cause.** Deux jeux de règles concurrents décrivaient les mêmes champs : celui du composant
(`.tfp-field input/textarea/select`) et un second, hérité d'un relevé antérieur du seul formulaire
de contact. La maquette applique pourtant la **même** géométrie aux deux formulaires — vérifié en
mesurant `#/contact` et `#/demande-de-devis` du prototype : 49 px pour une saisie, 51 pour une
liste, 112 pour une zone de texte, des deux côtés. Le second jeu a été supprimé.

Les listes déroulantes, elles, résistaient à toute correction dans le composant : la normalisation
de base était écrite `body.tfp-body select`, de spécificité (0,1,2), supérieure à `.tfp-field
select` (0,1,1). Une normalisation n'a pas à être spécifique ; elle est revenue au sélecteur
d'élément.

### 4.2 Empilement et largeurs

| Point | Maquette | Thème avant | Après |
|---|---|---|---|
| Ville / code postal sous 560 px | empilés, pleine largeur | **côte à côte, 64 % / 32 %** | empilés |
| Ville / code postal au-delà | `2fr 1fr`, code postal ≈ 227 px | idem | inchangé |
| Entreprise / fréquence (étape 2) | une rangée à deux colonnes | **deux rangées empilées** | une rangée |

### 4.3 Commandes

| Point | Maquette | Thème avant | Après |
|---|---|---|---|
| Bouton principal | 54 px de haut, `16px 30px`, 16,5 px, graisse 700 | **60 px**, `15px 26px`, 17 px, graisse 600 | conforme |
| Rangée de commandes | écart 14, alignement centré, recul 4 | écart 12, recul 16 | conforme |
| Mention de réassurance | dans la rangée, à droite du bouton | **sous le formulaire**, séparée du CTA | dans la rangée (étape 1) |
| Retour d'étape 2 | bouton-lien sans fond | **bouton plein secondaire** | bouton-lien |

Le correctif du bouton est **confiné au formulaire** (`.tfp-quote-form .tfp-form-actions .tfp-btn`)
et passe par les variables du composant. Les boutons du hero, mesurés à 60 px contre 61 dans la
maquette, sont déjà conformes : un correctif global les aurait cassés.

### 4.4 Étapes

| Point | Maquette | Thème avant | Après |
|---|---|---|---|
| Titre d'étape | rang en bleu + jauge de 3 px + objet de l'étape, 13 px | **titre de 20 px en gras** | indicateur de progression |
| Chapô d'étape 1 | 15,5 px, 12 px de recul | 17 px, 16 px de marge basse | conforme |
| Résumé de l'étape 1 | filet turquoise, rappel de la saisie, retour en arrière | **absent** | présent, rempli depuis les champs |

L'indicateur reste **dans le `<legend>`** : c'est lui qui donne son nom accessible au groupe de
champs. La jauge est `aria-hidden` — elle ne dit rien que « Étape 1 sur 2 » ne dise déjà.

### 4.5 Colonne latérale

| Point | Maquette | Thème avant | Après |
|---|---|---|---|
| Carte Audrey | 110 px, prénom 18 px, fonction 13,5 px | 110 px, prénom 17 px, fonction 14 px | conforme |
| Bloc téléphonique — intitulé | 14 px, graisse normale, turquoise clair | **17 px, graisse 700, police de titres, blanc** | conforme |
| Bloc téléphonique — numéro | 24 px | 26 px | conforme |
| Bloc téléphonique — rythme | 6 px puis 12 px | **écart uniforme de 10 px** | conforme |
| Bloc téléphonique — hauteur | 184,2 px hors pastille de note | 204,3 px | **184,2 px** |
| Témoignage provisoire | 154,6 px : fond glacier, sans ombre, rembourrage 22, étoiles 13, citation 15/1,55, légende sur une ligne à 13 | **277,7 px** : fond blanc ombré, rembourrage 32, étoiles 16, citation 19/500, légende sur deux lignes | variante `compacte`, **203,6 px** |
| Étoiles | `#EAB308` — les 24 occurrences du prototype, sans exception | **cuivre `#D9A062`** | `#EAB308` |

Le témoignage reste 49 px plus haut que celui du prototype, et ces 49 px sont **exactement** sa
mention « Exemple de présentation — témoignages authentiques en cours d'intégration » : 39 px de
texte et 10 px de recul. Elle est exigée par `CLAUDE.md` §5.5. Cette part-là n'est pas un défaut.
Les 123,1 px restants, eux, en étaient un, et ils sont résorbés.

La correction des étoiles porte sur **toutes** les cartes témoignage du site, pas seulement celle
de cette page : le thème les rendait en cuivre — la couleur d'accent de la charte — là où le
prototype les écrit invariablement en `#EAB308`.

### 4.6 Résultat mesuré

Hauteur du **corps du formulaire** — du haut du premier champ au bas de la dernière commande, la
seule hauteur comparable des deux côtés :

| Largeur | Maquette | Thème après |
|---|---|---|
| 375 px | 879,7 px | **876,9 px — 100 %** |
| 1 440 px | 599,7 px | **596,9 px — 100 %** |

(La colonne « avant » n'est pas donnée : cette hauteur-là n'existait pas comme mesure avant G27 §10
— l'outil comparait les boîtes `<form>`, qui ne sont pas comparables, comme dit plus bas. Écrire un
chiffre reconstitué serait exactement le défaut que ce document dénonce.)

Et les huit champs de l'étape 1 sont appariés un à un, corps, rembourrage et rayon identiques aux
deux largeurs.

> La boîte `<form>` elle-même n'est **pas** comparable, et l'outil le dit désormais en clair : la
> maquette place l'indicateur d'étape et le chapô **avant** sa balise `<form>`, le thème les met
> **dans** le `<fieldset>` parce qu'ils en portent le nom accessible. Comparer les deux `<form>`
> affichait un écart de 73 px qui ne correspondait à rien de visible à l'écran.

---

## 5. Contenus de la maquette délibérément non repris

| Contenu | Où | Motif |
|---|---|---|
| « ≈ 20 secondes » | case droite de l'indicateur d'étape 1 | Durée jamais mesurée. `CLAUDE.md` §5.1 interdit d'écrire une valeur plausible à la place d'une valeur relevée. La case porte l'objet de l'étape — « Vos locaux et vos coordonnées » — exactement comme la maquette le fait elle-même à l'étape 2 (« Précisions utiles »). |
| Pastille « ★★★★★ 5,0/5 sur Google » | bloc téléphonique | `CLAUDE.md` §5.5 : la note reste masquée tant qu'aucune URL de fiche vérifiable n'a été fournie et validée humainement. Elle représente 56,7 px de la carte du prototype. |
| « Demande enregistrée pour … » | résumé de l'étape 2 | Rien n'est envoyé au serveur avant l'étape 2 : annoncer un enregistrement qui n'a pas eu lieu serait faux. Le résumé dit « Étape 1 renseignée : … ». |
| « Réponse sous 24 h · devis gratuit et sans engagement » | à droite du bouton | Remplacé par le texte qu'impose `CLAUDE.md` §8 : « Gratuit · Sans engagement · Réponse sous 24 h ». La position, elle, est celle de la maquette. |
| Mention de réassurance à l'étape 2 | — | **Ajout**, pas omission : la maquette n'écrit rien sous la rangée de commandes de l'étape 2, mais `CLAUDE.md` §8 exige la réassurance près du CTA — et le CTA d'envoi est là. Elle est posée sur sa propre ligne pour ne pas replier la rangée. |
