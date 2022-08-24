<?php

namespace Woo\Faq;

class Admin{

    function __construct()
    {
        new Admin\Menu();
        new Admin\Enqueue();
        new Admin\AdminNotice();
        new Admin\ProductDataTab();
    }
    
}
