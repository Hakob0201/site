<?php
/**
 * WooCommerce class
 *
 * @package WavePlayer/WooCommerce
 */

namespace PerfectPeach\WavePlayer;

use \WP_Query as WP_Query;
use \WC_Admin_Meta_Boxes as WC_Admin_Meta_Boxes;
use \WC_AJAX as WC_AJAX;

defined( 'ABSPATH' ) || exit;

/**
 * WooCommerce class
 *
 * The WooCommerce class handles the integration between WavePlayer and WooCommerce
 *
 * @since 3.0.0
 * @package WavePlayer
 */
class WooCommerce {

	/**
	 * Loads the WooCommerce integration
	 */
	public static function load() {
		self::addons_support();
		add_action( 'init', array( __CLASS__, 'register_hooks' ) );
	}

	/**
	 * Get the default action priority for the single product page player
	 *
	 * @since  3.0.0
	 * @return array
	 */
	public static function get_default_product_player_priority() {
		return array(
			'before'         => 4,
			'after'          => 6,
			'before_rating'  => 9,
			'after_price'    => 11,
			'before_excerpt' => 19,
			'after_excerpt'  => 21,
			'before_meta'    => 39,
			'after_meta'     => 41,
		);
	}

	/**
	 * Registers all the hooks to integrate WavePlayer into WooCommerce
	 *
	 * @since 3.0.0
	 */
	public static function register_hooks() {

		$product_player_priority = self::get_default_product_player_priority();

		$product_player        = self::product_player_position();
		$replace_product_image = (int) waveplayer()->get_option( 'woocommerce_replace_product_image' );

		if ( 'none' !== $product_player ) {

			if ( 'after_summary' === $product_player ) {
				add_action( 'woocommerce_after_single_product_summary', array( __CLASS__, 'print_product_player' ), 5 );
			} else {
				add_action( 'woocommerce_single_product_summary', array( __CLASS__, 'print_product_player' ), $product_player_priority[ $product_player ] );
			}
			add_action( 'woocommerce_single_product_lightbox_summary', array( __CLASS__, 'print_product_player' ), 1 );
			add_filter( 'woocommerce_blocks_product_grid_item_html', array( __CLASS__, 'blocks_product_grid_item_html' ), 10, 3 );
			do_action( 'waveplayer_single_product_player_callback' );
		}

		if ( $replace_product_image ) {
			add_filter( 'woocommerce_product_get_image_id', array( __CLASS__, 'product_get_image_id' ), 10, 2 );
			add_filter( 'post_thumbnail_html', array( __CLASS__, 'post_thumbnail_html' ), 10, 5 );
			add_filter( 'has_post_thumbnail', array( __CLASS__, 'has_post_thumbnail' ), 10, 3 );
		}

		$shop_page_hook = 'template_redirect';
		if ( waveplayer()->is_ajax() ) {
			$shop_page_hook = 'wp_loaded';
		}
		add_action( $shop_page_hook, array( __CLASS__, 'shop_page_hooks' ), 10 );

		add_action( 'woocommerce_product_options_advanced', array( __CLASS__, 'add_preview_files' ) );
		add_action( 'woocommerce_process_product_meta', array( __CLASS__, 'save_preview_files' ) );
		add_action( 'woocommerce_process_product_meta', array( __CLASS__, 'save_music_type' ) );

		add_action( 'wp_ajax_waveplayer_create_product', array( __CLASS__, 'ajax_create_product' ) );

		add_filter( 'waveplayer_add_track_info', array( __CLASS__, 'add_product_info_to_track' ), 10, 3 );
		add_filter( 'waveplayer_add_external_track_info', array( __CLASS__, 'add_product_info_to_external_track' ), 10, 34 );

		add_filter( 'woocommerce_post_class', array( __CLASS__, 'woocommerce_post_class' ), 10, 2 );

	}

	/**
	 * Whether the product thumbnail should be removed on the shop page
	 *
	 * @since 3.0.0
	 * @return boolean
	 */
	public static function shall_remove_shop_thumbnail() {
		return ! ! (int) waveplayer()->get_option( 'woocommerce_remove_shop_image' );
	}

	/**
	 * Get the position for the player on the shop page
	 *
	 * @since 3.0.0
	 * @return string
	 */
	public static function shop_player_position() {
		return waveplayer()->get_option( 'woocommerce_shop_player' );
	}

	/**
	 * Get the position for the player on the single product page
	 *
	 * @since 3.0.0
	 * @return string
	 */
	public static function product_player_position() {
		return waveplayer()->get_option( 'woocommerce_product_player' );
	}

