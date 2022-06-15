<?php

namespace Woo\Faq\Frontend;

class Shortcode{

    function __construct()
    {
        add_action( 'woocommerce_after_single_product', [ $this, 'rendeFaqHtml'] );
    }

    /**
     * shortcode handeler function
     *
     * @param array $atts
     * @param string $content
     * @return string
     */
    public function rendeFaqHtml(){
        ?>
            <div class="container">
                <h2>Frequently Asked Questions</h2>
                <div class="accordion">
                    <div class="accordion-item">
                        <button id="accordion-button-1" aria-expanded="false"><span class="accordion-title">How Are You?</span><span class="icon" aria-hidden="true"></span></button>
                        <div class="accordion-content">
                            <p>I am fine</p>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }

}