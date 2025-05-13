<?php

namespace Woo\Faq\Admin;

class Enqueue{

    function __construct()
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueue'] );
    }

	function enqueue(){
        wp_enqueue_script('jquery-ui-autocomplete');
        wp_enqueue_style('jquery-ui-style', '//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css');

		wp_enqueue_style('faq-admin-style', WOO_FAQ_URL . '/assets/css/woo-admin-faq.css', [], '1.1.6', 'all');
		wp_enqueue_script('faq-admin-script', WOO_FAQ_URL . '/assets/js/woo-admin-faq.js' , [ 'jquery','jquery-ui-autocomplete' ], '1.1.6', true );

        wp_localize_script('faq-admin-script', 'faqAjax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('faq_nonce')
        ]);
    }
    
}