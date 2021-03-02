<?php
/**
 * Provide an array of options for the WavePlayer settings
 *
 * @package WavePlayer/Admin
 */

defined( 'ABSPATH' ) || exit;

$waveplayer_admin_page_options = array(

	'player'       => array(
		'label'       => esc_html__( 'Player', 'waveplayer' ),
		'title'       => esc_html__( 'Player Default Options', 'waveplayer' ),
		'description' => esc_html__( 'If one of the following parameters is not specified in a shortcode, the player is going to use the following default settings.', 'waveplayer' ),
		'settings'    => array(
			'autoplay'            => array(
				'label'       => esc_html__( 'Autoplay', 'waveplayer' ),
				'type'        => 'checkbox',
				'description' => esc_html__( 'If checked, the player will start playing back its playlist as soon as the page that contains it finishes loading up.', 'waveplayer' ),
				'value'       => 1,
			),
			'repeat'              => array(
				'label'       => esc_html__( 'Repeat all', 'waveplayer' ),
				'type'        => 'checkbox',
				'description' => esc_html__( 'If checked, the player will continuously play back its playlist. At the end of the last track, the player will restart from the first one.', 'waveplayer' ),
				'value'       => 1,
			),
			'shuffle'             => array(
				'label'       => esc_html__( 'Shuffle', 'waveplayer' ),
				'type'        => 'checkbox',
				'description' => esc_html__( 'If checked, the tracks of each player will be shuffled in a random order every time the page containing the player loads.', 'waveplayer' ),
				'value'       => 1,
			),
			'audio_override'      => array(
				'label'       => esc_html__( 'Audio override', 'waveplayer' ),
				'type'        => 'checkbox',
				'description' => wp_kses( __( 'If checked, every <code>[audio]</code> and <code>[playlist]</code> shortcode will be replaced with WavePlayer.', 'waveplayer' ), 'post' ),
				'value'       => 1,
			),
			'jump'                => array(
				'label'       => esc_html__( 'Jump to the next player', 'waveplayer' ),
				'type'        => 'checkbox',
				'description' => esc_html__( 'If checked, upon completion of a playlist, the next player in the page will start.', 'waveplayer' ),
				'value'       => 1,
			),
			'media_library_title' => array(
				'label'       => esc_html__( 'Use title in Media Library thumbnail', 'waveplayer' ),
				'type'        => 'checkbox',
				'description' => esc_html__( 'By default, WordPress uses file names to describe the thumbnail of an audio track in the Media Library. Setting this option, the thumbnail will display the title instead.', 'waveplayer' ),
				'value'       => 1,
			),
		),
	),

	'style'        => array(
		'label'       => esc_html__( 'Style', 'waveplayer' ),
		'title'       => esc_html__( 'Styling Options', 'waveplayer' ),
		'description' => esc_html__( 'A WavePlayer instance will follow the default values. You can ovverride each option when adding a new instance to a post or page.', 'waveplayer' ),
		'settings'    => array(
			'skin'                   => array(
				'label'            => esc_html__( 'Skin', 'waveplayer' ),
				'type'             => 'select',
				'description'      => esc_html__( 'Select the skin for the default player instances.', 'waveplayer' ),
				'options_callback' => array( '\PerfectPeach\WavePlayer\Renderer', 'get_skin_options' ),
				'callback_params'  => array( '' ),
			),
			'style'                  => array(
				'label'       => esc_html__( 'Style', 'waveplayer' ),
				'type'        => 'select',
				'description' => wp_kses( __( 'The style of the interface can be set to follow the <code>prefers-color-scheme</code> of the device or forced to <strong>light</strong> or <strong>dark</strong><br/>Modern browsers can now react to the the <strong>light</strong> or <strong>dark</strong> mode of the user device.', 'waveplayer' ), 'post' ),
				'options'     => array(
					'light'                => array(
						'label' => esc_html__( 'Light', 'waveplayer' ),
						'value' => 'light',
					),
					'dark'                 => array(
						'label' => esc_html__( 'Dark', 'waveplayer' ),
						'value' => 'dark',
					),
					'prefers-color-scheme' => array(
						'label' => esc_html__( 'Use "prefers-color-scheme" setting', 'waveplayer' ),
						'value' => 'color-scheme',
					),
				),
			),
			'size'                   => array(
				'label'       => esc_html__( 'Size', 'waveplayer' ),
				'type'        => 'select',
				'description' => esc_html__( 'The player comes in four different sizes: large, medium, small and extra small, that correspond to heights of 200px, 160px, 120px and 80 px respectively.', 'waveplayer' ),
				'options'     => array(
					'large'  => array(
						'label' => esc_html__( 'Large', 'waveplayer' ),
						'value' => 'lg',
					),
					'medium' => array(
						'label' => esc_html__( 'Medium', 'waveplayer' ),
						'value' => 'md',
					),
					'small'  => array(
						'label' => esc_html__( 'Small', 'waveplayer' ),
						'value' => 'sm',
					),
					'xsmall' => array(
						'label' => esc_html__( 'Extra Small', 'waveplayer' ),
						'value' => 'xs',
					),
				),
			),
			'shape'                  => array(
				'label'       => esc_html__( 'Shape', 'waveplayer' ),
				'type'        => 'select',
				'description' => esc_html__( 'The thumbnail of the active track is displayed inside a container that can have three different shapes: square, circle and rounded.', 'waveplayer' ),
				'options'     => array(
					'square'  => array(
						'label' => esc_html__( 'Square', 'waveplayer' ),
						'value' => 'square',
					),
					'circle'  => array(
						'label' => esc_html__( 'Circle', 'waveplayer' ),
						'value' => 'circle',
					),
					'rounded' => array(
						'label' => esc_html__( 'Rounded', 'waveplayer' ),
						'value' => 'rounded',
					),
				),
			),
			'default_font'           => array(
				'label'            => esc_html__( 'Default font', 'waveplayer' ),
				'type'             => 'select',
				'description'      => wp_kses( __( 'Select the font for the default player instances. This is a list of the 50 most popular Google Fonts. By selecting <strong>\'default\'</strong>, WavePlayer will inherit the font of its container.', 'waveplayer' ), 'post' ),
				'options_callback' => array( '\PerfectPeach\WavePlayer\Admin', 'get_google_fonts_options' ),
				'callback_params'  => array( '' ),
			),
			'base_font_size'         => array(
				'label'       => esc_html__( 'Base font size', 'waveplayer' ),
				'type'        => 'number',
				'description' => esc_html__( 'Select the base font size of the texts in the player.', 'waveplayer' ),
			),
			'sticky_player_position' => array(
				'label'       => esc_html__( 'Sticky Player Position', 'waveplayer' ),
				'type'        => 'select',
				'description' => esc_html__( 'Select whether the sticky player is going to be disabled or show at the top or bottom of the window.', 'waveplayer' ),
				'options'     => array(
					'disabled' => array(
						'label' => esc_html__( 'Disabled', 'waveplayer' ),
						'value' => 'disabled',
					),
					'bottom'   => array(
						'label' => esc_html__( 'Bottom', 'waveplayer' ),
						'value' => 'bottom',
					),
					'top'      => array(
						'label' => esc_html__( 'Top', 'waveplayer' ),
						'value' => 'top',
					),
				),
			),
			'info'                   => array(
				'label'       => esc_html__( 'Display Info', 'waveplayer' ),
				'type'        => 'select',
				'description' => esc_html__( 'Select whether to display the info bar, the playlist or nothing.', 'waveplayer' ),
				'options'     => array(
					'none'     => array(
						'label' => esc_html__( 'None', 'waveplayer' ),
						'value' => 'none',
					),
					'info'     => array(
						'label' => esc_html__( 'Info bar', 'waveplayer' ),
						'value' => 'info',
					),
					'playlist' => array(
						'label' => esc_html__( 'Info bar and playlist', 'waveplayer' ),
						'value' => 'playlist',
					),
				),
			),
			'full_width_playlist'    => array(
				'label'       => esc_html__( 'Full width playlist', 'waveplayer' ),
				'type'        => 'checkbox',
				'description' => esc_html__( 'If checked, the playlist will span across the full width of the player, instead of just under the waveform.', 'waveplayer' ),
				'value'       => 1,
			),
			'default_thumbnail'      => array(
				'label'       => esc_html__( 'Default thumbnail', 'waveplayer' ),
				'type'        => 'picture',
				'description' => esc_html__( 'Set the image to be displayed as a default thumbnail, whenever an audio track has no featured image associated.', 'waveplayer' ),
				'value'       => 1,
			),
			'default_thumbnail_size' => array(
				'label'            => esc_html__( 'Default thumbnail size', 'waveplayer' ),
				'type'             => 'select',
				'description'      => esc_html__( 'For better results, we recommend to select square sizes.', 'waveplayer' ),
				'options_callback' => array( '\PerfectPeach\WavePlayer\Renderer', 'get_registered_image_sizes' ),
				'callback_params'  => array( '' ),
			),
		),
	),

	'palettes'     => array(
		'label'       => esc_html__( 'Palettes', 'waveplayer' ),
		'title'       => esc_html__( 'Player Palettes', 'waveplayer' ),
		'description' => esc_html__( 'Here you can change the basic colors applying to every skin, such as text, border or background colors. You can also create your own palette to easily switch between different configurations.', 'waveplayer' ),
		'settings'    => array(),
	),

	'waveform'     => array(
		'label'       => esc_html__( 'Waveform', 'waveplayer' ),
		'title'       => esc_html__( 'Waveform Options and Colors', 'waveplayer' ),
		'description' => esc_html__( 'If one of the following parameters is not specified in a shortcode, the player is going to use the following default settings.', 'waveplayer' ),
		'settings'    => array(),
	),

	'placeholders' => array(
		'label'    => esc_html__( 'Placeholders', 'waveplayer' ),
		'title'    => esc_html__( 'Placeholder Templates', 'waveplayer' ),
		'settings' => array(),
	),

	'advanced'     => array(
		'label'       => esc_html__( 'Advanced', 'waveplayer' ),
		'title'       => esc_html__( 'Advanced', 'waveplayer' ),
		'description' => esc_html__( 'You can add your custom CSS rulesets and Javascript functions in the text area below', 'waveplayer' ),
		'settings'    => array(
			'custom_css' => array(
				'label' => esc_html__( 'Custom CSS', 'waveplayer' ),
				'type'  => 'textarea',
				'value' => '',
				'rows'  => 20,
				'class' => 'monospace',
			),
			'custom_js'  => array(
				'label' => esc_html__( 'Custom Javascript', 'waveplayer' ),
				'type'  => 'textarea',
				'value' => '',
				'rows'  => 20,
				'class' => 'monospace',
			),
		),
	),

	'woocommerce'  => array(
		'label'     => esc_html__( 'WooCommerce', 'waveplayer' ),
		'title'     => esc_html__( 'WooCommerce Options', 'waveplayer' ),
		'condition' => defined( 'WC_VERSION' ),
		'settings'  => array(),
	),

	'tools'        => array(
		'label'    => esc_html__( 'Tools', 'waveplayer' ),
		'title'    => esc_html__( 'Tools', 'waveplayer' ),
		'settings' => array(),
	),

);
