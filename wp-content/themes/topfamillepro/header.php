<?php
/**
 * En-tête HTML du document. tfp_seo() doit avoir été appelé par le gabarit AVANT
 * get_header() pour que includes/seo.php dispose des bonnes valeurs au moment de wp_head().
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'tfp-body' ); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#tfp-main">Aller au contenu principal</a>

<div style="min-height:100vh;display:flex;flex-direction:column">
<?php get_template_part( 'template-parts/header/site-header' ); ?>

<main id="tfp-main" style="flex:1">