	/**
	 * Register the action and filter callback functions
	 * responsible for replacing the product thumbnail
	 * with an instance of the player on the shop page
	 *
	 * @since 3.0.0
	 */
	public static function shop_page_hooks() {
		$shop_player = self::shop_player_position();
		if ( 'none' !== $shop_player ) {

			if ( self::shall_remove_shop_thumbnail() ) {
				remove_filter( 'post_thumbnail_html', array( __CLASS__, 'post_thumbnail_html' ), 10, 5 );
				add_filter( 'post_thumbnail_html', array( __CLASS__, 'product_player_html' ), 20, 2 );
				add_filter( 'woocommerce_single_product_image_html', array( __CLASS__, 'product_player_html' ), 10, 2 );
				add_filter( 'woocommerce_single_product_image_thumbnail_html', array( __CLASS__, 'product_player_html' ), 10, 2 );
				add_filter( 'woocommerce_product_get_image', array( __CLASS__, 'product_player_html' ), 10, 2 );
				do_action( 'waveplayer_shop_product_player_callback' );
			} else {
				add_action( "woocommerce_{$shop_player}_shop_loop_item_title", array( __CLASS__, 'print_product_player' ), 10 );
			}
		}
	}

	/**
	 * Get the active theme name
	 *
	 * @since  3.0.10
	 * @return string
	 */
	public static function get_active_theme_name() {
		$name  = '';
		$theme = wp_get_theme();
		if ( $theme ) {
			$name = $theme->get( 'Name' );
			if ( $theme->parent() ) {
				$name = $theme->parent()->get( 'Name' );
			}
		}
		return $name;
	}

	/**
	 * Add support for WooCommerce themes and addons
	 *
	 * @since 3.0.0
	 */
	public static function addons_support() {
		require_once 'class-woocommerce-addon-support.php';
		require_once 'class-woocommerce-theme-support.php';
	}

	/**
	 * Filter the result of the has_post_thumbnail default function
	 *
	 * @since 3.0.6
	 * @param string|int $has_thumbnail The ID of the current featured image.
	 * @param WP_Post    $_post         The post object of the current post in the loop.
	 * @param string|int $thumbnail_id  The ID of the featured image.
	 * @return int
	 */
	public static function has_post_thumbnail( $has_thumbnail, $_post, $thumbnail_id ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
		global $post;
		if ( ! $_post ) {
			$_post = $post;
		}
		if ( 'product' !== get_post_type( $_post ) ) {
			return $has_thumbnail;
		}
		$post_id = is_numeric( $_post ) ? $_post : $post->ID;
		$product = wc_get_product( $post_id );
		if ( $product && self::get_preview_files_thumbnail_id( $product->get_id() ) ) {
			$has_thumbnail = true;
		}
		return $has_thumbnail;
	}

	/**
	 * Get the ID of the featured image of a product
	 * or, if any, the first featured image
	 * of the preview files associated with it
	 *
	 * @since 3.0.0
	 * @param string|int $image_id The ID of the current featured image.
	 * @param string|int $product  The product to retrieve a featured image for.
	 * @return int
	 */
	public static function product_get_image_id( $image_id, $product ) {

		if ( ! $image_id ) {
			$track_image_id = self::get_preview_files_thumbnail_id( $product->get_id() );
			if ( $track_image_id ) {
				return (int) $track_image_id;
			}
		}
		return (int) $image_id;
	}

	/**
	 * Get the ID of the featured image of a product
	 * or, if any, the first featured image
	 * of the preview files associated with it
	 *
	 * @since  3.0.0
	 * @param  string       $html               The img element of the current featured image.
	 * @param  int          $post_id            The ID of the current $post object.
	 * @param  int          $post_thumbnail_id  The ID of the current featured image.
	 * @param  string|array $size               The requested size.
	 * @param  array        $attr               An array of attributes for the img element.
	 * @return string       The modified img element
	 */
	public static function post_thumbnail_html( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
		$product = wc_get_product( $post_id );
		if ( ! $product ) {
			return $html;
		}
		$post_thumbnail_id = self::product_get_image_id( $post_thumbnail_id, $product );
		if ( ! $post_thumbnail_id ) {
			$html = wp_get_attachment_image( $post_thumbnail_id, $size, false, $attr );
		}
		return (int) $image_id;
	}

	/**
	 * Get the ID of the featured image
	 * of the first preview file associated with the product
	 *
	 * @since 3.0.0
	 * @param string $product_id The ID of the product.
	 * @return int|boolean
	 */
	public static function get_preview_files_thumbnail_id( $product_id ) {

		$preview_files = self::get_preview_files( $product_id );
		if ( isset( $preview_files['ids'] ) ) {
			foreach ( $preview_files['ids'] as $id ) {
				$thumbnail_id = get_post_thumbnail_id( $id );
				if ( $thumbnail_id ) {
					return $thumbnail_id;
				}
			}
		}
		return false;
	}


