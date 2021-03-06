<?php

namespace Woo\Faq\Frontend;

class FaqHtml{

    function __construct()
    {
        
        $product_faq = esc_attr( get_option('product_faq') );
        $product_faq_position = esc_attr( get_option('product_faq_position') );

        if('disable'== $product_faq) return;
        
        if( 'after_cart_button' == $product_faq_position ){
            add_action( 'woocommerce_after_add_to_cart_form', [ $this, 'rendeFaqHtml'] );
        }elseif( 'after_meta' == $product_faq_position ){
            add_action( 'woocommerce_product_meta_end', [ $this, 'rendeFaqHtml'] );
        }elseif( 'after_summary' == $product_faq_position ){
            add_action( 'woocommerce_after_single_product_summary', [ $this, 'rendeFaqHtml'] );
        }elseif( 'after_single_product' == $product_faq_position ){
            add_action( 'woocommerce_after_single_product', [ $this, 'rendeFaqHtml'] );
        }
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

        $faq_2 = get_post_meta($product_id,'faq_2', true);
        $_faq_ans_2 = get_post_meta($product_id,'faq_ans_2', true);

        $faq_3 = get_post_meta($product_id,'faq_3', true);
        $_faq_ans_3 = get_post_meta($product_id,'faq_ans_3', true);

        $faq_heading = esc_attr( get_option('faq_heading') );
        
        // Style
        $faq_heading_color = esc_attr( get_option('faq_heading_color') );
        $faq_heading_font_size = esc_attr( get_option('faq_heading_font_size') );
        $faq_heading_style = 'color:'.$faq_heading_color.';' . 'font-size:'.$faq_heading_font_size;

        ?>
        <?php if( !empty($faq_1) || !empty($faq_2) || !empty($faq_3) ): ?>
            <div class="container">
                <h2 style="<?php echo $faq_heading_style; ?>">
                    <?php 
                        if(!empty($faq_heading)){
                            echo $faq_heading;
                        }else{
                            echo 'Frequently Asked Questions';
                        }
                    ?>
                </h2>
                <?php if( !empty($faq_1)): ?>
                <div class="accordion">
                    <div class="accordion-item">
                        <button id="accordion-button-1" aria-expanded="false"><span class="accordion-title"><?php echo $faq_1 ?? $faq_1; ?></span><span class="icon" aria-hidden="true"></span></button>
                        <div class="accordion-content">
                            <p><?php echo $_faq_ans_1 ?? $_faq_ans_1; ?></p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php if( !empty($faq_2)): ?>
                <div class="accordion">
                    <div class="accordion-item">
                        <button id="accordion-button-1" aria-expanded="false"><span class="accordion-title"><?php echo $faq_2 ?? $faq_2; ?></span><span class="icon" aria-hidden="true"></span></button>
                        <div class="accordion-content">
                            <p><?php echo $_faq_ans_2 ?? $_faq_ans_2; ?></p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php if( !empty($faq_3)): ?>
                <div class="accordion">
                    <div class="accordion-item">
                        <button id="accordion-button-1" aria-expanded="false"><span class="accordion-title"><?php echo $faq_3 ?? $faq_3; ?></span><span class="icon" aria-hidden="true"></span></button>
                        <div class="accordion-content">
                            <p><?php echo $_faq_ans_3 ?? $_faq_ans_3; ?></p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php
    }

}