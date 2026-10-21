<?php
/**
 * Routeur du banc local (`php -S … tools/banc-router.php`).
 *
 * Le serveur intégré de PHP ne connaît pas les « jolis » permaliens : une URL qui ressemble à un
 * fichier (`/wp-sitemap.xml`, `/robots.txt` généré) et qui n'existe pas sur le disque reçoit un
 * 404 avant même que WordPress ne s'exécute. Les permaliens sans extension passaient parce que le
 * serveur retombe sur `index.php` ; les sitemaps natifs, eux, n'étaient jamais servis sur le banc
 * (revue du 21 octobre 2026 : `tests/decisions.spec.js` les contrôle, et ils répondaient 404).
 *
 * Règle : un fichier qui existe est servi tel quel ; tout le reste passe par `index.php`, comme le
 * ferait la réécriture d'un hébergement réel.
 */
$racine = rtrim( (string) $_SERVER['DOCUMENT_ROOT'], '/' ); // le dossier passé à `-t`
$chemin = (string) parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );
if ( '/' !== $chemin && is_file( $racine . $chemin ) ) {
	return false; // fichier réel : le serveur intégré le sert lui-même
}
$_SERVER['SCRIPT_NAME']     = '/index.php';
$_SERVER['PHP_SELF']        = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = $racine . '/index.php';
require $racine . '/index.php';
