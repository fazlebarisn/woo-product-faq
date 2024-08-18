<?php
/**
* Plugin Name: Product FAQ for WooCommerce
* Plugin URI: https://github.com/fazlebarisn/woo-product-faq
* Description: Product FAQ for WooCommerce helps you to add frequently asked questions on single product page. Your customer can know some common questions answered.
* Version: 1.1.3
* Author: Fazle Bari
* Author URI: https://www.chitabd.com/
* Requires PHP: 7.2
* Tested up to: 6.6.1
* WC requires at least: 3.0.0
* WC tested up to: 	 9.1.4
* Licence: GPL Or leater 
* Text Domain: product-faq-for-woocommerce
* Domain Path: /i18n/languages/
* @package woofaq
*/

defined('ABSPATH') or die('Nice Try!');

/**
 * Only for developer
 * @author Fazle Bari <fazlebarisn@gmail.com>
 */
if( ! function_exists('dd') ){
	function dd( ...$vals){
		if( ! empty($vals) && is_array($vals) ){
			foreach($vals as $val ){
				echo "<pre>";
				var_dump($val);
				echo "</pre>";
			}
		}
	}
}

// Include autoload.php
if( file_exists( dirname(__FILE__) . '/vendor/autoload.php') ){
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

/**
 * The main class
 */

 final class WooFaq{

    /**
     * defien plugin version
     */
    const version = "1.1.2";

    /**
     * class constructor
     */
    private function __construct()
    {
        $this->defineConstants();

        add_action( 'before_woocommerce_init', [$this, 'product_faq_hpos'] );

        register_activation_hook( __FILE__ , [ $this , 'activate'] );

        add_action( 'plugins_loaded' , [ $this , 'initPlugin'] );
    }

    /**
     * Declare compatibility with custom order tables for WooCommerce.
     * Support WooCommerce High-performance order storage
     * @since 1.1.2
     * @author Fazle Bari <fazlebarisn@gmail.com>
     */
    public function product_faq_hpos(){
		if (class_exists('\Automattic\WooCommerce\Utilities\FeaturesUtil')) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('custom_order_tables', __FILE__, true);
		}
	}

    /**
     * initilize a singileton 
     *
     * @return \WooFaq class
     */
     public static function init(){

         static $instance = false;

         if( !$instance ){
             $instance = new self();
         }

         return $instance;
     }

     /**
      * Define plugin constants
      *
      * @return constants
      */
     public function defineConstants(){

         define( 'WOO_FAQ_VERSION' , self::version );
         define( 'WOO_FAQ_FILE' , __FILE__ );
         define( 'WOO_FAQ_PATH' , __DIR__ );
         define( 'WOO_FAQ_URL' , plugins_url( '' , WOO_FAQ_FILE ) );
         define( 'WOO_FAQ_ASSETS' , WOO_FAQ_URL . '/assets' );
         define( 'WOO_FAQ_BASENAME' , plugin_basename(__FILE__) );

     }

     /**
      * Initialize the plugin
      *
      * @return void
      */
     public function initPlugin(){

        if( is_admin() ){
            new Woo\Faq\Admin();
        }else{
            new \Woo\Faq\Frontend();
        }
        
     }

     /**
      * do stuff when plugin install
      *
      * @return void
      */
     public function activate(){

        // when first install
        $installed = get_option( 'woo_faq_installed' );
        if( !$installed ){
            update_option( 'woo_faq_installed' , time() );
        }

        // what is the version number when first install
        update_option( 'woo_faq_version' , WOO_FAQ_VERSION ); 

     }

 }

 /**
  * Initializes the main plugin
  *
  * @return \WooFaq class
  */
 function wooFaq(){
     return WooFaq::init();
 }

 // kick-off the plugin
 wooFaq();

 //var_dump( $installed );
 