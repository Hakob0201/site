<?php
/**
 * You can customize the output of this placeholder copying this file
 * in your current theme folder, in the following location:
 * /wp-content/themes/<your-theme>/waveplayer/placeholders/genres.php
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

<% const genres = track.genres ? track.genres : '' %>
<% if ( genres && ( attributes.guests || loggedUser ) ) { %>
	<% if ( attributes.raw ) { %>
		<%= genres %>
	<% } else { %>
		<span class="wvpl-tax wvpl-music_genre wvpl-genres <%= attributes.class %>">
			<% if ( attributes.icon ) { %>
				<span class="fa <%= attributes.icon %>"></span>
			<% } %>
			<%= genres %>
		</span>
	<% } %>
<% } %>
