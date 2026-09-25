<?php
/**
 * WooCommerce support.
 *
 * A clinic that sells health checks, gift cards or travel packs ends up with
 * WooCommerce, and Woo's markup answers to none of the theme's tokens. This
 * declares support and loads the mapping stylesheet — but only on the pages
 * that need it, so a shop of three products does not add shop CSS to every page.
 *
 * @package Docmed
 */

defined( 'ABSPATH' ) || exit;

/**
 * Declare support, and turn off Woo's own layout wrappers.
 *
 * A block theme supplies its own templates; Woo's `woocommerce_content`
 * wrappers would nest a second container inside them.
 */
function docmed_woocommerce_setup() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'docmed_woocommerce_setup' );

/**
 * Load the mapping stylesheet where a shop can appear.
 *
 * `is_woocommerce()` covers shop, product and product taxonomy pages but not
 * cart, checkout or account, so those are named. A shortcode or block dropped
 * on an arbitrary page is caught by the body class check Woo adds.
 */
function docmed_woocommerce_styles() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	$needed = is_woocommerce() || is_cart() || is_checkout() || is_account_page();

	/**
	 * Filters whether the WooCommerce stylesheet loads on this request.
	 *
	 * @param bool $needed Whether to load it.
	 */
	if ( ! apply_filters( 'docmed_load_woocommerce_styles', $needed ) ) {
		return;
	}

	wp_enqueue_style(
		'docmed-woocommerce',
		get_template_directory_uri() . '/assets/css/woocommerce.css',
		array( 'docmed-style' ),
		DOCMED_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'docmed_woocommerce_styles', 20 );

/**
 * Three products to a row, matching the stylesheet's grid.
 *
 * @return int
 */
function docmed_woocommerce_columns() {
	return 3;
}
add_filter( 'loop_shop_columns', 'docmed_woocommerce_columns' );
