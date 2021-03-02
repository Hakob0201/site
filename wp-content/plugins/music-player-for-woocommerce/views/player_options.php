<?php
if( !defined( 'WCMP_PLUGIN_URL' ) ) { echo 'Direct access not allowed.';  exit; }

// include resources
wp_enqueue_style( 'wcmp-admin-style', plugin_dir_url(__FILE__).'../css/style.admin.css', array(), '1.0.24' );

if(empty($post)) global $post;

$enable_player 	= $GLOBALS[ 'WooCommerceMusicPlayer' ]->get_product_attr( $post->ID, '_wcmp_enable_player', false );
$show_in 		= $GLOBALS[ 'WooCommerceMusicPlayer' ]->get_product_attr( $post->ID, '_wcmp_show_in', 'all' );
$player_style 	= $GLOBALS[ 'WooCommerceMusicPlayer' ]->get_product_attr( $post->ID, '_wcmp_player_layout', WCMP_DEFAULT_PLAYER_LAYOUT );
$volume 		= $GLOBALS[ 'WooCommerceMusicPlayer' ]->get_product_attr( $post->ID, '_wcmp_player_volume', WCMP_DEFAULT_PLAYER_VOLUME );
$player_controls= $GLOBALS[ 'WooCommerceMusicPlayer' ]->get_product_attr( $post->ID, '_wcmp_player_controls', WCMP_DEFAULT_PLAYER_CONTROLS );
$player_title= intval( $GLOBALS[ 'WooCommerceMusicPlayer' ]->get_product_attr( $post->ID, '_wcmp_player_title', 1 ) );
$merge_grouped	= intval( $GLOBALS[ 'WooCommerceMusicPlayer' ]->get_product_attr( $post->ID, '_wcmp_merge_in_grouped',0 ) );
$play_all		= intval( $GLOBALS[ 'WooCommerceMusicPlayer' ]->get_product_attr(
						$post->ID,
						'_wcmp_play_all',
						// This option is only for compatibility with versions previous to 1.0.28
						$GLOBALS[ 'WooCommerceMusicPlayer' ]->get_product_attr(
							$post->ID,
							'play_all',
							0
						)
					)
				);
$preload		= $GLOBALS[ 'WooCommerceMusicPlayer' ]->get_product_attr(
					$post->ID,
					'_wcmp_preload',
					$GLOBALS[ 'WooCommerceMusicPlayer' ]->get_product_attr(
						$post->ID,
						'preload',
						'none'
					)
				);
