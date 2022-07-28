<?php

namespace Woo\Faq\Admin;
class Menu{

    public function __construct()
    {
        // add a menu page in dashboard
        add_action( 'admin_menu' , [ $this , 'adminMenu'] );
        // add exta links to the plugin
        add_filter('plugin_action_links_'.WOO_FAQ_BASENAME, [$this, 'settingsLink']);
        // active custom settings
        add_action('admin_init', [$this, 'wooFaqSettings']);
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

    /**
     * Register custom settings for plugin
     *
     * @return void
     */
    public function wooFaqSettings(){
        // register sections
        register_setting('woofaq-settings-group', 'product_faq', [$this, 'sanitizeFirstName']);
        register_setting('woofaq-settings-group', 'last_name', [$this, 'sanitizeLasttName']);

        //add section
        add_settings_section('woofaq-accordion-options', 'Accordion Options',[$this, 'accordionOptions'],'woo_sfaq');

        //add settings fields
        add_settings_field('woofaq-first-name', 'Product Faq', [$this, 'woofaqFirstName'], 'woo_sfaq', 'woofaq-accordion-options');
        add_settings_field('woofaq-last-name', 'Last Name', [$this, 'woofaqLastName'], 'woo_sfaq', 'woofaq-accordion-options');
    }

    /**
     * callback function for settings section
     * echo html
     *
     * @return void
     */
    public function accordionOptions(){
        echo 'From here you can change all setiings';
    }

    //Sanitize Data before input
    public function sanitizeFirstName($input){
        //var_dump($input);
        $output = sanitize_text_field($input);
        return $output;
    }
    public function sanitizeLasttName($input){
        $output = sanitize_text_field($input);
        return $output;
    }

    // dusplay first name input field
    public function woofaqFirstName(){
        $product_faq = esc_attr( get_option('product_faq') );
        ?>
            <select name="product_faq" id="product_faq">
                <option value="enable">Enable</option>
                <option value="disable" selected >Disable</option>
            </select>
        <?php
    }

    // Display last name input field
    public function woofaqLastName(){
        $last_name = esc_attr( get_option('last_name') );
        echo '<input type="text" name="last_name" value="'.$last_name.'" placeholder="Enter Last Name" />';
    }
}

