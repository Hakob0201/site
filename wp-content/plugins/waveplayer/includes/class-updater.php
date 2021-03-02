<?php
/**
 * WooCommerce class
 *
 * @package WavePlayer/Updater
 */

namespace PerfectPeach\WavePlayer;

defined( 'ABSPATH' ) || exit;

/**
 * Updater class
 *
 * The Updater class handles the automatic update of the plugin
 *
 * @since 3.0.0
 * @package WavePlayer/Updater
 */
class Updater {

	/**
	 * The path of the main plugin file
	 *
	 * @var string
	 */
	private static $file;

	/**
	 * The data of the plugin
	 *
	 * @var array
	 */
	private static $plugin;

	/**
	 * The basename of the main plugin file
	 *
	 * @var string
	 */
	private static $basename;

	/**
	 * Whether the plugin is currently active or not
	 *
	 * @var boolean
	 */
	private static $active;

	/**
	 * The information of the latest update found
	 *
	 * @var array
	 */
	private static $update_info;

	/**
	 * Activate the updater functionalities
	 *
	 * @since 3.0.0
	 */
	public static function load() {
		if ( ! is_admin() || wp_doing_cron() || wp_doing_ajax() ) {
			return false;
		}

		self::$file = dirname( __DIR__ ) . '/waveplayer.php';
		add_action( 'admin_init', array( __CLASS__, 'set_plugin_properties' ) );
		add_filter( 'pre_set_site_transient_update_plugins', array( __CLASS__, 'modify_transient' ), 10, 1 );
		add_filter( 'plugins_api', array( __CLASS__, 'plugin_popup' ), 10, 3 );
		add_filter( 'upgrader_package_options', array( __CLASS__, 'upgrader_package_options' ), 10 );
		add_filter( 'upgrader_post_install', array( __CLASS__, 'after_install' ), 10, 3 );
		add_filter( 'upgrader_process_complete', array( __CLASS__, 'process_complete' ), 10, 2 );

		add_action( 'in_plugin_update_message-waveplayer/waveplayer.php', array( __CLASS__, 'in_plugin_update_message' ), 10, 2 );
	}

	/**
	 * Callback function setting up the main properties of the updater class
	 *
	 * @since 3.0.0
	 */
	public static function set_plugin_properties() {
		self::$plugin   = get_plugin_data( self::$file );
		self::$basename = plugin_basename( self::$file );
		self::$active   = is_plugin_active( self::$basename );
	}

	/**
	 * Get the update information from the WavePlayer website
	 *
	 * @since 3.0.0
	 */
	private static function get_repository_info() {

		$cache_key = 'waveplayer_update_info';

		// phpcs:disable WordPress.Security.NonceVerification.Recommended
		$force_check = ( isset( $_GET['force-check'] ) && 1 === (int) $_GET['force-check'] );
		// phpcs:enable

		$data = get_transient( $cache_key );
		if ( ! $force_check && ( false !== $data ) ) {
			self::$update_info = $data;
			return;
		}

		$waveplayer_info   = self::get_waveplayer_info();
		self::$update_info = self::get_update_info();
		if ( self::$update_info ) {
			set_transient( $cache_key, self::$update_info, 24 * HOUR_IN_SECONDS );
		}
	}

	/**
	 * Activate the updater functionalities
	 *
	 * @since  3.0.0
	 * @param  string $current_version The current version of the plugin.
	 * @return boolean                 Whether a new version is available or not
	 */
	private static function is_update_available( $current_version ) {

		$official_version         = preg_replace( '/-(.*)/', '', self::$update_info['tag_name'] );
		$is_new_version_available = version_compare( self::$update_info['tag_name'], $current_version, '>' );

		// A new official version is available.
		if ( $is_new_version_available && $official_version === self::$update_info['tag_name'] ) {
			return true;
		}

		$bare_version             = preg_replace( '/-(.*)/', '', $current_version );
		$is_new_version_available = version_compare( self::$update_info['tag_name'], $current_version, '=' );

		// The current version is a prerelease and there is an official release available.
		if ( $is_new_version_available && $bare_version !== $current_version && ! self::$update_info['prerelease'] ) {
			return true;
		}

		$beta_program             = ! ! (int) waveplayer()->get_option( 'beta_program' );
		$is_new_version_available = version_compare( self::$update_info['tag_name'], $current_version, '>' );

		// There is a new prerelease and the user is part of the beta program.
		if ( $is_new_version_available && self::$update_info['prerelease'] && $beta_program ) {
			return true;
		}

		return false;
	}

