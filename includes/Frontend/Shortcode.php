<?php

namespace Woo\Faq\Frontend;

class Shortcode{

    function __construct()
    {
        add_shortcode( 'fbs-ac' , [ $this , 'renderShortcode'] );
    }

    /**
     * shortcode handeler function
     *
     * @param array $atts
     * @param string $content
     * @return string
     */
    public function renderShortcode( $atts , $content='' ){
        return 'hello from shortcode';
    }

}