<?php

namespace Woo\Faq;

class Frontend{

    function __construct()
    {
        new Frontend\Shortcode();
        new Frontend\Enqueue();
    }

}