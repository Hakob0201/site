<?php
if(!class_exists('WCMP_WCVENDORS_ADDON'))
{
	class WCMP_WCVENDORS_ADDON
	{
		private $_wcmp;

		function __construct($wcmp)
		{
			$this->_wcmp = $wcmp;

			if(get_option('wcmp_wcv_enabled', 1))
			{
				add_action('wcv-after_seo_tab',array($this, 'product_settings'), 10, 2);
				add_action('wcv_save_product', array($this, 'save_product_settings'));
			}
			add_action('wcv_delete_post', array($this, 'delete_product'));
			add_action('wcmp_addon_general_settings', array($this, 'general_settings'));
			add_action('wcmp_save_setting', array($this, 'save_general_settings'));
		} // End __construct

		public function general_settings()
		{
			$wcmp_wcv_enabled = get_option('wcmp_wcv_enabled', 1);
			print '<tr><td><input aria-label="'.esc_attr(__('Activate the WC Vendors add-on','music-player-for-woocommerce')).'" type="checkbox" name="wcmp_wcv_enabled" '.($wcmp_wcv_enabled ? 'CHECKED'  : '').'></td><td width="100%"><b>'.__('Activate the WC Vendors add-on (Experimental add-on)', 'music-player-for-woocommerce').'</b><br><i>'.__('If the "WC Vendors" plugin is installed on the website, check the checkbox to allow vendors to configure their music players.', 'music-player-for-woocommerce').'</i></td></tr>';
		} // End general_settings

		public function save_general_settings()
		{
			update_option('wcmp_wcv_enabled', (!empty($_POST['wcmp_wcv_enabled'])) ? 1 : 0);
		} // End save_general_settings

		public function product_settings($product_id)
		{
			$post = get_post( $product_id );
			wp_enqueue_style('wcmp-wcv-css', plugin_dir_url(__FILE__).'wcv/style.css');
			?>
			<div class="wcv-container">
				<h6><?php _e('Music Player', 'music-player-for-woocommerce'); ?></h6>
				<input type="hidden" name="wcmp_nonce" value="<?php echo wp_create_nonce('wcmp_updating_product'); ?>" />
				<?php
				include_once dirname(__FILE__).'/../views/player_options.php';
				?>
			</div>
			<?php
		} // End product_settings

		public function save_product_settings($post_id)
		{
			$post = wc_get_product( $post_id );
			$this->_wcmp->save_post($post_id, $post, true);
		} // End save_product_settings

		public function delete_product($post_id)
		{
			$this->_wcmp->delete_post($post_id);
		} // End delete_product

		//******************** PRIVATE METHODS ************************


	} // End WCMP_WCVENDORS_ADDON
}

new WCMP_WCVENDORS_ADDON($wcmp);