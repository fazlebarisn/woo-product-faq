<?php

namespace Woo\Faq;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Admin{

    function __construct()
    {
        new Admin\Menu();
        new Admin\Enqueue();
        new Admin\AdminNotice();
        new Admin\ProductDataTab();
        new Admin\AiEngine();
    }
    
}
