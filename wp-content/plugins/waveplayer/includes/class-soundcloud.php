<?php
/**
 * Soundcloud class
 *
 * @package WavePlayer/SoundCloud
 */

namespace PerfectPeach\WavePlayer;

defined( 'ABSPATH' ) || exit;

/**
 * The Soundcloud class provides support for Soundcloud URLs
 *
 * @package WavePlayer/SoundCloud
 */
class Soundcloud {

	const WAVEPLAYER_SC_API_URL   = 'https://api.soundcloud.com/';
	const WAVEPLAYER_SC_CLIENT_ID = 'S0VXvlpY6vZh50WKHZJ4M0jBJjxFwddx';

	/**
	 * Return an array of tracks corresponding to a soundcloud URL
	 * The URL can be a single track or a playlist
	 *
	 * @since  3.0.0
	 * @param  string $sc_url A URL to a track or a playlist on Soundcloud.
	 * @return array
	 */
	public static function get_soundcloud_url( $sc_url ) {

		$url = self::WAVEPLAYER_SC_API_URL . 'resolve.json';

		if ( pathinfo( $sc_url, PATHINFO_EXTENSION ) === 'rss' ) {
			$tracks = array();

			$feed  = fetch_feed( $sc_url );
			$items = $feed->get_items( 0, 5 );
			foreach ( $items as $item ) {
				$track_url  = $item->get_permalink();
				$sc_url     = rawurlencode( $item->get_permalink() );
				$query_args = array(
					'url'       => $sc_url,
					'client_id' => self::WAVEPLAYER_SC_CLIENT_ID,
				);
				$url        = add_query_arg( $query_args, $url );
				$options    = array(
					'timeout' => 10,
					'headers' => array(
						'User-Agent' => 'WavePlayer/3.0',
					),
				);

				$data     = json_decode( wp_remote_retrieve_body( wp_remote_get( $url, $options ) ) );
				$tracks[] = $data;
			}
		} else {
			$sc_url     = rawurlencode( $sc_url );
			$query_args = array(
				'url'       => $sc_url,
				'client_id' => self::WAVEPLAYER_SC_CLIENT_ID,
			);
			$url        = add_query_arg( $query_args, $url );

			$options = array(
				'timeout' => 10,
				'headers' => array(
					'User-Agent' => 'WavePlayer/3.1',
				),
			);

			$data = json_decode( wp_remote_retrieve_body( wp_remote_get( $url, $options ) ) );
			if ( 'playlist' === $data->kind ) {
				$tracks = $data->tracks;
			} else {
				$tracks = array( $data );
			}
		}

		return $tracks;
	}

	/**
	 * Return the URL of the streamable audio file of a Soundcloud track
	 *
	 * @since  3.0.0
	 * @param  string $track_id     The Soundcloud URL to retrieve the streamable file.
	 * @param  string $secret_token If the track is private, the secret token to access it.
	 * @return array
	 */
	public static function get_soundcloud_stream_url( $track_id, $secret_token = '' ) {
		global $wp_filesystem;

		$args = array(
			'client_id' => self::WAVEPLAYER_SC_CLIENT_ID,
		);
		if ( $secret_token ) {
			$args['secret_token'] = $secret_token;
		}
		$sc_url        = self::WAVEPLAYER_SC_API_URL . "tracks/$track_id/streams";
		$sc_url        = add_query_arg( $args, $sc_url );
		$opts          = array( 'http' => array( 'header' => "User-Agent:MyAgent/1.0\r\n" ) );
		$context       = stream_context_create( $opts );
		$track_streams = json_decode( $wp_filesystem->get_contents( $sc_url, false, $context ) );
		if ( isset( $track_streams->http_mp3_128_url ) ) {
			return $track_streams->http_mp3_128_url;
		}

		return false;
	}
}
