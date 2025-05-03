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
        $global_groups = get_option('woo_afaq_global_groups', []);

        // Clean checks
        $has_product_faqs = !empty($faqs['question']);
        $has_global_faqs = !empty($global_groups);

        // If both are empty, exit early
        if (!$has_product_faqs && !$has_global_faqs) {
            return;
        }
         
        // if( in_array(!null, $faqs['question']) ) :

        // Style
        $faq_heading = esc_attr( get_option('faq_heading') );
        $faq_heading_color = esc_attr( get_option('faq_heading_color') );
        $faq_question_color = esc_attr( get_option('faq_question_color') );
        $faq_ans_color = esc_attr( get_option('faq_ans_color') );
        $faq_heading_font_size = esc_attr( get_option('faq_heading_font_size') );
        $faq_question_font_size = esc_attr( get_option('faq_question_font_size') );
        $faq_ans_font_size = esc_attr( get_option('faq_ans_font_size') );
        $faq_heading_style = 'color:'.$faq_heading_color.';' . 'font-size:'.$faq_heading_font_size;
        $faq_question_style = 'color:'.$faq_question_color.';' . 'font-size:'.$faq_question_font_size;
        $faq_ans_style = 'color:'.$faq_ans_color.';' . 'font-size:'.$faq_ans_font_size;
        //if( !empty($faqs) ): 
        ?>
            <div class="container">
                <?php
                if (!empty($faqs) && !empty($faqs['question'])) {
                    ?>
                    <h2 style="<?php echo esc_attr($faq_heading_style); ?>">
                        <?php 
                            if(!empty($faq_heading)){
                                echo esc_html($faq_heading);
                            }else{
                                echo esc_html__('Frequently Asked Questions' , 'product-faq-for-woocommerce');
                            }
                        ?>
                    </h2>
                    <?php
                    // Product-specific FAQs
                    foreach ($faqs['question'] as $key => $faq_question) {
                        $faq_answer = $faqs['answer'][$key] ?? '';
                        ?>
                        <div class="accordion">
                            <div class="accordion-item">
                                <button aria-expanded="false">
                                    <span class="accordion-title" style="<?php echo esc_attr($faq_question_style); ?>">
                                        <?php echo esc_html($faq_question); ?>
                                    </span>
                                    <span class="icon" aria-hidden="true"></span>
                                </button>
                                <div class="accordion-content">
                                    <p style="<?php echo esc_attr($faq_ans_style); ?>">
                                        <?php echo esc_html($faq_answer); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    // No product-specific FAQs, fallback to global groups
                    $global_groups = get_option('woo_afaq_global_groups', []);

                    $product_term_ids = [];

                    $taxonomies = get_object_taxonomies('product'); // or get_post_type($product_id)

                    foreach ($taxonomies as $taxonomy) {
                        $terms = wp_get_post_terms($product_id, $taxonomy, ['fields' => 'ids']);
                        if (!is_wp_error($terms)) {
                            $product_term_ids = array_merge($product_term_ids, $terms);
                        }
                    }
                    $product_term_ids = array_unique($product_term_ids);
                    if (!empty($global_groups) && !empty($product_term_ids)) {
 
                        foreach ($global_groups as $group) {
                            $archive_terms = $group['archive_terms'] ?? [];
                
                            // Check if product has matching terms in this taxonomy
                            $intersect = array_intersect($product_term_ids, $archive_terms);
                            if (!empty($intersect)) {
                                ?>
                                <h2 style="<?php echo esc_attr($faq_heading_style); ?>">
                                    <?php 
                                        if(!empty($faq_heading)){
                                            echo esc_html($faq_heading);
                                        }else{
                                            echo esc_html__('Frequently Asked Questions' , 'product-faq-for-woocommerce');
                                        }
                                    ?>
                                </h2>
                                <?php
                                // Match found, render these FAQs
                                $faqs = $group['faqs'] ?? [];
                                foreach ($faqs as $faq) {
                                    ?>                                  
                                    <div class="accordion">
                                        <div class="accordion-item">
                                            <button aria-expanded="false">
                                                <span class="accordion-title" style="<?php echo esc_attr($faq_question_style); ?>">
                                                    <?php echo esc_html($faq['question'] ?? ''); ?>
                                                </span>
                                                <span class="icon" aria-hidden="true"></span>
                                            </button>
                                            <div class="accordion-content">
                                                <p style="<?php echo esc_attr($faq_ans_style); ?>">
                                                    <?php echo esc_html($faq['answer'] ?? ''); ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        }
                    }
                }
                ?>
            </div>
        <?php
        // endif;
    }

}