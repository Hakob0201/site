<?php //phpcs:ignore WordPress.Files.Filename.NoHyphenatedLowercase
/**
 * You can customize the output of this placeholder copying this file
 * in your current theme folder, in the following location:
 * /wp-content/themes/<your-theme>/waveplayer/placeholders/play_count.php
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
	<%
		if ( track.stats ) {
			count = track.stats.play_count;
	%>
			<span class="wvpl-stats wvpl-icon wvpl-play_count <%= attributes.class %> " title="<%= _n( 'Played by %s user', 'Played by %s users', count, 'waveplayer' ).replace('%s', count) %>">
				<% if ( attributes.showValue ) { %>
					<span class="wvpl-value"><%= count %></span>
				<% } %>
			</span>
	<% } %>
<% } %>
