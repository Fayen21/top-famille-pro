// @ts-check
/**
 * Isolation des tests du formulaire de devis vis-à-vis de la limitation de fréquence.
 *
 * La production limite à 5 demandes par heure et par IP (`tfp_quote_rate_limit_ok()`, transitoire
 * `tfp_devis_<md5(ip)>`). Sur le banc, toutes les soumissions viennent de la même adresse : deux
 * suites relancées dans l'heure suffisaient à épuiser le quota, et un test de soumission valide
 * échouait sur `erreur=limite` (revue du 25 octobre 2026).
 *
 * Le seuil n'est PAS modifié et la protection n'est PAS désactivée : on remet à zéro le SEUL
 * compteur de l'IP du banc, par WP-CLI, avant chaque test qui doit atteindre l'envoi — et on le
 * sature volontairement pour le test du refus. Ces commandes ne s'exécutent que sur le banc local
 * (`/tmp/tfp-rig`, cible `localhost`) ; ailleurs, `banc` vaut false et les tests le disent.
 */
import { execFileSync } from 'node:child_process';
import { createHash } from 'node:crypto';
import { existsSync } from 'node:fs';
import path from 'node:path';

const RIG = process.env.TFP_RIG || '/tmp/tfp-rig';
const CIBLE = process.env.TFP_BASE_URL || 'http://localhost:8901';

/** `php -S` sur localhost peut voir la connexion en IPv4 ou en IPv6 : les deux clés sont traitées. */
const IPS_BANC = [ '127.0.0.1', '::1' ];
const cle = (ip) => 'tfp_devis_' + createHash('md5').update(ip).digest('hex');

export const banc = /^https?:\/\/(localhost|127\.0\.0\.1)(:\d+)?\/?$/.test(CIBLE) && existsSync(path.join(RIG, 'wp-cli.phar'));

function wp(...args) {
	execFileSync('php', [ path.join(RIG, 'wp-cli.phar'), `--path=${path.join(RIG, 'wp-core')}`, '--allow-root', ...args ], { stdio: 'pipe' });
}

/** Remet à zéro le compteur de demandes de devis de l'IP du banc, et lui seul. */
export function purgerLimiteDevis() {
	if (!banc) return;
	for (const ip of IPS_BANC) wp('transient', 'delete', cle(ip));
}

/** Place le compteur de l'IP du banc au seuil de production (5) : la demande suivante est refusée. */
export function saturerLimiteDevis() {
	if (!banc) return;
	for (const ip of IPS_BANC) wp('transient', 'set', cle(ip), '5', '3600');
}
