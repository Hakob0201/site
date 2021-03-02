<?php //phpcs:ignore WordPress.Files.Filename.NoHyphenatedLowercase
/**
 * You can customize the output of this placeholder copying this file
 * in your current theme folder, in the following location:
 * /wp-content/themes/<your-theme>/waveplayer/placeholders/share_fb.php
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
	<% var social = key.replace('share_', ''); %>
	<span class="wvpl-stats <%= attributes.class %>" title="<%= __( 'Share', 'waveplayer' ) %>">
		<span class="fa fa-<%= social %> wvpl-<%= social %> wvpl-share <%= attributes.icon %>" data-title="<%= track.title %>" data-social="<%= social %>" data-url="<%= location.protocol + track.post_url %>"></span>
	</span>
<% } %>
