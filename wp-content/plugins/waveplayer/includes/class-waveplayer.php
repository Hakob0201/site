<?php
/**
 * WooCommerce class
 *
 * @package WavePlayer/WavePlayer
 */

namespace PerfectPeach\WavePlayer;

defined( 'ABSPATH' ) || exit;

/**
 * WavePlayer class
 *
 * The main class of the plugin
 *
 * @since 3.0.0
 * @package WavePlayer/WavePlayer
 */
class WavePlayer {

	/**
	 * The WavePlayer version
	 *
	 * @var string
	 */
	private $version = '';

	/**
	 * Store the current WavePlayer instance
	 *
	 * @var WavePlayer
	 */
	private static $instance = null;

	/**
	 * An array with all the WavePlayer settings
	 *
	 * @var array
	 */
	private $options;

	/**
	 * Return the singleton class instance
	 *
	 * @since 3.0.0
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Deal with instance cloning
	 *
	 * @since 3.0.0
	 */
	public function __clone() {
		// phpcs:ignore Generic.Commenting.Todo.TaskFound
		// TODO: Add error message.
	}

	/**
	 * Deal with instance waking up
	 *
	 * @since 3.0.0
	 */
	public function __wakeup() {
		// phpcs:ignore Generic.Commenting.Todo.TaskFound
		// TODO: Add error message.
	}

	/**
	 * Main class constructor
	 *
	 * @since 3.0.0
	 */
	private function __construct() {
		add_action( 'plugins_loaded', array( $this, 'load' ) );
		add_action( 'plugins_loaded', array( $this, 'init_filesystem' ) );
	}

	/**
	 * Return the current WavePlayer version
	 *
	 * @since 3.0.0
	 * @return string The current WavePlayer version
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Load the necessary resources
	 *
	 * @since 3.0.0
	 */
	public function load() {
		if ( is_admin() ) {
			if ( ! function_exists( 'get_plugin_data' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}
			$plugin_data   = get_plugin_data( dirname( __DIR__ ) . '/waveplayer.php' );
			$this->version = $plugin_data['Version'];
		}

		$this->require_for_all();

		$request_type = $this->request_type();
		if ( $request_type ) {
			$this->{"require_for_$request_type"}();
		}

	}

	/**
	 * Return the environment where the class was invoked
	 *
	 * @since  3.0.0
	 * @return string
	 */
	private function request_type() {
		if ( is_admin() ) {
			return 'admin';
		}

		if ( $this->is_rest_request() ) {
			return 'rest';
		}

		if ( $this->is_ajax() ) {
			return 'ajax';
		}

		if ( $this->is_json_request() ) {
			return 'json';
		}

		if ( ! wp_doing_cron() && ! $this->is_json_request() ) {
			return 'frontend';
		}
	}

	/**
	 * Check whether the current request is an AJAX request
	 *
	 * @since 3.0.0
	 * @return boolean
	 */
	public function is_ajax() {
		return ( ! empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( 'xmlhttprequest' === strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) ) // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
				|| ( isset( $_SERVER['HTTP_X_PJAX'] ) && (bool) $_SERVER['HTTP_X_PJAX'] )
				|| ( isset( $_SERVER['X_PJAX'] ) && (bool) $_SERVER['X_PJAX'] )
				|| ( isset( $_SERVER['HTTP_X_BARBA'] ) && 'yes' === $_SERVER['HTTP_X_BARBA'] );
	}

	/**
	 * Check whether the current request is a JSON request
	 *
	 * @since 3.0.0
	 * @return boolean
	 */
	public function is_json_request() {
		return ( function_exists( 'wp_is_json_request' ) && wp_is_json_request() );
	}

	/**
	 * Check whether the current request is a JSON request
	 *
	 * @since 3.1.0
	 * @return boolean
	 */
	public function is_rest_request() {
		if ( 'edit' === filter_input( INPUT_GET, 'context', FILTER_SANITIZE_STRING ) ) {
			return false;
		}

		return ( defined( 'REST_REQUEST' ) && REST_REQUEST );
	}

	/**
	 * Check whether the current request is from the frontend
	 *
	 * @since 3.0.0
	 * @return boolean
	 */
	public function is_frontend() {
		return ( $this->request_type() === 'frontend' );
	}

	/**
	 * Load the resources needed for every type of request
	 *
	 * @since 3.0.0
	 */
	private function require_for_all() {

		if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
			require_once ABSPATH . '/wp-admin/includes/plugin.php';
		}

		require_once __DIR__ . '/class-admin.php';
		require_once __DIR__ . '/class-ajax.php';
		require_once __DIR__ . '/class-soundcloud.php';
		require_once __DIR__ . '/class-renderer.php';

		if ( defined( 'WC_VERSION' ) ) {
			require_once __DIR__ . '/class-woocommerce.php';
		}

		if ( function_exists( 'EDD' ) ) {
			require_once __DIR__ . '/class-edd.php';
		}

		add_action( 'init', array( $this, 'register_audio_taxonomies' ), 10 );
		add_action( 'init', array( $this, 'load_languages' ), 10 );
		add_action( 'init', array( $this, 'init' ), 10 );
	}

