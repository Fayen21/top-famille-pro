#!/usr/bin/env bash
# =================================================================================================
#  Top-Famille Pro — installation / mise à jour du site sur Hostinger, en une commande (SSH).
#
#  À lancer DANS le terminal SSH de l'hébergement (hPanel → Avancé → Accès SSH), depuis le dossier
#  du site WordPress (celui qui contient wp-config.php), après avoir déposé le dossier de livraison.
#
#  Ce que fait le script, dans l'ordre — il s'ARRÊTE au premier problème :
#    0. contrôles préalables (WP-CLI, dossier WordPress, fichiers de livraison intacts, version) ;
#    1. sauvegarde de la base + des thèmes et extensions, et note du thème actif (retour arrière) ;
#    2. GeneratePress (thème parent), ACF (champs), LiteSpeed Cache si demandé ;
#    3. thème Top-Famille Pro + outil d'installation du contenu ;
#    4. simulation (ce qui manque, contenu étranger aux 53 pages — rien n'est supprimé) ;
#    5. installation du contenu (53 pages) ;
#    6. activation du thème, permaliens ;
#    7. suppression de l'outil d'installation, purge du cache ;
#    8. contrôles automatiques du site en ligne (tarif 26 €, formulaire en envoi réel, 404,
#       sitemap à 53 adresses, robots.txt, compression).
#
#  Ce qu'il NE fait PAS (à faire par une personne, voir release/CHECKLIST-MISE-EN-LIGNE.md) :
#  envoyer un devis de test et vérifier la boîte de réception, regarder le site sur téléphone,
#  décider pour les avis et les mentions légales. Il ne supprime jamais aucune page.
#
#  Usage :
#    bash deployer-hostinger.sh                       # installation (demande confirmation)
#    bash deployer-hostinger.sh --simulation          # étapes 0 et 4 seulement : rien n'est modifié
#    bash deployer-hostinger.sh --retour-arriere      # réactive le thème noté avant l'installation
#
#  Options :
#    --paquets=DOSSIER        dossier contenant les ZIP et SHA256SUMS.txt (défaut : ~/tfp-livraison)
#    --chemin=DOSSIER         dossier WordPress (défaut : dossier courant)
#    --litespeed              installe et active LiteSpeed Cache s'il est absent
#    --sauvegarde-hpanel-faite  si l'export de la base échoue : confirme qu'une sauvegarde hPanel
#                             complète vient d'être faite, et continue
#    --oui                    ne pose pas la question de confirmation (usage avancé)
#    --restaurer-base=FICHIER avec --retour-arriere : réimporte aussi cette sauvegarde de base
# =================================================================================================
set -uo pipefail

VERSION_ATTENDUE="0.17.0"
TARIF_ATTENDU="26"
ADRESSES_SITEMAP=53
THEME="topfamillepro"
OUTIL="topfamillepro-content-installer"

PAQUETS="${HOME}/tfp-livraison"
CHEMIN="$(pwd)"
MODE="installation"
LITESPEED=0
HPANEL_OK=0
OUI=0
RESTAURER_BASE=""
WP="${WP_CMD:-wp}"

for arg in "$@"; do
	case "$arg" in
		--paquets=*) PAQUETS="${arg#*=}" ;;
		--chemin=*) CHEMIN="${arg#*=}" ;;
		--simulation) MODE="simulation" ;;
		--retour-arriere) MODE="retour" ;;
		--litespeed) LITESPEED=1 ;;
		--sauvegarde-hpanel-faite) HPANEL_OK=1 ;;
		--oui) OUI=1 ;;
		--restaurer-base=*) RESTAURER_BASE="${arg#*=}" ;;
		-h|--help) sed -n '2,40p' "$0"; exit 0 ;;
		*) echo "Option inconnue : $arg (voir --help)"; exit 2 ;;
	esac
done

# ---------- affichage ----------
if [ -t 1 ]; then V=$'\e[32m'; R=$'\e[31m'; J=$'\e[33m'; G=$'\e[1m'; N=$'\e[0m'; else V=""; R=""; J=""; G=""; N=""; fi
ETAPE=0
etape()  { ETAPE=$((ETAPE + 1)); printf '\n%s── %s ──%s\n' "$G" "$*" "$N"; }
ok()     { printf '  %s✓%s %s\n' "$V" "$N" "$*"; }
info()   { printf '    %s\n' "$*"; }
alerte() { printf '  %s!%s %s\n' "$J" "$N" "$*"; ALERTES=$((ALERTES + 1)); }
stop()   {
	printf '\n  %s✕ ARRÊT : %s%s\n' "$R" "$*" "$N"
	if [ "${MODIFIE:-0}" -eq 1 ]; then
		printf '    Le site a pu être modifié. Retour arrière : bash %s --retour-arriere\n' "$0"
	else
		printf '    Rien n’a été modifié sur le site.\n'
	fi
	exit 1
}
ALERTES=0
wpc() { $WP --path="$CHEMIN" "$@"; }

