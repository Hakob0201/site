<?php
/**
 * Debug class
 *
 * @package WavePlayer/Debug
 */

namespace PerfectPeach\WavePlayer; //phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedNamespaceFound

defined( 'ABSPATH' ) || exit;

/**
 * A class with some simple debugging tools
 *
 * @package WavePlayer/Debug
 */
class Debug {

	/**
	 * Store the start time.
	 *
	 * @var int
	 */
	public static $start = 0;

	/**
	 * Output a list of variables to the debug.log file.
	 *
	 * @since 3.0.0
	 * @param mixed ...$vars A list of variables that will be output to the log file.
	 */
	public static function log( ...$vars ) {
		if ( ! defined( 'WP_DEBUG' ) || ! WP_DEBUG ) {
			return;
		}

		foreach ( $vars as $var ) {
			error_log( print_r( $var, true ) ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log, WordPress.PHP.DevelopmentFunctions.error_log_print_r
		}
	}

	/**
	 * Set the $start property to the current microtime.
	 *
	 * @since 3.0.0
	 */
	public static function timer_start() {
		self::$start = microtime( true );
	}

	/**
	 * Output the elapsed microtime since the $start property
	 * and reset the $start property to the current microtime
	 *
	 * @since 3.0.0
	 * @param string $label The descriptive label being output to the log file
	 *                      before the current microtime.
	 */
	public static function timer_delta( $label = 'delta' ) {
		$t     = microtime( true );
		$delta = sprintf( '%.3f', 1000 * ( $t - self::$start ) );
		self::log( "$label: $delta" );
		self::$start = $t;
	}
}
