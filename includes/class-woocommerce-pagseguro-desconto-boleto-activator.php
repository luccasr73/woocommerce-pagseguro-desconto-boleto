<?php

/**
 * Fired during plugin activation
 *
 * @link       github.com/luccasr73
 * @since      1.0.0
 *
 * @package    Woocommerce_Pagseguro_Desconto_Boleto
 * @subpackage Woocommerce_Pagseguro_Desconto_Boleto/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Woocommerce_Pagseguro_Desconto_Boleto
 * @subpackage Woocommerce_Pagseguro_Desconto_Boleto/includes
 * @author     Luccas Robert <luccasrobert@hotmail.com>
 */
class Woocommerce_Pagseguro_Desconto_Boleto_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		if (!class_exists( 'WooCommerce')) {
			set_transient( 'activation_status', 'woo', 5 );
		} elseif (!class_exists('WC_PagSeguro')) {
			set_transient( 'activation_status', 'woopag', 5 );
		} else {
			set_transient( 'activation_status', true, 5 );
		}
	}

}