	/**
	 * HTML markup allowing to add preview files to the product
	 *
	 * @since 3.0.0
	 */
	public static function add_preview_files() {
		global $post;

		if ( ! $post ) {
			return;
		}

		$product = wc_get_product( $post->ID );
		if ( $product && $product->is_type( 'grouped' ) ) {
			return;
		}

		$post_id = $post->ID;
		?>
		<p class="form-field _music_type_field">
			<label for="_music_type"><?php esc_html_e( 'Music type', 'waveplayer' ); ?></label>
			<select id="_music_type" name="_music_type" class="select short">
				<option value="single" <?php selected( get_post_meta( $post_id, '_music_type', true ) === 'single' ); ?>>Single</option>
				<option value="album" <?php selected( get_post_meta( $post_id, '_music_type', true ) === 'album' ); ?>>Album</option>
			</select>
			<span class="description"><?php esc_html_e( 'Choose a music type', 'waveplayer' ); ?></span>
		</p>
		<div class="form-field preview_files">
			<label><?php esc_html_e( 'Preview files', 'waveplayer' ); ?></label>
			<table class="widefat">
				<thead>
					<tr>
						<th class="sort">&nbsp;</th>
						<th><?php esc_html_e( 'Name ', 'waveplayer' ); ?><span class="woocommerce-help-tip"></span></th>
						<th colspan="2"><?php esc_html_e( 'File URL ', 'waveplayer' ); ?> <span class="woocommerce-help-tip"></span></th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody class="ui-sortable">
					<?php
					$preview_files = get_post_meta( $post_id, '_preview_files', true );

					if ( $preview_files ) {
						if ( ! is_array( $preview_files ) ) {
							?>
								<tr>
									<td class="sort"></td>
									<td class="file_name"><input type="text" class="input_text" placeholder="<?php esc_attr_e( 'File Name', 'waveplayer' ); ?>" name="_wc_preview_file_names[]" value="" /></td>
									<td class="file_url"><input type="text" class="input_text" placeholder="<?php esc_attr_e( 'http://', 'waveplayer' ); ?>" name="_wc_preview_file_urls[]" value="<?php echo esc_attr( $preview_files ); ?>" /></td>
									<td class="file_url_choose" width="1%"><a href="#" class="button upload_preview_button" data-choose="<?php esc_attr_e( 'Choose file', 'waveplayer' ); ?>" data-update="<?php esc_attr_e( 'Insert file URL', 'waveplayer' ); ?>"><?php echo esc_html( str_replace( ' ', '&nbsp;', __( 'Choose file', 'waveplayer' ) ) ); ?></a></td>
									<td width="1%"><a href="#" class="delete"><?php esc_html_e( 'Delete', 'waveplayer' ); ?></a></td>
								</tr>
							<?php
						} else {
							foreach ( $preview_files as $key => $file ) {
								?>
								<tr>
									<td class="sort"></td>
									<td class="file_name"><input type="text" class="input_text" placeholder="<?php esc_attr_e( 'File Name', 'waveplayer' ); ?>" name="_wc_preview_file_names[]" value="<?php echo esc_attr( $file['name'] ); ?>" /></td>
									<td class="file_url"><input type="text" class="input_text" placeholder="<?php esc_attr_e( 'http://', 'waveplayer' ); ?>" name="_wc_preview_file_urls[]" value="<?php echo esc_attr( $file['file'] ); ?>" /></td>
									<td class="file_url_choose" width="1%"><a href="#" class="button upload_preview_button" data-choose="<?php esc_attr_e( 'Choose file', 'waveplayer' ); ?>" data-update="<?php esc_attr_e( 'Insert file URL', 'waveplayer' ); ?>"><?php echo esc_html( str_replace( ' ', '&nbsp;', __( 'Choose file', 'waveplayer' ) ) ); ?></a></td>
									<td width="1%"><a href="#" class="delete"><?php esc_html_e( 'Delete', 'waveplayer' ); ?></a></td>
								</tr>
								<?php
							}
						}
					}
					?>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="5">
							<a href="#" class="button insert" data-row="<tr>
	<td class=&quot;sort&quot;></td>
	<td class=&quot;file_name&quot;><input type=&quot;text&quot; class=&quot;input_text&quot; placeholder=&quot;File Name&quot; name=&quot;_wc_preview_file_names[]&quot; value=&quot;&quot; /></td>
	<td class=&quot;file_url&quot;><input type=&quot;text&quot; class=&quot;input_text&quot; placeholder=&quot;http://&quot; name=&quot;_wc_preview_file_urls[]&quot; value=&quot;&quot; /></td>
	<td class=&quot;file_url_choose&quot; width=&quot;1%&quot;><a href=&quot;#&quot; class=&quot;button upload_preview_button&quot; data-choose=&quot;<?php esc_attr_e( 'Choose File', 'waveplayer' ); ?>&quot; data-update=&quot;<?php esc_attr_e( 'Insert File URL', 'waveplayer' ); ?>&quot;><?php esc_html_e( 'Choose File', 'waveplayer' ); ?></a></td>
	<td width=&quot;1%&quot;><a href=&quot;#&quot; class=&quot;delete&quot;><?php esc_html_e( 'Delete', 'waveplayer' ); ?></a></td>
</tr>"><?php esc_html_e( 'Add File', 'waveplayer' ); ?></a>
						</th>
					</tr>
				</tfoot>
			</table>
		</div>
		<?php
	}

