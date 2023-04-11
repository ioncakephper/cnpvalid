<?php
/*
 * Plugin Name:       CNP Validator
 * Description:       Demo plugin for Wise WordPress Developer Test.
 * Version:           0.0.1
 * Author:            Ion Gireada
 * Author URI:        https://author.example.com/
 * Text Domain:       cnpv
 * Domain Path:       /languages
 */

// if this file is called directly, abort
if ( !defined ( 'ABSPATH' )) {
    die;
}

function cnpv_load_stylesheet() {
    if ( is_single() ) {
        wp_enqueue_style( 'cnpv_styles', plugin_dir_url(__FILE__) . 'cnpv-styles.css');
    }
}

add_action( 'wp_enqueue_scripts', 'cnpv_load_stylesheet');

function cnpv_function() {
    return '
    <div class="form-group">
        <label for="cnp">CNP:</label>
        <input type="text" class="form-control" name="cnp" id="cnp" placeholder="Enter CNP value here" />
        <input type="submit" name="validate" id="validate" value="Validate" onclick="validate_cnp_field(\'' . site_url() . '\')" />
        <div id="status"></div>
    </div>
    ';
}

add_shortcode('cnpv', 'cnpv_function');

function cnpv_add_javascript() {
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="http://localhost/wordpress/wp-content/plugins/cnpvalid/js/submit_validate_form.js"></script>
    <?php
}
add_action("wp_footer", 'cnpv_add_javascript');


