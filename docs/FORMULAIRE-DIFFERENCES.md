# Formulaire de devis — différences avec la maquette, une par une

> Établi en G26 §6, le 17 août 2026.
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
| Ordre des commandes d'étape 2 | envoi puis retour | **retour puis envoi** | L'ordre de lecture au clavier suit l'ordre visuel : la commande de retour précède celle d'envoi, comme dans tout parcours à étapes. Inverser l'ordre du document pour coller au prototype placerait l'envoi avant le retour dans la tabulation. |
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
