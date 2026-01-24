<?php

namespace Woo\Faq\Admin;

class Enqueue{

    function __construct()
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueue'] );
    }

	function enqueue(){
        wp_enqueue_script('jquery-ui-autocomplete');

		wp_enqueue_style('faq-admin-style', WOO_FAQ_URL . '/assets/css/woo-admin-faq.css', [], '1.1.6', 'all');
		wp_enqueue_script('faq-admin-script', WOO_FAQ_URL . '/assets/js/woo-admin-faq.js' , [ 'jquery','jquery-ui-autocomplete' ], '1.1.6', true );

        wp_localize_script('faq-admin-script', 'faqAjax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('faq_nonce')
        ]);
        
        // Check if pro plugin is active AND license is valid
        $is_pro_plugin_active = in_array( 'woo-product-faq-pro/product-faq-pro.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
        
        // Check if license is active (only if pro plugin is active)
        $is_license_active = false;
        if ( $is_pro_plugin_active && function_exists( 'faq_pro_is_license_active' ) ) {
            $is_license_active = faq_pro_is_license_active();
        }
        
        // Only enable pro features if both plugin is active AND license is valid
        $is_pro = $is_pro_plugin_active && $is_license_active;
        
        wp_localize_script('faq-admin-script', 'wooFaqPro', [
            'is_pro' => $is_pro,
        ]);
    }
    
}