<?php
/**
 * Skin Name: Play'n'Wave
 * Supports: size
 * Author: Luigi Pulcini
 * Version: 3.0.0
 * Author URI: http://www.luigipulcini.com
 * Description: A minimal interface with just the waveform and the play button. This interface is particularly useful for single-track instances, as a WooCommerce product player or in combination with tables.
 *
 * You can customize this interface copying the whole folder
 * in your current child theme folder, in the following location:
 * /wp-content/themes/<your-child-theme>/waveplayer/interface/skins/play_n_wave
 *
 * If WavePlayer find this skin in your child theme folder, it will override the factory one.
 *
 * @package WavePlayer/Skins
 */

defined( 'ABSPATH' ) || exit;

?>
<div id="<?php echo esc_attr( $args['id'] ); ?>" class="<?php echo esc_attr( $args['classes'] ); ?>" <?php echo $args['dataset']; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="wvpl-controls">
		<div class="wvpl-icon wvpl-play"></div>
	</div>
	<div class="wvpl-wave">
		<div class="wvpl-overlay">
			<svg>
				<use xlink:href="#waveform-animation" />
			</svg>
			<div class="percentage"></div>
			<div class="wvpl-loading">
				<div class="wvpl-loading-progress"></div>
			</div>
			<div class="message"></div>
		</div>
		<div class="wvpl-position"></div>
		<div class="wvpl-waveform"></div>
		<div class="wvpl-duration"></div>
	</div>
</div>
