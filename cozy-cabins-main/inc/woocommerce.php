<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package Cozy_Cabins
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 */
function cozy_cabins_woocommerce_setup() {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 150,
			'single_image_width'    => 300,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'default_columns' => 4,
				'min_columns'     => 1,
				'max_columns'     => 6,
			),
		)
	);
	// add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'cozy_cabins_woocommerce_setup' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function cozy_cabins_woocommerce_scripts() {
	wp_enqueue_style( 'cozy-cabins-woocommerce-style', get_template_directory_uri() . '/woocommerce.css', array(), _S_VERSION );
	wp_dequeue_style( 'wc-bookings-styles' );
	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'cozy-cabins-woocommerce-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'cozy_cabins_woocommerce_scripts' );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function cozy_cabins_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'cozy_cabins_woocommerce_active_body_class' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function cozy_cabins_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'cozy_cabins_woocommerce_related_products_args' );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

if ( ! function_exists( 'cozy_cabins_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function cozy_cabins_woocommerce_wrapper_before() {
		?>
			<main id="primary" class="site-main">
		<?php
	}
}
add_action( 'woocommerce_before_main_content', 'cozy_cabins_woocommerce_wrapper_before' );

if ( ! function_exists( 'cozy_cabins_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function cozy_cabins_woocommerce_wrapper_after() {
		?>
			</main><!-- #main -->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'cozy_cabins_woocommerce_wrapper_after' );

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if ( function_exists( 'cozy_cabins_woocommerce_header_cart' ) ) {
			cozy_cabins_woocommerce_header_cart();
		}
	?>
 */

if ( ! function_exists( 'cozy_cabins_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function cozy_cabins_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		cozy_cabins_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'cozy_cabins_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'cozy_cabins_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function cozy_cabins_woocommerce_cart_link() {
		?>
		<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'cozy-cabins' ); ?>">
			<?php
			$item_count_text = sprintf(
				/* translators: number of items in the mini cart. */
				_n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'cozy-cabins' ),
				WC()->cart->get_cart_contents_count()
			);
			?>
			<span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span> <span class="count"><?php echo esc_html( $item_count_text ); ?></span>
		</a>
		<?php
	}
}

if ( ! function_exists( 'cozy_cabins_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function cozy_cabins_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr( $class ); ?>">
				<?php cozy_cabins_woocommerce_cart_link(); ?>
			</li>
			<li>
				<?php
				$instance = array(
					'title' => '',
				);

				the_widget( 'WC_Widget_Cart', $instance );
				?>
			</li>
		</ul>
		<?php
	}
}
/**
 * Remove product data tabs
 */
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );


function woo_remove_product_tabs( $tabs ) {

    unset( $tabs['description'] );      	// Remove the description tab
    unset( $tabs['reviews'] ); 			// Remove the reviews tab
    unset( $tabs['additional_information'] );  	// Remove the additional information tab
    unset( $tabs['accommodation_booking_time'] );  	// Remove the check-in/check-out tab

    return $tabs;
}

add_action( 'woocommerce_after_single_product_summary', 'woocommerce_product_additional_information_tab' );
add_action( 'woocommerce_after_single_product_summary', 'checkin_checkout');
add_action( 'woocommerce_after_single_product_summary', 'comments_template' );


function checkin_checkout() {
	$check_in  = WC_Product_Accommodation_Booking::get_check_times( 'in' );
		$check_out = WC_Product_Accommodation_Booking::get_check_times( 'out' );
		?>
		<div class="check-time">
			<h2 class="check-time-title"><?php echo esc_html( apply_filters( 'woocommerce_accommodation_booking_time_tab_heading', __( 'Arrival/Check-out Time', 'woocommerce-accommodation-bookings' ) ) ); ?></h2>
			<ul class="check-time-list">
				<li><?php esc_html_e( 'Check-in time', 'woocommerce-accommodation-bookings' ); ?> <?php echo esc_html( date_i18n( get_option( 'time_format' ), strtotime( "Today " . $check_in ) ) ); ?></li>
				<li><?php esc_html_e( 'Check-out time', 'woocommerce-accommodation-bookings' ); ?> <?php echo esc_html( date_i18n( get_option( 'time_format' ), strtotime( "Today " . $check_out ) ) ); ?></li>
			</ul>
		</div>
		<?php
	}
	// remove_action(
	// 	'woocommerce_single_product_summary',
	// 	'woocommerce_template_single_price',
	// 	10
	// );
	// //This re-adds it
	// add_action(
	// 	'woocommerce_single_product_summary',
	// 	'woocommerce_template_single_price',
	// 	25
	// );

		
	remove_action(
		'woocommerce_shop_loop_item_title',
		'woocommerce_template_loop_product_title',
		10
	);
	add_action(
		'woocommerce_before_shop_loop_item_title',
		'woocommerce_template_loop_product_title',
		9
	);

	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
	add_action('woocommerce_before_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