	/**
	 * Modify the default WordPress update transient
	 * by adding the relevant information of the latest WavePlayer update
	 *
	 * @since  3.0.0
	 * @param  object $transient The WordPress plugin update transient.
	 * @return object            The modified transient if a new update is available
	 */
	public static function modify_transient( $transient ) {

		if ( property_exists( $transient, 'checked' ) ) {

			$checked = $transient->checked;
			if ( $checked && isset( $checked[ self::$basename ] ) ) {

				self::get_repository_info();
				$data = self::$update_info;

				if ( $data && self::is_update_available( $checked[ self::$basename ] ) ) {

					$slug   = current( explode( '/', self::$basename ) );
					$plugin = array(
						'url'            => self::$plugin['PluginURI'],
						'slug'           => $slug,
						'package'        => $data['zipball_url'],
						'new_version'    => $data['tag_name'],
						'tested'         => $data['tested'],
						'upgrade_notice' => $data['upgrade_notice'],
						'icons'          => array(
							'1x' => 'https://www.waveplayer.info/waveplayer.png',
							'2x' => 'https://www.waveplayer.info/waveplayer-2x.png',
						),
					);

					$transient->response[ self::$basename ] = (object) $plugin;
				}
			}
		}

		return $transient;
	}

	/**
	 * Return the upgrade package options for the latest WavePlayer update
	 * This includes the URL of the ZIP file to be downloaded
	 *
	 * @since  3.0.0
	 * @param  object $options The upgrade package options for WavePlayer.
	 * @return object          The modified package options
	 */
	public static function upgrader_package_options( $options ) {
		if ( ! isset( $options['hook_extra']['plugin'] ) || $options['hook_extra']['plugin'] !== self::$basename ) {
			return $options;
		}

		$data = self::$update_info;

		$zipball_url = $data['zipball_url'];

		$zipball_filename = basename( wp_parse_url( $zipball_url, PHP_URL_PATH ) );

		$tmpfname = wp_tempnam( $zipball_filename );

		if ( ! $tmpfname ) {
			return $options;
		}

		$response = wp_safe_remote_get(
			$zipball_url,
			array(
				'timeout'  => 300,
				'stream'   => true,
				'filename' => $tmpfname,
			)
		);

		if ( is_wp_error( $response ) ) {
			unlink( $tmpfname );
			return $options;
		}

		$options['package'] = $tmpfname;

		return $options;
	}

	/**
	 * Return an object with the relevant info of the WavePlayer plugin
	 *
	 * @since  3.0.0
	 * @param  object $result The original plugin info page HTML markup.
	 * @param  object $action The action.
	 * @param  object $args   The extra args about the plugin.
	 * @return object         The modified package options
	 */
	public static function plugin_popup( $result, $action, $args ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundBeforeLastUsed

		if ( ! empty( $args->slug ) ) {

			if ( current( explode( '/', self::$basename ) ) === $args->slug ) {

				$data = self::$update_info;

				$fields = array(
					'active_installs'     => 844,
					'downloaded'          => $data['number_of_sales'],
					'author_block_rating' => 20 * $data['rating'],
					'author_block_count'  => $data['rating_count'],
					'rating'              => 20 * $data['rating'],
					'ratings'             => $data['rating_count'],
					'added'               => $data['published_at'],
					'author'              => self::$plugin['AuthorName'],
					'author_profile'      => self::$plugin['AuthorURI'],
					'banners'             => array(
						'low'  => 'https://www.waveplayer.info/img/banners/1x/w3-codecanyon-cover.png',
						'high' => 'https://www.waveplayer.info/img/banners/2x/w3-codecanyon-cover.png',
					),
					'description'         => self::$plugin['Description'],
					'download_link'       => $data['zipball_url'],
					'homepage'            => self::$plugin['PluginURI'],
					'icons'               => array(
						'1x' => 'https://www.waveplayer.info/waveplayer.png',
						'2x' => 'https://www.waveplayer.info/waveplayer-2x.png',
					),
					'last_updated'        => $data['updated_at'],
					'name'                => self::$plugin['Name'],
					'num_ratings'         => $data['rating_count'],
					'requires'            => $data['requires'],
					'requires_php'        => $data['requires_php'],
					'screenshots'         => array(),
					'sections'            => array(
						'description' => $data['description'],
					),
					'short_description'   => $data['short_description'],
				);

				return (object) $fields;
			}
		}
		return $result;
	}

