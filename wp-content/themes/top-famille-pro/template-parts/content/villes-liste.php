<?php
/**
 * Liste des communes desservies, sans distance affichée (conformément à
 * la consigne). $args : 'communes' (tableau de chaînes).
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$communes = $args['communes'] ?? array();
if ( empty( $communes ) ) {
	return;
}
?>
<ul class="tfp-grille tfp-grille--3 tfp-liste-communes">
	<?php foreach ( $communes as $commune ) : ?>
		<li class="tfp-carte"><?php echo esc_html( $commune ); ?></li>
	<?php endforeach; ?>
</ul>