$on_cover 		= intval( $GLOBALS[ 'WooCommerceMusicPlayer' ]->get_product_attr( $post->ID, '_wcmp_on_cover', 0 ) );
?>
<input type="hidden" name="wcmp_nonce" value="<?php echo wp_create_nonce('wcmp_updating_product'); ?>" />
<table class="widefat" style="border-left:0;border-right:0;border-bottom:0;padding-bottom:0;">
	<tr>
		<td>
			<div class="wcmp-highlight-box">
			<?php
			_e(
				'<p>The player uses the audio files associated to the product. If you want protecting the audio files for selling, tick the checkbox: <b>"Protect the file"</b>, in whose case the plugin will create a truncated version of the audio files for selling to be used for demo. The size of audio files for demo is based on the number entered through the attribute: <b>"Percent of audio used for protected playbacks"</b>.</p><p><b>Protecting the files prevents that malicious users can access to the original audio files without pay for them.</b></p>',
				'music-player-for-woocommerce'
			);
			?>
			<p><?php _e( 'The security feature and particular files for demo are only available in the PRO version of the plugin', 'music-player-for-woocommerce'); ?>. <a target="_blank" href="https://wcmp.dwbooster.com"><?php _e('CLICK HERE TO GET THE PRO VERSION OF THE PLUGIN', 'music-player-for-woocommerce'); ?></a></p>
			<p><?php _e( 'For testing the premium version of the plugin, visit the online demo:<br/> <a href="https://demos.dwbooster.com/music-player-for-woocommerce/wp-login.php" target="_blank">Administration area: Click to access the administration area demo</a><br/><a href="https://demos.dwbooster.com/music-player-for-woocommerce/" target="_blank">Public page: Click to visit the WooCommerce Store</a>', 'music-player-for-woocommerce'); ?></p>
			</div>
			<div class="wcmp-highlight-box">
				<div id="wcmp_tips_header">
					<h3 style="margin-top:2px;margin-bottom:5px;cursor:pointer;" onclick="jQuery('#wcmp_tips_body').toggle();">
						<?php _e('[+|-] Tips', 'music-player-for-woocommerce'); ?>
					</h3>
				</div>
				<div id="wcmp_tips_body">
					<div class="wcmp-highlight-box">
						<a class="wcmp-tip"href="javascript:void(0);" onclick="jQuery(this).next('.wcmp-tip-text').toggle();">
						<?php _e('[+|-] Using the audio files stored on Google Drive', 'music-player-for-woocommerce'); ?>
						</a>
						<div class="wcmp-tip-text">
						<ul>
							<li>
								<p> -
								<?php
									_e(
										'Go to Drive, press the right click on the file to use, and select the option: <b>"Get Shareable Link"</b>',
										'music-player-for-woocommerce'
									);
								?>
								</p>
								<p>
								<?php
									_e(
										'The previous action will generate an url with the structure: <b>https://drive.google.com/open?id=FILE_ID</b>',
										'music-player-for-woocommerce'
									);
								?>
								</p>
							</li>
							<li>
								<p> -
									<?php
									_e(
										'Knowing the FILE_ID, extracted from the previous URL, enter the URL below, into the WooCommerce product, to allow the Music Player accessing to it:',
										'music-player-for-woocommerce'
									);
								?>
								</p>
								<p>
									<b>https://drive.google.com/uc?export=download&id=FILE_ID&.mp3</b>
								</p>
								<p>
									<?php
									_e(
										'<b>Note:</b> Pay attention to the use of the fake parameter: <b>&.mp3</b> as the last one in the URL',
										'music-player-for-woocommerce'
									);
									?>
								</p>
							</li>
						</div>
					</div>
					<div class="wcmp-highlight-box">
						<a class="wcmp-tip"href="javascript:void(0);" onclick="jQuery(this).next('.wcmp-tip-text').toggle();">
						<?php _e('[+|-] Using the audio files stored on DropBox', 'music-player-for-woocommerce'); ?>
						</a>
						<div class="wcmp-tip-text">
						<ul>
							<li>
								<p> -
								<?php
									_e(
										'Sign in to <a href="https://www.dropbox.com/login" target="_blank">dropbox.com </a>',
										'music-player-for-woocommerce'
									);
								?>
								</p>
							</li>
							<li>
								<p> -
								<?php
									_e(
										"Hover your cursor over the file or folder you'd like to share and click <b>Share</b> when it appears.",
										'music-player-for-woocommerce'
									);
								?>
								</p>
							</li>
							<li>
								<p> -
								<?php
									_e(
										"If a link hasn't been created, click Create a link. (If a link was already created, click Copy link.",
										'music-player-for-woocommerce'
									);
								?>
								</p>
								<p>
								<?php
									_e(
										'The link structure would be similar to:<br> https://www.dropbox.com/s/rycvgn8iokfedmo/file.mp3?dl=0',
										'music-player-for-woocommerce'
									);
								?>
								</p>
							</li>
							<li>
								<p> -
								<?php
									_e(
										'Enter the URL into the WooCommerce product with the following structure:<br> https://www.dropbox.com/s/rycvgn8iokfedmo/file.mp3?dl=1&.mp3',
										'music-player-for-woocommerce'
									);
								?>
								</p>
								<p>
									<?php
									_e(
										'<b>Note:</b> Pay attention to the use of the fake parameter: <b>&.mp3</b> as the last one in the URL. Furthermore, the parameter <b>dl=0</b>, has been modified as <b>dl=1</b>',
										'music-player-for-woocommerce'
									);
									?>
								</p>
							</li>
						</div>
					</div>
				</div>
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<table class="widefat wcmp-player-settings" style="border:1px solid #e1e1e1;">
				<tr>
					<td><?php _e( 'Include music player', 'music-player-for-woocommerce' ); ?></td>
					<td><div class="wcmp-tooltip"><span class="wcmp-tooltiptext"><?php _e('The player is shown only if the product is "downloadable", and there is at least an audio file between the "Downloadable files"', 'music-player-for-woocommerce'); ?></span><input aria-label="<?php print esc_attr(__('Enable player','music-player-for-woocommerce')); ?>" type="checkbox" name="_wcmp_enable_player" <?php echo (( $enable_player ) ? 'checked' : '' ); ?> /></div></td>
				</tr>
				<tr>
					<td><?php _e( 'Include in', 'music-player-for-woocommerce' ); ?></td>
					<td>
						<input aria-label="<?php print esc_attr(__('Include on products pages','music-player-for-woocommerce')); ?>" type="radio" name="_wcmp_show_in" value="single" <?php echo (( $show_in == 'single' ) ? 'checked' : '' ); ?> />
						<?php _e('single-entry pages <i>(Product\'s page only)</i>', 'music-player-for-woocommerce'); ?><br />

						<input aria-label="<?php print esc_attr(__('Include on multiple-entry pages','music-player-for-woocommerce')); ?>" type="radio" name="_wcmp_show_in" value="multiple" <?php echo (( $show_in == 'multiple' ) ? 'checked' : '' ); ?> />
						<?php _e('multiple entries pages <i>(Shop pages, archive pages, but not in the product\'s page)</i>', 'music-player-for-woocommerce'); ?><br />

						<input aria-label="<?php print esc_attr(__('Include on product and multiple-entry pages', 'music-player-for-woocommerce')); ?>" type="radio" name="_wcmp_show_in" value="all" <?php echo (( $show_in == 'all' ) ? 'checked' : '' ); ?> />
						<?php _e('all pages <i>(with single or multiple-entries)</i>', 'music-player-for-woocommerce'); ?>
					</td>
				</tr>
				<tr>
					<td><?php _e( 'Merge in grouped products', 'music-player-for-woocommerce' ); ?></td>
					<td><input aria-label="<?php print esc_attr(__('Merge in grouped products','music-player-for-woocommerce')); ?>" type="checkbox" name="_wcmp_merge_in_grouped" <?php echo (( $merge_grouped ) ? 'checked' : '' ); ?> /><br /><em><?php _e( 'In grouped products, display the "Add to cart" buttons and quantity fields in the players rows', 'music-player-for-woocommerce' ); ?></em></td>
				</tr>
				<tr>
					<td valign="top"><?php _e( 'Player layout', 'music-player-for-woocommerce' ); ?></td>
					<td>
						<table>
							<tr>
								<td><input aria-label="<?php print esc_attr(__('Skin 1','music-player-for-woocommerce')); ?>" name="_wcmp_player_layout" type="radio" value="mejs-classic" <?php echo (($player_style == 'mejs-classic') ? 'checked' : '') ;?> /></td>
								<td><img alt="<?php print esc_attr(__('Skin 1','music-player-for-woocommerce')); ?>" src="<?php print esc_url(WCMP_PLUGIN_URL); ?>/views/assets/skin1.png" /></td>
							</tr>

							<tr>
								<td><input aria-label="<?php print esc_attr(__('Skin 2','music-player-for-woocommerce')); ?>" name="_wcmp_player_layout" type="radio" value="mejs-ted" <?php echo (($player_style == 'mejs-ted') ? 'checked' : '') ;?> /></td>
								<td><img alt="<?php print esc_attr(__('Skin 2','music-player-for-woocommerce')); ?>" src="<?php print esc_url(WCMP_PLUGIN_URL); ?>/views/assets/skin2.png" /></td>
							</tr>

							<tr>
								<td><input aria-label="<?php print esc_attr(__('Skin 3','music-player-for-woocommerce')); ?>" name="_wcmp_player_layout" type="radio" value="mejs-wmp" <?php echo (($player_style == 'mejs-wmp') ? 'checked' : '') ;?> /></td>
								<td><img alt="<?php print esc_attr(__('Skin 3','music-player-for-woocommerce')); ?>" src="<?php print esc_url(WCMP_PLUGIN_URL); ?>/views/assets/skin3.png" /></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<?php _e( 'Preload', 'music-player-for-woocommerce' ); ?>
					</td>
					<td>
						<label><input aria-label="<?php print esc_attr(__('Preload - none','music-player-for-woocommerce')); ?>" type="radio" name="_wcmp_preload" value="none" <?php if($preload == 'none') echo 'CHECKED'; ?> /> None</label><br />
						<label><input aria-label="<?php print esc_attr(__('Preload - metadata','music-player-for-woocommerce')); ?>" type="radio" name="_wcmp_preload" value="metadata" <?php if($preload == 'metadata') echo 'CHECKED'; ?> /> Metadata</label><br />
						<label><input aria-label="<?php print esc_attr(__('Preload - auto','music-player-for-woocommerce')); ?>" type="radio" name="_wcmp_preload" value="auto" <?php if($preload == 'auto') echo 'CHECKED'; ?> /> Auto</label><br />
					</td>
				</tr>
				<tr>
					<td>
						<?php _e( 'Play all', 'music-player-for-woocommerce' ); ?>
					</td>
					<td>
						<input aria-label="<?php print esc_attr(__('Play all','music-player-for-woocommerce')); ?>" type="checkbox" name="_wcmp_play_all" <?php if(!empty($play_all)) echo 'CHECKED'; ?> />
					</td>
				</tr>
				<tr>
					<td><?php _e( 'Player volume (from 0 to 1)', 'music-player-for-woocommerce' ); ?></td>
					<td>
						<input aria-label="<?php print esc_attr(__('Player volume', 'music-player-for-woocommerce')); ?>" type="number" name="_wcmp_player_volume" min="0" max="1" step="0.01" value="<?php echo esc_attr($volume); ?>" />
					</td>
				</tr>
				<tr>
					<td><?php _e( 'Player controls', 'music-player-for-woocommerce' ); ?></td>
					<td>
						<input aria-label="<?php print esc_attr(__('Play/pause button','music-player-for-woocommerce')); ?>" type="radio" name="_wcmp_player_controls" value="button" <?php echo (( $player_controls == 'button' ) ? 'checked' : ''); ?> /> <?php _e( 'the play/pause button only', 'music-player-for-woocommerce' ); ?><br />
						<input aria-label="<?php print esc_attr(__('All controls', 'music-player-for-woocommerce')); ?>" type="radio" name="_wcmp_player_controls" value="all" <?php echo (( $player_controls == 'all' ) ? 'checked' : ''); ?> /> <?php _e( 'all controls', 'music-player-for-woocommerce' ); ?><br />
						<input aria-label="<?php print esc_attr(__('Depending on context','music-player-for-woocommerce')); ?>" type="radio" name="_wcmp_player_controls" value="default" <?php echo (( $player_controls == 'default' ) ? 'checked' : ''); ?> /> <?php _e( 'the play/pause button only, or all controls depending on context', 'music-player-for-woocommerce' ); ?>
						<div class="wcmp-on-cover" style="margin-top:10px;">
							<input aria-label="<?php print esc_attr(__('On cover','music-player-for-woocommerce')); ?>" type="checkbox" name="_wcmp_player_on_cover" value="default" <?php
							echo ((!empty($on_cover) && ( $player_controls == 'button' ||  $player_controls == 'default')) ? 'checked' : '');
							?> />
							<?php _e( 'for play/pause button players display them on cover images.', 'music-player-for-woocommerce' ); ?>
							<i>
							<?php
							_e('(This feature is experimental, and will depend on the theme active on the website.)', 'music-player-for-woocommerce');
							?>
							</i>
						</div>
					</td>
				</tr>
				<tr>
					<td><?php _e( 'Display the player\'s title', 'music-player-for-woocommerce' ); ?></td>
					<td>
						<input aria-label="<?php print esc_attr(__('Display the player title','music-player-for-woocommerce')); ?>" type="checkbox" name="_wcmp_player_title" <?php echo (( !empty($player_title) ) ? 'checked' : ''); ?> />
					</td>
				</tr>
				<tr>
					<td colspan="2" style="color:red;"><?php _e( 'The security feature is only available in the PRO version of the plugin', 'music-player-for-woocommerce'); ?>. <a target="_blank" href="https://wcmp.dwbooster.com"><?php _e('CLICK HERE TO GET THE PRO VERSION OF THE PLUGIN', 'music-player-for-woocommerce'); ?></a></td>
				</tr>
				<tr>
					<td style="color:#DDDDDD;"><?php _e( 'Protect the file', 'music-player-for-woocommerce' ); ?></td>
					<td><input aria-label="<?php print esc_attr(__('Protect the file','music-player-for-woocommerce')); ?>" type="checkbox" DISABLED /></td>
				</tr>
				<tr valign="top">
					<td style="color:#DDDDDD;"><?php _e('Percent of audio used for protected playbacks', 'music-player-for-woocommerce'); ?></td>
					<td style="color:#DDDDDD;">
						<input aria-label="<?php print esc_attr(__('Percent of audio used for protected playbacks','music-player-for-woocommerce')); ?>" type="number" DISABLED /> % <br /><br />
						<em><?php _e('To prevent unauthorized copying of audio files, the files will be partially accessible', 'music-player-for-woocommerce'); ?></em>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<table class="widefat" style="border:0;padding-bottom:20px;">
	<tr valign="top">
		<td style="color:#DDDDDD;">
			<table class="widefat wcmp-player-demos" style="border:1px solid #e1e1e1;">
				<tr valign="top">
					<td style="color:#DDDDDD;"><input aria-label="<?php print esc_attr(__('Own demo files','music-player-for-woocommerce')); ?>" type="checkbox" disabled /> <?php _e('Select my own demo files', 'music-player-for-woocommerce'); ?></td>
				</tr>
				<tr valign="top" class="wcmp-demo-files">
					<td>
						<div style="color:#DDDDDD;"><?php _e('Demo files', 'music-player-for-woocommerce'); ?></div>
						<table class="widefat">
							<thead>
								<tr>
									<th style="color:#DDDDDD;"><?php _e('Name', 'music-player-for-woocommerce'); ?></th>
									<th colspan="2" style="color:#DDDDDD;"><?php _e('File URL', 'music-player-for-woocommerce'); ?></th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<input aria-label="<?php print esc_attr(__('File name','music-player-for-woocommerce')); ?>" type="text" class="wcmp-file-name" placeholder="<?php _e('File Name', 'music-player-for-woocommerce'); ?>" disabled style="color:#DDDDDD;" />
									</td>
									<td>
										<input aria-label="<?php print esc_attr(__('File URL','music-player-for-woocommerce')); ?>" type="text" class="wcmp-file-url" placeholder="http://" disabled style="color:#DDDDDD;" />
									</td>
									<td width="1%" style="color:#DDDDDD;">
										<a href="javascript:void(0);" class="button wcmp-select-file" style="color:#DDDDDD;"><?php _e('Choose file', 'music-player-for-woocommerce'); ?></a>
									</td>
									<td width="1%" style="color:#DDDDDD;">
										<a href="javascript:void(0);" class="wcmp-delete" style="color:#DDDDDD;"><?php _e('Delete', 'music-player-for-woocommerce');?></a>
									</td>
								</tr>
							</tbody>
							<tfoot>
								<tr>
									<th colspan="4" style="color:#DDDDDD;">
										<a href="javascript:void(0);" class="button wcmp-add" style="color:#DDDDDD;"><?php _e('Add File', 'music-player-for-woocommerce'); ?></a>
									</th>
								</tr>
							</tfoot>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<script>jQuery(window).on('load', function(){
	var $ = jQuery;
	function coverSection()
	{
		var v = $('[name="_wcmp_player_controls"]:checked').val(),
			c = $('.wcmp-on-cover');
		if(v == 'default' || v == 'button') c.show();
		else c.hide();
	};
	$(document).on('change', '[name="_wcmp_player_controls"]', function(){
		coverSection();
	});
	coverSection();
});</script>
<style>.wcmp-player-settings tr td:first-child{width:225px;}</style>