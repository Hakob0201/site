<?php
/**
 * Admin class
 *
 * @package WavePlayer/Admin
 */

namespace PerfectPeach\WavePlayer; //phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedNamespaceFound

defined( 'ABSPATH' ) || exit;

/**
 * The Admin class manages the backend administration area
 *
 * @package WavePlayer/Admin
 */
class Admin {

	/**
	 * An array of options to be displayed in the setting page
	 *
	 * @var array
	 */
	private static $admin_page_options;

	/**
	 * Store the tab currently visible
	 *
	 * @var string
	 */
	private static $current_tab;

	/**
	 * Store the HTML tags allowed in the texts of the settings page
	 *
	 * @var string
	 */
	private static $allowed_html_tags = array(
		'a'      => array(
			'href'   => true,
			'title'  => true,
			'target' => true,
		),
		'br'     => array(),
		'code'   => array(),
		'strong' => array(),
	);

	/**
	 * Register all the functions needed to manage the administration area
	 *
	 * @since 3.0.0
	 */
	public static function load() {
		if ( wp_doing_cron() ) {
			return;
		}

		add_filter( 'attachment_fields_to_edit', array( __CLASS__, 'attachment_fields_to_edit' ), 10, 2 );
		add_filter( 'attachment_fields_to_save', array( __CLASS__, 'attachment_fields_to_save' ), 10, 2 );

		if ( wp_doing_ajax() ) {
			return;
		}

		add_filter( 'plugin_action_links_waveplayer/waveplayer.php', array( __CLASS__, 'action_links' ), 10, 2 );
		add_action( 'admin_menu', array( __CLASS__, 'update_options' ) );
		add_action( 'admin_menu', array( __CLASS__, 'add_options_page' ) );

		add_filter( 'plugins_auto_update_enabled', '__return_true' );
		add_filter( 'plugin_auto_update_setting_html', array( __CLASS__, 'auto_update_setting_html' ), 10, 3 );

		if ( ! waveplayer()->get_option( 'purchase_code' ) && ! get_transient( '_waveplayer_registration_notice_dismissed' ) ) {
			add_action( 'admin_notices', array( __CLASS__, 'registration_notice' ) );
		}

		self::set_current_tab();
	}

	/**
	 * Get the array of custom fields added to the audio attachments
	 *
	 * @since 3.0.0
	 */
	public static function get_custom_fields() {
		return apply_filters( 'waveplayer_attachment_custom_fields', get_site_option( 'waveplayer_attachment_custom_fields', array() ) );
	}

