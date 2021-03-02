<?php
/**
 * Renderer class
 *
 * @package PodcastPage/PodcastPage
 */

namespace PerfectPeach\PodcastPage;

defined( 'ABSPATH' ) || exit;

/**
 * Renderer class
 *
 * This class contains all the functions dealing with the interface
 *
 * @since 1.0.0
 * @package PodcastPage/Render
 */
class Render {

	const TEMPLATE_PATH = 'templates/';
	const THEME_PATH    = '/podcastpage/' . self::TEMPLATE_PATH;

	/**
	 * Register all the action and filter callbacks
	 * related to the rendering of the interface
	 *
	 * @since  1.0.0
	 */
	public static function load() {
		add_shortcode( 'podcast_page', array( __CLASS__, 'podcast_page' ) );
	}

	/**
	 * Generate the [podcast_page] shortcode
	 *
	 * @since  1.0.0
	 * @param  array  $atts    The parameters of the shortcode.
	 * @param  string $content The content of the shortcode (not used).
	 * @return string
	 */
	public static function podcast_page( $atts, $content ) { //phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
		if ( isset( $atts['url'] ) ) {

			$args = shortcode_atts(
				array(
					'url'           => '',
					'per_page'      => 5,
					'pagination'    => true,
					'header'        => 'all',
					'section_width' => '900px',
					'header_height' => '200px',
					'item_height'   => '100px',
					'header_bg'     => '',
					'header_color'  => '',
					'template'      => 'default',
				),
				$atts,
				'podcastpage_rss'
			);

			$feed = fetch_feed( $args['url'] );
			unset( $args['url'] );

			if ( is_wp_error( $feed ) ) {
				return;
			}

			$current_page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
			$num_tracks   = $args['per_page'];
			$first_item   = $num_tracks * ( $current_page - 1 );
			$total_items  = $feed->get_item_quantity();
			$max_items    = $feed->get_item_quantity( $num_tracks );
			$items        = $feed->get_items( $first_item, $max_items );
			$total_pages  = ceil( $total_items / $num_tracks );

			if ( empty( $items ) || ! is_array( $items ) ) {
				return;
			}
			$template = $args['template'];
			$params   = implode(
				' ',
				array_map(
					function( $value, $param ) {
						return "$param='$value'";
					},
					$args,
					array_keys( $args )
				)
			);

			ob_start();

			do_action( 'podcastpage_before_rss_feed_page' );

			?>
			<div class="feed-page" style="--max-width:<?php echo esc_attr( $args['section_width'] ); ?>;--header-height:<?php echo esc_attr( $args['header_height'] ); ?>;--item-height:<?php echo esc_attr( $args['item_height'] ); ?>;">
			<?php

			if ( 'all' === $args['header'] || ( 'first' === $args['header'] && 1 === $current_page ) ) {
				$feed_title       = $feed->get_title();
				$feed_permalink   = $feed->get_permalink();
				$feed_link        = $feed->get_link();
				$feed_description = $feed->get_description();
				$feed_image       = $feed->get_image_url();

				list( $background_color, $color ) = self::get_image_colors( $feed_image );

				include self::include_template( 'header' );
			}

			?>
			<div class="feed-page-content">
				<?php

				foreach ( $items as $item ) {
					$enclosure = $item->get_enclosure();
					if ( $enclosure && $enclosure->link ) {
						$image = '';
						if ( $item->get_item_tags( SIMPLEPIE_NAMESPACE_ITUNES, 'image' ) ) {
							$image = $item->get_item_tags( SIMPLEPIE_NAMESPACE_ITUNES, 'image' )[0]['attribs']['']['href'];
						}

						$permalink   = $item->get_permalink();
						$title       = $item->get_title();
						$author      = $item->get_author()->name;
						$author_link = $feed->get_link();
						$date        = $item->get_date();
						$description = preg_replace( "/<p>[ \t\n\r]*(<br>)*[ \t\n\r]*<\/p>/", '', $item->get_description() );

						$url = $item->get_enclosure()->link;
						AJAX::add_external_data(
							$url,
							array(
								'poster' => $image,
								'link'   => $permalink,
							)
						);

						$player = do_shortcode( "[audio src='$url']" );
						include self::include_template( 'item', $template );
					}
				}

				$big = 999999999;

				if ( filter_var( $args['pagination'], FILTER_VALIDATE_BOOLEAN ) ) {

					do_action( 'podcastpage_before_rss_feed_pagination' );

					?>
					<div class="rss-feed-pagination">
						<?php
						echo paginate_links(  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							apply_filters(
								'podcastpage_rss_pagination_args',
								array(
									'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
									'format'    => '?paged=%#%',
									'current'   => max( 1, $current_page ),
									'total'     => $total_pages,
									'prev_text' => '&laquo;',
									'next_text' => '&raquo;',
								),
								$current_page,
								$total_pages
							)
						);
						?>
					</div>
					<?php

					do_action( 'podcastpage_after_rss_feed_pagination' );

				}

				?>
				</div>
			</div>
			<?php

			do_action( 'podcastpage_after_rss_feed_page' );

			return ob_get_clean();
		}
	}

	/**
	 * Return the average color of an image and its best contrasting color
	 *
	 * @since  1.0.0
	 * @param  string $image_url The URL of an image.
	 * @return array             The array containing the two colors
	 */
	public static function get_image_colors( $image_url ) {
		$image  = imagecreatefromstring( wp_remote_retrieve_body( wp_remote_get( $image_url ) ) );
		$width  = imagesx( $image );
		$height = imagesy( $image );
		$pixel  = imagecreatetruecolor( 1, 1 );
		imagecopyresampled( $pixel, $image, 0, 0, 0, 0, 1, 1, $width, $height );
		$rgb   = imagecolorat( $pixel, 0, 0 );
		$color = imagecolorsforindex( $pixel, $rgb );

		$background_color = "{$color['red']},{$color['green']},{$color['blue']}";
		$color            = ( $color['red'] * 0.299 + $color['green'] * 0.587 + $color['blue'] * 0.114 ) > 186 ? '#000' : '#fff';

		return array( $background_color, $color );
	}

	/**
	 * Include a template
	 *
	 * @since 1.0.0
	 * @param string $template The template name.
	 * @param string $part     An optional part for the template.
	 */
	public static function include_template( $template, $part = '' ) {

		if ( $part ) {
			$template = "$template-$part";
		}

		$theme_template_path  = get_stylesheet_directory() . self::THEME_PATH . "$template.php";
		$plugin_template_path = plugin_dir_path( __DIR__ ) . self::TEMPLATE_PATH . "$template.php";

		if ( file_exists( $theme_template_path ) ) {
			return $theme_template_path;
		} elseif ( file_exists( $plugin_template_path ) ) {
			return $plugin_template_path;
		}
	}

}

PodcastPage::load();
