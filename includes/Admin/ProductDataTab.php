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

        // Ensure we have a proper array structure
        if (!is_array($value) || !isset($value['question']) || !isset($value['answer'])) {
            $value = array(
                'question' => array(''),
                'answer' => array(''),
            );
        }

        // Ensure both arrays have the same length and are not empty
        $max_count = max(count($value['question']), count($value['answer']), 1);
        for ($i = 0; $i < $max_count; $i++) {
            if (!isset($value['question'][$i])) {
                $value['question'][$i] = '';
            }
            if (!isset($value['answer'][$i])) {
                $value['answer'][$i] = '';
            }
        }

        $args = array();

        foreach ($value['question'] as $key => $val) {
            echo '<div class="options_group faq-group" data-index="' . esc_attr($key) . '">';
            
            // Add remove button for each FAQ item (except the first one)
            if ($key > 0) {
                echo '<button type="button" class="faq-remove-question" style="float:right; margin-top:5px; background:#fff; color:#b32d2e; border:1px solid #b32d2e; border-radius:50%; width:24px; height:24px; padding:0; cursor:pointer;">
                    <span class="dashicons dashicons-no-alt" style="font-size:12px; line-height:22px;"></span>
                </button>';
            }
            
            woocommerce_wp_text_input([
                'id'        => 'faq_' . $key,
                'name'      => 'faq[question][' . $key . ']',
                'label'     =>  'Question ' . ($key + 1),
                'class'     =>  'faq_input faq-question-box',
                'type'      =>  'text',
                'desc_tip'  =>  true,
                'data_type' => 'text',
                'value'     =>  $value['question'][$key] ?? '',
                'placeholder' => 'Enter your question here...',
                'style'     => 'width: 98%;',
            ]);
            
            woocommerce_wp_textarea_input([
                'id'        => 'faq_ans_' . $key,
                'name'      => 'faq[answer][' . $key . ']',
                'label'     => 'Answer ' . ($key + 1),
                'class'     => 'faq_input faq-answer-box',
                'desc_tip'  => true,
                'value'     =>  $value['answer'][$key] ?? '',
                'placeholder' => 'Enter your answer here...',
                'rows'      => 3,
                'style'     => 'width: 100%;',
            ]);
            
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
        // Check if this is an autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Check user permissions
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // Check if our FAQ data is being submitted
        if (!isset($_POST['faq']) || !is_array($_POST['faq'])) {
            return;
        }

        $_data = wp_unslash($_POST['faq']);
        $sanitize_data = [];

        foreach ($_data as $key => $data) {
            if (!is_array($data) || !in_array($key, ['question', 'answer'])) {
                continue;
            }

            $sanitize_data[$key] = array();
            foreach ($data as $index => $item) {
                if (!empty($item)) {
                    $sanitize_data[$key][$index] = sanitize_text_field($item);
                }
            }
        }

        // Only update if we have valid data
        if (!empty($sanitize_data['question']) || !empty($sanitize_data['answer'])) {
            $result = update_post_meta($post_id, 'faq', $sanitize_data);
        } else {
            // If no valid data, delete the meta
            delete_post_meta($post_id, 'faq');
        }
    }
}
