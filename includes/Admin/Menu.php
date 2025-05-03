<?php

namespace Woo\Faq\Admin;
class Menu{

    public function __construct(){
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
        add_menu_page( __('Product Faq' , 'product-faq-for-woocommerce' ) , __('Product Faq' , 'product-faq-for-woocommerce') , 'manage_options' , 'woo_sfaq' , [$this , 'adminPage'] , 'dashicons-info' );
        add_submenu_page( 'woo_sfaq' , __('Product Archive' , 'product-faq-for-woocommerce') , __('Product Archive' , 'product-faq-for-woocommerce') , 'manage_options' , 'woo_afaq' , [$this , 'productAtchivePage'] );
    }

    /**
     * admin page function
     * include template here
     * @since 1.0.0
     * @return void
     * @author Fazle Bari <fazlebarisn@gmail.com>
     */
    public function adminPage(){
        require_once WOO_FAQ_PATH.'/pages/dashboard.php';
    }
    public function productAtchivePage(){
        require_once WOO_FAQ_PATH.'/pages/product-archive.php';
    }

    /**
     * Register custom settings for plugin
     * @return void
     * @since 1.0.0
     * @author Fazle Bari <fazlebarisn@gmail.com>
     */
    public function wooFaqSettings(){
        // register sections
        register_setting('woofaq-settings-group', 'product_faq');
        register_setting('woofaq-settings-group', 'product_faq_position');
        register_setting('woofaq-settings-group', 'faq_heading', [$this, 'sanitizeFaqHeading']);
        register_setting('woofaq-settings-group', 'faq_heading_color');
        register_setting('woofaq-settings-group', 'faq_question_color');
        register_setting('woofaq-settings-group', 'faq_ans_color');
        register_setting('woofaq-settings-group', 'faq_heading_font_size', [$this, 'sanitizeFaqFontSize']);
        register_setting('woofaq-settings-group', 'faq_question_font_size', [$this, 'sanitizeFaqFontSize']);
        register_setting('woofaq-settings-group', 'faq_ans_font_size', [$this, 'sanitizeFaqFontSize']);

        //add section
        add_settings_section('woofaq-product-faq-options', __('Product Faq Options', 'product-faq-for-woocommerce'),[$this, 'productFaqOptions'],'woo_sfaq');

        //add color section
        add_settings_section('woofaq-product-faq-style', __('Product Faq Style', 'product-faq-for-woocommerce'),[$this, 'productFaqStyle'],'woo_sfaq');

        //add settings fields
        add_settings_field('woofaq-product-faq', __('Product Faq', 'product-faq-for-woocommerce'), [$this, 'ProductFaq'], 'woo_sfaq', 'woofaq-product-faq-options');
        add_settings_field('woofaq-faq-position', __('Faq Position', 'product-faq-for-woocommerce'), [$this, 'faqPosition'], 'woo_sfaq', 'woofaq-product-faq-options');
        add_settings_field('woofaq-heading', __('Faq Heading', 'product-faq-for-woocommerce'), [$this, 'Heading'], 'woo_sfaq', 'woofaq-product-faq-options');

        add_settings_field('woofaq-heading-color', __('Heading Font Color', 'product-faq-for-woocommerce'), [$this, 'HeadingColor'], 'woo_sfaq', 'woofaq-product-faq-style');
        add_settings_field('woofaq-question-color', __('Question Font Color', 'product-faq-for-woocommerce'), [$this, 'QuestionColor'], 'woo_sfaq', 'woofaq-product-faq-style');
        add_settings_field('woofaq-ans-color', __('Answer Font Color', 'product-faq-for-woocommerce'), [$this, 'AnswerColor'], 'woo_sfaq', 'woofaq-product-faq-style');
        add_settings_field('woofaq-heading-font-size', __('Heading Font Size', 'product-faq-for-woocommerce'), [$this, 'HeadingFontSize'], 'woo_sfaq', 'woofaq-product-faq-style');
        add_settings_field('woofaq-question-font-size', __('Question Font Size', 'product-faq-for-woocommerce'), [$this, 'QuestionFontSize'], 'woo_sfaq', 'woofaq-product-faq-style');
        add_settings_field('woofaq-ans-font-size', __('Answer Font Size', 'product-faq-for-woocommerce'), [$this, 'AnswerFontSize'], 'woo_sfaq', 'woofaq-product-faq-style');
    }

    /**
     * callback function for settings section
     * echo html
     * @return void
     * @since 1.0.0
     * @author Fazle Bari <fazlebarisn@gmail.com>
     */
    public function productFaqOptions(){
        echo esc_html__('From here you can change all setiings' , 'product-faq-for-woocommerce');
    }

    /**
     * callback function for style settings section
     * echo html
     * @return void
     * @author Fazle Bari <fazlebarisn@gmail.com> 
     */
    public function productFaqStyle(){
        echo esc_html__('From this section you can change all style for your FAQ html.' , 'product-faq-for-woocommerce');
    }

    /**
     * Sanitize heading data data before input
     * 
     * @return void
     * @since 1.0.0
     * @author Fazle Bari <fazlebarisn@gmail.com> 
     */
    public function sanitizeFaqHeading($input){
        $output = sanitize_text_field($input);
        return $output;
    }
    /**
     * Sanitize font size data data before input
     * 
     * @return void
     * @since 1.0.0
     * @author Fazle Bari <fazlebarisn@gmail.com> 
     */
    public function sanitizeFaqFontSize($input){
        $output = sanitize_text_field($input);
        return $output;
    }

