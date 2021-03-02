<?php
/**
 * Skin Name: WavePlayer3 Exhibition
 * Supports: size,shape,infobar,playlist
 * Author: Luigi Pulcini
 * Version: 3.0.0
 * Author URI: http://www.luigipulcini.com
 * Description: The new interface included in WavePlayer3, using the most advanced styling techniques for the best reasult in a broad variety of configurations. This is the same as the 'WavePlayer3' skin except it has a blurred background using the thumbnail of the track being played back.
 *
 * You can customize this interface copying the whole folder
 * in your current child theme folder, in the following location:
 * /wp-content/themes/<your-child-theme>/waveplayer/interface/skins/w3-exhibition
 *
 * If WavePlayer find this skin in your child theme folder, it will override the factory one.
 *
 * @package WavePlayer/Skins
 */

defined( 'ABSPATH' ) || exit;

?>
<div id="<?php echo esc_attr( $args['id'] ); ?>" class="<?php echo esc_attr( $args['classes'] ); ?>" <?php echo $args['dataset']; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="wvpl-cover">
		<div class="wvpl-poster"></div>
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
	<div class="wvpl-interface">
		<div class="wvpl-controls">
			<div class="wvpl-icon wvpl-prev wvpl-disabled"></div>
			<div class="wvpl-icon wvpl-play"></div>
			<div class="wvpl-icon wvpl-next wvpl-disabled"></div>
		</div>
		<div class="wvpl-volume-slider">
			<div class="rail">
				<div class="value"></div>
			</div>
			<div class="handle"></div>
			<div class="touchable"></div>
		</div>
		<div class="wvpl-infobar">
			<div class="wvpl-playing-info"><div class="wvpl-infoblock"></div></div>
		</div>
	</div>
	<div class="wvpl-playlist">
		<div class="wvpl-playlist-wrapper"></div>
	</div>
</div>
