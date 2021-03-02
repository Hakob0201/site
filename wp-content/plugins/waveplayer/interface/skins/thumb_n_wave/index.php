<?php
/**
 * Skin Name: Thumb'n'Wave
 * Supports:
 * Author: Luigi Pulcini
 * Version: 3.0.0
 * Author URI: http://www.luigipulcini.com
 * Description: This skin is perfect for WooCommerce products in the shop, archive or category pages.
 *
 * You can customize this interface copying the whole folder
 * in your current child theme folder, in the following location:
 * /wp-content/themes/<your-child-theme>/waveplayer/interface/skins/thumb_n_wave
 *
 * If WavePlayer find this skin in your child theme folder, it will override the factory one.
 *
 * @package WavePlayer/Skins
 */

defined( 'ABSPATH' ) || exit;

?>
<div id="<?php echo esc_attr( $args['id'] ); ?>" class="<?php echo esc_attr( $args['classes'] ); ?>" <?php echo $args['dataset']; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="wvpl-main-block">
		<div class="wvpl-poster"></div>
		<div class="wvpl-controls">
			<div class="wvpl-icon wvpl-prev wvpl-disabled"></div>
			<div class="wvpl-icon wvpl-play"></div>
			<div class="wvpl-icon wvpl-next wvpl-disabled"></div>
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
			<div class="wvpl-waveform"></div>
		</div>
	</div>
</div>