	/**
	 * The actions performed after the plugin update completes
	 *
	 * @since  3.0.0
	 * @param  array $response   The default response.
	 * @param  array $hook_extra The extra hook information.
	 * @param  array $result     The result information about the update.
	 * @return object             The modified response
	 */
	public static function after_install( $response, $hook_extra, $result ) {
		global $wp_filesystem;

		if ( ! isset( $hook_extra['plugin'] ) || $hook_extra['plugin'] !== self::$basename ) {
			return $response;
		}

		$install_directory = plugin_dir_path( self::$file );
		$wp_filesystem->move( $result['destination'], $install_directory );
		$result['destination'] = $install_directory;

		if ( self::$active ) {
			activate_plugin( self::$basename );
		}

		return $result;
	}

	/**
	 * The actions performed after the whole process ends
	 *
	 * @since  3.0.0
	 * @param  array $response   The default response.
	 * @param  array $hook_extra The extra hook information.
	 */
	public static function process_complete( $response, $hook_extra ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundBeforeLastUsed
		if ( isset( $hook_extra['plugins'] ) && in_array( self::$basename, $hook_extra['plugins'], true ) ) {
			waveplayer()->update_version();
		}
	}

	/**
	 * Output the message to be shown after the default update message
	 *
	 * @since  3.0.0
	 * @param  array $plugindata The plugin data.
	 * @param  array $response   The response of the update.
	 */
	public static function in_plugin_update_message( $plugindata, $response ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
		$upgrade_notice = esc_html( self::$update_info['upgrade_notice'] );
		echo '<br />';
		echo "<span class='waveplayer-upgrade-notice'>{$upgrade_notice}</span></p></div>"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Return the message to be shown after the default update message
	 *
	 * @since  3.0.0
	 * @return array The update info received from the WavePlayer website
	 */
	private static function get_update_info() {
		$code = waveplayer()->get_option( 'purchase_code' );
		if ( ! $code ) {
			$code = '';
		}

		$optin = waveplayer()->get_option( 'email_optin' );

		$site_url = wp_parse_url( get_bloginfo( 'url' ) );
		$site_url = $site_url['host'] ?? '';

		$request_uri = 'https://www.waveplayer.info/api/update_check';
		$body        = array(
			'code'     => $code,
			'site_url' => $site_url,
		);
		if ( $optin ) {
			$body['admin_email'] = get_option( 'admin_email' );
		}

		$options = array(
			'body'        => $body,
			'headers'     => array(
				'Content-Type' => 'application/x-www-form-urlencoded',
				'User-Agent'   => 'WordPress/5.4; ' . get_bloginfo( 'url' ),
			),
			'method'      => 'POST',
			'httpversion' => '1.1',
			'data_format' => 'body',
		);

		$response = json_decode( wp_remote_retrieve_body( wp_safe_remote_post( $request_uri, $options ) ), true );

		if ( ! $response['success'] ) {
			return false;
		}

		$data = $response['update_info'];

		$plugin_data_keys = array(
			'tested'         => 'Tested up to',
			'wc_tested'      => 'WC tested up to',
			'upgrade_notice' => 'Upgrade notice',
		);
		foreach ( $plugin_data_keys as $key => $value ) {
			if ( preg_match( '/^[ \t\/*#@-]*' . preg_quote( $value, '/' ) . ':(.*)$/mi', $data['body'], $match ) && $match[1] ) {
				$data[ $key ] = _cleanup_header_comment( $match[1] );
			}
		}

		return $data;
	}

	/**
	 * Calls the old update function to update the statistics about the current installations
	 *
	 * @since  3.0.0
	 * @return string The response of the remote server
	 */
	private static function get_waveplayer_info() {
		$query_args = array(
			'action'            => 'get_metadata',
			'slug'              => 'waveplayer',
			'installed_version' => waveplayer()->get_version(),
			'php'               => phpversion(),
			'locale'            => get_locale(),
		);

		$options = array(
			'timeout' => 10, // seconds.
			'headers' => array(
				'Accept' => 'application/json',
			),
		);

		$url = 'https://www.waveplayer.info/updater/';
		if ( ! empty( $query_args ) ) {
			$url = add_query_arg( $query_args, $url );
		}

		return wp_remote_get( $url, $options );
	}

}

Updater::load();
