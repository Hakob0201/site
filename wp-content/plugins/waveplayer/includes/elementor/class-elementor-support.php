<?php
/**
 * Elementor_Support class
 *
 * @package WavePlayer/Elementor
 */

namespace PerfectPeach\WavePlayer;

use \Elementor\Plugin as Elementor;

defined( 'ABSPATH' ) || exit;

/**
 * Add support for the Elementor editor
 *
 * @package WavePlayer/Elementor
 */
class Elementor_Support {

	const VERSION                   = '1.0.0';
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
	const MINIMUM_PHP_VERSION       = '7.0';

	/**
	 * Add a call to the initialization function
	 *
	 * @since 3.0.0
	 */
	public static function load() {
		add_action( 'init', array( __CLASS__, 'init' ) );
	}

	/**
	 * Initialize the Elementor support callback functions
	 *
	 * @since 3.0.0
	 */
	public static function init() {
		require_once 'class-elementor-playlist-control.php';

		add_filter( 'elementor/editor/localize_settings', array( __CLASS__, 'localize_settings' ) );
		add_action( 'elementor/widgets/widgets_registered', array( __CLASS__, 'init_widgets' ) );
		add_action( 'elementor/controls/controls_registered', array( __CLASS__, 'init_controls' ) );
		add_action( 'elementor/editor/before_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );
	}

	/**
	 * Initialize the WavePlayer widget in the Elementor editor
	 *
	 * @since 3.0.0
	 */
	public static function init_widgets() {
		require_once __DIR__ . '/class-elementor-widget.php';

		Elementor::instance()->widgets_manager->register_widget_type( new Elementor_Widget() );
	}

	/**
	 * Initialize the custom controls for the WavePlayer widget
	 *
	 * @since 3.0.0
	 */
	public static function init_controls() {
		require_once __DIR__ . '/class-elementor-playlist-control.php';
		Elementor::$instance->controls_manager->register_control( 'playlist', new Elementor_Playlist_Control() );

		require_once __DIR__ . '/class-elementor-color-tuplet-control.php';
		Elementor::$instance->controls_manager->register_control( 'colorTuplet', new Elementor_Color_Tuplet_Control() );
	}

	/**
	 * Enqueue the styles and scripts required by the WavePlayer widget
	 *
	 * @since 3.0.0
	 */
	public static function enqueue_scripts() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		wp_register_style( 'waveplayer-elementor-playlist', plugins_url( "/assets/css/elementor/playlist-control$suffix.css", dirname( __DIR__ ) ), array(), waveplayer()->get_version() );
		wp_enqueue_style( 'waveplayer-elementor-playlist' );

		$deps = array( 'wp-util', 'lodash', 'mce-view', 'media-views', 'wp-i18n' );
		wp_register_script( 'waveplayer', plugins_url( '/assets/js/waveplayer.js', dirname( __DIR__ ) ), $deps, waveplayer()->get_version(), true );
		if ( function_exists( 'wp_add_inline_script' ) ) {
			wp_add_inline_script( 'waveplayer', waveplayer()->script_vars() );
		}

		wp_register_script( 'waveplayer_media_waveplayer', plugins_url( "/assets/js/media-waveplayer$suffix.js", dirname( __DIR__ ) ), $deps, waveplayer()->get_version(), true );

		wp_register_script( 'waveplayer-elementor-controls', plugins_url( "/assets/js/elementor/waveplayer-controls$suffix.js", dirname( __DIR__ ) ), array( 'jquery' ), waveplayer()->get_version(), true );
	}

	/**
	 * Add the relevant strings to the Elementor configuration
	 *
	 * @since  3.0.0
	 * @param  array $config The original array.
	 * @return array         The modified array.
	 */
	public static function localize_settings( $config ) {
		// translators: %s represents the number of selected tracks.
		$config['i18n']['playlist_tracks_selected']       = esc_html__( '%s Tracks Selected', 'waveplayer' );
		$config['i18n']['playlist_no_tracks_selected']    = esc_html__( 'No Tracks Selected', 'waveplayer' );
		$config['i18n']['delete_playlist']                = esc_html__( 'Reset WavePlayer Playlist', 'waveplayer' );
		$config['i18n']['dialog_confirm_playlist_delete'] = esc_html__( 'Are you sure you want to reset the playlist for this instance?', 'waveplayer' );
		$config['i18n']['insert_tracks']                  = esc_html__( 'Insert Tracks', 'waveplayer' );
		return $config;
	}

}

Elementor_Support::load();