	/**
	 * Saves the preview files when the product is updated
	 *
	 * @since 3.0.0
	 * @param int $product_id The ID of the product being updated.
	 */
	public static function save_preview_files( $product_id ) {

		$product = wc_get_product( $product_id );
		if ( $product && $product->is_type( 'grouped' ) ) {
			return;
		}

		$files = array();

		//phpcs:disable WordPress.Security.NonceVerification.Recommended
		if ( isset( $_REQUEST['_wc_preview_file_urls'] ) ) {
			$file_names    = isset( $_REQUEST['_wc_preview_file_names'] ) ? $_REQUEST['_wc_preview_file_names'] : array();  // phpcs:ignore WordPress.Security.NonceVerification.Missing, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized, WordPress.Security.ValidatedSanitizedInput.MissingUnslash
			$file_urls     = isset( $_REQUEST['_wc_preview_file_urls'] ) ? wp_unslash( array_map( 'trim', $_REQUEST['_wc_preview_file_urls'] ) ) : array(); // phpcs:ignore WordPress.Security.NonceVerification.Missing, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized, WordPress.Security.ValidatedSanitizedInput.MissingUnslash
			$file_url_size = count( $file_urls );

			for ( $i = 0; $i < $file_url_size; $i ++ ) {

				$file_urls[ $i ] = str_replace( untrailingslashit( get_bloginfo( 'url' ) ), '', $file_urls[ $i ] );

				if ( ! empty( $file_urls[ $i ] ) ) {
					if ( 0 === strpos( $file_urls[ $i ], 'http' ) || 0 === strpos( $file_urls[ $i ], '//' ) ) {
						$file_is  = 'absolute';
						$file_url = $file_urls[ $i ];
					} elseif ( '[' === substr( $file_urls[ $i ], 0, 1 ) && ']' === substr( $file_urls[ $i ], -1 ) ) {
						$file_is  = 'shortcode';
						$file_url = wc_clean( $file_urls[ $i ] );
					} else {
						$file_is  = 'relative';
						$file_url = wc_clean( $file_urls[ $i ] );
					}

					$file_name = wc_clean( $file_names[ $i ] );
					$file_hash = md5( $file_url );

					if ( 'relative' === $file_is ) {
						$file_path = $file_url;

						if ( '..' === substr( $file_path, 0, 2 ) || '/' !== substr( $file_path, 0, 1 ) ) {
							$file_path = realpath( ABSPATH . $file_path );
						} elseif ( strpos( $file_path, substr( WP_CONTENT_DIR, strlen( untrailingslashit( ABSPATH ) ) ) ) === 0 ) {
							$file_path = realpath( WP_CONTENT_DIR . substr( $file_path, strlen( substr( WP_CONTENT_DIR, strlen( untrailingslashit( ABSPATH ) ) ) ) ) );
						} elseif ( strpos( $file_path, substr( WP_CONTENT_DIR, strlen( ABSPATH ) ) ) === 0 ) {
							$file_path = realpath( WP_CONTENT_DIR . substr( $file_path, strlen( substr( WP_CONTENT_DIR, strlen( ABSPATH ) ) ) ) );
						}

						if ( ! file_exists( $file_path ) ) {
							// translators: %s is the URL of the file.
							WC_Admin_Meta_Boxes::add_error( sprintf( esc_html__( 'The preview file %s cannot be used as it does not exist on the server.', 'waveplayer' ), '<code>' . $file_url . '</code>' ) );
							continue;
						}
					}

					$files[ $file_hash ] = array(
						'name' => $file_name,
						'file' => $file_url,
					);
				}
			}
		}
		//phpcs:enable WordPress.Security.NonceVerification.Recommended

		update_post_meta( $product_id, '_preview_files', $files );
	}

	/**
	 * Save the music type of a product
	 *
	 * @since 3.0.0
	 * @param int|string $product_id The ID of the product being updated.
	 */
	public static function save_music_type( $product_id ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found

		if ( ! isset( $_REQUEST['_music_type'] ) ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended
			return;
		}

		$music_type = $_REQUEST['_music_type']; // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized, WordPress.Security.ValidatedSanitizedInput.MissingUnslash

		update_post_meta( $product_id, '_music_type', $music_type );
	}

