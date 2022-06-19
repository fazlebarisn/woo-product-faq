<?php

namespace Woo\Faq\Frontend;

class Enqueue{

    function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue'] );
    }

	function enqueue(){
		wp_enqueue_style('faqstyle', WOO_FAQ_URL . '/assets/css/woo-faq.css', [], '1.1', 'all');
		wp_enqueue_script('faqscript', WOO_FAQ_URL . '/assets/js/woo-faq.js' , [ 'jquery' ], time(), true );
    }
    
}