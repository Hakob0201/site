<?php
/**
 * You can customize the output of this placeholder copying this file
 * in your current theme folder, in the following location:
 * /wp-content/themes/<your-theme>/waveplayer/placeholders/likes.php
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
	<% if ( track.stats ) { %>
		<% var l = track.stats.likes; %>
		<% var msg = !loggedUser ? __( 'Only logged in users can like tracks', 'waveplayer' ) : ''; %>
		<% var liked = track.liked ? 'liked' : ''; %>
		<span
			class="wvpl-stats wvpl-icon wvpl-button wvpl-<%=key %> <%= liked %> <%= attributes.class%>"
			title="<%= __( 'Liked by %s users', 'waveplayer' ).replace('%s', l) %> <%= msg %>"
			data-id="<%= track.id %>"
			data-index="<%= track.index %>"
			data-event="<%= track.liked ? 'unlike' : 'like' %>"
			data-callback="updateLikes">
			<% if ( attributes.showValue ) { %>
				<span class="wvpl-value"><%= l %></span>
			<% } %>
		</span>
	<% } %>
<% } %>
