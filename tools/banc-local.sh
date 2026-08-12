#!/usr/bin/env bash
#
# Monte le banc de mesure WordPress **hors dépôt**, de zéro.
#
# Le dépôt ne versionne que le thème enfant (CLAUDE.md §3) : le cœur WordPress, la base et les
# contenus vivent dans /tmp et disparaissent avec le conteneur. Cette procédure était jusqu'ici
# décrite en prose dans STATUS.md §11 et devait être retrouvée puis réassemblée à chaque session ;
# elle a été perdue deux fois, et une erreur de `siteurl` a fait mesurer pendant vingt minutes une
# page servie **sans sa feuille de style** — le HTML est correct, les 53 routes répondent 200, et
# toutes les mesures géométriques sont fausses. Le contrôle final ci-dessous ferme cette porte.
#
# Usage :
#   bash tools/banc-local.sh                 → monte tout, sert en environnement « production »
#   bash tools/banc-local.sh --development   → environnement « development » (suite fonctionnelle)
#   bash tools/banc-local.sh --seed-only     → rejoue seulement les contenus
#
# Réseau requis au premier passage (miroir GitHub de WordPress ; wordpress.org est hors de portée
# depuis ce bac à sable).
set -euo pipefail

RIG="${TFP_RIG:-/tmp/tfp-rig}"
DEPOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
PORT="${TFP_PORT:-8901}"
URL="http://localhost:${PORT}"
ENVIRONNEMENT="production"
SEED_ONLY=0
for arg in "$@"; do
	case "$arg" in
		--development) ENVIRONNEMENT="development" ;;
		--seed-only) SEED_ONLY=1 ;;
	esac
done

WP() { php "$RIG/wp-cli.phar" --path="$RIG/wp-core" --allow-root "$@"; }

if [ "$SEED_ONLY" -eq 0 ]; then
	mkdir -p "$RIG"
	cd "$RIG"
	[ -d wp-core ] || git clone --depth 1 https://github.com/WordPress/WordPress.git wp-core
	[ -d sqlite-simple ] || git clone --depth 1 https://github.com/aaemnnosttv/wp-sqlite-db.git sqlite-simple
	cp sqlite-simple/src/db.php wp-core/wp-content/db.php
	mkdir -p wp-core/wp-content/database
	[ -f wp-cli.phar ] || curl -sSL https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar -o wp-cli.phar

	cd "$RIG/wp-core"
	if [ ! -f wp-config.php ]; then
		cp wp-config-sample.php wp-config.php
		php -r '$f="wp-config.php";$c=file_get_contents($f);
			$c=str_replace("database_name_here","wpdb",$c);
			$c=str_replace("username_here","root",$c);
			$c=str_replace("password_here","",$c);
			$c=str_replace("localhost","127.0.0.1",$c);
			file_put_contents($f,$c);'
	fi
	# L'environnement doit être pilotable : la suite fonctionnelle exige `development` (l'envoi de
	# courriel y est neutralisé), les mesures se font en `production`. Les hauteurs de page sont
	# identiques dans les deux, la bascule est donc sans effet sur la géométrie.
	grep -q WP_ENVIRONMENT_TYPE wp-config.php || php -r '$f="wp-config.php";$c=file_get_contents($f);
		$c=str_replace("/* That\x27s all, stop editing!",
			"if ( getenv(\x27WP_ENVIRONMENT_TYPE\x27) ) { define( \x27WP_ENVIRONMENT_TYPE\x27, getenv(\x27WP_ENVIRONMENT_TYPE\x27) ); }\n\n/* That\x27s all, stop editing!", $c);
		file_put_contents($f,$c);'

	# GeneratePress n'est pas distribué publiquement : un talon suffit, le thème enfant ne dépend
	# d'aucune de ses fonctions PHP.
	mkdir -p wp-content/themes/generatepress
	printf '/*\nTheme Name: GeneratePress\nVersion: 3.6.0\n*/\n' > wp-content/themes/generatepress/style.css
	printf '<?php\n' > wp-content/themes/generatepress/index.php
	printf '<?php\n' > wp-content/themes/generatepress/functions.php

	WP core install --url="$URL" --title="Top-Famille Pro" --admin_user=admin \
		--admin_password=admin --admin_email=test@example.com --skip-email >/dev/null

	# Thème **copié**, non lié : le banc doit prouver ce que sert une installation réelle.
	rm -rf wp-content/themes/topfamillepro
	cp -a "$DEPOT/wp-content/themes/topfamillepro" wp-content/themes/topfamillepro
	WP theme activate topfamillepro >/dev/null
	WP rewrite structure '/%postname%/' >/dev/null

	# `wp core install` déduit parfois un chemin de l'emplacement courant : sans cette remise à
	# plat, les ressources sont servies sous un préfixe inexistant et la feuille de style répond 404.
	WP option update siteurl "$URL" >/dev/null
	WP option update home "$URL" >/dev/null
	WP rewrite flush --hard >/dev/null 2>&1 || true
