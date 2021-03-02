<?php
/**
 * You can customize this interface copying the whole folder
 * in your current child theme folder, in the following location:
 * /wp-content/themes/<your-child-theme>/waveplayer/interface/skins
 *
 * If WavePlayer find this skin in your child theme folder, it will override the factory one.
 *
 * @package WavePlayer/skins
 */

defined( 'ABSPATH' ) || exit;

/*
This is the HTML markup used for the sticky player.

You can customize this interface copying this file
in your current child theme folder, in the following location:
/wp-content/themes/<your-child-theme>/waveplayer/interface/sticky.php

If WavePlayer find this file in your child theme folder, it will override the factory one.

*/

?>

<div id="wvpl-sticky-player" class="<?php echo esc_attr( $classes ); ?>">
	<div class="wvpl-container">
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
		<div class="wvpl-wave">
			<div class="wvpl-position">0:00</div>
			<div class="wvpl-waveform"></div>
			<div class="wvpl-duration">0:00</div>
		</div>
		<div class="wvpl-trackinfo"></div>
	</div>
	<button type="button" class="wvpl-sticky-player-toggle"></button>
</div>
