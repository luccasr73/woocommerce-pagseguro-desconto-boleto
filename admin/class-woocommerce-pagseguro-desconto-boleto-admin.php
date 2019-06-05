<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       github.com/luccasr73
 * @since      1.0.0
 *
 * @package    Woocommerce_Pagseguro_Desconto_Boleto
 * @subpackage Woocommerce_Pagseguro_Desconto_Boleto/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woocommerce_Pagseguro_Desconto_Boleto
 * @subpackage Woocommerce_Pagseguro_Desconto_Boleto/admin
 * @author     Luccas Robert <luccasrobert@hotmail.com>
 */
class Woocommerce_Pagseguro_Desconto_Boleto_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name.'bulma', 'https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'admin', plugin_dir_url( __FILE__ ) . 'css/woocommerce-pagseguro-desconto-boleto-admin.css', array($this->plugin_name.'bulma'), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	/*public function enqueue_scripts() {

		//wp_enqueue_script( $this->plugin_name.'jquery', 'https://code.jquery.com/jquery-3.4.1.min.js', array(), $this->version, false );
		//wp_enqueue_script( $this->plugin_name.'admin', plugin_dir_url( __FILE__ ) . 'js/woocommerce-pagseguro-desconto-boleto-admin.js', array(), $this->version, false );
		//wp_localize_script( $this->plugin_name.'admin', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ));

	}*/

	function deactive_plugin(){
		deactivate_plugins($this->plugin_name.'/'.$this->plugin_name.'.php');
	}

	function mount_notice($errText, $type){
		$template = '';
		$template .= '<div class="'.$type.' notice is-dismissible">';	
		$template .= '<p>'.$errText.'</p>';
		$template .= '</div>';
		return $template;
	}

	function createOptions(){
		add_option( $this->plugin_name.'discount_value',  10 );
		add_option( $this->plugin_name.'discount_active', false );
		add_option( $this->plugin_name.'discount_cumulative', false );
	}
	
	function activation_notice(){
	
		/* Check transient, if available display notice */
		if( get_transient( 'activation_status' ) === 'woo' ){
			echo($this->mount_notice('O WooCommerce precisa estar ativado para este plugin funcionar', 'error'));
			if ( isset($_GET['activate']) ) {
				unset($_GET['activate']);
			}
			delete_transient( 'activation_status' );
			$this->deactive_plugin();
		}
		if( get_transient( 'activation_status' ) === 'woopag' ){
			echo($this->mount_notice('O WooCommerce PagSeguro precisa estar ativado para este plugin funcionar', 'error'));
			if ( isset($_GET['activate']) ) {
				unset($_GET['activate']);
			}
			delete_transient( 'activation_status' );
			$this->deactive_plugin();
		}

		if( get_transient( 'activation_status' ) === true ){
			echo($this->mount_notice('Plugin ativado', 'updated'));
			if ( isset($_GET['activate']) ) {
				unset($_GET['activate']);
			}
			$this->createOptions();
			delete_transient( 'activation_status' );
		}	
	}

	public function add_submenu(){
		add_submenu_page(
			'woocommerce',
			'WooCommerce PagSeguro Desconto no Boleto',
			'PagSeguro Desconto no Boleto',
			'manage_options',
			$this->plugin_name, 
			array($this, 'submenu_template')
		);
	}

	public function submenu_template(){
		include_once plugin_dir_path( __FILE__ ). 'partials/woocommerce-pagseguro-desconto-boleto-admin-display.php';
	}

	public function save_options() {
		$discount_value = $_POST['discount-value'];
		$active = $_POST['discount-active'];
		$cumulative = $_POST['discount-cumulative'];

		if(!isset($_POST['discount-active'])){
			$active = false;
		} else {
			$active = true;
		}

		if(!isset($_POST['discount-cumulative']) ) {
			$cumulative = false;
		} else {
			$cumulative = true;
		}
		
		if( !filter_var($discount_value, FILTER_VALIDATE_INT) &&  $discount_value <= 100) {
			set_transient( $this->plugin_name.'error_set_discount_value', 'Digite um numero inteiro!', 600 );
		}

		update_option( $this->plugin_name.'discount_value', absint($discount_value) );
		update_option( $this->plugin_name.'discount_active', $active );
		update_option( $this->plugin_name.'discount_cumulative', $cumulative );

		wp_redirect( admin_url('admin.php?page='.$this->plugin_name) );
	}
}
