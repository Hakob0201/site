<?php //phpcs:ignore WordPress.Files.Filename.NoHyphenatedLowercase
/**
 * You can customize the output of this placeholder copying this file
 * in your current theme folder, in the following location:
 * /wp-content/themes/<your-theme>/waveplayer/placeholders/runtime.php
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
	<% if (!track.stats) {
		s = '0:00';
	} else {
		var length = Math.round(track.stats.runtime);
		var seconds = length % 60,
			minutes = Math.floor(length / 60) % 60,
			hours = Math.floor(length / 3600);
		s = (hours > 0 ? hours + ":" : "") + (hours > 0 && minutes < 10 ? "0" : "") + minutes + ":" + (seconds < 10 ? "0" : "") + seconds;
	} %>
	<span class="wvpl-stats <%= attributes.class %>" title="<%= __( 'Total runtime: %s', 'waveplayer' ).replace('%s',s) %>">
		<span class="fa fa-hourglass-half <%= attributes.icon %>"></span>
		<% if ( attributes.showValue ) { %>
			<span class="wvpl-value"><%= s %></span>
		<% } %>
	</span>
<% } %>
