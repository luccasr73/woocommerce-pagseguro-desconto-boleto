<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              github.com/luccasr73
 * @since             1.0.0
 * @package           Woocommerce_Pagseguro_Desconto_Boleto
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce Pagseguro Desconto Boleto
 * Plugin URI:        github.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Luccas Robert
 * Author URI:        github.com/luccasr73
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woocommerce-pagseguro-desconto-boleto
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WOOCOMMERCE_PAGSEGURO_DESCONTO_BOLETO_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woocommerce-pagseguro-desconto-boleto-activator.php
 */
function activate_woocommerce_pagseguro_desconto_boleto() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-pagseguro-desconto-boleto-activator.php';
	Woocommerce_Pagseguro_Desconto_Boleto_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woocommerce-pagseguro-desconto-boleto-deactivator.php
 */
function deactivate_woocommerce_pagseguro_desconto_boleto() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-pagseguro-desconto-boleto-deactivator.php';
	Woocommerce_Pagseguro_Desconto_Boleto_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woocommerce_pagseguro_desconto_boleto' );
register_deactivation_hook( __FILE__, 'deactivate_woocommerce_pagseguro_desconto_boleto' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-pagseguro-desconto-boleto.php';

/*


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woocommerce_pagseguro_desconto_boleto() {

	$plugin = new Woocommerce_Pagseguro_Desconto_Boleto();
	$plugin->run();

}
run_woocommerce_pagseguro_desconto_boleto();
