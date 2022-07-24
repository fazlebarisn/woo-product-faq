<?php

namespace Woo\Faq\Admin;
class Menu{

    public function __construct()
    {
        add_action( 'admin_menu' , [ $this , 'adminMenu'] );
        add_filter('plugin_action_links_'.WOO_FAQ_BASENAME, [$this, 'settingsLink']);
    }

    /**
     * add settings link 
     *
     * @return void
     */
    public function settingsLink( $links ){
        $settings_link = '<a href="admin.php?page=woo_sfaq">Settings</a>';
        array_push($links,$settings_link);
        return $links;
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
        require_once WOO_FAQ_PATH.'/templates/Admin.php';
    }

}