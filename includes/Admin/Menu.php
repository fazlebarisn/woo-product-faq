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

        add_action('admin_enqueue_scripts', [$this, 'enqueueAssets']);
    }

    /**
     * Enqueue assets for the settings page
     * @since 1.1.9
     */
    public function enqueueAssets($hook = '') {
        $current_page = sanitize_text_field($_GET['page'] ?? '');
        if (!in_array($current_page, ['woo_sfaq', 'woo_afaq', 'woo_pfaq', 'woo_author_faq'])) {
            return;
        }

        wp_enqueue_style('woo-faq-admin-settings', WOO_FAQ_URL . '/assets/css/admin-settings.css', [], WOO_FAQ_VERSION);
        wp_enqueue_script('woo-faq-admin-settings', WOO_FAQ_URL . '/assets/js/admin-settings.js', ['jquery'], WOO_FAQ_VERSION, true);
        wp_localize_script('woo-faq-admin-settings', 'faqAjax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('faq_nonce')
        ]);
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
    }

    /**
     * add settings link 
     *
     * @return void
     */
    public function settingsLink( $links ){
        $settings_link = '<a href="admin.php?page=woo_sfaq">Settings</a>';
        
        // Only show upgrade link if pro plugin is not active
        if ( ! in_array( 'woo-product-faq-pro/product-faq-pro.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
            $pro_link = '<a href="https://wpbay.com/product/product-faq-for-woocommerce-pro/" target="_blank" style="color: #667eea; font-weight: 600;">🚀 Upgrade to Pro</a>';
            array_push($links, $settings_link, $pro_link);
        } else {
            array_push($links, $settings_link);
        }
        
        return $links;
    }
    /**
     * Add menu in wordpress dashboard menu
     *
     * @return void
     */
    public function adminMenu(){
        add_menu_page( __('Product Faq' , 'product-faq-for-woocommerce' ) , __('Product FAQ' , 'product-faq-for-woocommerce') , 'manage_options' , 'woo_sfaq' , [$this , 'adminPage'] , 'dashicons-info' );
        add_submenu_page( 'woo_sfaq' , __('Product Archive' , 'product-faq-for-woocommerce') , __('Bulk FAQ' , 'product-faq-for-woocommerce') , 'manage_options' , 'woo_afaq' , [$this , 'productAtchivePage'] );
        add_submenu_page( 'woo_sfaq' , __('Browse Our Plugins' , 'product-faq-for-woocommerce') , __('Our Plugins' , 'product-faq-for-woocommerce') , 'manage_options' , 'woo_pfaq' , [$this , 'ourPluginsPage'] );
        add_submenu_page( 'woo_sfaq' , __('About The Author' , 'product-faq-for-woocommerce') , __('About The Author' , 'product-faq-for-woocommerce') , 'manage_options' , 'woo_author_faq' , [$this , 'pluginAuthorPage'] );
    }

    /**
     * admin page function
     * include template here
     * @since 1.0.0
     * @return void
     * @author Fazle Bari <fazlebarisn@gmail.com>
     */
    public function adminPage(){
        $menu_instance = $this;
        require_once WOO_FAQ_PATH.'/pages/dashboard.php';
    }
    public function productAtchivePage(){
        require_once WOO_FAQ_PATH.'/pages/product-archive.php';
    }
    public function ourPluginsPage(){
        require_once WOO_FAQ_PATH.'/pages/our-plugins.php';
    }
    public function pluginAuthorPage(){
        require_once WOO_FAQ_PATH.'/pages/plugin-author.php';
    }

    /**
     * Register custom settings for plugin
     * @return void
     * @since 1.0.0
     * @author Fazle Bari <fazlebarisn@gmail.com>
     */
    public function wooFaqSettings(){
        // register sections
        register_setting('woofaq-settings-group', 'product_faq', [$this, 'sanitizeTextField']);
        register_setting('woofaq-settings-group', 'product_faq_position', [$this, 'sanitizeTextField']);
        register_setting('woofaq-settings-group', 'faq_heading', [$this, 'sanitizeTextField']);
        register_setting('woofaq-settings-group', 'faq_heading_color', [$this, 'sanitizeTextField']);
        register_setting('woofaq-settings-group', 'faq_question_color', [$this, 'sanitizeTextField']);
        register_setting('woofaq-settings-group', 'faq_ans_color', [$this, 'sanitizeTextField']);
        register_setting('woofaq-settings-group', 'faq_heading_font_size', [$this, 'sanitizeTextField']);
        register_setting('woofaq-settings-group', 'faq_question_font_size', [$this, 'sanitizeTextField']);
        register_setting('woofaq-settings-group', 'faq_ans_font_size', [$this, 'sanitizeTextField']);
        register_setting('woofaq-settings-group', 'woo_faq_enable_schema', [$this, 'sanitizeTextField']);
        register_setting('woofaq-settings-group', 'woo_faq_ai_provider', [$this, 'sanitizeTextField']);
        register_setting('woofaq-settings-group', 'woo_faq_ai_model', [$this, 'sanitizeTextField']);
        register_setting('woofaq-settings-group', 'woo_faq_ai_api_key', [$this, 'sanitizeTextField']);
        register_setting('woofaq-settings-group', 'woo_faq_ai_tone', [$this, 'sanitizeTextField']);
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
    public function sanitizeTextField($input){
        $output = sanitize_text_field(wp_unslash($input));
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
                <option value="product_tab" <?php echo esc_attr( $faq_position ) && $faq_position == 'product_tab' ? 'selected' : ''; ?> >Product Tab</option>
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
            <input type="text" class="color-field" name="faq_heading_color" value="<?php echo esc_attr( $faq_heading_color ); ?>" />
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
            <input type="text" class="color-field" name="faq_question_color" value="<?php echo esc_attr( $faq_question_color ); ?>" />
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
            <input type="text" class="color-field" name="faq_ans_color" value="<?php echo esc_attr( $faq_ans_color ); ?>" />
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

    /**
     * Display Google Schema JSON-LD toggle
     */
    public function EnableSchema(){
        $enable_schema = get_option('woo_faq_enable_schema', 'enable');
        ?>
            <select name="woo_faq_enable_schema">
                <option value="enable" <?php selected($enable_schema, 'enable'); ?>><?php esc_html_e('Enable (Recommended for Google SEO)', 'product-faq-for-woocommerce'); ?></option>
                <option value="disable" <?php selected($enable_schema, 'disable'); ?>><?php esc_html_e('Disable', 'product-faq-for-woocommerce'); ?></option>
            </select>
            <p class="description"><?php esc_html_e('Automatically generates Schema.org FAQPage structured data (JSON-LD) for rich results in Google Search.', 'product-faq-for-woocommerce'); ?></p>
        <?php
    }

    /**
     * Display AI Provider selection
     */
    public function AiProvider(){
        $provider = get_option('woo_faq_ai_provider', 'gemini');
        ?>
            <select name="woo_faq_ai_provider" id="woo_faq_ai_provider">
                <option value="gemini" <?php selected($provider, 'gemini'); ?>>Google Gemini (Fast & Free Tier)</option>
                <option value="openai" <?php selected($provider, 'openai'); ?>>OpenAI (ChatGPT / GPT-4o-mini)</option>
            </select>
        <?php
    }

    /**
     * Display AI Model selection
     */
    public function AiModel(){
        $provider = get_option('woo_faq_ai_provider', 'gemini');
        $model = get_option('woo_faq_ai_model', 'gemini-3.6-flash');
        ?>
            <select name="woo_faq_ai_model" id="woo_faq_ai_model">
                <optgroup label="Google Gemini Models" id="optgroup-gemini">
                    <option value="gemini-3.6-flash" <?php selected($model, 'gemini-3.6-flash'); ?>>Gemini 3.6 Flash (Recommended - High Speed & High Reliability)</option>
                    <option value="gemini-flash-latest" <?php selected($model, 'gemini-flash-latest'); ?>>Gemini Flash Latest (Auto-Updated)</option>
                    <option value="gemini-3.5-flash" <?php selected($model, 'gemini-3.5-flash'); ?>>Gemini 3.5 Flash</option>
                    <option value="gemini-3.7-flash" <?php selected($model, 'gemini-3.7-flash'); ?>>Gemini 3.7 Flash</option>
                </optgroup>
                <optgroup label="OpenAI Models" id="optgroup-openai">
                    <option value="gpt-4o-mini" <?php selected($model, 'gpt-4o-mini'); ?>>GPT-4o mini (Recommended - Fast & Cost-Effective)</option>
                    <option value="gpt-4o" <?php selected($model, 'gpt-4o'); ?>>GPT-4o (High Intelligence)</option>
                    <option value="gpt-3.5-turbo" <?php selected($model, 'gpt-3.5-turbo'); ?>>GPT-3.5 Turbo (Legacy)</option>
                </optgroup>
            </select>
            <p class="description"><?php esc_html_e('Select which AI model is used for generating WooCommerce product FAQs.', 'product-faq-for-woocommerce'); ?></p>
        <?php
    }

    /**
     * Display AI API Key input
     */
    public function AiApiKey(){
        $key = get_option('woo_faq_ai_api_key', '');
        ?>
            <div style="display: flex; gap: 10px; align-items: center; max-width: 500px;">
                <input type="password" name="woo_faq_ai_api_key" id="woo_faq_ai_api_key" value="<?php echo esc_attr($key); ?>" placeholder="<?php esc_attr_e('Paste your Google Gemini or OpenAI API Key here', 'product-faq-for-woocommerce'); ?>" style="flex: 1;" />
                <button type="button" class="button button-secondary" id="woo-faq-test-ai-key"><?php esc_html_e('Test Connection', 'product-faq-for-woocommerce'); ?></button>
            </div>
            <p class="description" style="margin-top: 6px;">
                <span id="woo-faq-ai-test-result" style="font-weight: 600;"></span>
                <span id="woo-faq-key-hint">
                    Get a free Gemini API key from <a href="https://aistudio.google.com/app/apikey" target="_blank">Google AI Studio</a> or OpenAI key from <a href="https://platform.openai.com/api-keys" target="_blank">OpenAI Platform</a>.
                </span>
            </p>
        <?php
    }

    /**
     * Display AI Tone selection
     */
    public function AiTone(){
        $tone = get_option('woo_faq_ai_tone', 'sales');
        ?>
            <select name="woo_faq_ai_tone">
                <option value="sales" <?php selected($tone, 'sales'); ?>>Persuasive & Sales-Focused (Objection Buster)</option>
                <option value="friendly" <?php selected($tone, 'friendly'); ?>>Warm, Helpful & Friendly</option>
                <option value="concise" <?php selected($tone, 'concise'); ?>>Concise & Direct (Brief Answers)</option>
                <option value="technical" <?php selected($tone, 'technical'); ?>>Technical, Detailed & Professional</option>
            </select>
        <?php
    }
}

