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
        register_setting('woofaq-settings-group', 'product_faq');
        register_setting('woofaq-settings-group', 'faq_heading', [$this, 'sanitizeFaqHeading']);

        //add section
        add_settings_section('woofaq-product-faq-options', __('Product Faq Options', 'woofaq'),[$this, 'productFaqOptions'],'woo_sfaq');

        //add settings fields
        add_settings_field('woofaq-product-faq', __('Product Faq', 'woofaq'), [$this, 'woofaqProductFaq'], 'woo_sfaq', 'woofaq-product-faq-options');
        add_settings_field('woofaq-faq-heading', __('Faq Heading', 'woofaq'), [$this, 'woofaqHeading'], 'woo_sfaq', 'woofaq-product-faq-options');
    }

    /**
     * callback function for settings section
     * echo html
     *
     * @return void
     */
    public function productFaqOptions(){
        echo 'From here you can change all setiings';
    }

    //Sanitize Data before input
    public function sanitizeFaqHeading($input){
        //var_dump($input);
        $output = sanitize_text_field($input);
        return $output;
    }

    // dusplay first name input field
    public function woofaqProductFaq(){
        $product_faq = esc_attr( get_option('product_faq') );
        ?>
            <select name="product_faq" id="product_faq">
                <option value="enable" <?php echo isset($product_faq ) && $product_faq == 'enable' ? 'selected' : ''; ?> >Enable</option>
                <option value="disable" <?php echo isset($product_faq ) && $product_faq == 'disable' ? 'selected' : ''; ?> >Disable</option>
            </select>
        <?php
    }

    // Display last name input field
    public function woofaqHeading(){
        $faq_heading = esc_attr( get_option('faq_heading') );
        echo '<input type="text" name="faq_heading" value="'.$faq_heading.'" placeholder="Insert Faq Heading" />';
    }
}

