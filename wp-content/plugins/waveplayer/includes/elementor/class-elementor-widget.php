<?php
/**
 * Elementor_Widget class
 *
 * @package WavePlayer/Elementor
 */

namespace PerfectPeach\WavePlayer;

use \Elementor\Controls_Manager as Controls_Manager;
use \Elementor\Repeater as Repeater;

/**
 * Elementor_Widget class
 *
 * @package WavePlayer/Elementor
 */
class Elementor_Widget extends \Elementor\Widget_Base {

	/**
	 * The constructor of the widget
	 *
	 * @since 3.0.0
	 * @param array $data The data to build the widget.
	 * @param array $args THe arguments passed to the widget.
	 */
	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		wp_register_style( 'waveplayer-widget', plugins_url( "/assets/css/elementor/waveplayer-widget$suffix.css", dirname( __DIR__ ) ), array(), waveplayer()->get_version() );
	}

	/**
	 * Redefines the default get_name method of the base class
	 *
	 * @since  3.0.0
	 * @return string The name of the widget
	 */
	public function get_name() {
		return 'waveplayer';
	}

	/**
	 * Redefines the default get_title method of the base class
	 *
	 * @since  3.0.0
	 * @return string The title of the widget
	 */
	public function get_title() {
		return esc_html__( 'WavePlayer', 'waveplayer' );
	}

	/**
	 * Redefines the default get_icon method of the base class
	 *
	 * @since  3.0.0
	 * @return string The icon of the widget
	 */
	public function get_icon() {
		return 'waveplayer-widget-icon';
	}

	/**
	 * Redefines the default get_categories method of the base class
	 *
	 * @since  3.0.0
	 * @return array The categories of the widget
	 */
	public function get_categories() {
		return array( 'general' );
	}

	/**
	 * Redefines the default get_keywords method of the base class
	 *
	 * @since  3.0.0
	 * @return array The keywords of the widget
	 */
	public function get_keywords() {
		return array( 'audio', 'player', 'waveform', 'wave', 'sound' );
	}

	/**
	 * Redefines the default get_script_depends method of the base class
	 *
	 * @since  3.0.0
	 * @return array The script dependencies of the widget
	 */
	public function get_script_depends() {
		return array( 'waveplayer' );
	}

	/**
	 * Redefines the default get_style_depends method of the base class
	 *
	 * @since  3.0.0
	 * @return array The style dependencies of the widget
	 */
	public function get_style_depends() {
		return array( 'waveplayer-widget' );
	}

	/**
	 * Redefines the default get_custom_help_url method of the base class
	 *
	 * @since  3.0.0
	 * @return string The custom help URL of the widget
	 */
	public function get_custom_help_url() {
		return 'https://waveplayer.info';
	}

	/**
	 * Register the controls for the widget
	 *
	 * @since  3.0.0
	 */
	protected function _register_controls() { // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore

		$this->register_player_controls();
		$this->register_aspect_controls();
		$this->register_waveform_color_controls();
		$this->register_waveform_option_controls();

	}

	/**
	 * Register the controls for the player section of the widget
	 *
	 * @since  3.0.0
	 */
	private function register_player_controls() {

		$this->start_controls_section(
			'player_options',
			array(
				'label' => esc_html__( 'Player Options', 'waveplayer' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'type',
			array(
				'label'   => esc_html__( 'Audio file location', 'waveplayer' ),
				'type'    => Controls_Manager::CHOOSE,
				'toggle'  => false,
				'options' => array(
					'internal' => array(
						'title' => esc_html__( 'Internal (Media library)', 'waveplayer' ),
						'icon'  => 'fa fa-music',
					),
					'external' => array(
						'title' => esc_html__( 'External', 'waveplayer' ),
						'icon'  => 'fa fa-external-link',
					),
					'product'  => array(
						'title' => esc_html__( 'WooCommerce Preview File', 'waveplayer' ),
						'icon'  => 'fa fa-box',
					),
				),
				'default' => 'internal',
			)
		);

		$this->add_control(
			'ids',
			array(
				'label'      => esc_html__( 'Audio files from the Media Library', 'waveplayer' ),
				'type'       => 'playlist',
				'media_type' => 'audio',
				'condition'  => array( 'type' => 'internal' ),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'url',
			array(
				'label'       => esc_html__( 'URL', 'waveplayer' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => 'paste or type the URL here',
			)
		);

		$this->add_control(
			'url_list',
			array(
				'label'     => esc_html__( 'External audio files', 'waveplayer' ),
				'type'      => Controls_Manager::REPEATER,
				'fields'    => $repeater->get_controls(),
				'condition' => array( 'type' => 'external' ),
				'default'   => array(
					array(
						'title'   => esc_html__( 'URL #1', 'waveplayer' ),
						'content' => '',
					),
				),
			)
		);

		$this->add_control(
			'product_note',
			array(
				'label'     => esc_html__( 'WooCommerce Preview File', 'waveplayer' ),
				'type'      => Controls_Manager::RAW_HTML,
				'raw'       => '<p class="elementor-control-field-description">' . esc_html__( 'This mode is meant to be used with WooCommerce template builders for instances that are inside a WooCoommerce loop. The player will automatically include all the tracks listed as preview files for the current product in the WooCommerce loop.', 'waveplayer' ) . '</p>',
				'condition' => array( 'type' => 'product' ),
			)
		);

		$this->end_controls_section();

	}

	/**
	 * Register the controls for the aspect section of the widget
	 *
	 * @since  3.0.0
	 */
	private function register_aspect_controls() {

		$this->start_controls_section(
			'aspect_options',
			array(
				'label' => esc_html__( 'Visual Aspect', 'waveplayer' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$skins            = Renderer::get_skins();
		$skin_options     = array_combine(
			array_map(
				function( $s ) {
					return $s['skin'];
				},
				$skins
			),
			array_map(
				function( $s ) {
					return $s['name'];
				},
				$skins
			)
		);
		$skins_with_size  = array_values(
			array_map(
				function( $s ) {
					return $s['skin'];
				},
				array_filter(
					$skins,
					function( $s ) {
						return in_array( 'size', $s['support'], true );
					}
				)
			)
		);
		$skins_with_shape = array_values(
			array_map(
				function( $s ) {
					return $s['skin'];
				},
				array_filter(
					$skins,
					function( $s ) {
						return in_array( 'shape', $s['support'], true );
					}
				)
			)
		);

		$palettes        = Renderer::get_palettes();
		$palette_options = array_combine(
			array_map(
				function( $s ) {
					return $s['colors'];
				},
				$palettes
			),
			array_map(
				function( $s ) {
					return $s['name'];
				},
				$palettes
			)
		);

		$this->add_control(
			'skin',
			array(
				'label'   => esc_html__( 'Skin', 'waveplayer' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $skin_options,
				'default' => waveplayer()->get_option( 'skin' ),
			)
		);

		$this->add_control(
			'palette',
			array(
				'label'   => esc_html__( 'Palette', 'waveplayer' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $palette_options,
				'default' => waveplayer()->get_option( 'default_palette' ),
			)
		);
		$this->add_control(
			'override_wave_colors',
			array(
				'label'        => esc_html__( 'Palette overrides default waveform colors', 'waveplayer' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => '1',
				'default'      => 1 === (int) waveplayer()->get_option( 'override_wave_colors' ),
			)
		);

		$this->add_control(
			'style',
			array(
				'label'   => esc_html__( 'Style', 'waveplayer' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'light'        => 'Light',
					'dark'         => 'Dark',
					'color-scheme' => 'Follow Color Scheme',
				),
				'default' => waveplayer()->get_option( 'style' ),
			)
		);

		$this->add_control(
			'size',
			array(
				'label'     => esc_html__( 'Sizing', 'waveplayer' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'xs' => esc_html__( 'Extra Small', 'waveplayer' ),
					'sm' => esc_html__( 'Small', 'waveplayer' ),
					'md' => esc_html__( 'Medium', 'waveplayer' ),
					'lg' => esc_html__( 'Large', 'waveplayer' ),
				),
				'condition' => array(
					'skin' => $skins_with_size,
				),
				'default'   => waveplayer()->get_option( 'size' ),
			)
		);

		$this->add_control(
			'shape',
			array(
				'label'     => esc_html__( 'Shape', 'waveplayer' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'square'  => esc_html__( 'Square', 'waveplayer' ),
					'circle'  => esc_html__( 'Circle', 'waveplayer' ),
					'rounded' => esc_html__( 'Rounded', 'waveplayer' ),
				),
				'condition' => array(
					'skin' => $skins_with_shape,
				),
				'default'   => waveplayer()->get_option( 'shape' ),
			)
		);

		$this->end_controls_section();

	}

	/**
	 * Register the controls for the waveform color section of the widget
	 *
	 * @since  3.0.0
	 */
	private function register_waveform_color_controls() {

		$this->start_controls_section(
			'waveform_color',
			array(
				'label' => esc_html__( 'Waveform Colors', 'waveplayer' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$colors = array(
			'wave_color'     => 'Wave Colors',
			'progress_color' => 'Progress Colors',
			'cursor_color'   => 'Cursor Colors',
		);

		foreach ( $colors as $key => $label ) {
			$this->add_control(
				$key,
				array(
					'label'   => esc_html__( $label, 'waveplayer' ), // phpcs:ignore WordPress.WP.I18n.NonSingularStringLiteralText
					'type'    => 'colorTuplet',
					'default' => array(
						$key       => waveplayer()->get_option( $key ),
						"{$key}_2" => waveplayer()->get_option( "{$key}_2" ),
					),
				)
			);
		}

		$this->end_controls_section();

	}

	/**
	 * Register the controls for the waveform option section of the widget
	 *
	 * @since  3.0.0
	 */
	private function register_waveform_option_controls() {

		$this->start_controls_section(
			'waveform_options',
			array(
				'label' => esc_html__( 'Waveform Options', 'waveplayer' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'cursor_width',
			array(
				'label'   => esc_html__( 'Cursor width', 'waveplayer' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'0' => 'No cursor',
					'1' => 'Thin (1px)',
					'2' => 'Regular (2px)',
					'4' => 'Thick (4px)',
				),
				'default' => waveplayer()->get_option( 'cursor_width' ),
			)
		);
		$this->add_control(
			'wave_mode',
			array(
				'label'      => esc_html__( 'Bar width', 'waveplayer' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 10,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => waveplayer()->get_option( 'wave_mode' ),
				),
			)
		);
		$this->add_control(
			'gap_width',
			array(
				'label'      => esc_html__( 'Gap width', 'waveplayer' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 10,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => waveplayer()->get_option( 'gap_width' ),
				),
			)
		);
		$this->add_control(
			'wave_normalization',
			array(
				'label'   => esc_html__( 'Visual Normalization', 'waveplayer' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => waveplayer()->get_option( 'wave_normalization' ),
			)
		);
		$this->add_control(
			'wave_compression',
			array(
				'label'   => esc_html__( 'Visual Compression', 'waveplayer' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'1' => esc_html__( 'None (linear)', 'waveplayer' ),
					'2' => esc_html__( 'Moderate (square)', 'waveplayer' ),
					'3' => esc_html__( 'High (cubic)', 'waveplayer' ),
					'4' => esc_html__( 'Very high (4th order)', 'waveplayer' ),
					'5' => esc_html__( 'Extreme (5th order)', 'waveplayer' ),
				),
				'default' => waveplayer()->get_option( 'wave_compression' ),
			)
		);

		$this->add_control(
			'wave_asymmetry',
			array(
				'label'   => esc_html__( 'Asymmetry', 'waveplayer' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'1'       => esc_html__( '1/2 + 1/2', 'waveplayer' ),
					'2'       => esc_html__( '2/3 + 1/3', 'waveplayer' ),
					'3'       => esc_html__( '3/4 + 1/4', 'waveplayer' ),
					'4'       => esc_html__( '4/5 + 1/5', 'waveplayer' ),
					'99999'   => esc_html__( 'top only', 'waveplayer' ),
					'0.00001' => esc_html__( 'bottom only', 'waveplayer' ),
				),
				'default' => waveplayer()->get_option( 'wave_asymmetry' ),
			)
		);

		$this->add_control(
			'wave_animation',
			array(
				'label'   => esc_html__( 'Animation speed', 'waveplayer' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'1'    => esc_html__( 'No animation', 'waveplayer' ),
					'0.85' => esc_html__( 'Slow', 'waveplayer' ),
					'0.7'  => esc_html__( 'Smooth', 'waveplayer' ),
					'0.55' => esc_html__( 'Normal', 'waveplayer' ),
					'0.4'  => esc_html__( 'Fast', 'waveplayer' ),
					'0.25' => esc_html__( 'Hectic', 'waveplayer' ),
				),
				'default' => waveplayer()->get_option( 'wave_animation' ),
			)
		);

		$this->add_control(
			'amp_freq_ratio',
			array(
				'label'     => esc_html__( 'Animation speed', 'waveplayer' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'4'        => esc_html__( 'mostly amplitude', 'waveplayer' ),
					'2'        => esc_html__( 'more amplitude', 'waveplayer' ),
					'1'        => esc_html__( 'amplitude and frequency equally', 'waveplayer' ),
					'0.5'      => esc_html__( 'more frequency', 'waveplayer' ),
					'0.25'     => esc_html__( 'mostly frequency', 'waveplayer' ),
					'0.000061' => esc_html__( 'frequency only', 'waveplayer' ),
				),
				'condition' => array( 'wave_animation!' => '1' ),
				'default'   => waveplayer()->get_option( 'amp_freq_ratio' ),
			)
		);

		$this->end_controls_section();

	}

	/**
	 * Output the player
	 *
	 * @since  3.0.0
	 */
	protected function render() {
		$settings  = $this->get_settings_for_display();
		$ids       = array();
		$url_array = array();
		if ( 'internal' === $settings['type'] ) {
			$ids = array_map(
				function( $item ) {
					return $item['id'];
				},
				$settings['ids']
			);
		} elseif ( 'external' === $settings['type'] ) {
			$url_array = array_filter(
				array_map(
					function( $url ) {
						return $url['url'];
					},
					$settings['url_list']
				)
			);
			// phpcs:disable Generic.Commenting.Todo.TaskFound
			// } elseif ( 'product' === $settings['type'] ) {
			// TODO: nothing to do here for now.
			// phpcs:enable
		}
		$atts = array_filter(
			array_intersect_key(
				$settings,
				array_flip(
					array(
						'ids',
						'url',
						'type',
						'skin',
						'palette',
						'style',
						'size',
						'shape',
						'override_wave_colors',
						'wave_animation',
						'wave_normalization',
						'wave_compression',
						'wave_asymmetry',
					)
				)
			)
		);

		if ( ! isset( $atts['override_wave_colors'] ) ) {
			$atts['override_wave_colors'] = '0';
		}

		$atts              = array_merge( $atts, $settings['wave_color'], $settings['progress_color'], $settings['cursor_color'] );
		$atts['wave_mode'] = $settings['wave_mode']['size'];
		$atts['gap_width'] = $settings['gap_width']['size'];
		if ( 1 === (int) $settings['wave_animation'] ) {
			$atts['amp_freq_ratio'] = $settings['amp_freq_ratio'];
		}
		$atts['ids'] = implode( ',', $ids );
		$atts['url'] = implode( ',', $url_array );

		if ( count( $ids ) + count( $url_array ) === 0 && 'product' !== $atts['type'] ) {
			return;
		}

		echo Renderer::waveplayer_shortcode( $atts ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

}