    /**
     * Get option data from database
     * 
     * @return void
     * @since 1.0.0
     * @author Fazle Bari <fazlebarisn@gmail.com> 
     */
    public function faq_option_data( $key ){
        $value = get_option($key);
        return $value;
    }

    /**
     * dusplay enable/disable input field
     * 
     * @return void
     * @since 1.0.0
     * @author Fazle Bari <fazlebarisn@gmail.com> 
     */
    public function ProductFaq(){

        $product_faq = $this->faq_option_data('product_faq');

        $product_faq = isset($product_faq ) ? $product_faq : 'enable';
        ?>
            <select name="product_faq" id="product_faq">
                <option value="disable" <?php echo esc_attr($product_faq ) && $product_faq == 'disable' ? 'selected' : ''; ?> >Disable</option>
                <option value="enable" <?php echo esc_attr($product_faq ) && $product_faq == 'enable' ? 'selected' : ''; ?> >Enable</option>
            </select>
        <?php
    }

    /**
     * dusplay faq position field
     * 
     * @return void
     * @since 1.0.0
     * @author Fazle Bari <fazlebarisn@gmail.com> 
     */
    public function faqPosition(){
        $product_faq_position = get_option('product_faq_position');
        $faq_position = isset($product_faq_position ) ? $product_faq_position : 'after_single_product';
        ?>
            <select name="product_faq_position" id="product_faq_position">
                <option value="after_cart_button" <?php echo esc_attr( $faq_position ) && $faq_position == 'after_cart_button' ? 'selected' : ''; ?> >After Cart Button</option>
                <option value="after_meta" <?php echo esc_attr( $faq_position ) && $faq_position == 'after_meta' ? 'selected' : ''; ?> >After Meta</option>
                <option value="after_summary" <?php echo esc_attr( $faq_position ) && $faq_position == 'after_summary' ? 'selected' : ''; ?> >After Summary</option>
                <option value="after_single_product" <?php echo esc_attr( $faq_position ) && $faq_position == 'after_single_product' ? 'selected' : ''; ?> >After Single Product</option>
            </select>
        <?php
    }

    /**
     * Display heading input field
     * 
     * @return void
     * @since 1.0.0
     * @author Fazle Bari <fazlebarisn@gmail.com> 
     */
    public function Heading(){
        $faq_heading = get_option('faq_heading');
        ?>
            <input type="text" name="faq_heading" value="<?php echo esc_attr( $faq_heading ); ?>" placeholder="Insert Faq Heading" />
        <?php
    }

    /**
     * Display heading color input field
     * 
     * @return void
     * @since 1.0.0
     * @author Fazle Bari <fazlebarisn@gmail.com> 
     */
    public function HeadingColor(){
        $faq_heading_color = get_option('faq_heading_color');
        ?>
            <input type="color" name="faq_heading_color" value="<?php echo esc_attr( $faq_heading_color ); ?>" />
        <?php
    }

    /**
     * Display question color input field
     * 
     * @return void
     * @since 1.1.4
     * @author Fazle Bari <fazlebarisn@gmail.com> 
     */
    public function QuestionColor(){
        $faq_question_color = get_option('faq_question_color');
        ?>
            <input type="color" name="faq_question_color" value="<?php echo esc_attr( $faq_question_color ); ?>" />
        <?php
    }
    /**
     * Display answer color input field
     * 
     * @return void
     * @since 1.1.4
     * @author Fazle Bari <fazlebarisn@gmail.com> 
     */
    public function AnswerColor(){
        $faq_ans_color = get_option('faq_ans_color');
        ?>
            <input type="color" name="faq_ans_color" value="<?php echo esc_attr( $faq_ans_color ); ?>" />
        <?php
    }

    /**
     * Display heading font size input field
     * 
     * @return void
     * @since 1.0.0
     * @author Fazle Bari <fazlebarisn@gmail.com> 
     */
    public function HeadingFontSize(){
        $faq_heading_font_size = get_option('faq_heading_font_size');
        ?>
            <input type="text" name="faq_heading_font_size" value="<?php echo esc_attr( $faq_heading_font_size ); ?>" placeholder="Example: 45px" />
        <?php
    }

    /**
     * Display question font size input field
     * 
     * @return void
     * @since 1.1.4
     * @author Fazle Bari <fazlebarisn@gmail.com> 
     */
    public function QuestionFontSize(){
        $faq_question_font_size = get_option('faq_question_font_size');
        ?>
            <input type="text" name="faq_question_font_size" value="<?php echo esc_attr( $faq_question_font_size ); ?>" placeholder="Example: 45px" />
        <?php
    }

    /**
     * Display answer font size input field
     * 
     * @return void
     * @since 1.1.4
     * @author Fazle Bari <fazlebarisn@gmail.com> 
     */
    public function AnswerFontSize(){
        $faq_ans_font_size = get_option('faq_ans_font_size');
        ?>
            <input type="text" name="faq_ans_font_size" value="<?php echo esc_attr( $faq_ans_font_size ); ?>" placeholder="Example: 45px" />
        <?php
    }
}

