<?php
/**
 * Elementor_Playlist_Control class
 *
 * @package WavePlayer/Elementor
 */

namespace PerfectPeach\WavePlayer;

use \Elementor\Plugin as Elementor;

defined( 'ABSPATH' ) || exit;


/**
 * Elementor_Playlist_Control class
 *
 * @package WavePlayer/Elementor
 */
class Elementor_Playlist_Control extends \Elementor\Base_Data_Control {

	/**
	 * Redefines the default get_type method of the base class
	 *
	 * @since  3.0.0
	 * @return string The type of control
	 */
	public function get_type() {
		return 'playlist';
	}

	/**
	 * Return the attachment array
	 *
	 * @since  3.0.0
	 * @param  array $settings The current settings of the control.
	 * @return array
	 */
	public function on_import( $settings ) {
		foreach ( $settings as &$attachment ) {
			if ( empty( $attachment['url'] ) ) {
				continue;
			}

			$attachment = Elementor::$instance->templates_manager->get_import_images_instance()->import( $attachment );
		}

		$settings = array_filter( $settings );

		return $settings;
	}

	/**
	 * Output the HTML markup of the control template
	 *
	 * @since  3.0.0
	 */
	public function content_template() {
		?>
		<div class="elementor-control-field">
			<div class="elementor-control-title">{{{ data.label }}}</div>
			<div class="elementor-control-input-wrapper">
				<# if ( data.description ) { #>
				<div class="elementor-control-field-description">{{{ data.description }}}</div>
				<# } #>
				<div class="elementor-control-media__content elementor-control-tag-area">
					<div class="elementor-control-playlist-status elementor-control-dynamic-switcher-wrapper">
						<span class="elementor-control-playlist-status-title"></span>
						<span class="elementor-control-playlist-clear elementor-control-unit-1"><i class="eicon-trash-o" aria-hidden="true"></i></span>
					</div>
					<div class="elementor-control-playlist-content">
						<div class="elementor-control-playlist-thumbnails"></div>
						<div class="elementor-control-playlist-edit"><span><i class="eicon-pencil" aria-hidden="true"></i></span></div>
						<button class="elementor-button elementor-control-playlist-add" aria-label="<?php esc_attr_e( 'Add Tracks', 'waveplayer' ); ?>"><i class="eicon-plus-circle" aria-hidden="true"></i></button>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Return the default settings for the control
	 *
	 * @since  3.0.0
	 * @return array
	 */
	protected function get_default_settings() {
		return array(
			'label_block' => true,
			'separator'   => 'none',
			'dynamic'     => array(
				'categories' => array( 'playlist' ),
				'returnType' => 'object',
			),
		);
	}

	/**
	 * Return the default value for the control
	 *
	 * @since  3.0.0
	 * @return array
	 */
	public function get_default_value() {
		return array();
	}

	/**
	 * Enqueue the required scripts
	 *
	 * @since  3.0.0
	 */
	public function enqueue() {
		wp_enqueue_script( 'waveplayer' );
		wp_enqueue_script( 'waveplayer_media_waveplayer' );
		wp_enqueue_script( 'waveplayer-elementor-controls' );
	}

}
