<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="tfp-skip-link" href="#tfp-contenu"><?php esc_html_e( 'Aller au contenu principal', 'top-famille-pro' ); ?></a>

<header class="tfp-header">
	<div class="tfp-header__barre container">
		<a class="tfp-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<span class="tfp-logo__texte">Top-Famille Pro</span>
			<?php endif; ?>
		</a>

		<?php get_template_part( 'template-parts/header/nav-desktop' ); ?>

		<div class="tfp-header__actions">
			<a class="tfp-header__tel" href="<?php echo esc_url( tfp_telephone_href() ); ?>">
				<svg class="tfp-icone" aria-hidden="true" viewBox="0 0 24 24" width="18" height="18"><path d="M6 3h3l2 5-2.5 1.5a11 11 0 0 0 5 5L15 12l5 2v3a2 2 0 0 1-2 2A16 16 0 0 1 4 5a2 2 0 0 1 2-2z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
				<?php echo esc_html( tfp_telephone_affichage() ); ?>
			</a>
			<?php tfp_bouton_devis( '', 'primaire', 'tfp-btn--compact' ); ?>
			<button type="button" id="tfp-menu-toggle" class="tfp-menu-toggle" aria-expanded="false" aria-controls="tfp-mobile-nav">
				<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'top-famille-pro' ); ?></span>
				<svg class="tfp-icone-menu" aria-hidden="true" viewBox="0 0 24 24" width="22" height="22"><path d="M3 6h18M3 12h18M3 18h18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
			</button>
		</div>
	</div>
</header>

<?php get_template_part( 'template-parts/header/nav-mobile' ); ?>
<?php get_template_part( 'template-parts/header/barre-cta-mobile' ); ?>

<main id="tfp-contenu" class="tfp-main">
