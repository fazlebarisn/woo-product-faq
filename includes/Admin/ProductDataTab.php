<?php

namespace Woo\Faq\Admin;

class ProductDataTab
{

    public function __construct()
    {
        add_filter('woocommerce_product_data_tabs', [$this, 'faq_product_edit_tab']);
        add_filter('woocommerce_product_data_panels', [$this, 'faq_product_tab_options']);
        add_action('faq_woocommerce_product_options', [$this, 'faq_add_field_in_panel']);
        add_action('woocommerce_process_product_meta', [$this, 'faq_save_field_data']);
    }

    /**
     * Add new tab in product page
     * @return array $tabs
     * @since 1.0.0
     * @author Fazle Bari <fazlebarisn@gmail.com>
     */
    public function faq_product_edit_tab($product_data_tab)
    {

        $faq_tab['frequently_asked_questions'] = array(
            'label' => __('FAQ', 'product-faq-for-woocommerce'),
            'target'   => 'frequently_asked_questions', //This is targetted div's id
            'class'     => array('hide_if_downloadable', 'hide_if_grouped'), //'hide_if_grouped',
        );

        $position = 3; // Change this for desire position 
        $tabs = array_slice($product_data_tab, 0, $position, true); // First part of original tabs 
        $tabs = array_merge($tabs, $faq_tab); // Add new 
        $tabs = array_merge($tabs, array_slice($product_data_tab, $position, null, true));

        return $tabs;
    }

    /**
     * Render the question and answer section
     * @since 1.0.0
     * @author Fazle Bari <fazlebarisn@gmail.com>
     */
    public function faq_product_tab_options()
    {
        ?>
        <div id="frequently_asked_questions" class="panel woocommerce_options_panel">
            <div class="option-group-wrapper">
                <?php do_action('faq_woocommerce_product_options'); ?>
                <?php
                $product_faq = get_option('product_faq');
                if (!$product_faq || 'disable' == $product_faq) :
                ?>
                    <p class="faq-note"><span>Importent note: </span>Please Enable 'Product Faq' from the setting page. ( Deshboard -> Product Faq )</p>
                <?php endif; ?>
            </div>
            <button type="button" class="faq-add-question button button-primary">Add New FAQ</button>
        </div>
        <?php
    }

    // add input box for faq
    function faq_add_field_in_panel()
    {
        global $post;
        $value = get_post_meta($post->ID, 'faq', true);

        $value = is_array($value) ? $value : array(
            'question' => array(''),
            'answer' => array(''),
        );

        $args = array();

        foreach ($value['question'] as $key => $val) {
            echo '<div class="options_group">';
            woocommerce_wp_text_input([
                'id'        => 'faq_' . $key,
                'name'      => 'faq[question][' . $key . ']',
                'label'     =>  'Question',
                'class'     =>  'faq_input faq-question-box',
                'type'      =>  'text',
                'desc_tip'  =>  true,
                'data_type' => 'text',
                'value'     =>  $value['question'][$key] ?? '',
            ]);
            woocommerce_wp_text_input([
                'id'        => 'faq_ans_' . $key,
                'name'      => 'faq[answer][' . $key . ']',
                'label'     => 'Answer',
                'class'     => 'faq_input',
                'type'      => 'text',
                'desc_tip'  => true,
                'data_type' => 'text',
                'value'     =>  $value['answer'][$key] ?? '',
            ]);
            // echo '<button type="button" class="faq-remove-question" style="float:right; background:#fff; color:#b32d2e; border-color:#b32d2e; margin-top:5px; padding:0; border-radius: 50%;"><span class="dashicons dashicons-no-alt"></span></button>';
            echo '</div>';
        }

        $args = apply_filters('faq_field_args', $args);
        
        foreach ($args as $arg) {
            woocommerce_wp_text_input($arg);
        }
    }

    // save data
    function faq_save_field_data($post_id)
    {
        $_data = $_POST['faq'] ?? [];

        if (! is_array($_data)) return;
        $sanitize_data = [];
        // dd($_data); die;
        foreach ($_data as $key => $data) {
            $each_data = isset($data)  && is_array($data) ? $data : false;

            if ($each_data && ($key == 'question' || $key == 'answer')) {
                $sanitize_data[$key] = array_filter($each_data, function ($item) {
                    $sanitize_string = sanitize_text_field($item);
                    return is_string($sanitize_string) && ! empty($sanitize_string);
                });
            }
        }

        if (empty($sanitize_data)) return;
        update_post_meta($post_id, 'faq', $sanitize_data);
    }
}