cd "$CHEMIN" 2>/dev/null || { echo "Dossier introuvable : $CHEMIN"; exit 1; }
SAUVEGARDES="${HOME}/tfp-sauvegardes"
mkdir -p "$SAUVEGARDES"

# =================================================================================================
#  Retour arrière
# =================================================================================================
if [ "$MODE" = "retour" ]; then
	etape "Retour arrière"
	[ -f "$SAUVEGARDES/theme-avant.txt" ] || stop "aucun thème noté (fichier $SAUVEGARDES/theme-avant.txt absent)."
	THEME_AVANT="$(cat "$SAUVEGARDES/theme-avant.txt")"
	info "Thème actif avant l'installation : $THEME_AVANT"
	if [ "$OUI" -ne 1 ]; then
		read -r -p "  Réactiver « $THEME_AVANT » ? Tapez OUI : " rep; [ "$rep" = "OUI" ] || stop "annulé."
	fi
	wpc theme activate "$THEME_AVANT" >/dev/null || stop "impossible de réactiver $THEME_AVANT."
	ok "thème $THEME_AVANT réactivé"
	if [ -n "$RESTAURER_BASE" ]; then
		[ -f "$RESTAURER_BASE" ] || stop "sauvegarde introuvable : $RESTAURER_BASE"
		wpc db import "$RESTAURER_BASE" >/dev/null || stop "réimport de la base échoué."
		ok "base réimportée depuis $(basename "$RESTAURER_BASE")"
	fi
	wpc plugin is-installed "$OUTIL" 2>/dev/null && { wpc plugin deactivate "$OUTIL" >/dev/null 2>&1; wpc plugin delete "$OUTIL" >/dev/null 2>&1; ok "outil d'installation supprimé"; }
	wpc plugin is-active litespeed-cache 2>/dev/null && wpc litespeed-purge all >/dev/null 2>&1 && ok "cache LiteSpeed purgé"
	wpc rewrite flush >/dev/null 2>&1
	printf '\n%sRetour arrière terminé.%s Vérifiez le site dans un navigateur.\n' "$V" "$N"
	exit 0
fi

# =================================================================================================
#  0. Contrôles préalables
# =================================================================================================
etape "0. Contrôles préalables"
command -v "${WP%% *}" >/dev/null 2>&1 || stop "WP-CLI (commande « wp ») est introuvable sur ce serveur."
wpc core is-installed >/dev/null 2>&1 || stop "aucun WordPress installé dans $CHEMIN (lancez le script depuis le dossier qui contient wp-config.php, ou passez --chemin=)."
SITE="$(wpc option get home 2>/dev/null)"
ok "WordPress trouvé : $SITE"
php -r 'exit(version_compare(PHP_VERSION, "8.0", ">=") ? 0 : 1);' || stop "PHP 8.0 minimum requis (version actuelle : $(php -r 'echo PHP_VERSION;'))."
ok "PHP $(php -r 'echo PHP_VERSION;')"

ZIP_THEME="$PAQUETS/topfamillepro-theme.zip"
ZIP_OUTIL="$PAQUETS/topfamillepro-content-installer.zip"
for f in "$ZIP_THEME" "$ZIP_OUTIL" "$PAQUETS/SHA256SUMS.txt"; do
	[ -f "$f" ] || stop "fichier de livraison absent : $f (déposez le dossier de livraison dans $PAQUETS, ou passez --paquets=)."
done
( cd "$PAQUETS" && grep -E 'topfamillepro-(theme|content-installer)\.zip' SHA256SUMS.txt | sha256sum -c --quiet - ) \
	|| stop "les ZIP ne correspondent pas à leurs empreintes : transfert incomplet ou fichiers abîmés. Redéposez-les."
ok "fichiers de livraison intacts (empreintes SHA-256 vérifiées)"
VERSION_ZIP="$(unzip -p "$ZIP_THEME" "$THEME/style.css" 2>/dev/null | sed -n 's/^Version: *//p' | tr -d '\r')"
[ "$VERSION_ZIP" = "$VERSION_ATTENDUE" ] || stop "le thème livré est en version « $VERSION_ZIP », $VERSION_ATTENDUE attendue."
ok "thème livré : version $VERSION_ZIP"

