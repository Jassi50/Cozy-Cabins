<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Cozy_Cabins
 */

?>

	<footer id="colophon" class="site-footer">
		<div class="site-info">
			<div class="wp-infodiv">
				<p>Cozy Cabins theme developed by Jassi Brar,<br/> Lema Azizi, Riley Robertson & Carrie Graham</p>
				<p>
				<?php
				/* translators: 1: Theme name, 2: Theme author. */
				printf( esc_html__( 'Theme: %1$s by %2$s.', 'cozy-cabins' ), 'cozy-cabins', '<a href="https://cozycabins.bcitwebdeveloper.ca/">FWD28</a>' );
				?>
				</p>
			</div><!--END .wp-infodiv -->
		</div><!-- END .site-info -->

<!-- listing second footer nav registration from functions file for policies menu -->

		<div class="socmednav">
			<nav id="footer-navigation" class="footer-navigation">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-2',
					'menu_id'        => 'secondary-menu',
				)
			);
			wp_nav_menu(
				array(
					'theme_location' => 'menu-3',
					'menu_id'        => 'tertiary-menu',
				)
			);
			?>		
		</nav><!-- #site-navigation -->
		</div>

		</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer() ?>

</body>
</html>
