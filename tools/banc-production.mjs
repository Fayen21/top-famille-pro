#!/usr/bin/env node
/**
 * Banc d'essai « proche de la production » : compression et cache devant le rig WordPress.
 *
 * Le rig local est servi par `php -S`, qui ne compresse rien et n'envoie aucun en-tête de cache.
 * Mesurer Lighthouse dessus, c'est mesurer un site dont la feuille de style pèse 59 Ko au lieu de
 * 10 : sur le lien mobile bridé de Lighthouse (1,6 Mbit/s, 150 ms de latence), cela suffit à
 * décaler le premier rendu de plus d'une seconde. L'hébergement réel est un LiteSpeed Hostinger,
 * qui compresse et met en cache — c'est cet environnement-là qu'il faut mesurer.
 *
 * Ce mandataire ajoute donc, devant le rig, exactement ce que LiteSpeed apporte :
 *  - **Brotli ou gzip** sur le HTML, le CSS, le JS, le SVG et le JSON, selon `Accept-Encoding` ;
 *  - **`Cache-Control` d'un an et immuable** sur les ressources versionnées (polices, images, CSS
 *    et JS du thème), `no-cache` sur le HTML ;
 *  - **`Vary: Accept-Encoding`**, sans lequel un cache partagé servirait la mauvaise variante.
 *
 * Il n'ajoute rien d'autre : pas de minification à la volée, pas de cache de page. La seule
 * réécriture faite est celle de l'origine dans les réponses textuelles, sans quoi les polices
 * échoueraient sur CORS et le banc mesurerait une page sans ses polices. Ce qui est mesuré
 * derrière reste le rendu réel du thème.
 *
 * Usage :
 *   node tools/banc-production.mjs                 → écoute sur 8902, relaie vers 8901
 *   node tools/banc-production.mjs --port=8903 --cible=http://localhost:8899
 */
import http from 'node:http';
import { gzip, brotliCompress, constants } from 'node:zlib';

const arg = (n, d) => (process.argv.find((a) => a.startsWith(`--${n}=`)) || '').split('=')[1] || d;
const PORT = Number(arg('port', 8902));
const CIBLE = new URL(arg('cible', 'http://localhost:8901'));

/** Types compressibles : compresser une image déjà compressée coûte du temps et ne gagne rien. */
const COMPRESSIBLE = /^(text\/|application\/(javascript|json|xml|xhtml\+xml)|image\/svg\+xml)/;

/** Ressource versionnée, donc cacheable longtemps : le thème sert ses fichiers avec un `?ver=`. */
const IMMUABLE = /\.(woff2?|css|js|jpe?g|png|webp|avif|svg|ico)(\?|$)/i;

const serveur = http.createServer((req, res) => {
	const amont = http.request(
		{
			hostname: CIBLE.hostname,
			port: CIBLE.port,
			path: req.url,
			method: req.method,
			// L'en-tête `Accept-Encoding` n'est pas transmis : c'est ce mandataire qui compresse,
			// pas le rig. Le transmettre exposerait à une double compression.
			headers: { ...req.headers, host: CIBLE.host, 'accept-encoding': 'identity' },
		},
		(amontRes) => {
			const type = amontRes.headers['content-type'] || '';
			const entetes = { ...amontRes.headers };
			delete entetes['content-length'];
			delete entetes['content-encoding'];
			// Le rig répond en `transfer-encoding: chunked`. Conserver cet en-tête tout en
			// annonçant un `content-length` produit deux cadrages contradictoires : Chrome refuse
			// alors la page derrière un écran d'interstitiel, et Lighthouse ne mesure rien.
			delete entetes['transfer-encoding'];
			delete entetes.connection;

			entetes['cache-control'] = IMMUABLE.test(req.url) ? 'public, max-age=31536000, immutable' : 'no-cache';
			entetes.vary = 'Accept-Encoding';

			const accepte = req.headers['accept-encoding'] || '';

			if (!COMPRESSIBLE.test(type)) {
				res.writeHead(amontRes.statusCode, entetes);
				amontRes.pipe(res);
				return;
			}

			/*
			 * Les réponses textuelles sont mises en mémoire avant d'être renvoyées, pour une raison
			 * précise : WordPress écrit ses URL en absolu, avec l'origine du rig. Servies depuis ce
			 * mandataire, elles deviennent des requêtes multi-origines — et les polices, chargées
			 * avec `crossorigin`, échouent alors sur CORS. Le banc mesurerait une page sans ses
			 * polices, et Lighthouse compterait une erreur de console qui n'existe pas sur le site.
			 * Réécrire l'origine règle le problème à sa source plutôt que d'ajouter un en-tête CORS
			 * que la production n'aura pas.
			 */
			const morceaux = [];
			amontRes.on('data', (c) => morceaux.push(c));
			amontRes.on('end', () => {
				const corps = Buffer.concat(morceaux)
					.toString('utf8')
					.split(CIBLE.origin)
					.join(`http://localhost:${PORT}`);
				const brut = Buffer.from(corps, 'utf8');

				const envoyer = (buf, encodage) => {
					if (encodage) entetes['content-encoding'] = encodage;
					entetes['content-length'] = String(buf.length);
					res.writeHead(amontRes.statusCode, entetes);
					res.end(buf);
				};
				if (/\bbr\b/.test(accepte)) {
					brotliCompress(brut, { params: { [constants.BROTLI_PARAM_QUALITY]: 5 } }, (e, out) =>
						e ? envoyer(brut, null) : envoyer(out, 'br')
					);
				} else if (/\bgzip\b/.test(accepte)) {
					gzip(brut, { level: 6 }, (e, out) => (e ? envoyer(brut, null) : envoyer(out, 'gzip')));
				} else {
					envoyer(brut, null);
				}
			});
		}
	);
	amont.on('error', (e) => {
		res.writeHead(502, { 'content-type': 'text/plain; charset=utf-8' });
		res.end(`Banc de production : le rig ${CIBLE.origin} ne répond pas (${e.message})\n`);
	});
	req.pipe(amont);
});

serveur.listen(PORT, () => {
	console.log(`Banc « proche production » sur http://localhost:${PORT} → ${CIBLE.origin}`);
	console.log('  compression Brotli/gzip · Cache-Control 1 an sur les ressources versionnées · Vary');
});
