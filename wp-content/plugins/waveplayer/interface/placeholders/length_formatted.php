<?php //phpcs:ignore WordPress.Files.Filename.NoHyphenatedLowercase
/**
 * You can customize the output of this placeholder copying this file
 * in your current theme folder, in the following location:
 * /wp-content/themes/<your-theme>/waveplayer/placeholders/length_formatted.php
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
	<span class="wvpl-stats <%= attributes.class %>" title="<%= __( 'Track length: %s', 'waveplayer' ).replace('%s', track.length_formatted) %>">
		<span class="<%= attributes.icon %>"></span>
		<% if ( attributes.showValue ) { %>
			<span class="wvpl-value"><%= track.length_formatted %></span>
		<% } %>
	</span>
<% } %>
