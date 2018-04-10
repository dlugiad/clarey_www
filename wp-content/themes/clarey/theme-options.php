<?php

add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

/**
 * Init plugin options to white list our options
 */
function theme_options_init(){
	register_setting( 'clarey_options', 'clarey_theme_options', 'theme_options_validate' );
}

/**
 * Load up the menu page
 */
function theme_options_add_page() {
	add_theme_page( __( 'Opcje', 'clarey' ), __( 'Opcje', 'clarey' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
}

/**
 * Create arrays for our select and radio options
 */
// $select_options = array(
// 	'0' => array(
// 		'value' =>	'0',
// 		'label' => __( 'Zero', 'clarey' )
// 	),
// 	'1' => array(
// 		'value' =>	'1',
// 		'label' => __( 'One', 'clarey' )
// 	),
// 	'2' => array(
// 		'value' => '2',
// 		'label' => __( 'Two', 'clarey' )
// 	),
// 	'3' => array(
// 		'value' => '3',
// 		'label' => __( 'Three', 'clarey' )
// 	),
// 	'4' => array(
// 		'value' => '4',
// 		'label' => __( 'Four', 'clarey' )
// 	),
// 	'5' => array(
// 		'value' => '3',
// 		'label' => __( 'Five', 'clarey' )
// 	)
// );

// $radio_options = array(
// 	'yes' => array(
// 		'value' => 'yes',
// 		'label' => __( 'Yes', 'clarey' )
// 	),
// 	'no' => array(
// 		'value' => 'no',
// 		'label' => __( 'No', 'clarey' )
// 	),
// 	'maybe' => array(
// 		'value' => 'maybe',
// 		'label' => __( 'Maybe', 'clarey' )
// 	)
// );

/**
 * Create the options page
 */
function theme_options_do_page() {
	global $select_options, $radio_options;

	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;

	?>
	<div class="wrap">
		<?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Opcje', 'clarey' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Options saved', 'clarey' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
			<?php settings_fields( 'clarey_options' ); ?>
			<?php $options = get_option( 'clarey_theme_options' ); ?>

			<table class="form-table">

				<?php
				/**
				 * A sample text input option
				 */
				?>

<!-- Telefony -->
				<tr valign="top"><th scope="row"><?php _e( 'Facebook', 'clarey' ); ?></th>
					<td>
						<input id="clarey_theme_options[facebook]" class="regular-text" type="text" name="clarey_theme_options[facebook]" value="<?php esc_attr_e( $options['facebook'] ); ?>" />
						<label class="description" for="clarey_theme_options[facebook]"><?php _e( '', 'clarey' ); ?></label>
					</td>
				</tr>
				<tr valign="top"><th scope="row"><?php _e( 'Twitter', 'clarey' ); ?></th>
					<td>
						<input id="clarey_theme_options[twitter]" class="regular-text" type="text" name="clarey_theme_options[twitter]" value="<?php esc_attr_e( $options['twitter'] ); ?>" />
						<label class="description" for="clarey_theme_options[twitter]"><?php _e( '', 'clarey' ); ?></label>
					</td>
				</tr>
				<tr valign="top"><th scope="row"><?php _e( 'Linked in', 'clarey' ); ?></th>
					<td>
						<input id="clarey_theme_options[linkedin]" class="regular-text" type="text" name="clarey_theme_options[linkedin]" value="<?php esc_attr_e( $options['linkedin'] ); ?>" />
						<label class="description" for="clarey_theme_options[linkedin]"><?php _e( '', 'clarey' ); ?></label>
					</td>
				</tr>
				<tr valign="top"><th scope="row"><?php _e( 'Google+', 'clarey' ); ?></th>
					<td>
						<input id="clarey_theme_options[gplus]" class="regular-text" type="text" name="clarey_theme_options[gplus]" value="<?php esc_attr_e( $options['gplus'] ); ?>" />
						<label class="description" for="clarey_theme_options[gplus]"><?php _e( '', 'clarey' ); ?></label>
					</td>
				</tr>
				<tr valign="top"><th scope="row"><?php _e( 'YouTube', 'clarey' ); ?></th>
					<td>
						<input id="clarey_theme_options[youtube]" class="regular-text" type="text" name="clarey_theme_options[youtube]" value="<?php esc_attr_e( $options['youtube'] ); ?>" />
						<label class="description" for="clarey_theme_options[youtube]"><?php _e( '', 'clarey' ); ?></label>
					</td>
				</tr>
				<tr valign="top"><th scope="row"><?php _e( 'Pinterest', 'clarey' ); ?></th>
					<td>
						<input id="clarey_theme_options[pinterest]" class="regular-text" type="text" name="clarey_theme_options[pinterest]" value="<?php esc_attr_e( $options['pinterest'] ); ?>" />
						<label class="description" for="clarey_theme_options[pinterest]"><?php _e( '', 'clarey' ); ?></label>
					</td>
				</tr>
				<tr valign="top"><th scope="row"><?php _e( 'Instagram', 'clarey' ); ?></th>
					<td>
						<input id="clarey_theme_options[instagram]" class="regular-text" type="text" name="clarey_theme_options[instagram]" value="<?php esc_attr_e( $options['instagram'] ); ?>" />
						<label class="description" for="clarey_theme_options[instagram]"><?php _e( '', 'clarey' ); ?></label>
					</td>
				</tr>

<tr><td><hr></td></tr>


				<tr valign="top"><th scope="row"><?php _e( 'Link Rejestracja', 'clarey' ); ?></th>
					<td>
						<input id="clarey_theme_options[register]" class="regular-text" type="text" name="clarey_theme_options[register]" value="<?php esc_attr_e( $options['register'] ); ?>" />
						<label class="description" for="clarey_theme_options[register]"><?php _e( '', 'clarey' ); ?></label>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Link Logowanie', 'clarey' ); ?></th>
					<td>
						<input id="clarey_theme_options[login]" class="regular-text" type="text" name="clarey_theme_options[login]" value="<?php esc_attr_e( $options['login'] ); ?>" />
						<label class="description" for="clarey_theme_options[login]"><?php _e( '', 'clarey' ); ?></label>
					</td>
				</tr>

<tr><td><hr></td></tr>


				<tr valign="top"><th scope="row"><?php _e( 'Dodatkowe Style CSS', 'clarey' ); ?></th>
					<td>
						<textarea rows="6" cols="50" id="clarey_theme_options[css_style]" class="regular-text" type="text" name="clarey_theme_options[css_style]"><?php esc_attr_e( $options['css_style'] ); ?></textarea>
						<label class="description" for="clarey_theme_options[css_style]"><?php _e( '', 'clarey' ); ?></label>
					</td>
				</tr>

			</table>

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'clarey' ); ?>" />
			</p>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function theme_options_validate( $input ) {


	// Our checkbox value is either 0 or 1
	if ( ! isset( $input['option1'] ) )
		$input['option1'] = null;
	$input['option1'] = ( $input['option1'] == 1 ? 1 : 0 );

	// Say our text option must be safe text with no HTML tags
	$input['sometext'] = wp_filter_nohtml_kses( $input['sometext'] );


	return $input;
}

// adapted from http://planetozh.com/blog/2009/05/handling-plugins-options-in-wordpress-28-with-register_setting/