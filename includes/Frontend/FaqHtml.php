<?php

namespace Woo\Faq\Frontend;

class FaqHtml{

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

        if ( !is_product() ) {
            return;
        }
        $product_id = get_the_ID();
        $faq_1 = get_post_meta($product_id,'faq_1', true);
        $_faq_ans_1 = get_post_meta($product_id,'faq_ans_1', true);

        ?>
            <div class="container">
                <h2>Frequently Asked Questions</h2>
                <div class="accordion">
                    <div class="accordion-item">
                        <button id="accordion-button-1" aria-expanded="false"><span class="accordion-title"><?php echo $faq_1 ?? $faq_1; ?></span><span class="icon" aria-hidden="true"></span></button>
                        <div class="accordion-content">
                            <p><?php echo $_faq_ans_1 ?? $_faq_ans_1; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }

}