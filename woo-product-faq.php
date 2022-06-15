<?php
/**
Plugin Name: Product FAQ for WooCommerce
Plugin URI: https://www.chitabd.com/
Description: Add FAQ in WooCommerce Product Page
Version: 1.0.0
Author: Fazle Bari
Author URI: https://www.chitabd.com/
Licence: GPL Or leater
Text Domain: wpfaq
*/

defined('ABSPATH') or die('Nice Try!');

require_once __DIR__ . "/vendor/autoload.php";
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