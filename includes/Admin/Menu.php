<?php

namespace Woo\Faq\Admin;

class Menu{

    public function __construct()
    {
        add_action( 'admin_menu' , [ $this , 'adminMenu'] );,/sa;s
    }

    /**
     * Add menu in wordpress dashboard menu
     *
     * @return void
     */
    public function adminMenu(){
        add_menu_page( __('Product Faq' , 'woofaq' ) , __('Faq' , 'woofaq') , 'manage_options' , 'woo-faq' , [$this , 'pluginPage'] , 'dashicons-welcome-learn-more' );
    }

    public function pluginPage(){
        echo "hyyy";
    }
}