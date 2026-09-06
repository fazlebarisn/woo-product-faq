<?php

namespace Woo\Faq;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Frontend{

    function __construct()
    {
        new Frontend\FaqHtml();
        new Frontend\Enqueue();
    }

}