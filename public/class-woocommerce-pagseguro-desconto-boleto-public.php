<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       github.com/luccasr73
 * @since      1.0.0
 *
 * @package    Woocommerce_Pagseguro_Desconto_Boleto
 * @subpackage Woocommerce_Pagseguro_Desconto_Boleto/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Woocommerce_Pagseguro_Desconto_Boleto
 * @subpackage Woocommerce_Pagseguro_Desconto_Boleto/public
 * @author     Luccas Robert <luccasrobert@hotmail.com>
 */
class Woocommerce_Pagseguro_Desconto_Boleto_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	function apply_discount_on_boleto( $xml, $order ) {
		if(empty(WC()->cart->get_applied_coupons())) {
			$newxml = $xml;
			if($newxml->method == 'boleto'){
				$shipping = WC()->cart->get_shipping_total();
				$total = $order->total;
				$discount_value = ($total - $shipping) * ((int)get_option( $this->plugin_name.'discount_value', 10 )/100);
				//$boleto_cost = 1;
				$new_total = $discount_value;
				$new_total = '-'.$new_total;
				$new_total = number_format($new_total, 2);
				$newxml->addChild( 'extraAmount', $new_total );
				$fee = new \WC_Order_Item_Fee();
				$fee->set_props( array(
					'name'      => 'Desconto no Boleto',
					'tax_class' => 0,
					'total'     => -($discount_value),
					'total_tax' => 0,
					'taxes'     => array(
						'total' => array( 0 ),
					),
					'order_id'  => $order->get_id(),
				) );
				$fee->save();
				$order->add_item( $fee );
				$order->update_taxes();
				$order->calculate_totals();
				$order->save();
			}
			return $newxml;
		}
	}
	

	function display_total_boleto() {
		if(empty(WC()->cart->get_applied_coupons())) {
			$total = WC()->cart->cart_contents_total;
			$shipping = WC()->cart->get_shipping_total();
			$desconto = (int)get_option( $this->plugin_name.'discount_value', 10 );
			$discount = number_format( $total * ( $desconto / 100 ), 2, '.', ',' );
			
				echo ' <tr class="cart-total-boleto order-total">
					<th>' . __( "Valor com desconto", "woocommerce" ) . '</th>
					<td data-title="total-boleto"><strong style="color:#333">'.wc_price((float)$shipping + $total-(float)$discount).' à vista no boleto</strong></td>
				</tr>';
		}
	}

	function apply_discount_on_boleto_cumulative( $xml, $order ) {
		//if(empty(WC()->cart->get_applied_coupons())) {
			$newxml = $xml;
			if($newxml->method == 'boleto'){
				$shipping = WC()->cart->get_shipping_total();
				$total = $order->total;
				$discount_value = ($total - $shipping) * ((int)get_option( $this->plugin_name.'discount_value', 10 )/100);
				//$boleto_cost = 1;
				$new_total = $discount_value;
				$new_total = '-'.$new_total;
				$new_total = number_format($new_total, 2);
				$newxml->addChild( 'extraAmount', $new_total );
				$fee = new \WC_Order_Item_Fee();
				$fee->set_props( array(
					'name'      => 'Desconto no Boleto',
					'tax_class' => 0,
					'total'     => -($discount_value),
					'total_tax' => 0,
					'taxes'     => array(
						'total' => array( 0 ),
					),
					'order_id'  => $order->get_id(),
				) );
				$fee->save();
				$order->add_item( $fee );
				$order->update_taxes();
				$order->calculate_totals();
				$order->save();
			}
			return $newxml;
		//}
	}
	

	function display_total_boleto_cumulative() {
		//if(empty(WC()->cart->get_applied_coupons())) {
			$total = WC()->cart->cart_contents_total;
			$shipping = WC()->cart->get_shipping_total();
			$desconto = (int)get_option( $this->plugin_name.'discount_value', 10 );
			$discount = number_format( $total * ( $desconto / 100 ), 2, '.', ',' );
			
				echo ' <tr class="cart-total-boleto order-total">
					<th>' . __( "Valor com desconto", "woocommerce" ) . '</th>
					<td data-title="total-boleto"><strong style="color:#333">'.wc_price((float)$shipping + $total-(float)$discount).' à vista no boleto</strong></td>
				</tr>';
		//}
	}

}
