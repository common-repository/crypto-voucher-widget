<?php
/*
Plugin Name:  Crypto Voucher Widget
Plugin URI:   https://www.npmjs.com/package/@crypto-voucher/widget
Description:  A simple hassle-free tool for selling cryptocurrency straight from your website.
Version:      2.0.0
Author:       Crypto Voucher Team
Author URI:   https://cryptovoucher.io/
*/

require('cv_widget_image.php');
// require('cv_widget_text_button.php');


/* settings section */

function dbi_add_settings_page() {
    add_options_page( 'CV Widget Settings', 'CV Widget Settings', 'manage_options', 'dbi-example-plugin', 'dbi_render_plugin_settings_page' );
}
add_action( 'admin_menu', 'dbi_add_settings_page' );

function dbi_render_plugin_settings_page() {
	?>
	<div
		 style="display: grid; grid-template-columns: 100%; grid-auto-rows: min-content; row-gap: 12px;"
		 >
		<h2>Crypto Voucher Widget Settings</h2>
		<form action="options.php" method="post">
			<?php
			settings_fields( 'cv_widget_plugin_options' );
			do_settings_sections( 'cv_widget_plugin' ); ?>
			<input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e( 'Save' ); ?>" />
		</form>
	</div>
    <?php
}

function cv_widget_plugin_register_settings() {
    register_setting( 'cv_widget_plugin_options', 'cv_widget_plugin_options', 'cv_widget_plugin_options_validate' );
    add_settings_section( 'api_settings', 'API Settings', 'cv_widget_plugin_section_text', 'cv_widget_plugin' );

    add_settings_field( 'cv_widget_plugin_options_widget_token', 'API Token', 'cv_widget_plugin_options_widget_token', 'cv_widget_plugin', 'api_settings' );
}
add_action( 'admin_init', 'cv_widget_plugin_register_settings' );

function cv_widget_plugin_options_validate( $input ) {
    $newinput['widget_token'] = trim( $input['widget_token'] );
    if ( ! preg_match( '/^[a-z0-9]{24}$/i', $newinput['widget_token'] ) ) {
        $newinput['widget_token'] = '';
    }

    return $newinput;
}

function cv_widget_plugin_section_text() {
    echo '<p>Here you can set your API token</p>';
}

function cv_widget_plugin_options_widget_token() {
    $options = get_option( 'cv_widget_plugin_options' );
    echo "<input id='cv_widget_plugin_options_widget_token' placeholder='API token here...' name='cv_widget_plugin_options[widget_token]' type='text' value='" . esc_attr( $options['widget_token'] ) . "' />";
}

/* end of settings */

function cvvchwgt_register_widgets() {
    register_widget( 'CV_Widget_Image' );
}
add_action('widgets_init', 'cvvchwgt_register_widgets');


function cvvchwgt_load_scripts() {
  wp_register_script('crypto_voucher_widget', plugins_url('/plugins/cryptoVoucherWidget/crypto-voucher-widget.umd.js', __FILE__), array(), '1.0', false);
  wp_enqueue_script('crypto_voucher_widget');
}
add_action('wp_enqueue_scripts', 'cvvchwgt_load_scripts');

function cvvchwgt_load_styles() {
  wp_enqueue_style('widget_styles', plugins_url('/plugins/cryptoVoucherWidget/style.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'cvvchwgt_load_styles');


function cvvchwgt_wpb_hook_javascript() {
    ?>
        <script>
          window.onload = () => {
            const baseUrl = 'https://widget-front.cryptovoucher.io';

            window.startTransaction_hertlkj345h34 = ({ token, amount = null, currency = null, extId = null }) => {
              const widget = new CryptoVoucherWidget({
                selector: '#widget_embed_sdfgSDFgs45gGw',
                token: token,
                baseUrl: baseUrl,
                amount,
                currency,
                extId
              });

              widget.start();
            }
          }
        </script>
    <?php
}
add_action('wp_head', 'cvvchwgt_wpb_hook_javascript');


function cvvchwgt_custom_content_after_body_open_tag() {
    ?>
      <div id="widget_embed_sdfgSDFgs45gGw"></div>
    <?php
}
add_action('wp_body_open', 'cvvchwgt_custom_content_after_body_open_tag');
?>
