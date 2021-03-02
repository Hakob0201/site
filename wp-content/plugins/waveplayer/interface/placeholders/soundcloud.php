<?php
/**
 * You can customize the output of this placeholder copying this file
 * in your current theme folder, in the following location:
 * /wp-content/themes/<your-theme>/waveplayer/placeholders/soundcloud.php
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
	<a href="<%= track.soundcloud_url || '' %>" class="wvpl-link <%= attributes.class %>" target="<%= attributes.target || '_blank' %>">
		<span
			class="wvpl-stats wvpl-icon wvpl-button wvpl-soundcloud <%= attributes.class %>"
			title="<%= __( 'Play this track on Soundcloud', 'waveplayer' ) %>"
			data-id="<%= track.id %>"
			data-index="<%= track.index %>"
			data-event="goToSoundcloud">
	</a>
<% } %>
