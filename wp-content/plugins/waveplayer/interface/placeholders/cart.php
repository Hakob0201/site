<?php
/**
 * You can customize the output of this placeholder copying this file
 * in your current theme folder, in the following location:
 * /wp-content/themes/<your-theme>/waveplayer/placeholders/cart.php
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
	<% if ( track.product_id ) {
		var cart = track.in_cart > 0 ? 'wvpl-in_cart' : 'wvpl-add_to_cart';
		var callback = track.in_cart > 0 ? 'goToCart' : 'addToCart';
		var title = track.in_cart > 0 ? __( 'Already in cart: go to cart', 'waveplayer' ) : __( 'Add to cart', 'waveplayer' ); %>

		<span class="wvpl-stats wvpl-icon wvpl-button wvpl-cart <%= cart %> <%= attributes.class %>"
			title="<%= title %>"
			data-product_id="<%= track.product_id %>"
			data-event="<%= callback %>"
			data-callback="<%= callback %>">
	</span>
	<% } %>
<% } %>
