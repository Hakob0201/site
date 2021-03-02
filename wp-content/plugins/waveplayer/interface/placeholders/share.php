<?php
/**
 * You can customize the output of this placeholder copying this file
 * in your current theme folder, in the following location:
 * /wp-content/themes/<your-theme>/waveplayer/placeholders/share.php
 *
 * This way, you can safely upgrade WavePlayer to a newer version,
 * without losing any customization you made to the structure of the player.
 *
 * @package WavePlayer/Placeholders
 * @phpcs:disable Generic.PHP.DisallowAlternativePHPTags.MaybeASPOpenTagFound
 * @phpcs:disable Generic.PHP.DisallowAlternativePHPTags.MaybeASPShortOpenTagFound
 */

defined( 'ABSPATH' ) || exit;

?>
<% if ( ( attributes.guests || loggedUser ) ) { %>
	<% url = track.post_url %>
	<% if ( track.type === 'soundcloud' ) { url = track.soundcloud_url } %>
	<span class="wvpl-stats wvpl-icon wvpl-button wvpl-share <%= attributes.class %>" title="<%= __( 'Share', 'waveplayer' ) %>" data-title="<%= track.title %>" data-url="<%= url %>">
		<span class="wvpl-share-popup">
			<ul>
				<li class="wvpl-icon wvpl-button wvpl-share_fb" data-social="fb"></li>
				<li class="wvpl-icon wvpl-button wvpl-share_tw" data-social="tw"></li>
				<li class="wvpl-icon wvpl-button wvpl-share_ln" data-social="ln"></li>
			</ul>
		</span>
	</span>
<% } %>
