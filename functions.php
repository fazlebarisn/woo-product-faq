<?php
/**
 * Only for developer
 * @author Fazle Bari <fazlebarisn@gmail.com>
 */
if (!function_exists('dd')) {
    function dd(...$vals)
    {
        if (!empty($vals) && is_array($vals)) {
            ob_start(); // Start output buffering
            foreach ($vals as $val) {
                echo "<pre>";
                var_dump($val);
                echo "</pre>";
            }
            $output = ob_get_clean(); // Get the buffered output and clear the buffer
            echo esc_html($output); // Output the buffered content
        }
    }
}

/**
 * Search taxonomy
 * @author Fazle Bari <fazlebarisn@gmail.com>
 */
add_action('wp_ajax_faq_term_search', function () {
    check_ajax_referer('faq_nonce', 'nonce');

    $term     = isset($_GET['term']) ? sanitize_text_field(wp_unslash($_GET['term'])) : '';
    $taxonomy = isset($_GET['taxonomy']) ? sanitize_text_field(wp_unslash($_GET['taxonomy'])) : '';

    if (!in_array($taxonomy, ['product_cat', 'product_tag'])) {
        wp_send_json([]);
    }

    $results = get_terms([
        'taxonomy'   => $taxonomy,
        'hide_empty' => false,
        'name__like' => $term,
        'number'     => 10,
    ]);

    $formatted = array_map(function ($term) {
        return [
            'label' => $term->name,
            'value' => $term->term_id
        ];
    }, $results);

    wp_send_json($formatted);
});

/**
 * Handle dismissing pro promotion notice
 * @author Fazle Bari <fazlebarisn@gmail.com>
 */
add_action('wp_ajax_woo_faq_dismiss_pro_notice', function () {
    check_ajax_referer('woo_faq_dismiss_pro_notice', 'nonce');
    
    $user_id = get_current_user_id();
    if ($user_id) {
        update_user_meta($user_id, 'woo_faq_pro_notice_dismissed', true);
    }
    
    wp_send_json_success();
});