fi

cd "$DEPOT"
for f in bin/seed-phase2-content.php bin/seed-phase3-batch1-prestations.php \
	bin/seed-phase3-batch2-departements.php bin/seed-phase3-batch3-villes.php \
	bin/seed-phase3-batch4-communes.php bin/seed-phase3-batch5-articles.php \
	bin/seed-phase3-batch5-pages.php bin/seed-phase3-batch6-pages.php \
	bin/seed-phase3-batch7-pages.php bin/seed-phase4-maillage.php \
	bin/seed-fidelite-prestations.php bin/seed-fidelite-zones.php \
	bin/seed-fidelite-articles.php bin/seed-fidelite-pages.php \
	bin/cleanup-wp-defaults.php; do
	WP eval-file "$f" >/dev/null
done

# Arrêt de l'instance précédente, puis **attente de la libération du port**. Sans cette attente,
# le nouveau serveur échoue à se lier, l'ancien répond encore quelques instants, et le contrôle
# final porte sur une instance qui n'a pas l'environnement demandé — l'erreur se lit comme un
# défaut du thème alors que c'est le banc qui n'a pas redémarré.
for pid in $(pgrep -f "php -S localhost:${PORT}" || true); do kill "$pid" 2>/dev/null || true; done
for _ in $(seq 1 40); do
	curl -s -o /dev/null --max-time 1 "$URL/" || break
	sleep 0.5
done

cd "$RIG/wp-core"
# `php -S` est mono-processus : la suite Playwright sérialise alors toutes ses requêtes.
PHP_CLI_SERVER_WORKERS="${TFP_WORKERS:-6}" WP_ENVIRONMENT_TYPE="$ENVIRONNEMENT" \
	nohup php -S "localhost:${PORT}" -t "$RIG/wp-core" > "$RIG/php.log" 2>&1 &
for _ in $(seq 1 40); do
	curl -s -o /dev/null --max-time 1 "$URL/" && break
	sleep 0.5
done

# ------------------------------------------------------------------
# Contrôle final — la seule partie de ce script qu'il ne faut pas sauter.
# ------------------------------------------------------------------
echec=0
code_accueil=$(curl -s -o /dev/null -w '%{http_code}' "$URL/")
code_css=$(curl -s -o /dev/null -w '%{http_code}' "$URL/wp-content/themes/topfamillepro/assets/dist/css/main.css")
printf 'accueil %s · feuille de style %s · environnement %s\n' "$code_accueil" "$code_css" "$ENVIRONNEMENT"
[ "$code_accueil" = "200" ] || { echo "✗ l'accueil ne répond pas"; echec=1; }
[ "$code_css" = "200" ] || { echo "✗ la feuille de style n'est pas servie — toute mesure géométrique serait fausse"; echec=1; }
if [ "$ENVIRONNEMENT" = "development" ]; then
	# Le corps est capturé avant d'être filtré : sous `pipefail`, `grep -q` ferme le tube dès la
	# première correspondance, `curl` reçoit SIGPIPE, et la condition échouait alors même que le
	# marqueur était bien présent.
	contact=$(curl -s "$URL/contact/")
	case "$contact" in
		*data-tfp-mail-disabled*) : ;;
		*) echo "✗ l'envoi n'est pas neutralisé : ne pas lancer la suite de soumission"; echec=1 ;;
	esac
fi
exit "$echec"
