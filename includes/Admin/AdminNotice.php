<?php

namespace Woo\Faq\Admin;

class AdminNotice{
    public function __construct(){
        //add_action( 'admin_notices', [$this ,'sample_admin_notice__error'] );
    }

    public function sample_admin_notice__error(){
        $class = 'notice notice-error';
        $message = __( 'Irks! An error has occurred.', 'sample-text-domain' );
     
        printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
    }
}