	/**
	 * Load the extra resources needed for the backend
	 *
	 * @since 3.0.0
	 */
	private function require_for_admin() {
		if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
			require_once ABSPATH . '/wp-admin/includes/plugin.php';
		}

		// phpcs:disable WordPress.Security.NonceVerification.Recommended
		if ( empty( $_GET['wvpl-ajax'] ) ) {
			require_once __DIR__ . '/class-updater.php';
			if ( class_exists( 'Elementor\Base_Data_Control' ) ) {
				require_once __DIR__ . '/elementor/class-elementor-support.php';
			}
		}
		// phpcs:enable

		register_activation_hook( dirname( __DIR__ ) . '/waveplayer.php', array( $this, 'activation' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 1 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 10 );
		add_action( 'admin_head', array( $this, 'add_font_awesome' ), 10 );
	}

	/**
	 * Load the extra resources needed for AJAX calls
	 *
	 * @since 3.0.0
	 */
	private function require_for_ajax() {

		$shall_enqueue = false;

		// if Cornerstone is installed, enqueue the frontend styles and scripts
		// when the editor is active.
		if ( isset( $_REQUEST['_cs_nonce'] ) && wp_verify_nonce( $_REQUEST['_cs_nonce'], 'cornerstone_nonce' ) ) { // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
			$shall_enqueue = isset( $_REQUEST['cs_preview_state'] );
		}

		/**
		 * By default, WavePlayer doesn't enqueue the scripts and styles when the request is made via AJAX.
		 * This filter allows to activate the enqueuing of the styles and scripts even for AJAX calls.
		 *
		 * @since 3.0.10
		 * @param boolean Whether WavePlayer should enqueue styles and scripts during an AJAX call
		 */
		if ( apply_filters( 'waveplayer_shall_enqueue_scripts_for_ajax', $shall_enqueue ) ) {
			$this->require_for_frontend();
		}
	}

	/**
	 * Load the extra resources needed for JSON requests
	 *
	 * @since 3.0.0
	 */
	private function require_for_json() {
		require_once __DIR__ . '/class-renderer.php';
	}