ENV_TYPE="$(wpc eval 'echo wp_get_environment_type();' 2>/dev/null)"
if [ "$ENV_TYPE" != "production" ]; then
	alerte "environnement WordPress « $ENV_TYPE » : le formulaire de devis n'enverra AUCUN e-mail ici (protection des tests)."
	info "Pour un vrai site ou une préproduction de recette, retirez WP_ENVIRONMENT_TYPE de wp-config.php."
else
	ok "environnement : production (le formulaire enverra de vrais e-mails)"
fi
THEME_AVANT="$(wpc theme list --status=active --field=name 2>/dev/null | head -1)"
ok "thème actif actuellement : $THEME_AVANT"

# =================================================================================================
#  Simulation seule
# =================================================================================================
simulation() {
	wpc eval '
		if ( ! function_exists( "tfp_installer_precheck" ) ) { echo "  (outil d’installation non actif : simulation indisponible)\n"; return; }
		$p = tfp_installer_precheck();
		foreach ( $p as $famille => $l ) {
			if ( ! is_array( $l ) || ! isset( $l["expected"] ) ) continue;
			$n = function ( $v ) { return is_array( $v ) ? count( $v ) : (int) $v; };
			printf( "    %-14s %2d attendus · %2d présents · %2d à créer\n", $famille, $l["expected"], $n( $l["present"] ), $n( $l["missing"] ) );
		}
		$etrangers = tfp_installer_scan_legacy_content();
		if ( $etrangers ) {
			echo "    Contenu HORS des 53 pages (rien ne sera supprimé ; à examiner après coup) :\n";
			foreach ( $etrangers as $e ) printf( "      - [%s] %s  (/%s/, %s)\n", $e["post_type"], $e["title"], $e["slug"], $e["status"] );
		} else {
			echo "    Aucun contenu publié hors des 53 pages.\n";
		}
	'
}

if [ "$MODE" = "simulation" ]; then
	etape "4. Simulation (rien n'est modifié)"
	if wpc plugin is-active "$OUTIL" 2>/dev/null; then
		simulation
	else
		info "L'outil d'installation n'est pas encore sur ce site : la simulation détaillée sera faite"
		info "pendant l'installation, avant toute écriture. Contrôles préalables : tous réussis."
	fi
	printf '\n%sSimulation terminée — rien n’a été modifié.%s\n' "$V" "$N"
	exit 0
fi

# ---------- confirmation ----------
if [ "$OUI" -ne 1 ]; then
	printf '\n  %sVous allez installer Top-Famille Pro %s sur :%s %s\n' "$G" "$VERSION_ZIP" "$N" "$SITE"
	info "Le contenu des 53 pages sera créé ou REMPLACÉ par celui de la livraison."
	read -r -p "  Pour continuer, tapez l'adresse du site exactement ($SITE) : " rep
	[ "$rep" = "$SITE" ] || stop "confirmation différente de l'adresse du site : rien n'a été modifié."
fi

# =================================================================================================
#  1. Sauvegarde
# =================================================================================================
etape "1. Sauvegarde"
MODIFIE=1
HORO="$(date +%Y%m%d-%H%M%S)"
echo "$THEME_AVANT" > "$SAUVEGARDES/theme-avant.txt"
ok "thème actuel noté pour le retour arrière : $THEME_AVANT"
if wpc db export "$SAUVEGARDES/base-$HORO.sql" >/dev/null 2>&1; then
	ok "base de données exportée : $SAUVEGARDES/base-$HORO.sql"
elif [ "$HPANEL_OK" -eq 1 ]; then
	alerte "export de la base impossible ici ; sauvegarde hPanel déclarée faite (--sauvegarde-hpanel-faite)."
else
	stop "export de la base impossible. Faites une sauvegarde complète dans hPanel → Sauvegardes, puis relancez avec --sauvegarde-hpanel-faite."
fi
tar -czf "$SAUVEGARDES/themes-extensions-$HORO.tar.gz" -C "$CHEMIN/wp-content" themes plugins 2>/dev/null \
	&& ok "thèmes et extensions archivés : $SAUVEGARDES/themes-extensions-$HORO.tar.gz" \
	|| alerte "archive des thèmes et extensions non créée (la sauvegarde de la base reste valable)."

# =================================================================================================
#  2. Prérequis : GeneratePress, ACF, LiteSpeed
# =================================================================================================
etape "2. Prérequis"
if wpc theme is-installed generatepress 2>/dev/null; then
	ok "GeneratePress déjà installé"
