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
			if ( function_exists( 'get_field' ) ):

				if( have_rows('home_section') ):

					// Loop through rows.
					while( have_rows('home_section') ) : the_row();
					?><article class="front-archive"><?php
				
						// Load sub field value.
						$title = get_sub_field('title');
						$image = get_sub_field('image');
						$description = get_sub_field('description');
						$link = get_sub_field('link');
						// Do something...
						echo '<a href="' .$link. '">';
						echo "<h2 class = 'front-archive'>";
						echo $title;
						echo'</h2>' ;
						echo wp_get_attachment_image( $image,'cozy_front_archive', "", 
						array('class' => 'front-archive'));
						echo "<p class='front-archive' >";
						echo $description;
						echo '</p>';
						echo '</a>';
					?></article><?php
					// End loop.
					endwhile;
						// then output content containing Instagram shortcode
						get_template_part( 'template-parts/content', 'page' );			
				// No value.
				else :
					// Do something...
					echo 'no sections found';
				endif;
			endif;

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_footer();
