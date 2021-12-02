<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cozy_Cabins
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			?><h1><?php the_title();?></h1>

			<?php


			if ( function_exists( 'get_field' ) ) :

				// check if the repeater field has rows of data
				if( have_rows('people') ):

					?><div class="about-article-div"><?php
					// loop through the rows of data
					while ( have_rows('people') ) : the_row();
						// display a sub field value
						?><article class="about-us-article"><?php
						?><h2 class="about-us-title"><?php the_sub_field('name');?></h2><?php 
						echo 	wp_get_attachment_image( get_sub_field('photo'), 'medium', "", array("class" => "about-us-img" ));?><br/>
						<p class="about-us-para"> <?php the_sub_field('bio');
						?></p></article><?php
					endwhile;
					?></div><!-- END about-article-div --><?php
				else :

					echo 'nothing found';

				endif;?>
				

					<?php

					if ( get_field( 'our_location_title' ) ) :

							echo "<h3>";
							the_field( 'our_location_title' );
							echo "</h3>";

							$image2 = get_field('our_location');
							$size2 = "full";
							if( $image2 ):
							echo 	wp_get_attachment_image( $image2, $size2, "",
									array( 'class' => 'about-us-location' ) );
							endif;
						
					endif;
					if ( get_field( 'our_friends' ) ) :
						echo '<h3>';
						the_field( 'our_friends' );
						echo '</h3>';

						$image = get_field('our_friends_image');
						$size = 'full';
						if( $image ):
						echo '<a href="https://cozycabins.bcitwebdeveloper.ca/our-friends/">';
						echo wp_get_attachment_image( $image, $size, "", array( "class" => "about-us-friends-img" ) );
						echo '</a>';
						endif;

					endif;
			endif;

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_footer();