	/**
	 * Load the extra resources needed for the frontend
	 *
	 * @since 3.0.0
	 */
	private function require_for_frontend() {
		if ( class_exists( 'Elementor\Base_Data_Control' ) ) {
			require_once __DIR__ . '/elementor/class-elementor-support.php';
		}
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 1 );
		add_action( 'wp_head', array( $this, 'add_font_awesome' ), 10 );
	}

	/**
	 * Initialize the plugin
	 *
	 * @since 3.0.0
	 */
	public function init() {
		global $wp_filesystem;

		$options     = $this->get_options();
		$this->nonce = wp_create_nonce( 'waveplayer' );

		$upload_dir = wp_upload_dir();

		define( 'WAVEPLAYER_PEAK_FOLDER', trailingslashit( $upload_dir['basedir'] ) . 'peaks/' );
		define( 'WAVEPLAYER_PEAK_PATH', trailingslashit( $upload_dir['baseurl'] ) . 'peaks/' );
		define( 'WAVEPLAYER_CACHE_FOLDER', $wp_filesystem->wp_content_dir() . 'cache/waveplayer' );

		if ( ! file_exists( WAVEPLAYER_PEAK_FOLDER ) ) {
			$wp_filesystem->mkdir( WAVEPLAYER_PEAK_FOLDER );
		}
		if ( ! file_exists( WAVEPLAYER_CACHE_FOLDER ) ) {
			$wp_filesystem->mkdir( WAVEPLAYER_CACHE_FOLDER );
		}
		if ( ! file_exists( WAVEPLAYER_PEAK_FOLDER ) ) {
			$wp_filesystem->mkdir( WAVEPLAYER_PEAK_FOLDER );
		}
		if ( ! file_exists( WAVEPLAYER_PEAK_FOLDER . 'soundcloud' ) ) {
			$wp_filesystem->mkdir( WAVEPLAYER_PEAK_FOLDER . 'soundcloud' );
		}
		if ( ! file_exists( WAVEPLAYER_PEAK_FOLDER . 'external' ) ) {
			$wp_filesystem->mkdir( WAVEPLAYER_PEAK_FOLDER . 'external' );
		}

		add_image_size( 'waveplayer-playlist-thumb', 48, 48, true );
	}

	/**
	 * Initialize WP_Filesystem global variable
	 *
	 * @since 3.0.0
	 */
	public static function init_filesystem() {
		require_once ABSPATH . 'wp-admin/includes/file.php';
		global $wp_filesystem;
		WP_Filesystem();
	}

	/**
	 * Define the default values for the WavePlayer settings
	 *
	 * @since  3.0.0
	 * @return array
	 */
	public function default_options() {
		$defaults = array(
			'skin'                   => 'w3-standard',
			'default_palette'        => '141f24-2f4651-e9edef-bed0d8-557a89-83b2c7-238fbd-49b6e6-205e79-a6d6ea-21779b-5fb2d6',
			'size'                   => 'md',
			'style'                  => 'light',
			'show_list'              => 0,
			'shape'                  => 'circle',
			'autoplay'               => 0,
			'repeat'                 => 0,
			'shuffle'                => 0,
			'wave_color'             => '#058',
			'wave_color_2'           => '#08b',
			'progress_color'         => '#d33',
			'progress_color_2'       => '#d93',
			'cursor_color'           => '#ee2',
			'cursor_color_2'         => '#d93',
			'cursor_width'           => 2,
			'hover_opacity'          => 50,
			'wave_mode'              => 4,
			'gap_width'              => 1,
			'wave_compression'       => 2,
			'wave_normalization'     => 1,
			'wave_asymmetry'         => 1,
			'wave_animation'         => 0.55,
			'amp_freq_ratio'         => 1,
			'template'               => '%title% %artist%',
			'custom_css'             => '',
			'custom_js'              => '',
			'default_thumbnail'      => plugins_url( 'assets/img/waveplayer.jpg', __DIR__ ),
			'default_thumbnail_size' => 'thumbnail',
			'audio_override'         => 1,
			'jump'                   => 1,
			'delete_settings'        => 0,
			'info'                   => 'playlist',
			'playlist_template'      => '%thumbnail% %title% %artist% %separator% %cart% %likes%',
			'sticky_template'        => '%thumbnail% %title% %artist% %share% %cart%',
			'sticky_player_position' => 'bottom',
			'full_width_playlist'    => 0,
			'default_font'           => 'default',
			'base_font_size'         => 16,
			'override_wave_colors'   => 1,
			'media_library_title'    => 1,
			'beta_program'           => 0,
			'purchase_code'          => '',
			'email_optin'            => 0,
			'version'                => $this->get_version(),
		);

		if ( defined( 'WC_VERSION' ) ) {
			$defaults = array_merge(
				$defaults,
				array(
					'woocommerce_shop_player'           => 'before',
					'woocommerce_shop_player_skin'      => 'thumb_n_wave',
					'woocommerce_shop_player_size'      => 'default',
					'woocommerce_shop_player_info'      => 'none',
					'woocommerce_remove_shop_image'     => 1,
					'woocommerce_product_player'        => 'after',
					'woocommerce_product_player_skin'   => 'play_n_wave',
					'woocommerce_product_player_size'   => 'default',
					'woocommerce_product_player_info'   => 'none',
					'woocommerce_remove_product_image'  => 1,
					'woocommerce_replace_product_image' => 1,
					'woocommerce_music_type_filter'     => 0,
				)
			);
		}

		return $defaults;

	}

	/**
	 * Return the WavePlayer settings
	 *
	 * @since  3.0.0
	 * @return array The associative array containing the settings
	 */
	public function get_options() {
		if ( ! $this->options ) {
			$options = $this->default_options();

			foreach ( $options as $option_name => $option_value ) {
				$options[ $option_name ] = get_site_option( "waveplayer_$option_name", $option_value );
			}
			$this->options = $options;
		}
		return array_merge( $this->default_options(), $this->options );
	}

	/**
	 * Return the setting corresponding to the option name provided
	 *
	 * @since  3.0.0
	 * @param  string $option_name The option name to be returned.
	 * @return mixed               The value of the option.
	 */
	public function get_option( $option_name ) {
		$options = $this->get_options();
		if ( ! isset( $options[ $option_name ] ) ) {
			return false;
		}

		return $options[ $option_name ];
	}

	/**
	 * Update the settings in the database
	 *
	 * @since 3.0.0
	 * @param array $options The array with the updated option values.
	 *                       If no array is passed, the options property is stored instead.
	 */
	public function update_options( $options = array() ) {
		$this->options = $this->get_options();

		if ( $options ) {
			$this->options = array_merge( $this->options, $options );
		}

		foreach ( $this->options as $option_name => $option_value ) {
			update_site_option( "waveplayer_$option_name", $option_value );
		}
	}

	/**
	 * The function called when the plugin gets activated
	 *
	 * @since 3.0.0
	 * @param boolean $networkwide Whether the plugin gets activated for all the sites of a multisite installation.
	 */
	public function activation( $networkwide ) {
		global $wpdb;

		if ( $networkwide && function_exists( 'is_multisite' ) && is_multisite() ) {
			$old_blog = $wpdb->blogid;
			$blogids  = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
			foreach ( $blogids as $blog_id ) {
				switch_to_blog( $blog_id );
				$this->_activation();
			}
			switch_to_blog( $old_blog );
			return;
		} else {
			$this->_activation();
		}
	}

	/**
	 * Activate a single site
	 * (called multiple times for multisite installations of WordPress)
	 *
	 * @since 3.0.0
	 */
	private function _activation() { //phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
		$this->options['delete_settings'] = false;
		$this->update_version();
	}


	/**
	 * Update the waveplayer settings based on the version that was previously installed
	 *
	 * @since 3.0.0
	 */
	public function update_version() {
		if ( get_site_option( 'waveplayer_version' ) !== $this->get_version() ) {
			AJAX::convert_old_stats();
			$options     = $this->get_options();
			$old_options = get_site_option( 'waveplayer_options' );
			if ( $old_options && '3.0.0' === $this->get_version() ) {
				$options = array_merge( $options, $old_options );

				if ( strpos( 'assets/img/music_file.png', $options['default_thumbnail'] ) >= 0 ) {
					$options['default_thumbnail'] = plugins_url( 'assets/img/waveplayer.jpg', __DIR__ );
				}

				$options['skin'] = 'w3-standard';

				foreach ( $options as $option_name => $option_value ) {
					if ( $option_value ) {
						update_site_option( "waveplayer_$option_name", $option_value );
					}
				}
				// phpcs:ignore Squiz.PHP.CommentedOutCode.Found
				// delete_site_option( 'waveplayer_options' );.
			}
			$options['sticky_template'] = str_replace( '$cart%', '%cart%', $options['sticky_template'] );
			$options['version']         = $this->get_version();
			$this->update_options( $options );
		}
	}

	/**
	 * Register the taxonomies for the audio attachments
	 *
	 * @since 3.0.0
	 */
	public function register_audio_taxonomies() {

		$taxonomies = array(
			'music_genre' =>
				array(
					'slug'          => 'music_genre',
					'name'          => 'Genres',
					'singular_name' => 'Genre',
				),
		);

		/**
		 * Filters the array of taxonomies being added to the audio attachments.
		 *
		 * @since 3.0.0
		 * @param array $taxonomies An array containing the taxonomies being added to the audio attachments.
		 */
		$taxonomies = apply_filters( 'waveplayer_audio_taxonomies', $taxonomies );

		foreach ( $taxonomies as $slug => $t ) {

			$labels = array(
				'name'              => esc_html( $t['name'] ),
				'singular_name'     => esc_html( $t['singular_name'] ),
				'search_items'      => esc_html( 'Search ' . $t['name'] ),
				'all_items'         => esc_html( 'All ' . $t['name'] ),
				'parent_item'       => esc_html( 'Parent ' . $t['singular_name'] ),
				'parent_item_colon' => esc_html( 'Parent ' . $t['singular_name'] . ':' ),
				'edit_item'         => esc_html( 'Edit ' . $t['singular_name'] ),
				'update_item'       => esc_html( 'Update ' . $t['singular_name'] ),
				'add_new_item'      => esc_html( 'Add New ' . $t['singular_name'] ),
				'new_item_name'     => esc_html( 'New ' . $t['singular_name'] . ' Name' ),
				'menu_name'         => esc_html( $t['singular_name'] ),
			);

			$args = array(
				'hierarchical'          => true,
				'labels'                => $labels,
				'show_ui'               => true,
				'show_admin_column'     => false,
				'query_var'             => true,
				'update_count_callback' => '_update_generic_term_count',
				'meta_box_cb'           => 'post_categories_meta_box',
				'rewrite'               => array( 'slug' => $slug ),
			);
			register_taxonomy( $slug, array( 'attachment:audio' ), $args );
		}
	}

	/**
	 * Load the the language textdomain
	 *
	 * @since 3.0.0
	 */
	public function load_languages() {
		load_plugin_textdomain( 'waveplayer', false, plugin_basename( __DIR__ ) . '/languages/' );
	}

	/**
	 * Enqueue the scripts required for the frontend
	 *
	 * @since 3.0.0
	 */
	public function enqueue_scripts() {
		global $post;

		if ( is_feed() || wp_doing_ajax() ) {
			return;
		}

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		$deps = array( 'jquery', 'wp-util', 'lodash', 'wp-i18n' );

		if ( 'default' !== strtolower( $this->options['default_font'] ) ) {
			$font_name = rawurlencode( $this->options['default_font'] );
			if ( $font_name ) {
				wp_register_style( 'waveplayer-default-font', "https://fonts.googleapis.com/css2?family=$font_name:wght@400;700", array(), $this->get_version() );
				wp_enqueue_style( 'waveplayer-default-font' );
			}
		}

		wp_register_style( 'waveplayer', plugins_url( "/assets/css/styles$suffix.css", __DIR__ ), array(), $this->get_version() );
		wp_enqueue_style( 'waveplayer' );

		$skin = $this->get_option( 'skin' );

		wp_register_script( 'waveplayer', plugins_url( "/assets/js/waveplayer$suffix.js", __DIR__ ), $deps, $this->get_version(), true );
		wp_enqueue_script( 'waveplayer' );
		wp_set_script_translations( 'waveplayer', 'waveplayer' );

		$custom_js = trim( $this->options['custom_js'] );
		if ( $custom_js ) {
			$custom_js = "document.addEventListener('waveplayer.engine.ready', (event) => { var $ = jQuery\n$custom_js })";
		}
		if ( function_exists( 'wp_add_inline_script' ) ) {
			wp_add_inline_script( 'waveplayer', $custom_js );
		}

		wp_add_inline_script( 'waveplayer', $this->script_vars() );

	}

	/**
	 * Add Font Awesome, required to show the icons of the player
	 *
	 * @since 3.0.7
	 */
	public function add_font_awesome() {
		?>
		<link rel="preload" href="<?php echo esc_url( plugins_url( '/assets/fonts/fa-solid-900.woff2', __DIR__ ) ); ?>" as="font" crossorigin />
		<link rel="preload" href="<?php echo esc_url( plugins_url( '/assets/fonts/fa-brands-400.woff2', __DIR__ ) ); ?>" as="font" crossorigin />
		<style type="text/css">
			@font-face{font-family:'Font Awesome 5 Free';font-style:normal;font-weight:900;font-display:block;src:url(<?php echo esc_url( plugins_url( '/assets/fonts/fa-solid-900.woff2', __DIR__ ) ); ?>) format("woff2")}.fa,.fas{font-family:'Font Awesome 5 Free';font-weight:900}@font-face{font-family:'Font Awesome 5 Brands';font-style:normal;font-weight:400;font-display:block;src:url(<?php echo esc_url( plugins_url( '/assets/fonts/fa-brands-400.woff2', __DIR__ ) ); ?>) format("woff2")}.fab{font-family:'Font Awesome 5 Brands';font-weight:400}
		</style>
		<?php
	}

	/**
	 * Enqueue the scripts required by the backend
	 *
	 * @since  3.0.0
	 */
	public function admin_enqueue_scripts() {

		$this->enqueue_scripts();

		$deps = array( 'wp-util', 'lodash', 'mce-view', 'media-views', 'wp-i18n', 'waveplayer' );
		wp_enqueue_media();

		$page   = get_query_var( 'page' );
		$screen = get_current_screen();
		if ( ( isset( $_GET['page'] ) && 'waveplayer' === $_GET['page'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$waveplayer_codemirror['css'] = wp_enqueue_code_editor( array( 'type' => 'text/css' ) );
			$waveplayer_codemirror['js']  = wp_enqueue_code_editor( array( 'type' => 'text/javascript' ) );
			wp_localize_script( 'jquery', 'wvplCM', $waveplayer_codemirror );

			wp_enqueue_script( 'wp-theme-plugin-editor' );
			wp_enqueue_style( 'wp-codemirror' );

			wp_register_script( 'iro-color-picker', plugins_url( '/assets/js/iro.min.js', __DIR__ ), array(), $this->get_version(), false );
			wp_enqueue_script( 'iro-color-picker' );
		}
		if ( ( isset( $_GET['page'] ) && 'waveplayer' === $_GET['page'] ) || 'product' === $screen->post_type ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			wp_register_script( 'waveplayer_admin_scripts', plugins_url( '/assets/js/admin-scripts.js', __DIR__ ), $deps, $this->get_version(), true );
			wp_enqueue_script( 'waveplayer_admin_scripts' );
		}

		wp_register_script( 'waveplayer_media_waveplayer', plugins_url( '/assets/js/media-waveplayer.js', __DIR__ ), $deps, $this->get_version(), true );
		wp_enqueue_script( 'waveplayer_media_waveplayer' );

		wp_register_style( 'waveplayer_admin_style', plugins_url( '/assets/css/admin_style.css', __DIR__ ), array(), $this->get_version() );
		wp_enqueue_style( 'waveplayer_admin_style' );

	}

	/**
	 * Enqueue the scripts required by the Elementor editor
	 *
	 * @since 3.0.0
	 */
	public function enqueue_elementor_scripts() {
		$this->enqueue_scripts();
		wp_register_script( 'waveplayer-elementor', plugins_url( '/assets/js/waveplayer-elementor.js', __DIR__ ), array(), $this->get_version(), false );
		wp_enqueue_script( 'waveplayer-elementor' );
	}

	/**
	 * Output a javascript variable to pass the global options to the script
	 *
	 * @since  3.0.0
	 * @return string
	 */
	public function script_vars() {
		global $post;

		$options         = $this->get_options();
		$options['site'] = get_bloginfo();
		if ( defined( 'WC_VERSION' ) ) {
			$options['cartURL'] = wc_get_cart_url();
		}
		$options['debug'] = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG;

		$user_id   = get_current_user_id();
		$user_info = get_userdata( $user_id );
		$user      = array();
		if ( ! $user_info ) {
			$user['ID'] = '0';
		} else {
			$user['ID']           = $user_info->ID;
			$user['display_name'] = $user_info->display_name;
			$user['caps']         = $user_info->caps;
			$user['avatar']       = get_avatar( $user_id );
		}

		$wvpl_vars = array(
			'ajax_url'        => admin_url( 'admin-ajax.php' ),
			'wvpl_ajax_url'   => $this->get_endpoint( '%%endpoint%%' ),
			'ajax_nonce'      => wp_create_nonce( 'waveplayer-ajax-call' ),
			'post_id'         => isset( $post ) ? $post->ID : 0,
			'options'         => $options,
			'currentUser'     => $user,
			'skins'           => Renderer::get_skins(),
			'palettes'        => Renderer::get_palettes(),
			'is_script_debug' => defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG,
			'peak_path'       => WAVEPLAYER_PEAK_PATH,
		);

		if ( defined( 'WC_VERSION' ) ) {
			$wvpl_vars['wc_version']     = WC_VERSION;
			$wvpl_vars['currencySymbol'] = get_woocommerce_currency_symbol();
		}
		if ( is_admin() ) {
			$wvpl_vars['nonce']             = wp_create_nonce( 'waveplayer-parse-shortcode' );
			$wvpl_vars['admin_tools_nonce'] = wp_create_nonce( 'waveplayer-admin-tools' );
			$wvpl_vars['is_gutenberg']      = Renderer::is_gutenberg_editor();
			$wvpl_vars['is_elementor']      = Renderer::is_elementor_editor();
		}
		return 'var wvplVars = ' . wp_json_encode( $wvpl_vars );
	}

	/**
	 * Generate the custom endpoint for the AJAX calls
	 *
	 * @since  3.0.0
	 * @param  string $request The query arg added to the ajax endpoint.
	 * @return string
	 */
	public function get_endpoint( $request = '' ) {
		return esc_url_raw( apply_filters( 'waveplayer_ajax_get_endpoint', add_query_arg( 'wvpl-ajax', $request, remove_query_arg( array( 'regenerate_peaks' ), home_url( '/', 'relative' ) ) ), $request ) );
	}

	/**
	 * Return the attachment ID from its URL or false
	 *
	 * @since  3.0.0
	 * @param  string $url The $url to be checked.
	 * @return int         The attachment ID or false if no attachment corresponds to the $url provided
	 */
	public function attachment_url_to_postid( $url ) {
		if ( strpos( $url, 'http' ) !== 0 && strpos( $url, '//' ) !== 0 ) {
			$upload_path = trailingslashit( str_replace( get_bloginfo( 'url' ), '', wp_upload_dir()['baseurl'] ) );
			$url         = str_replace( $upload_path, '', $url );
		}
		return (int) attachment_url_to_postid( $url );
	}

}
