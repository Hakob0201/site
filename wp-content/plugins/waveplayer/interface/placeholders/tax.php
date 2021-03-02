<?php
/**
 * You can customize the output of this placeholder copying this file
 * in your current theme folder, in the following location:
 * /wp-content/themes/<your-theme>/waveplayer/placeholders/tax.php
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

<% const terms = track.taxonomies[taxName] ? track.taxonomies[taxName] : '' %>
<% if ( terms && ( attributes.guests || loggedUser ) ) { %>
	<% if ( attributes.raw ) { %>
		<%= terms %>
	<% } else { %>
		<span class="wvpl-tax wvpl-<%= tax_name %> <%= attributes.class %>">
			<% if ( attributes.icon ) { %>
				<span class="<%= attributes.icon %>"></span>
			<% } %>
			<%= terms %>
		</span>
	<% } %>
<% } %>
