<?php

namespace Woo\Faq\Admin;

class AdminNotice{
    public function __construct(){

        if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
        } 
    }

    public function admin_notice_missing_main_plugin(){
        $class = 'notice notice-error';
        $message = __( "Product FAQ for WooCommerce Requires WooCommerce to be Activated", "product-faq-for-woocommerce" );
     
        printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
    }
}