else
	wpc theme install generatepress >/dev/null 2>&1 || stop "installation de GeneratePress impossible (thème parent obligatoire)."
	ok "GeneratePress installé"
fi
if wpc plugin is-active advanced-custom-fields 2>/dev/null; then
	ok "ACF déjà actif"
elif wpc plugin install advanced-custom-fields --activate >/dev/null 2>&1; then
	ok "ACF installé et activé"
else
	alerte "ACF n'a pas pu être installé : le site fonctionne sans, mais les champs ne seront pas modifiables en administration. À installer ensuite (Extensions → Ajouter → « Advanced Custom Fields »)."
fi
if [ "$LITESPEED" -eq 1 ] && ! wpc plugin is-active litespeed-cache 2>/dev/null; then
	wpc plugin install litespeed-cache --activate >/dev/null 2>&1 && ok "LiteSpeed Cache installé et activé" \
		|| alerte "LiteSpeed Cache n'a pas pu être installé (à faire depuis l'administration)."
fi

# =================================================================================================
#  3. Thème et outil d'installation
# =================================================================================================
etape "3. Thème et outil d'installation du contenu"
wpc theme install "$ZIP_THEME" --force >/dev/null 2>&1 || stop "installation du thème impossible."
ok "thème Top-Famille Pro $VERSION_ZIP installé (pas encore activé)"
wpc plugin install "$ZIP_OUTIL" --force --activate >/dev/null 2>&1 || stop "installation de l'outil de contenu impossible."
ok "outil d'installation du contenu installé et activé"

# =================================================================================================
#  4. Simulation
# =================================================================================================
etape "4. Simulation (lecture seule)"
simulation

# =================================================================================================
#  5. Installation du contenu
# =================================================================================================
etape "5. Installation du contenu (53 pages)"
RAPPORT="$SAUVEGARDES/rapport-installation-$HORO.txt"
wpc eval '
	$r = tfp_installer_run();
	$erreurs = 0;
	foreach ( $r["steps"] as $s ) {
		printf( "%s %s\n", "ok" === $s["status"] ? "OK " : "ERR", $s["label"] );
		if ( "ok" !== $s["status"] ) { $erreurs++; echo "    " . str_replace( "\n", "\n    ", trim( $s["output"] ) ) . "\n"; }
	}
	foreach ( $r["after"] as $type => $n ) printf( "    %-11s %3d publiés (avant : %d)\n", $type, $n, $r["before"][ $type ] ?? 0 );
	exit( $erreurs ? 1 : 0 );
' > "$RAPPORT" 2>&1
CODE=$?
sed 's/^OK /  ✓ /; s/^ERR/  ✕ /' "$RAPPORT"
[ "$CODE" -eq 0 ] || stop "une étape de l'installation du contenu a échoué (détail ci-dessus et dans $RAPPORT). Le thème n'a PAS été activé."
ok "contenu installé — rapport : $RAPPORT"

# =================================================================================================
#  6. Activation et permaliens
# =================================================================================================
etape "6. Activation du thème et permaliens"
wpc theme activate "$THEME" >/dev/null 2>&1 || stop "activation du thème impossible."
ok "thème Top-Famille Pro activé"
STRUCT="$(wpc option get permalink_structure 2>/dev/null)"
if [ -z "$STRUCT" ]; then
	wpc rewrite structure '/%postname%/' >/dev/null 2>&1 && ok "permaliens réglés sur « Nom de l'article »"
fi
wpc rewrite flush --hard >/dev/null 2>&1 || wpc rewrite flush >/dev/null 2>&1
ok "règles d'adresses reconstruites"

# =================================================================================================
#  7. Nettoyage
# =================================================================================================
etape "7. Nettoyage"
wpc plugin deactivate "$OUTIL" >/dev/null 2>&1; wpc plugin delete "$OUTIL" >/dev/null 2>&1
wpc plugin is-installed "$OUTIL" 2>/dev/null && alerte "l'outil d'installation est encore présent : supprimez-le depuis Extensions." || ok "outil d'installation supprimé"
if wpc plugin is-active litespeed-cache 2>/dev/null; then
	wpc litespeed-purge all >/dev/null 2>&1 && ok "cache LiteSpeed purgé" || alerte "purge LiteSpeed impossible : purgez depuis l'administration (LiteSpeed Cache → Boîte à outils)."
else
	alerte "LiteSpeed Cache n'est pas actif : obligatoire pour les performances (relancez avec --litespeed, ou installez-le depuis l'administration)."
fi

