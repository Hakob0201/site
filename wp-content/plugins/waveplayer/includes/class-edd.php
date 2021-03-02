<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName
/**
 * EasyDigitalDownloads class
 *
 * @package WavePlayer/EDD
 */

namespace PerfectPeach\WavePlayer;

defined( 'ABSPATH' ) || exit;

/**
 * EasyDigitalDownloads class
 *
 * The WooCommerce class handles the integration between WavePlayer and WooCommerce
 *
 * @since 3.0.10
 * @package WavePlayer/EDD
 */
class EasyDigitalDownloads {

	/**
	 * Loads the EasyDigitalDownloads integration
	 */
	public static function load() {
		add_action( 'init', array( __CLASS__, 'register_hooks' ) );
	}

	/**
	 * Registers all the hooks to integrate WavePlayer into EasyDigitalDownloads
	 *
	 * @since 3.0.10
	 */
	public static function register_hooks() {
		add_action( 'edd_purchase_link_top', array( __CLASS__, 'edd_player' ), 10 );
	}

	/**
	 * Get the HTML markup of the player that includes
	 * all the preview files associated with a EDD product
	 *
	 * @since  3.0.10
	 */
	public static function edd_player() {
		$file = get_post_meta( get_the_ID(), '_preview_files', true );

		if ( $file ) {
			echo do_shortcode( "[waveplayer url='$file']" );
		}
	}

}

EasyDigitalDownloads::load();
