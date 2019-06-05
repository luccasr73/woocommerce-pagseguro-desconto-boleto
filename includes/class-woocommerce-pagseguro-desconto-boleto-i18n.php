<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       github.com/luccasr73
 * @since      1.0.0
 *
 * @package    Woocommerce_Pagseguro_Desconto_Boleto
 * @subpackage Woocommerce_Pagseguro_Desconto_Boleto/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Woocommerce_Pagseguro_Desconto_Boleto
 * @subpackage Woocommerce_Pagseguro_Desconto_Boleto/includes
 * @author     Luccas Robert <luccasrobert@hotmail.com>
 */
class Woocommerce_Pagseguro_Desconto_Boleto_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'woocommerce-pagseguro-desconto-boleto',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