	/**
	 * Get the preview files of a product
	 *
	 * @since  3.0.0
	 * @param  int|string $product_id The ID of the product.
	 * @return array
	 */
	public static function get_preview_files( $product_id ) {

		$product = wc_get_product( $product_id );

		if ( ! $product ) {
			return array();
		}

		$base_upload_url = trailingslashit( wp_upload_dir()['baseurl'] );

		$preview_files = array();
		$products      = array();
		if ( $product->is_type( 'grouped' ) ) {
			$products = $product->get_children();
		} else {
			$products[] = $product->get_id();
		}

		foreach ( $products as $id ) {

			$_preview_files = get_post_meta( $id, '_preview_files', true );

			if ( $_preview_files ) {
				$_files = array();
				if ( ! is_array( $_preview_files ) ) {
					$files = explode( ',', $_preview_files );
					foreach ( $files as $file ) {
						if ( is_numeric( $file ) ) {
							if ( wp_attachment_is( 'audio', $file ) ) {
								$file_ids[] = $file;
							}
						} else {
							$_file   = str_replace( $base_upload_url, '', $file );
							$file_id = waveplayer()->attachment_url_to_postid( $_file );
							if ( $file_id ) {
								$file_ids[] = $file_id;
							} else {
								$file_urls[] = $_preview_files;
							}
						}
					}
				} else {
					foreach ( $_preview_files as $key => $value ) {
						$_file   = str_replace( $base_upload_url, '', $value['file'] );
						$file_id = waveplayer()->attachment_url_to_postid( $_file );
						if ( $file_id ) {
							$file_ids[] = $file_id;
						} else {
							$file_urls[] = $value['file'];
						}
					}
				}
			}
		}
		if ( ! empty( $file_ids ) ) {
			$preview_files['ids'] = $file_ids;
		}
		if ( ! empty( $file_urls ) ) {
			$preview_files['url'] = $file_urls;
		}
		return $preview_files;
	}

	/**
	 * Get the HTML markup of the player that includes
	 * all the preview files associated with a product
	 *
	 * @since  3.0.0
	 * @param  WC_Product $_product The current product object.
	 * @param  array      $args     Additional parameters to pass to the shortcode.
	 * @return string
	 */
	public static function product_player( $_product = null, $args = array() ) {
		global $product;

		if ( ! $_product ) {
			$_product = $product;
		}
		if ( is_numeric( $_product ) ) {
			$_product = wc_get_product( $_product );
		}
		if ( ! $_product ) {
			return false;
		}
		$options = waveplayer()->get_options();
		$size    = $options['woocommerce_shop_player_size'];
		$info    = $options['woocommerce_shop_player_info'];
		$skin    = $options['woocommerce_shop_player_skin'];
		if ( self::is_single_product() || waveplayer()->is_rest_request() ) {
			$skin = $options['woocommerce_product_player_skin'];
			$size = $options['woocommerce_product_player_size'];
			$info = $options['woocommerce_product_player_info'];
		}
		if ( 'default' === $size ) {
			$size = $options['size'];
		}
		if ( ! isset( $args['skin'] ) ) {
			$args['skin'] = $skin;
		}
		if ( ! isset( $args['size'] ) ) {
			$args['size'] = $size;
		}
		if ( ! isset( $args['info'] ) ) {
			$args['info'] = $info;
		}

		$files = self::get_preview_files( $_product->get_id() );

		if ( isset( $files['ids'] ) ) {
			$type = 'ids';
		} elseif ( isset( $files['url'] ) ) {
			$type = 'url';
		}
		if ( isset( $type ) && isset( $files[ $type ] ) ) {
			$list = implode( ',', $files[ $type ] );
			if ( $list ) {
				$args[ $type ] = $list;
				$params        = implode(
					' ',
					array_map(
						function( $key, $value ) {
							return "$key='$value'";
						},
						array_keys( $args ),
						$args
					)
				);
				return do_shortcode( "[waveplayer $params]" );
			}
		}
		return false;
	}


