// @ts-check
import { defineConfig, devices } from '@playwright/test';

/**
 * Suite de tests bout-en-bout du thème (phase 5, PROMPT-PHASES.md) — s'exécute contre un
 * WordPress déjà démarré (pas de webServer ici : aucun serveur MySQL/WordPress "jetable" ne peut
 * être piloté depuis ce dépôt, cf. CLAUDE.md §3, le dépôt versionne le thème enfant, pas le cœur).
 *
 * URL cible : TFP_BASE_URL (variable d'environnement), par défaut le rig de test local documenté
 * dans STATUS.md §11 (WordPress jetable hors dépôt, SQLite, thème lié en symlink).
 *
 * `executablePath` pointe explicitement vers le Chromium préinstallé de l'environnement : la
 * version de @playwright/test installée peut réclamer une révision de navigateur différente de
 * celle réellement présente sur le disque, cette option contourne la vérification de version.
 */
const BASE_URL = process.env.TFP_BASE_URL || 'http://localhost:8899';
const CHROMIUM_PATH = process.env.TFP_CHROMIUM_PATH || '/opt/pw-browsers/chromium';

export default defineConfig({
	testDir: './tests',
	fullyParallel: true,
	forbidOnly: !!process.env.CI,
	retries: process.env.CI ? 1 : 0,
	workers: process.env.CI ? 2 : undefined,
	reporter: [['list'], ['html', { outputFolder: '.playwright-report', open: 'never' }]],
	timeout: 30000,
	use: {
		baseURL: BASE_URL,
		trace: 'retain-on-failure',
		launchOptions: {
			executablePath: CHROMIUM_PATH,
		},
	},
	projects: [
		{
			name: 'chromium',
			use: { ...devices['Desktop Chrome'] },
		},
	],
});
