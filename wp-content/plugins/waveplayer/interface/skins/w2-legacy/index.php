<?php
/**
 * Skin Name: WavePlayer2 Legacy
 * Supports: size,shape,style,volume,infobar,playlist
 * Author: Luigi Pulcini
 * Version: 3.0.0
 * Author URI: http://www.luigipulcini.com
 * Description: This is the traditional WavePlayer2 visual interface. If you have been using WavePlayer 2, we recommend selecting this skin to minimize the chances of problems with your current customization.
 *
 * You can customize this interface copying the whole folder
 * in your current child theme folder, in the following location:
 * /wp-content/themes/<your-child-theme>/waveplayer/interface/skins/w2-legacy
 *
 * If WavePlayer find this skin in your child theme folder, it will override the factory one.
 *
 * @package WavePlayer/skins
 */

defined( 'ABSPATH' ) || exit;

?>
<div id="<?php echo esc_attr( $args['id'] ); ?>" class="<?php echo esc_attr( $args['classes'] ); ?>" <?php echo $args['dataset']; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="wvpl-left-box" style="background-image:url(<?php echo esc_attr( $args['default_thumbnail'] ); ?>)">
		<div class="wvpl-interface">
			<div class="wvpl-volume-overlay"></div>
			<div class="wvpl-icon wvpl-info"></div>
			<div class="wvpl-controls">
				<div class="wvpl-icon wvpl-prev wvpl-disabled"></div>
				<div class="wvpl-icon wvpl-play"></div>
				<div class="wvpl-icon wvpl-next wvpl-disabled"></div>
			</div>
			<?php if ( isset( $args['volume_mode'] ) && 'slider' === $args['volume_mode'] ) { ?>
				<div class="wvpl-volume-slider">
					<div class="rail">
						<div class="value"></div>
					</div>
					<div class="handle"></div>
					<div class="touchable"></div>
				</div>
			<?php } else { ?>
				<div class="wvpl-icon wvpl-volume wvpl-volume_up"></div>
			<?php } ?>
		</div>
		<div class="wvpl-poster"></div>
	</div>
	<div class="wvpl-right-box">
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
		<div class="wvpl-duration"></div>
		<div class="wvpl-waveform"></div>
		<div class="wvpl-infobar">
			<div class="wvpl-playing-info"><div class="wvpl-infoblock"></div></div>
		</div>
	</div>
	<div class="wvpl-playlist">
		<div class="wvpl-playlist-wrapper"></div>
	</div>
</div>