# =================================================================================================
#  8. Contrôles du site en ligne
# =================================================================================================
etape "8. Contrôles du site en ligne ($SITE)"
ECHECS=0
controle() { if eval "$2"; then ok "$1"; else printf '  %s✕%s %s\n' "$R" "$N" "$1"; ECHECS=$((ECHECS + 1)); fi; }
page()   { curl -sSL --max-time 30 "$SITE$1" 2>/dev/null; }
statut() { curl -s -o /dev/null -w '%{http_code}' --max-time 30 "$SITE$1" 2>/dev/null; }

ESP="([[:space:]]|&nbsp;|&#160;|&#8239;|"$'\xc2\xa0'"|"$'\xe2\x80\xaf'")?"
THEME_ACTIF="$(wpc theme list --status=active --field=name 2>/dev/null | head -1)"
controle "thème actif : Top-Famille Pro $VERSION_ZIP" '[ "$THEME_ACTIF" = "$THEME" ]'
ACCUEIL="$(page /)"
controle "accueil accessible (HTTP 200)" '[ "$(statut /)" = "200" ]'
controle "tarif affiché : $TARIF_ATTENDU € HT/h" 'grep -Eq "(^|[^0-9,])${TARIF_ATTENDU}${ESP}€" <<<"$ACCUEIL"'
controle "aucun ancien tarif à 27 € sur l'accueil" '! grep -Eq "(^|[^0-9,])27${ESP}€" <<<"$ACCUEIL"'
for u in /prestations/bureaux/ /zones-intervention/cote-dor/dijon/ /tarifs/ /demande-de-devis/ /mentions-legales/; do
	controle "$u accessible" '[ "$(statut "$u")" = "200" ]'
done
DEVIS="$(page /demande-de-devis/)"
if grep -q 'data-tfp-mail-disabled' <<<"$DEVIS"; then
	printf '  %s✕%s formulaire de devis en mode test : AUCUN e-mail ne partira (environnement « %s »)\n' "$R" "$N" "$ENV_TYPE"; ECHECS=$((ECHECS + 1))
else
	ok "formulaire de devis en envoi réel"
fi
controle "une adresse inexistante renvoie une vraie erreur 404" '[ "$(statut /tfp-adresse-inexistante-$HORO/)" = "404" ]'
TOTAL=0
for s in page prestation zone post; do
	n="$(page "/wp-sitemap-posts-$s-1.xml" | grep -o '<loc>' | wc -l | tr -d ' ')"; TOTAL=$((TOTAL + n))
done
controle "sitemap : $TOTAL adresses ($ADRESSES_SITEMAP attendues)" '[ "$TOTAL" -eq "$ADRESSES_SITEMAP" ]'
controle "robots.txt annonce le sitemap" 'grep -qi "^Sitemap:" <<<"$(page /robots.txt)"'
ENC="$(curl -s -o /dev/null -D - -H 'Accept-Encoding: br, gzip' --max-time 30 "$SITE/wp-content/themes/$THEME/assets/dist/css/main.css" 2>/dev/null | grep -i '^content-encoding' | tr -d '\r')"
if [ -n "$ENC" ]; then ok "feuille de style compressée (${ENC#*: })"; else alerte "feuille de style servie sans compression : activez la compression dans LiteSpeed Cache."; fi

# =================================================================================================
#  Bilan
# =================================================================================================
printf '\n%s══ Bilan ══%s\n' "$G" "$N"
info "Sauvegardes et rapport : $SAUVEGARDES"
if [ "$ECHECS" -gt 0 ]; then
	printf '  %s%d contrôle(s) en échec.%s Corrigez avant d’ouvrir le site, ou revenez en arrière :\n' "$R" "$ECHECS" "$N"
	info "bash $0 --retour-arriere"
	exit 1
fi
printf '  %sInstallation terminée, contrôles automatiques réussis%s (%d alerte(s) à lire ci-dessus).\n' "$V" "$N" "$ALERTES"
cat <<FIN

  Il reste à faire par une personne (release/CHECKLIST-MISE-EN-LIGNE.md, phases 3 à 5) :
    1. Envoyer un devis de test depuis « Nettoyage de bureaux » en choisissant « Commerces »,
       et vérifier que l'e-mail arrive EN BOÎTE DE RÉCEPTION avec le bon contenu.
    2. Regarder le site sur ordinateur et sur téléphone.
    3. Mettre en brouillon le contenu « hors des 53 pages » listé à l'étape 4, s'il y en a.
    4. Garder l'ancien thème ($THEME_AVANT) quelques jours avant de le supprimer.
  En cas de problème : bash $0 --retour-arriere
FIN
exit 0
