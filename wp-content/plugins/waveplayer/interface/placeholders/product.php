<?php
/**
 * You can customize the output of this placeholder copying this file
 * in your current theme folder, in the following location:
 * /wp-content/themes/<your-theme>/waveplayer/placeholders/product.php
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
	<% if (track.product_url ) { %>
		<span
			class="wvpl-stats wvpl-icon wvpl-button wvpl-product <%= attributes.class %>"
			title="<%= __( 'Go to the product page', 'waveplayer' ) %>"
			data-id="<%= track.id %>"
			data-index="<%= track.index %>"
			data-product-id="<%= track.product_id %>">
			<a href="<%= track.product_url || '' %>" class="wvpl-link <%= attributes.class %>"></a>
		</span>
	<% } %>
<% } %>
