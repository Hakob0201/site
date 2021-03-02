<?php
/**
 * Plugin Name: WavePlayer
 * Plugin URI: http://www.waveplayer.info
 * Description: WavePlayer is an audio player that uses the waveform of each track as its timeline.
 * Author: Luigi Pulcini
 * Version: 3.1.3
 * Author URI: http://www.luigipulcini.com
 * Tested up to: 5.5.1
 * WC tested up to: 4.6.0
 * Requires at least: 5.0
 * Requires PHP: 7.0
 *
 * @package WavePlayer
 */

namespace PerfectPeach\WavePlayer; //phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedNamespaceFound

defined( 'ABSPATH' ) || exit;

require_once 'includes/class-waveplayer.php';
require_once 'includes/class-debug.php';

/**
 * Returns the main instance of WavePlayer.
 *
 * @since  3.0.0
 * @return WavePlayer
 */
function waveplayer() {
	return WavePlayer::instance();
}

$GLOBALS['waveplayer'] = waveplayer();
