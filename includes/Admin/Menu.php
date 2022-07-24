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
        add_menu_page( __('Product Faq' , 'woofaq' ) , __('Product Faq' , 'woofaq') , 'manage_options' , 'woo_sfaq' , [$this , 'adminPage'] , 'dashicons-welcome-learn-more' );
    }

    /**
     * admin page function
     * include template here
     *
     * @return void
     */
    public function adminPage(){
        //var_dump(WOO_FAQ_PATH);
        require_once WOO_FAQ_PATH.'/templates/Admin.php';
    }

}