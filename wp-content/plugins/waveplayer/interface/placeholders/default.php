<?php
/**
 * You can customize the output of this placeholder copying this file
 * in your current theme folder, in the following location:
 * /wp-content/themes/<your-theme>/waveplayer/placeholders/default.php
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
	<% if ( attributes.raw ) { %>
		<%= track[ key ] %>
	<% } else { %>
		<% const iconClass = attributes.icon ? 'wvpl-icon ' + attributes.icon : '' %>
		<% const buttonClass = attributes.event ? 'wvpl-stats wvpl-button' : '' %>
		<% const statClass = iconClass || buttonClass ? 'wvpl-stats' : '' %>
		<span class="<%= statClass %> <%= iconClass %> <%= buttonClass %> wvpl-<%= key %> <%= attributes.class %>"
			title="<%= attributes.title %>"
			data-id="<%= track.id %>"
			data-index="<%= track.index %>"
			data-event="<%= attributes.event %>">
			<% if ( attributes.url ) { %>
				<% const download = attributes.download ? 'download="' + attributes.download + '"' : '' %>
				<a href="<%= attributes.url %>" class="wvpl-link" target="<%= attributes.target %>" <%= download %> >
			<% } %>
			<% if ( attributes.label ) { %>
				<%= attributes.label %>
			<% } %>
			<%= track[ key ] %>
			<% if ( attributes.url ) { %>
				</a>
			<% } %>
		</span>
	<% } %>
<% } %>
