<?php

namespace Woo\Faq;

class Admin{

    function __construct()
    {
        new Admin\Menu();
        new Admin\AdminNotice();
        new Admin\ProductDataTab();
    }
    
}