	/**
	 * Output the HTML markup of the form used to add, edit and save
	 * the audio attachment custom fields
	 *
	 * @since 3.0.0
	 */
	public static function print_custom_fields_admin() {
		$custom_fields = self::get_custom_fields();

		$field_types = array(
			'text'     => esc_html__( 'Text', 'waveplayer' ),
			'textarea' => esc_html__( 'Textarea', 'waveplayer' ),
			'checkbox' => esc_html__( 'Checkbox', 'waveplayer' ),
			'radio'    => esc_html__( 'Radio', 'waveplayer' ),
			'select'   => esc_html__( 'Select', 'waveplayer' ),
			'time'     => esc_html__( 'Time', 'waveplayer' ),
			'date'     => esc_html__( 'Date', 'waveplayer' ),
			'number'   => esc_html__( 'Number', 'waveplayer' ),
		);

		$names = array(); ?>

		<table class="form-table widefat waveplayer-custom-fields">
			<tbody>
				<?php foreach ( $custom_fields as $custom_field ) { ?>
					<tr valign="top" class="custom-field-row" data-name="<?php echo esc_attr( $custom_field['name'] ); ?>">
						<th scope="row"><?php echo esc_html( $custom_field['label'] ); ?></th>
						<td>
							<?php
								$names[] = $custom_field['name'];
								printf( 'name: <strong>%s</strong>', esc_html( $custom_field['name'] ) );
								printf( '<br>type: <strong>%s</strong>', esc_html( $custom_field['type'] ) );
								printf( '<br>default value: <strong>%s</strong>', ( isset( $custom_field['default'] ) && $custom_field['default'] ) ? esc_html( $custom_field['default'] ) : esc_html__( '&lt;none&gt;', 'waveplayer' ) );
							if ( isset( $custom_field['options'] ) ) {
								printf( '<br>options: %s', implode( ', ', esc_html( $custom_field['options'] ) ) );
							}
							?>
							<div class="row-actions">
								<span>
									<button type="button" class="button-link editinline"><?php esc_html_e( 'Edit', 'waveplayer' ); ?></button> |
								</span>
								<span class="trash">
									<a href class=""><?php esc_html_e( 'Delete', 'waveplayer' ); ?></a>
								</span>
							</div>
							<input type="hidden" class="field-name" name="waveplayer_attachment_custom_fields[<?php echo esc_attr( $custom_field['name'] ); ?>][name]" value="<?php echo esc_attr( $custom_field['name'] ); ?>" />
							<input type="hidden" class="field-label" name="waveplayer_attachment_custom_fields[<?php echo esc_attr( $custom_field['name'] ); ?>][label]" value="<?php echo esc_attr( $custom_field['label'] ); ?>" />
							<input type="hidden" class="field-type" name="waveplayer_attachment_custom_fields[<?php echo esc_attr( $custom_field['name'] ); ?>][type]" value="<?php echo esc_attr( $custom_field['type'] ); ?>" />
							<input type="hidden" class="field-default" name="waveplayer_attachment_custom_fields[<?php echo esc_attr( $custom_field['name'] ); ?>][default]" value="<?php echo esc_attr( $custom_field['default'] ); ?>" />
							<?php if ( isset( $custom_field['options'] ) ) { ?>
								<input type="hidden" class="field-options" name="waveplayer_attachment_custom_fields[<?php echo esc_attr( $custom_field['name'] ); ?>][options]" value="<?php echo esc_attr( implode( ',', $custom_field['options'] ) ); ?>" />
							<?php } ?>
						</td>
					</tr>
				<?php } ?>
				<tr id="custom_field_editor" valign="top" class="hidden" data-row="<tr valign='top' class='custom-field-row' data-name='%%name%%'><th scope='row'>%%label%%</th><td>%%description%%<div class='row-actions'><span><button type='button' class='button-link editinline'>Edit</button> |</span><span class='trash'><a href class=''>Delete</a></span></div><input type='hidden' class='field-name' name='waveplayer_attachment_custom_fields[%%name%%][name]' value='%%name%%' /><input type='hidden' class='field-label' name='waveplayer_attachment_custom_fields[%%name%%][label]' value='%%label%%' /><input type='hidden' class='field-type' name='waveplayer_attachment_custom_fields[%%name%%][type]' value='%%type%%' /><input type='hidden' class='field-default' name='waveplayer_attachment_custom_fields[%%name%%][default]' value='%%default%%' />%%option_input%%</td></tr>" data-options="<input type='hidden' class='field-options' name='waveplayer_attachment_custom_fields[%%name%%][options]' value='%%options%%' />">
					<th scope="row"></th>
					<td>
						<label for="field_label">
							<span><?php esc_html_e( 'label', 'waveplayer' ); ?></span>
							<input id="field_label" type="text" placeholder="label" />
						</label>
						<label for="field_name">
							<span><?php esc_html_e( 'name', 'waveplayer' ); ?></span>
							<input id="field_name" type="text" placeholder="name" />
						</label>
						<label for="field_type">
							<span><?php esc_html_e( 'type', 'waveplayer' ); ?></span>
							<select id="field_type">
								<?php foreach ( $field_types as $key => $field_type ) { ?>
									<option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $field_type ); ?></option>
								<?php } ?>
							</select>
						</label>
						<label for="field_default">
							<span><?php esc_html_e( 'default', 'waveplayer' ); ?></span>
							<input id="field_default" type="text" placeholder="default" />
						</label>
						<label for="field_options">
							<span><?php esc_html_e( 'options', 'waveplayer' ); ?></span>
							<input id="field_options" type="text" class="regular-text" disabled>
						</label>
						<label>
							<span>&nbsp;</span>
							<button id="update-custom-field" type="button" class="button button-primary"><?php esc_html_e( 'Update', 'waveplayer' ); ?></button>
							<button id="cancel-custom-field" type="button" class="button"><?php esc_html_e( 'Cancel', 'waveplayer' ); ?></button>
						</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<button id="add-custom-field" type="button" class="button"><?php esc_html_e( 'Add custom field', 'waveplayer' ); ?></button>
					</th>
					<td></td>
				</tr>
			</tbody>
		</table>
		<input id="custom_field_names" type="hidden" value="<?php echo esc_attr( implode( ',', $names ) ); ?>" />
		<?php
	}

	/**
	 * Return the HTML markup of a single element of the custom field form
	 *
	 * @since  3.0.0
	 * @param  array   $custom_field The properties of the custom field.
	 * @param  WP_Post $post         The post being currently edited.
	 * @return array                 The form field
	 */
	private static function generate_custom_form_field( $custom_field, $post ) {
		if ( isset( $custom_field['options'] ) ) {
			$options = array_map(
				function( $o ) {
					return trim( $o );
				},
				$custom_field['options']
			);
		}

		$form_field                = array();
		$form_field['label']       = $custom_field['label'];
		$form_field['application'] = 'audio';
		$form_field['exclusions']  = array( 'image', 'video' );
		$form_field['input']       = 'html';

		if ( isset( $custom_field['default'] ) ) {
			$form_field['value'] = $custom_field['default'];
		}
		$value = get_post_meta( $post->ID, "waveplayer_{$custom_field['name']}", true );
		if ( $value ) {
			$form_field['value'] = $value;
		}

		switch ( $custom_field['type'] ) {
			case 'text':
				$form_field['input'] = 'text';
				break;
			case 'checkbox':
				$form_field['html'] = esc_html( "<input type='checkbox' name='attachments[$post->ID][$name]' value='1' " . checked( $value, '1', false ) . ' />' );
				break;
			case 'radio':
				$form_field['input'] = 'html';
				$html                = '';
				foreach ( $options as $option ) {
					$html .= esc_html( "<label class='radio'><input type='radio' name='attachments[$post->ID][$name]' value='$option' " . checked( $value, $option, false ) . " /><span>$option</span></label><br>" );
				}
				$form_field['html'] = $html;
				break;
			case 'textarea':
				$form_field['html'] = esc_html( "<textarea name='attachments[$post->ID][$name]'>$value</textarea>" );
				break;
			case 'select':
				$form_field['input'] = 'html';
				$html                = "<select name='attachments[$post->ID][$name]'>";
				foreach ( $options as $option ) {
					$html .= "<option value='$option' " . selected( $value, $option, false ) . ">$option</option>";
				}
				$html              .= '</select>';
				$form_field['html'] = esc_html( $html );
				break;
			case 'time':
				$form_field['html'] = esc_html( "<input type='time' name='attachments[$post->ID][$name]' value='$value' />" );
				break;
			case 'date':
				$form_field['html'] = esc_html( "<input type='date' name='attachments[$post->ID][$name]' value='$value' />" );
				break;
			case 'number':
				$form_field['html'] = esc_html( "<input type='number' name='attachments[$post->ID][$name]' value='$value' />" );
				break;
			case 'color':
				$form_field['html'] = esc_html(
					"<div class='color-group'>
						<div class='color-swatch' data-name='waveplayer_$name' style='background-color:$value;'></div>
						<input type='hidden' id='waveplayer_$name' name='attachments[$post->ID][$name]' class='waveplayer-color-input' value='$value'>
					</div>"
				);
				break;
			case 'media':
				break;
		}
		return $form_field;
	}

	/**
	 * Filter the $form_fields adding the custom fields to be edited
	 *
	 * @since  3.0.0
	 * @param  array   $form_fields An array of form fields.
	 * @param  WP_Post $post        The current post object.
	 * @return array
	 */
	public static function attachment_fields_to_edit( $form_fields, $post ) {

		if ( substr( $post->post_mime_type, 0, 5 ) !== 'audio' ) {
			return $form_fields;
		}

		$custom_fields = self::get_custom_fields();
		if ( $custom_fields ) {
			foreach ( $custom_fields as $key => $field ) {
				$form_fields[ $key ] = self::generate_custom_form_field( $field, $post );
			}
		}

		if ( ! function_exists( 'wp_terms_checklist' ) ) {
			return $form_fields;
		}

		foreach ( $form_fields as $field => &$args ) {
			if ( ! taxonomy_exists( $field ) ) {
				continue;
			}

			if ( (bool) $args['hierarchical'] ) {
				ob_start();
					wp_terms_checklist(
						$post->ID,
						array(
							'taxonomy'      => $field,
							'selected_cats' => false,
							'checked_ontop' => false,
							'walker'        => new Walker_Taxonomy_Checklist(),
						)
					);
					$content = ob_get_contents();
				if ( $content ) {
					$html = '<div id="taxonomy-' . $field . '" class="categorydiv wvpl-taxonomydiv"><div id="' . $field . '-all" class="tabs-panel"><ul id="' . $field . 'checklist" data-wp-lists="list:' . $field . '" class="categorychecklist form-no-clear">' . $content . '</ul></div></div>';
				} else {
					$html = '<ul class="term-list"><li>No ' . $args['label'] . ' found.</li></ul>';
				}
				ob_end_clean();

				unset( $args['value'] );

				$args['input'] = 'html';
				$args['html']  = $html;
			} else {
				$values        = wp_get_object_terms( $post->ID, $field, array( 'fields' => 'names' ) );
				$args['value'] = join( ', ', $values );
			}
		}
		return $form_fields;
	}

	/**
	 * Filter the $form_fields adding the custom fields to be saved
	 *
	 * @since  3.0.0
	 * @param  WP_Post $post       The current post object.
	 * @param  WP_Post $attachment The attachment object.
	 * @return array
	 */
	public static function attachment_fields_to_save( $post, $attachment ) {

		if ( substr( $post['post_mime_type'], 0, 5 ) !== 'audio' ) {
			return $post;
		}

		$custom_fields = self::get_custom_fields();
		foreach ( $custom_fields as $custom_field ) {
			$key = $custom_field['name'];
			if ( isset( $attachment[ $key ] ) ) {
				update_post_meta( $post['ID'], "waveplayer_$key", $attachment[ $key ] );
			} else {
				delete_post_meta( $post['ID'], "waveplayer_$key" );
			}
		}

		if ( ! isset( $_REQUEST['tax_input'] ) ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended
			return $post;
		}

		foreach ( $_REQUEST['tax_input'] as $tax_name => $tax ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
			$term_ids = array_map(
				'intval',
				array_keys( $tax, '1', true )
			);
			wp_set_object_terms( $post['ID'], $term_ids, $tax_name, false );
			_update_generic_term_count( $term_ids, $tax_name );
		}
		return $post;
	}

	/**
	 * Return the URL of the WavePlayer setting page
	 *
	 * @since  3.0.8
	 * @param  array $args The array with the additional query args.
	 * @return string      The setting page URL
	 */
	public static function settings_page_url( $args = array() ) {
		$query_args = array_merge( array( 'page' => 'waveplayer' ), $args );
		return add_query_arg( $query_args, admin_url( 'options-general.php', 'admin' ) );
	}

	/**
	 * Add a 'Settings' link to the actions on the Plugins page
	 *
	 * @since  3.0.0
	 * @param  array  $links An array of the links in the action list.
	 * @param  string $file  The basename of the current plugin.
	 * @return array
	 */
	public static function action_links( $links, $file ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
		$settings_link = '<a href="' . esc_url( self::settings_page_url() ) . '">' . esc_html__( 'Settings', 'waveplayer' ) . '</a>';
		array_unshift( $links, $settings_link );
		return $links;
	}

	/**
	 * Add the WavePlayer option page to the Settings menu
	 *
	 * @since  3.0.0
	 */
	public static function add_options_page() {
		add_options_page( 'WavePlayer', 'WavePlayer', 'manage_options', 'waveplayer', array( __CLASS__, 'admin_page' ) );
	}

	/**
	 * Add the WavePlayer option page to the Settings menu
	 *
	 * @since  3.0.0
	 */
	public static function set_current_tab() {
		// phpcs:disable WordPress.Security.NonceVerification.Recommended
		if ( ! isset( $_GET['page'] ) || 'waveplayer' !== $_GET['page'] ) {
			return;
		}
		// phpcs:enable

		self::$current_tab = 'player';
		if ( isset( $_POST['waveplayer_nonce'] ) && wp_verify_nonce( $_POST['waveplayer_nonce'], 'waveplayer-settings' ) ) { //phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
			if ( isset( $_POST['waveplayer_current_tab'] ) ) {
				self::$current_tab = $_POST['waveplayer_current_tab']; //phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
			}
		}
		if ( isset( $_GET['tab'] ) ) {
			self::$current_tab = $_GET['tab']; //phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		}
	}

	/**
	 * Return an array defining the tabs of the setting page
	 *
	 * @since  3.0.0
	 * @return array
	 */
	public static function get_tabs() {

		$tabs = array();
		include_once 'admin-page.inc.php';
		self::$admin_page_options = $waveplayer_admin_page_options;

		foreach ( self::$admin_page_options as $section => $option ) {
			if ( ! isset( $option['condition'] ) || $option['condition'] ) {
				add_settings_section(
					"waveplayer_$section",
					'',
					array( __CLASS__, 'output_section' ),
					"waveplayer_$section"
				);
				foreach ( $option['settings'] as $key => $setting ) {
					add_settings_field(
						"waveplayer_$key",
						$setting['label'],
						array( __CLASS__, 'output_field' ),
						"waveplayer_{$section}",
						"waveplayer_{$section}_settings",
						array(
							'section'   => $section,
							'label_for' => "waveplayer_$key",
							'key'       => $key,
							'setting'   => $setting,
						)
					);
				}
				$tabs[ $section ] = $option['label'];
			}
		}

		return $tabs;
	}

	/**
	 * Output the tabs of the setting page
	 *
	 * @since  3.0.0
	 */
	private static function print_tabs() {

		$tabs = self::get_tabs();

		ob_start();

		?>
		<div class="nav-tab-wrapper">
			<?php foreach ( $tabs as $tab => $title ) { ?>
				<a id="waveplayer-tab-<?php echo esc_attr( $tab ); ?>" href="#<?php echo esc_attr( $tab ); ?>" class="waveplayer_tab nav-tab
				<?php
				if ( self::$current_tab === $tab ) {
					echo 'nav-tab-active';
				}
				?>
				"><?php echo esc_html( $title ); ?></a>
			<?php } ?>
		</div>

		<?php
		echo ob_get_clean(); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Output the content of a tab of the setting page
	 *
	 * @since  3.0.0
	 * @param array $args The array with the section arguments.
	 */
	public static function output_section( $args ) {

		$options = waveplayer()->get_options();

		$tab_id = str_replace( 'waveplayer_', '', $args['id'] );
		$tab    = self::$admin_page_options[ $tab_id ];
		?>

		<div id="waveplayer-<?php echo esc_attr( $tab_id ); ?>" class="waveplayer-option-page <?php echo ( $tab_id !== self::$current_tab ? 'hidden' : '' ); ?>">
			<h3><?php echo esc_html( $tab['title'] ); ?></h3>
			<p>
				<?php echo esc_html( $tab['description'] ); ?>
			</p>
			<table class="form-table" role="presentation">
				<?php
				do_settings_fields( $args['id'], "{$args['id']}_settings" );
				?>
			</table>
			<?php submit_button(); ?>
		</div>
		<?php
	}

	/**
	 * Output the single field of each setting
	 *
	 * @since 3.0.8
	 * @param array $args The array passed to the setting field callback.
	 */
	public static function output_field( $args ) {
		$section     = str_replace( 'waveplayer_', '', $args['section'] );
		$tab         = self::$admin_page_options[ $section ];
		$key         = $args['key'];
		$field       = $args['setting'];
		$value       = waveplayer()->get_option( $key );
		$id          = $args['label_for'];
		$description = isset( $field['description'] ) ? $field['description'] : '';

		switch ( $field['type'] ) {
			case 'select':
				?>
					<select id="<?php echo esc_attr( $args['label_for'] ); ?>" name="<?php echo esc_attr( $args['label_for'] ); ?>">
						<?php
						if ( isset( $field['options'] ) ) {
							foreach ( $field['options'] as $f_key => $option ) {
								?>
									<option name="waveplayer_<?php echo esc_attr( "{$key}_{$f_key}" ); ?>" value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $value, $option['value'] ); ?>><?php echo esc_html( $option['label'] ); ?></option>
								<?php
							}
						} elseif ( $field['options_callback'] ) {
							echo call_user_func_array( $field['options_callback'], $field['callback_params'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						}
						?>
					</select>
					<span class="item-description"></span>
					<br>
					<?php if ( $description ) { ?>
						<span class="description"><?php echo $description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<?php } ?>
				<?php
				break;
			case 'input':
			case 'number':
				?>
					<input id="<?php echo esc_attr( $args['label_for'] ); ?>" type="<?php echo esc_attr( $field['type'] ); ?>" name="<?php echo esc_attr( $args['label_for'] ); ?>" value=<?php echo esc_attr( $value ); ?>>
					<?php if ( $description ) { ?>
						<span class="description"><?php echo $description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<?php } ?>
				<?php
				break;
			case 'checkbox':
				?>
					<input id="<?php echo esc_attr( $args['label_for'] ); ?>" type="checkbox" name="<?php echo esc_attr( $args['label_for'] ); ?>" value=<?php echo esc_attr( $field['value'] ); ?> <?php checked( $value, $field['value'] ); ?>>
					<?php if ( $description ) { ?>
						<span class="description"><?php echo $description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<?php } ?>
				<?php
				break;
			case 'textarea':
				?>
					<textarea id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $args['label_for'] ); ?>" rows="<?php echo esc_attr( $field['rows'] ); ?>" class="<?php echo esc_attr( $field['class'] ); ?>"><?php echo esc_html( $value ); ?></textarea>
					<?php if ( $description ) { ?>
						<span class="description"><?php echo $description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<?php } ?>
				<?php
				break;
			case 'picture':
				?>
					<div id="<?php echo esc_attr( $args['label_for'] ); ?>" class="wvpl-thumbnail-preview <?php echo strpos( $value, 'assets/img/waveplayer.jpg' ) >= 0 ? 'empty' : ''; ?>" style="background-image:url('<?php echo esc_attr( $value ); ?>');">
						<div class="waveplayer-thumbnail-overlay">
							<div class="waveplayer-thumbnail-remove"></div>
						</div>
					</div>
					<input type="hidden" name="<?php echo esc_attr( $args['label_for'] ); ?>" value="<?php echo esc_attr( $value ); ?>" />
					<?php if ( $description ) { ?>
						<span class="description"><?php echo $description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<?php } ?>
				<?php
				break;
			case 'html':
				echo call_user_func_array( $field['render_callback'], $field['callback_params'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				if ( $description ) {
					?>
					<span class="description"><?php echo $description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<?php
				}
				break;
			default:
				?>
					<input id="<?php echo esc_attr( $args['label_for'] ); ?>" type="<?php echo esc_attr( $field['type'] ); ?>" name="<?php echo esc_attr( $args['label_for'] ); ?>" value=<?php echo esc_attr( $value ); ?> />
					<?php if ( $description ) { ?>
						<span class="description"><?php echo $description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<?php } ?>
				<?php
				break;
		}
	}

	/**
	 * Return the HTML markup of a list of options with the 100 more popular Google Fonts
	 *
	 * @since 3.0.0
	 * @return string
	 */
	public static function get_google_fonts_options() {
		$options = waveplayer()->get_options();

		$google_font_list = array( 'Roboto', 'Open Sans', 'Lato', 'Montserrat', 'Source Sans Pro', 'Roboto Condensed', 'Oswald', 'Roboto Mono', 'Raleway', 'Poppins', 'Noto Sans', 'Roboto Slab', 'Merriweather', 'PT Sans', 'Ubuntu', 'Playfair Display', 'Muli', 'Open Sans Condensed', 'PT Serif', 'Lora', 'Slabo 27px', 'Nunito', 'Noto Sans JP', 'Work Sans', 'Rubik', 'Noto Serif', 'Fira Sans', 'Titillium Web', 'Quicksand', 'Noto Sans KR', 'Nanum Gothic', 'Mukta', 'Noto Sans TC', 'Nunito Sans', 'Heebo', 'PT Sans Narrow', 'Arimo', 'Inconsolata', 'Barlow', 'Oxygen', 'Dosis', 'Bitter', 'Libre Baskerville', 'Crimson Text', 'Libre Franklin', 'Karla', 'Josefin Sans', 'Cabin', 'Anton', 'Source Code Pro', 'Hind', 'Abel', 'Amiri', 'Fjalla One', 'Lobster', 'Pacifico', 'Indie Flower', 'Exo 2', 'Dancing Script', 'Source Serif Pro', 'Arvo', 'Hind Siliguri', 'Varela Round', 'Merriweather Sans', 'Cairo', 'Yanone Kaffeesatz', 'Overpass', 'Shadows Into Light', 'Barlow Condensed', 'IBM Plex Sans', 'Comfortaa', 'Asap', 'Prompt', 'Kanit', 'Questrial', 'Martel', 'Archivo Narrow', 'Abril Fatface', 'Amatic SC', 'Acme', 'Catamaran', 'Fira Sans Condensed', 'EB Garamond', 'Bree Serif', 'Zilla Slab', 'Noto Sans SC', 'Cormorant Garamond', 'Hind Madurai', 'Teko', 'Righteous', 'Signika', 'Play', 'Domine', 'Exo', 'Russo One', 'Cinzel', 'PT Sans Caption', 'Rajdhani', 'Maven Pro', 'Fredoka One' );

		?>
		<option name="<?php echo 'waveplayer_font_default'; ?>" value="default" <?php selected( $options['default_font'], 'default' ); ?>>Default</option>
		<?php

		foreach ( $google_font_list as $font ) {
			$font_slug = strtolower( str_replace( ' ', '_', $font ) );
			?>
			<option name="<?php echo esc_attr( "waveplayer_font_$font_slug" ); ?>" value="<?php echo esc_attr( $font ); ?>" <?php selected( $options['default_font'], $font ); ?>><?php echo esc_html( $font ); ?></option>
			<?php
		}

		return ob_get_clean();
	}


	/**
	 * Update the WavePlayer options in the database when the Save settings button is clicked
	 *
	 * @since 3.0.0
	 */
	public static function update_options() {

		// phpcs:disable WordPress.Security.NonceVerification.Recommended
		if ( ! isset( $_GET['page'] ) || 'waveplayer' !== $_GET['page'] ) {
			return;
		}
		// phpcs:enable

		if ( isset( $_POST['submit'] ) && isset( $_POST['waveplayer_nonce'] ) && wp_verify_nonce( $_POST['waveplayer_nonce'], 'waveplayer-settings' ) ) { //phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
			$options     = waveplayer()->get_options();
			$option_keys = array_diff(
				array_keys( $options ),
				array( 'version', 'purchase_code' )
			);

			foreach ( $option_keys as $key ) {
				$option_value = '';
				$option_key   = "waveplayer_$key";
				if ( isset( $_POST[ $option_key ] ) ) {
					$option_value = stripslashes( $_POST[ $option_key ] );//phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
				}

				$options[ $key ] = $option_value;
			}
			$options['version'] = waveplayer()->get_version();
			if ( isset( $_POST['waveplayer_attachment_custom_fields'] ) ) {
				$acf                                 = array_map(
					function( $cf ) {
						if ( isset( $cf['options'] ) && $cf['options'] ) {
							$cf['options'] = explode( ',', $cf['options'] );
						}

						return $cf;
					},
					$_POST['waveplayer_attachment_custom_fields'] //phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
				);
				$options['attachment_custom_fields'] = $acf;
			} else {
				unset( $options['attachment_custom_fields'] );
				delete_site_option( 'waveplayer_attachment_custom_fields' );
			}
			waveplayer()->update_options( $options );
		}
	}

	/**
	 * Output the registration notice
	 *
	 * @since 3.0.0
	 */
	public static function registration_notice() {
		?>
		<div class="notice notice-warning notice-waveplayer-registration is-dismissible">
			<p>
				<?php esc_html_e( 'Register your WavePlayer purchase code to take advantage of automatic updates. ', 'waveplayer' ); ?>
				<a href="<?php echo esc_url( self::settings_page_url( array( 'tab' => 'tools' ) ) ); ?>"><?php esc_html_e( 'Click here', 'waveplayer' ); ?></a>
			</p>
		</div>
		<?php
	}

	/**
	 * Output the main settings page
	 *
	 * @since 3.0.0
	 */
	public static function admin_page() {

		// phpcs:disable WordPress.Security.NonceVerification.Recommended
		if ( ! isset( $_GET['page'] ) || 'waveplayer' !== $_GET['page'] ) {
			return;
		}
		// phpcs:enable

		global $current_user;
		global $wp_roles;
		global $wp_filesystem;

		$options = waveplayer()->get_options();

		settings_errors();
		?>

		<h1><?php echo esc_html( get_admin_page_title() ); ?><span class="setting-version"><?php echo esc_html( waveplayer()->get_version() ); ?></span></h1>

		<div class="wrap">

			<?php $tabs = self::print_tabs(); ?>

			<?php $current_tab = self::$current_tab; ?>

			<form id="waveplayer_form" name="waveplayer_form" method="post" action="">
				<input type="hidden" name="waveplayer_current_tab" id="waveplayer_current_tab" value="<?php echo esc_attr( self::$current_tab ); ?>">
				<input type="hidden" name="waveplayer_nonce" id="waveplayer_nonce" value="<?php echo esc_attr( wp_create_nonce( 'waveplayer-settings' ) ); ?>">
				<?php settings_fields( 'waveplayer' ); ?>

				<div id="color-picker-container">
					<input id="color-picker-value" class="waveplayer-color-input" />
					<div id="color-picker"></div>
				</div>

				<!-- PLAYER OPTIONS TAB -->
				<?php do_settings_sections( 'waveplayer_player' ); ?>

				<!-- VISUAL ASPECT TAB -->
				<?php do_settings_sections( 'waveplayer_style' ); ?>

				<!-- PALETTES TAB -->
				<div id="waveplayer-palettes" class="waveplayer-option-page <?php echo ( 'palettes' !== self::$current_tab ? 'hidden' : '' ); ?>">
					<h3><?php esc_html_e( 'Player Palettes', 'waveplayer' ); ?></h3>
					<p>
						<?php esc_html_e( 'Here you can change the basic colors applying to every skin, such as text, border or background colors. You can also create your own palette to easily switch between different configurations.', 'waveplayer' ); ?>
					</p>
					<table class="form-table">
						<tbody>
							<tr valign="top" data-option="default-palette">
								<th scope="row">
									<label><?php esc_html_e( 'Default Palette', 'waveplayer' ); ?></label>
								</th>
								<td>
									<?php echo Renderer::print_palette_selectbox(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</td>
							</tr>
							<tr valign="top" data-option="override_wave_colors">
								<th scope="row">
									<label for="waveplayer_override_wave_colors"><?php esc_html_e( 'Override wave colors', 'waveplayer' ); ?></label>
								</th>
								<td>
									<input type="checkbox" name="waveplayer_override_wave_colors" value="1" <?php checked( $options['override_wave_colors'], 1 ); ?> />
									<span class="description"><?php esc_html_e( 'Use the colors from the palette instead of the default wave colors', 'waveplayer' ); ?></span>
								</td>
							</tr>
							<tr valign="top" data-option="palette">
								<th scope="row">
									<label><?php esc_html_e( '1-Click Palette Generator', 'waveplayer' ); ?></label>
								</th>
								<td>
									<div id="palette" class="wvpl-palette-<?php echo esc_attr( md5( $options['default_palette'] ) ); ?>">
										<div class="color-swatch palette-swatch palette-swatch-main linked" data-var="fc" title="Text color in Light Mode, Background color in Dark Mode"></div>
										<div class="color-swatch palette-swatch palette-swatch-shade" data-var="fc-s" title="Text color shade in Light Mode, Background color in Dark Mode"></div>
										<div class="color-swatch palette-swatch palette-swatch-main linked" data-var="bc" title="Background color in Light Mode, Text color in Dark Mode"></div>
										<div class="color-swatch palette-swatch palette-swatch-shade" data-var="bc-s" title="Background color shade in Light Mode, Text color shade in Dark Mode"></div>
										<div class="color-swatch palette-swatch palette-swatch-main linked" data-var="hc" title="Highlight/Wave color"></div>
										<div class="color-swatch palette-swatch palette-swatch-shade" data-var="hc-s" title="Highlight/Wave color shade"></div>
										<div class="color-swatch palette-swatch palette-swatch-main linked" data-var="wc" title="Wave color"></div>
										<div class="color-swatch palette-swatch palette-swatch-shade" data-var="wc-s" title="Wave color shade"></div>
										<div class="color-swatch palette-swatch palette-swatch-main linked" data-var="pc" title="Progress color"></div>
										<div class="color-swatch palette-swatch palette-swatch-shade" data-var="pc-s" title="Progress color shade"></div>
										<div class="color-swatch palette-swatch palette-swatch-main linked" data-var="cc" title="Cursor color"></div>
										<div class="color-swatch palette-swatch palette-swatch-shade" data-var="cc-s" title="Cursor color shade"></div>
									</div>
									<p>
										<button id="waveplayer_random_palette" type="button" class="button button-default button-wvpl button-wvpl-magic-wand"><?php esc_html_e( 'Generate', 'waveplayer' ); ?></button>
										<button id="waveplayer_save_palette" type="button" class="button button-default button-wvpl button-wvpl-save" disabled><?php esc_html_e( 'Save', 'waveplayer' ); ?></button>
										<input name="waveplayer_palette_name" type="text" placeholder="type a name for this palette" />
									</p>
									<p>
										<label for="waveplayer_monochromatic_pairs">
											<input id="waveplayer_monochromatic_pairs" type="checkbox" name="waveplayer_monochromatic_pairs" checked/><?php esc_html_e( 'Force monochromatic color pairs', 'waveplayer' ); ?>
										</label>
									</p>
									<p>
										<label for="waveplayer_monochromatic_palette" class="label-indent-1">
											<input id="waveplayer_monochromatic_palette" type="checkbox" name="waveplayer_monochromatic_palette" /><?php esc_html_e( 'Force a full monochromatic palette', 'waveplayer' ); ?>
										</label>
									</p>
									<p>
										<label for="waveplayer_player_background_image">
											<input id="waveplayer_player_background_image" type="checkbox" name="waveplayer_player_background_image"/><?php esc_html_e( 'Exhibition Mode: the thumbnail of the current track is blurred out and used as the background of the player', 'waveplayer' ); ?>
										</label>
									</p>
								</td>
							</tr>
							<tr valign="top" data-option="examples">
								<th scope="row">
									<label><?php esc_html_e( 'Examples', 'waveplayer' ); ?></label>
								</th>
								<td>
									<div id="player_examples">
										<div class="light-mode">
											<h4><?php esc_html_e( 'Light Mode', 'waveplayer' ); ?></h4>
											<?php
 												// phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode
												$tracks = base64_encode(
													wp_json_encode(
														array(
															array(
																'title'     => 'Wedding',
																'artist'    => 'AudioPizza',
																'poster'    => 'https://0.s3.envato.com/files/68862403/ava1.jpg',
																'poster_thumbnail'  => 'https://0.s3.envato.com/files/68862403/ava1.jpg',
																'file'      => 'https://dl.dropboxusercontent.com/s/o5jewqhxiernyrf/119878550.mp3?raw=1',
																'peak_file' => wp_normalize_path( plugin_dir_url( __DIR__ ) . 'assets/peaks/119878550.peaks' ),
															),
															array(
																'title'     => 'Give Your Dreams The Wings To Fly',
																'artist'    => 'TimMcMorris',
																'poster'    => 'https://0.s3.envato.com/files/226070327/Tim%20McMorris.jpg',
																'poster_thumbnail'  => 'https://0.s3.envato.com/files/226070327/Tim%20McMorris.jpg',
																'file'      => 'https://dl.dropboxusercontent.com/s/pe8u7i3si83cqc5/194772420.mp3?raw=1',
																'peak_file' => wp_normalize_path( plugin_dir_url( __DIR__ ) . 'assets/peaks/194772420.peaks' ),
															),
															array(
																'title'     => 'Inspiring Uplifting Emotional Piano',
																'artist'    => 'RedLionProduction',
																'poster'    => 'https://s3.envato.com/files/249256898/80x80%20Red.png',
																'poster_thumbnail'  => 'https://s3.envato.com/files/249256898/80x80%20Red.png',
																'file'      => 'https://dl.dropboxusercontent.com/s/y4mcamwmh3ict0w/145229456.mp3?raw=1',
																'peak_file' => wp_normalize_path( plugin_dir_url( __DIR__ ) . 'assets/peaks/145229456.peaks' ),
															),
														)
													)
												);
												echo do_shortcode( "[waveplayer tracks='$tracks' style='light' autoplay='0']" );
											?>
										</div>
										<div class="dark-mode">
											<h4><?php esc_html_e( 'Dark Mode', 'waveplayer' ); ?></h4>
											<?php
												echo do_shortcode( "[waveplayer tracks='$tracks' style='dark' autoplay='0']" );
											?>
										</div>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
					<?php submit_button(); ?>
				</div>

				<!-- WAVEFORM OPTIONS TAB -->
				<div id="waveplayer-waveform" class="waveplayer-option-page <?php echo ( 'waveform' !== self::$current_tab ? 'hidden' : '' ); ?>">
					<h3><?php esc_html_e( 'Waveform Options and Palette', 'waveplayer' ); ?></h3>
					<p>
						<?php esc_html_e( 'If one of the following parameters is not specified in a shortcode, these are going to be the default settings for the player.', 'waveplayer' ); ?>
					</p>
					<table class="form-table">
						<tbody>
							<tr valign="top">
								<th scope="row">
									<label><?php esc_html_e( 'Waveform preview', 'waveplayer' ); ?></label>
								</th>
								<td>
									<?php
										$sample = plugin_dir_url( __DIR__ ) . 'assets/peaks/sample.mp3';
 										// phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode
										$tracks = base64_encode(
											wp_json_encode(
												array(
													array(
														'id'        => 'sample',
														'title'     => 'Sample',
														'artist'    => 'Luigi Pulcini',
														'file'      => $sample,
														'peak_file' => wp_normalize_path( plugin_dir_url( __DIR__ ) . 'assets/peaks/sample.peaks' ),
													),
												)
											)
										);
										echo do_shortcode( "[waveplayer skin='play_n_wave' tracks='$tracks' override_wave_colors='0' style='light' autoplay='0']" );
									?>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="waveplayer_wave_color"><?php esc_html_e( 'Waveform options', 'waveplayer' ); ?></label>
								</th>
								<td>
									<div class="waveplayer-colors-container">
										<div>
											<h5><?php esc_html_e( 'WAVE', 'waveplayer' ); ?></h5>
											<div class="color-tuplet">
												<div class="color-group">
													<div class="color-swatch" data-name="waveplayer_wave_color" style="background-color:<?php echo esc_attr( $options['wave_color'] ); ?>;"></div>
													<input type="hidden" id="waveplayer_wave_color" name="waveplayer_wave_color" class="waveplayer-color-input" value="<?php echo esc_attr( $options['wave_color'] ); ?>">
												</div>
												<div class="color-group">
													<div class="color-swatch" data-name="waveplayer_wave_color_2" style="background-color:<?php echo esc_attr( $options['wave_color_2'] ); ?>;"></div>
													<input type="hidden" id="waveplayer_wave_color_2" name="waveplayer_wave_color_2" class="waveplayer-color-input" value="<?php echo esc_attr( $options['wave_color_2'] ); ?>">
												</div>
											</div>
											<h6><?php esc_html_e( 'bar and gap size', 'waveplayer' ); ?></h6>
												<?php esc_html_e( 'bar', 'waveplayer' ); ?> <input type="range" name="waveplayer_wave_mode" min=1 max=10 value=<?php echo esc_attr( isset( $options['wave_mode'] ) ? $options['wave_mode'] : 1 ); ?>><br>
												<?php esc_html_e( 'gap', 'waveplayer' ); ?> <input type="range" name="waveplayer_gap_width" min=0 max=10 value=<?php echo esc_attr( isset( $options['gap_width'] ) ? $options['gap_width'] : 0 ); ?>>
										</div>
										<div>
											<h5><?php esc_html_e( 'PROGRESS', 'waveplayer' ); ?></h5>
											<div class="color-tuplet">
												<div class="color-group">
													<div class="color-swatch" data-name="waveplayer_progress_color" style="background-color:<?php echo esc_attr( $options['progress_color'] ); ?>;"></div>
													<input type="hidden" id="waveplayer_progress_color" name="waveplayer_progress_color" class="waveplayer-color-input" value="<?php echo esc_attr( $options['progress_color'] ); ?>">
												</div>
												<div class="color-group">
													<div class="color-swatch" data-name="waveplayer_progress_color_2" style="background-color:<?php echo esc_attr( $options['progress_color_2'] ); ?>;"></div>
													<input type="hidden" id="waveplayer_progress_color_2" name="waveplayer_progress_color_2" class="waveplayer-color-input" value="<?php echo esc_attr( $options['progress_color_2'] ); ?>">
												</div>
											</div>
											<h6><?php esc_html_e( 'mouse hovering opacity', 'waveplayer' ); ?></h6>
											<select name="waveplayer_hover_opacity">
												<option name="waveplayer_wave_hover_opacity_100" value="100" <?php selected( $options['hover_opacity'], '100' ); ?>>100%</option>
												<option name="waveplayer_wave_hover_opacity_90" value="90" <?php selected( $options['hover_opacity'], '90' ); ?>>90%</option>
												<option name="waveplayer_wave_hover_opacity_80" value="80" <?php selected( $options['hover_opacity'], '80' ); ?>>80%</option>
												<option name="waveplayer_wave_hover_opacity_70" value="70" <?php selected( $options['hover_opacity'], '70' ); ?>>70%</option>
												<option name="waveplayer_wave_hover_opacity_60" value="60" <?php selected( $options['hover_opacity'], '60' ); ?>>60%</option>
												<option name="waveplayer_wave_hover_opacity_50" value="50" <?php selected( $options['hover_opacity'], '50' ); ?>>50%</option>
												<option name="waveplayer_wave_hover_opacity_40" value="40" <?php selected( $options['hover_opacity'], '40' ); ?>>40%</option>
												<option name="waveplayer_wave_hover_opacity_30" value="30" <?php selected( $options['hover_opacity'], '30' ); ?>>30%</option>
												<option name="waveplayer_wave_hover_opacity_20" value="20" <?php selected( $options['hover_opacity'], '20' ); ?>>20%</option>
												<option name="waveplayer_wave_hover_opacity_10" value="10" <?php selected( $options['hover_opacity'], '10' ); ?>>10%</option>
												<option name="waveplayer_wave_hover_opacity_0" value="0" <?php selected( $options['hover_opacity'], '0' ); ?>>0%</option>
											</select>
										</div>
										<div>
											<h5><?php esc_html_e( 'CURSOR', 'waveplayer' ); ?></h5>
											<div class="color-tuplet">
												<div class="color-group">
													<div class="color-swatch" data-name="waveplayer_cursor_color" style="background-color:<?php echo esc_attr( $options['cursor_color'] ); ?>;"></div>
													<input type="hidden" id="waveplayer_cursor_color" name="waveplayer_cursor_color" class="waveplayer-color-input" value="<?php echo esc_attr( $options['cursor_color'] ); ?>">
												</div>
												<div class="color-group">
													<div class="color-swatch" data-name="waveplayer_cursor_color_2" style="background-color:<?php echo esc_attr( $options['cursor_color_2'] ); ?>;"></div>
													<input type="hidden" id="waveplayer_cursor_color_2" name="waveplayer_cursor_color_2" class="waveplayer-color-input" value="<?php echo esc_attr( $options['cursor_color_2'] ); ?>">
												</div>
											</div>
											<h6><?php esc_html_e( 'Cursor Width', 'waveplayer' ); ?></h6>
											<select name="waveplayer_cursor_width">
												<option name="waveplayer_wave_cursor_width_0" value="0" <?php selected( $options['cursor_width'], '0' ); ?>><?php esc_html_e( 'No cursor', 'waveplayer' ); ?></option>
												<option name="waveplayer_wave_cursor_width_1" value="1" <?php selected( $options['cursor_width'], '1' ); ?>><?php esc_html_e( 'Thin (1px)', 'waveplayer' ); ?></option>
												<option name="waveplayer_wave_cursor_width_2" value="2" <?php selected( $options['cursor_width'], '2' ); ?>><?php esc_html_e( 'Normal (2px)', 'waveplayer' ); ?></option>
												<option name="waveplayer_wave_cursor_width_4" value="4" <?php selected( $options['cursor_width'], '4' ); ?>><?php esc_html_e( 'Thick (4px)', 'waveplayer' ); ?></option>
											</select>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="waveplayer_wave_color"><?php esc_html_e( 'Animation options', 'waveplayer' ); ?></label>
								</th>
								<td>
									<div class="waveplayer-colors-container">
										<div class="waveplayer-animation-options">
											<h6>&nbsp;</h6>
											<select name="waveplayer_wave_animation">
												<option name="waveplayer_wave_animation_static" value="1" <?php selected( $options['wave_animation'], '1' ); ?>><?php esc_html_e( 'No animation', 'waveplayer' ); ?></option>
												<option name="waveplayer_wave_animation_soft" value="0.85" <?php selected( $options['wave_animation'], '0.85' ); ?>><?php esc_html_e( 'Slow', 'waveplayer' ); ?></option>
												<option name="waveplayer_wave_animation_smooth" value="0.7" <?php selected( $options['wave_animation'], '0.7' ); ?>><?php esc_html_e( 'Smooth', 'waveplayer' ); ?></option>
												<option name="waveplayer_wave_animation_normal" value="0.55" <?php selected( $options['wave_animation'], '0.55' ); ?>><?php esc_html_e( 'Normal', 'waveplayer' ); ?></option>
												<option name="waveplayer_wave_animation_exciting" value="0.4" <?php selected( $options['wave_animation'], '0.4' ); ?>><?php esc_html_e( 'Fast', 'waveplayer' ); ?></option>
												<option name="waveplayer_wave_animation_hectic" value="0.25" <?php selected( $options['wave_animation'], '0.25' ); ?>><?php esc_html_e( 'Hectic', 'waveplayer' ); ?></option>
											</select>
											<span id="waveplayer_amp_freq_ratio_group" class="<?php echo esc_attr( '1' === $options['wave_animation'] ? 'wvpl-inactive' : '' ); ?>">
												<span class="wvpl-hspacer"><?php esc_html_e( 'animation with', 'waveplayer' ); ?></span>
												<select name="waveplayer_amp_freq_ratio">
													<option name="waveplayer_amp_freq_ratio_mostamp" value="4" <?php selected( $options['amp_freq_ratio'], '4' ); ?>><?php esc_html_e( 'mostly amplitude', 'waveplayer' ); ?></option>
													<option name="waveplayer_amp_freq_ratio_moreamp" value="2" <?php selected( $options['amp_freq_ratio'], '2' ); ?>><?php esc_html_e( 'more amplitude', 'waveplayer' ); ?></option>
													<option name="waveplayer_amp_freq_ratio_balanced" value="1" <?php selected( $options['amp_freq_ratio'], '1' ); ?>><?php esc_html_e( 'amplitude and frequency equally', 'waveplayer' ); ?></option>
													<option name="waveplayer_amp_freq_ratio_morefreq" value="0.5" <?php selected( $options['amp_freq_ratio'], '0.5' ); ?>><?php esc_html_e( 'more frequency', 'waveplayer' ); ?></option>
													<option name="waveplayer_amp_freq_ratio_mostfreq" value="0.25" <?php selected( $options['amp_freq_ratio'], '0.25' ); ?>><?php esc_html_e( 'mostly frequency', 'waveplayer' ); ?></option>
													<option name="waveplayer_amp_freq_ratio_freqonly" value="0.000061" <?php selected( $options['amp_freq_ratio'], '0.000061' ); ?>><?php esc_html_e( 'only frequency', 'waveplayer' ); ?></option>
												</select>
												<span class="wvpl-hspacer"><?php esc_html_e( ' affecting the waveform', 'waveplayer' ); ?></span>
											</span>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="waveplayer_wave_color"><?php esc_html_e( 'Geometry options', 'waveplayer' ); ?></label>
								</th>
								<td>
									<div class="waveplayer-colors-container">
										<div>
											<h6><?php esc_html_e( 'visual compression', 'waveplayer' ); ?></h6>
											<select name="waveplayer_wave_compression">
												<option name="waveplayer_wave_compression_linear" value="1" <?php selected( $options['wave_compression'], '1' ); ?>><?php esc_html_e( 'None (linear)', 'waveplayer' ); ?></option>
												<option name="waveplayer_wave_compression_square" value="2" <?php selected( $options['wave_compression'], '2' ); ?>><?php esc_html_e( 'Moderate (square)', 'waveplayer' ); ?></option>
												<option name="waveplayer_wave_compression_cubic" value="3" <?php selected( $options['wave_compression'], '3' ); ?>><?php esc_html_e( 'High (cubic)', 'waveplayer' ); ?></option>
												<option name="waveplayer_wave_compression_4th" value="4" <?php selected( $options['wave_compression'], '4' ); ?>><?php esc_html_e( 'Very high (4th order)', 'waveplayer' ); ?></option>
												<option name="waveplayer_wave_compression_5th" value="5" <?php selected( $options['wave_compression'], '5' ); ?>><?php esc_html_e( 'Extreme (5th order)', 'waveplayer' ); ?></option>
											</select>
										</div>
										<div>
											<h6><?php esc_html_e( 'visual normalization', 'waveplayer' ); ?></h6>
											<select name="waveplayer_wave_normalization">
												<option name="waveplayer_wave_normalization_as_is" value="0" <?php selected( $options['wave_normalization'], '0' ); ?>>as is</option>
												<option name="waveplayer_wave_normalization_normalized" value="1" <?php selected( $options['wave_normalization'], '1' ); ?>>normalized</option>
											</select>
										</div>
										<div>
											<h6><?php esc_html_e( 'asymmetry', 'waveplayer' ); ?></h6>
											<select name="waveplayer_wave_asymmetry">
												<option name="waveplayer_wave_asymmetry_1" value="1" <?php selected( $options['wave_asymmetry'], '1' ); ?>>1/2 + 1/2</option>
												<option name="waveplayer_wave_asymmetry_2" value="2" <?php selected( $options['wave_asymmetry'], '2' ); ?>>2/3 + 1/3</option>
												<option name="waveplayer_wave_asymmetry_3" value="3" <?php selected( $options['wave_asymmetry'], '3' ); ?>>3/4 + 1/4</option>
												<option name="waveplayer_wave_asymmetry_4" value="4" <?php selected( $options['wave_asymmetry'], '4' ); ?>>4/5 + 1/5</option>
												<option name="waveplayer_wave_asymmetry_top" value="99999" <?php selected( $options['wave_asymmetry'], '99999' ); ?>><?php esc_html_e( 'top only', 'waveplayer' ); ?></option>
												<option name="waveplayer_wave_asymmetry_bottom" value="0.00001" <?php selected( $options['wave_asymmetry'], '0.00001' ); ?>><?php esc_html_e( 'bottom only', 'waveplayer' ); ?></option>
											</select>
										</div>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
					<?php submit_button(); ?>
				</div>


				<!-- PLACEHOLDERS TAB -->
				<div id="waveplayer-placeholders" class="waveplayer-option-page <?php echo ( 'placeholders' !== self::$current_tab ? 'hidden' : '' ); ?>">
					<h3><?php esc_html_e( 'Placeholders', 'waveplayer' ); ?></h3>
					<p>
						<?php esc_html_e( 'Use the text areas below to customize the content of the information shown in the main player info bar, each row of the playlist and the sticky player.', 'waveplayer' ); ?>
					</p>
					<p>
						<?php
							echo wp_kses(
								__(
									'You can use HTML syntax. As a placeholder for a specific metadata, you can use any ID3 tag present in the audio file, delimited by the <code>%</code> character. Please bear in mind that the presence of every tag is not guaranteed for every single track you upload.',
									'waveplayer'
								),
								self::$allowed_html_tags
							);
						?>
					</p>
					<p>
						<?php esc_html_e( 'Here is a list of the most common ID3 tags and metadata you can use:', 'waveplayer' ); ?>
						<code>%album%</code>, <code>%artist%</code>, <code>%bitrate%</code>, <code>%bitrate_mode%</code>, <code>%channelmode%</code>, <code>%channels%</code>,
						<code>%compression_ratio%</code>, <code>%dataformat%</code>, <code>%encoder_options%</code>, <code>%file%</code>, <code>%fileformat%</code>,
						<code>%filesize%</code>, <code>%genre%</code>, <code>%length%</code>, <code>%length_formatted%</code>, <code>%lossless%</code>,
						<code>%mime_type%</code>, <code>%sample_rate%</code>, <code>%title%</code>, <code>%year%</code>.
					</p>
					<p>
						<?php esc_html_e( 'In addition to the previous tags, you can use other special placeholders created by WavePlayer:', 'waveplayer' ); ?><br>
						<code>%likes%</code>: <?php esc_html_e( 'a like button and a counter of the total likes for a given track,', 'waveplayer' ); ?><br>
						<code>%downloads%</code>: <?php esc_html_e( 'a download button and a counter of the total downloads for a given track,', 'waveplayer' ); ?><br>
						<code>%cart%</code>: <?php esc_html_e( 'a cart button (an active WooCommerce installation is required),', 'waveplayer' ); ?><br>
						<code>%play_count%</code>: <?php esc_html_e( 'a counter of the total playbacks for a given track,', 'waveplayer' ); ?><br>
						<code>%runtime%</code>: <?php esc_html_e( 'a counter of the total time a given track has been listened to,', 'waveplayer' ); ?><br>
						<code>%share%</code>: <?php esc_html_e( 'a share button to select the social network where you want to share the track,', 'waveplayer' ); ?><br>
						<code>%genres%</code>: <?php esc_html_e( 'a list of terms of the Music Genre category associated with the track', 'waveplayer' ); ?><br>
					</p>
					<table class="form-table">
						<tbody>
							<tr valign="top">
								<th scope="row">
									<label for="waveplayer_template"><?php esc_html_e( 'Info bar template', 'waveplayer' ); ?></label>
								</th>
								<td>
									<textarea name="waveplayer_template" size="120" rows="3"><?php echo esc_textarea( $options['template'] ); ?></textarea>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="waveplayer_playlist_template"><?php esc_html_e( 'Playlist row template', 'waveplayer' ); ?></label>
								</th>
								<td>
									<textarea name="waveplayer_playlist_template" size="120" rows="3"><?php echo esc_textarea( $options['playlist_template'] ); ?></textarea>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="waveplayer_sticky_template"><?php esc_html_e( 'Sticky Player template', 'waveplayer' ); ?></label>
								</th>
								<td>
									<textarea name="waveplayer_sticky_template" size="120" rows="3"><?php echo esc_textarea( $options['sticky_template'] ); ?></textarea>
								</td>
							</tr>
						</tbody>
					</table>

					<?php submit_button(); ?>

					<h4><?php esc_html_e( 'Audio Attachment custom fields', 'waveplayer' ); ?></h4>
					<p>
						<?php echo wp_kses( __( 'The audio attachment custom fields you add here will be available in the attachment editor and in the attachment modal dialog. Once you entered a custom field value for an attachment, you can display it as a placeholder using its name. For example, if you create a custom field called <code>my_custom_field</code>, you can use it in the player simply typing <code>%my_custom_field%</code> in any of the templates above.', 'waveplayer' ), self::$allowed_html_tags ); ?>
					</p>
					<p>
						<?php echo wp_kses( __( 'You can also customize the metadata attached to each track using the <code>waveplayer_add_track_info</code> filter. <a href="https://www.waveplayer.info/info-bar-playlist" target="_blank"><strong>More info</strong></a> are available on the Official WavePlayer website.', 'waveplayer' ), self::$allowed_html_tags ); ?>
					</p>
					<?php
						self::print_custom_fields_admin();
					?>
					<?php submit_button(); ?>
				</div>


				<!-- ADVANCED TAB -->
				<?php do_settings_sections( 'waveplayer_advanced' ); ?>

				<?php
				if ( defined( 'WC_VERSION' ) ) {

					$result              = WooCommerce::music_inputs();
					$track_inputs        = $result['track_inputs'];
					$paginate_links      = $result['paginate_links'];
					$found_tracks        = $result['found_tracks'];
					$player_default_size = $options['size'];

					?>

					<!-- WOOCOMMERCE OPTIONS TAB -->
					<div id="waveplayer-woocommerce" class="waveplayer-option-page <?php echo ( 'woocommerce' !== self::$current_tab ? 'hidden' : '' ); ?>">
						<h3><?php esc_html_e( 'WooCommerce Options', 'waveplayer' ); ?></h3>
						<p><?php esc_html_e( 'WavePlayer can add a player for each item in the Shop and Single Product pages automatically, using the preview files attached to each product.', 'waveplayer' ); ?></p>
						<table class="form-table">
							<tbody>
								<tr valign="top">
									<th scope="row">
										<label for="waveplayer_woocommerce_replace_product_image"><?php esc_html_e( 'Product thumbnail', 'waveplayer' ); ?></label>
									</th>
									<td>
										<p><input type="checkbox" name="waveplayer_woocommerce_replace_product_image" value=1 <?php isset( $options['woocommerce_replace_product_image'] ) ? checked( $options['woocommerce_replace_product_image'], true ) : ''; ?>/> <?php esc_html_e( 'Use the featured image of the audio track as the product image', 'waveplayer' ); ?></p>
									</td>
								</tr>
							</tbody>
						</table>
						<h4><?php esc_html_e( 'Shop Page Options', 'waveplayer' ); ?></h4>
						<table class="form-table">
							<tbody>
								<tr valign="top">
									<th scope="row">
										<label for="waveplayer_woocommerce_shop_player"><?php esc_html_e( 'Position', 'waveplayer' ); ?></label>
									</th>
									<td>
										<select name="waveplayer_woocommerce_shop_player">
											<option name="waveplayer_woocommerce_shop_player_none" value="none" <?php selected( $options['woocommerce_shop_player'], 'none' ); ?>><?php esc_html_e( 'Disable', 'waveplayer' ); ?></option>
											<option name="waveplayer_woocommerce_shop_player_before" value="before" <?php selected( $options['woocommerce_shop_player'], 'before' ); ?>><?php esc_html_e( 'Before the title', 'waveplayer' ); ?></option>
											<option name="waveplayer_woocommerce_shop_player_after" value="after" <?php selected( $options['woocommerce_shop_player'], 'after' ); ?>><?php esc_html_e( 'After the title', 'waveplayer' ); ?></option>
										</select>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="waveplayer_woocommerce_shop_player_skin"><?php esc_html_e( 'Skin', 'waveplayer' ); ?></label>
									</th>
									<td>
										<select name="waveplayer_woocommerce_shop_player_skin">
											<?php echo Renderer::get_skin_options( 'woocommerce_shop_player_skin' );  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
										</select>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="waveplayer_woocommerce_shop_player_size"><?php esc_html_e( 'Size', 'waveplayer' ); ?></label>
									</th>
									<td>
										<select name="waveplayer_woocommerce_shop_player_size">
											<option name="waveplayer_woocommerce_shop_player_size_default" value="default" <?php selected( $options['woocommerce_shop_player_size'], 'default' ); ?>><?php esc_html_e( 'Default', 'waveplayer' ); ?> (<?php echo esc_html( $player_default_size ); ?>)</option>
											<option name="waveplayer_woocommerce_shop_player_size_lg" value="lg" <?php selected( $options['woocommerce_shop_player_size'], 'lg' ); ?>><?php esc_html_e( 'Large', 'waveplayer' ); ?></option>
											<option name="waveplayer_woocommerce_shop_player_size_md" value="md" <?php selected( $options['woocommerce_shop_player_size'], 'md' ); ?>><?php esc_html_e( 'Medium', 'waveplayer' ); ?></option>
											<option name="waveplayer_woocommerce_shop_player_size_sm" value="sm" <?php selected( $options['woocommerce_shop_player_size'], 'sm' ); ?>><?php esc_html_e( 'Small', 'waveplayer' ); ?></option>
											<option name="waveplayer_woocommerce_shop_player_size_xs" value="xs" <?php selected( $options['woocommerce_shop_player_size'], 'xs' ); ?>><?php esc_html_e( 'Extra Small', 'waveplayer' ); ?></option>
										</select>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="waveplayer_woocommerce_shop_player_info"><?php esc_html_e( 'Info', 'waveplayer' ); ?></label>
									</th>
									<td>
										<select name="waveplayer_woocommerce_shop_player_info">
											<option name="waveplayer_woocommerce_shop_player_info_none" value="none" <?php selected( $options['woocommerce_shop_player_info'], 'none' ); ?>><?php esc_html_e( 'nothing', 'waveplayer' ); ?></option>
											<option name="waveplayer_woocommerce_shop_player_info_bar" value="bar" <?php selected( $options['woocommerce_shop_player_info'], 'bar' ); ?>><?php esc_html_e( 'the info bar only', 'waveplayer' ); ?></option>
											<option name="waveplayer_woocommerce_shop_player_info_playlist" value="playlist" <?php selected( $options['woocommerce_shop_player_info'], 'playlist' ); ?>><?php esc_html_e( 'both the info bar and the playlist', 'waveplayer' ); ?></option>
										</select>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="waveplayer_woocommerce_remove_shop_image"><?php esc_html_e( 'Remove product thumbnail', 'waveplayer' ); ?></label>
									</th>
									<td>
										<p><input type="checkbox" name="waveplayer_woocommerce_remove_shop_image" value=1 <?php isset( $options['woocommerce_remove_shop_image'] ) ? checked( $options['woocommerce_remove_shop_image'], true ) : ''; ?>/><?php esc_html_e( 'Remove the product thumbnail from the shop page. This option is particularly useful in combination with the “Thumb’n’Wave” skin', 'waveplayer' ); ?></p>
									</td>
								</tr>
							</tbody>
						</table>
						<h4><?php esc_html_e( 'Single Product Page Options', 'waveplayer' ); ?></h4>
						<table class="form-table">
							<tbody>
								<tr valign="top">
									<th scope="row">
										<label for="waveplayer_woocommerce_product_player"><?php esc_html_e( 'Position', 'waveplayer' ); ?></label>
									</th>
									<td>
										<select name="waveplayer_woocommerce_product_player">
											<option name="waveplayer_woocommerce_product_player_none" value="none" <?php selected( $options['woocommerce_product_player'], 'none' ); ?>><?php esc_html_e( 'Disable', 'waveplayer' ); ?></option>
											<option name="waveplayer_woocommerce_product_player_before" value="before" <?php selected( $options['woocommerce_product_player'], 'before' ); ?>><?php esc_html_e( 'Before the title', 'waveplayer' ); ?></option>
											<option name="waveplayer_woocommerce_product_player_after" value="after" <?php selected( $options['woocommerce_product_player'], 'after' ); ?>><?php esc_html_e( 'After the title', 'waveplayer' ); ?></option>
											<option name="waveplayer_woocommerce_product_player_before_rating" value="before_rating" <?php selected( $options['woocommerce_product_player'], 'before_rating' ); ?>><?php esc_html_e( 'Before the rating', 'waveplayer' ); ?></option>
											<option name="waveplayer_woocommerce_product_player_after_price" value="after_price" <?php selected( $options['woocommerce_product_player'], 'after_price' ); ?>><?php esc_html_e( 'After the price', 'waveplayer' ); ?></option>
											<option name="waveplayer_woocommerce_product_player_before_excerpt" value="before_excerpt" <?php selected( $options['woocommerce_product_player'], 'before_excerpt' ); ?>><?php esc_html_e( 'Before the short description', 'waveplayer' ); ?></option>
											<option name="waveplayer_woocommerce_product_player_after_excerpt" value="after_excerpt" <?php selected( $options['woocommerce_product_player'], 'after_excerpt' ); ?>><?php esc_html_e( 'After the short description', 'waveplayer' ); ?></option>
											<option name="waveplayer_woocommerce_product_player_before_meta" value="before_meta" <?php selected( $options['woocommerce_product_player'], 'before_meta' ); ?>><?php esc_html_e( 'Before the metadata', 'waveplayer' ); ?></option>
											<option name="waveplayer_woocommerce_product_player_after_meta" value="after_meta" <?php selected( $options['woocommerce_product_player'], 'after_meta' ); ?>><?php esc_html_e( 'After the metadata', 'waveplayer' ); ?></option>
											<option name="waveplayer_woocommerce_product_player_after_summary" value="after_summary" <?php selected( $options['woocommerce_product_player'], 'after_summary' ); ?>><?php esc_html_e( 'After the summary', 'waveplayer' ); ?></option>
										</select>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="waveplayer_woocommerce_product_player_skin"><?php esc_html_e( 'Skin', 'waveplayer' ); ?></label>
									</th>
									<td>
										<select name="waveplayer_woocommerce_product_player_skin">
											<?php echo Renderer::get_skin_options( 'woocommerce_product_player_skin' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
										</select>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="waveplayer_woocommerce_product_player_size"><?php esc_html_e( 'Size', 'waveplayer' ); ?></label>
									</th>
									<td>
										<select name="waveplayer_woocommerce_product_player_size">
											<option name="waveplayer_woocommerce_product_player_size_default" value="default" <?php selected( $options['woocommerce_product_player_size'], 'default' ); ?>><?php esc_html_e( 'Default', 'waveplayer' ); ?> (<?php echo esc_html( $player_default_size ); ?>)</option>
											<option name="waveplayer_woocommerce_product_player_size_lg" value="lg" <?php selected( $options['woocommerce_product_player_size'], 'lg' ); ?>><?php esc_html_e( 'Large', 'waveplayer' ); ?></option>
											<option name="waveplayer_woocommerce_product_player_size_md" value="md" <?php selected( $options['woocommerce_product_player_size'], 'md' ); ?>><?php esc_html_e( 'Medium', 'waveplayer' ); ?></option>
											<option name="waveplayer_woocommerce_product_player_size_sm" value="sm" <?php selected( $options['woocommerce_product_player_size'], 'sm' ); ?>><?php esc_html_e( 'Small', 'waveplayer' ); ?></option>
											<option name="waveplayer_woocommerce_product_player_size_xs" value="xs" <?php selected( $options['woocommerce_product_player_size'], 'xs' ); ?>><?php esc_html_e( 'Extra Small', 'waveplayer' ); ?></option>
										</select>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="waveplayer_woocommerce_product_player_info"><?php esc_html_e( 'Info', 'waveplayer' ); ?></label>
									</th>
									<td>
										<select name="waveplayer_woocommerce_product_player_info">
											<option name="waveplayer_woocommerce_product_player_info_none" value="none" <?php selected( $options['woocommerce_product_player_info'], 'none' ); ?>><?php esc_html_e( 'nothing', 'waveplayer' ); ?></option>
											<option name="waveplayer_woocommerce_product_player_info_bar" value="bar" <?php selected( $options['woocommerce_product_player_info'], 'bar' ); ?>><?php esc_html_e( 'the info bar only', 'waveplayer' ); ?></option>
											<option name="waveplayer_woocommerce_product_player_info_playlist" value="playlist" <?php selected( $options['woocommerce_product_player_info'], 'playlist' ); ?>><?php esc_html_e( 'both the info bar and the playlist', 'waveplayer' ); ?></option>
										</select>
									</td>
								</tr>
							</tbody>
						</table>
						<?php submit_button(); ?>
						<h3><?php esc_html_e( 'Product Batch Creation', 'waveplayer' ); ?></h3>
						<p>
							<?php
								echo wp_kses(
									__(
										'The following batch creation process eases the creation of WooCommerce simple or variable products for each audio attachment found in your Media Library.<br>
										The batch creation saves a draft product per each item. The default product is simple, virtual and downloadable.<br>
										WavePlayer automatically associates to each product the corresponding audio track, as a preview files.<br>
										After the creation of all the product drafts, you can review and publish all the products, adding the downloadable files you want to associate to each product.<br>',
										'waveplayer'
									),
									self::$allowed_html_tags
								);
							?>
						</p>
						<div>
							<div class="">
								<select id="waveplayer_woocommerce_product_type" name="waveplayer_woocommerce_product_type">
									<option name="waveplayer_woocommerce_product_type_simple" value="simple" selected><?php esc_html_e( 'Simple', 'waveplayer' ); ?></option>
									<option name="waveplayer_woocommerce_product_type_variable" value="variable"><?php esc_html_e( 'Variable', 'waveplayer' ); ?></option>
								</select>
								<?php esc_html_e( 'Price', 'waveplayer' ); ?><?php echo esc_html( get_woocommerce_currency_symbol() ); ?><input type="text" id="waveplayer_woocommerce_price_tracks" name="waveplayer_woocommerce_price_tracks" value="0.99">
							</div>
							<div class="">
								<div id="track-pagination" class="tablenav">
										<?php
										echo $paginate_links; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
										?>
								</div>
								<p class="search-box">
									<label class="screen-reader-text" for="post-search-input">Search Pages:</label>
									<input type="search" id="track-search-input" name="s" value="" placeholder="search tracks...">
								</p>
								<div id="waveplayer_music_tracks" class="product-music-list">
								<?php
									echo $track_inputs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
								</div>
								<p>
									<a href="#" class="wvpl_toggle_selection" data-type="tracks" data-mode="select"><?php esc_html_e( 'Select all', 'waveplayer' ); ?></a> | <a href="#" class="wvpl_toggle_selection" data-type="tracks" data-mode="deselect"><?php esc_html_e( 'Deselect all', 'waveplayer' ); ?></a>
								</p><br>
								<p><a class="button button-primary wvpl_create_products" data-type="tracks"><?php esc_html_e( 'Create product drafts for each selected track', 'waveplayer' ); ?></a><p>
								<p><progress class="wvpl_progress wvpl_products_progress_tracks" value="0" max="1"></progress></p>
							</div>
						</div>
					</div>

				<?php } ?>


				<!-- TOOLS TAB -->
				<div id="waveplayer-tools" class="waveplayer-option-page <?php echo ( 'tools' !== self::$current_tab ? 'hidden' : '' ); ?>">
					<h3><?php esc_html_e( 'Tools', 'waveplayer' ); ?></h3>
					<table class="form-table">
						<tbody>
							<tr valign="top">
								<td colspan="2">
									<h4><?php esc_html_e( 'License Registration', 'waveplayer' ); ?></h4>
									<p>
										<?php esc_html_e( 'Please register your license to take advantage of free perpetual updates.', 'waveplayer' ); ?><br>
									</p>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label><?php esc_html_e( 'Register license', 'waveplayer' ); ?></label>
								</th>
								<td>
									<div class="waveplayer-registration-block">
										<input type="text" name="waveplayer_purchase_code" placeholder="your purchase code" value="<?php echo esc_attr( $options['purchase_code'] ); ?>" <?php disabled( ! ! $options['purchase_code'] ); ?> />
										<button id="waveplayer_register_license" type="button" class="button button-default registration-button <?php echo ! ! $options['purchase_code'] ? 'hidden' : ''; ?>" data-action="register"><?php esc_html_e( 'Register', 'waveplayer' ); ?></button>
										<button id="waveplayer_unregister_license" type="button" class="button button-default registration-button <?php echo ! $options['purchase_code'] ? 'hidden' : ''; ?>" data-action="unregister"><?php esc_html_e( 'Unregister', 'waveplayer' ); ?></button>
										<label class="waveplayer-email-optin-block" for="waveplayer_email_optin"><input id="waveplayer_email_optin" name="waveplayer_email_optin" type="checkbox" <?php checked( $options['email_optin'] ); ?>/> Get notified about your purchase code registration and any future update</label>
									</div>
									<p class="description">
										<span class="waveplayer-register-description-block <?php echo esc_attr( $options['purchase_code'] ? 'hidden' : '' ); ?>" >
											<?php esc_html_e( 'By registering your purchase code, you will associate it with the current website.', 'waveplayer' ); ?><br>
											<?php esc_html_e( 'You can get your purchase code from ', 'waveplayer' ); ?><strong><a href="https://codecanyon.net/downloads" target="_blank"><?php esc_html_e( 'your CodeCanyon account', 'waveplayer' ); ?></a></strong>
										</span>
										<span class="waveplayer-unregister-description-block <?php echo ! $options['purchase_code'] ? 'hidden' : ''; ?>">
											<?php esc_html_e( 'By unregistering your purchase code, you will free up this license and be able to use it on a different website.', 'waveplayer' ); ?>
											<strong><a href="https://codecanyon.net/downloads" target="_blank"><?php esc_html_e( 'your CodeCanyon account', 'waveplayer' ); ?></a></strong>
										</span>
									</p>
								</td>
							</tr>
							<tr valign="top">
								<td colspan="2">
									<h4><?php esc_html_e( 'Uninstalling WavePlayer', 'waveplayer' ); ?></h4>
									<p>
										<?php
											echo wp_kses(
												__(
													'By default, WavePlayer does not delete its settings when uninstalling. This will help you keep all your customization when installing a new version of the plugin, that implies you uninstall the previous version first.<br>
													If you want to permanently delete WavePlayer, set the <strong>Delete Settings</strong> checkbox before uninstalling and WavePlayer will delete all its settings during installation.<br>
													All peaks and info files stored in the <strong>/peaks</strong> subfolder will be deleted as well, completely cleaning your WordPress setup from any traces from WavePlayer.',
													'waveplayer'
												),
												self::$allowed_html_tags
											);
										?>
									</p>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="waveplayer_delete_settings"><?php esc_html_e( 'Delete settings', 'waveplayer' ); ?></label>
								</th>
								<td>
									<input type="checkbox" name="waveplayer_delete_settings" value=1 <?php isset( $options['delete_settings'] ) ? checked( $options['delete_settings'], true ) : ''; ?>>
									<span class="description"><?php esc_html_e( 'Set this option, if you want to delete all WavePlayer settings when uninstalling the plugin.', 'waveplayer' ); ?></span>
								</td>
							</tr>
						</tbody>
					</table>

					<?php submit_button(); ?>

					<table class="form-table">
						<tbody>
							<tr valign="top">
								<td colspan="2">
									<hr/>
									<h4><?php esc_html_e( 'Cache', 'waveplayer' ); ?></h4>
									<p>
										<?php
										echo wp_kses(
											__(
												'WavePlayer stores in the <code>/wp-content/cache/waveplayer</code> folder the content of each instance you create. Thanks to this cache, static player instances that never change their content can be generated in a much shorter time, reducing the server response time and improving the page speed performance. For example, a single-track player instance is generated in <strong>10 to 15 ms</strong> on an average shared server. The same instance, read from the cache, can be generated in <strong>less than 1 ms</strong>.',
												'waveplayer'
											),
											self::$allowed_html_tags
										);
										?>
									</p>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label><?php esc_html_e( 'Clear the cache', 'waveplayer' ); ?></label>
								</th>
								<td>
									<input class="button button-primary wvpl_clear_cache" type="submit" data-elements="orphan" value="<?php esc_html_e( 'Clear cache now', 'waveplayer' ); ?>" />
									<div id="wvpl_clear_cache_notice"></div>
								</td>
							</tr>
							<tr valign="top">
								<td colspan="2">
									<hr/>
									<h4><?php esc_html_e( 'Peak and info files', 'waveplayer' ); ?></h4>
									<p>
										<?php
											echo wp_kses(
												__(
													'A peak file is saved by WavePlayer in the \'<strong>peaks</strong>\' subfolder of the WordPress upload folder, whenever an audio track is loaded for the first time.<br>
													This allows WavePlayer to render the waveform of each audio file much faster the following times.',
													'waveplayer'
												),
												self::$allowed_html_tags
											);
										?>
									</p>
									<p>
										<?php
										esc_html_e(
											'Additionally, every time WavePlayer uses an external audio file for the first time, a small text file containing all the information about the external track gets saved in the same folder, together with an image of the cover art, if present in the audio file.
										These files are very small in size but help WavePlayer speed up the loading process of external audio files enormously, while offering you the possibility to playback audio files that are not stored in your own web server.',
											'waveplayer'
										);
										?>
									</p>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label><?php echo wp_kses( __( 'Regenerate peak files:<br>(internal only)', 'waveplayer' ), self::$allowed_html_tags ); ?></label>
								</th>
								<td>
									<input class="button button-primary wvpl_regenerate_peaks" type="submit" data-elements="orphan" value="<?php esc_html_e( 'Regenerate peak files', 'waveplayer' ); ?>" />
									<p class="description">
										<input type="checkbox" name="waveplayer_overwrite_peak_files" />
										<span class="description"><?php esc_html_e( 'Overwrite the peak files that are already stored in the peak folder.', 'waveplayer' ); ?></span>
									</p>
									<p><progress class="wvpl_progress wvpl_regenerate_file_progress" value="0" max="1"></progress></p>
									<p><progress class="wvpl_progress wvpl_regenerate_peak_progress" value="0" max="1"></progress></p>
									<div id="wvpl_regenerate_peak_notice"></div>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label><?php echo wp_kses( __( 'Delete orphan peak files:<br>(internal only)', 'waveplayer' ), self::$allowed_html_tags ); ?></label>
								</th>
								<td>
									<input class="button button-primary wvpl_delete_peaks" type="submit" data-elements="orphan" value="<?php esc_html_e( 'Delete orphan peak files', 'waveplayer' ); ?>" />
									<p class="description">
										<?php
											echo wp_kses(
												__(
													'If you delete an audio track that was previously used in WavePlayer, the peak file remains unused forever in the peak subfolder of the plugin.<br>
													Although peak files are very small in size (usually around 30 kB), it can be a waste of your hosting space if you happen to upload and delete audio attachments regularly.<br>
													It is recommended to delete orphan peak files every time you delete a massive amount of audio attachments from your website.',
													'waveplayer'
												),
												self::$allowed_html_tags
											);
										?>
									</p>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label><?php echo wp_kses( __( 'Delete all peak files:<br>(internal only)', 'waveplayer' ), self::$allowed_html_tags ); ?></label>
								</th>
								<td>
									<input class="button button-primary wvpl_delete_peaks" type="submit" data-elements="all-internal" value="<?php esc_html_e( 'Delete all peak files', 'waveplayer' ); ?>" />
									<p class="description">
										<?php esc_html_e( 'If you want to make sure WavePlayer regenerates all the peak files, you have to delete all of them using this button.', 'waveplayer' ); ?>
									</p>
									<p class="description">
										<?php echo wp_kses( __( '<strong>NOTE</strong>: This operation will not delete any audio file you uploaded in the Media Library.', 'waveplayer' ), self::$allowed_html_tags ); ?>
									</p>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label><?php echo wp_kses( _e( 'Delete all peak & info files:<br>(both internal and external)', 'waveplayer' ), self::$allowed_html_tags ); ?></label>
								</th>
								<td>
									<input class="button button-primary wvpl_delete_peaks" type="submit" data-elements="all" value="<?php esc_html_e( 'Delete all peak and info files', 'waveplayer' ); ?>" />
									<p class="description">
										<?php esc_html_e( 'If you want to make sure WavePlayer regenerates all the peak files for both internal and external audio files, you have to delete all of them using this button.', 'waveplayer' ); ?>
									</p>
									<p class="description">
										<?php echo wp_kses( _e( '<strong>NOTE</strong>: This operation will not delete any audio file you uploaded in the Media Library.', 'waveplayer' ), self::$allowed_html_tags ); ?>
									</p>
								</td>
							</tr>
						</tbody>
					</table>
					<table class="form-table">
						<tbody>
							<tr valign="top">
								<td colspan="2">
									<hr/>
									<h4><?php esc_html_e( 'Development', 'waveplayer' ); ?></h4>
									<p>
										<?php esc_html_e( 'If you are willing to stay up to date with the development of the new features without waiting for a stable relief, you can enroll in the beta program', 'waveplayer' ); ?>
									</p>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="waveplayer_beta_program"><?php esc_html_e( 'Receive beta updates', 'waveplayer' ); ?></label>
								</th>
								<td>
									<input type="checkbox" name="waveplayer_beta_program" value=1 <?php isset( $options['beta_program'] ) ? checked( $options['beta_program'], true ) : ''; ?>>
									<span><?php esc_html_e( 'By participating in the beta program, you will receive updates to versions that are still in development.', 'waveplayer' ); ?></span>
									<p class="description">
										<?php echo wp_kses( __( '<strong>WARNING!!!</strong> We strongly recommend you enroll to the beta program exclusively on a staging website and only if you are expert and able to troubleshoot any issue that the use of a beta version may cause.', 'waveplayer' ), self::$allowed_html_tags ); ?><br>
										<?php esc_html_e( 'We highly discouraged you from updating to a beta version on a production website is highly.', 'waveplayer' ); ?><br>
										<?php esc_html_e( 'While we do appreciate you taking the time to report any issue you encounter when using a beta version – which is the very reason we make this option available in the first place –, we won\'t provide any assistance or support whatsoever in troubleshooting and fixing any problem arising from the use of a beta version.', 'waveplayer' ); ?><br>
									</p>
								</td>
							</tr>
						</tbody>
					</table>
					<?php submit_button(); ?>
				</div>

		</form>

		<?php
	}

	/**
	 * Return the HTML markup of the auto-update enabler
	 *
	 * @param  string $html        The HTML markup for the update enabler.
	 * @param  string $plugin_file The plugin file.
	 * @param  string $plugin_data The plugin data.
	 * @return string              The filtered HTML markup for the update enabler.
	 * @since 3.1.2
	 */
	public static function auto_update_setting_html( $html, $plugin_file, $plugin_data ) {
		if ( 'waveplayer/waveplayer.php' === $plugin_file ) {
			ob_start();
			?>
			<a href="" class="toggle-auto-update aria-button-if-js" data-wp-action="enable" role="button">
				<span class="dashicons dashicons-update spin hidden" aria-hidden="true"></span>
				<span class="label">Enable auto-updates</span>
			</a>
			<?php

			$html = ob_get_clean();
		}

		return $html;
	}
}

/**
 * Walker_Taxonomy_Checklist class
 *
 * @since 3.0.0
 * @phpcs:disable Generic.Files.OneObjectStructurePerFile.MultipleFound
 */
class Walker_Taxonomy_Checklist extends \Walker {

	/**
	 * Define the type of tree
	 *
	 * @var string
	 */
	public $tree_type = 'category';

	/**
	 * Define the type of tree
	 *
	 * @var array
	 */
	public $db_fields = array(
		'parent' => 'parent',
		'id'     => 'term_id',
	);

	/**
	 * Walker start level
	 *
	 * @since 3.0.0
	 * @param string $output The HTML markup.
	 * @param int    $depth  The depth of the walker.
	 * @param array  $args   An array of additional arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundInExtendedClassAfterLastUsed
		$indent  = str_repeat( "\t", $depth );
		$output .= "$indent<ul class='children'>\n";
	}

	/**
	 * Walker end level
	 *
	 * @since 3.0.0
	 * @param string $output The HTML markup.
	 * @param int    $depth  The depth of the walker.
	 * @param array  $args   An array of additional arguments.
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundInExtendedClassAfterLastUsed
		$indent  = str_repeat( "\t", $depth );
		$output .= "$indent</ul>\n";
	}

	/**
	 * Walker start element
	 *
	 * @since 3.0.0
	 * @param string $output   The HTML markup.
	 * @param int    $category The category.
	 * @param int    $depth    The depth of the walker.
	 * @param array  $args     An array of additional arguments.
	 * @param int    $id       An array of additional arguments.
	 */
	public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundInExtendedClassBeforeLastUsed, Generic.CodeAnalysis.UnusedFunctionParameter.FoundInExtendedClassAfterLastUsed
		if ( empty( $args['taxonomy'] ) ) {
			$taxonomy = 'category';
		}

		$class   = in_array( $category->term_id, $args['popular_cats'], true ) ? ' class="popular-category"' : '';
		$output .= "\n<li id='{$args['taxonomy']}-{$category->term_id}'$class><label class='selectit'><input value='0' type='hidden' name='tax_input[{$args['taxonomy']}][{$category->term_id}]' /><input value='1' type='checkbox' name='tax_input[{$args['taxonomy']}][{$category->term_id}]' id='in-{$args['taxonomy']}-{$category->term_id}'" . checked( in_array( $category->term_id, $args['selected_cats'], true ), true, false ) . disabled( empty( $args['disabled'] ), false, false ) . ' />' . esc_html( apply_filters( 'the_category', $category->name ) ) . '</label>'; // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
	}

	/**
	 * Walker end element
	 *
	 * @since 3.0.0
	 * @param string $output   The HTML markup.
	 * @param int    $category The category.
	 * @param int    $depth    The depth of the walker.
	 * @param array  $args     An array of additional arguments.
	 */
	public function end_el( &$output, $category, $depth = 0, $args = array() ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundInExtendedClassAfterLastUsed
		$output .= "</li>\n";
	}
}

Admin::load();
