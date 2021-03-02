<?php
/**
 * Skin Name: Inline Play
 * Supports: size
 * Author: Luigi Pulcini
 * Version: 3.0.0
 * Author URI: http://www.luigipulcini.com
 * Description: A minimal interface with just the play button. This interface is ideal as an inline play icon that open the track in the sticky player.
 *
 * You can customize this interface copying the whole folder
 * in your current child theme folder, in the following location:
 * /wp-content/themes/<your-child-theme>/waveplayer/interface/skins/inline-play
 *
 * If WavePlayer find this skin in your child theme folder, it will override the factory one.
 *
 * @package WavePlayer/skins
 */

defined( 'ABSPATH' ) || exit;

?>
<div id="<?php echo esc_attr( $args['id'] ); ?>" class="<?php echo esc_attr( $args['classes'] ); ?>" <?php echo $args['dataset']; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="wvpl-controls">
		<div class="wvpl-icon wvpl-play"></div>
	</div>
</div>
