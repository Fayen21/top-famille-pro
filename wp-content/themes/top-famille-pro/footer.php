	</main>

	<footer class="tfp-footer">
		<div class="container tfp-footer__grille">
			<div class="tfp-footer__bloc">
				<p class="tfp-logo__texte">Top-Famille Pro</p>
				<p>
					<?php
					$adresse = trim( tfp_get_donnee( 'siege_adresse' ) . ' ' . tfp_get_donnee( 'siege_code_postal' ) . ' ' . tfp_get_donnee( 'siege_ville' ) );
					echo esc_html( $adresse );
					?>
				</p>
				<p><a href="<?php echo esc_url( tfp_telephone_href() ); ?>"><?php echo esc_html( tfp_telephone_affichage() ); ?></a></p>
				<?php $email = tfp_get_donnee( 'email' ); ?>
				<?php if ( $email ) : ?>
					<p><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></p>
				<?php endif; ?>
			</div>

			<div class="tfp-footer__bloc">
				<h2><?php esc_html_e( 'Navigation', 'top-famille-pro' ); ?></h2>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'container'      => false,
						'items_wrap'     => '<ul>%3$s</ul>',
						'fallback_cb'    => false,
					)
				);
				?>
			</div>

			<div class="tfp-footer__bloc">
				<h2><?php esc_html_e( 'Zones d\'intervention', 'top-famille-pro' ); ?></h2>
				<p><?php echo esc_html( implode( ', ', tfp_zones_prioritaires_liste() ) ); ?></p>
				<p><a href="<?php echo esc_url( home_url( '/zones-intervention/' ) ); ?>"><?php esc_html_e( 'Voir toutes les zones', 'top-famille-pro' ); ?></a></p>
			</div>
		</div>

		<div class="tfp-footer__bas container">
			<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> Top-Famille Pro. <?php esc_html_e( 'Tous droits réservés.', 'top-famille-pro' ); ?></p>
		</div>
	</footer>

<?php wp_footer(); ?>
</body>
</html>
