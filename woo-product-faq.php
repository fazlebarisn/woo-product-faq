<?php
/**
* Plugin Name: Product FAQ for WooCommerce
* Plugin URI: https://github.com/fazlebarisn/woo-product-faq
* Description: Product FAQ for WooCommerce helps you to add frequently asked questions on single product page. Your customer can know some common questions answered. It will help them to understand to product better.
* Version: 1.0.0
* Author: Fazle Bari
* Author URI: https://www.chitabd.com/
* Requires PHP: 7.2
* Tested up to:         6.0.5
* WC requires at least: 3.0.0
* WC tested up to: 	 6.8.2
* Licence: GPL Or leater
* Text Domain: product-faq-for-woocommerce
* Domain Path: /languages/
* @package woofaq
*/

defined('ABSPATH') or die('Nice Try!');

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
    const version = "1.0.0";

    /**
     * class constructor
     */
    private function __construct()
    {
        $this->defineConstants();

        register_activation_hook( __FILE__ , [ $this , 'activate'] );

        add_action( 'plugins_loaded' , [ $this , 'initPlugin'] );
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
 