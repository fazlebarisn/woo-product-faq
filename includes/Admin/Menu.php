<?php

namespace Woo\Faq\Admin;

use function PHPSTORM_META\map;

class Menu{

    public function __construct()
    {
        add_action( 'admin_menu' , [ $this , 'adminMenu'] );
    }

    /**
     * Add menu in wordpress dashboard menu
     *
     * @return void
     */
    public function adminMenu(){
        add_menu_page( __('Product Faq' , 'woofaq' ) , __('Product Faq' , 'woofaq') , 'manage_options' , 'woo-faq' , [$this , 'pluginPage'] , 'dashicons-welcome-learn-more' );
    }

    public function registerCustomFields(){
        register_setting('woo_faq', 'Select Position', 'wooFaqSettings');

        add_settings_section('woo_sfaq', 'Faq Option', 'faqOptions','woo_faq');

        add_settings_field('woo_faq_id', 'Title', 'fieldCallback','woo_faq', 'woo_sfaq');
    }

    public function wooFaqSettings(){
        echo 555555;
    }

    public function faqOptions(){
        echo 4444;
    }

    public function fieldCallback(){
        echo 66666;
    }
}