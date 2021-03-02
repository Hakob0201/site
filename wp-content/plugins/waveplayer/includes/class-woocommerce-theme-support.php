<?php
/**
 * WooCommerce_Theme_Support class
 *
 * @package WavePlayer/WooCommerce_Theme_Support
 */

namespace PerfectPeach\WavePlayer;

defined( 'ABSPATH' ) || exit;

/**
 * WooCommerce_Theme_Support class
 *
 * The WooCommerce class handles the integration between WavePlayer and WooCommerce
 *
 * @since 3.0.0
 * @package WavePlayer/WooCommerce_Theme_Support
 */
class WooCommerce_Theme_Support {

	/**
	 * Register the callback functions activating this class
	 *
	 * @since 3.0.0
	 */
	public static function load() {
		add_action( 'waveplayer_single_product_player_callback', array( __CLASS__, 'register_single_product_player_hooks' ), 10 );
		add_action( 'template_redirect', array( __CLASS__, 'register_shop_product_player_hooks' ), 20 );
	}

	/**
	 * Register the callback functions responsible for adding a player instance
	 * in the single product page.
	 * This is only required for themes that malfunction with the default methods
	 *
	 * @since 3.0.0
	 */
	public static function register_single_product_player_hooks() {

		$player_position                 = WooCommerce::product_player_position();
		$default_product_player_priority = WooCommerce::get_default_product_player_priority();
		$active_theme_name               = WooCommerce::get_active_theme_name();

		switch ( $active_theme_name ) {
			case 'thegem':
				$product_player_priority = array(
					'before'         => 9,
					'after'          => 11,
					'before_rating'  => 19,
					'after_price'    => 31,
					'before_excerpt' => 34,
					'after_excerpt'  => 36,
					'before_meta'    => 44,
					'after_meta'     => 46,
				);
				add_action( 'thegem_woocommerce_single_product_right', array( 'PerfectPeach\WavePlayer\WooCommerce', 'print_product_player' ), $default_product_player_priority[ $player_position ] );

				$product_player_priority = array(
					'before'         => 9,
					'after'          => 11,
					'before_rating'  => 19,
					'after_price'    => 31,
					'before_excerpt' => 34,
					'after_excerpt'  => 36,
					'before_meta'    => 54,
					'after_meta'     => 56,
				);
				add_action( 'thegem_woocommerce_single_product_quick_view_right', array( 'PerfectPeach\WavePlayer\WooCommerce', 'print_product_player' ), $default_product_player_priority[ $player_position ] );
				break;

			case 'oceanwp':
				remove_action( 'woocommerce_single_product_summary', array( __CLASS__, 'print_product_player' ), $default_product_player_priority[ $player_position ] );
				$product_player_action = array(
					'before'         => 'ocean_before_single_product_title',
					'after'          => 'ocean_after_single_product_title',
					'before_rating'  => 'ocean_before_single_product_rating',
					'after_price'    => 'ocean_after_single_product_price',
					'before_excerpt' => 'ocean_before_single_product_excerpt',
					'after_excerpt'  => 'ocean_after_single_product_excerpt',
					'before_meta'    => 'ocean_before_single_product_meta',
					'after_meta'     => 'ocean_after_single_product_meta',
				);
				add_action( $product_player_action[ $player_position ], array( 'PerfectPeach\WavePlayer\WooCommerce', 'print_product_player' ) );
				break;
		}

	}

	/**
	 * Register the callback functions responsible for adding a player instance
	 * in the single product page.
	 * This is only required for themes that malfunction with the default methods
	 *
	 * @since 3.0.0
	 */
	public static function register_shop_product_player_hooks() {

		$position = WooCommerce::shop_player_position();

		/**
		 * REHub theme support
		 *
		 * @since 3.0.4
		 */
		add_filter( 'rh_thumb_output', array( 'PerfectPeach\WavePlayer\WooCommerce', 'product_player_html' ) );

		/**
		 * OceanWP theme support
		 *
		 * @since 3.0.6
		 */
		if ( class_exists( 'OceanWP_WooCommerce_Config' ) ) {
			if ( WooCommerce::shall_remove_shop_thumbnail() ) {
				remove_action( "woocommerce_{$position}_shop_loop_item_title", array( 'OceanWP_WooCommerce_Config', 'loop_product_thumbnail' ), 10 );
				add_filter(
					'ocean_woo_product_elements_positioning',
					function( $sections ) {
						return array_diff( $sections, array( 'image' ) );
					}
				);
			}
			if ( 'none' !== $position ) {
				remove_action( "woocommerce_{$position}_shop_loop_item_title", array( 'PerfectPeach\WavePlayer\WooCommerce', 'print_product_player' ), 10 );
				add_action( "ocean_{$position}_archive_product_title", array( 'PerfectPeach\WavePlayer\WooCommerce', 'print_product_player' ), 10 );
				add_action( 'ocean_woo_quick_view_product_content', array( 'PerfectPeach\WavePlayer\WooCommerce', 'print_product_player' ), 10 );

			}
		}
	}
}

WooCommerce_Theme_Support::load();
