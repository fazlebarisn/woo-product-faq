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

        $faqs = get_post_meta($product_id,'faq',true);

        if( !isset($faqs['question']) ){
            return;
        }
         
        if( in_array(!null, $faqs['question']) ) :

        // Style
        $faq_heading = esc_attr( get_option('faq_heading') );
        $faq_heading_color = esc_attr( get_option('faq_heading_color') );
        $faq_heading_font_size = esc_attr( get_option('faq_heading_font_size') );
        $faq_heading_style = 'color:'.$faq_heading_color.';' . 'font-size:'.$faq_heading_font_size;
        //if( !empty($faqs) ): 
        ?>
            <div class="container">
                <h2 style="<?php echo esc_attr($faq_heading_style); ?>">
                    <?php 
                        if(!empty($faq_heading)){
                            echo esc_html($faq_heading);
                        }else{
                            echo esc_html__('Frequently Asked Questions' , 'product-faq-for-woocommerce');
                        }
                    ?>
                </h2>
                <?php if( !empty($faqs) ): 
                    foreach($faqs['question'] as $key=>$faq ){
                    //echo $faq;
                        ?>
                        <div class="accordion">
                            <div class="accordion-item">
                                <button id="accordion-button-1" aria-expanded="false"><span class="accordion-title"><?php echo esc_html( $faqs['question'][$key] ?? '' ); ?></span><span class="icon" aria-hidden="true"></span></button>
                                <div class="accordion-content">
                                    <p><?php echo esc_html( $faqs['answer'][$key] ?? '' ) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php } endif; ?>
            </div>
        <?php
        endif;
    }

}