	/**
	 * Output the product player to the page
	 *
	 * @since  3.0.0
	 */
	public static function print_product_player() {
		$product_player = self::product_player();
		if ( $product_player ) {
			echo $product_player; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}

	/**
	 * Whether the current page is the single product page
	 * and the current WooCommerce loop is not the 'related' one
	 *
	 * @since  3.0.0
	 * @return boolean
	 */
	public static function is_single_product() {
		if ( is_product() && 'related' !== wc_get_loop_prop( 'name' ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Whether the current loop is a woocommerce loop
	 * where the shop-type player can be added
	 *
	 * @since  3.1.3
	 * @return boolean
	 */
	public static function is_woocommerce_loop() {
		return ( is_woocommerce() && ! self::is_single_product() );
	}

	/**
	 * Whether the current loop is the mini cart
	 *
	 * @since  3.1.3
	 * @return boolean
	 */
	public static function is_mini_cart() {
		return ( did_action( 'woocommerce_before_mini_cart' ) > did_action( 'woocommerce_after_mini_cart' ) );
	}

	/**
	 * Return the HTML markup of the product player
	 *
	 * @since  3.0.0
	 * @param  string         $html     When used as a filter, the markup being replaced.
	 * @param  WC_Product|int $_product The ID or object of the current product.
	 * @return string
	 */
	public static function product_player_html( $html, $_product = null ) {
		if ( self::is_single_product() || is_cart() || self::is_mini_cart() ) {
			return $html;
		}

		global $product;
		if ( is_numeric( $_product ) ) {
			if ( 'attachment' === get_post_type( $_product ) ) {
				$_product = $product;
			} elseif ( 'product' === get_post_type( $_product ) ) {
				$_product = wc_get_product( $_product );
			}
		}

		$product_player = self::product_player( $_product );
		if ( $product_player ) {
			$html = $product_player;
		}
		return $html;
	}

	/**
	 * Return the HTML markup of the product block
	 *
	 * @since  3.0.0
	 * @param  string $html    When used as a filter, the markup being replaced.
	 * @param  object $data    The object containing the markup of each product element.
	 * @param  object $product The current product object in the loop.
	 * @return string
	 */
	public static function blocks_product_grid_item_html( $html, $data, $product ) {
		$product_player = self::product_player( $product );
		if ( $product_player ) {
			$html = "<li class=\"wc-block-grid__product\">
    			<a href=\"{$data->permalink}\" class=\"wc-block-grid__product-link\">
    				{$data->image}
                    {$product_player}
    				{$data->title}
    			</a>
    			{$data->badge}
    			{$data->price}
    			{$data->rating}
    			{$data->button}
    		</li>";
		}

		return $html;
	}


	/**
	 * Add a product to the cart
	 *
	 * @since  3.0.0
	 */
	public static function ajax_add_to_cart() {
		ob_start();

		$product_id        = isset( $_POST['product_id'] ) ? (int) $_POST['product_id'] : 0; // phpcs:ignore WordPress.Security.NonceVerification.Missing
		$quantity          = 1;
		$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
		$product_status    = get_post_status( $product_id );
		$added             = WC()->cart->add_to_cart( $product_id, $quantity );

		if ( $passed_validation && $added && 'publish' === $product_status ) {
			ob_start();

			woocommerce_mini_cart();

			$mini_cart = ob_get_clean();

			$data = array(
				'fragments'  => apply_filters(
					'woocommerce_add_to_cart_fragments',
					array(
						'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>',
					)
				),
				'cart_hash'  => WC()->cart->get_cart_hash(),
				'ajax_nonce' => wp_create_nonce( 'waveplayer-ajax-call' ),
			);

			wp_send_json_success( $data );
		} else {
			$data = array(
				'message'     => __( 'The product was not added to the cart', 'waveplayer' ),
				'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id ), // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
				'product_id'  => $product_id,
			);
			wp_send_json_error( $data );
		}
	}

	/**
	 * Retrieve the audio attachments
	 *
	 * @since  3.0.0
	 * @param  int    $posts_per_page The number of tracks per page.
	 * @param  int    $paged          The page where to start getting tracks.
	 * @param  string $search         The string to search.
	 * @return array                  An array of tracks and albums.
	 */
	public static function get_audio_attachments( $posts_per_page = 10, $paged = 1, $search = '' ) {

		$tracks = array();
		$albums = array();

		$args = array(
			'posts_per_page' => $posts_per_page,
			'paged'          => $paged,
			'post_type'      => 'attachment',
			'post_mime_type' => 'audio',
			'post_status'    => 'any',
		);

		if ( $search ) {
			$args['s'] = $search;
		}
		$query        = new WP_Query( $args );
		$found_tracks = $query->found_posts;

		if ( $query->have_posts() ) {
			foreach ( $query->posts as $attachment ) {
				$id          = $attachment->ID;
				$track       = wp_get_attachment_metadata( $id );
				$track['id'] = $id;
				$post        = get_post( $id );
				if ( $post->post_title ) {
					$track['title'] = $post->post_title;
				}
				$track_file    = wp_get_attachment_url( $id );
				$track['file'] = $track_file;

				$track['product'] = self::get_product_id(
					array(
						'file' => $track_file,
						'id'   => $id,
					)
				);

				$tracks[] = $track;
				if ( isset( $track['album'] ) ) {
					$key = $track['album'];
					if ( ! isset( $albums[ $key ] ) ) {
						$albums[ $key ]           = array();
						$albums[ $key ]['count']  = 0;
						$albums[ $key ]['tracks'] = array();
					}
					$albums[ $key ]['count']++;
					$albums[ $key ]['tracks'][] = $track['id'];
				}
			}
			foreach ( $albums as $title => $album ) {
				$album['product'] = self::get_product_id( array( 'album' => $title ) );
				$album['tracks']  = implode( ',', $album['tracks'] );
				$albums[ $title ] = $album;
			}
		}

		return array(
			'tracks'       => $tracks,
			'found_tracks' => $found_tracks,
		);
	}


	/**
	 * Generate the HTML markup for the audio attachment list with checkboxes
	 *
	 * @since  3.0.0
	 * @param  int    $posts_per_page The number of tracks per page.
	 * @param  int    $paged          The page where to start getting tracks.
	 * @param  string $search         The string to search.
	 * @return array                  An array of containers for the track and the album inputs.
	 */
	public static function music_inputs( $posts_per_page = 10, $paged = 1, $search = '' ) {
		$result = self::get_audio_attachments( $posts_per_page, $paged, $search );
		if ( $result ) {
			$tracks       = $result['tracks'];
			$found_tracks = $result['found_tracks'];
			$per_page     = $posts_per_page;
		} else {
			return false;
		}
		$track_inputs = '';
		foreach ( $tracks as $track ) {
			$id       = esc_attr( $track['id'] );
			$title    = esc_attr( $track['title'] );
			$length   = esc_html( isset( $track['length_formatted'] ) ? $track['length_formatted'] : '' );
			$file     = esc_html( basename( $track['file'] ) );
			$product  = $track['product'];
			$disabled = $product > 0 ? 'disabled' : '';

			$track_inputs .= "<div><input type='checkbox' name='music_track_$id' value='$id' $disabled data-title='$title' /><span class='$disabled'>$id. <strong>$title</strong> – $length ($file)</span></div>";
		}
		$args = array(
			'base'      => '%_%',
			'format'    => '#%#%',
			'current'   => (int) $paged,
			'total'     => ceil( $found_tracks / $posts_per_page ),
			'prev_text' => '<',
			'next_text' => '>',
		);
		// translators: %s is the number of tracks found.
		$found_tracks_label = '<span class="found-tracks">' . sprintf( esc_attr( _n( '%s track', '%s tracks', $found_tracks, 'waveplayer' ) ), number_format_i18n( $found_tracks ) ) . '</span>'; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		require_once ABSPATH . 'wp-admin/includes/template.php';
		require_once ABSPATH . 'wp-admin/includes/class-wp-screen.php';
		$pagination = new \WP_List_Table( array( 'ajax' => true ) );
		$pagination->set_pagination_args(
			array(
				'total_items' => $found_tracks,
				'total_pages' => ceil( $found_tracks / $posts_per_page ),
				'per_page'    => $posts_per_page,
			)
		);

		ob_start();
		?>

		<div class="tablenav-pages">
			<?php $pagination->pagination( 'top' ); ?>
		</div>

		<?php
		$paginate_links = ob_get_clean(); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		return array(
			'track_inputs'   => $track_inputs,
			'paginate_links' => $paginate_links,
			'found_tracks'   => $found_tracks,
		);
	}

	/**
	 * Generate the HTML markup for the audio attachment list with checkboxes
	 *
	 * @since  3.0.0
	 * @param array $data  The data to match the products against.
	 * @return int|boolean The ID of the product or false if no product was found
	 */
	public static function get_product_id( $data ) {

		$product_id = false;

		$args = array(
			'posts_per_page' => 1,
			'post_status'    => 'any',
			'post_type'      => 'product',
		);

		$meta_query = array();
		$music_type = '';
		if ( isset( $data['file'] ) || isset( $data['id'] ) ) {
			$value                  = isset( $data['file'] ) ? $data['file'] : $data['id'];
			$meta_query['relation'] = 'AND';
			$meta_query[]           = array(
				'key'     => '_preview_files',
				'value'   => $value,
				'compare' => 'LIKE',
			);
			$music_type             = 'single';
		} elseif ( isset( $data['album'] ) ) {
			$args['title'] = $data['album'];
			$music_type    = 'album';
		}
		if ( $music_type ) {
			$meta_query[]       = array(
				'key'     => '_music_type',
				'value'   => $music_type,
				'compare' => '=',
			);
			$args['meta_query'] = $meta_query; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
		}

		$query = new WP_Query( $args );
		if ( $query->have_posts() ) {
			$query->the_post();
			$product_id = get_the_ID();
			wp_reset_postdata();
		}

		return $product_id;
	}

	/**
	 * Callback function hooked to the 'waveplayer_add_track_info' filter
	 * Add the relevant data of a product associated with the track
	 *
	 * @since  3.0.0
	 * @param array $track     The array containing the track info.
	 * @param int   $track_id  The ID of the track.
	 * @param int   $post_id   The ID of the post containing the track.
	 * @return array           The filtered array containing the track info
	 */
	public static function add_product_info_to_track( $track, $track_id, $post_id ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
		if ( is_admin() ) {
			$screen = get_current_screen();
			if ( 'post' === $screen->base ) {
				return $track;
			}
		}

		global $product;
		$options    = waveplayer()->get_options();
		$track_file = str_replace( get_bloginfo( 'url' ), '', $track['file'] );

		$args  = array(
			'posts_per_page' => 1,
			'post_status'    => 'publish',
			'post_type'      => 'product',
			'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
				'relation' => 'AND',
				array(
					'relation' => 'OR',
					array(
						'key'     => '_preview_files',
						'value'   => "$track_file",
						'compare' => 'LIKE',
					),
					array(
						'key'     => '_preview_files',
						'value'   => "^$track_id$",
						'compare' => 'REGEXP',
					),
				),
			),
		);
		$query = new WP_Query( $args );
		if ( $query->found_posts ) {
			$post                   = current( $query->posts );
			$preview_files          = get_post_meta( $post->ID, '_preview_files', true );
			$track['product_id']    = $post->ID;
			$track['product_title'] = $post->post_title;
			$track['product_url']   = get_permalink( $post->ID );
			$_product               = wc_get_product( $post->ID );
			$track['product_price'] = floatval( $_product->get_price() );
			if ( $_product->is_type( 'variable' ) ) {
				$track['product_variations'] = $_product->get_available_variations();
				setup_postdata( $post );
				ob_start();
				woocommerce_variable_add_to_cart();
				$cart_form = ob_get_clean();
				if ( $product && $product->is_type( 'grouped' ) ) {
					wp_reset_postdata();
				}
				$track['product_variations_form'] = $cart_form;
			}

			$default_poster_size    = isset( $options['default_thumbnail_size'] ) && $options['default_thumbnail_size'] ? $options['default_thumbnail_size'] : 'thumbnail';
			$post_featured_image_id = get_post_thumbnail_id( $post->ID );
			if ( waveplayer()->get_option( 'default_thumbnail' ) === $track['poster'] && $post_featured_image_id ) {
				$track['poster']           = current( wp_get_attachment_image_src( $post_featured_image_id, $default_poster_size ) ) ? current( wp_get_attachment_image_src( $post_featured_image_id, $default_poster_size ) ) : '';
				$track['poster_thumbnail'] = current( wp_get_attachment_image_src( $post_featured_image_id, 'waveplayer-playlist-thumb' ) ) ? current( wp_get_attachment_image_src( $post_featured_image_id, 'waveplayer-playlist-thumb' ) ) : '';
				$track['poster_srcset']    = wp_get_attachment_image_srcset( $post_featured_image_id, array( 48, 48 ) ) ? wp_get_attachment_image_srcset( $post_featured_image_id, array( 48, 48 ) ) : '';
			}
			$track['product_formatted_price'] = wc_price( $track['product_price'] );
			$track['in_cart']                 = 0;
			if ( WC()->cart ) {
				foreach ( WC()->cart->get_cart() as $cart_item ) {
					if ( $track['product_id'] === $cart_item['product_id'] ) {
						$track['in_cart'] = 1;
						break;
					}
				}
			}
		}
		return $track;
	}

	/**
	 * Callback function hooked to the 'waveplayer_add_external_track_info' filter
	 * Add the relevant data of a product associated with the track
	 *
	 * @since  3.0.0
	 * @param array  $track     The array containing the track info.
	 * @param int    $hash      The MD5 hash of the URL identifying the external track
	 *                          (this is passed for verification only).
	 * @param int    $post_id   The ID of the post containing the track.
	 * @param string $url       The URL of the external track.
	 * @return array           The filtered array containing the track info
	 */
	public static function add_product_info_to_external_track( $track, $hash, $post_id, $url ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundBeforeLastUsed
		global $product;

		$options = waveplayer()->get_options();

		$args  = array(
			'posts_per_page' => 1,
			'post_status'    => 'publish',
			'post_type'      => 'product',
			'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
				'relation' => 'AND',
				array(
					'relation' => 'OR',
					array(
						'key'     => '_preview_files',
						'value'   => "$url",
						'compare' => 'LIKE',
					),
				),
			),
		);
		$query = new WP_Query( $args );
		if ( $query->found_posts ) {
			$post                   = current( $query->posts );
			$preview_files          = get_post_meta( $post->ID, '_preview_files', true );
			$track['product_id']    = $post->ID;
			$track['product_title'] = $post->post_title;
			$track['product_url']   = get_permalink( $post->ID );
			$_product               = wc_get_product( $post->ID );
			$track['product_price'] = floatval( $_product->get_price() );
			if ( $_product->is_type( 'variable' ) ) {
				$track['product_variations'] = $_product->get_available_variations();
				setup_postdata( $post );
				ob_start();
				woocommerce_variable_add_to_cart();
				$cart_form = ob_get_clean();
				if ( $product && $product->is_type( 'grouped' ) ) {
					wp_reset_postdata();
				}
				$track['product_variations_form'] = $cart_form;
			}
			$track['product_formatted_price'] = wc_price( $track['product_price'] );
			$track['in_cart']                 = 0;
			if ( WC()->cart ) {
				foreach ( WC()->cart->get_cart() as $cart_item ) {
					if ( $track['product_id'] === $cart_item['product_id'] ) {
						$track['in_cart'] = 1;
						break;
					}
				}
			}
		}
		return $track;
	}

	/**
	 * Callback function hooked to the 'woocommerce_post_class' filter
	 * Add the 'waveplayer-product' class to a product with preview files
	 *
	 * @since  3.0.0
	 * @param array      $classes The array containing the track info.
	 * @param WC_Product $product The current $product object.
	 * @return array     The filtered array containing the product item classes
	 */
	public static function woocommerce_post_class( $classes, $product ) {
		if ( get_post_meta( $product->get_id(), '_preview_files', true ) ) {
			$classes[] = 'waveplayer-product';
		}

		return $classes;
	}
}

WooCommerce::load();
