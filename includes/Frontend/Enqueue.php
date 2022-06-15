<?php

namespace Woo\Faq\Frontend;

class Enqueue{

    function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'enqueue'));
    }

	function enqueue(){
		wp_enqueue_style('faqstyle', plugin_dir_url( __FILE__ ) . 'assets/css/woo-faq.css', [], '1.1', 'all');
		wp_enqueue_script('faqscript', plugin_dir_url( __FILE__ ) . 'assets/js/woo-faq.js' , [ 'jquery' ], time(), true );
    }
    
}