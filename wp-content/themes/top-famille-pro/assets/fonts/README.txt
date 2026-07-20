Polices locales attendues (non incluses dans ce commit)
=========================================================

Le réseau de cet environnement de développement bloque l'accès à
fonts.google.com : les fichiers de police n'ont pas pu être téléchargés
automatiquement. theme.json référence déjà les bons chemins ; il suffit
de déposer les fichiers suivants (rien d'autre à modifier) :

assets/fonts/hanken-grotesk/
  - HankenGrotesk-Regular.woff2   (graisse 400)
  - HankenGrotesk-SemiBold.woff2  (graisse 600)
  - HankenGrotesk-Bold.woff2      (graisse 700)

assets/fonts/public-sans/
  - PublicSans-Regular.woff2   (graisse 400)
  - PublicSans-Medium.woff2    (graisse 500)
  - PublicSans-Bold.woff2      (graisse 700)

Source officielle et gratuite (licence SIL Open Font License) :
https://fonts.google.com/specimen/Hanken+Grotesk
https://fonts.google.com/specimen/Public+Sans

Pour chaque police, télécharger la famille, garder uniquement les trois
graisses ci-dessus, les convertir en .woff2 si besoin (les polices
Google Fonts sont livrées en .ttf), et les déposer dans les dossiers
indiqués avec exactement ces noms de fichiers.

Tant que ces fichiers ne sont pas présents, le site utilise la police de
secours système déclarée dans theme.json (sans-serif) — rien n'est cassé,
mais la typographie ne correspond pas encore à la maquette.
