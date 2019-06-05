<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       github.com/luccasr73
 * @since      1.0.0
 *
 * @package    Woocommerce_Pagseguro_Desconto_Boleto
 * @subpackage Woocommerce_Pagseguro_Desconto_Boleto/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Woocommerce_Pagseguro_Desconto_Boleto
 * @subpackage Woocommerce_Pagseguro_Desconto_Boleto/includes
 * @author     Luccas Robert <luccasrobert@hotmail.com>
 */
class Woocommerce_Pagseguro_Desconto_Boleto {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Woocommerce_Pagseguro_Desconto_Boleto_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WOOCOMMERCE_PAGSEGURO_DESCONTO_BOLETO_VERSION' ) ) {
			$this->version = WOOCOMMERCE_PAGSEGURO_DESCONTO_BOLETO_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'woocommerce-pagseguro-desconto-boleto';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Woocommerce_Pagseguro_Desconto_Boleto_Loader. Orchestrates the hooks of the plugin.
	 * - Woocommerce_Pagseguro_Desconto_Boleto_i18n. Defines internationalization functionality.
	 * - Woocommerce_Pagseguro_Desconto_Boleto_Admin. Defines all hooks for the admin area.
	 * - Woocommerce_Pagseguro_Desconto_Boleto_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woocommerce-pagseguro-desconto-boleto-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woocommerce-pagseguro-desconto-boleto-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-woocommerce-pagseguro-desconto-boleto-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-woocommerce-pagseguro-desconto-boleto-public.php';

		$this->loader = new Woocommerce_Pagseguro_Desconto_Boleto_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Woocommerce_Pagseguro_Desconto_Boleto_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Woocommerce_Pagseguro_Desconto_Boleto_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Woocommerce_Pagseguro_Desconto_Boleto_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		//$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_notices', $plugin_admin, 'activation_notice' );
		$this->loader->add_action('admin_menu', $plugin_admin, 'add_submenu', 100);
		//$this->loader->add_action('wp_ajax_reload_discount', $plugin_admin,'reload_discount');
		$this->loader->add_action('admin_post_save_options', $plugin_admin,'save_options');
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Woocommerce_Pagseguro_Desconto_Boleto_Public( $this->get_plugin_name(), $this->get_version() );

		$active = get_option( $this->plugin_name.'discount_active', false );
		$cumulative = get_option( $this->plugin_name.'discount_cumulative', false );

		if($active && $cumulative){
			$this->loader->add_filter( 'woocommerce_pagseguro_payment_xml', $plugin_public, 'apply_discount_on_boleto_cumulative', 10, 2 );
			$this->loader->add_action( 'woocommerce_cart_totals_after_order_total',$plugin_public, 'display_total_boleto_cumulative', 20 );
			$this->loader->add_action( 'woocommerce_review_order_after_shipping', $plugin_public, 'display_total_boleto_cumulative', 20 );
		}
		if($active && !$cumulative){
			$this->loader->add_filter( 'woocommerce_pagseguro_payment_xml', $plugin_public, 'apply_discount_on_boleto', 10, 2 );
			$this->loader->add_action( 'woocommerce_cart_totals_after_order_total',$plugin_public, 'display_total_boleto', 20 );
			$this->loader->add_action( 'woocommerce_review_order_after_shipping', $plugin_public, 'display_total_boleto', 20 );
		}
		
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Woocommerce_Pagseguro_Desconto_Boleto_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
